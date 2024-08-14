<?php
// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
require_once 'dbh.inc.php';

// Initialize variables
$email = $password = "";
$email_error = $password_error = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        $dbConnection = getDatabaseConnection();

        // Verify email and password
        $statement = $dbConnection->prepare("SELECT email, password FROM users WHERE user_id = ?");
        $statement->execute([$user_id]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $email_valid = filter_var($email, FILTER_VALIDATE_EMAIL) && $email === $user['email'];
            $password_correct = password_verify($password, $user['password']);

            if ($email_valid && $password_correct) {
                // Prepare and execute the deletion query
                $deleteStatement = $dbConnection->prepare("DELETE FROM users WHERE user_id = ?");
                $deleteStatement->execute([$user_id]);

                // Destroy the session and redirect the user
                session_unset();
                session_destroy();
                header("Location: index.php?status=deleted");
                exit();
            } else {
                if (!$email_valid) {
                    $email_error = "Email is invalid or does not match.";
                }
                if (!$password_correct) {
                    $password_error = "Incorrect password.";
                }
            }
        } else {
            $error_message = "No account found with that email!";
        }
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./output.css">
    <title>Sign Out</title>
</head>

<body class="bg-halfBlack sm:w-screen w-full h-fit">
    <?php include_once("./header.php");?>
    <main class="w-[80%] sm:container mx-auto sm:w-full h-[801px] flex sm:mb-14 mb-[39px]">
        <section
            class="sign-out w-full sm:w-[651.81px] h-[717px] sm:h-full bg-greyWhite rounded-xl sm:mr-6 mr-0 flex flex-col items-center ">
            <article class="relative sm:top-[110px] top-[88px]">
                <h1 class="text-[32px] font-bold mb-8 leading-none text-center">Sign Out</h1>
                <strong>
                    <p>Deleting your account will erase all your personal data, preferences, and history.
                        This action is
                        irreversible. Are you sure you want to proceed?</p>
                </strong>
                <?php if ($error_message || $email_error || $password_error): ?>
                <div class="text-red-500 mb-4">
                    <p><?= $error_message ?></p>
                    <p><?= $email_error ?></p>
                    <p><?= $password_error ?></p>
                </div>
                <?php endif; ?>
                <form action="Sign-out.php" method="post" class="flex flex-col mb-[10px]">
                    <input type="email" name="email" id="floatingEmail" placeholder="Email" required
                        class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                        value="<?=$email?>" />

                    <input type="password" name="password" id="floatingPassword" placeholder="Password"
                        class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                        value="" />

                    <button type="submit" name="submit" id="floatingLogin"
                        class="w-[234px] sm:w-[405px] h-[58px] font-[570] bg-pastelBlue rounded-xl mb-2"><span
                            class="font-[570]">Sign Out
                        </span></button>
                    <a href="sign-out.php">
                        <p class="underline text-xs text-center">Forgot your password?</p>
                    </a>
                    <p class="font-[570] h-fit leading-none text-center my-4">OR</p>
                    <a href="index.php"
                        class="w-[234px] sm:w-[405px] h-[58px] text-pastelBlue bg-halfBlack rounded-xl font-[570] mb-2 flex justify-center items-center"><span
                            class="font-[570]">Close</span></button></a>
                </form>
                <section class="img-login h-full sm:grid grid-rows-2 grid-cols-2 gap-6 grow hidden">
                    <div class="bg-gray-500 rounded-xl" name="img-log_01">1</div>
                    <div class="bg-gray-500 rounded-xl row-span-2" name="img-log_02">2</div>
                    <div class="bg-gray-500 rounded-xl" name="img-log_03">3</div>
                </section>
    </main>
    <?php include_once("./footer.php");?>
</body>

</html>