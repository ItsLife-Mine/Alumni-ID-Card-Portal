<?php
require_once 'lib/config.php'; // Apni config file ka path check kar lein

if (isset($_POST["del_idD"])) {
    $encrypted_string = $_POST["del_idD"];

    // Encryption Settings (Dashboard ke exact match honi chahiye)
    $cipher_algo = "AES-128-CTR"; 
    $option = 0;
    $decrypt_iv = '8746376827619797'; 
    $decrypt_key = "encryption"; 

    // Decrypt the ID
    $studentID = openssl_decrypt($encrypted_string, $cipher_algo, $decrypt_key, $option, $decrypt_iv);

    if ($studentID) {
        // Status ko wapas 'N' aur 'Pending' set karna
        $userStatus = "N";
        $idCardStatus = "Pending";

        $sql = "UPDATE studentregistration SET 
                userStatus = :userStatus, 
                idCardStatus = :idCardStatus 
                WHERE studentID = :studentID";
        
        $stmt = $DB_con->prepare($sql);
        $stmt->bindParam(':studentID', $studentID);
        $stmt->bindParam(':userStatus', $userStatus);
        $stmt->bindParam(':idCardStatus', $idCardStatus);

        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Error: Could not update database.";
        }
    } else {
        echo "Error: Invalid ID.";
    }
}
?>