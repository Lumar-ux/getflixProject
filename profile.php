<?php
session_start();
include_once "dbh.inc.php";

// Assurez-vous que l'utilisateur est connecté
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

// Définissez le répertoire des avatars
$avatar_directory = "image/avatar_directory/";

$dbConnection = getDatabaseConnection();

// Préparez la requête SQL pour récupérer les commentaires de l'utilisateur
$user_id = $_SESSION['user_id']; // Assurez-vous que user_id est stocké dans la session
$sql = "SELECT comment FROM tv_series_comments WHERE user_id = ?";
$stmt = $dbConnection->prepare($sql);
$stmt->execute([$user_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Profile</title>
</head>

<body class="bg-gray-100 h-screen flex justify-center items-center">

    <main class="bg-white p-10 rounded-lg shadow-lg w-full max-w-md relative">
        <!-- Avatar Section -->
        <header class="flex justify-center mb-10">
            <img src="<?php echo htmlspecialchars($avatar_directory . $_SESSION['avatar']); ?>" alt="Avatar"
                class="w-32 h-32 object-cover rounded-full border-4 border-pastelBlue">
        </header>

        <!-- Profile Information Section -->
        <section class="text-align">
            <!-- Full Name -->
            <article class="mb-4">
                <h1 class="text-lg font-semibold text-gray-700 inline-block">Full Name :</h1>
                <span id="fullname" class="text-lg text-gray-900 font-normal inline-block">
                    <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                </span>
            </article>

            <!-- Username -->
            <article class="mb-4">
                <h2 class="text-lg font-semibold text-gray-700 inline-block">User Name :</h2>
                <span id="username" class="text-lg text-gray-900 font-normal inline-block">
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
            </article>
        </section>

        <!-- Email -->
        <article class="mb-10">
            <h2 class="text-lg font-semibold text-gray-700 inline-block">Email :</h2>
            <span id="username" class="text-lg text-gray-900 font-normal inline-block">
                <?php echo htmlspecialchars($_SESSION['email']); ?>
            </span>
        </article>

        <!-- User Comments Section -->
        <section>
            <h2 class="text-lg font-semibold text-gray-700 mb-4">My Comments:</h2>
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <?php if (count($comments) > 0): ?>
                <ul class="list-disc pl-5">
                    <?php foreach ($comments as $comment): ?>
                    <li class="mb-2"><?php echo htmlspecialchars($comment['comment']); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p class="text-gray-600">You have not posted any comments yet.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Close Button Section -->
        <footer class="absolute bottom-4 right-4">
            <button onclick="window.location.href='index.php';"
                class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
                <!-- SVG Cross Icon -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </footer>

    </main>
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>