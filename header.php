<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Initialize the session
if (session_status() === PHP_SESSION_NONE) {
    // Session has not started, so start it
    session_start();
}

include_once "dbh.inc.php";

$authenticated = false;
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $authenticated = true;
}

// Define the avatar directory
$avatar_directory = "image/avatar_directory/";

?>
<header class="w-[80%] sm:container mx-auto h-[88.6px] sm:h-[110px]">
    <nav class="h-full w-full">
        <ul class="list-none h-full flex justify-center sm:justify-between items-center sm:flex-nowrap flex-wrap">
            <li class="logo-mobile sm:hidden flex mt-6"><a href="index.php"><img src="image/GETFLIX_logo.svg" alt="GetFlix Logo"
                        class="sm:h-[30px] h-[18px] sm:mr-[73px] mr-0"></a></li>
            <li class="logo-desk sm:flex hidden"><a href="index.php"><img src="image/GETFLIX_logo.svg" alt="GetFlix Logo"
                        class="sm:h-[30px] h-[18px] sm:mr-[73px] mr-0"></a>
                <a href="index.php"
                    class="mr-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'text-pastelBlue' : 'text-white'; ?>">Home</a>
                <a href="category.php?movies"
                    class="mr-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'category.php' && isset($_GET['movies'])) ? 'text-pastelBlue' : 'text-white'; ?>">Movie</a>
                <a href="category.php?series"
                    class="mr-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'category.php' && isset($_GET['series'])) ? 'text-pastelBlue' : 'text-white'; ?>">Tv
                    Shows</a>
                <a href="category.php?country"><button id="dropdownHoverButton1" data-dropdown-toggle="dropdownHover1"
                        data-dropdown-trigger="hover"
                        class="<?php echo (basename($_SERVER['PHP_SELF']) == 'category.php' && isset($_GET['country'])) ? 'text-pastelBlue' : 'text-white'; ?> focus:ring-2 focus:outline-none focus:ring-gray-300 rounded-xl mr-4 inline-flex items-center leading-none h-[20px]"
                        type="button">Country<svg class="w-2.5 h-2.5 ml-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4"></path>
                        </svg>
                    </button></a>
                <div id="dropdownHover1"
                    class="z-10 bg-greyWhite divide-y divide-gray-100 rounded-xl shadow w-fit hidden px-2">
                    <article class="flex">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton1">
                            <li>
                                <a href="category.php?c=argentina"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Argentina</a>
                            </li>
                            <li>
                                <a href="category.php?c=australia"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Australia</a>
                            </li>
                            <li>
                                <a href="category.php?c=austria"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Austria</a>
                            </li>
                            <li>
                                <a href="category.php?c=belgium"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Belgium</a>
                            </li>
                            <li>
                                <a href="category.php?c=brazil"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Brazil</a>
                            </li>
                            <li>
                                <a href="category.php?c=canada"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Canada</a>
                            </li>
                            <li>
                                <a href="category.php?c=china"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">China</a>
                            </li>
                            <li>
                                <a href="category.php?c=czech_republic"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Czech
                                    Republic</a>
                            </li>
                            <li>
                                <a href="category.php?c=denmark"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Denmark</a>
                            </li>
                        </ul>
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton1">
                            <li>
                                <a href="category.php?c=finland"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Finland</a>
                            </li>
                            <li>
                                <a href="category.php?c=france"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">France</a>
                            </li>
                            <li>
                                <a href="category.php?c=germany"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Germany</a>
                            </li>
                            <li>
                                <a href="category.php?c=hong_kong"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Hong
                                    Kong</a>
                            </li>
                            <li>
                                <a href="category.php?c=hungary"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Hungary</a>
                            </li>
                            <li>
                                <a href="category.php?c=india"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">India</a>
                            </li>
                            <li>
                                <a href="category.php?c=ireland"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Ireland</a>
                            </li>
                            <li>
                                <a href="category.php?c=israel"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Israel</a>
                            </li>
                            <li>
                                <a href="category.php?c=italy"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Italy</a>
                            </li>
                        </ul>
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton1">
                            <li>
                                <a href="category.php?c=japan"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Japan</a>
                            </li>
                            <li>
                                <a href="category.php?c=luxembourg"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Luxembourg</a>
                            </li>
                            <li>
                                <a href="category.php?c=mexico"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Mexico</a>
                            </li>
                            <li>
                                <a href="category.php?c=netherlands"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Netherlands</a>
                            </li>
                            <li>
                                <a href="category.php?c=new_zealand"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">New
                                    Zealand</a>
                            </li>
                            <li>
                                <a href="category.php?c=norway"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Norway</a>
                            </li>
                            <li>
                                <a href="category.php?c=poland"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Poland</a>
                            </li>
                            <li>
                                <a href="category.php?c=romania"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Romania</a>
                            </li>
                            <li>
                                <a href="category.php?c=russia"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Russia</a>
                            </li>
                        </ul>
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton1">
                            <li>
                                <a href="category.php?c=south_africa"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">South
                                    Africa</a>
                            </li>
                            <li>
                                <a href="category.php?c=south_korea"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">South
                                    Korea</a>
                            </li>
                            <li>
                                <a href="category.php?c=spain"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Spain</a>
                            </li>
                            <li>
                                <a href="category.php?c=sweden"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Sweden</a>
                            </li>
                            <li>
                                <a href="category.php?c=switzerland"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Switzerland</a>
                            </li>
                            <li>
                                <a href="category.php?c=taiwan"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Taiwan</a>
                            </li>
                            <li>
                                <a href="category.php?c=thailand"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Thailand</a>
                            </li>
                            <li>
                                <a href="category.php?c=united_kingdom"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">United
                                    Kingdom</a>
                            </li>
                            <li>
                                <a href="category.php?c=United+States+of+America"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">USA</a>
                            </li>
                        </ul>
                    </article>
                </div>
                <a href="category.php?language">
                    <button id="dropdownHoverButton3" data-dropdown-toggle="dropdownHover3"
                        data-dropdown-trigger="hover"
                        class="<?php echo (basename($_SERVER['PHP_SELF']) == 'category.php' && isset($_GET['language'])) ? 'text-pastelBlue' : 'text-white'; ?> focus:ring-2 focus:outline-none focus:ring-gray-300 rounded-xl mr-4 inline-flex items-center leading-none h-[20px]"
                        type="button">Browse by language<svg class="w-2.5 h-2.5 ml-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4"></path>
                        </svg>
                    </button></a>
                <div id="dropdownHover3"
                    class="z-10 bg-greyWhite divide-y divide-gray-100 rounded-xl shadow w-fit hidden px-2">
                    <article class="flex">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton3">
                            <li>
                                <a href="category.php?l=german"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">German</a>
                            </li>
                            <li>
                                <a href="category.php?l=english"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">English</a>
                            </li>
                            <li>
                                <a href="category.php?l=arabic"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Arabic</a>
                            </li>
                            <li>
                                <a href="category.php?l=bulgarian"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Bulgarian</a>
                            </li>
                            <li>
                                <a href="category.php?l=korean"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Korean</a>
                            </li>
                            <li>
                                <a href="category.php?l=danish"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Danish</a>
                            </li>
                            <li>
                                <a href="category.php?l=spanish"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Spanish</a>
                            </li>
                            <li>
                                <a href="category.php?l=finnish"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Finnish</a>
                            </li>
                            <li>
                                <a href="category.php?l=flemish"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Flemish</a>
                            </li>
                        </ul>
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton3">
                            <li>
                                <a href="category.php?l=filipino"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Filipino</a>
                            </li>
                            <li>
                                <a href="category.php?l=french"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">French</a>
                            </li>
                            <li>
                                <a href="category.php?l=hindi"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Hindi</a>
                            </li>
                            <li>
                                <a href="category.php?l=indonesian"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Indonesian</a>
                            </li>
                            <li>
                                <a href="category.php?l=italian"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Italian</a>
                            </li>
                            <li>
                                <a href="category.php?l=japanese"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Japanese</a>
                            </li>
                            <li>
                                <a href="category.php?l=malayalam"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Malayalam</a>
                            </li>
                            <li>
                                <a href="category.php?l=mandarin"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Mandarin</a>
                            </li>
                            <li>
                                <a href="category.php?l=dutch"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Dutch</a>
                            </li>
                        </ul>
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton3">
                            <li>
                                <a href="category.php?l=norwegian"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Norwegian</a>
                            </li>
                            <li>
                                <a href="category.php?l=polish"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Polish</a>
                            </li>
                            <li>
                                <a href="category.php?l=portuguese"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Portuguese</a>
                            </li>
                            <li>
                                <a href="category.php?l=romanian"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Romanian</a>
                            </li>
                            <li>
                                <a href="category.php?l=swedish"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Swedish</a>
                            </li>
                            <li>
                                <a href="category.php?l=tamil"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Tamil</a>
                            </li>
                            <li>
                                <a href="category.php?l=telugu"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Telugu</a>
                            </li>
                            <li>
                                <a href="category.php?l=thai"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Thai</a>
                            </li>
                            <li>
                                <a href="category.php?l=turkish"
                                    class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Turkish</a>
                            </li>
                        </ul>
                    </article>
                </div>
            </li>
            <li class="desktop-nav flex items-center">
                <!-- <img src="image/Search_Icon.svg" alt="Search Icon" class="mr-4 block"> -->
                <article class="zone-search flex">
                    <div>
                        <form class="">
                    </div>
                    <button type="submit" class="py-2.5 me-2 text-sm font-medium text-white rounded-lg ">
                        <img src="image/Search_Icon.svg" alt="Search Icon">
                    </button>
                    </div>
                    <div class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <button id="dropdown-button-2" class="z-10 inline-flex items-center sm:py-2.5 sm:px-4  px-1 text-sm font-medium sm:h-[50px] h-[20px] text-gray-500 bg-gray-50 border border-gray-300 rounded-s-lg hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white dark:border-gray-600 focus:ring-pastelBlue focus:ring-2 rounded-l-full border-r-0" type="button">
                            <span id="selected-item" class="sm:text-base text-sm w-20">Movie</span> <!-- Span to show selected item -->
                            <svg class="w-2.5 h-2.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <!-- Dropdown for filter -->
                        <div id="dropdown-search-city" class="absolute z-10 mt-40 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button-2">
                                <li>
                                    <a href="#" class="dropdown-item inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-black" role="menuitem">
                                        Movie
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-black" role="menuitem">
                                        Tv Series
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="relative sm:w-full sm:h-[50px] h-[20px] w-[120px] mr-3 ">
                            <input type="text" id="livesearch" autocomplete="off" class="bg-gray-50 text-gray-900 text-md rounded-r-full  block w-full h-full py-3 px-4  dark:bg-gray-700 border-l-0 dark:placeholder-gray-400 dark:text-white focus:ring-pastelBlue focus:ring-2" placeholder="Search ..." required />

                            <!-- showing results resieved from search -->
                            <div id="livesearch_dropdown" class="z-10 mt-1 hidden absolute bg-white divide-y divide-gray-100 rounded-lg shadow w-full dark:bg-gray-700">
                                <ul id="livesearch_ul" class="py-2 text-sm text-gray-700 dark:text-gray-200 max-h-80 overflow-y-scroll" aria-labelledby="dropdown-button-2">
                                    <!-- will come from js -->
                                </ul>
                            </div>

                        </div>
                    </div>
                    </form>
                    </div>
                </article>

                <!-- 120px<img src="image/avatar-01.png" alt="avatar users" class="mr-2.5">
                <img src="image/icon_arrow-down.svg" alt="arrow down"> -->
                <?php
                if ($authenticated) {
                    // echo $user_id;
                    $query = 'SELECT username, fullname, email, avatar FROM users  WHERE user_id = :id;';
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":id", $user_id);
                    $stmt->execute();
                    $user_result = $stmt->fetch(PDO::FETCH_OBJ);

                    $user_data_username = $user_result->username;
                    $user_data_email = $user_result->email;
                    $user_data_avatar = $user_result->avatar;
                ?>
                    <article class="user-profil sm:w-[50px] sm:h-[50px] h-[30px] w-[30px] sm:ml-4 ml-3 shrink-0">
                        <!-- button, login -->
                        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                                data-dropdown-placement="bottom">
                                <span class="sr-only">Open user menu</span>
                                <img class="sm:w-[50px] sm:h-[50px] h-[30px] w-[30px] rounded-full shrink-0"
                                    src="<?php echo htmlspecialchars($avatar_directory . $_SESSION['avatar']); ?>"
                                    alt="user avatar">
                            </button>
                            <!-- Dropdown menu -->
                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                                id="user-dropdown">
                                <div class="px-4 py-3">
                                    <span class="block text-sm text-gray-900 dark:text-white">
                                        <?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                                    <span
                                        class="block text-sm  text-gray-500 truncate dark:text-gray-400"><?php echo $_SESSION['email']; ?></span>
                                </div>
                                <ul class="py-2" aria-labelledby="user-menu-button">
                                    <li>
                                        <a href="profile.php"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                                    </li>
                                    <li class="<?php echo (basename((!isset($_SESSION['autority']) || $_SESSION['autority'] !== 1))) ? 'hidden' : 'block'; ?>">
                                        <a href="admin.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Admin</a>
                                    </li>
                                    <li>
                                        <a href="login.php"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Login</a>
                                    </li>
                                    <li>
                                        <a href="logout.php"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Logout</a>
                                    </li>
                                    <!-- <li>
                                    <a href="sign-out.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign-out</a>
                                </li> -->
                                </ul>
                            </div>
                        </div>
                    </article>
                <?php
                } else {
                ?>
                    <a href="sign-up.php"
                        class="mr-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'sign-up.php') ? 'text-pastelBlue' : 'text-white'; ?>">Sign-up</a>
                    <a href="login.php"
                        class="mr-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'login.php') ? 'text-pastelBlue' : 'text-white'; ?>">Login</a>
            </li>
        <?php   }  ?>
        <!-- menu pour mobile -->
        <article class="menu-icon sm:hidden flex items-center h-[38px] w-[38px] pl-2 py-2">
            <button id="multiLevelDropdownButton" data-dropdown-toggle="multi-dropdown"
                class="w-full h-full  focus:ring-2 focus:outline-none focus:ring-gray-300 rounded-xl inline-flex items-center leading-none"
                type="button"><img src="image/menu_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="menu-icon"
                    class="w-7" fill="none" viewBox="0 0 10 6" aria-hidden="true">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </button>
            <div id="multi-dropdown"
                class="z-10 bg-greyWhite divide-y divide-gray-100 rounded-xl shadow w-fit hidden px-2">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="doubleDropdownButton">
                    <li class="block"><a href="index.php"
                            class="mr-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'text-pastelBlue' : 'text-halfBlack'; ?> hover:bg-gray-300 hover:px-2 hover:py-1">Home</a>
                    </li>
                    <li class="block"><a href="category.php?movies"
                            class="mr-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'category.php' && isset($_GET['movies'])) ? 'text-pastelBlue' : 'text-halfBlack'; ?>">Movie</a>
                    </li>
                    <li class="block"><a href="category.php?series"
                            class="mr-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'category.php' && isset($_GET['series'])) ? 'text-pastelBlue' : 'text-halfBlack'; ?>">Tv
                            Shows</a></li>
                    <li class="block">
                        <button id="doubleDropdownButton1" data-dropdown-toggle="doubleDropdown1"
                            data-dropdown-placement="bottom"
                            class="<?php echo (basename($_SERVER['PHP_SELF']) == 'category.php' && isset($_GET['country'])) ? 'text-pastelBlue' : 'text-halfBlock'; ?> focus:ring-2 focus:outline-none focus:ring-gray-300 rounded-xl mr-4 inline-flex items-center leading-none h-[20px]"
                            type="button">Country<svg class="w-2.5 h-2.5 ml-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4"></path>
                            </svg>
                        </button>
                        <div id="doubleDropdown1"
                            class="z-10 bg-greyWhite divide-y divide-gray-100 rounded-xl shadow w-fit hidden px-2">
                            <article class=" flex">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton1">
                                    <li>
                                        <a href="category.php?c=argentina"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Argentina</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=australia"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Australia</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=austria"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Austria</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=belgium"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Belgium</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=brazil"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Brazil</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=canada"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Canada</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=china"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">China</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=czech_republic"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Czech
                                            Republic</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=denmark"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Denmark</a>
                                    </li>
                                </ul>
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton1">
                                    <li>
                                        <a href="category.php?c=finland"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Finland</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=france"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">France</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=germany"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Germany</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=hong_kong"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Hong
                                            Kong</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=hungary"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Hungary</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=india"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">India</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=ireland"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Ireland</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=israel"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Israel</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=italy"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Italy</a>
                                    </li>
                                </ul>
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton1">
                                    <li>
                                        <a href="category.php?c=japan"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Japan</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=luxembourg"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Luxembourg</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=mexico"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Mexico</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=netherlands"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Netherlands</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=new_zealand"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">New
                                            Zealand</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=norway"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Norway</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=poland"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Poland</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=romania"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Romania</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=russia"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Russia</a>
                                    </li>
                                </ul>
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton1">
                                    <li>
                                        <a href="category.php?c=south_africa"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">South
                                            Africa</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=south_korea"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">South
                                            Korea</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=spain"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Spain</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=sweden"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Sweden</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=switzerland"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Switzerland</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=taiwan"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Taiwan</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=thailand"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Thailand</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=united_kingdom"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">United
                                            Kingdom</a>
                                    </li>
                                    <li>
                                        <a href="category.php?c=United+States+of+America"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">USA</a>
                                    </li>
                                </ul>
                            </article>
                        </div>
                    </li>
                    <li class="hover:bg-gray-300 hover:px-2 hover:py-1 rounded-xl">
                        <button id="doubleDropdownButton2" data-dropdown-toggle="doubleDropdown2"
                            data-dropdown-placement="bottom"
                            class="<?php echo (basename($_SERVER['PHP_SELF']) == 'category.php' && isset($_GET['language'])) ? 'text-pastelBlue' : 'text-halfBlack'; ?> focus:ring-2 focus:outline-none focus:ring-gray-300 rounded-xl mr-4 inline-flex items-center leading-none h-[20px]"
                            type="button">Browse by lunguage<svg class="w-2.5 h-2.5 ml-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4"></path>
                            </svg>
                        </button>
                        <div id="doubleDropdown2"
                            class="z-10 bg-greyWhite divide-y divide-gray-100 rounded-xl shadow w-fit hidden px-2">
                            <article class="flex">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton3">
                                    <li>
                                        <a href="category.php?l=german"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">German</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=english"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">English</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=arabic"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Arabic</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=bulgarian"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Bulgarian</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=korean"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Korean</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=danish"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Danish</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=spanish"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Spanish</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=finnish"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Finnish</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=flemish"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Flemish</a>
                                    </li>
                                </ul>
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton3">
                                    <li>
                                        <a href="category.php?l=filipino"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Filipino</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=french"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">French</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=hindi"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Hindi</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=indonesian"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Indonesian</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=italian"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Italian</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=japanese"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Japanese</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=malayalam"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Malayalam</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=mandarin"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Mandarin</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=dutch"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Dutch</a>
                                    </li>
                                </ul>
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton3">
                                    <li>
                                        <a href="category.php?l=norwegian"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Norwegian</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=polish"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Polish</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=portuguese"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Portuguese</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=romanian"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Romanian</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=swedish"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Swedish</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=tamil"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Tamil</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=telugu"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Telugu</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=thai"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Thai</a>
                                    </li>
                                    <li>
                                        <a href="category.php?l=turkish"
                                            class="block px-4 py-2 hover:bg-coloHover hover:px-4 hover:py-2 rounded-xl">Turkish</a>
                                    </li>
                                </ul>
                            </article>
                        </div>
                    </li>
                </ul>
        </article>
        </li>
        </ul>
    </nav>
</header>