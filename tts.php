<?php
    require 'vendor/autoload.php';
    $googleAPIKey = 'AIzaSyDdSk0MAZfgx6P5VX60VWniRJBdcCilI_g';
    if( isset( $_POST['tts'] ) && !empty( $_POST['tts'] ) )
    {
            $articleText = $_POST['data'];
    } else {
        $articleText = 'no message found';
    }
    $articleText = '';
    $client = new GuzzleHttp\Client();
    $requestData = [
        'input' =>[
            'text' => $articleText
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
    file_put_contents('tts.mp3', base64_decode($fileData['audioContent']));
?>