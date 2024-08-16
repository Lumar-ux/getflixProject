<?php
require_once("dbh.inc.php");
// getting data from mysql 
try {
  $dbConnection = getDatabaseConnection();
  // movie
  $movie_query = $dbConnection->prepare('SELECT * from movies where imdb_vote > 6 LIMIT 15;'); // add a filter of imdb_vote larger then 8
  $movie_query->execute();
  $movie_result = $movie_query->fetchAll(PDO::FETCH_ASSOC);


  // tv-series
  $tv_query = $dbConnection->prepare('SELECT * from tv_series where imdb_vote > 6 LIMIT 15;'); // add a filter of imdb_vote larger then 8
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

?>
<?php
//images pour le hero
$elements = [
    [
        'image' => './image/hero_image/Chernobyles.jpg',
        'title' => 'Chernobyl',
        'imdb_vote' => '9.3',
        'release_date' => '2019'
    ],
    [
      'image' => './image/hero_image/BohemianRhapsody-Crop.png',
      'title' => 'Bohemian Rhapsody',
      'imdb_vote' => '7.9',
      'release_date' => '2019'
    ],
    [
      'image' => './image/hero_image/SISU.jpg',
      'title' => "Sisu",
      'imdb_vote' => '6.9',
      'release_date' => '2022'
    ],
    [
      'image' => './image/hero_image/NightAgent-Crop.png',
      'title' => "The Night Agent",
      'imdb_vote' => '7.5',
      'release_date' => '2023'
    ],
    [
      'image' => './image/hero_image/DropOfGod-Crop.png',
      'title' => "Drop Of God",
      'imdb_vote' => '8.0',
      'release_date' => '2023'
    ],
    [
      'image' => './image/hero_image/Avatar_2-Crop.png',
      'title' => "Avatar: The Way of Water",
      'imdb_vote' => '7.5',
      'release_date' => '2022'
    ],
    [
      'image' => './image/hero_image/Lucky.png',
      'title' => "Loki",
      'imdb_vote' => '8.2',
      'release_date' => '2021-2023'
    ],
];
$n = count($elements);
?>

<!DOCTYPE html>
<html lang="en" class="h-screen w-screen">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./output.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.js" integrity="sha512-bkge924rHvzs8HYzPSjoL47QZU0PYng6QsMuo3xxmEtCeGsfIeDl6t4ATj+NxwUbwOEYKsGO8A5zIAkMXP+cHQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <title>Getflix</title>
</head>

<body class="bg-halfBlack sm:w-screen w-full h-fit">
  <?php include_once("./header.php"); ?>
  <main class="w-[80%] sm:container mx-auto h-fit">
    <section class="cate-main h-[748px] sm:h-[801px] flex items-center sm:my-[39px]">
      <article class="hero-article h-[622px] sm:h-[691px] flex *:mr-6 last:*:mr-0 overflow-x-auto">
        <?php for ($i = 0; $i < $n; $i++): ?>
              <?php 
              $element = $elements[$i % count($elements)];
              ?>
              <article class="card1 flex-shrink-0 group relative h-[622px] sm:h-[652px] w-[93.16px] sm:w-[190px] overflow-hidden sm:hover:w-[485.21px] hover:w-[462.88px]">
                  <img src="<?php echo $element['image']; ?>" alt="<?php echo $element['title']; ?> Test" class="transition-transform duration-500 ease-in-out w-full h-full object-cover rounded-xl">
                  <section class="absolute flex flex-col justify-between inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out p-4">
                      <h2 class="text-white text-4xl font-[570] uppercase leading-none h-5"><?php echo $element['title']; ?></h2>
                      <article class="flex justify-between items-center">
                          <button class="flex items-center h-fit">
                              <img class="mr-1.5 h-8 w-8" src="image/grade_32dp_FFF_FILL1_wght400_GRAD0_opsz40.svg" alt="IMDB Rating">
                              <span class="text-white text-lg leading-none"><?php echo $element['imdb_vote']; ?></span>
                          </button>
                          <button class="flex items-center h-fit">
                              <span class="text-white text-lg leading-none"><?php echo $element['release_date']; ?></span>
                          </button>
                      </article>
                  </section>
              </article>
          <?php endfor; ?>
      </article>
    </section>
    <section class="cate-main w-full h-fit overflow-x-scroll mb-14">
      <article class="grid1 h-full space-y-3 sm:space-y-6">
        <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6">
          <h1 name="category-01" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">Movie<br>Top 10</h1>
          <a href="category.php?topmovies" class="self-end w-[19%] h-[19%]"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full"></a>
        </div>
        <?php foreach ($movie_result as $movie) { ?>
          <a class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-3" href="program-detail.php?id=<?php echo $movie['movieapi_id']; ?>"><img class="grid-item bg-gray-500 rounded-xl" src="http://image.tmdb.org/t/p/w500/<?php echo $movie["poster_path"]; ?>" alt="poster"></a>
        <?php } ?>
      </article>
    </section>
    <section class="cate-main w-full h-fit overflow-x-scroll mb-14">
      <article class="grid1 h-full space-y-3 sm:space-y-6">
        <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6">
          <h1 name="category-02" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">Tv Shows Top 10</h1>
          <a href="category.php?topseries" class="self-end w-[19%] h-[19%]"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full"></a>
        </div>
        <?php foreach ($tv_result as $tv) { ?>
          <a class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-3" href="program-detail.php?id=<?php echo $tv['tvapi_id']; ?>"><img class="grid-item bg-gray-500 rounded-xl" src="http://image.tmdb.org/t/p/w500/<?php echo $tv["poster_path"]; ?>" alt="poster"></a>
        <?php } ?>

      </article>
    </section>
    <section class="cate-main w-full h-fit overflow-x-scroll mb-14">
      <article class="grid1 h-full space-y-3 sm:space-y-6">
        <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6">
          <h1 name="category-03" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">Discover Movies</h1>
          <a href="category.php?movies" class="self-end w-[19%] h-[19%]"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full"></a>
        </div>
        <?php foreach ($dis_movie_result as $dis_movie) { ?>
          <a class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-3" href="program-detail.php?id=<?php echo $dis_movie['movieapi_id']; ?>"><img class="grid-item bg-gray-500 rounded-xl" src="http://image.tmdb.org/t/p/w500/<?php echo $dis_movie["poster_path"]; ?>" alt="poster"></a>
        <?php } ?>
      </article>
    </section>
    <section class="cate-main w-full h-fit overflow-x-scroll mb-14">
      <article class="grid1 h-full space-y-3 sm:space-y-6">
        <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6">
          <h1 name="category-04" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">Discover Tv Shows</h1>
          <a href="category.php?series" class="self-end w-[19%] h-[19%]"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full"></a>
        </div>
        <?php foreach ($dis_tv_result as $dis_tv) { ?>
          <a class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-3" href="program-detail.php?id=<?php echo $dis_tv['tvapi_id']; ?>"><img class="grid-item bg-gray-500 rounded-xl" src="http://image.tmdb.org/t/p/w500/<?php echo $dis_tv["poster_path"]; ?>" alt="poster"></a>
        <?php } ?>
      </article>
    </section>
  </main>
  <?php include_once("./footer.php"); ?>
  <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
  <!-- <script src="./masonry.pkgd.js"></script> -->
</body>

</html>