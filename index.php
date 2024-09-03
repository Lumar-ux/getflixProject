<?php
require_once("dbh.inc.php");
$dbConnection = getDatabaseConnection();
// getting data from mysql 
try {

  // movie
  $movie_query = $dbConnection->prepare('SELECT * from movies where imdb_vote > 8 LIMIT 15;'); // add a filter of imdb_vote larger then 8
  $movie_query->execute();
  $movie_result = $movie_query->fetchAll(PDO::FETCH_ASSOC);


  // tv-series
  $tv_query = $dbConnection->prepare('SELECT * from tv_series where imdb_vote > 8 LIMIT 15;'); // add a filter of imdb_vote larger then 8
  $tv_query->execute();
  $tv_result = $tv_query->fetchAll(PDO::FETCH_ASSOC);


  //discover movies
  $dis_movie_query = $dbConnection->prepare('SELECT * from movies LIMIT 15;');
  $dis_movie_query->execute();
  $dis_movie_result = $dis_movie_query->fetchAll(PDO::FETCH_ASSOC);


  //discover tv series
  $dis_tv_query = $dbConnection->prepare('SELECT * from tv_series LIMIT 15;');
  $dis_tv_query->execute();
  $dis_tv_result = $dis_tv_query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  exit();
}


// random movie or tv series in hero

function getRandomRecordsEveryTwoDays()
{
  global $dbConnection;
  $storage_file = 'random_records.json'; // File to store records and timestamp
  $two_days = 2 * 24 * 60 * 60; // 2 days in seconds

  // Check if the storage file exists and is readable
  if (file_exists($storage_file)) {
    $data = json_decode(file_get_contents($storage_file), true);
    if (isset($data['timestamp']) && (time() - $data['timestamp']) < $two_days) {
      // If the data is less than two days old, return the stored records
      return $data['records'];
    }
  }
  // Otherwise, fetch new random records
  $new_records = fetchRandomRecords();

  // Store the new records and the current timestamp in the file
  $data = [
    'timestamp' => time(),
    'records' => $new_records
  ];
  file_put_contents($storage_file, json_encode($data));

  return $new_records;
}

function fetchRandomRecords()
{
  global $dbConnection;
  try {
    // SQL query to get random 7 records from movies and tv_series
    $sql = "
          SELECT movies.movieapi_id as id, movies.title AS name, movies.poster_path as poster, movies.release_date AS date,movies.imdb_vote as imdb, 'movie' AS type FROM movies 
          WHERE movies.imdb_vote > 8 
          UNION 
          SELECT tv_series.tvapi_id as id, tv_series.title as name, tv_series.poster_path as poster, tv_series.release_date AS date,tv_series.imdb_vote as imdb, 'tv_series' AS type 
          FROM tv_series WHERE tv_series.imdb_vote > 8
          ORDER BY RAND() LIMIT 7;
        ";

    // Prepare and execute the query
    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    // Fetch the results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    return [];
  }
}

// Usage of the function
$records = getRandomRecordsEveryTwoDays();

// Output or process the results
// foreach ($records as $record) {
//   echo "ID: " . $record['id'] . "<br>";
//   echo "Name: " . $record['name'] . "<br>";
//   echo "Poster: " . $record['poster'] . "<br>";
//   echo "Date: " . $record['date'] . "<br>";
//   echo "Type: " . $record['type'] . "<br><br>";
// }








?>
<?php
//images pour le hero
// $elements = [
//   [
//     'image' => './image/hero_image/Chernobyles.jpg',
//     'title' => 'Chernobyl',
//     'imdb_vote' => '9.3',
//     'release_date' => '2019'
//   ],
//   [
//     'image' => './image/hero_image/BohemianRhapsody-Crop.png',
//     'title' => 'Bohemian Rhapsody',
//     'imdb_vote' => '7.9',
//     'release_date' => '2019'
//   ],
//   [
//     'image' => './image/hero_image/SISU.jpg',
//     'title' => "Sisu",
//     'imdb_vote' => '6.9',
//     'release_date' => '2022'
//   ],
//   [
//     'image' => './image/hero_image/NightAgent-Crop.png',
//     'title' => "The Night Agent",
//     'imdb_vote' => '7.5',
//     'release_date' => '2023'
//   ],
//   [
//     'image' => './image/hero_image/DropOfGod-Crop.png',
//     'title' => "Drop Of God",
//     'imdb_vote' => '8.0',
//     'release_date' => '2023'
//   ],
//   [
//     'image' => './image/hero_image/Avatar_2-Crop.png',
//     'title' => "Avatar: The Way of Water",
//     'imdb_vote' => '7.5',
//     'release_date' => '2022'
//   ],
//   [
//     'image' => './image/hero_image/Lucky.png',
//     'title' => "Loki",
//     'imdb_vote' => '8.2',
//     'release_date' => '2021-2023'
//   ],
// ];
// $n = count($elements);
?>

