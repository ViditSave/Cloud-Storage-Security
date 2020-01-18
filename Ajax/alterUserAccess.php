<?php 
	session_start(); 
	if(isset($_POST['Uname']) & isset($_POST['DocID']) & isset($_POST['Type'])) {
		$connect = mysqli_connect("localhost", "root", "", "SecureStorage");
		if ($_POST['Type']=='Grant') {
			$pwd='12345678';
			mysqli_query($connect,"INSERT INTO AccessDocument(Doc_ID, File_Pwd, Access_Expiry, User_Name) VALUES ('".$_POST['DocID']."','".$pwd."',NOW(),'".$_POST['Uname']."')");
		}
		else if ($_POST['Type']=='Revoke') {
			mysqli_query($connect,"DELETE FROM AccessDocument WHERE User_Name='".$_POST['Uname']."' AND Doc_ID='".$_POST['DocID']."'");
		}
		else if ($_POST['Type']=='QRcode') {
			include('../Libraries/PHPQrcode/qrlib.php'); 
			$codeContents = "Your Link is :".$_POST['DocID'].$_POST['Uname'];
			QRcode::png($codeContents,'../Images/QRcodes/'.$_POST['DocID'].$_POST['Uname'].'.png');
			echo "<img src='../Images/QRcodes/".$_POST['DocID'].$_POST['Uname'].".png' style='width:120px; height:120px;'>";
		}
	}
?>