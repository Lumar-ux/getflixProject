<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = 'getflixdb';

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "DB Connected successfully";
}catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>

<header class="container mx-auto w-full h-[110px]">
    <nav class="h-full w-full">
      <ul class="list-none h-full flex justify-between items-center">
        <article class="flex">
          <img src="image/GETFLIX_logo.svg" alt="GetFlix Logo" class="mr-[73px]">
          <li><a href="index.php" class="mr-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'text-pastelBlue' : 'text-white'; ?>">Home</a></li>
          <li><a id="dropdownDefaultButton" data-dropdown-toggle="dropdown" href="#" class="mr-4 <?= basename($_SERVER['PHP_SELF']) == 'category.php' ? 'text-pastelBlue' : 'text-white' ?>">Genre</a></li>

          <div id="dropdown" class="z-10 ml-32 hidden  left-72  absolute bg-white divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <li>
                  <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a>
                </li>
              </ul>
          </div>
        <!-- <div class="mt-2 bg-gray-800 rounded-lg absolute block py-2 w-72" id="dropdown"  aria-labelledby="dropdownDefaultButton">
              <a href="#" class="block px-4 py-2 text-gray-100 hover:bg-gray-700">Action</a>
              <a href="#" class="block px-4 py-2 text-gray-100 hover:bg-gray-700">Horrore</a>
              <a href="#" class="block px-4 py-2 text-gray-100 hover:bg-gray-700">Action</a>
              <a href="#" class="block px-4 py-2 text-gray-100 hover:bg-gray-700">Action</a>
          </div> -->
          <li><a href="category.php" class="mr-4 <?= basename($_SERVER['PHP_SELF']) == 'category.php' ? 'text-pastelBlue' : 'text-white' ?>">Tv Series</a></li>
          <li><a href="category.php" class="mr-4 <?= basename($_SERVER['PHP_SELF']) == 'category.php' ? 'text-pastelBlue' : 'text-white' ?>">Country</a></li>
          <li><a href="category.php" class="mr-4 <?= basename($_SERVER['PHP_SELF']) == 'category.php' ? 'text-pastelBlue' : 'text-white' ?>">Browse by language</a></li>
        </article>
        <article class="flex">
          <div class="mr-3">
              <form class="">   
                <div class="flex">
                  <label for="simple-search" class="sr-only">Search</label>
                  <button id="dropdown-button-2" data-dropdown-toggle="dropdown-search-city" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200  dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">
                        Select <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                      </svg>
                      </button>
                      <div id="dropdown-search-city" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                          <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button-2">
                              <li>
                                  <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-black" role="menuitem">
                                      <div class="inline-flex items-center">             
                                          Movie
                                      </div>
                                  </button>
                              </li>
                              <li>
                                  <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-black" role="menuitem">
                                      <div class="inline-flex items-center">
                                          Tv Series
                                      </div>
                                  </button>
                              </li>
                              <li>
                                  <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-black" role="menuitem">
                                      <div class="inline-flex items-center">
                                          Language
                                      </div>
                                  </button>
                              </li>
                              <li>
                                  <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-black" role="menuitem">
                                      <div class="inline-flex items-center">
                                          Country
                                      </div>
                                  </button>
                              </li>
                          </ul>
                      </div>
                  <div class="relative w-full">
                      <input type="text" id="livesearch" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg  block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"  placeholder="Search ..." required />
                  </div>
                  <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white rounded-lg ">
                  <img src="image/Search_Icon.svg" alt="Search Icon">
                  </button>
                  </div>
              </form>
          </div>        
       
          <img src="image/avatar-01.png" alt="avatar users" class="mr-2.5">
          <img src="image/icon_arrow-down.svg" alt="arrow down">
        </article>
      </ul>

    </nav>
  </header>