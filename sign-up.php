<?php
// Affichage des erreurs PHP pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize the session
include_once "dbh.inc.php";

// Variables d'authentification et d'erreurs
$authenticated = false;
if (isset($_SESSION["email"])) {
    $authenticated = true;
}

// Initialisation des variables pour stocker les valeurs des champs et les erreurs
$username = "";
$fullname = "";
$email = "";
$password = "";
$confirm_password = "";

$username_error = "";
$fullname_error = "";
$email_error = "";
$password_error = "";
$confirm_password_error = "";
$avatar_error = "";

$error = false;

/******************************* AVATAR ************************************/

$avatar_directory = "./image/avatar_directory/";

if (is_dir($avatar_directory)) {
    $avatars = array_filter(scandir($avatar_directory), function($file) use ($avatar_directory) {
        $allowed_ext = array("jpg", "jpeg", "png", "gif");
        $file_ext = pathinfo($file, PATHINFO_EXTENSION);
        return in_array($file_ext, $allowed_ext) && !is_dir($avatar_directory . $file);
    });
} else {
    $avatars = [];
    $avatar_error = "Avatar directory does not exist.";
}

// Initialiser la sélection d'avatar (au cas où le formulaire est envoyé vide)
$avatar = isset($_POST['avatar']) ? $_POST['avatar'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $username = $_POST['username'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $avatar = $_POST['avatar'] ?? '';

    /***************************** Validation du username ***********************************/
    if (empty($username)) {
        $username_error = "Username is required";
        $error = true;
    }

    /***************************** Validation du fullname ***********************************/
    if (empty($fullname)) {
        $fullname_error = "Full name is required";
        $error = true;
    }

    /***************************** Validation de l'email ***********************************/
    if (empty($email)) {
        $email_error = "Email is required";
        $error = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Email format is not valid";
        $error = true;
    } else {
        try{
             // Vérifiez si l'email est déjà utilisé
            $dbConnection = getDatabaseConnection();
            $statement = $dbConnection->prepare("SELECT user_id FROM users WHERE email = ?");
            $statement->execute([$email]);
            if ($statement->rowCount() > 0) {
            $email_error = "Email is already used";
            $error = true;
            } 
        } catch (PDOException $e) {
           $email_error ="Database error: " . $e->getMessage();
           $error = true;
        }
    }

    /***************************** Validation du password ***********************************/
    if (strlen($password) < 6) {
        $password_error = "Password must have at least 6 characters";
        $error = true;
    }

    /***************************** Validation de la confirmation du password ***********************************/
    if ($confirm_password != $password) {
        $confirm_password_error = "Password and Confirm Password do not match";
        $error = true;
    }

    /***************************** Validation de l'avatar ***********************************/
    if (empty($avatar) || !in_array($avatar, $avatars)) {
        $avatar_error = "Please select a valid avatar";
        $error = true;
    }

    /***************************** Si pas d'erreurs, insérer l'utilisateur dans la base de données **********************/
    if (!$error) {
        try{
            // Autorité par défaut à 2 pour les non-admins
            $autority = 2;

            // Hashage du mot de passe avant l'insertion dans la base de données
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $statement = $dbConnection->prepare(
                "INSERT INTO users (username, password, fullname, email, avatar, autority) VALUES (?, ?, ?, ?, ?, ?)"
            );
            $statement->execute([$username, $hashed_password, $fullname, $email, $avatar, $autority]);
            $insert_id = $dbConnection->lastInsertId();

            // Définir une variable de session pour indiquer le succès
            $_SESSION['registration_success'] = true;
            $_SESSION['fullname'] = $fullname; // Stocker le nom complet pour le message
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
            $_SESSION['registration_success'] = false;
        }
    } else {
        $_SESSION['registration_success'] = false;
    }
}


// Affichage de l'alerte de succès
if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) { ?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
    <strong class="font-bold">Success! </strong>
    <span class="block sm:inline">
        <?php echo "Awesome, " . htmlspecialchars($_SESSION['fullname']) . "! Your GETFLIX account has been created. You can now log in and start streaming your favorite shows and movies!"; ?>
    </span>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none';">
            <title>Close</title>
            <path
                d="M14.348 5.652a.5.5 0 1 0-.707-.707L10 8.586 6.36 4.945a.5.5 0 1 0-.707.707l3.64 3.64-3.64 3.64a.5.5 0 0 0 .707.707L10 10.414l3.64 3.64a.5.5 0 0 0 .707-.707l-3.64-3.64 3.64-3.64z" />
        </svg>
    </span>
</div>

<?php

    // Réinitialiser la variable de session pour éviter que l'alerte ne réapparaisse lors du rafraîchissement de la page
    unset($_SESSION['registration_success']);
    unset($_SESSION['fullname']);
}


