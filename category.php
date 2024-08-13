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
  $condition = '';

  //
  $conditionMovies = '';
  $conditionSeries = '';
  $language = '';
  //
  $h1_text = '';
  // Determine the base query and condition based on request
  if (isset($_GET['topmovies'])) {
    $h1_text = 'Movies';
    $url_get = 'topmovies';
    $query = "SELECT movieapi_id AS id, poster_path, 'movie' AS type FROM movies";
    $condition = " WHERE imdb_vote > 7";
  } elseif (isset($_GET['topseries'])) {
    $h1_text = 'TV Shows';
    $url_get = 'topseries';
    $query = "SELECT tvapi_id AS id, poster_path, 'tv_series' AS type FROM tv_series";
    $condition = " WHERE imdb_vote > 7";
  } elseif (isset($_GET['movies'])) {
    $h1_text = 'Movies';
    $url_get = 'movies';
    $query = "SELECT movieapi_id AS id, poster_path, 'movie' AS type FROM movies";
  } elseif (isset($_GET['series'])) {
    $url_get = 'series';
    $query = "SELECT tvapi_id AS id, poster_path, 'tv_series' AS type FROM tv_series";
  } {
    // Default behavior if no specific request
    $query = "SELECT movieapi_id AS id, poster_path, 'movie' AS type FROM movies";
    $query .= " UNION ALL SELECT tvapi_id AS id, poster_path, 'tv_series' AS type FROM tv_series";
  }

  // Add WHERE clause for country if needed
  if (isset($_GET['c'])) {
    $country = $_GET['c'];
    // Apply the condition to both parts of the UNION ALL query
    $conditionMovies .= " WHERE LOWER(country) LIKE LOWER(:country)";
    $conditionSeries .= " WHERE LOWER(country) LIKE LOWER(:country)";
    $h1_text = htmlspecialchars($country) . ' Movies & TV Shows';
  }

  // Add WHERE clause for language if needed
  if (isset($_GET['l'])) {
    $language = $_GET['l'];
    // Add an AND clause if the conditions already have WHERE in them
    if (!empty($conditionMovies)) {
      $conditionMovies .= " AND LOWER(language) LIKE LOWER(:language)";
      $conditionSeries .= " AND LOWER(language) LIKE LOWER(:language)";
    } else {
      $conditionMovies .= " WHERE LOWER(language) LIKE LOWER(:language)";
      $conditionSeries .= " WHERE LOWER(language) LIKE LOWER(:language)";
    }
    $h1_text = htmlspecialchars($language) . ' Movies & TV Shows';
  }

  // Apply the condition to the query
  if (isset($_GET['c']) || isset($_GET['l'])) {
    $query = "SELECT movieapi_id AS id, poster_path, 'movie' AS type FROM movies" . $conditionMovies;
    $query .= " UNION ALL SELECT tvapi_id AS id, poster_path, 'tv_series' AS type FROM tv_series" . $conditionSeries;
  }

  // Debugging output
  echo $query;

  $dbConnection = getDatabaseConnection();
  $stmt = $dbConnection->prepare($query);

  // Bind parameters if needed
  if (isset($_GET['c'])) {
    $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
  }
  if (isset($_GET['l'])) {
    $stmt->bindValue(':language', '%' . $language . '%', PDO::PARAM_STR);
  }

  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <section class="container w-full mx-auto mt-[75px] mb-14">
    <article class="flex items-center justify-between mb-14">
      <h1 name="name-category" class=" text-pastelBlue text-[56px] font-[570] uppercase leading-none"><?php echo $h1_text; ?></h1>
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
    </article>
  </section>
  <?php include_once("./footer.php"); ?>
  <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>