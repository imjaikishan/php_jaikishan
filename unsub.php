<?php
$conn = mysqli_connect( 'localhost' , 'jai' , 'kishanJai@13' , 'user' );

if( !$conn ){
	die( "Connection failed: " . mysqli_connect_error() );
}
if ( ! isset( $_GET['email'] ) ) {
	header( 'Location: /404.php' );
}

$email = $_GET['email'];

if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL )) {
	header( 'Location: /404.php' );
}
	$stmt = $conn->prepare( 'SELECT email FROM `ed` WHERE email = ?' );
	$stmt->bind_param( 's', $email);
	$stmt->execute();
	$stmt->bind_result( $db_email);
	$stmt->fetch();
	$stmt->close();
if ( $email !== $db_email ) {
	header( 'Location: /404.php' );
} else {
		$stmt = $conn->prepare( 'UPDATE `ed` SET verified = 0 WHERE email = ?' );
		$stmt->bind_param( 's', $email );
		$stmt->execute();
	}
	echo 'unsubed';
?>
