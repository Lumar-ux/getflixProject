<?php
include_once "layout/header.php";

// Check if the user is logged in; if yes, redirect them to the home page
if (isset($_SESSION["email"])) {
    header("location: index.php");
    exit;
} 
?>


<div class="container py-5">
    <div class="mx-auto border shadow p-4" style="width: 400px">
        <h2 class=" text-center mb-4">Password reset</h2>
        <hr />

        <?php  if (!empty($error)) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>
                <?= $error ?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>

        <form action="password_reset.php" method="post">
            <div class="row mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" placeholder="Oops! Forgot your password?" required>
            </div>

            <div class="row mb-3">
                <div class="col d-grid">
                    <button type="submit" class="btn btn-dark">Reset password</button>
                </div>
                <div class="col d-grid">
                    <a href="index.php" class="btn btn-outline-dark">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>


<?php
include_once "layout/footer.php";
?>