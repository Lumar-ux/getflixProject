<?php
session_start();

// Vérifiez si l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['autority']) || $_SESSION['autority'] !== 1) {
    header("Location: login.php"); // Redirection si non autorisé
    exit();
}

// Handle message deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = intval($_POST['id']);  // Correction : utiliser 'id' au lieu de 'user_id'
    
    try {
        require_once "dbh.inc.php";
        $query = "DELETE FROM users WHERE user_id = :user_id";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $id, PDO::PARAM_INT);
        
        $stmt->execute();
        $pdo = null;
        $stmt = null;

        // Redirect to avoid resubmission on refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();

    } catch(PDOException $e) {  
        die("Échec de la requête : ". $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Admin Dashboard</title>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6 md:p-8 lg:p-12">
        <h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>
        <a class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" href="#" role="button">XXX</a>
        <a class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" href="#" role="button">XXX</a>
        <br><br>
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border-b">Autority</th>
                    <th class="px-4 py-2 border-b">User_id</th>
                    <th class="px-4 py-2 border-b">Username</th>
                    <th class="px-4 py-2 border-b">Password</th>
                    <th class="px-4 py-2 border-b">Fullname</th>
                    <th class="px-4 py-2 border-b">Email</th>
                    <th class="px-4 py-2 border-b">Avatar</th>
                    <th class="px-4 py-2 border-b">Last Updated</th>
                    <th class="px-4 py-2 border-b">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Configuration de la base de données
                include_once "dbh.inc.php";
                
                // Requête SQL pour récupérer tous les DATA users
                $sql = "SELECT * FROM users";
                
                $result = $pdo->query($sql);

                if (!$result) { 
                    die("Requête invalide : " . $pdo->errorInfo()[2]);
                }

                // Récupérer et afficher les données de chaque ligne
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "
                    <tr>
                        <td class='px-4 py-2 border-b'>{$row['autority']}</td>
                        <td class='px-4 py-2 border-b'>{$row['user_id']}</td>
                        <td class='px-4 py-2 border-b'>{$row['username']}</td>
                        <td class='px-4 py-2 border-b'>{$row['password']}</td>
                        <td class='px-4 py-2 border-b'>{$row['fullname']}</td>
                        <td class='px-4 py-2 border-b'>{$row['email']}</td>
                        <td class='px-4 py-2 border-b'>
                            <img src='./image/avatar_directory/{$row['avatar']}' alt='Avatar' class='w-8 h-8'>
                        </td>
                         <td class='px-4 py-2 border-b'>
                            {$row['last_updated']} <!-- Affichage de la date du dernier changement -->
                        </td>
                        <td class='px-4 py-2 border-b'>
                        <div class='flex space-x-2'>
                            <a href='edit.php?id={$row['user_id']}' class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 inline-block mr-2'>Edit</a>
                            <form method='POST' action='#' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['user_id']}'>
                                <button type='submit' name='delete' class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600'>Delete</button>
                            </form>
                        </div>
                        </td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>