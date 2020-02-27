<?php 
	$filePass = str_pad(hash('sha256',$fileKey),74,"0",STR_PAD_LEFT);
	if (isset($_GET['DocID']) & isset($_GET['Pass'])) {
		$documentID = $_GET['DocID'];
		$userPass = $_GET['Pass'];
	}
	else {
		$result = mysqli_query($connect, "SELECT File_Pwd FROM accessdocument WHERE User_Name='".$_SESSION["username"]."' AND Doc_ID='".$_POST['DocID']."'");
		$row = mysqli_fetch_array($result);
		if(mysqli_num_rows($result)==0)
			echo "Error Retriving File";
		else {
			$documentID = $_POST['DocID'];
			$userPass = $row['File_Pwd'];
		}
	}
	$urlGenPassword = str_split(base64_decode($userPass)^$filePass, 64);
	
	$tempCheckPass = str_pad($documentID,5,"0",STR_PAD_LEFT).str_pad($_SESSION["username"],20,".",STR_PAD_LEFT).str_pad($_SESSION["userid"],5,"0",STR_PAD_LEFT);
	$checkPass = hash('sha256', $tempCheckPass);
	
	$fileFinalRes = 0;
	if ($urlGenPassword[0] == $checkPass)
		if ($urlGenPassword[1] >= time())
			$fileFinalRes = 1;
		else 
			$fileFinalRes = 2;
	else 
		$fileFinalRes = 0;
?>