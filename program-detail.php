<?php
include_once "dbh.inc.php";
$conn = getDatabaseConnection();
// The ID to search for
if (isset($_GET['id'])) {
  $id = $_GET['id'] ?? null; // Use null coalescing operator for safety
  if (isset($_GET["type"])) {
    $type = $_GET["type"];
  }
  // Function to fetch data from a table 
  // in one place it there is 2 table but in other place there are 3 tables
  function fetchData($conn, $query, $id)
  {
    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $id]);

    // Return the fetched data
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  // Check data in table1 (movie) 
  $query = " SELECT movies.*,movies.id as movie_id, movie_cast.* ,'movie' as type FROM movies INNER JOIN movie_cast ON movies.movieapi_id  = movie_cast.movieapi_id WHERE movies.movieapi_id = :id;";
  // Call the function
  $data = fetchData($conn, $query, $id);

  $table1_data = null;
  $table2_data = null;

  if ($data) {
    $table1_data = reset($data);
    $table2_data = $data;
  } else {
    // Check data in table2 (tv series)
    // Define the parameters for the function call
    $query = "SELECT tv_series.*, seasons.*, episodes.* FROM tv_series INNER JOIN seasons ON tv_series.id = seasons.tv_series_id INNER JOIN episodes ON seasons.id = episodes.season_id WHERE tv_series.tvapi_id = :id;";

    $data = fetchData($conn, $query, $id);

    if ($data) {
      $table1_data = reset($data);
      $table2_data = $data;
    } else {
      echo "no data in db";
      // Data not found in both tables, make an external request
      // function to get data from api

      // Call the function and get JSON-encoded data
      // $json_data = get_data_from_api($id, $type, $API_KEY);

      // // Decode JSON data to PHP array
      // $data = json_decode($json_data, true);

      // // Check if $data is an array and not empty
      // if (is_array($data) && !empty($data)) {
      //     if (isset($data['error'])) {
      //         // Handle error message
      //         echo "Error: " . $data['error'];
      //     } else {
      //         // Process the data
      //         $table1_data = isset($data[0]) ? $data[0] : [];
      //         $table2_data = $data;
      //     }
      // } else {
      //     // Handle unexpected data format
      //     echo "Error: Unexpected data format.";
      // }
    }
  }




  //changing the time format
  function formatDuration($minutes)
  {
    $hours = intdiv($minutes, 60);
    $remainingMinutes = $minutes % 60;
    return sprintf("%d h / %d min", $hours, $remainingMinutes);
  }
  $duration = $table1_data['duration'];
  $formattedDuration = formatDuration($duration);
  //genre
  $string = $table1_data['genres'];
  // Split the string into an array using ', ' as the delimiter
  $words = explode(', ', $string);
  // Optionally, trim whitespace from each word
  $words = array_map('trim', $words);


  $firstGenre = isset($words[0]) ? $words[0] : null;

  // --------------------------------------------------------------
  // find movie or series with same genres
  // Determine which table to query
  $table = '';
  $id_column = '';
  $exclude_id = $id;
  if (isset($table1_data['movieapi_id'])) {
    $table = 'movies';
    $id_column = 'movieapi_id';
  } elseif (isset($table1_data['tvapi_id'])) {
    $table = 'tv_series';
    $id_column = 'tvapi_id';
  }

  if ($table) {
    // Start building the query
    $query = "SELECT *, $id_column as id FROM $table WHERE $id_column != :exclude_id";
    $conditions = [];

    // Build the conditions for the genres
    foreach ($words as $index => $genre) {
      $paramName = ':genre_' . $index; // Use index to ensure unique parameter names
      $conditions[] = "LOWER(genres) LIKE LOWER(CONCAT('%', $paramName, '%'))";
    }

    // If there are genre conditions, add them to the query
    if (!empty($conditions)) {
      $query .= " AND (" . implode(' OR ', $conditions) . ")";
    }

    // Add the LIMIT clause
    $query .= " LIMIT 15";

    // Prepare the query using PDO
    $statement = $conn->prepare($query);

    // Bind the genre parameters
    foreach ($words as $index => $genre) {
      $paramName = ':genre_' . $index; // Use the same index-based parameter name
      $statement->bindValue($paramName, $genre, PDO::PARAM_STR);
    }
    // Bind the exclude_id parameter
    $statement->bindValue(':exclude_id', $exclude_id, PDO::PARAM_INT);

    // Execute the query
    $statement->execute();
    $same_genre_results = $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}


// ------- test comments---------------------------------------------
if (isset($_POST['submit'])) {
  $text = $_POST["message-current-user"];
  $dbmovie_id = $table1_data['movie_id'];
  $user_id = 1; // need actual user is from session


  try {
    $query = "INSERT INTO movie_comments (comment,movie_id,user_id) VALUES (:comment, :movie_id, :user_id)";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':comment', $text);
    $stmt->bindParam(':movie_id', $dbmovie_id);
    $stmt->bindParam(':user_id', $user_id);
    $result = $stmt->execute();
    if ($result) {
      header("Location:program-detail.php?id=$id&comment=success");
    }
  } catch (PDOException $e) {
    // Handle any errors
    echo "Error: " . $e->getMessage();
  }
}

