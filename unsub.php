<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
	<title>unsubscribe</title>
</head>
<body>
	<p id="post"><b><h3> I hope you enjoyed our app !! You will be missed  &#x1F97A;</h3></address></b></p>

</body>
</html>

<?php
	$conn = mysqli_connect( 'sql6.freemysqlhosting.net' , 'sql6519889' , 'SNTJXSWpSs' , 'sql6519889' );

if ( ! $conn ) {
	die( 'Connection failed: ' . mysqli_connect_error() );
}
if ( ! isset( $_GET['email'] ) ) {
	header( 'Location: /404.php' );
}

$email = $_GET['email'] ;

if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
	header( 'Location: /404.php' );
}
	$stmt = $conn->prepare( 'SELECT email FROM `ed` WHERE email = ?' );
	$stmt->bind_param( 's', $email );
	$stmt->execute();
	$stmt->bind_result( $db_email );
	$stmt->fetch();
	$stmt->close();
if ( $email !== $db_email ) {
	header( 'Location: /404.php' );
} else {
		$stmt = $conn->prepare( 'DELETE FROM `ed` WHERE email = ?' );
		$stmt->bind_param( 's', $email );
		$stmt->execute();
}
