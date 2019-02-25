<?php
require('vendor/autoload.php');
// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = new Aws\S3\S3Client([
    'version'  => 'latest',
    'region'   => 'us-east-2',
]);

$client = new Aws\Rekognition\RekognitionClient([
    'version'   =>  'latest',
    'region'    =>  'us-east-1',
]);

$bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');
$buckets = $s3->listBuckets();


foreach ($buckets['Buckets'] as $bucket) {
    echo $bucket['Name'] . "\n";
}

?>

<html>
    <head><meta charset="UTF-8"></head>
    <body>
        <h1>Hello SOFE4630</h1>
        <?php
            if(isset($_GET['value'])){
                $key = $_GET['value'];
                echo $key;
            }
            $image = file_get_contents('https://s3.us-east-2.amazonaws.com/sofe430a2kdc/'.$key);
            $result = $client->detectLabels([
                'Image' => [ // REQUIRED
                    'Bytes' =>
                ],
                'MaxLabels' => 10,
                'MinConfidence' => 20,
            ]);
            echo "im here";
            //echo $result;
            //echo $result['Name']['Confidence'];


        ?>
    </body>
</html>