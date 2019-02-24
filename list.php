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
			"Bucket" => $bucket
		));
		foreach ($objects as $object) {
?>
		<p> <a href="<?=htmlspecialchars($s3->getObjectUrl($bucket, $object['Key']))?>"> <?echo "<img src="$object['Key'] . "><br>";?></a></p>

<?		}?>

<?php } catch(Exception $e) { ?>
        <p>error :(</p>
<?php }  ?>
/*
try {
    $results = $s3->getPaginator('ListObjects', [
        'Bucket' => $bucket['Name']
    ]);

    foreach ($results as $result) {
        foreach ($result['Contents'] as $object) {
        echo $object['Key'] . PHP_EOL;
                // Get the object.
        $result1 = $s3->getObjectUrl([
            'Bucket' => $bucket['Name'],
            'Key'    => $object['Key']
        ]);
        echo "<img src=" . $object['Key']."><br>";
    }
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
*/
?>
    </body>
</html>