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
  // Initialization
  $query = '';
  $url_get = '';
  $conditionMovies = '';
  $conditionSeries = '';
  $h1_text = '';
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
  $itemsPerPage = 10; // Number of items per page
  $offset = ($page - 1) * $itemsPerPage; // Calculate offset for SQL query

  // Determine the base query and condition based on request
  if (isset($_GET['topmovies'])) {
    $h1_text = 'Movies';
    $url_get = 'topmovies';
    $query = "SELECT movieapi_id AS id, poster_path, 'movie' AS type FROM movies";
    $conditionMovies = " WHERE imdb_vote > 7";
  } elseif (isset($_GET['topseries'])) {
    $h1_text = 'TV Shows';
    $url_get = 'topseries';
    $query = "SELECT tvapi_id AS id, poster_path, 'tv_series' AS type FROM tv_series";
    $conditionSeries = " WHERE imdb_vote > 7";
  } elseif (isset($_GET['movies'])) {
    $h1_text = 'Movies';
    $url_get = 'movies';
    $query = "SELECT movieapi_id AS id, poster_path, 'movie' AS type FROM movies";
  } elseif (isset($_GET['series'])) {
    $h1_text = 'TV Shows';
    $url_get = 'series';
    $query = "SELECT tvapi_id AS id, poster_path, 'tv_series' AS type FROM tv_series";
  } else {
    // Default behavior if no specific request, allow filtering both movies and TV series by country or language
    $query = "SELECT movieapi_id AS id, poster_path, 'movie' AS type FROM movies";
    $query .= " UNION ALL SELECT tvapi_id AS id, poster_path, 'tv_series' AS type FROM tv_series";
  }

  // Add WHERE clause for genre if needed
  if (isset($_GET['g'])) {
    $genre = $_GET['g'];
    if (isset($_GET['movies'])) {
      $conditionMovies .= (empty($conditionMovies) ? " WHERE LOWER(genres) LIKE LOWER(:genre)" : " AND LOWER(genres) LIKE LOWER(:genre)");
    } elseif (isset($_GET['series'])) {
      $conditionSeries .= (empty($conditionSeries) ? " WHERE LOWER(genres) LIKE LOWER(:genre)" : " AND LOWER(genres) LIKE LOWER(:genre)");
    }
    $h1_text = htmlspecialchars($_GET['g']) . " $h1_text";
  }

  // Add WHERE clause for country if needed
  if (isset($_GET['c'])) {
    $country = $_GET['c'];
    if (isset($_GET['movies'])) {
      $conditionMovies .= (empty($conditionMovies) ? " WHERE LOWER(country) LIKE LOWER(:country)" : " AND LOWER(country) LIKE LOWER(:country)");
    } elseif (isset($_GET['series'])) {
      $conditionSeries .= (empty($conditionSeries) ? " WHERE LOWER(country) LIKE LOWER(:country)" : " AND LOWER(country) LIKE LOWER(:country)");
    } else {
      // If neither movies nor series is specified, apply the condition to both.
      $conditionMovies .= " WHERE LOWER(country) LIKE LOWER(:country)";
      $conditionSeries .= " WHERE LOWER(country) LIKE LOWER(:country)";
    }
    $h1_text = htmlspecialchars($country) . ' Movies & TV Shows';
  }

  // Add WHERE clause for language if needed
  if (isset($_GET['l'])) {
    $language = $_GET['l'];
    if (isset($_GET['movies'])) {
      $conditionMovies .= (empty($conditionMovies) ? " WHERE LOWER(language) LIKE LOWER(:language)" : " AND LOWER(language) LIKE LOWER(:language)");
    } elseif (isset($_GET['series'])) {
      $conditionSeries .= (empty($conditionSeries) ? " WHERE LOWER(language) LIKE LOWER(:language)" : " AND LOWER(language) LIKE LOWER(:language)");
    } else {
      // If neither movies nor series is specified, apply the condition to both.
      $conditionMovies .= " WHERE LOWER(language) LIKE LOWER(:language)";
      $conditionSeries .= " WHERE LOWER(language) LIKE LOWER(:language)";
    }
    $h1_text = htmlspecialchars($language) . ' Movies & TV Shows';
  }

  // Apply the conditions to the query
  $query = "";
  if (isset($_GET['movies'])) {
    $query = "SELECT movieapi_id AS id, poster_path, 'movie' AS type FROM movies" . $conditionMovies;
  } elseif (isset($_GET['series'])) {
    $query = "SELECT tvapi_id AS id, poster_path, 'tv_series' AS type FROM tv_series" . $conditionSeries;
  } else {
    // Combine query if filtering by country, language, or genre
    $query = "SELECT movieapi_id AS id, poster_path, 'movie' AS type FROM movies" . $conditionMovies .
      " UNION ALL SELECT tvapi_id AS id, poster_path, 'tv_series' AS type FROM tv_series" . $conditionSeries;
  }

  //for the pagination
  $query .= " LIMIT :offset, :limit";

  // Debugging output
  // echo $query;

  $dbConnection = getDatabaseConnection();
  $stmt = $dbConnection->prepare($query);
  // Bind parameters only if they exist in the query
  if (strpos($query, ':country') !== false && isset($_GET['c'])) {
    $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
  }
  if (strpos($query, ':genre') !== false && isset($_GET['g'])) {
    $stmt->bindValue(':genre', '%' . $genre . '%', PDO::PARAM_STR);
  }
  if (strpos($query, ':language') !== false && isset($_GET['l'])) {
    $stmt->bindValue(':language', '%' . $language . '%', PDO::PARAM_STR);
  }

  // Bind parameters if needed
  if (isset($_GET['c'])) {
    $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
  }
  if (isset($_GET['g'])) {
    $stmt->bindValue(':genre', '%' . $genre . '%', PDO::PARAM_STR);
  }
  if (isset($_GET['l'])) {
    $stmt->bindValue(':language', '%' . $language . '%', PDO::PARAM_STR);
  }

  // Bind pagination parameters (always used)
  $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
  $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);

  $stmt->execute();
  // echo 'offset :' . $offset . " & item per page: " . $itemsPerPage;
  // $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ///////////////////////////////////////////////////////////////////////////////
  // Total pages calculation for pagination
  $totalQuery = "SELECT COUNT(*) FROM (";
  $totalQuery .= "SELECT movieapi_id FROM movies";
  $totalQuery .= (isset($_GET['c']) || isset($_GET['l']) || isset($_GET['g'])) ? $conditionMovies : '';
  $totalQuery .= " UNION ALL ";
  $totalQuery .= "SELECT tvapi_id FROM tv_series";
  $totalQuery .= (isset($_GET['c']) || isset($_GET['l']) || isset($_GET['g'])) ? $conditionSeries : '';
  $totalQuery .= ") AS combined";

  $totalStmt = $dbConnection->prepare($totalQuery);
  if (isset($_GET['c'])) {
    $totalStmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
  }
  if (isset($_GET['g'])) {
    $totalStmt->bindValue(':genre', '%' . $genre . '%', PDO::PARAM_STR);
  }
  if (isset($_GET['l'])) {
    $totalStmt->bindValue(':language', '%' . $language . '%', PDO::PARAM_STR);
  }
  $totalStmt->execute();
  $totalItems = $totalStmt->fetchColumn();
  $total_page = ceil($totalItems / $itemsPerPage);

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

  <!-- Pagination HTML -->
  <section class="container w-full mx-auto my-4 flex justify-center">
    <nav aria-label="Page navigation example" class="mx-auto mt-5">
      <ul class="inline-flex -space-x-px text-sm gap-1">
        <?php
        // Build base URL for pagination
        $base_url = '?page=';
        $url_params = '';
        $url_params .= isset($_GET['movies']) ? '&movies' : '';
        $url_params .= isset($_GET['series']) ? '&series' : '';
        $url_params .= isset($_GET['c']) ? '&c=' . urlencode($_GET['c']) : '';
        $url_params .= isset($_GET['l']) ? '&l=' . urlencode($_GET['l']) : '';
        $url_params .= isset($_GET['g']) ? '&g=' . urlencode($_GET['g']) : '';

        // Previous button
        $prev_page = max(1, $page - 1);
        ?>
        <li>
          <a href="<?php echo $base_url . $prev_page . $url_params; ?>" class="flex items-center justify-center px-3 h-8 rounded-l-xl text-gray-50 border border-gray-300 bg-gray-900 hover:bg-gray-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white">Previous</a>
        </li>

        <?php
        // Page number links
        for ($x = 1; $x <= $total_page; $x++): ?>
          <li>
            <a href="<?php echo $base_url . $x . $url_params; ?>" class="flex items-center justify-center px-3 h-8 text-gray-50 border border-gray-300 hover:bg-gray-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white <?php echo ($x == $page) ? 'font-bold bg-gray-500' : 'bg-gray-900'; ?>">
              <?php echo $x; ?>
            </a>
          </li>
        <?php endfor; ?>

        <?php
        // Next button
        $next_page = min($total_page, $page + 1);
        ?>
        <li>
          <a href="<?php echo $base_url . $next_page . $url_params; ?>" class="flex items-center justify-center px-3 h-8 rounded-r-xl text-gray-50 border border-gray-300 bg-gray-900 hover:bg-gray-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white">Next</a>
        </li>
      </ul>
    </nav>
  </section>

  <?php include_once("./footer.php"); ?>
  <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>