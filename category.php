<!DOCTYPE html>
<html lang="en" class="h-screen w-screen">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./output.css">
  <title>Category</title>
</head>
<body class="bg-halfBlack sm:w-screen w-full h-fit">
  <?php include_once("./header.php");?>
  <section class="w-[80%] sm:container mx-auto h-fit">
    <article class="flex items-center justify-between mb-14">
      <h1 name="name-category" class=" text-pastelBlue text-[50px] sm:text-[56px] font-[570] uppercase leading-none">Movies</h1>
      <section class="<?php echo (basename($_SERVER['PHP_SELF']) == 'category.php' && (isset($_GET['language']) or isset($_GET['country']))) ? 'hidden' : 'block'; ?>">
        <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'category.php' && isset($_GET['genre'])) ? 'text-pastelBlue' : 'text-white'; ?> focus:ring-2 focus:outline-none focus:ring-gray-300 rounded-xl mr-4 inline-flex items-center leading-none h-[20px] sm:text-base text-sm" type="button">Genre<svg class="w-2.5 h-2.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"></path>
        </svg>
        </button>
        <div id="dropdownHover" class="z-10 bg-greyWhite divide-y divide-gray-100 rounded-xl shadow w-fit hidden px-2">
          <article class="flex">
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Action</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Adventure</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Animation</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Biography</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Comedy</a>
              </li>
            </ul>
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Crime</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Documentary</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Drama</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Family</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Fantasy</a>
              </li>
            </ul>
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Horror</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">History</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Musical</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Mystery</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Romance</a>
              </li>
            </ul>
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Sci-Fi</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Sport</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Thriller</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">War</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:coloHover hover:px-4 hover:py-2 rounded-xl">Western</a>
              </li>
            </ul>
          </article>
        </div>
      </section>
    </article>
    <article class="w-full grid-cols-2 grid sm:grid-cols-[288.74px_288.74px_288.74px_288.74px_288.74px] grid-flow-row auto-rows-[202.8px] sm:auto-rows-[388px] sm:gap-6 gap-3 sm:mb-14 mb-[39px]">
      <div class="bg-gray-500 rounded-xl" name="img-cat_01"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_02"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_03"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_04"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_05"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_06"></div>
      <div class="col-span-2 bg-gray-500 rounded-xl" name="img-cat_07"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_08"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_09"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_10"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_11"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_12"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_13"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_14"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_16"></div>
      <div class="col-span-2 bg-gray-500 rounded-xl" name="img-cat_15"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_17"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_18"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_19"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_20"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_21"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_22"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_23"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_24"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_25"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_26"></div>
    </article>
  </section>
  <?php include_once("./footer.php");?>
  <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>