<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./output.css">
  <title>Category</title>
</head>

<body class="bg-halfBlack h-screen w-screen">
  <?php include_once("./header.php");
  $query = '';
  $url_get = '';
  if (isset($_GET['topmovies'])) {
    $url_get = 'topmovies';
    $getdata = 'movies';
    $query = "SELECT movieapi_id AS id, poster_path FROM $getdata WHERE imdb_vote > 7";
  } elseif (isset($_GET['topseries'])) {
    $url_get = 'topseries';
    $getdata = "tv_series";
    $query = "SELECT tvapi_id AS id, poster_path FROM $getdata WHERE imdb_vote > 7";
  } elseif (isset($_GET['movies'])) {
    $url_get = 'movies';
    $getdata = 'movies';
    $query = "SELECT movieapi_id AS id, poster_path FROM $getdata";
  } elseif (isset($_GET['series'])) {
    $url_get = 'series';
    $getdata = "tv_series";
    $query = "SELECT tvapi_id AS id, poster_path FROM $getdata";
  }

  $whereClause = '';
  if (isset($_GET['g'])) {
    $genre = $_GET['g']; // Correctly assign the genre value
    $whereClause = ' WHERE genres LIKE :genre';
  }

  // Append the where clause if necessary
  if (!empty($whereClause)) {
    $query .= $whereClause;
  }

  $dbConnection = getDatabaseConnection();
  $p_query = $dbConnection->prepare($query);

  if (isset($_GET['g'])) {
    $p_query->execute([':genre' => '%' . $genre . '%']);
  } else {
    $p_query->execute();
  }

  $result = $p_query->fetchAll(PDO::FETCH_ASSOC);

  ?>
  <section class="container w-full mx-auto mt-[75px] mb-14">
    <article class="flex items-center justify-between mb-14">
      <h1 name="name-category" class=" text-pastelBlue text-[56px] font-[570] uppercase leading-none">Movies</h1>
      <section class="<?php echo (basename($_SERVER['PHP_SELF']) == 'category.php' && (isset($_GET['language']) or isset($_GET['country']))) ? 'hidden' : 'block'; ?>">
        <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'category.php' && isset($_GET['genre'])) ? 'text-pastelBlue' : 'text-white'; ?> focus:ring-2 focus:outline-none focus:ring-gray-300 rounded-xl mr-4 inline-flex items-center leading-none h-[20px]" type="button">Genre<svg class="w-2.5 h-2.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"></path>
          </svg>
        </button>
        <div id="dropdownHover" class="z-10 bg-greyWhite divide-y divide-gray-100 rounded-xl shadow w-fit hidden px-2">
          <article class="flex">
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
              <li>
                <a href="?<?php echo $url_get; ?>&g=action" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Action</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=adventure" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Adventure</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=animation" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Animation</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=biography" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Biography</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=comedy" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Comedy</a>
              </li>
            </ul>
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
              <li>
                <a href="?<?php echo $url_get; ?>&g=crime" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Crime</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=documentary" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Documentary</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=drama" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Drama</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=family" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Family</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=fantasy" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Fantasy</a>
              </li>
            </ul>
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
              <li>
                <a href="?<?php echo $url_get; ?>&g=horror" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Horror</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=history" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">History</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=musical" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Musical</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=mystery" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Mystery</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=romance" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Romance</a>
              </li>
            </ul>
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownHoverButton">
              <li>
                <a href="?<?php echo $url_get; ?>&g=sci-Fi" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Sci-Fi</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=sport" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Sport</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=thriller" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Thriller</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=war" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">War</a>
              </li>
              <li>
                <a href="?<?php echo $url_get; ?>&g=western" class="block px-4 py-2 hover:bg-gray-300 hover:px-4 hover:py-2 rounded-xl">Western</a>
              </li>
            </ul>
          </article>
        </div>
      </section>
    </article>
    <article class="w-full grid grid-cols-[288.74px_288.74px_288.74px_288.74px_288.74px] grid-flow-row auto-rows-[388px] gap-6">
      <?php
      foreach ($result as $row) { ?>
        <a class="bg-gray-500 rounded-xl" href="program-detail.php?id=<?php echo $row['id']; ?>" name="img-cat_07">
          <img class="rounded-xl w-[288.74px] h-[388px]" src="http://image.tmdb.org/t/p/w500/<?php echo $row["poster_path"]; ?>" alt="poster">
        </a>
      <?php } ?>

      <!-- <div class="bg-gray-500 rounded-xl" name="img-cat_08"></div> -->
      <!-- <div class="bg-gray-500 rounded-xl" name="img-cat_09"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_10"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_11"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_12"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_13"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_14"></div>
      <div class="col-span-2 bg-gray-500 rounded-xl" name="img-cat_15"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_16"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_17"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_18"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_19"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_20"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_21"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_22"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_23"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_24"></div>
      <div class="bg-gray-500 rounded-xl" name="img-cat_25"></div> -->
    </article>
  </section>
  <?php include_once("./footer.php"); ?>
  <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>