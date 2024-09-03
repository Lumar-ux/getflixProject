<?php
require_once('dbh.inc.php');

// Retrieve and hash the token
$token = $_GET['token'] ?? ''; // Use null coalescing to avoid undefined index notice
$token = filter_var($token); // Sanitize token to avoid malicious input
$token_hash = hash('sha256', $token);

// Prepare the SQL query
$query = "SELECT * FROM users WHERE reset_token_hash = :token_hash";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':token_hash', $token_hash);
$stmt->execute();

// Fetch the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result === false) { // Check if the token was found
    redirectWithError("Invalid or expired token");
}

// Check if the token has expired
if (strtotime($result['reset_token_expires_at']) <= time()) {
    redirectWithError("Token has expired");
}

// echo "token is valid and hasn't expired";


// Function to redirect with an error message
function redirectWithError($message)
{
    header("Location: reset_password.php?error=" . urlencode($message) . "&token=" . $_GET['token']);
    exit();
}



if (isset($_POST['password'])) {
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_pass'];

    // Check if the password contains at least one number
    if (!preg_match("/[0-9]/", $password) || !preg_match("/[0-9]/", $confirm_pass)) {
        redirectWithError('Password must contain at least one number');
    }

    // Check if the passwords match
    if ($confirm_pass !== $password) {
        redirectWithError("Passwords do not match");
    } else {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL query
        $query = "UPDATE users SET password = :n_password, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE user_id = :user_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':n_password', $password_hash);
        $stmt->bindParam(':user_id', $result['user_id']);
        $stmt->execute();

        try {
            // Check if the password was updated successfully
            $affectedRows = $stmt->rowCount();

            if ($affectedRows > 0) {
                sendChangeConfirmation($result['username'], $result['email']);
                header("Location: login.php?password=updated");
            } else {
                header("Location: login.php?password=not_updated");
            }
        } catch (PDOException $e) {
            // Log the error
            error_log("Database error: " . $e->getMessage());
            redirectWithError("An error occurred. Please try again later.");
        }
        exit();
    }
}


function sendChangeConfirmation($username, $email)
{
    // get date and time
    $current_date = date('Y-m-d');
    echo "Current date: " . $current_date . "\n";
    // Get current time
    $current_time = date('H:i:s');
    echo "Current time: " . $current_time . "\n";



    $mail = require __DIR__ . "/mailer.php";
    $mail->setFrom("noreply@getflix.rf.gd"); // email address from your domain
    $mail->addAddress($email); // user email
    $mail->Subject = "Password Change Confirmation";
    $mail->isHTML(true);
    $mail->Body = <<<END
        <p>Dear $username,</p>
        <p>Your account password was successfully changed on $current_date at $current_time.</p>
        <p>Important notes:</p>
        <ul>
            <li>Your new password is now active for future logins.</li>
            <li>If you didn't make this change, please contact us immediately at <a href="mailto:support@getflix.rf.gd">support@getflix.rf.gd</a></li>
        </ul>
        <p>For account security:</p>
        <ul>
            <li>Never share your password.</li>
            <li>Use unique passwords for different accounts.</li>
        </ul>
        <p>If you have any questions, our support team is here to help.</p>
        <p>Best regards,<br>Getflix Team</p>
    END;
    try {
        $mail->send();
        echo "Message has been sent successfully.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
    }
}

?>

<!DOCTYPE html>
<html lang="en" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <link rel="icon" href="image/favicon.ico.jpg" type="image/x-icon">
    <title></title>
</head>

<body class="bg-halfBlack sm:w-screen w-full h-fit">
    <?php include_once("./header.php"); ?>
    <main class="w-[80%] sm:container mx-auto sm:w-full h-[801px] flex sm:mb-14 mb-[39px]">
        <section
            class="login w-full sm:w-[651.81px] h-[717px] sm:h-full bg-greyWhite rounded-xl sm:mr-6 mr-0 flex flex-col items-center ">
            <article id="forget_form" class=" relative sm:top-[110px] top-[88px] text-center items-center">
                <h1 class="text-[32px] font-bold mb-8 leading-none text-center">Reset your password</h1>
                <?php
                if (isset($_GET['error'])) {
                    echo '<p class="text-sm w-[240px] sm:w-[328px] mb-8 mx-auto text-center text-red-600 border border-red-500">' . htmlspecialchars($_GET['error']) . '</p>';
                }
                ?>

                <form action="" method="post" class="flex flex-col mb-[10px]">
                    <input type="password" name="password" id="floatingEmail" placeholder="New password" autocomplete="off" required
                        class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                        value="" />
                    <input type="password" name="confirm_pass" id="floatingEmail" placeholder="Confirm password" autocomplete="off" required
                        class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                        value="" />
                    <button type="submit" name="submit" id="floatingLogin"
                        class="w-[234px] sm:w-[405px] h-[58px] font-[570] bg-pastelBlue rounded-xl mb-2"><span
                            class="font-[570]">Reset</span></button>
                </form>
            </article>

        </section>
        <section class="img-login h-full sm:grid grid-rows-2 grid-cols-2 gap-6 grow hidden">
            <div class="bg-gray-500 rounded-xl" name="img-log_01">
                <img src="image/login_image/image1.jpg" class="max-h-[388.5px] w-full object-top rounded-xl" alt="movie-poster">
            </div>
            <div class="rounded-xl row-span-2" name="img-log_02">
                <img src="image/login_image/image2.jpg" class="max-h-[801px] object-cover rounded-xl" alt="movie-poster">
            </div>
            <div class="bg-gray-500 rounded-xl" name="img-log_03">
                <img src="image/login_image/image3.jpg" class="max-h-[388.5px] w-full object-cover rounded-xl" alt="movie-poster">
            </div>
        </section>
    </main>
    <?php include_once("./footer.php"); ?>
</body>
<script>
    let login_link = document.getElementById('login_link');
    let forget_link = document.getElementById('forget_link');

    let login_div = document.getElementById('login_form'); // Assuming you have a login form
    let forget_div = document.getElementById('forget_form');

    login_link.addEventListener('click', (e) => {
        e.preventDefault();
        login_form.classList.remove('hidden');
        forget_form.classList.add('hidden');
    });

    forget_link.addEventListener('click', (e) => {
        e.preventDefault();
        forget_form.classList.remove('hidden');
        login_form.classList.add('hidden');
    });
</script>

</html>