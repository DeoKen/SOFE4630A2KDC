<?php
require('vendor/autoload.php');
// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = new Aws\S3\S3Client([
    'version'  => '2006-03-01',
    'region'   => 'us-east-2',
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
		<h3>S3 Files</h3>
<?php
	try {
		$objects = $s3->getIterator('ListObjects', array(
			"Bucket" => $bucket['Name']
		));
		foreach ($objects as $object) {
		echo "<p> <a href=";
		htmlspecialchars(
		$s3->getObjectUrl([
		    $bucket['Name'],
		    $object['Key']
		]));
		echo "><img src=https://s3.us-east-2.amazonaws.com/sofe430a2kdc/".$object['Key'] . " height='100' width='100'><br></a></p>";

		}

} catch(Exception $e) {
        echo $e->getMessage() . PHP_EOL;
 }

?>
    </body>
</html>