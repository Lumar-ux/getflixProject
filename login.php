<?php
include_once "layout/header.php";

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


<div class="container py-5">
    <div class="mx-auto border shadow p-4" style="width: 400px">
        <h2 class=" text-center mb-4">Login</h2>
        <hr />

        <?php  if (!empty($error)) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>
                <?= $error ?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>

        <form action="login.php" method="post">
            <div class="row mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?=$email?>" />
            </div>

            <div class="row mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" value="" />
            </div>

            <div class="row mb-3">
                <div class="col d-grid">
                    <button type="submit" class="btn btn-dark">Login</button>
                </div>
                <div class="col d-grid">
                    <a href="index.php" class="btn btn-outline-dark">
                        Cancel
                    </a>
                </div>

        </form>
    </div>
</div>


<?php
include_once "layout/footer.php";
?>