<!DOCTYPE html>
<html lang="en" class="h-screen w-screen">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./output.css">
  <!-- Favicon pour les navigateurs modernes -->
  <link rel="icon" href="image/favicon.ico.jpg" type="image/x-icon">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.js"
    integrity="sha512-bkge924rHvzs8HYzPSjoL47QZU0PYng6QsMuo3xxmEtCeGsfIeDl6t4ATj+NxwUbwOEYKsGO8A5zIAkMXP+cHQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <title>Getflix</title>
</head>

<body class="bg-halfBlack sm:w-screen w-full h-fit">
  <?php include_once("./header.php"); ?>
  <main class="w-[80%] sm:container mx-auto h-fit">
    <section class="cate-main h-[748px] sm:h-[801px] flex items-center sm:my-[39px]">
      <article class="hero-article h-[622px] sm:h-[691px] flex *:mr-6 last:*:mr-0 overflow-x-auto">
        <?php foreach ($records as $record) { ?>
          <a href="program-detail.php?id=<?php echo $record['id']; ?>" class="hover:cursor-pointer">
            <article class="card1 flex-shrink-0 group relative h-[622px] sm:h-[652px] w-[93.16px] sm:w-[190px] overflow-hidden sm:hover:w-[485.21px] hover:w-[462.88px]">
              <img src="http://image.tmdb.org/t/p/w500/<?php echo $record['poster']; ?>" alt="<?php echo $record['name']; ?> Test" class="transition-transform duration-500 ease-in-out w-full h-full object-cover rounded-xl">
              <section class="absolute flex flex-col justify-between inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out p-4">
                <h2 class="text-white text-4xl font-[570] uppercase leading-none h-5"><?php echo $record['name']; ?></h2>
                <article class="flex justify-between items-center">
                  <button class="flex items-center h-fit">
                    <img class="mr-1.5 h-8 w-8" src="image/grade_32dp_FFF_FILL1_wght400_GRAD0_opsz40.svg" alt="IMDB Rating">
                    <span class="text-white text-lg leading-none"><?php echo $record['imdb']; ?></span>
                  </button>
                  <button class="flex items-center h-fit">
                    <span class="text-white text-lg leading-none"><?php echo $record['date']; ?></span>
                  </button>
                </article>
              </section>
            </article>
          </a>
        <?php } ?>
      </article>
    </section>
    <section class="cate-main w-full h-fit overflow-x-scroll mb-14">
      <article class="grid1 h-full space-y-3 sm:space-y-6">
        <!-- First card for the "Movie Top 10" category -->
        <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6">
          <h1 name="category-01" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">
            Movie<br>Top 10
          </h1>
          <a href="category.php?topmovies" class="self-end w-[19%] h-[19%]">
            <img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full">
          </a>
        </div>

        <!-- Loop through movies and display them as cards with hover effect -->
        <?php foreach ($movie_result as $movie) { ?>
          <a class="relative grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6 group" name="img-cat-3" href="program-detail.php?id=<?php echo $movie['movieapi_id']; ?>&movies">
            <img class="w-full h-full object-cover rounded-xl" src="http://image.tmdb.org/t/p/w500/<?php echo $movie["poster_path"]; ?>" alt="poster">
            <!-- Hover text that appears when the card is hovered -->
            <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div class="absolute bottom-8 left-4 text-white text-lg font-semibold">
                <?php echo $movie['title']; ?>
              </div>
              <div class="absolute bottom-4 right-4 flex justify-center items-center text-white text-md font-bold">
                <img class="mr-1.5 h-6 w-6" src="image/grade_32dp_FFF_FILL1_wght400_GRAD0_opsz40.svg" alt="IMDB Rating">
                <?php echo $movie['imdb_vote']; ?>
              </div>
            </div>
          </a>
        <?php } ?>
      </article>
    </section>
    <section class="cate-main w-full h-fit overflow-x-scroll mb-14">
      <article class="grid1 h-full space-y-3 sm:space-y-6 space-x-3 sm:space-x-6 ">
        <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6 ml-3 sm:ml-6">
          <h1 name="category-02" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">Tv Shows Top 10</h1>
          <a href="category.php?topseries" class="self-end w-[19%] h-[19%]"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full"></a>
        </div>
        <?php foreach ($tv_result as $tv) { ?>
          <a class="relative grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6 group" name="img-cat-3" href="program-detail.php?id=<?php echo $tv['tvapi_id']; ?>&tvshows"><img class="grid-item bg-gray-500 rounded-xl" src="http://image.tmdb.org/t/p/w500/<?php echo $tv["poster_path"]; ?>" alt="poster">
            <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div class="absolute bottom-8 left-4 text-white text-lg font-semibold">
                <?php echo $tv['title']; ?>
              </div>
              <div class="absolute bottom-4 right-4 flex justify-center items-center text-white text-md font-bold">
                <img class="mr-1.5 h-6 w-6" src="image/grade_32dp_FFF_FILL1_wght400_GRAD0_opsz40.svg" alt="IMDB Rating">
                <?php echo $tv['imdb_vote']; ?>
              </div>
            </div>
          </a>
        <?php } ?>

      </article>
    </section>
    <section class="cate-main w-full h-fit overflow-x-scroll mb-14">
      <article class="grid1 h-full space-y-3 sm:space-y-6 space-x-3 sm:space-x-6">
        <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6 ml-3 sm:ml-6">
          <h1 name="category-03" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">Discover Movies</h1>
          <a href="category.php?movies" class="self-end w-[19%] h-[19%]"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full"></a>
        </div>
        <?php foreach ($dis_movie_result as $dis_movie) { ?>
          <a class="relative grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6 group" name="img-cat-3" href="program-detail.php?id=<?php echo $dis_movie['movieapi_id']; ?>&movies"><img class="grid-item bg-gray-500 rounded-xl" src="http://image.tmdb.org/t/p/w500/<?php echo $dis_movie["poster_path"]; ?>" alt="poster">
            <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div class="absolute bottom-8 left-4 text-white text-lg font-semibold">
                <?php echo $dis_movie['title']; ?>
              </div>
              <div class="absolute bottom-4 right-4 flex justify-center items-center text-white text-md font-bold">
                <img class="mr-1.5 h-6 w-6" src="image/grade_32dp_FFF_FILL1_wght400_GRAD0_opsz40.svg" alt="IMDB Rating">
                <?php echo $dis_movie['imdb_vote']; ?>
              </div>
            </div>
          </a>
        <?php } ?>
      </article>
    </section>
    <section class="cate-main w-full h-fit overflow-x-scroll mb-14">
      <article class="grid1 h-full space-y-3 sm:space-y-6 space-x-3 sm:space-x-6">
        <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6 ml-3 sm:ml-6">
          <h1 name="category-04" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">Discover Tv Shows</h1>
          <a href="category.php?series" class="self-end w-[19%] h-[19%]"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full"></a>
        </div>
        <?php foreach ($dis_tv_result as $dis_tv) { ?>
          <a class="relative grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6 group" name="img-cat-3" href="program-detail.php?id=<?php echo $dis_tv['tvapi_id']; ?>&tvshows"><img class="grid-item bg-gray-500 rounded-xl" src="http://image.tmdb.org/t/p/w500/<?php echo $dis_tv["poster_path"]; ?>" alt="poster">
            <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div class="absolute bottom-8 left-4 text-white text-lg font-semibold">
                <?php echo $dis_tv['title']; ?>
              </div>
              <div class="absolute bottom-4 right-4 flex justify-center items-center text-white text-md font-bold">
                <img class="mr-1.5 h-6 w-6" src="image/grade_32dp_FFF_FILL1_wght400_GRAD0_opsz40.svg" alt="IMDB Rating">
                <?php echo $dis_tv['imdb_vote']; ?>
              </div>
            </div>
          </a>
        <?php } ?>
      </article>
    </section>
  </main>
  <?php include_once("./footer.php"); ?>
  <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
  <!-- <script src="./masonry.pkgd.js"></script> -->
</body>

</html>