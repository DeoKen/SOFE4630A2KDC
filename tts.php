<?php

    require 'vendor/autoload.php';
    $articleText = 'no message found';
// Imports the Cloud Client Library
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
// instantiates a client
$client = new TextToSpeechClient();
// sets text to be synthesised
$synthesis_input = (new SynthesisInput())
    ->setText($articleText);
// build the voice request, select the language code ("en-US") and the ssml
// voice gender
$voice = (new VoiceSelectionParams())
    ->setLanguageCode('en-US')
    ->setSsmlGender(SsmlVoiceGender::FEMALE);
// select the type of audio file you want returned
$audioConfig = (new AudioConfig())
    ->setAudioEncoding(AudioEncoding::MP3);
// perform text-to-speech request on the text input with selected voice
// parameters and audio file type
$response = $client->synthesizeSpeech($synthesis_input, $voice, $audioConfig);
$audioContent = $response->getAudioContent();
// the response's audioContent is binary
file_put_contents('output.mp3', $audioContent);
echo 'Audio content written to "output.mp3"' . PHP_EOL;
    /*
    if( isset( $_GET['tts'] ) && !empty( $_GET['tts'] ) )
    {
            $articleText = $_GET['data'];
    } else {
        $articleText = 'no message found';
    }

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
    $file = file_put_contents('tts.mp3', base64_decode($fileData['audioContent']));

    echo "<audio controls><source src=".$file." type='audio/mpeg></audio>";
*/
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