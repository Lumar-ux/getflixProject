<?php
require_once('dbh.inc.php');
$token = $_GET['token'];
$token_hash = hash('sha256', $token);

$query = "SELECT * FROM users WHERE reset_token_hash =:token_hash";

$stmt = $pdo->prepare($query);

$stmt->bind_param(':token_hash', $token_hash);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user['reset_token_expires_at']) <= time()) {
    die('token has expired');
}

echo "token is valid and hasn't expired";



if (isset($_POST['password'])) {
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_pass'];

    if (!preg_match("/[0-9]/", $password) || !preg_match("/[0-9]/", $confirm_pass)) {
        die('Password must contain at lest one number');
    }

    if (!preg_match("/[0-9]/", $password) || !preg_match("/[0-9]/", $confirm_pass)) {
        die('Password must contain at lest one number');
    }
    if ($confirm_pass !== $password) {
        die('password did not match');
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password =:n_password , reset_token_hash =null, reset_token_expires_at=null WHERE user_id =:user_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bind_param(':n_password', $password_hash);
        $stmt->bind_param(':user_id', $user['user_id']);
        $stmt->execute();

        $affectedRows = $stmt->rowCount();

        if ($affectedRows > 0) {
            header("location:login.php?password=updated");
        } else {
            header("location:login.php?password=not_updated");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <link rel="icon" href="image/favicon.ico.jpg" type="image/x-icon">
    <title></title>
</head>

<body class="bg-halfBlack sm:w-screen w-full h-fit">
    <?php include_once("./header.php"); ?>
    <main class="w-[80%] sm:container mx-auto sm:w-full h-[801px] flex sm:mb-14 mb-[39px]">
        <section
            class="login w-full sm:w-[651.81px] h-[717px] sm:h-full bg-greyWhite rounded-xl sm:mr-6 mr-0 flex flex-col items-center ">
            <article id="forget_form" class=" relative sm:top-[110px] top-[88px] text-center items-center">
                <h1 class="text-[32px] font-bold mb-8 leading-none text-center">Reset your password</h1>
                <p class="text-sm w-[240px] sm:w-[328px] mb-8 mx-auto text-center ">

                <form action="" method="post" class="flex flex-col mb-[10px]">
                    <input type="password" name="password" id="floatingEmail" placeholder="New password" autocomplete="off" required
                        class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                        value="" />
                    <input type="password" name="confirm_pass" id="floatingEmail" placeholder="Confirm password" autocomplete="off" required
                        class="w-[234px] sm:w-[405px] h-[58px] border-2 border-pastelBlue rounded-xl text-center mb-4"
                        value="" />
                    <button type="submit" name="submit" id="floatingLogin"
                        class="w-[234px] sm:w-[405px] h-[58px] font-[570] bg-pastelBlue rounded-xl mb-2"><span
                            class="font-[570]">Reset</span></button>
                </form>
            </article>

        </section>
        <section class="img-login h-full sm:grid grid-rows-2 grid-cols-2 gap-6 grow hidden">
            <div class="bg-gray-500 rounded-xl" name="img-log_01">1</div>
            <div class="bg-gray-500 rounded-xl row-span-2" name="img-log_02">2</div>
            <div class="bg-gray-500 rounded-xl" name="img-log_03">3</div>
        </section>
    </main>
    <?php include_once("./footer.php"); ?>
</body>
<script>
    let login_link = document.getElementById('login_link');
    let forget_link = document.getElementById('forget_link');

    let login_div = document.getElementById('login_form'); // Assuming you have a login form
    let forget_div = document.getElementById('forget_form');

    login_link.addEventListener('click', (e) => {
        e.preventDefault();
        login_form.classList.remove('hidden');
        forget_form.classList.add('hidden');
    });

    forget_link.addEventListener('click', (e) => {
        e.preventDefault();
        forget_form.classList.remove('hidden');
        login_form.classList.add('hidden');
    });
</script>

</html>