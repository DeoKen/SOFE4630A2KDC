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
    ->setText('Hello, world!');
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
file_put_contents($file, $audioContent);
    //if (filesize($file)>0){
        echo "<audio controls><source src=".$file." type=audio/mp3></audio>";
    //}

?>
<html>
    <head><meta charset="UTF-8"></head>
    <body>
        <p>Google TTS</p>
        <form action="tts.php" method="post" id="tts">
        <input type="text" name="tts">
        <input type="submit">
        </form>
        <a href=https://sofe4630a2kdc.herokuapp.com>HOME</a>
    </body>
</html>