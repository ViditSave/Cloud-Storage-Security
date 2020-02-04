<?php 
	session_start(); 
	if(isset($_POST['Uname']) & isset($_POST['DocID']) & isset($_POST['Type'])) {
		$file="ajax";
		include '../includeAll.php';
		if ($_POST['Type']=='Grant') {
			$pwd='12345678';
			mysqli_query($connect,"INSERT INTO accessdocument(Doc_ID, File_Pwd, Access_Expiry, User_Name) VALUES ('".$_POST['DocID']."','".$pwd."',NOW(),'".$_POST['Uname']."')");
		}
		else if ($_POST['Type']=='Revoke') {
			mysqli_query($connect,"DELETE FROM accessdocument WHERE User_Name='".$_POST['Uname']."' AND Doc_ID='".$_POST['DocID']."'");
		}
		else if ($_POST['Type']=='QRcode') {
			include('../Libraries/PHPQrcode/qrlib.php'); 
			$codeContents = "Your Link is :".$_POST['DocID'].$_POST['Uname'];
			QRcode::png($codeContents,'../Images/QRcodes/'.$_POST['DocID'].$_POST['Uname'].'.png');
			echo "<img src='Images/QRcodes/".$_POST['DocID'].$_POST['Uname'].".png' style='width:120px; height:120px; display:block; margin:auto;'>";
		}
		else if ($_POST['Type']=='Request') {
			mysqli_query($connect,"INSERT INTO requestdocument(User_ID, Doc_ID, Owner_ID, Timestamp) VALUES ('".$_POST['Uname']."', '".$_POST['DocID']."','".$_POST['OwnerID']."', NOW())");
		}
		else if ($_POST['Type']=='GiveAccess') {
			$pwd='12345678';
			mysqli_query($connect,"INSERT INTO accessdocument(Doc_ID, File_Pwd, Access_Expiry, User_Name) VALUES ('".$_POST['DocID']."','".$pwd."',NOW(),'".$_POST['Uname']."')");
			//mysqli_query($connect,"DELETE FROM requestdocument WHERE ";
		}
	}
?>