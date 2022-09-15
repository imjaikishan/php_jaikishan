<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
	<title>Subscription</title>
</head>
<body>
	<h id="post"><b><h3>Thank You! Your Subscription has been activated &#128079;</h3></b></h>

</body>
</html>
<?php


require_once './inc/functions.php';
$conn = mysqli_connect( 'sql6.freemysqlhosting.net' , 'sql6519889' , 'SNTJXSWpSs' , 'sql6519889' );

if ( ! $conn ) {
	die( 'Connection failed: ' . mysqli_connect_error() );
}
if ( isset( $_GET['vkey'] ) ) {
	$vkey   = $_GET['vkey'];
	$result = $conn->query( "SELECT vkey,verified FROM ed WHERE verified = 0 AND vkey = '$vkey' LIMIT 1" );
	$email  = isset( $_GET['email'] );
	if ( 1 === $result->num_rows ) {
		// validate email.
		$update = $conn->query( "UPDATE ed SET verified = 1 WHERE vkey = '$vkey' LIMIT 1" );

		if ( $update ) {
			$comic = get_comic();
			$title = $comic->safe_title;

			$file         = file_get_contents( $comic->img );
			$encoded_file = chunk_split( base64_encode( $file ) );   // Embed image in base64 to send with email.

			$attachments[] = array(
				'name'     => $comic->title . '.jpg',
				'data'     => $encoded_file,
				'type'     => 'application/pdf',
				'encoding' => 'base64',
			);
			$body          = '
	   		<p >Hello Subscriber</p>
	   		Here is your Comic for the day
	   		<h3>' . $comic->safe_title . "</h3>
	   		<img src='" . $comic->img . "' alt='some comic hehe'/>
	   		<br />
	   		To read the comic head to <a target='_blank' href='https://xkcd.com/" . $comic->num . "'>Here</a><br />
	   		To unsubscribe kindly visit <a href='http://localhost/xkcd/unsub.php?email=$email'>here.</a>
	   		";
			send_comic( $email, $title, $body, $attachments );
		} else {
			die( 'Something went wrong' );
		}
	} else {
		echo 'this account is invalid or already verified';
	}
} else {
	die( 'Something went wrong' );
}
