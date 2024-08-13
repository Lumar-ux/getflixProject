<?php
// Affichage des erreurs PHP pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize the session
session_start();

// Check if the user is logged in; if yes, redirect them to the home page
if (isset($_SESSION["email"])) {
    header("location: index.php");
    exit;
} 

$email = "";
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = 'Email and Password are required!';
    } else {
        include_once 'dbh.inc.php';
        $dbConnection = getDatabaseConnection();
        
        // Prepare the SQL query using PDO
        $statement = $dbConnection->prepare(
            "SELECT user_id, username, fullname, password, avatar FROM users WHERE email = :email"
        );
        
        // Bind the 'email' parameter to the query
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        
        // Execute the query
        $statement->execute();
        
        // Fetch the result
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Extract user data
            $stored_password = $user['password'];
            $user_id = $user['user_id'];
            $username = $user['username'];
            $fullname = $user['fullname'];
            $avatar = $user['avatar'];

            if (password_verify($password, $stored_password)) {
                // Password is correct

                // Store data in session variables
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['email'] = $email;
                $_SESSION['avatar'] = $avatar;


                // Redirect user to the home page
                header('location: index.php');
                exit;
            } else {
                $error = 'Incorrect password!';
            }
        } else {
            $error = 'No account found with that email!';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en" class="h-screen w-screen">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <title>Login</title>
  </head>
  <body class="bg-halfBlack sm:w-screen w-full h-fit">
    <?php include_once("./header.php");?>
    <main class="w-[80%] sm:container mx-auto sm:w-full h-[801px] flex sm:mb-14 mb-[39px]">
        <section class="login w-full sm:w-[651.81px] h-[717px] sm:h-full bg-greyWhite rounded-xl sm:mr-6 mr-0 flex flex-col items-center ">
            <article class="relative sm:top-[110px] top-[88px]">
                <h1 class="text-[32px] font-bold mb-8 leading-none text-center">Login</h1>

                <?php  if (!empty($error)) { ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold"><?= $error ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </aside>
                    <?php } ?>

                    <form action="login.php" method="post" class="flex flex-col mb-[10px]">
                        <input type="email" name="email" id="floatingEmail" placeholder="Email"
                            class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                            value="<?=$email?>" />

                        <input type="password" name="password" id="floatingPassword" placeholder="Password"
                            class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                            value="" />

                        <button type="submit" name="submit" id="floatingLogin"
                            class="w-[234px] sm:w-[405px] h-[58px] font-[570] bg-pastelBlue rounded-xl mb-2"><span
                                class="font-[570]">Log
                                in</span></button>
                        <a href="index.php">
                            <p class="underline text-xs text-center">Forgot your password?</p>
                        </a>
                        <p class="font-[570] h-fit leading-none text-center my-4">OR</p>
                        <a href="sign-up.php"
                            class="w-[234px] sm:w-[405px] h-[58px] text-pastelBlue bg-halfBlack rounded-xl font-[570] mb-2 flex justify-center items-center"><span
                                class="font-[570]">Sign Up</span></button></a>
                        <article>
                            <input type="checkbox" name="rememberMe" id="rememberMe" class="accent-pastelBlue">
                            <label for="rememberMe">Remember me</label>
                        </article>
                                </form>
                    <p class="text-xs w-[234px] sm:w-[328px]">This page is protected by Google reCAPTCHA to ensure that you are not a
                        robot.</p>
            </article>
        </section>
        <section class="img-login h-full sm:grid grid-rows-2 grid-cols-2 gap-6 grow hidden">
            <div class="bg-gray-500 rounded-xl" name="img-log_01">1</div>
            <div class="bg-gray-500 rounded-xl row-span-2" name="img-log_02">2</div>
            <div class="bg-gray-500 rounded-xl" name="img-log_03">3</div>
        </section>
    </main>
    <?php include_once("./footer.php");?>
</body>

</html>