<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Initialize the session
// if (session_status() == PHP_SESSION_NONE) {
//   session_start();

include_once "dbh.inc.php";

$authenticated = false;
if (isset($_SESSION["email"]) && (session_status() == PHP_SESSION_NONE)) {
    $authenticated = true;
}

// Define the avatar directory
$avatar_directory = "image/avatar_directory/";

?>
<header class="w-[80%] sm:container mx-auto h-[88.6px] sm:h-[110px]">
    <nav class="h-full w-full">
        <ul class="list-none h-full flex justify-between items-center">
            <li class="sm:hidden flex"><a href="index.php"><img src="image/GETFLIX_logo.svg" alt="GetFlix Logo"
                        class="sm:h-[30px] h-[18px] sm:mr-[73px] mr-0"></a></li>
            <li class="sm:flex hidden"><a href="index.php"><img src="image/GETFLIX_logo.svg" alt="GetFlix Logo"
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
                                <a href="category.php?argentina"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Argentina</a>
                            </li>
                            <li>
                                <a href="category.php?australia"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Australia</a>
                            </li>
                            <li>
                                <a href="category.php?austria"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Austria</a>
                            </li>
                            <li>
                                <a href="category.php?belgium"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Belgium</a>
                            </li>
                            <li>
                                <a href="category.php?brazil"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Brazil</a>
                            </li>
                            <li>
                                <a href="category.php?canada"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Canada</a>
                            </li>
                            <li>
                                <a href="category.php?china"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">China</a>
                            </li>
                            <li>
                                <a href="category.php?czech_republic"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Czech
                                    Republic</a>
                            </li>
                            <li>
                                <a href="category.php?denmark"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Denmark</a>
                            </li>
                        </ul>
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton1">
                            <li>
                                <a href="category.php?finland"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Finland</a>
                            </li>
                            <li>
                                <a href="category.php?france"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">France</a>
                            </li>
                            <li>
                                <a href="category.php?germany"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Germany</a>
                            </li>
                            <li>
                                <a href="category.php?hong_kong"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Hong
                                    Kong</a>
                            </li>
                            <li>
                                <a href="category.php?hungary"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Hungary</a>
                            </li>
                            <li>
                                <a href="category.php?india"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">India</a>
                            </li>
                            <li>
                                <a href="category.php?ireland"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Ireland</a>
                            </li>
                            <li>
                                <a href="category.php?israel"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Israel</a>
                            </li>
                            <li>
                                <a href="category.php?italy"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Italy</a>
                            </li>
                        </ul>
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton1">
                            <li>
                                <a href="category.php?japan"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Japan</a>
                            </li>
                            <li>
                                <a href="category.php?luxembourg"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Luxembourg</a>
                            </li>
                            <li>
                                <a href="category.php?mexico"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Mexico</a>
                            </li>
                            <li>
                                <a href="category.php?netherlands"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Netherlands</a>
                            </li>
                            <li>
                                <a href="category.php?new_zealand"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">New
                                    Zealand</a>
                            </li>
                            <li>
                                <a href="category.php?norway"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Norway</a>
                            </li>
                            <li>
                                <a href="category.php?poland"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Poland</a>
                            </li>
                            <li>
                                <a href="category.php?romania"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Romania</a>
                            </li>
                            <li>
                                <a href="category.php?russia"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Russia</a>
                            </li>
                        </ul>
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton1">
                            <li>
                                <a href="category.php?south_africa"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">South
                                    Africa</a>
                            </li>
                            <li>
                                <a href="category.php?south_korea"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">South
                                    Korea</a>
                            </li>
                            <li>
                                <a href="category.php?spain"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Spain</a>
                            </li>
                            <li>
                                <a href="category.php?sweden"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Sweden</a>
                            </li>
                            <li>
                                <a href="category.php?switzerland"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Switzerland</a>
                            </li>
                            <li>
                                <a href="category.php?taiwan"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Taiwan</a>
                            </li>
                            <li>
                                <a href="category.php?thailand"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Thailand</a>
                            </li>
                            <li>
                                <a href="category.php?united_kingdom"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">United
                                    Kingdom</a>
                            </li>
                            <li>
                                <a href="category.php?usa"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">USA</a>
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
                                <a href="category.php?german"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">German</a>
                            </li>
                            <li>
                                <a href="category.php?english"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">English</a>
                            </li>
                            <li>
                                <a href="category.php?arabic"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Arabic</a>
                            </li>
                            <li>
                                <a href="category.php?bulgarian"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Bulgarian</a>
                            </li>
                            <li>
                                <a href="category.php?korean"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Korean</a>
                            </li>
                            <li>
                                <a href="category.php?danish"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Danish</a>
                            </li>
                            <li>
                                <a href="category.php?spanish"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Spanish</a>
                            </li>
                            <li>
                                <a href="category.php?finnish"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Finnish</a>
                            </li>
                            <li>
                                <a href="category.php?flemish"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Flemish</a>
                            </li>
                        </ul>
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton3">
                            <li>
                                <a href="category.php?filipino"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Filipino</a>
                            </li>
                            <li>
                                <a href="category.php?french"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">French</a>
                            </li>
                            <li>
                                <a href="category.php?hindi"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Hindi</a>
                            </li>
                            <li>
                                <a href="category.php?indonesian"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Indonesian</a>
                            </li>
                            <li>
                                <a href="category.php?italian"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Italian</a>
                            </li>
                            <li>
                                <a href="category.php?japanese"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Japanese</a>
                            </li>
                            <li>
                                <a href="category.php?malayalam"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Malayalam</a>
                            </li>
                            <li>
                                <a href="category.php?mandarin"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Mandarin</a>
                            </li>
                            <li>
                                <a href="category.php?dutch"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Dutch</a>
                            </li>
                        </ul>
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton3">
                            <li>
                                <a href="category.php?norwegian"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Norwegian</a>
                            </li>
                            <li>
                                <a href="category.php?polish"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Polish</a>
                            </li>
                            <li>
                                <a href="category.php?portuguese"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Portuguese</a>
                            </li>
                            <li>
                                <a href="category.php?romanian"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Romanian</a>
                            </li>
                            <li>
                                <a href="category.php?swedish"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Swedish</a>
                            </li>
                            <li>
                                <a href="category.php?tamil"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Tamil</a>
                            </li>
                            <li>
                                <a href="category.php?telugu"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Telugu</a>
                            </li>
                            <li>
                                <a href="category.php?thai"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Thai</a>
                            </li>
                            <li>
                                <a href="category.php?turkish"
                                    class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Turkish</a>
                            </li>
                        </ul>
                    </article>
                </div>
            </li>
            <li class="mobile-nav sm:flex hidden">
                <img src="image/Search_Icon.svg" alt="Search Icon" class="mr-4 sm:block hidden">
                <!-- 120px<img src="image/avatar-01.png" alt="avatar users" class="mr-2.5">
            <img src="image/icon_arrow-down.svg" alt="arrow down"> -->
                <?php
          if ($authenticated){                              
          ?>
                <article>
                    <!-- button, login -->
                    <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                        <button type="button"
                            class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                            data-dropdown-placement="bottom">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full"
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
                                    class="block text-sm  text-gray-500 truncate dark:text-gray-400"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                            </div>
                            <ul class="py-2" aria-labelledby="user-menu-button">
                                <li>
                                    <a href="profile.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                                </li>
                                <li>
                                    <a href="login.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Login</a>
                                </li>
                                <li>
                                    <a href="logout.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Logout</a>
                                </li>
                                <li>
                                    <a href="sign-out.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign-out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php
              }  else {
              ?>
                    <a href="sign-up.php"
                        class="mr-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'sign-up.php') ? 'text-pastelBlue' : 'text-white'; ?>">Sign-up</a>
                    <a href="login.php"
                        class="mr-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'login.php') ? 'text-pastelBlue' : 'text-white'; ?>">Login</a>
            </li>
            <?php   }  ?>
            </article>
            <!-- menu pour mobile -->
            <article class="sm:hidden flex items-center">
                <img src="image/Search_Icon.svg" alt="Search Icon" class="mr-4">
                <button id="multiLevelDropdownButton" data-dropdown-toggle="multi-dropdown"
                    class="p-2 focus:ring-2 focus:outline-none focus:ring-gray-300 rounded-xl mr-4 inline-flex items-center leading-none h-[20px]"
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
                                <article class="flex">
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="doubleDropdownButton1">
                                        <li>
                                            <a href="category.php?argentina"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Argentina</a>
                                        </li>
                                        <li>
                                            <a href="category.php?australia"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Australia</a>
                                        </li>
                                        <li>
                                            <a href="category.php?austria"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Austria</a>
                                        </li>
                                        <li>
                                            <a href="category.php?belgium"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Belgium</a>
                                        </li>
                                        <li>
                                            <a href="category.php?brazil"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Brazil</a>
                                        </li>
                                        <li>
                                            <a href="category.php?canada"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Canada</a>
                                        </li>
                                        <li>
                                            <a href="category.php?china"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">China</a>
                                        </li>
                                        <li>
                                            <a href="category.php?czech_republic"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Czech
                                                Republic</a>
                                        </li>
                                        <li>
                                            <a href="category.php?denmark"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Denmark</a>
                                        </li>
                                    </ul>
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="doubleDropdownButton1">
                                        <li>
                                            <a href="category.php?finland"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Finland</a>
                                        </li>
                                        <li>
                                            <a href="category.php?france"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">France</a>
                                        </li>
                                        <li>
                                            <a href="category.php?germany"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Germany</a>
                                        </li>
                                        <li>
                                            <a href="category.php?hong_kong"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Hong
                                                Kong</a>
                                        </li>
                                        <li>
                                            <a href="category.php?hungary"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Hungary</a>
                                        </li>
                                        <li>
                                            <a href="category.php?india"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">India</a>
                                        </li>
                                        <li>
                                            <a href="category.php?ireland"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Ireland</a>
                                        </li>
                                        <li>
                                            <a href="category.php?israel"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Israel</a>
                                        </li>
                                        <li>
                                            <a href="category.php?italy"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Italy</a>
                                        </li>
                                    </ul>
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="doubleDropdownButton1">
                                        <li>
                                            <a href="category.php?japan"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Japan</a>
                                        </li>
                                        <li>
                                            <a href="category.php?luxembourg"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Luxembourg</a>
                                        </li>
                                        <li>
                                            <a href="category.php?mexico"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Mexico</a>
                                        </li>
                                        <li>
                                            <a href="category.php?netherlands"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Netherlands</a>
                                        </li>
                                        <li>
                                            <a href="category.php?new_zealand"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">New
                                                Zealand</a>
                                        </li>
                                        <li>
                                            <a href="category.php?norway"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Norway</a>
                                        </li>
                                        <li>
                                            <a href="category.php?poland"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Poland</a>
                                        </li>
                                        <li>
                                            <a href="category.php?romania"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Romania</a>
                                        </li>
                                        <li>
                                            <a href="category.php?russia"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Russia</a>
                                        </li>
                                    </ul>
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="doubleDropdownButton1">
                                        <li>
                                            <a href="category.php?south_africa"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">South
                                                Africa</a>
                                        </li>
                                        <li>
                                            <a href="category.php?south_korea"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">South
                                                Korea</a>
                                        </li>
                                        <li>
                                            <a href="category.php?spain"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Spain</a>
                                        </li>
                                        <li>
                                            <a href="category.php?sweden"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Sweden</a>
                                        </li>
                                        <li>
                                            <a href="category.php?switzerland"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Switzerland</a>
                                        </li>
                                        <li>
                                            <a href="category.php?taiwan"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Taiwan</a>
                                        </li>
                                        <li>
                                            <a href="category.php?thailand"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Thailand</a>
                                        </li>
                                        <li>
                                            <a href="category.php?united_kingdom"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">United
                                                Kingdom</a>
                                        </li>
                                        <li>
                                            <a href="category.php?usa"
                                                class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">USA</a>
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
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="doubleDropdownButton2">
                                        <li class="hover:bg-gray-300 hover:px-2 hover:py-1 rounded-xl">
                                            <a href="category.php?german"
                                                class="block px-4 py-2 hover:px-4 hover:py-2 hover:bg-gray-300 rounded-xl">German</a>
                                        </li>
                                        <li>
                                            <a href="category.php?english"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">English</a>
                                        </li>
                                        <li>
                                            <a href="category.php?arabic"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Arabic</a>
                                        </li>
                                        <li>
                                            <a href="category.php?bulgarian"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Bulgarian</a>
                                        </li>
                                        <li>
                                            <a href="category.php?korean"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Korean</a>
                                        </li>
                                        <li>
                                            <a href="category.php?danish"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Danish</a>
                                        </li>
                                        <li>
                                            <a href="category.php?spanish"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Spanish</a>
                                        </li>
                                        <li>
                                            <a href="category.php?finnish"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Finnish</a>
                                        </li>
                                        <li>
                                            <a href="category.php?flemish"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Flemish</a>
                                        </li>
                                    </ul>
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="doubleDropdownButton2">
                                        <li>
                                            <a href="category.php?filipino"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Filipino</a>
                                        </li>
                                        <li>
                                            <a href="category.php?french"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">French</a>
                                        </li>
                                        <li>
                                            <a href="category.php?hindi"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Hindi</a>
                                        </li>
                                        <li>
                                            <a href="category.php?indonesian"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Indonesian</a>
                                        </li>
                                        <li>
                                            <a href="category.php?italian"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Italian</a>
                                        </li>
                                        <li>
                                            <a href="category.php?japanese"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Japanese</a>
                                        </li>
                                        <li>
                                            <a href="category.php?malayalam"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Malayalam</a>
                                        </li>
                                        <li>
                                            <a href="category.php?mandarin"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Mandarin</a>
                                        </li>
                                        <li>
                                            <a href="category.php?dutch"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Dutch</a>
                                        </li>
                                    </ul>
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="doubleDropdownButton2">
                                        <li>
                                            <a href="category.php?norwegian"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Norwegian</a>
                                        </li>
                                        <li>
                                            <a href="category.php?polish"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Polish</a>
                                        </li>
                                        <li>
                                            <a href="category.php?portuguese"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Portuguese</a>
                                        </li>
                                        <li>
                                            <a href="category.php?romanian"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Romanian</a>
                                        </li>
                                        <li>
                                            <a href="category.php?swedish"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Swedish</a>
                                        </li>
                                        <li>
                                            <a href="category.php?tamil"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Tamil</a>
                                        </li>
                                        <li>
                                            <a href="category.php?telugu"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Telugu</a>
                                        </li>
                                        <li>
                                            <a href="category.php?thai"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Thai</a>
                                        </li>
                                        <li>
                                            <a href="category.php?turkish"
                                                class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Turkish</a>
                                        </li>
                                    </ul>
                                </article>
                            </div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <?php
                            if ($authenticated){                              
                          ?>
                            <div
                                class="sm:flex hidden items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                                <button type="button"
                                    class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                    id="user-menu-button1" aria-expanded="false" data-dropdown-toggle="user-dropdown1"
                                    data-dropdown-placement="bottom">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="w-8 h-8 rounded-full"
                                        src="<?php echo htmlspecialchars($avatar_directory . $_SESSION['avatar']); ?>"
                                        alt="user avatar">
                                </button>
                                <!-- Dropdown menu -->
                                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                                    id="user-dropdown1">
                                    <div class="px-4 py-3">
                                        <span class="block text-sm text-gray-900 dark:text-white">
                                            <?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                                        <span
                                            class="block text-sm  text-gray-500 truncate dark:text-gray-400"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                                    </div>
                                    <ul class="py-2" aria-labelledby="user-menu-button">
                                        <li>
                                            <a href="profile.php"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:coloHover hover:px-4 hover:py-2 rounded-xl dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                                        </li>
                                        <li>
                                            <a href="login.php"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:coloHover hover:px-4 hover:py-2 rounded-xl dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Login</a>
                                        </li>
                                        <li>
                                            <a href="logout.php"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:coloHover hover:px-4 hover:py-2 rounded-xl dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Logout</a>
                                        </li>
                                        <li>
                                            <a href="sign-out.php"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:coloHover hover:px-4 hover:py-2 rounded-xl dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign-out</a>
                                        </li>
                                    </ul>
                                </div>

                                <?php
                        }  else {
                        ?>
                        <li class="border-t-2 border-gray-700"><a href="sign-up.php"
                                class="mr-4 text-sm <?php echo (basename($_SERVER['PHP_SELF']) == 'sign-up.php') ? 'text-pastelBlue' : 'text-halfBlack'; ?>">Sign-up</a>
                        </li>
                        <li class="mb-2"><a href="login.php"
                                class="mr-4 text-sm <?php echo (basename($_SERVER['PHP_SELF']) == 'login.php') ? 'text-pastelBlue' : 'text-halfBlack'; ?>">Login</a>
                        </li>
                        <?php   }  ?>
                        </li>
                    </ul>
                </div>
            </article>
            </li>
        </ul>
    </nav>
</header>