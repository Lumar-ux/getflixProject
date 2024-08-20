<?php
include_once "dbh.inc.php";
$conn = getDatabaseConnection();
// The ID to search for
if (isset($_GET['id'])) {
  $id = $_GET['id'] ?? null; // Use null coalescing operator for safety
  // if (isset($_GET["type"])) {
  //   $type = $_GET["type"];
  // }
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
    $type = 'movie';
  } else {
    // Check data in table2 (tv series)
    // Define the parameters for the function call
    $query = "SELECT tv_series.*,tv_series.id as series_id FROM tv_series  WHERE tv_series.tvapi_id = :id;";
    $data = fetchData($conn, $query, $id);
    $type = 'series';



    if ($data) {
      $table1_data = reset($data);
      $table2_data = $data;


      $series_id = $table1_data['id'];
      // getting series seasons 
      $query = "SELECT * FROM seasons WHERE tv_series_id=:id;";

      $seasons = fetchData($conn, $query, $series_id);
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
  if ($type == 'movie') {
    $duration = $table1_data['duration'];
    $formattedDuration = formatDuration($duration);
  }
  //genre
  $string = $table1_data['genres'];
  // Split the string into an array using ', ' as the delimiter
  $words = explode(', ', $string);
  // Optionally, trim whitespace from each word
  $words = array_map('trim', $words);


  $firstGenre = isset($words[0]) ? $words[0] : null;

  // -------------------------------------------------------------- same movie---------------------
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


// ------- insert comments to db---------------------------------------------
if (isset($_POST['submit'])) {
  $text = $_POST["message-current-user"];
  if ($type == 'movie') {
    $db_id = $table1_data['movie_id'];
    $query = "INSERT INTO movie_comments (comment,movie_id,user_id) VALUES (:comment, :db_id, :user_id)";
  } else {
    $db_id = $table1_data['series_id'];
    $query = "INSERT INTO tv_series_comments (comment,tv_series_id,user_id) VALUES (:comment, :db_id, :user_id)";
  }
  $user_id = $_SESSION["user_id"];


  try {
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':comment', $text);
    $stmt->bindParam(':db_id', $db_id);
    $stmt->bindParam(':user_id', $user_id);
    $st_result = $stmt->execute();
    if ($st_result) {
      header("Location:program-detail.php?id=$id&comment=success");
    } else {
      header("Location:program-detail.php?id=$id&comment=unsuccess");
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.js" integrity="sha512-bkge924rHvzs8HYzPSjoL47QZU0PYng6QsMuo3xxmEtCeGsfIeDl6t4ATj+NxwUbwOEYKsGO8A5zIAkMXP+cHQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
      <img class="rounded-xl h-[270px] sm:h-full hover:h-fit sm:hover:h-full hover:object-contain sm:w-fit w-full sm:mr-14 sm:mb-0 mb-3 sm:m-0 sm:object-contain object-cover" name="img-cat_08" src="http://image.tmdb.org/t/p/w500/<?php echo $table1_data['poster_path']; ?>" alt="poster">
      <article class="flex flex-col w-full sm:h-full h-[436px] sm:justify-between">
        <section class="detail w-full">
          <h1 name="name-prog" class="bg-pastelBlue text-white sm:p-4 p-[10px] text-[34px] font-[570] uppercase sm:mb-6 mb-3 rounded-[10px] leading-none w-full"> <?php echo $table1_data['title']; ?></h1>
          <article class="info flex sm:flex-row flex-col sm:items-center sm:mb-6 mb-3">
            <section class="sm:mb-0 mb-2">
              <?php
              foreach ($words as $word) { ?>
                <button name="genre-01" class="bg-white p-[10px] sm:text-base text-[13px] font-[570] leading-none mr-2 rounded-[10px]"><?php echo $word ?></button>
              <?php } ?>
            </section>
            <section class="flex">
              <p name=" year" class="sm:separator leading-none font-[570] sm:text-base text-[13px] text-white mr-2">Year: <?php $release_date = $table1_data['release_date'];
                                                                                                                          $year = date('Y', strtotime($release_date));
                                                                                                                          echo $year; ?></p>
              <?php if ($type == 'movie') { ?>
                <p name="duration" class="separator leading-none font-[570] sm:text-base text-[13px] text-white mr-2">Duration : <?php echo $formattedDuration; ?></p>
              <?php } ?>
              <p name="imbdb-note" class="separator leading-none font-[570] sm:text-base text-[13px] text-white"> IMDB
                <?php
                $rounded = round($table1_data['imdb_vote'], 1);
                echo $rounded; ?></p>
            </section>
          </article>
          <article class="flex">
            <ul class="list-none mr-6">
              <li class="text-white sm:text-xs text-[10px] sm:mb-[10px] mb-2">Country : <span name="prog-country"><?php echo $table1_data['country']; ?></span></li>
              <li class="text-white sm:text-xs text-[10px]">Production : <span name="prog-prod"><?php echo $table1_data['production']; ?></span></li>
              <li class="text-white sm:text-xs text-[10px]">Language : <span name="prog-prod"><?php echo $table1_data['language']; ?></span></li>
            </ul>
            <ul class="list-none">
              <li class="text-white sm:text-xs text-[10px] sm:mb-[10px] mb-2">Date Release : <span name="prog-release"><?php echo $table1_data['release_date']; ?></span></li>
              <?php if ($type == 'movie') { ?>
                <li class="text-white sm:text-xs text-[10px] sm:w-[370px] w-[136.5px] line-clamp-2">Cast : <span name="prog-cast">
                  <?php
                  // to limit the number of cast
                  $limit = 9; // Set the limit to the desired number of items
                  $count = 0; // Initialize a counter

                  foreach ($table2_data as $data) {
                    echo $data['name'] . ', ';
                    $count++;

                    if ($count >= $limit) {
                      break; // Exit the loop once the limit is reached
                    }
                  }
                } ?></span></li>
            </ul>
          </article>
        </section>
        <section class="descriptif mt-auto">
          <p class="text-white font-[570] sm:text-[18px] text-sm line-clamp-6"><?php echo $table1_data['overview']; ?></p>
        </section>
      </article>
    </section>
    <section class="list-episode w-full h-fit bg-gray-900 border-[#B9B9B] border-1 rounded-xl p-[30px] mb-6 <?php echo ($type == 'movie') ? 'hidden' : 'block'; ?>">
      <article>
        <section class="mb-6">
          <!-- seasons dropdown -->
          <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white bg-pastelBlue hover:bg-[#5461B0] focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg sm:text-base text-sm px-3 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Seasons <svg class="w-2.5 h-2.5 ms-3 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
            </svg>
          </button>
          <!-- Dropdown menu -->
          <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="p-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButtonEpisode">
              <?php
              foreach ($seasons as $season) {
              ?>
                <li>
                  <a href="<?php echo $season['id']; ?>" class="block px-4 py-2 hover:bg-coloHover hover:text-white"><?php echo $season['title']; ?></a>
                </li>
              <?php } ?>
            </ul>
          </div>
        </section>
        <section class="w-full max-h-[200px] overflow-y-scroll">
          <!-- episodes  -->
          <ul id="episode-list" class="w-full grid sm:grid-cols-5 sm:grid-rows-2 auto-rows-auto gap-2">
            <!-- will be add from js with ajax -->
          </ul>
        </section>
      </article>
    </section>

    <!-- Main modal -->
    <!-- <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"> -->
    <!-- <div class="relative p-4 w-full max-w-2xl max-h-full"> -->
    <!-- Modal content -->
    <!-- <div class="relative bg-gray-900 rounded-lg shadow dark:bg-gray-700 w-[1000px] h-[700px]"> -->
    <!-- Modal header -->
    <!-- <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-400 hover:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-hide="default-modal">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div> -->
    <!-- Modal body -->
    <!-- <div class="p-4 md:p-5 space-y-4 w-full h-full">
            <iframe src="" id="episode_video" frameborder="0" class="w-full h-full"></iframe>
          </div>
        </div>
      </div>
    </div> -->
    <!-- ----------model end------------- -->

    <section class="cate-main w-full h-fit overflow-x-scroll mb-14">
      <article class="grid1 h-full space-y-3 sm:space-y-6">
        <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6">
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
      <?php if ($authenticated) { ?>
        <article name="Comment-Area" class="flex mb-10">
          <section class="w-full sm:w-[875px]">
            <article class="flex items-center mb-2">
              <!-- <div class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2"></div> -->
              <img src="./image/avatar_directory/<?php echo $user_data_avatar; ?>" alt="" class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2">
              <h2 name="current-name-user" class="text-white font-bold leading-none"><?php echo $user_data_username; ?></h2>
            </article>
            <div class="form-floating">
              <form action="" method="POST" class="flex flex-col">
                <textarea class="form-control w-full h-20 rounded-xl p-4 mb-1" placeholder="Leave a comment here..." id="floatingTextarea2" name="message-current-user"></textarea>
                <button type="submit" name="submit" class="send text-[12px] font-normal text-white w-fit hover:bg-[#424242] px-4 py-2 rounded-xl"><span class="text-[12px] font-normal text-white">Envoyé</span></button>
              </form>
            </div>
          </section>
        </article>
      <?php } ?>
      <?php
      //------------------------- comments--------------------------------------
      $query = '';
      if ($type == 'movie') {
        // Movie query
        $query = "SELECT users.username, users.avatar, movie_comments.comment, movie_comments.created_at
                    FROM users
                    INNER JOIN movie_comments ON users.user_id = movie_comments.user_id
                    WHERE movie_comments.movie_id = :movie_id
                    ORDER BY movie_comments.created_at DESC";
        $db_id = $table1_data['movie_id'];
      } else {
        // Series query
        $query = "SELECT users.username, users.avatar, tv_series_comments.comment, tv_series_comments.created_at
                    FROM users
                    INNER JOIN tv_series_comments ON users.user_id = tv_series_comments.user_id
                    WHERE tv_series_comments.tv_series_id = :tv_series_id
                    ORDER BY tv_series_comments.created_at DESC";
        $db_id = $table1_data['series_id'];
      }

      try {
        $stmt = $conn->prepare($query);
        // Bind the parameter based on the query type
        if ($type == 'movie') {
          $stmt->bindParam(':movie_id', $db_id, PDO::PARAM_INT);
        } else {
          $stmt->bindParam(':tv_series_id', $db_id, PDO::PARAM_INT);
        }

        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      if (isset($comments) && is_array($comments)) {
        foreach ($comments as $row) { ?>

          <article name="post-Area" class="flex mb-10">
            <section class="w-full sm:w-[875px]">
              <article class="flex items-center mb-2">
                <!-- <div class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2"></div> -->
                <img src="./image/avatar_directory/<?php echo $row['avatar']; ?>" class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2" alt="user image">
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
      <?php    }
      } ?>
    </section>
  </main>
  <?php include_once("./footer.php"); ?>
  <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Select all li elements within the ul
      const listItems = document.querySelectorAll('ul[aria-labelledby="dropdownHoverButtonEpisode"] li');

      // Function to handle the season selection and display episodes
      function loadEpisodes(item) {
        // Prevent the default link behavior if needed
        event.preventDefault();

        // Access the text inside the <a> tag
        let aTag = item.querySelector('a');
        let text = aTag.textContent;
        let season_id = aTag.getAttribute("href");

        // Log the clicked season (for debugging)
        console.log('You clicked on: ' + text + " id: " + season_id);

        // Create an XMLHttpRequest object
        const xhttp = new XMLHttpRequest();

        // Define a callback function
        xhttp.onload = function() {
          if (this.status === 200) { // Check if the request was successful
            // Parse the JSON string into a JavaScript object
            const episodes = JSON.parse(this.responseText);

            // Reference to the <ul> element where <li> elements will be added
            const episodeList = document.getElementById('episode-list');

            // Clear the list (in case it already has items)
            episodeList.innerHTML = '';

            // Loop through the episodes and create <li> elements
            episodes.forEach(function(episode) {
              // Create the <li> element
              const listItem = document.createElement('li');
              listItem.className = 'sm:w-[285.93px] w-full h-[56.72px] border-2 border-pastelBlue cursor-pointer rounded-xl p-4 flex items-center';

              // Create the <p> element inside the <li>
              const paragraph = document.createElement('p');
              paragraph.className = 'leading-none sm:text-base text-sm font-[570] text-[#6C6C6C]';
              paragraph.innerHTML = `Eps ${episode.episode_number} : <span class="font-normal" name="nameEpisode">${episode.title}  <b>IMDB:${episode.imdb_vote}</b></span>`;

              // Append the <p> to the <li>
              listItem.appendChild(paragraph);

              // Append the <li> to the <ul>
              episodeList.appendChild(listItem);

              // Add click event to each episode item to open the modal
              // listItem.addEventListener('click', function() {
              //   showModal(episode.trailer_id);
              // });
            });
          } else {
            console.error('Error fetching data:', this.status, this.statusText);
          }
        };

        // Send the request to fetch episodes
        xhttp.open("GET", `get_episode.php?season_id=${season_id}`, true);
        xhttp.send();
      }

      // Function to show the modal and set the iframe source
      // function showModal(trailer_id) {
      //   const modal = document.getElementById('default-modal');
      //   const iframe = document.getElementById('episode_video');
      //   const trailerUrl = `https://www.youtube.com/embed/${trailer_id}`; // Modify if using a different video service

      //   // Set the iframe src
      //   iframe.src = trailerUrl;

      //   // Show the modal
      //   modal.classList.remove('hidden');
      //   modal.classList.add('flex');
      // }

      // Function to hide the modal
      // function hideModal() {
      //   const modal = document.getElementById('default-modal');
      //   const iframe = document.getElementById('episode_video');

      //   // Remove the iframe src to stop the video
      //   iframe.src = '';

      //   modal.classList.add('hidden');
      //   modal.classList.remove('flex');
      // }

      // Loop through each li element and add an event listener
      listItems.forEach(function(item) {
        item.addEventListener('click', function(event) {
          loadEpisodes(item);
        });
      });

      // Automatically trigger click event on the first season to load episodes by default
      if (listItems.length > 0) {
        loadEpisodes(listItems[0]);
      }

      // Event listener for modal close buttons
      // const closeButtons = document.querySelectorAll('[data-modal-hide]');
      // closeButtons.forEach(function(button) {
      //   button.addEventListener('click', function() {
      //     hideModal();
      //   });
      // });
    });
  </script>

</body>

</html>