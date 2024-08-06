<?php 
include_once "layout/header.php";

// Check if the user is logged in; if not, redirect them to the login page
if (!isset($_SESSION["email"])) {
    header("location: login.php");
    exit;
}

// Define the avatar directory
$avatar_directory = "images/avatar_directory/";

?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mx-auto border shadow p-4 d-flex flex-column" style="height: 100%;">
            <h2 class="text-center mb-4">Profile</h2>
            <hr />

            <div class="row mb-3">
                <div class="col-sm-4">Username</div>
                <div class="col-sm-8"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4">Fullname</div>
                <div class="col-sm-8"><?php echo htmlspecialchars($_SESSION['fullname']); ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4">Email</div>
                <div class="col-sm-8"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4">Avatar</div>
                <div class="col-sm-8">
                    <img src="<?php echo htmlspecialchars($avatar_directory . $_SESSION['avatar']); ?>" alt="Avatar"
                        class="img-thumbnail" style="width: 80px; height: 80px;">
                </div>
            </div>
            <br />

            <!-- Button Container -->
            <div class="mt-auto text-end">
                <a href="index.php" class="btn btn-outline-danger">
                    Close
                </a>
            </div>
        </div>
    </div>
</div>

<?php
// Include the footer
include_once "layout/footer.php";
?>