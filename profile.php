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
    <link rel="icon" href="image/favicon.ico.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Profile</title>
</head>

<body class="bg-halfBlack sm:w-screen w-full h-fit">
    <?php include_once("./header.php"); ?>
    <main class="bg-gray-400 p-5 rounded-lg shadow-lg max-w-md w-[80%] sm:container mx-auto h-fit flex justify-between gap-5">
        <section class="p-5 w-[40%] bg-gray-300 rounded-lg">
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
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col items-center pb-10">
                    <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="./image/avatar_directory/<?php echo $_SESSION['avatar']; ?>" alt="Bonnie image" />
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white"><?php echo $_SESSION['username']; ?></h5>

                    <div class="flex mt-4 md:mt-6 flex-col">
                        <p class="text-sm text-gray-500 dark:text-gray-400"><b>Full Name : </b><?php echo $_SESSION['fullname']; ?></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400"><b>Email : </b><?php echo $_SESSION['email']; ?></p>
                        <a href="index.php" class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">back</a>
                    </div>
                </div>
            </div>



        </section>

        <section class="w-[40%] p-5 bg-gray-300 rounded-lg">
            <!-- User Comments Section -->
            <section class="p-10 rounded-lg shadow-lg w-full max-w-md relative">
                <h2 class=" text-lg font-semibold text-gray-700 mb-4">My Comments:</h2>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <!-- <?php if (count($comments) > 0): ?>
                        <ul class="list-disc pl-5">
                            <?php foreach ($comments as $comment): ?>
                                <li class="mb-2"><?php echo htmlspecialchars($comment['comment']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-gray-600">You have not posted any comments yet.</p>
                    <?php endif; ?> -->


                    <div class="flex items-start gap-2.5">
                        <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="Jese image">
                        <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Bonnie Green</span>
                                <!-- <span class="text-sm font-normal text-gray-500 dark:text-gray-400">11:46</span> -->
                            </div>
                            <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">That's awesome. I think our users will really appreciate the improvements.</p>
                        </div>
                        <!-- <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" data-dropdown-placement="bottom-start" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600" type="button">
                        </button> -->

                    </div>
                </div>
            </section>
        </section>

        <section class="w-[40%] bg-gray-300 p-10">
            <h2 class="text-lg text-gray-700 mb-4 font-bold">NewsLetter</h2>
            <p class="text-gray-700 mb-5">Subscribe to our newsletter for the latest updates on new movie releases and exclusive content. Don't miss out—stay in the loop with all the cinematic news!</p>
            <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Subscribe</button>

            <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">UnSubscribe</button>
        </section>

    </main>

    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>