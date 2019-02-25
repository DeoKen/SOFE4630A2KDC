<?php
    require 'vendor/autoload.php';
    $googleAPIKey = 'AIzaSyBFHwK7xiu0O1mlztwcg18yBYPdb-2f0Wk';
    $articleText = 'no message found';

    /*
    if( isset( $_GET['tts'] ) && !empty( $_GET['tts'] ) )
    {
            $articleText = $_GET['data'];
    } else {
        $articleText = 'no message found';
    }
    */
    use Google\Cloud\TextToSpeech\V1\AudioConfig;
    use Google\Cloud\TextToSpeech\V1\AudioEncoding;
    use Google\Cloud\TextToSpeech\V1\SynthesisInput;
    use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
    use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

    $textToSpeechClient = new TextToSpeechClient();

    $input = new SynthesisInput();
    $input->setText($articleText);
    $voice = new VoiceSelectionParams();
    $voice->setLanguageCode('en-US');
    $audioConfig = new AudioConfig();
    $audioConfig->setAudioEncoding(AudioEncoding::MP3);

    $resp = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
    file_put_contents('test.mp3', $resp->getAudioContent());
?>