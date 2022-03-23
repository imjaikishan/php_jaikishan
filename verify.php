<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'vendor/PHPMailer-master/src/Exception.php';
	require 'vendor/PHPMailer-master/src/PHPMailer.php';
	require 'vendor/PHPMailer-master/src/SMTP.php';

if( isset( $_GET['vkey'] ) )
{
	$curl = curl_init();
	curl_setopt_array ( $curl,[ CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => 'https://api.github.com/repos/octocat/hello-world/issues/42/timeline',
	CURLOPT_USERAGENT=>'GitHub Timeline'] );

	$data = curl_exec( $curl );

	$vkey = $_GET['vkey'];
	$conn = mysqli_connect( 'localhost' , 'jai' , 'kishanJai@13' , 'user' );
	$email = $_GET['email'];
	echo $email;
	$result = $conn->query("SELECT vkey,verified FROM ed WHERE verified = 0 AND vkey = '$vkey' LIMIT 1");
	if( $result->num_rows == 1){
		//validate email
		$update = $conn->query("UPDATE ed SET verified = 1 WHERE vkey = '$vkey' LIMIT 1");
		if ($update){
			echo 'Your account has been verified';
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->SMTPDebug = 2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
			$mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
			$mail->Port = '587'; // TLS only
			$mail->SMTPSecure = 'tls'; // ssl is depracated
			$mail->SMTPAuth = 'true';
			$mail->Username = 'itsmejaikishan2k@gmail.com';
			$mail->Password = 'zmewzsvrotaiqudn';
			$mail->setFrom( 'itsmejaikishan2k@gmail.com', 'Jaikishan' );
			$mail->addAddress( $email );
			$mail->Subject = 'Timeline Update';
			$mail->msgHTML($data); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
			$mail->AltBody = 'HTML messaging not supported';

			if(!$mail->send()){
				echo "Mailer Error: ";
			}
			else
			{
				echo "Message sent!";
			}
		}
		else {
			echo $conn->error;
		}
	}
	else {
		echo 'this account is invalid or already verified';
	}
}
else{
	die("Something went wrong");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Verification Followed by Github timeline update</title>
</head>
<body>

</body>
</html>
