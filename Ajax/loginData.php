<?php 	
	session_start();	
	$output="";
	if(isset($_POST['Uname']) & isset($_POST['Pass'])) {
		$ip=$_SERVER['REMOTE_ADDR'];
		$file="ajax";
		include '../includeAll.php';
		$fetchBrute=mysqli_query($connect,"SELECT Count FROM bruteforcecheck where IP_Addr='".$ip."'");
		$rowBrute=mysqli_fetch_assoc($fetchBrute);
		if(mysqli_num_rows($fetchBrute)!=0) {
			if ($rowBrute['Count']>=10) {
				$blockIP = 1;
				$output="Your IP has been Blocked for Multiple Incorrect Login Attempts | 2";
			}
		}
		if (!(isset($blockIP))) {
			$uname=$_POST["Uname"];
			$pass=$_POST["Pass"];
			$brute=0;
			$fetchSalt=mysqli_query($connect,"SELECT Salt FROM login where User_Name='".$uname."'");
			$rowSalt=mysqli_fetch_assoc($fetchSalt);
			if(mysqli_num_rows($fetchSalt)!=0) {
				
				$funType = "Login";
				$password = $pass;
				$salt = $rowSalt['Salt'];
				include 'keyHash.php';
				
				$fetchPass=mysqli_query($connect,"SELECT Password,User_ID FROM login where User_Name='".$uname."' and Salt='".$rowSalt['Salt']."'");
				$rowPass=mysqli_fetch_assoc($fetchPass);
				if(mysqli_num_rows($fetchPass)!=0) {
					#echo base64_encode($rowPass['Password'])." ".base64_encode($arr[0]);
					if ($rowPass['Password']==$finalKey){
						mysqli_query($connect,"UPDATE bruteforcecheck SET Count=0 , Timestamp=NOW() WHERE IP_Addr='".$ip."'");
						$output="Correct Username and Password | 1";
						$_SESSION["username"] = $uname;
						$_SESSION["userid"] = $rowPass["User_ID"];
						if (isset($_SESSION["viewFile"])) {
							$output = $_SESSION["viewFile"]." | 3";
							unset($_SESSION["viewFile"]);
						}
					}
					else {
						$brute=1;
					}
				}
				//pclose($pid);
			}
			else {
				$brute=1;
			}
			if ($brute==1) {
				$fetchBrute=mysqli_query($connect,"SELECT * FROM bruteforcecheck where IP_Addr='".$ip."'");
				$rowBrute=mysqli_fetch_assoc($fetchBrute);
				if(mysqli_num_rows($fetchBrute)!=0) {
					mysqli_query($connect,"UPDATE bruteforcecheck SET Count=Count+1 , Timestamp=NOW() WHERE IP_Addr='".$ip."'");
				}
				else {
					mysqli_query($connect,"INSERT INTO bruteforcecheck(IP_Addr, Count, Timestamp) VALUES ('".$ip."',1,NOW())");
				}
				$output="Incorrect Username or Password | 2";
			}
		}
		else {
			unset($blockIP);
		}
	}
	echo $output;
?>