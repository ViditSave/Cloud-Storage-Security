<?php 
	session_start(); 
	if(isset($_POST['Uname']) & isset($_POST['DocID']) & isset($_POST['Type'])) {
		$file="ajax";
		include '../includeAll.php';
		if (($_POST['Type']=='Grant')|($_POST['Type']=='GiveFileAccess')) {
			$result = mysqli_query($connect, "SELECT User_ID FROM user WHERE User_Name='".$_POST['Uname']."'");
			if(mysqli_num_rows($result)==0)
				echo "No such User Name exists";
			else {
				$row = mysqli_fetch_array($result);
				$userID = $row['User_ID'];
			
				$tempUserPass = str_pad($_POST['DocID'],5,"0",STR_PAD_LEFT).str_pad($_POST['Uname'],20,".",STR_PAD_LEFT).str_pad($userID,5,"0",STR_PAD_LEFT);
				$timestamp = time();
				$UserPass = hash('sha256', $tempUserPass).$timestamp;
				
				$result = mysqli_query($connect, "SELECT Doc_Password FROM document WHERE Doc_ID='".$_POST['DocID']."'");
				$row = mysqli_fetch_array($result);
				$filePass = str_pad(hash('sha256', $row['Doc_Password']),74,"0",STR_PAD_LEFT);
				
				$finalPass = base64_encode($UserPass ^ $filePass); 
				
				mysqli_query($connect,"INSERT INTO accessdocument(Doc_ID, File_Pwd, Access_Expiry, User_Name) VALUES ('".$_POST['DocID']."','".$finalPass."',NOW(),'".$_POST['Uname']."')");
			}
		}
		else if ($_POST['Type']=='Revoke') {
			mysqli_query($connect,"DELETE FROM accessdocument WHERE User_Name='".$_POST['Uname']."' AND Doc_ID='".$_POST['DocID']."'");
		}
		else if ($_POST['Type']=='QRcode') {
			include('../Libraries/PHPQrcode/qrlib.php');
			$result = mysqli_query($connect, "SELECT File_Pwd FROM accessdocument WHERE User_Name='".$_POST['Uname']."' AND Doc_ID='".$_POST['DocID']."'");
			$row = mysqli_fetch_array($result);
			#$codeContents = "http://localhost/SecureStorage/displayFile.php?DocID=".$_POST['DocID']."&Pass=".$row['File_Pwd'];
			$codeContents = "http://securestore.com/SecureStorage/displayFile.php?DocID=".$_POST['DocID']."&Pass=".$row['File_Pwd'];
			QRcode::png($codeContents,'../Images/QRcodes/'.$_POST['DocID'].$_POST['Uname'].'.png');
			echo "<img src='Images/QRcodes/".$_POST['DocID'].$_POST['Uname'].".png' style='width:200px; height:200px; display:block; margin:auto;'>";
		}
		else if ($_POST['Type']=='Request') {
			mysqli_query($connect,"INSERT INTO requestdocument(User_ID, Doc_ID, Owner_ID, Timestamp) VALUES ('".$_POST['Uname']."', '".$_POST['DocID']."','".$_POST['OwnerID']."', NOW())");
		}
		else if ($_POST['Type']=='RemoveAccessRequest'){
			mysqli_query($connect,"DELETE FROM requestdocument WHERE User_ID='".$_POST['Uname']."' AND Doc_ID='".$_POST['DocID']."'");
		}
	}
?>