<?php
require_once './inc/functions.php';
$conn = mysqli_connect( 'localhost', 'jai', 'kishanJai@13', 'user' );
$stmt = $conn->prepare( 'SELECT email FROM `ed` WHERE verified = 1' );
$stmt->execute();
$mailtoarr = array();
$stmt->store_result();
$stmt->bind_result( $mail );
if ( $stmt->num_rows > 0 ) {

	while ( $stmt->fetch() ) {
			$comic = get_comic();
			unset( $attachments );
			$title = $comic->safe_title;

		$file = file_get_contents( $comic->img );
		$encoded_file = chunk_split( base64_encode( $file ) );   // Embed image in base64 to send with email.

		$attachments[] = array(
			'name'     => $comic->title . '.jpg',
			'data'     => $encoded_file,
			'type'     => 'application/pdf',
			'encoding' => 'base64',
		);
		print_r( $attachments );
		$body = '
	   		<p >Hello Subscriber</p>
	   		Here is your Comic for the day
	   		<h3>' . $comic->safe_title . "</h3>
	   		<img src='" . $comic->img . "' alt='some comic hehe'/>
	   		<br />
	   		To read the comic head to <a target='_blank' href='https://xkcd.com/" . $comic->num . "'>Here</a><br />
	   		To unsubscribe kindly visit <a href='http://localhost/xkcd/unsub.php?email=$mail'>here.</a>";
		send_Comic( $mail, $title, $body, $attachments );
	}
			echo 'Sent Succesfully';
}
