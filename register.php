<?php 

// Affichage des erreurs PHP pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "layout/header.php";
require_once 'dbh.inc.php';

// Initialisation des variables pour stocker les valeurs des champs et les erreurs
$username = "";
$fullname = "";
$email = "";

$username_error = "";
$fullname_error = "";
$email_error = "";
$password_error = "";
$confirm_password_error = "";
$avatar_error = "";   

$error = false;

/*******************************      AVATAR      ************************************/

$avatar_directory = "images/avatar_directory/";

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
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $avatar = $_POST['avatar'];

    /*****************************   Validation du username  ***********************************/
    if (empty($username)) {
        $username_error = "Username is required";
        $error = true; 
    }

    /*****************************   Validation du fullname  ***********************************/     
    if (empty($fullname)) {
        $fullname_error = "Full name is required";
        $error = true; 
    }

    /*****************************   Validation de l'email  ***********************************/    
    if (empty($email)) {
        $email_error = "Email is required";
        $error = true; 
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Email format is not valid";
        $error = true; 
    } else {
        // Vérifiez si l'email est déjà utilisé
        $dbConnection = getDatabaseConnection();
        $statement = $dbConnection->prepare("SELECT user_id FROM users WHERE email = ?");
        $statement->execute([$email]);
        if ($statement->rowCount() > 0) {
            $email_error = "Email is already used";
            $error = true;
        }
    }
    
    /*****************************   Validation du password  ***********************************/    
    if (strlen($password) < 6) {
        $password_error = "Password must have at least 6 characters";
        $error = true; 
    }
    
    /*****************************   Validation de la confirmation du password ***********************************/    
    if ($confirm_password != $password) {
        $confirm_password_error = "Password and Confirm Password do not match";
        $error = true; 
    }

    /*****************************   Validation de l'avatar  ***********************************/ 
    if (empty($avatar) || !in_array($avatar, $avatars)) {
        $avatar_error = "Please select a valid avatar";
        $error = true;
    }
  
    /***************************** Si pas d'erreurs, insérer l'utilisateur dans la base de données **********************/
    if (!$error) {
        // Hashage du mot de passe avant l'insertion dans la base de données
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $statement = $dbConnection->prepare(
            "INSERT INTO users (username, password, fullname, email, avatar) VALUES (?, ?, ?, ?, ?)"
        );
        $statement->execute([$username, $hashed_password, $fullname, $email, $avatar]);
        $insert_id = $dbConnection->lastInsertId();
        
        echo "New record created successfully. User ID: " . htmlspecialchars($insert_id);

        // Redirect user to the home page
         /**header('location: index.php');
         exit;**/
    }
    
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mx-auto border shadow p-4">
            <h2 class="text-center mb-4">Register</h2>
            <hr />

            <form action="register.php" method="post">
                <!-- Formulaire pour le nom d'utilisateur, le mot de passe, etc. -->
                <div class="row mb-3">
                    <label for="username" class="col-sm-4 col-form-label">Username*</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="username"
                            value="<?php echo htmlspecialchars($username); ?>" />
                        <span class="text-danger"><?php echo htmlspecialchars($username_error); ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-sm-4 col-form-label">Password*</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password" value="" />
                        <span class="text-danger"><?php echo htmlspecialchars($password_error); ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="confirm_password" class="col-sm-4 col-form-label">Confirm Password*</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="confirm_password" value="" />
                        <span class="text-danger"><?php echo htmlspecialchars($confirm_password_error); ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="fullname" class="col-sm-4 col-form-label">Full name*</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="fullname"
                            value="<?php echo htmlspecialchars($fullname); ?>" />
                        <span class="text-danger"><?php echo htmlspecialchars($fullname_error); ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-sm-4 col-form-label">Email*</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" name="email"
                            value="<?php echo htmlspecialchars($email); ?>" />
                        <span class="text-danger"><?php echo htmlspecialchars($email_error); ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="avatar" class="col-sm-4 col-form-label">Select Avatar*</label>
                    <div class="col-sm-8">
                        <div class="d-flex flex-wrap">
                            <?php foreach ($avatars as $image): ?>
                            <div class="m-2">
                                <label>
                                    <input type="radio" name="avatar" value="<?php echo htmlspecialchars($image); ?>"
                                        <?php if ($avatar == $image) echo 'checked'; ?> />
                                    <img src="<?php echo htmlspecialchars($avatar_directory . $image); ?>" alt="Avatar"
                                        class="img-thumbnail" style="width: 80px; height: 80px;">
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <span class="text-danger"><?php echo htmlspecialchars($avatar_error); ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="offset-sm-4 col-sm-4 d-grid">
                        <button type="submit" class="btn btn-dark">Register</button>
                    </div>
                    <div class="col-sm-4 d-grid">
                        <a href="index.php" class="btn btn-outline-dark">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
include "layout/footer.php";
?>