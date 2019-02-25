<?php

    require 'vendor/autoload.php';

    if( isset( $_POST['tts'] ) && !empty( $_POST['tts'] ) )
    {
        $textToS = $_POST['tts'];
        echo $textToS;

    } else {
        $textToS = 'no message found';
        echo $textToS;
    }
    $file = "tts";
    $file = $file . ".mp3";
    //file_put_contents($file, "");
    $googleAPIKey = 'AIzaSyBFHwK7xiu0O1mlztwcg18yBYPdb-2f0Wk';
    $client = new GuzzleHttp\Client();
    $requestData = [
        'input' =>[
            'text' => $textToS
        ],
        'voice' => [
            'languageCode' => 'en-US',
            'name' => 'en-US-Wavenet-F'
        ],
        'audioConfig' => [
            'audioEncoding' => 'MP3',
            'pitch' => 0.00,
            'speakingRate' => 1.00
        ]
    ];
    try {
        $response = $client->request('POST', 'https://texttospeech.googleapis.com/v1beta1/text:synthesize?key=' . $googleAPIKey, [
            'json' => $requestData
        ]);
    } catch (Exception $e) {
        die('Something went wrong: ' . $e->getMessage());
    }
    $fileData = json_decode($response->getBody()->getContents(), true);
    file_put_contents($file, base64_decode($fileData['audioContent']));
    if (filesize($file)>0){
        echo "<audio controls autoplay><source src=".$file." type=audio/mp3></audio>";
    }
    echo'<a href=https://sofe4630a2kdc.herokuapp.com>HOME</a>';
    //header("Location: index.php");
    //exit();
?>

