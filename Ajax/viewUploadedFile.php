<?php 	
	session_start();
	$file="ajax";
	include '../includeAll.php';
	if (isset($_SESSION["username"]) & isset($_SESSION["userid"])) {
		if (isset($_POST["DocID"])) {
			$query = "SELECT Doc_Name, Doc_Extension, Doc_Password FROM document where Doc_ID = ".$_POST['DocID'];
			$result= mysqli_query($connect, $query);
			$row = mysqli_fetch_array($result);
			
			$cipherText = file_get_contents('../Uploads/'.$row['Doc_Name'].".aes");
			$tempCText = explode("::", base64_decode($cipherText));
			$cipherText = $tempCText[0];
			$cipher = "aes-256-cbc";
			
			$fileKey=$row['Doc_Password'];
			include 'filePassDecrypt.php';
			//echo $fileFinalRes;
			if ($fileFinalRes == 0)
				echo "View File|||||<span style='margin:50px auto; color:red; display:block; width:fit-content; font-size:1.5rem;'>This link isn't designed for your account or it may be damaged.</span>";
			else if ($fileFinalRes == 1) {
				$key=$row['Doc_Password'];
				$ivlen = openssl_cipher_iv_length($cipher);
				$iv = $tempCText[1];
				$original_plaintext = openssl_decrypt($cipherText, $cipher, $key, $options=0, $iv);
				file_put_contents('../Uploads/tempDecrypted/'.$row['Doc_Name'].'.'.$row['Doc_Extension'], $original_plaintext); //Save the ecnypted code somewhere.

				echo $row['Doc_Name'].".".$row['Doc_Extension']."|||||";
				$path = "Uploads/tempDecrypted/".$row['Doc_Name'].".".$row['Doc_Extension'];
				
				$DocExt = strtolower($row['Doc_Extension']);
				if ($DocExt=='txt' | $DocExt=='html')
					echo '<p><iframe src="'.$path.'" frameborder="0" height="550px" width="100%"></iframe></p>';
				
				else if ($DocExt=='pdf')
					echo '<embed src="'.$path.'#toolbar=0" width="100%" height="550px"/>';
				
				else if ($DocExt=="png" | $DocExt=='gif' | $DocExt=='jpg')
					echo '<img src='.$path.'  height="550px" style="margin:auto; display:block;"/>';
				
				else if ($DocExt=="mp4")
					echo '<video height="550px" style="margin:auto; display:block;" autoplay> <source src="'.$path.'" type=video/mp4> </video>';
			}
			else if ($fileFinalRes == 2)
				echo "View File|||||<span style='margin:50px auto; color:red; display:block; width:fit-content; font-size:1.5rem;'>Your access right to the document has expired. Please contact the file owner for to regain file access.</span>";
		}
		if (isset($_POST["fileName"])) {
			unlink("../Uploads/tempDecrypted/".$_POST["fileName"]);
		}
	}
?>