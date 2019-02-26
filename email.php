<?php
require('vendor/autoload.php');
// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = new Aws\S3\S3Client([
    'version'  => 'latest',
    'region'   => 'us-east-2',
]);
$bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');

$buckets = $s3->listBuckets();
foreach ($buckets['Buckets'] as $bucket) {
    //echo $bucket['Name'] . "\n";
}

//getting the ses client
$SesClient = new Aws\Ses\SesClient([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);
//the sender email which has been verified by amazon
$sender_email = 'k_jasper0.1@hotmail.com';
//getting the email address provided by the user
if( isset( $_POST['data'] ) && !empty( $_POST['data'] ) )
{
    $recipient_emails = $_POST['data'];
    echo "recipeint is: ".$recipient_emails."<br>";
} else {
    echo("no email");
}

//getting files list from the s3 bucket
$filelist="";
try {
    $results = $s3->getPaginator('ListObjects', [
        'Bucket' => $bucket['Name']
    ]);

    foreach ($results as $result) {
        foreach ($result['Contents'] as $object) {
            echo $object['Key'] . PHP_EOL;
            //adds the file names in the bucket to the variable
            $filelist .= $object['Key'] . PHP_EOL;
        }
    }
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
//the subject file of the email
$subject = 'S3 File List';
//the actual message
$plaintext_body = $filelist;
//the body, basically the ad
$html_body =  '<h1>AWS Amazon Simple Email Service Test Email</h1>'.
              '<p>This email was sent with <a href="https://aws.amazon.com/ses/">'.
              'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">'.
              'AWS SDK for PHP</a>.</p><br><br><p>This was sent from https://sofe4630a2kdc.herokuapp.com</p>'.$filelist;
$char_set = 'UTF-8';
try {
    //setting up the configuration to send the email
    $result = $SesClient->sendEmail([
        'Destination' => [
            'ToAddresses' => [$recipient_emails],
        ],
        'ReplyToAddresses' => [$sender_email],
        'Source' => $sender_email,
        'Message' => [
          'Body' => [
              'Html' => [
                  'Charset' => $char_set,
                  'Data' => $html_body,
              ],
              'Text' => [
                  'Charset' => $char_set,
                  'Data' => $plaintext_body,
              ],
          ],
          'Subject' => [
              'Charset' => $char_set,
              'Data' => $subject,
          ],
        ],
    ]);
    //getting the message id of the email
    $messageId = $result['MessageId'];
    echo "Email sent! Message ID: $messageId"."\n";
    echo "<a href=https://sofe4630a2kdc.herokuapp.com/>HOME</a>";
} catch (AwsException $e) {
    // output error message if fails
    echo $e->getMessage();
    echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
    echo "\n";
}
?>
