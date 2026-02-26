<?php

require_once 'dbconfig.php';

class USER {

	private $conn;

	public function __construct() {
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
	}

	/* ==============================
	   COMMON HELPERS
	============================== */
	public function runQuery($sql) {
		return $this->conn->prepare($sql);
	}

	public function lasdID() {
		return $this->conn->lastInsertId();
	}

	/* ==============================
	   USER REGISTRATION
	============================== */
	public function register(
		$studentName,
		$rollnumber,
		$studentEmail,
		$studentpEmail,
		$studentMobile,
		$vtype,
		$role,
		$yearofenroll,
		$yearofgraduation,
		$graduationdegree,
		$photograph,
		$regDate,
		$tokenCode,
		$studentPassword
	) {
		try {

			$stmt = $this->conn->prepare("
				INSERT INTO studentregistration
				(
					studentName,
					rollnumber,
					studentEmail,
					studentpEmail,
					studentMobile,
					vtype,
					role,
					yearofenroll,
					yearofgraduation,
					graduationdegree,
					photograph,
					regDate,
					tokenCode,
					studentPassword,
					status,
					idCardStatus,
					userStatus
				)
				VALUES
				(
					:studentName,
					:rollnumber,
					:studentEmail,
					:studentpEmail,
					:studentMobile,
					:vtype,
					:role,
					:yearofenroll,
					:yearofgraduation,
					:graduationdegree,
					:photograph,
					:regDate,
					:tokenCode,
					:studentPassword,
					'PENDING',
					'PENDING',
					'Y'
				)
			");

			$stmt->bindParam(":studentName", $studentName);
			$stmt->bindParam(":rollnumber", $rollnumber);
			$stmt->bindParam(":studentEmail", $studentEmail);
			$stmt->bindParam(":studentpEmail", $studentpEmail);
			$stmt->bindParam(":studentMobile", $studentMobile);
			$stmt->bindParam(":vtype", $vtype);
			$stmt->bindParam(":role", $role);
			$stmt->bindParam(":yearofenroll", $yearofenroll);
			$stmt->bindParam(":yearofgraduation", $yearofgraduation);
			$stmt->bindParam(":graduationdegree", $graduationdegree);
			$stmt->bindParam(":photograph", $photograph);
			$stmt->bindParam(":regDate", $regDate);
			$stmt->bindParam(":tokenCode", $tokenCode);
			$stmt->bindParam(":studentPassword", $studentPassword);

			$stmt->execute();
			return true;

		} catch (PDOException $ex) {
			echo $ex->getMessage();
			return false;
		}
	}

	/* ==============================
	   USER LOGIN
	============================== */
	public function login($studentEmail, $upass, $authtokenid) {
		try {

			$stmt = $this->conn->prepare(
				"SELECT * FROM studentregistration WHERE studentEmail = :email LIMIT 1"
			);
			$stmt->execute([":email" => $studentEmail]);
			$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

			if (!$userRow) {
				header("Location: index.php?error");
				exit;
			}

			/* userStatus check */
			if ($userRow['userStatus'] !== "Y") {
				header("Location: index.php?inactive");
				exit;
			}

			/* password check (plain – existing logic preserved) */
			if ($userRow['studentPassword'] !== $upass) {
				header("Location: index.php?error");
				exit;
			}

			$studentID = $userRow['studentID'];
			$loginFlg  = "Y";

			/* authsession handling */
			$stmt2 = $this->conn->prepare(
				"SELECT * FROM authsession WHERE studentID = :studentID"
			);
			$stmt2->execute([":studentID" => $studentID]);
			$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

			if (!$row2) {
				$stmt3 = $this->conn->prepare(
					"INSERT INTO authsession (studentID, authtokenid, loginFlg)
					 VALUES (:studentID, :authtokenid, :loginFlg)"
				);
				$stmt3->execute([
					":studentID"   => $studentID,
					":authtokenid" => $authtokenid,
					":loginFlg"    => $loginFlg
				]);
			} else {
				$stmt4 = $this->conn->prepare(
					"UPDATE authsession
					 SET authtokenid = :authtokenid,
					     loginFlg = :loginFlg
					 WHERE studentID = :studentID"
				);
				$stmt4->execute([
					":studentID"   => $studentID,
					":authtokenid" => $authtokenid,
					":loginFlg"    => $loginFlg
				]);
			}

			$_SESSION['userSession'] = $userRow['studentEmail'];
			$_SESSION['studentIDSession'] = $studentID;
			return true;

		} catch (PDOException $ex) {
			echo $ex->getMessage();
		}
	}

	/* ==============================
	   SESSION HELPERS
	============================== */
	public function is_logged_in() {
		return isset($_SESSION['userSession']);
	}

	public function redirect($url) {
		header("Location: $url");
		exit;
	}

	public function logout() {
		session_destroy();
		unset($_SESSION['userSession'], $_SESSION['studentIDSession']);
	}

	/* ==============================
	   EMAIL
	============================== */
	public function send_mail($email, $message, $subject) {
		require_once 'mailer/class.phpmailer.php';

		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth   = true;
		$mail->SMTPSecure = "tls";
		$mail->Host       = "smtp.gmail.com";
		$mail->Port       = 587;

		$mail->Username   = "alumniadmin@iiitd.ac.in";
		$mail->Password   = "gg";

		$mail->setFrom("no@iiitd.ac.in", "IIIT-Delhi");
		$mail->addAddress($email);
		$mail->addReplyTo("admin-web@iiitd.ac.in", "IIIT-Delhi");

		$mail->Subject = $subject;
		$mail->MsgHTML($message);
		$mail->send();
	}
}
