<?php
session_start();

// Vérifiez si l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['autority']) || $_SESSION['autority'] !== 1) {
    header("Location: login.php"); // Redirection si non autorisé
    exit();
}

// Gestion de la suppression des utilisateurs
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

         // Redirection pour éviter la resoumission lors du rafraîchissement
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();

    } catch(PDOException $e) {  
        die("Échec de la requête : ". $e->getMessage());
    }
}

// Gestion de l'ajout d'un utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Assurez-vous de ne pas stocker les mots de passe en clair
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $avatar = 'default_avatar.jpg';// Avatar par défaut
    $autority = intval($_POST['autority']);

    try {
        require_once "dbh.inc.php";
        $query = "INSERT INTO users (username, password, fullname, email, avatar, autority) VALUES (:username, :password, :fullname, :email, :avatar, :autority)";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":fullname", $fullname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":avatar", $avatar);
        $stmt->bindParam(":autority", $autority, PDO::PARAM_INT);
        
        $stmt->execute();
        $pdo = null;
        $stmt = null;

        // Redirection pour éviter la resoumission lors du rafraîchissement
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();

    } catch(PDOException $e) {  
        die("Échec de la requête : ". $e->getMessage());
    }  
}

include_once "graph.inc.php"; // Inclure le fichier pour générer les données du graphique


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
    <!-- Début du conteneur principal -->
    <section class="container mx-auto p-6 md:p-8 lg:p-12">
        <h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>
        <!-- Boutons flexibles et responsive -->
        <section class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
            <a class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" href="#" role="button">XXX</a>
            <a class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" href="#" role="button">XXX</a>
            <a class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" href="logout.php" role="button">Exit</a>
            <!-- Bouton Exit -->
        </section>
        <br><br>

        <!-- Conteneur flex pour le formulaire et le graphique -->
        <section class="flex flex-col md:flex-row gap-6  mb-6">
            <!-- Formulaire pour ajouter un nouvel utilisateur -->
            <section class="bg-white p-6 rounded-lg shadow-md w-full md:w-1/3">
                <h3 class="text-xl font-semibold mb-4">Add New User</h3>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <section class="mb-4">
                        <!-- Formulaire d'ajout d'utilisateur -->
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" name="username" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </section>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="fullname" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="fullname" name="fullname" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="autority" class="block text-sm font-medium text-gray-700">Authority</label>
                        <select id="autority" name="autority" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </div>
                    <button type="submit" name="add"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add User</button>
                </form>
            </section>

            <!-- Section pour le graphique -->
            <aside class="bg-white p-6 rounded-lg shadow-md w-full md:w-2/3">
                <h3 class="text-xl font-semibold mb-4">User Growth Over Time</h3>
                <!-- Remplacez ce texte par le code du graphique -->
                <section class="h-65 bg-gray-200 rounded-lg flex items-center justify-center">
                    <canvas id="userChart"></canvas>
                </section>
            </aside>
        </section>

        <!-- Tableau avec conteneur scrollable -->
        <section class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border-b text-xs md:text-sm">Created_at</th>
                        <th class="px-4 py-2 border-b text-xs md:text-sm">Autority</th>
                        <th class="px-4 py-2 border-b text-xs md:text-sm">User_id</th>
                        <th class="px-4 py-2 border-b text-xs md:text-sm">Username</th>
                        <th class="px-4 py-2 border-b text-xs md:text-sm">Password</th>
                        <th class="px-4 py-2 border-b text-xs md:text-sm">Fullname</th>
                        <th class="px-4 py-2 border-b text-xs md:text-sm">Email</th>
                        <th class="px-4 py-2 border-b text-xs md:text-sm">Avatar</th>
                        <th class="px-4 py-2 border-b text-xs md:text-sm">Last Updated</th>
                        <th class="px-4 py-2 border-b text-xs md:text-sm">Action</th>
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
                        <td class='px-4 py-2 border-b text-xs md:text-sm'>{$row['created_at']}</td>
                        <td class='px-4 py-2 border-b text-xs md:text-sm'>{$row['autority']}</td>
                        <td class='px-4 py-2 border-b text-xs md:text-sm'>{$row['user_id']}</td>
                        <td class='px-4 py-2 border-b text-xs md:text-sm'>{$row['username']}</td>
                        <td class='px-4 py-2 border-b text-xs md:text-sm'>{$row['password']}</td>
                        <td class='px-4 py-2 border-b text-xs md:text-sm'>{$row['fullname']}</td>
                        <td class='px-4 py-2 border-b text-xs md:text-sm'>{$row['email']}</td>
                        <td class='px-4 py-2 border-b text-xs md:text-sm'>
                            <img src='./image/avatar_directory/{$row['avatar']}' alt='Avatar' class='w-8 h-8'>
                        </td>
                         <td class='px-4 py-2 border-b text-xs md:text-sm'>
                            {$row['last_updated']} <!-- Affichage de la date du dernier changement -->
                        </td>
                        <td class='px-4 py-2 border-b text-xs md:text-sm'>
                        <section class='flex space-x-2'>
                            <a href='edit.php?id={$row['user_id']}' class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 inline-block mr-2'>Edit</a>
<form method='POST' action='admin.php' style='display:inline;'>
                    <input type='hidden' name='id' value='{$row['user_id']}'>
                    <button type='submit' name='delete'
                        class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600'>Delete</button>
                    </form>
        </section>
        </td>
        </tr>
        ";
        }
        ?>
                </tbody>
            </table>
        </section>
    </section>
    <!-- Inclure Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer les données depuis PHP
        const dates = <?php echo $datesJson; ?>;
        const userCounts = <?php echo $userCountsJson; ?>;

        // Création du graphique
        const ctx = document.getElementById('userChart').getContext('2d');
        new Chart(ctx, {
            type: 'line', // Type de graphique
            data: {
                labels: dates, // Labels des axes (dates)
                datasets: [{
                    label: 'Number of Users', // Légende de la série
                    data: userCounts, // Données à afficher (nombre d'utilisateurs)
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Users'
                        }
                    }
                }
            }
        });
    });
    </script>
</body>

</html>