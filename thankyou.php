<?php

	$conn = mysqli_connect( 'localhost' , 'jai' , 'kishanJai@13' , 'user' );

	if( !$conn ){
		die( "Connection failed: " . mysqli_connect_error() );
	}

	if( !isset( $_POST['submit'] ) ){
		die( "The request type is not a post" );
	}

	$email = $_POST['email'];
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo 'Not a valid Email address';
	}
	else{
	$vkey = md5( time().$email );
	$checkuser = "SELECT * from ed where email='$email'";
	$result = mysqli_query($conn,$checkuser);
	$count = mysqli_num_rows($result);
	if($count>0){
		// echo 'User already signed up with this email';
	}
	else{

	$sql = "INSERT INTO `ed` (`email`, `vkey`) VALUES ('$email','$vkey')";
	if( $conn->query( $sql ) )
	{
		$headers = 'Reply-To: itsmejaikishan2k@gmail.com' . "\r\n";
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
		$subject = 'Email verification';
		$message = "<p1>To Verify your account please follow the link :<a href = 'http://localhost/xkcd/validate.php?vkey=$vkey&email=$email'>Verify your account</a></p1>";

		mail($email,$subject,$message,$headers);

	}
	else
	{
		echo 'user not added';
	}
	}


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
	<title>Thankyou</title>
</head>
<body>
	<p id="post"><b>Thank You! Please check your inbox to confirm your Email address &#10024;</address></b></p>

</body>
</html>
