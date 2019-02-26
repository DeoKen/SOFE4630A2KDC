<?php
require('vendor/autoload.php');
// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = new Aws\S3\S3Client([
    'version'  => 'latest',
    'region'   => 'us-east-2',
]);
//getting the amazon rekognition client
$client = new Aws\Rekognition\RekognitionClient([
    'version'   =>  'latest',
    'region'    =>  'us-east-2',
]);

$bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');

?>

<html>
    <head><meta charset="UTF-8"></head>
    <body>
        <h1>Amazon Rekognition</h1>
        <?php
            //gets the value from the picture when they are clicked
            if(isset($_GET['value'])){
                $key = $_GET['value'];
            }
            echo "<h2>Analyzing ".$key."</h2>";
            try {
                //calling the detectlabels function from the rekognition api
                //it tells the api to analyze the picture from the s3 bucket
                //the key is the picture the user clicked.
                $result = $client->detectLabels([
                    'Image' => [ // REQUIRED
                        'S3Object' => [
                            'Bucket' => $bucket,
                            'Name' => $key,
                        ],
                    ],
                    'MaxLabels' => 10,
                    'MinConfidence' => 20,
                ]);
                //outputting the results in the form of an html table
                echo '<table>';
                for ($n=0;$n<sizeof($result['Labels']); $n++){
                    //echo '<tr>';
                    echo '<tr><td> Name: ' . $result['Labels'][$n]['Name'] . '</td>';
                    echo '<td> Confidence: ' . $result['Labels'][$n]['Confidence'] . '</td></tr>';
                    ///echo '</tr>';
                }
                echo '</table><a href=https://sofe4630a2kdc.herokuapp.com/>HOME</a>';
            } catch(Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }



        ?>
    </body>
</html>