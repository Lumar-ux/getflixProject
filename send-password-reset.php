<?php
require_once("dbh.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST["email"];

    $token = bin2hex(random_bytes(16)); // will give random 16 number

    $token_hash = hash('sha256', $token); //will hash the number to 35

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);




    //geting user name

    $user_query = "SELECT username FROM users where email = :email;";
    $user_st = $pdo->prepare($user_query);
    $user_st->bindParam(':email', $email, PDO::PARAM_STR);
    $user_st->execute();
    $user_info = $user_st->fetch(PDO::FETCH_ASSOC);
    $username = $user_info['username'];

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
        $mail->setFrom("noreply@getflix.rf.gd"); // email address from your domain
        $mail->addAddress($email); // user email
        $mail->Subject = "Reset Your Password";
        $mail->isHTML(true);
        $mail->Body = <<<END
            <p>Dear $username,</p>
            
            <p>We received a request to reset your password for your account. If you didn't make this request, you can ignore this email.</p>
            
            <p>To reset your password, please click the link below:</p>
            
            <a href="http://getflix.rf.gd/reset-password.php?token=$token" 
                style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #ffffff; background-color: #007bff; text-decoration: none; border-radius: 5px;">
            Reset Your Password
            </a>
            
            <p>This link will expire in 24 hours. If you need any further assistance, feel free to contact our support team.</p>
            
            <p>Thank you for using our service.</p>
            
            <p>Best regards,<br>
            Getflix Support Team</p>
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
