<?php

    require 'vendor/autoload.php';
    //getting the text inputted by the user
    if( isset( $_POST["tts"] ) && !empty( $_POST["tts"] ) )
    {
        $textToS = $_POST["tts"];
        echo $textToS;

    } else {
        $textToS = "no message found";
        echo $textToS;
    }
    //creating the .mp3 file
    $file = "tts";
    $file = $file . ".mp3";
    //the google api key used
    $googleAPIKey = "AIzaSyBFHwK7xiu0O1mlztwcg18yBYPdb-2f0Wk";
    //the google api did not work correctly but using json proved to be just as useful
    $client = new GuzzleHttp\Client();
    //this formats the json request data to comply with the api
    $requestData = [
        "input" =>[
            "text" => $textToS
        ],
        "voice" => [
            "languageCode" => "en-US",
            "name" => "en-US-Wavenet-F"
        ],
        "audioConfig" => [
            "audioEncoding" => "MP3",
            "pitch" => 0.00,
            "speakingRate" => 1.00
        ]
    ];
    //requesting for the data from google cloud
    try {
        $response = $client->request("POST", "https://texttospeech.googleapis.com/v1beta1/text:synthesize?key=" . $googleAPIKey, [
            "json" => $requestData
        ]);
    } catch (Exception $e) {
        die("Something went wrong: " . $e->getMessage());
    }
    //getting the data from the response from google cloud.
    $fileData = json_decode($response->getBody()->getContents(), true);
    //putting the contents into $file and encodes it to be useable for .mp3 format
    file_put_contents($file, base64_decode($fileData["audioContent"]));
    //this makes it so that if there is a data, it will make the html element
    if (filesize($file)>0){
        //echo the html element to play the audiofile
        echo "<audio controls autoplay><source src=".$file." type=audio/mp3></audio>";
    }
    echo"<a href=https://sofe4630a2kdc.herokuapp.com>HOME</a>";
    //header("Location: index.php");
    //exit();
?>

