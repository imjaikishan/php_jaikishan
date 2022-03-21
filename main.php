<?php
	//connecting with the mysql server and database
	$conn = mysqli_connect('localhost' , 'jai' , 'kishanJai@13' , 'user' );
	if ( !$conn ){
		echo 'not connected to databse';
	}
	if( isset($_POST['signup'])){
		$email = $_POST['email'];
		$vkey = md5(time().$email);
		//checking duplicate user
		$checkuser = "SELECT * from ed where email= '$email'";
		$result = mysqli_query($conn,$checkuser);
		$count = mysqli_num_rows($result);
		if($count>0){
			echo 'user already signed up with this email';
		}
		else{
			$sql = "INSERT INTO `ed`(`email`, `vkey`) VALUES ('$email','$vkey')";
			if( $conn->query( $sql ) )
			{
				echo 'user added';
				//sending mail
				$to = $email;
				$from = "itsmejaikishan2k@gmail.com";
				$subject = "Email Verification token";
				$message = "Your token is : -'$vkey'";
				$headers = "From:" . $from;
				mail($to,$subject,$message,$headers);
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
	<title>rtCamp assignment</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>User data </h2>
  <form method="POST">
	<div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>

    <button type="submit" name="signup" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
</html>
