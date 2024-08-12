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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <title>Sign Up</title>
</head>

<body class="bg-halfBlack h-screen w-screen">
    <?php include_once("./header.php");?>
    <main class="container mx-auto w-full h-[801px] my-14 flex">
        <section class="Profile w-[651.81px] h-full bg-greyWhite rounded-xl mr-6 flex flex-col items-center ">
            <article class="relative top-[50px]">
                <h1 class="text-[32px] font-bold mb-8 leading-none text-center">Profile</h1>
                <section class="flex flex-col mb-[10px]">
                    <section class="mb-3 flex items-center">
                        <img src="<?php echo htmlspecialchars($avatar_directory . $_SESSION['avatar']); ?>" alt="Avatar"
                            class="w-20 h-20 object-cover rounded-full cursor-pointer
                       hover:ring-2 hover:ring-pastelBlue
                       focus:outline-none focus:ring-2 focus:ring-greyWhite">
                    </section>

                    <section class="mb-3 flex items-center">
                        <Label for="profile" value="Username">
                            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        </Label>
                    </section>

                    <section class="mb-3 flex items-center">
                        <Label for="profile" value="Username">
                            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        </Label>
                    </section>

                    <!-- Autres informations ou éléments de profil -->
                </section>
            </article>





            <span type="password" name="password" placeholder="Password"
                class="w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4" value="" />
            <span class="text-red-500"><?php echo htmlspecialchars($password_error); ?></span>

            <input type="password" name="confirm_password" placeholder="Confirm Password"
                class="w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4" value="" />
            <span class="text-red-500"><?php echo htmlspecialchars($confirm_password_error); ?></span>

            <input type="fullname" name="fullname" placeholder="Full Name"
                class="w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                value="<?php echo htmlspecialchars($fullname); ?>" />
            <span class="text-red-500"><?php echo htmlspecialchars($fullname_error); ?></span>

            <input type="email" name="email" placeholder="Email"
                class="w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                value="<?php echo htmlspecialchars($email); ?>" />
            <span class="text-red-500"><?php echo htmlspecialchars($email_error); ?></span>

            <section class="bg-[#B1BBFC] h-auto w-[405px] overflow-x-auto flex items-center rounded-xl mb-4">
                <div class="grid grid-cols-4 gap-4 p-4">
                    <?php foreach ($avatars as $image): ?>
                    <div class="flex justify-center items-center">
                        <label>
                            <input type="radio" name="avatar" value="<?php echo htmlspecialchars($image); ?>"
                                <?php if (isset($avatar) && $avatar == $image) echo 'checked'; ?> class="hidden">
                            <img src="<?php echo htmlspecialchars($avatar_directory . $image); ?>" alt="Avatar" class="w-20 h-20 object-cover rounded-full cursor-pointer
                           hover:ring-2 hover:ring-pastelBlue
                           focus:outline-none focus:ring-2 focus:ring-greyWhite">
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <span class="text-red-500"><?php echo htmlspecialchars($avatar_error); ?></span>
            </section>
            <button type="action" name="sign-out"
                class="w-[405px] h-[58px] font-[570] bg-pastelBlue rounded-xl mb-2"><span
                    class="font-[570]">close</span></button>
        </section>
        </aside>
        <!-- <p class="text-xs w-[328px]">This page is protected by Google reCAPTCHA to ensure that you are not a robot.</p> -->
        </article>
        </section>
        <section class="img-login h-full grid grid-rows-2 grid-cols-2 gap-6 grow">
            <div class="bg-gray-500 rounded-xl" name="img-log_01">1</div>
            <div class="bg-gray-500 rounded-xl row-span-2" name="img-log_02">2</div>
            <div class="bg-gray-500 rounded-xl" name="img-log_03">3</div>
        </section>
    </main>
    <?php include_once("./footer.php");?>
</body>

</html>