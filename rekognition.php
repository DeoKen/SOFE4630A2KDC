<?php
require('vendor/autoload.php');
// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = new Aws\S3\S3Client([
    'version'  => 'latest',
    'region'   => 'us-east-2',
]);

$rekog = new Aws/Rekognition/RekognitionClient([
    'vertion'   =>  'latest',
    'region'    => 'us-east-2',
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
            //if(isset($_GET['value'])){
                //$key = $_GET['value'];
                //echo $key;
            //}
            /*
            $result = $rekog->detectLabels([
                'Image' => [ // REQUIRED
                    'S3Object' => [
                        'Bucket' => $bucket['Name'],
                        'Name' => '{$key}',
                    ],
                ],
                'MaxLabels' => 10,
                'MinConfidence' => 20,
            ]);
            */
            //echo $result;
            //echo $result['Name']['Confidence'];
        ?>
    </body>
</html>