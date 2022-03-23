<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'vendor/PHPMailer-master/src/Exception.php';
	require 'vendor/PHPMailer-master/src/PHPMailer.php';
	require 'vendor/PHPMailer-master/src/SMTP.php';

	$conn = mysqli_connect( 'localhost' , 'jai' , 'kishanJai@13' , 'user' );

	if( !$conn ){
		die( "Connection failed: " . mysqli_connect_error() );
	}

	if( !isset( $_POST['signup'] ) ){
		die( "The request type is not a post" );
	}

	$email = $_POST['email'];
	$vkey = md5( time().$email );
  $sql = "INSERT INTO `ed`(`email`, `vkey`) VALUES ('$email','$vkey')";
		if( $conn->query( $sql ) )
		{
			echo 'user added';
		}
		else
		{
			echo 'user not added';
		}


	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
	$mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
	$mail->Port = '587'; // TLS only
	$mail->SMTPSecure = 'tls'; // ssl is depracated
	$mail->SMTPAuth = 'true';
	$mail->Username = 'itsmejaikishan2k@gmail.com';
	$mail->Password = 'zmewzsvrotaiqudn';
	$mail->setFrom( 'itsmejaikishan@gmail.com', 'Jaikishan' );
	$mail->addAddress( $email, 'Jaikishan' );
	$mail->Subject = 'User Verification';
	$mail->msgHTML("<a href='http://192.168.18.23/rtCamp/verify.php?vkey=$vkey'>Register account</a>"); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
	$mail->AltBody = 'HTML messaging not supported';

	if(!$mail->send()){
		echo "Mailer Error: ";
	}
	else
	{
		echo "Message sent!";
	}
?>
