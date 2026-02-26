<?php
require_once 'dbconfig.php';

class ADMIN
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->dbConnection();
    }

    /* ================================
       Common Helpers
    ================================= */
    public function runQuery($sql)
    {
        return $this->conn->prepare($sql);
    }

    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    /* ================================
       Admin Registration
    ================================= */
    public function register($adName, $adEmail, $adMobile, $password, $tokenCode)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare(
            "INSERT INTO adminlogin
             (adName, adEmail, adMobile, adPassword, tokenCode, userStatus)
             VALUES (:name, :email, :mobile, :pass, :token, 'Y')"
        );

        return $stmt->execute([
            ':name'   => $adName,
            ':email'  => $adEmail,
            ':mobile' => $adMobile,
            ':pass'   => $hash,
            ':token'  => $tokenCode
        ]);
    }

    /* ================================
       Admin Login  ✅ FIXED & WORKING
    ================================= */
    public function adminLogin($email, $password, $authtokenid)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM adminlogin WHERE adEmail = :email LIMIT 1"
            );
            $stmt->execute([':email' => $email]);

            if ($stmt->rowCount() !== 1) {
                return false;
            }

            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // ✅ ACTIVE CHECK
            if (!isset($admin['userStatus']) || $admin['userStatus'] !== 'Y') {
                return false;
            }

            // ✅ PASSWORD CHECK (bcrypt + old sha256 support)
            $sha256 = hash('sha256', $password);

            if (
                !password_verify($password, $admin['adPassword']) &&
                $admin['adPassword'] !== $sha256
            ) {
                return false;
            }

            // ✅ SESSION
            $_SESSION['adminSession'] = $admin['adID'];

            /* ================================
               authsession (UNCHANGED LOGIC)
            ================================= */
            $check = $this->conn->prepare(
                "SELECT studentID FROM authsession WHERE studentID = :id"
            );
            $check->execute([':id' => $admin['adID']]);

            if ($check->rowCount() == 0) {
                $insert = $this->conn->prepare(
                    "INSERT INTO authsession (studentID, authtokenid, loginFlg)
                     VALUES (:id, :token, 'Y')"
                );
                $insert->execute([
                    ':id'    => $admin['adID'],
                    ':token' => $authtokenid
                ]);
            } else {
                $update = $this->conn->prepare(
                    "UPDATE authsession
                     SET authtokenid = :token, loginFlg = 'Y'
                     WHERE studentID = :id"
                );
                $update->execute([
                    ':token' => $authtokenid,
                    ':id'    => $admin['adID']
                ]);
            }

            return true;

        } catch (PDOException $e) {
            // optional: log error
            return false;
        }
    }

    /* ================================
       Login Check
    ================================= */
    public function is_adlogged_in()
    {
        return isset($_SESSION['adminSession']);
    }

    /* ================================
       Logout
    ================================= */
    public function adminLogout()
    {
        session_unset();
        session_destroy();
        return true;
    }
}
