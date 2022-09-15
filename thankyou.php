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
	<h id="post"><b><h3>Thank You! Please check your inbox to confirm your Email address &#10024;</h3></b></h>

</body>
</html>
<?php

	$conn = mysqli_connect( 'localhost' , 'jai' , 'kishanJai@13' , 'user' );

	if( !$conn ){
		die( "Connection failed: " . mysqli_connect_error() );
	}

	if( !isset( $_POST['submit'] ) ){
		die( 'The request type is not a post' );
	}

	$email = $_POST['email'];
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo 'Not a valid Email address' ;
	}
	else{
	$vkey      = md5( time().$email );
	$checkuser = "SELECT * from ed where email='$email'";
	$result    = mysqli_query($conn,$checkuser);
	$count     = mysqli_num_rows($result);
    echo "'\u{1F389}'";
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
		$subject = 'Verify your XKCD subscription!';
		$message = "
		<p >Hello Subscriber</p>
		<h2>Please Verify Your account</h2>
				<br />
				<td align='center' style='margin:0;text-align:center'><a href='http://localhost/xkcd/validate.php?vkey=$vkey&email=$email' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Verify!</a></td>
		";

		mail($email,$subject,$message,$headers);

	}
	else
	{
		echo 'user not added';
	}
	}


}
