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
    // check if there is a request
    if(isset($_GET['title'])){
        $searchTerm =$_GET['title'];
        // echo "resived data: ".$data;
        // SELECT * FROM users WHERE fname like '%".$name."%'
        // Prepare the SQL query with a placeholder for the title
        $query = $conn->prepare("SELECT movieapi_id, title, poster_path FROM movies WHERE title LIKE :title");

        // Bind the search term to the placeholder, wrapping it with wildcards
        $query->bindValue(':title', $searchTerm . '%');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // Convert the results into JSON format
        $jsonResult = json_encode($result);

        // Set the content type header to application/json
         header('Content-Type: application/json');

        // Output the JSON string
         echo $jsonResult;

    }
//get the name form the request






require_once('env.php');
// if the movie not found in db
// searching the movie inside the api
// https://developer.themoviedb.org/docs/search-and-query-for-details#search

if(isset($_GET['advance_search'])){
    $data = rawurlencode($_GET['advance_search']);

    $url="https://api.themoviedb.org/3/search/multi?api_key=$API_KEY&query=$data";
    // Fetching movie data
    $file_data = file_get_contents($url);

    // Check if file_get_contents returned anything
    if ($file_data === FALSE) {
        echo json_encode(['error' => 'Failed to fetch data from API']);
        exit();
    }

    $json_data = json_decode($file_data, true);  // Decode as an associative array

    // Check for JSON errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Failed to decode JSON']);
        exit();
    }

    // Check if data is available and then send it as JSON
    if (!empty($json_data)) {
        echo json_encode($json_data);  // Convert the array back to JSON and send it
    } else {
        echo json_encode(['error' => 'No data found']);  // Send an error message as JSON
    }
}




// api request
// https://api.themoviedb.org/3/search/movie?query=Jack+Reacher&api_key=API_KEY

// example result
// "poster_path": "/IfB9hy4JH1eH6HEfIgIGORXi5h.jpg",  
// "adult": false,  
// "overview": "Jack Reacher must uncover the truth behind a major government conspiracy in order to clear his name. On the run as a fugitive from the law, Reacher uncovers a potential secret from his past that could change his life forever.",  
// "release_date": "2016-10-19",  
// "genre_ids": [  
//   53,  
//   28,  
//   80,  
//   18,  
//   9648  
// ],  
// "id": 343611,  
// "original_title": "Jack Reacher: Never Go Back",  
// "original_language": "en",  
// "title": "Jack Reacher: Never Go Back",  
// "backdrop_path": "/4ynQYtSEuU5hyipcGkfD6ncwtwz.jpg",  
// "popularity": 26.818468,  
// "vote_count": 201,  
// "video": false,  
// "vote_average": 4.19  
// }


// send the result back