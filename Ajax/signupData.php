<?php 
	session_start();	
	$output="";

	if(isset($_POST['Fname']) & isset($_POST['Lname']) & isset($_POST['Email']) & isset($_POST['Contact']) & isset($_POST['Uname']) & isset($_POST['Pass'])) {
		$fname=$_POST["Fname"];
		$lname=$_POST["Lname"];
		$email=$_POST["Email"];
		$contn=$_POST["Contact"];
		$uname=$_POST["Uname"];
		$passw=$_POST["Pass"];
		$output="";
		if ((strlen($contn)!=10)&(strlen($contn)!=8)|(!(ctype_digit($contn)))) {
			$output="Please enter the Contact Number correctly (8 or 10 digits)";
			echo "Contact | ";
		}
		if ($email=="") {
			$output="Please enter the Email ID correctly.";
			echo "Email | ";
		}
		if ((strlen($passw)<8)|(strlen($passw)>16)) {
			$output="Please enter the Password correctly (Between 8 to 16 characters)";
			echo "Pass | ";
		}
		if ((strlen($uname)>15)|($uname=="")) {
			$output="The User Name has been taken (Under 15 characters)";
			echo "Uname | ";
		}
		if (($lname=="")|(!ctype_alpha($lname))) {
			$output="Please enter the Last Name correctly.";
			echo "Lname | ";
		}
		if (($fname=="")|(!ctype_alpha($fname))) {
			$output="Please enter the First Name correctly.";
			echo "Fname | ";
		}
		if ($output!="")
			echo $output;
		else {
			$ip=$_SERVER['REMOTE_ADDR'];
			$connect = mysqli_connect("localhost", "root", "", "SecureStorage") or die("could not select database");
			$insertQuery="INSERT INTO User(User_Fname, User_Lname, User_email, User_Contact, User_RegDate) VALUES ('$fname','$lname','$email','$contn', NOW())";
			mysqli_query($connect,$insertQuery);
			$sql_val="SELECT User_ID FROM User where User_Fname='$fname' and User_Lname='$lname' and User_email='$email'";
			$result_val=mysqli_query($connect,$sql_val);
			$row_val = mysqli_fetch_array($result_val);
			$command = "python ../Python/keyHash.py Signup ".$passw;
			$pid = popen( $command,"r");
			$py=fread($pid, 256);
			$arr= explode(" ",$py);
			$sql_login="INSERT INTO Login VALUES (".$row_val['User_ID'].",'$uname','$arr[0]', '$arr[1]')";
			mysqli_query($connect,$sql_login);
			$_SESSION["username"] = $uname;
			$_SESSION["userid"] = $row_val["User_ID"];
			echo "6 | Verified and Added to the database";
		}
	}
	else {
		header('Location:index.php');
	}
?>