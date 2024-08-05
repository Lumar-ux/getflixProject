<?php 
include "layout/header.php"; 

// Démarrer une session pour accéder aux variables de session
session_start();

// Vérifiez si les données nécessaires sont disponibles (vous pouvez aussi les récupérer d'une base de données)
if (isset($_SESSION['username']) && isset($_SESSION['avatar'])) {
    $username = $_SESSION['username'];
    $avatar = $_SESSION['avatar'];
} else {
    // Rediriger vers la page d'inscription si les données ne sont pas disponibles
    header("Location: register.php");
    exit();
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mx-auto border shadow p-4">
            <h2 class="text-center mb-4">Registration Successful</h2>
            <hr />
            <div class="text-center mb-4">
                <h4>Welcome, <?php echo htmlspecialchars($username); ?>!</h4>
                <p>You have successfully registered.</p>
                <div class="my-3">
                    <img src="../assets/images/avatars/<?php echo htmlspecialchars($avatar); ?>" alt="Avatar"
                        class="img-thumbnail" style="width: 150px; height: 150px;">
                </div>
                <a href="index.php" class="btn btn-dark">Go to Homepage</a>
            </div>
        </div>
    </div>
</div>

<?php 
include "layout/footer.php"; 
?>