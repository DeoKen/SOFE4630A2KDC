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
    $file = "tts";
    $file = $file . ".mp3";
    file_put_contents($file, base64_decode($fileData['audioContent']));

    echo "<audio controls><source src=".$file." type=audio/mp3></audio>";

?>
<html>
    <head><meta charset="UTF-8"></head>
    <body>
        <p>Google TTS</p>
        <form action="tts.php" method="get" id="tts">
        <input type="text" name="tts">
        <input type="submit">
        <audio controls><source src=<?php echo $file; ?> type=audio/mp3></audio>
    </body>
</html>