<?php
require_once('dbh.inc.php'); // Include database connection
$conn = $pdo;
/**
 * Fetch data from the API, insert it into the database, and return the inserted data.
 *
 * @param int $id The ID of the movie or TV show.
 * @param string $type The type of content ('movie' or 'tv').
 * @param string $api The API key for the TMDb API.
 * @return string JSON encoded data of the inserted movie or TV show.
 */
function get_data_from_api($id, $type, $api = API_KEY)
{
    $error = false; // Initialize error tracking
    $externalUrl = "https://api.themoviedb.org/3/$type/$id?&append_to_response=videos&api_key=$api"; // API URL
    $response = file_get_contents($externalUrl); // Fetch the API response
    $externalData = $response ? json_decode($response) : null; // Decode the response

    // Global variable for database connection
    global $conn;

    // Check if the API response is valid
    if (!$externalData) {
        return json_encode(['error' => 'Failed to fetch data from API.']);
    }

    // If the type is 'tv' (TV series)
    if ($type == 'tv') {
        $tvapi_id = $id; // TV series ID
        $title = $externalData->name; // Title of the TV series
        $overview = $externalData->overview; // Overview of the TV series
        $poster_path = $externalData->poster_path; // Poster path

        // Extract genres
        $genres = [];
        if (isset($externalData->genres) && is_array($externalData->genres)) {
            foreach ($externalData->genres as $genre) {
                $genres[] = $genre->name;
            }
        }

        // Extract trailer ID (if available)
        $trailer_id = '';
        foreach ($externalData->videos->results as $video) {
            if ($video->type === 'Trailer') {
                $trailer_id = $video->key;
                break;
            }
        }

        $toprated = 0;
        $popular = 1;
        $imdb_vote = $externalData->vote_average;

        // Extract production countries
        $country = [];
        if (isset($externalData->production_countries) && is_array($externalData->production_countries)) {
            foreach ($externalData->production_countries as $countries) {
                $country[] = $countries->name;
            }
        }

        $release_date = $externalData->first_air_date;

        $language = isset($externalData->spoken_languages[0]->english_name) ? $externalData->spoken_languages[0]->english_name : 'no';

        // Extract production companies
        $production = [];
        if (isset($externalData->production_companies) && is_array($externalData->production_companies)) {
            foreach ($externalData->production_companies as $companies) {
                $production[] = $companies->name;
            }
        }

        // Insert TV series data into the database
        $stmt = $conn->prepare("INSERT INTO tv_series (tvapi_id, title, overview, poster_path,genres, trailer_id, toprated, popular,imdb_vote,country,language,release_date, production) VALUES (:tvapi_id, :title, :overview, :poster_path, :genres,:trailer_id,:toprated, :popular,:imdb_vote,:country,:language,:release_date,:production)");
        $stmt->execute([
            ':tvapi_id' => $tvapi_id,
            ':title' => $title,
            ':overview' => $overview,
            ':poster_path' => $poster_path,
            ':genres' => implode(', ', $genres),
            ':trailer_id' => $trailer_id,
            ':toprated' => $toprated,
            ':popular' => $popular,
            ':imdb_vote' => $imdb_vote,
            ':country' => implode(', ', $country),
            ':language' => $language,
            ':release_date' => $release_date,
            ':production' => implode(', ', $production)
        ]);

        // Check if the insertion was successful
        if ($stmt->rowCount() > 0) {
            $tv_series_id = $conn->lastInsertId(); // Get the last inserted ID
            $error = false;
        } else {
            $error = true;
            return json_encode(['error' => 'Failed to insert TV series data.']);
        }

        // Insert seasons and episodes
        if (isset($externalData->seasons)) {
            foreach ($externalData->seasons as $season) {
                $season_number = $season->season_number;
                $title = $season->name;
                $poster_path = !empty($season->poster_path) ? $season->poster_path : "no";
                $release_date = !empty($season->air_date) ? $season->air_date : '1970-01-01';

                $trailer_id = 'no';
                $season_videos_json = file_get_contents("https://api.themoviedb.org/3/tv/" . $tvapi_id . "'/season/" . $season_number . "/videos?language=en-US&api_key=" . $api);
                $season_videos = json_decode($season_videos_json);
                if (isset($season_videos->results)) {
                    foreach ($season_videos->results as $key) {
                        if ($key->type == "Trailer") {
                            $trailer_id = $key->key;
                            break;
                        }
                    }
                }

                $stmt = $conn->prepare("INSERT INTO seasons (tv_series_id, season_number, title, poster_path, trailer_id, release_date)
                                        VALUES (:tv_series_id, :season_number, :title, :poster_path, :trailer_id, :release_date)");
                $stmt->execute([
                    ':tv_series_id' => $tv_series_id,
                    ':season_number' => $season_number,
                    ':title' => $title,
                    ':poster_path' => $poster_path,
                    ':trailer_id' => $trailer_id,
                    ':release_date' => $release_date
                ]);

                if ($stmt->rowCount() > 0) {
                    $season_id = $conn->lastInsertId(); // Get the last inserted ID
                    $error = false;
                } else {
                    $error = true;
                }

                // Fetch and insert episodes
                $episode_data_json = file_get_contents("https://api.themoviedb.org/3/tv/" . $tvapi_id . "/season/" . $season_number . "?language=en-US&api_key=" . $api);
                $episode_data = json_decode($episode_data_json);

                foreach ($episode_data->episodes as $episode) {
                    $episode_number = !empty($episode->episode_number) ? $episode->episode_number : "no";
                    $title = !empty($episode->name) ? $episode->name : "no";
                    $overview = !empty($episode->overview) ? $episode->overview : "no";
                    $poster_path = !empty($episode->still_path) ? $episode->still_path : "no";
                    $release_date = !empty($episode->air_date) ? $episode->air_date : '1970-01-01';
                    $duration = !empty($episode->runtime) ? $episode->runtime : "0";
                    $imdb_vote = !empty($episode->vote_average) ? $episode->vote_average : "0";

                    $episode_trailer_id = "0";
                    $episode_video_json = file_get_contents("https://api.themoviedb.org/3/tv/" . $tvapi_id . "/season/" . $season_number . "/videos?language=en-US&api_key=" . $api);
                    $episode_video = json_decode($episode_video_json);

                    if (isset($episode_video->results)) {
                        foreach ($episode_video->results as $key) {
                            if ($key->type == "Trailer") {
                                $episode_trailer_id = $key->key;
                                break;
                            }
                        }
                    }

                    // Insert episode data into the database
                    $stmt = $conn->prepare("INSERT INTO episodes (season_id, episode_number, title, overview, poster_path, trailer_id, release_date, duration, imdb_vote)
                                            VALUES (:season_id, :episode_number, :title, :overview, :poster_path, :trailer_id, :release_date, :duration,:imdb_vote)");
                    $stmt->execute([
                        ':season_id' => $season_id,
                        ':episode_number' => $episode_number,
                        ':title' => $title,
                        ':overview' => $overview,
                        ':poster_path' => $poster_path,
                        ':trailer_id' => $episode_trailer_id,
                        ':release_date' => $release_date,
                        ':duration' => $duration,
                        ':imdb_vote' => $imdb_vote
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $error = false;
                    } else {
                        $error = true;
                    }
                }
            }
        }

        // After inserting all data, fetch and return the inserted TV series data
        if (!$error) {
            $inserted_data_stmt = $conn->prepare("SELECT tv_series.*,tv_series.id as series_id FROM tv_series  WHERE tv_series.tvapi_id = :tvapi_id;");
            $inserted_data_stmt->execute([':tvapi_id' => $tvapi_id]);
            $inserted_data = $inserted_data_stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($inserted_data); // Return the data in JSON format
        }
    } else {
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // If the type is 'movie'

        $movieapi_id = $externalData->id;
        $title = $externalData->original_title;

        // Extract genres
        $genres = [];
        if (isset($externalData->genres) && is_array($externalData->genres)) {
            foreach ($externalData->genres as $genre) {
                $genres[] = $genre->name;
            }
        }

        // Extract trailer ID
        $trailer_id = isset($externalData->videos->results[0]->key) ? $externalData->videos->results[0]->key : 'no';
        // Extract language
        $language = isset($externalData->spoken_languages[0]->english_name) ? $externalData->spoken_languages[0]->english_name : '';
        // Extract country
        $country = isset($externalData->production_countries[0]->name) ? $externalData->production_countries[0]->name : '';
        // Extract production companies
        $production = [];
        if (isset($externalData->production_companies) && is_array($externalData->production_companies)) {
            foreach ($externalData->production_companies as $companies) {
                $production[] = $companies->name;
            }
        }

        // Insert movie data into the database
        $stmt = $conn->prepare("INSERT INTO movies (movieapi_id, title, overview, poster_path, toprated, popular, imdb_vote, release_date, trailer_id, genres, language, country, duration, production)
                                VALUES (:movieapi_id, :title, :overview, :poster_path, :toprated, :popular, :imdb_vote, :release_date, :trailer_id, :genres, :language, :country, :duration, :production)");
        $stmt->execute([
            ':movieapi_id' => $movieapi_id,
            ':title' => $title,
            ':overview' => $externalData->overview,
            ':poster_path' => $externalData->poster_path,
            ':toprated' => 0,
            ':popular' => 1,
            ':imdb_vote' => !empty($externalData->vote_average) ? $externalData->vote_average : '0',
            ':release_date' => $externalData->release_date,
            ':trailer_id' => $trailer_id,
            ':genres' => implode(", ", $genres),
            ':language' => $language,
            ':country' => $country,
            ':duration' => isset($externalData->runtime) ? $externalData->runtime : 0,
            ':production' => implode(", ", $production)
        ]);


        //getting single movie casts
        $movies_cast_Url = "https://api.themoviedb.org/3/movie/" . $movieapi_id . "/credits?language=en-US&api_key=" . $api;
        $movies_cast = file_get_contents($movies_cast_Url);
        $movies_cast_datas = json_decode($movies_cast);

        if ($movies_cast_datas && isset($movies_cast_datas->cast)) {
            foreach ($movies_cast_datas->cast as $cast) {
                if ($cast->known_for_department == "Acting") { //checking to get only the actors
                    $actor_name = $cast->original_name;
                    $department = $cast->known_for_department;
                    if ($cast->profile_path == '') {
                        $image_path = 'null';
                    } else {
                        $image_path = $cast->profile_path;
                    }
                    $character_name = $cast->character;

                    //add to the table of movie_cast (will take one movieapi_id and will and all the actors)
                    // Prepare and execute the insert statement
                    $cast_stmt = $conn->prepare("INSERT INTO movie_cast (movieapi_id, name,department,image_path,character_name) VALUES (:movieapi_id, :name,:department,:image_path,:character_name)");

                    $cast_result = $cast_stmt->execute([
                        ':movieapi_id' => $movieapi_id,
                        ':name' => $actor_name,
                        ':department' => $department,
                        ':image_path' => $image_path,
                        ':character_name' => $character_name
                    ]);
                }
            }
        }




        // After inserting, fetch and return the inserted movie data
        if ($stmt->rowCount() > 0) {
            $inserted_data_stmt = $conn->prepare("SELECT movies.*,movies.id as movie_id, movie_cast.* ,'movie' as type FROM movies INNER JOIN movie_cast ON movies.movieapi_id  = movie_cast.movieapi_id WHERE movies.movieapi_id = :movieapi_id;");
            $inserted_data_stmt->execute([':movieapi_id' => $movieapi_id]);
            $inserted_data = $inserted_data_stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($inserted_data); // Return the data in JSON format
        } else {
            return json_encode(['error' => 'Failed to insert movie data.']);
        }
    }
}
