<?php
include_once "layout/header.php";

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

<div class="container py-5">
    <div class="mx-auto border shadow p-4" style="width: 400px">
        <h2 class="text-center mb-4">Account Deletion Confirmation</h2>
        <hr />

        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-box">
            <strong>
                <p>Deleting your account will erase all your personal data, preferences, and history. This action is
                    irreversible. Are you sure you want to proceed?</p>
            </strong>
            <button type="button" class="btn-close" id="close-alert" aria-label="Close"></button>
        </div>

        <!-- Sad Message Div (Initially Hidden) -->
        <div id="sad-message" style="display: none; text-align: center;">
            <p class="text-warning">We're sorry to see you go. We hope to see you again someday!</p>
        </div>

        <!-- Error Messages -->
        <?php if ($email_error): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($email_error); ?>
        </div>
        <?php endif; ?>
        <?php if ($password_error): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($password_error); ?>
        </div>
        <?php endif; ?>
        <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
        <?php endif; ?>

        <form method="post"
            onsubmit="return confirm('Are you sure you want to delete your account? This action is irreversible.');">
            <div class="row mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" />
                <?php if ($email_error): ?>
                <span class="text-danger"><?php echo htmlspecialchars($email_error); ?></span>
                <?php endif; ?>
            </div>

            <div class="row mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" />
                <?php if ($password_error): ?>
                <span class="text-danger"><?php echo htmlspecialchars($password_error); ?></span>
                <?php endif; ?>
            </div>

            <div class="row mb-3">
                <div class="col d-grid">
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </div>
                <div class="col d-grid">
                    <a href="profile.php" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="script.js"></script>

<?php
// Include the footer
include_once "layout/footer.php";
?>