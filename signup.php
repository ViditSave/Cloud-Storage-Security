<?php 		
session_start();
$output="";
if(isset($_POST["submit"])) {
	$fname=$_POST["fname"];
	$lname=$_POST["lname"];
	$email=$_POST["email"];
	$contn=$_POST["cnumb"];
	$uname=$_POST["uname"];
	$passw=$_POST["pwd"];
	if (($fname=="")|($lname=="")|(!ctype_alpha($fname))|(!ctype_alpha($lname))) { 
		$output="Please enter the Name correctly.";
	}
	else if ($email=="") {
		$output="Please enter the Email ID correctly.";
	}
	else if ((strlen($contn)!=10)&(strlen($contn)!=8)|(!(ctype_digit($contn)))) {
		$output="Please enter the Contact Number correctly (8 or 10 digits)";
	}
	else if ((strlen($uname)>15)|($uname=="")) {
		$output="Please enter the User Name correctly (Under 15 characters)";
	}
	else if ((strlen($passw)<8)|(strlen($passw)>16)) {
		$output="Please enter the Password correctly (Between 8 to 16 characters)";
	}
	else {
		$ip=$_SERVER['REMOTE_ADDR'];
		$connect = mysqli_connect("localhost", "root", "", "SecureStorage") or die("could not select database");
		$insertQuery="INSERT INTO User(User_Fname, User_Lname, User_email, User_Contact, User_RegDate) VALUES ('$fname','$lname','$email','$contn', NOW())";
		mysqli_query($connect,$insertQuery);
		$sql_val="SELECT User_ID FROM User where User_Fname='$fname' and User_Lname='$lname' and User_email='$email'";
		$result_val=mysqli_query($connect,$sql_val);
		$row_val = mysqli_fetch_array($result_val);
		
		$command = "python keyHash.py Signup ".$passw;
		$pid = popen( $command,"r");
		$py=fread($pid, 256);
		$arr= explode(" ",$py);
		$sql_login="INSERT INTO Login VALUES (".$row_val['User_ID'].",'$uname','$arr[0]', '$arr[1]')";
		mysqli_query($connect,$sql_login);
		$output="Verified and Added to the database";
		
		$_SESSION["username"] = $uname;
		$_SESSION["userid"] = $row_val["User_ID"];
		header('Location:index.php');		
	}
}
?>
<html>
	<head>
		<title>Login Screen</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>
			*{font-family:Verdana;}
			table{width:90%;text-align:left;margin:auto; color:black;}
			input{margin-left:10px; width:85%; height:35px; border-radius: 10px;}
			.blur{width: 50%; padding:25px 20px; background-color:white; border-radius: 25px; margin:15px auto;}
			.signinButton{color:white; background-color:#000080; padding: 7px 10px; width:25%; border-radius: 15px;}
			@media (min-width: 350px) and (max-width:550px)  {
				.blur{width: 80%; margin: 15px auto;}
				.signinButton{padding: 7px 10px; width:50%;}
			}
		</style>
	</head>
	<?php include 'navbar.php'; ?>
	<body style="background-image: linear-gradient(#000080, #6666ff, #6666ff); margin:0px; position:relative; min-height:100%;">
		<div class="blur">
			<h1 style="color:#000080; margin:0px;"><b><center>Sign Up</center></b></h2><br>
			<form method="post" action="signup.php">
				<table>
					<tr>
						<th>First Name</th>
						<td>:<input type="text" name="fname" placeholder="  Enter your First Name" value="<?php echo isset($_POST["fname"]) ? $_POST["fname"] : ''; ?>"></td>
					</tr>
					<tr>
						<th>Last Name</th>
						<td>:<input type="text" name="lname" placeholder="  Enter your Last Name" value="<?php echo isset($_POST["lname"]) ? $_POST["lname"] : ''; ?>"></td>
					</tr>
					<tr>
						<th>Email ID</th>
						<td>:<input type="text" name="email" placeholder="  Enter your Email ID for verification" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>"></td>
					</tr>
					<tr>
						<th>Contact No.</th>
						<td>:<input type="text" name="cnumb" placeholder="  Enter your Contact Number" value="<?php echo isset($_POST["cnumb"]) ? $_POST["cnumb"] : ''; ?>"></td>
					</tr>
					<tr>
						<th>Username</th>
						<td>:<input type="text" name="uname" placeholder="  Enter your User Name" value="<?php echo isset($_POST["uname"]) ? $_POST["uname"] : ''; ?>"></td>
					</tr>
					<tr>
						<th>Password</th>
						<td>:<input type="password" name="pwd" placeholder="  Enter your Password" value="<?php echo isset($_POST["pwd"]) ? $_POST["pwd"] : ''; ?>"></td>
					</tr>
				</table><br>
				<center><input type="submit" class="button signinButton" value="Submit" name="submit"></center>
			</form>
			<p style="color:red; text-align:center;"><?php echo "$output"; ?></p>
		</div>
	<?php include 'footer.php'; ?>
	</body>
</html>