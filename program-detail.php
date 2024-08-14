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
    $query = " SELECT movies.*, movie_cast.* FROM movies INNER JOIN movie_cast ON movies.movieapi_id  = movie_cast.movieapi_id WHERE movies.movieapi_id = :id;";
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

    //genre
    $string = $table1_data['genres'];
    // Split the string into an array using ', ' as the delimiter
    $words = explode(', ', $string);
    // Optionally, trim whitespace from each word
    $words = array_map('trim', $words);


    //changing the time format
    function formatDuration($minutes)
    {
        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;
        return sprintf("%d h / %d min", $hours, $remainingMinutes);
    }
    $duration = $table1_data['duration'];
    $formattedDuration = formatDuration($duration);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <title>Getflix | <?php echo $table1_data['title']; ?></title>
</head>

<body class="bg-halfBlack h-screen w-screen">
    <?php include_once("./header.php"); ?>
    <main class="container mx-auto w-full mt-14">
        <section class="porg-detail flex w-full h-[801px] mb-28">
            <img class="bg-gray-500 rounded-xl h-full w-[679px] mr-14" name="img-cat_08" src="http://image.tmdb.org/t/p/w500/<?php echo $table1_data['poster_path']; ?>" alt="poster">
            <article class="flex flex-col w-[801px] h-full justify-between mb-14">
                <section class="w-full">
                    <h1 name="name-prog"
                        class="bg-pastelBlue text-white py-4 pl-4 text-[34px] text-1 font-[570] uppercase mb-6 rounded-[10px] leading-none w-full">
                        <?php echo $table1_data['title']; ?></h1>
                    <article class="info flex items-center mb-6">
                        <?php
                        foreach ($words as $word) { ?>
                            <button name="genre-01" class="bg-white p-[10px] text-base font-[570] leading-none mr-2 rounded-[10px]"><?php echo $word ?></button>
                        <?php } ?>

                        <p name="year" class="font-[570] text-base text-white mr-2">Year: <?php
                                                                                            $release_date = $table1_data['release_date'];
                                                                                            $year = date('Y', strtotime($release_date));
                                                                                            echo $year; ?></p>
                        <p name="duration" class="font-[570] text-base text-white mr-2">Duration : <?php echo $formattedDuration; ?></p>
                        <p name="imbdb-note" class="font-[570] text-base text-white"> <?php echo $table1_data['imdb_vote']; ?></p>
                    </article>
                    <article class="flex">
                        <ul class="list-none mr-6">
                            <li class="text-white text-xs mb-[10px]">Country : <span name="prog-country"><?php echo $table1_data['country']; ?></span></li>
                            <li class="text-white text-xs">Production : <span name="prog-prod"><?php echo $table1_data['production']; ?></span></li>
                        </ul>
                        <ul class="list-none">
                            <li class="text-white text-xs mb-[10px]">Date Release : <span name="prog-release"><?php echo $table1_data['release_date']; ?></span></li>
                            <li class="text-white text-xs w-[370px]">Cast : <span name="prog-cast">
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
                <section>
                    <!-- <video class="bg-gray-500 rounded-xl min-h-[238px] w-[417px] mb-6" name="trailer-video" controls>
                        <source src="https://www.youtube.com/embed/<?php echo $table1_data['trailer_id']; ?>?autoplay=0&controls=1" type="video/mp4">
                    </video> -->
                    <iframe class='rounded-xl min-h-[238px] w-[417px] mb-6' src="https://www.youtube.com/embed/<?php echo $table1_data['trailer_id']; ?>?autoplay=0&controls=1" frameborder="0"></iframe>

                    <p class="text-white font-[570] text-[18px]">Overview: <?php echo $table1_data['overview']; ?></p>
                </section>
            </article>
        </section>
        <section class="suggestion w-full mb-28">
            <article class="grid1 w-full h-fit space-y-6  overflow-x-auto">
                <div
                    class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-6">
                    <h1 name="category-01" class="text-white text-[56px] font-[570] uppercase break-words">You may also
                        like</h1>
                    <a href="#" class="self-end"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie"
                            class="w-[72px] h-[72px] self-end"></a>
                </div>
                <div class="grid-item  bg-gray-500 rounded-xl ml-6" name="img-cat-3">0.1</div>
                <div class="grid-item bg-gray-500 rounded-xl ml-6" name="img-cat-1">1</div>
                <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-6" name="img-cat-2">2</div>
                <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl" name="img-cat-3">3</div>
                <div class="grid-item bg-gray-500 rounded-xl ml-6" name="img-cat-3">4</div>
                <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-6" name="img-cat-4">5</div>
                <div class="grid-item bg-gray-500 rounded-xl ml-6" name="img-cat-5">6</div>
            </article>
        </section>
        <section class="w-full mb-14">
            <h1 class="text-white uppercase text-2xl font-semibold mb-14">Comments</h1>
            <article name="Comment-Area" class="flex mb-10">
                <div class="w-[104px] h-[104px] bg-greyWhite rounded-full mr-4"></div>
                <section>
                    <h2 name="current-name-user" class="text-white font-bold leading-none mb-2">User</h2>
                    <div class="form-floating">
                        <form action="#" method="POST" class="flex flex-col">
                            <textarea class="form-control w-[875px] h-20 rounded-xl p-4 mb-1"
                                placeholder="Leave a comment here..." id="floatingTextarea2"
                                name="message-current-user"></textarea>
                            <button type="submit" name="submit"
                                class="send text-[12px] font-normal text-white w-fit hover:bg-[#424242] px-4 py-2 rounded-xl"><span
                                    class="text-[12px] font-normal text-white">Envoyé</span></button>
                        </form>
                    </div>
                </section>
            </article>
            <article name="post-Area" class="flex mb-10">
                <div class="w-[104px] h-[104px] bg-greyWhite rounded-full mr-4"></div>
                <section>
                    <h2 name="current-name-user" class="text-white font-bold leading-none mb-2">User</h2>
                    <div class="screen-message w-[875px] h-20 rounded-xl p-4 mb-1 bg-greyWhite" name="message-user">
                    </div>
                    <div class="flex">
                        <button class="p-2 hover:bg-[#424242] mr-2 rounded-full"><img
                                src="image/thumb_up_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Up"
                                class="w-[18px] h-[18px]"></button>
                        <button class="p-2 hover:bg-[#424242] rounded-full"><img
                                src="image/thumb_down_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Down"
                                class="w-[18px] h-[18px]"></button>
                        <!-- <button type="submit" name="submit" class="send flex hover:bg-[#424242] px-4 py-2 rounded-xl"><img src="image/reply_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Reply-Icon" class="w-[18px] h-[18px] mr-1"><span class="text-[12px] font-normal text-white">Reply</span></button> -->
                    </div>
                </section>
            </article>
            <article name="post-Area" class="flex mb-10">
                <div class="w-[104px] h-[104px] bg-greyWhite rounded-full mr-4"></div>
                <section>
                    <h2 name="current-name-user" class="text-white font-bold leading-none mb-2">User</h2>
                    <div class="screen-message w-[875px] h-20 rounded-xl p-4 mb-1 bg-greyWhite" name="message-user">
                    </div>
                    <div class="flex">
                        <button class="p-2 hover:bg-[#424242] mr-2 rounded-full"><img
                                src="image/thumb_up_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Up"
                                class="w-[18px] h-[18px]"></button>
                        <button class="p-2 hover:bg-[#424242] rounded-full"><img
                                src="image/thumb_down_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Down"
                                class="w-[18px] h-[18px]"></button>
                        <!-- <button type="submit" name="submit" class="send flex hover:bg-[#424242] px-4 py-2 rounded-xl"><img src="image/reply_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Reply-Icon" class="w-[18px] h-[18px] mr-1"><span class="text-[12px] font-normal text-white">Reply</span></button> -->
                    </div>
                </section>
            </article>
            <article name="post-Area" class="flex mb-10">
                <div class="w-[104px] h-[104px] bg-greyWhite rounded-full mr-4"></div>
                <section>
                    <h2 name="current-name-user" class="text-white font-bold leading-none mb-2">User</h2>
                    <div class="screen-message w-[875px] h-20 rounded-xl p-4 mb-1 bg-greyWhite" name="message-user">
                    </div>
                    <div class="flex">
                        <button class="p-2 hover:bg-[#424242] mr-2 rounded-full"><img
                                src="image/thumb_up_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Up"
                                class="w-[18px] h-[18px]"></button>
                        <button class="p-2 hover:bg-[#424242] rounded-full"><img
                                src="image/thumb_down_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Down"
                                class="w-[18px] h-[18px]"></button>
                        <!-- <button type="submit" name="submit" class="send flex hover:bg-[#424242] px-4 py-2 rounded-xl"><img src="image/reply_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Reply-Icon" class="w-[18px] h-[18px] mr-1"><span class="text-[12px] font-normal text-white">Reply</span></button> -->
                    </div>
                </section>
            </article>
        </section>
    </main>
    <?php include_once("./footer.php"); ?>
</body>

</html>