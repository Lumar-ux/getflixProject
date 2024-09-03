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
$sql = "(SELECT mc.comment_id, u.username, u.avatar, m.title AS name, m.poster_path, mc.comment, mc.created_at, 'movie' AS type 
FROM movie_comments mc INNER JOIN users u ON mc.user_id = u.user_id 
INNER JOIN movies m ON mc.movie_id = m.id WHERE u.user_id =:user_id ) 
UNION ALL 
(SELECT sc.comment_id, u.username, u.avatar, s.title AS name, s.poster_path, sc.comment, sc.created_at, 'series' AS type FROM tv_series_comments sc 
INNER JOIN users u ON sc.user_id = u.user_id INNER JOIN tv_series s ON sc.tv_series_id = s.id WHERE u.user_id = :user_id) ORDER BY created_at DESC;";
$stmt = $dbConnection->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);



//delete comment -----------------------------------------------------------------------------
if (isset($_GET['dc'])) {
    $type = $_GET['type'];
    $comment_id = $_GET['dc'];
    $query = '';
    if ($type == "movie") {
        $query = "DELETE FROM movie_comments WHERE comment_id =:comment_id;";
    } else {
        $query = "DELETE FROM tv_series_comments WHERE comment_id =:comment_id;";
    }
    $stmt = $dbConnection->prepare($query);
    $stmt->bindParam(':comment_id', $comment_id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        header("Location:profile.php?comment=deleted");
    } else {
        header("Location:profile.php?comment=notdeleted");
    }
}



