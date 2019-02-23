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
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile']['tmp_name'])) {

	// try upload

	// for now, use existing name
	$uploadfolder = 'somefolder';
	$uploadname = $_FILES['userfile']['name'];

	// set up s3
	$bucket = getenv('S3_BUCKET');
	$keyname = $uploadfolder.'/'.$uploadname;
	// try
	try {
	    // Upload data.
	    $result = $s3->putObject(array(
	        'Bucket' => $bucket,
	        'Key'    => $keyname,
	        'Body'   => fopen($_FILES['userfile']['tmp_name'], 'rb'),
	        'ACL'    => 'public-read'
	    ));

	    // Print the URL to the object.

	    // show image
	    echo('<p><img src="'.$result['ObjectURL'].'" /></p>');

	} catch (S3Exception $e) {
	    echo $e->getMessage() . "\n";
	}

}
else {
	?>
		<h2>Upload a file</h2>
        <form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <input name="userfile" type="file"><input type="submit" value="Upload">
        </form>

	<?
};
?>
</html>