<?php
require('vendor/autoload.php');
// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = new Aws\S3\S3Client([
    'version'  => 'latest',
    'region'   => 'us-east-2',
]);

//gets the bucket
$bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');

$buckets = $s3->listBuckets();//this list all the buckets
foreach ($buckets['Buckets'] as $bucket) {
    //echo $bucket['Name'] . "\n";
}

?>
<html>
    <head><meta charset="UTF-8"></head>
    <body>
        <h1>SOFE4630 A2 100579215</h1>

<?php
//checking if there is a file
if(isset($_FILES['file'])){
    $file = $_FILES['file'];
    //making the file
    $name=$file['name'];
    $tempname=$file['tempname'];
    $extension=explode('.',$name);
    $extension=strtolower(end($extension));
    //puting the file object to the bucket
    try{
        $s3->putObject([
            'Bucket'=>$bucket['Name'],
            'Key'=>"{$name}",
            'Body'=>fopen($_FILES['file']['tmp_name'], 'rb'),
            'ACL'=>'public-read'
        ]);
    }
    catch(Exception $e){
        echo $e->getMessage() . PHP_EOL;
    }
}
?>
<form enctype="multipart/form-data" action="" method="POST">
            <input name="file" type="file"><input type="submit" value="Upload">
</form>
		<h3>S3 Bucket Files</h3>
<?php
    //listing all the objects in the bucket
	try {
		$objects = $s3->getIterator('ListObjects', array(
			"Bucket" => $bucket['Name']
		));
		foreach ($objects as $object) {
		    //echo the html format to show all the bucket pictures
		    echo "<a href=https://sofe4630a2kdc.herokuapp.com/rekognition.php?value=".$object['Key'].">";
		    echo "<img src=https://s3.us-east-2.amazonaws.com/sofe430a2kdc/";
		    echo $object['Key'] . " height='100' width='100'><br><br></a>";
		}

    } catch(Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }

?>
        <p>Get emailed list of S3 Bucket files</p>
        <form action="email.php" method="post" id="data">
        <input type="text" name="data">
        <input type="submit">
        </form>
        <p>Google TTS</p>
        <form action="tts.php" method="post" id="tts">
        <input type="text" name="tts">
        <input type="submit">
        </form>

    </body>
</html>


</body>
</html>