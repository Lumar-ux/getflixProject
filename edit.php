<?php
session_start();

// Vérifiez si l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['autority']) || $_SESSION['autority'] !== 1) {
    header("Location: login.php");
    exit();
}

require_once "dbh.inc.php";

// Initialiser les variables
$user = null;
$userId = null;

// Vérifiez si un ID est fourni pour l'édition
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    try {
        $query = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            die("Utilisateur non trouvé.");
        }
        $userId = $user['user_id'];
    } catch(PDOException $e) {  
        die("Échec de la requête : ". $e->getMessage());
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Mot de passe
    $authority = $_POST['authority']; // Autorité

    // Gestion de l'avatar
    $avatar = $_POST['current_avatar']; // Valeur par défaut de l'avatar

    if (!empty($_FILES['avatar']['name'])) {
        // Nouveau fichier a été téléchargé
        $avatarFile = $_FILES['avatar'];
        $avatarName = basename($avatarFile['name']);
        $avatarPath = 'image/avatar_directory/' . $avatarName;

        // Déplacer le fichier téléchargé
        if (move_uploaded_file($avatarFile['tmp_name'], $avatarPath)) {
            $avatar = $avatarName;
            // Mettre à jour l'avatar dans la base de données
            // Connexion à la base de données et requête de mise à jour
            //$query = "UPDATE users SET avatar = ? WHERE id = ?";
            //$stmt = $pdo->prepare($query);
            //$stmt->execute([$avatarName, $userId]);
        // Erreur lors du téléchargement du fichier
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    }

    try {
        $query = "UPDATE users SET username = :username, fullname = :fullname, email = :email, autority = :autority, avatar = :avatar";
        
        if (!empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $query .= ", password = :password";
        }
        
        $query .= " WHERE user_id = :user_id";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":fullname", $fullname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":autority", $authority, PDO::PARAM_INT);
        $stmt->bindParam(":avatar", $avatar);
        $stmt->bindParam(":user_id", $id, PDO::PARAM_INT);
        
        if (!empty($password)) {
            $stmt->bindParam(":password", $passwordHash);
        }
        
        $stmt->execute();
        header("Location: admin.php");
        exit();
    } catch(PDOException $e) {  
        die("Échec de la requête : ". $e->getMessage());
    }
} else {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Edit User</h2>
        <form method="POST" action="" enctype="multipart/form-data"
            class="bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['user_id']); ?>">

            <div class="mb-4">
                <label for="user_id" class="block text-gray-700 text-sm font-medium mb-2">User ID:</label>
                <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>"
                    disabled
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-200 text-gray-600 cursor-not-allowed">
            </div>

            <div class="mb-4">
                <label for="authority" class="block text-gray-700 text-sm font-medium mb-2">Authority:</label>
                <input type="number" id="authority" name="authority"
                    value="<?php echo htmlspecialchars($user['autority']); ?>"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-medium mb-2">Username:</label>
                <input type="text" id="username" name="username"
                    value="<?php echo htmlspecialchars($user['username']); ?>"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="fullname" class="block text-gray-700 text-sm font-medium mb-2">Fullname:</label>
                <input type="text" id="fullname" name="fullname"
                    value="<?php echo htmlspecialchars($user['fullname']); ?>"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password:</label>
                <input type="password" id="password" name="password"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Leave blank to keep current password">
            </div>

            <div class="mb-4">
                <label for="avatar" class="block text-gray-700 text-sm font-medium mb-2">Avatar:</label>
                <input type="file" id="avatar" name="avatar"
                    class="block w-full text-gray-600 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <?php if (!empty($user['avatar'])): ?>
                <img src="image/avatar_directory/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Current Avatar"
                    class="mt-4 w-32 h-32 object-cover border border-gray-300 rounded-md">
                <?php endif; ?>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="submit" name="update"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Update</button>
                <a href="admin.php" class="text-blue-500 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>