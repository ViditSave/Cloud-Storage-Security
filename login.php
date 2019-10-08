<?php 	
session_start();	
$output="";
if(isset($_POST["submit"])) {
	$ip=$_SERVER['REMOTE_ADDR'];
	$op=0;
	$connect = mysqli_connect("localhost", "root", "", "SecureStorage") or die("could not select database");
	$fetchBrute=mysqli_query($connect,"SELECT Count FROM BruteForceCheck where IP_Addr='".$ip."'");
	$rowBrute=mysqli_fetch_assoc($fetchBrute);
	if(mysqli_num_rows($fetchBrute)!=0) {
		if ($rowBrute['Count']>=10) {
			$output="Your IP has been Blocked for Multiple Incorrect Login Attempts";
		}
		else {
			$op=1;
		}
	}
	else {
		$op=1;
	}
	if ($op ==1) {
		$uname=$_POST["username"];
		$pass=$_POST["pass"];
		$brute="0";
		$fetchSalt=mysqli_query($connect,"SELECT Salt FROM Login where User_Name='".$uname."'");
		$rowSalt=mysqli_fetch_assoc($fetchSalt);
		if(mysqli_num_rows($fetchSalt)!=0) {
			$command = "python keyHash.py Login ".$pass." ".$rowSalt['Salt'];
			$pid = popen( $command,"r");
			$py=fread($pid, 256);
			$arr= explode(" ",$py);
			$fetchPass=mysqli_query($connect,"SELECT Password,User_ID FROM Login where User_Name='".$uname."' and Salt='".$rowSalt['Salt']."'");
			$rowPass=mysqli_fetch_assoc($fetchPass);
			if(mysqli_num_rows($fetchPass)!=0) {
				if ($rowPass['Password']==$arr[0]){
					mysqli_query($connect,"UPDATE BruteForceCheck SET Count=0 , Timestamp=NOW() WHERE IP_Addr='".$ip."'");
					$output="Correct Username and Password";
					
					$_SESSION["username"] = $uname;
					$_SESSION["userid"] = $rowPass["User_ID"];
					header('Location:index.php');
				}
				else {
					$brute=1;
				}
			}
			pclose($pid);
		}
		else {
			$brute=1;
		}
		if ($brute==1) {
			$fetchBrute=mysqli_query($connect,"SELECT * FROM BruteForceCheck where IP_Addr='".$ip."'");
			$rowBrute=mysqli_fetch_assoc($fetchBrute);
			if(mysqli_num_rows($fetchBrute)!=0) {
				mysqli_query($connect,"UPDATE BruteForceCheck SET Count=Count+1 , Timestamp=NOW() WHERE IP_Addr='".$ip."'");
			}
			else {
				mysqli_query($connect,"INSERT INTO BruteForceCheck(IP_Addr, Count, Timestamp) VALUES ('".$ip."',1,NOW())");
			}
			$output="Incorrect Username or Password";
		}
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
			.blur{width: 50%; padding:25px 20px; background-color:white; border-radius: 25px; margin:100px auto;}
			.loginButton{color:white; background-color:#000080; padding: 7px 10px; width:25%; border-radius: 15px;}
			@media (min-width: 350px) and (max-width:550px)  {
				.blur{width: 80%; margin: 50px auto;}
				.loginButton{padding: 7px 10px; width:50%;}
			}
		</style>
	</head>
	<?php include 'navbar.php'; ?>
	<body style="background-image: linear-gradient(#000080, #6666ff, #6666ff); margin:0px; position:relative; min-height:100%;">
		<div class="blur">
			<h1 style="color:#000080; margin:0px;"><b><center>Login</center></b></h2><br>
			<form method="post" action="login.php">
				<table>
					<tr>
						<th>Username</th>
						<td>:<input type="text" name="username" placeholder="  Enter User Name"></td>
					</tr>
					<tr>
						<th>Password</th>
						<td>:<input type="password" name="pass" id="password" placeholder="  Enter Password"></td>
					</tr>
				</table><br>
				<center><input type="submit" class="button loginButton" value="Submit" name="submit"></center>
			</form>
			<p style="color:red; text-align:center;"><?php echo "$output"; ?></p>
		</div>
	<?php include 'footer.php'; ?>
	</body>
</html>