<?php 	
	session_start();
	$file="ajax";
	include '../includeAll.php';
	if (isset($_SESSION["username"]) & isset($_SESSION["userid"])) {
		if (isset($_POST["DocID"])) {
			$query = "SELECT Doc_Name, Doc_Extension FROM document where Doc_ID = ".$_POST['DocID'];
			$result= mysqli_query($connect, $query);
			$row = mysqli_fetch_array($result);
			
			$cipherText = file_get_contents('../Uploads/'.$row['Doc_Name'].".aes");
			$tempCText = explode("::", base64_decode($cipherText));
			$cipherText = $tempCText[0];
			$cipher = "aes-256-cbc";
			$key="123456789";
			$ivlen = openssl_cipher_iv_length($cipher);
			$iv = $tempCText[1];
			$original_plaintext = openssl_decrypt($cipherText, $cipher, $key, $options=0, $iv);
			file_put_contents('..\\Uploads\\tempDecrypted\\'.$row['Doc_Name'].'.'.$row['Doc_Extension'], $original_plaintext); //Save the ecnypted code somewhere.

			echo $row['Doc_Name'].".".$row['Doc_Extension']."|||||";
			$path = "Uploads/tempDecrypted/".$row['Doc_Name'].".".$row['Doc_Extension'];
			
			$DocExt = $row['Doc_Extension'];
			if ($DocExt=='txt' | $DocExt=='html')
				echo '<p><iframe src="'.$path.'" frameborder="0" height="550px" width="100%"></iframe></p>';
			
			else if ($DocExt=='pdf')
				echo '<embed src="'.$path.'#toolbar=0" width="100%" height="550px"/>';
			
			else if ($DocExt=="png" | $DocExt=='gif' | $DocExt=='jpg')
				echo '<img src='.$path.'  height="550px" style="margin:auto; display:block;"/>';
			
			else if ($DocExt=="mp4")
				echo '<video height="550px" style="margin:auto; display:block;" autoplay> <source src="'.$path.'" type=video/mp4> </video>';
			
		}
		if (isset($_POST["fileName"])) {
			unlink("../Uploads/tempDecrypted/".$_POST["fileName"]);
		}
	}
?>