?>


<!DOCTYPE html>
<html lang="en" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <title>Sign Up</title>
</head>

<body class="bg-halfBlack sm:w-screen w-full h-fit">
    <?php include_once("./header.php");?>
    <main class="w-[80%] sm:container mx-auto h-[801px] sm:mb-14 mb-[39px] flex">
        <section
            class="login w-[651.81px] h-[775px] sm:h-full bg-greyWhite rounded-xl sm:mr-6 mr-0 flex flex-col items-center sm:mb-14 mb-[39px]">
            <article class="relative top-[50px]">
                <h1 class="text-[32px] font-bold mb-8 leading-none text-center">Sign Up</h1>
                <form action="#" method="post" class="flex flex-col mb-[10px]">
                    <input type="username" name="username" placeholder="User Name"
                        class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                        value="<?php echo htmlspecialchars($username); ?>">
                    <span class="text-red-500"><?php echo htmlspecialchars($username_error); ?></span>
                    <input type="password" name="password" placeholder="Password"
                        class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4">
                    <span class="text-red-500"><?php echo htmlspecialchars($password_error); ?></span>
                    <input type="password" name="confirm_password" placeholder="Confirm Password"
                        class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4" />
                    <span class="text-red-500"><?php echo htmlspecialchars($confirm_password_error); ?></span>
                    <input type="fullname" name="fullname" placeholder="Full Name"
                        class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                        value="<?php echo htmlspecialchars($fullname); ?>" />
                    <span class="text-red-500"><?php echo htmlspecialchars($fullname_error); ?></span>
                    <input type="email" name="email" placeholder="Email"
                        class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                        value="<?php echo htmlspecialchars($email); ?>">
                    <span class="text-red-500"><?php echo htmlspecialchars($email_error); ?></span>
                    <section
                        class="bg-[#B1BBFC] h-[120px] w-[234px] sm:w-[405px] overflow-x-scroll flex items-center rounded-xl mb-4">
                        <article class="flex mx-4">
                            <?php foreach ($avatars as $image): ?>
                            <input type="radio" name="avatar" class="hidden last:mr-0 mr-4"
                                value="<?php echo htmlspecialchars($image); ?>"
                                <?php if (isset($avatar) && $avatar == $image) echo 'checked'; ?>>
                            <img src="<?php echo htmlspecialchars($avatar_directory . $image); ?>" alt="Avatar"
                                class="last:mr-0 mr-4 flex-none h-[86px] w-[86px] rounded-full focus:outline-none focus:ring-2 focus:ring-greyWhite">
                            <?php endforeach;?>
                        </article>
                        <span class="text-red-500"><?php echo htmlspecialchars($avatar_error); ?></span>
                    </section>
                    <button type="submit" name="submit"
                        class="w-[234px] sm:w-[405px] h-[58px] font-[570] bg-pastelBlue rounded-xl mb-2"><span
                            class="font-[570]">Sign Up</span></button>
                </form>
                <!-- <p class="text-xs w-[328px]">This page is protected by Google reCAPTCHA to ensure that you are not a robot.</p> -->
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