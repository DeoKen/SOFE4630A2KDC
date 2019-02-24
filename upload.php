<?php
require('vendor/autoload.php');
// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = new Aws\S3\S3Client([
    'version'  => '2006-03-01',
    'region'   => 'us-east-1',
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

		<a href="https://sofe4630a2kdc.herokuapp.com/list.php">Files List</a>
<?php
if(isset($_FILES['file'])){
    $file = $_FILES['file'];

    $name=$file['name'];
    $tempname=$file['tempname'];
    $extension=explode('.',$name);
    $extension=strtolower(end($extension));
    $key=md5(uniqid());
    $tempfname="{$key}.{$extension}";
    $tempfpath="uploads/{$tempfname}";

    move_uploaded_file($tempfname, $tempfpath);

    try{
        $s3->putObject([
            'Bucket'=>$bucket,
            'Key'=>"pics/{$name}",
            'Body'=>fopen($tempfpath, 'rb'),
            'ACL'=>'public-read'
        ]);
    }
    catch(S3Exception $e){
        die("error");
    }
}



</html>