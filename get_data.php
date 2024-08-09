<?php

// make a request with the id and get data
// add data to database
// then select data from database and return
function get_data_from_api($id, $type, $api = API_KEY)
{
    $externalUrl = "https://api.themoviedb.org/3/$type/$id?&append_to_response=videos&api_key=$api";
    $response = @file_get_contents($externalUrl); // Use @ to suppress errors
    $externalData = $response ? json_decode($response) : null;
    // echo $externalData;
    if ($type == 'tv') {
        echo $tvapi_id = $id;
        echo $title = $externalData->name;
        echo $overview = $externalData->overview;
        echo $poster_path = $externalData->poster_path;

        $genres = [];
        if (isset($externalData->genres) && is_array($externalData->genres)) {
            foreach ($externalData->genres as $genre) {
                $genres[] = $genre->name;
            }
        }
        echo var_dump($genres);

        $trailer_id = '';
        foreach ($externalData->videos->results as $video) {
            if ($video->type === 'Trailer') {
                $trailer_id = $video->key;
                break; // Exit the loop once we find the first trailer
            }
        }
        echo $trailer_id;


        echo $toprated = 0;
        echo $popular = 1;
        echo $imdb_vote = $externalData->vote_average;

        $country = [];
        if (isset($externalData->production_countries) && is_array($externalData->production_countries)) {
            foreach ($externalData->production_countries as $countries) {
                // Ensure $countries is an object and has the 'name' property
                if (is_object($countries) && isset($countries->name)) {
                    $country[] = $countries->name;
                }
            }
        }

        echo var_dump($country);

        echo $release_date = $externalData->first_air_date;
        $production  = [];
        if (isset($externalData->production_companies) && is_array($externalData->production_companies)) {
            foreach ($externalData->production_companies as $companies) {
                $production[] = $companies->name;
            }
        }
        echo var_dump($production);
    }

    // if ($externalData) {
    //     echo json_encode(['source' => 'external', 'data' => $externalData]);
    // } else {
    //     echo json_encode(['source' => null, 'data' => null]);
    // }
}
// https://api.themoviedb.org/3/tv/1408?api_key=d5112f8a863bfa359d7688dcb740a21b

// https://api.themoviedb.org/3/tv/1408?&append_to_response=videos&api_key=d5112f8a863bfa359d7688dcb740a21b