?>
<!DOCTYPE html>
<html lang="en" class="h-screen w-screen">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./output.css">
  <title>Getflix | <?php echo $table1_data['title']; ?></title>
</head>

<body class="bg-halfBlack sm:w-screen w-full h-fit">
  <?php include_once("./header.php"); ?>
  <main class="w-[80%] sm:container mx-auto h-fit">
    <section class="relative w-full mb-6 pt-[57.14%;] sm:block hidden">
      <iframe class="absolute top-0 right-0 w-full h-full bg-gray-500 rounded-xl" name="trailer-video" src="https://www.youtube.com/embed/<?php echo $table1_data['trailer_id']; ?>?autoplay=0&controls=1" frameborder="0"></iframe>
    </section>
    <section class="porg-detail block sm:flex w-full sm:h-[801px] h-[716.4px] sm:mb-28 mb-[78px]">
      <!-- <div class="bg-gray-500 rounded-xl h-[270px] sm:h-full w-full sm:w-[679px] sm:mr-14 sm:mb-0 mb-3 sm:m-0" name="img-cat_08"></div> -->

      <img class="bg-gray-500 rounded-xl h-[270px] sm:h-full w-full sm:w-[679px] sm:mr-14 sm:mb-0 mb-3 sm:m-0" name="img-cat_08" src="http://image.tmdb.org/t/p/w500/<?php echo $table1_data['poster_path']; ?>" alt="poster">

      <article class="flex flex-col w-full sm:w-[801px] sm:h-full h-[436px] sm:justify-between">
        <section class="detail w-full">
          <h1 name="name-prog" class="bg-pastelBlue text-white py-4 pl-4 text-[34px] text-1 font-[570] uppercase sm:mb-6 mb-2.5 rounded-[10px] leading-none w-full"> <?php echo $table1_data['title']; ?></h1>
          <article class="info flex items-center sm:mb-6 mb-2.5">
            <?php
            foreach ($words as $word) { ?>
              <button name="genre-01" class="bg-white p-[10px] sm:text-base text-[13px] font-[570] leading-none mr-2 rounded-[10px]"><?php echo $word ?></button>
            <?php } ?>
            <p name=" year" class="font-[570] sm:text-base text-[13px] text-white mr-2">Year: <?php
                                                                                              $release_date = $table1_data['release_date'];
                                                                                              $year = date('Y', strtotime($release_date));
                                                                                              echo $year; ?></p>
            <p name="duration" class="font-[570] sm:text-base text-[13px] text-white mr-2">Duration : <?php echo $formattedDuration; ?></p>
            <p name="imbdb-note" class="font-[570] sm:text-base text-[13px] text-white"><?php echo $table1_data['imdb_vote']; ?></p>
          </article>
          <article class="flex">
            <ul class="list-none mr-6">
              <li class="text-white text-xs mb-[10px]">Country : <span name="prog-country"><?php echo $table1_data['country']; ?></span></li>
              <li class="text-white text-xs">Production : <span name="prog-prod"><?php echo $table1_data['production']; ?></span></li>
            </ul>
            <ul class="list-none">
              <li class="text-white text-xs mb-[10px]">Date Release : <span name="prog-release"><?php echo $table1_data['release_date']; ?></span></li>
              <li class="text-white text-xs sm:w-[370px] w-[136.5px] line-clamp-2">Cast : <span name="prog-cast">
                  <?php // to limit the number of cast
                  $limit = 9; // Set the limit to the desired number of items
                  $count = 0; // Initialize a counter

                  foreach ($table2_data as $data) {
                    echo $data['name'] . ', ';
                    $count++;

                    if ($count >= $limit) {
                      break; // Exit the loop once the limit is reached
                    }
                  } ?></span></li>
            </ul>
          </article>
        </section>
        <section class="descriptif mt-0">
          <p class="text-white font-[570] sm:text-[18px] text-3.5 line-clamp-6">Overview: <?php echo $table1_data['overview']; ?></p>
        </section>
      </article>
    </section>
    <section class="cate-main w-full h-fit overflow-x-scroll mb-14">
      <article class="grid1 h-full space-y-3 sm:space-y-6">
        <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-0 sm:mt-6">
          <h1 name="category-01" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">You may also like</h1>
          <a href="category.php?g=<?php echo $firstGenre; ?>" class="self-end w-[19%] h-[19%]"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full"></a>
        </div>
        <?php
        // get the movies with the same genres from db
        $counter = 1;
        foreach ($same_genre_results as $result) {
          $additionalClass = ($counter % 3 === 0) ? 'grid-item--width2' : '';
        ?>
          <a href="program-detail.php?id=<?php echo $result['id']; ?>" class="grid-item <?php echo $additionalClass; ?> bg-gray-500 rounded-xl ml-3 sm:ml-6">
            <img class="w-full h-full" src="http://image.tmdb.org/t/p/w500/<?php echo $result['poster_path']; ?>" alt="poster">
          </a>
        <?php $counter++;
        } ?>
      </article>
    </section>
    <section class="w-full mb-14">
      <h1 class="text-white uppercase text-2xl font-semibold mb-14">Comments</h1>
      <article name="Comment-Area" class="flex mb-10">
        <section class="w-full sm:w-[875px]">
          <article class="flex items-center mb-2">
            <div class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2"></div>
            <h2 name="current-name-user" class="text-white font-bold leading-none">User</h2>
          </article>
          <div class="form-floating">
            <form action="" method="POST" class="flex flex-col">
              <textarea class="form-control w-full h-20 rounded-xl p-4 mb-1" placeholder="Leave a comment here..." id="floatingTextarea2" name="message-current-user"></textarea>
              <button type="submit" name="submit" class="send text-[12px] font-normal text-white w-fit hover:bg-[#424242] px-4 py-2 rounded-xl"><span class="text-[12px] font-normal text-white">Envoyé</span></button>
            </form>
          </div>
        </section>
      </article>

      <?php
      //------------------------- comments--------------------------------------
      $query = "SELECT users.username, users.avatar, movie_comments.comment, movie_comments.created_at
                FROM users
                INNER JOIN movie_comments ON users.user_id = movie_comments.user_id
                WHERE movie_comments.movie_id = :movie_id;";

      $moviedb_id = $table1_data['movie_id'];

      try {
        // Prepare the statement
        $stmt = $conn->prepare($query);

        // Bind the parameter
        $stmt->bindParam(':movie_id', $moviedb_id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch all results
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
      }
      foreach ($comments as $row) { ?>

        <article name="post-Area" class="flex mb-10">
          <section class="w-full sm:w-[875px]">
            <article class="flex items-center mb-2">
              <!-- <div class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2"></div> -->
              <img src="<?php echo $row['avatar'];  ?>" class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2" alt="user image">
              <h2 name="current-name-user" class="text-white font-bold leading-none"><?php echo $row['username'];  ?></h2>
            </article>
            <div class="screen-message w-full h-20 rounded-xl p-4 mb-1 bg-greyWhite text-black" name="message-user">
              <p><?php echo $row['comment'];  ?></p>
            </div>
            <div class="flex">
              <!-- <button class="p-2 hover:bg-coloHover mr-2 rounded-full"><img src="image/thumb_up_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Up" class="w-[18px] h-[18px]"></button>
              <button class="p-2 hover:bg-coloHover rounded-full"><img src="image/thumb_down_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Down" class="w-[18px] h-[18px]"></button> -->
              <!-- <button type="submit" name="submit" class="send flex hover:bg-[#424242] px-4 py-2 rounded-xl"><img src="image/reply_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Reply-Icon" class="w-[18px] h-[18px] mr-1"><span class="text-[12px] font-normal text-white">Reply</span></button> -->
            </div>
          </section>
        </article>
      <?php    } ?>
      <!-- 
      <article name="post-Area" class="flex mb-10">
        <section class="w-full sm:w-[875px]">
          <article class="flex items-center mb-2">
            <div class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2"></div>
            <h2 name="current-name-user" class="text-white font-bold leading-none">User</h2>
          </article>
          <div class="screen-message w-full h-20 rounded-xl p-4 mb-1 bg-greyWhite" name="message-user"></div>
          <div class="flex">
            <button class="p-2 hover:bg-[#424242] mr-2 rounded-full"><img src="image/thumb_up_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Up" class="w-[18px] h-[18px]"></button>
            <button class="p-2 hover:bg-[#424242] rounded-full"><img src="image/thumb_down_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Down" class="w-[18px] h-[18px]"></button> -->
      <!-- <button type="submit" name="submit" class="send flex hover:bg-[#424242] px-4 py-2 rounded-xl"><img src="image/reply_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Reply-Icon" class="w-[18px] h-[18px] mr-1"><span class="text-[12px] font-normal text-white">Reply</span></button> -->
      <!-- </div>
        </section>
      </article> -->
      <!-- <article name="post-Area" class="flex mb-10">
        <section class="w-full sm:w-[875px]">
          <article class="flex items-center mb-2">
            <div class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2"></div>
            <h2 name="current-name-user" class="text-white font-bold leading-none">User</h2>
          </article>
          <div class="screen-message w-full h-20 rounded-xl p-4 mb-1 bg-greyWhite" name="message-user"></div>
          <div class="flex">
            <button class="p-2 hover:bg-[#424242] mr-2 rounded-full"><img src="image/thumb_up_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Up" class="w-[18px] h-[18px]"></button>
            <button class="p-2 hover:bg-[#424242] rounded-full"><img src="image/thumb_down_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Down" class="w-[18px] h-[18px]"></button> -->
      <!-- <button type="submit" name="submit" class="send flex hover:bg-[#424242] px-4 py-2 rounded-xl"><img src="image/reply_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Reply-Icon" class="w-[18px] h-[18px] mr-1"><span class="text-[12px] font-normal text-white">Reply</span></button> -->
      <!-- </div>
        </section>
      </article> -->
    </section>
  </main>
  <?php include_once("./footer.php"); ?>
</body>

</html>