// ------------------ edit user data----------------------------------
if (isset($_POST['fullname'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $query = "UPDATE users SET fullname=:fullname, email=:email, username=:username WHERE user_id=:user_id;";
    $stmt = $dbConnection->prepare($query);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        header("Location:profile.php?userdata=updated");
    } else {
        header("Location:profile.php?userdata=noupdated");
    }
}



// ---------------------getting user data ----------------------------------
$user_query = "SELECT * FROM users WHERE user_id=:user_id;";
$stmt = $dbConnection->prepare($user_query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$users_data = $stmt->fetch(PDO::FETCH_ASSOC);



// ---------------------Deleteing user account----------------------------
if (isset($_POST['delete_user_id'])) {
    $user_id = $_POST['delete_user_id'];


    try {
        // Prepare the DELETE SQL query
        $delete_query = "DELETE FROM users WHERE user_id = :user_id;";
        $stmt = $dbConnection->prepare($delete_query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any rows were affected (i.e., deleted)
        if ($stmt->rowCount() > 0) {

            // Destroy the all session
            session_destroy();

            header("Location:index.php?account=deleted");
            exit;
        } else {
            header("Location:profile.php?account=nodeleted");
        }
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <link rel="icon" href="image/favicon.ico.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Profile</title>
</head>

<body class="bg-halfBlack sm:w-screen w-full h-fit">
    <?php include_once("./header.php"); ?>
    <main class=" p-5 rounded-lg shadow-lg max-w-md w-[80%] sm:container mx-auto h-fit flex justify-between gap-5">
        <section class=" w-[40%] rounded-lg">
            <!-- Avatar Section -->
            <!-- <header class="flex justify-center mb-10">
                <img src="<?php echo htmlspecialchars($avatar_directory . $_SESSION['avatar']); ?>" alt="Avatar"
                    class="w-32 h-32 object-cover rounded-full border-4 border-pastelBlue">
            </header> -->

            <!-- Profile Information Section -->
            <!-- <section class="text-align"> -->
            <!-- Full Name -->
            <!-- <article class="mb-4">
                    <h1 class="text-lg font-semibold text-gray-700 inline-block">Full Name :</h1>
                    <span id="fullname" class="text-lg text-gray-900 font-normal inline-block">
                        <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                    </span>
                </article> -->

            <!-- Username -->
            <!-- <article class="mb-4">
                    <h2 class="text-lg font-semibold text-gray-700 inline-block">User Name :</h2>
                    <span id="username" class="text-lg text-gray-900 font-normal inline-block">
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </span>
                </article>
            </section> -->

            <!-- Email -->
            <!-- <article class="mb-10">
                <h2 class="text-lg font-semibold text-gray-700 inline-block">Email :</h2>
                <span id="username" class="text-lg text-gray-900 font-normal inline-block">
                    <?php echo htmlspecialchars($_SESSION['email']); ?>
                </span>
            </article> -->
            <!-- Close Button Section -->
            <!-- <footer class="absolute bottom-4 right-4">
                <button onclick="window.location.href='index.php';"
                    class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"> -->
            <!-- SVG Cross Icon -->
            <!-- <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </footer> -->



            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-end px-4 pt-4">
                    <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                        <span class="sr-only">Open dropdown</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                            <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2" aria-labelledby="dropdownButton">
                            <li>
                                <a href="#" data-modal-target="static-modal" data-modal-toggle="static-modal" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                            </li>
                            <li>
                                <a href="#" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col items-center pb-10">
                    <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="./image/avatar_directory/<?php echo $_SESSION['avatar']; ?>" alt="Bonnie image" />
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Username: <?php echo $users_data['username']; ?></h5>

                    <div class="flex mt-4 md:mt-6 flex-col">
                        <p class="text-xl text-gray-500 dark:text-gray-400"><b>Full Name : </b><?php echo $users_data['fullname']; ?></p>
                        <p class="text-xl text-gray-500 dark:text-gray-400"><b>Email : </b><?php echo $users_data['email']; ?></p>

                    </div>
                </div>
            </div>
        </section>

        <!-- ---------- user info edit model  --------- -->
        <!-- Main modal -->
        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Update User Info
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="md:p-5 space-y-1">
                        <form class="max-w-sm mx-auto" action="" method="POST">
                            <div class="mb-5">
                                <label for="fullname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Full Name</label>
                                <input type="text" id="fullname" name="fullname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required value="<?php echo $users_data['fullname']; ?>" />
                            </div>
                            <div class="mb-5">
                                <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                                <input type="text" id="username" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required value="<?php echo $users_data['username']; ?>" />
                            </div>
                            <div class="mb-5">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" id="email" name='email' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required value="<?php echo $users_data['email']; ?>" />
                            </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </form>
                        <button data-modal-hide="static-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- -----------------user delete model confirmation------------------- -->
        <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <form action="" method="POST">
                            <input type="text" class="hidden" name="delete_user_id" value="<?php echo $user_id; ?>">

                            <h3 class="mb-3 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete your account?</h3>
                            <p class="mb-5 text-sm font-normal text-gray-500 dark:text-gray-400">All you data will be delete.</p>

                            <button data-modal-hide="popup-modal" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                        </form>
                        <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- -------------- model end ------------------- -->



        <section class="w-[40%] p-4 bg-gray-100 rounded-lg">
            <!-- User Comments Section -->
            <section class=" pt-1 px-3 rounded-lg shadow-lg w-full max-w-md relative">
                <h2 class=" text-lg font-bold text-gray-700 mb-4">My Comments:</h2>
                <div class=" rounded-lg shadow-sm">
                    <?php
                    foreach ($comments as $comment) {
                    ?>
                        <div class="flex items-start gap-2.5">
                            <img class="w-20 h-20 rounded-lg" src="http://image.tmdb.org/t/p/w500/<?php echo $comment['poster_path']; ?>" alt="poster">
                            <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4  rounded-e-xl rounded-es-xl ">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="text-sm text-gray-900 dark:text-white font-bold"><?php echo $comment['name']; ?></span>
                                    <!-- <span class="text-sm font-normal text-gray-500 dark:text-gray-400">11:46</span> -->
                                    <a href="?dc=<?php echo $comment['comment_id']; ?>&type=<?php echo $comment['type']; ?>" class="focus:outline-none w-9 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><img src="image/delete.png" alt="delete img"></a>
                                </div>
                                <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">Comment: <?php echo $comment['comment']; ?></p>


                            </div>
                            <!-- <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" data-dropdown-placement="bottom-start" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600" type="button">
                        </button> -->

                        </div>
                    <?php } ?>

                </div>
            </section>
        </section>

        <section class="w-[40%] bg-gray-100 p-5 rounded-lg">
            <h2 class="text-lg text-gray-700 mb-4 font-bold">NewsLetter</h2>
            <p class="text-gray-700 mb-5">Subscribe to our newsletter for the latest updates on new movie releases and exclusive content. Don't miss out—stay in the loop with all the cinematic news!</p>
            <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Subscribe</button>

            <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">UnSubscribe</button>
        </section>

    </main>
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>