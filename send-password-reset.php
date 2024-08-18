<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST["email"];

    $token = bin2hex(random_bytes(16)); // will give random 16 number

    $token_hash = hash('sha256', $token); //will hash the number to 35

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    require_once "dbh.inc.php";

    $query = "UPDATE users SET reset_token_hash = :token_hash, 
                reset_token_expires_at = :expiry 
                WHERE email = :email;";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':token_hash', $token_hash, PDO::PARAM_STR);
    $stmt->bindParam(':expiry', $expiry, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $affectedRows = $stmt->rowCount();
    if ($affectedRows > 0) {
        $mail = require __DIR__ . "/mailer.php";
        $mail->setFrom("getflix404@gmail.com"); // email address from your domain
        $mail->addAddress($email); // user email
        $mail->Subject = "Password Reset";
        $mail->Body = <<<END

        Click <a href="http://localhost/reset-password.php?token=$token">Here</a>
        to reset your password.

        END;
        // the url has to be a actual link 
        try {
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error:{$mail->ErrorInfo}";
        }
        header('Location:login.php?send=success');
    }
}
