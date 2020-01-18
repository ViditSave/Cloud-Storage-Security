<?php 	
	session_start();	
	$output="";
	if(isset($_POST['Uname']) & isset($_POST['Pass'])) {
		$ip=$_SERVER['REMOTE_ADDR'];
		$connect = mysqli_connect("localhost", "root", "", "SecureStorage") or die("could not select database");
		$fetchBrute=mysqli_query($connect,"SELECT Count FROM BruteForceCheck where IP_Addr='".$ip."'");
		$rowBrute=mysqli_fetch_assoc($fetchBrute);
		if(mysqli_num_rows($fetchBrute)!=0) {
			if ($rowBrute['Count']>=10)
				$output="Your IP has been Blocked for Multiple Incorrect Login Attempts";
			else {
				$uname=$_POST["Uname"];
				$pass=$_POST["Pass"];
				$brute=0;
				$fetchSalt=mysqli_query($connect,"SELECT Salt FROM Login where User_Name='".$uname."'");
				$rowSalt=mysqli_fetch_assoc($fetchSalt);
				if(mysqli_num_rows($fetchSalt)!=0) {
					$command = "python ../Python/keyHash.py Login ".$pass." ".$rowSalt['Salt'];
					$pid = popen( $command,"r");
					$py=fread($pid, 256);
					$arr= explode(" ",$py);
					$fetchPass=mysqli_query($connect,"SELECT Password,User_ID FROM Login where User_Name='".$uname."' and Salt='".$rowSalt['Salt']."'");
					$rowPass=mysqli_fetch_assoc($fetchPass);
					if(mysqli_num_rows($fetchPass)!=0) {
						if ($rowPass['Password']==$arr[0]){
							mysqli_query($connect,"UPDATE BruteForceCheck SET Count=0 , Timestamp=NOW() WHERE IP_Addr='".$ip."'");
							$output="Correct Username and Password | 1";
							$_SESSION["username"] = $uname;
							$_SESSION["userid"] = $rowPass["User_ID"];
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
					$output="Incorrect Username or Password | 2";
				}
			}
		}
	}
	echo $output;
?>