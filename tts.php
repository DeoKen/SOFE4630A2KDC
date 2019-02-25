<?php
    require 'vendor/autoload.php';
    $articleText = 'no message found';

    /*
    if( isset( $_GET['tts'] ) && !empty( $_GET['tts'] ) )
    {
            $articleText = $_GET['data'];
    } else {
        $articleText = 'no message found';
    }
    */
    $googleAPIKey = 'AIzaSyBFHwK7xiu0O1mlztwcg18yBYPdb-2f0Wk';
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
<html>
    <head><meta charset="UTF-8"></head>
    <body>
        <p>Google TTS</p>
        <form action="tts.php" method="get" id="tts">
        <input type="text" name="tts">
        <input type="submit">
    </body>
</html>