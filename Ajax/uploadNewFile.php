<?php 	
	session_start();
	$file="ajax";
	include '../includeAll.php';
	if (isset($_SESSION["username"]) & isset($_SESSION["userid"])) {
		$output="";
		if(!empty($_FILES['uploaded_file']))
		{
			$name=str_replace(" ","_",basename( $_FILES['uploaded_file']['name']));
			$ext=explode(".",$name);
			$path = "../Uploads/" . $name;
			if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
				$plaintext = file_get_contents('../Uploads/'.$name); $cipher = "aes-256-cbc";
				
				$funType = "FileEncr";
				include 'keyHash.php';
				$key = $keyFinal;
				
				$ivlen = openssl_cipher_iv_length($cipher);
				$iv = openssl_random_pseudo_bytes($ivlen);
				$ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv);
				$encryptedTest = base64_encode($ciphertext . '::' . $iv);
				file_put_contents('../Uploads/'.$ext[0].'.aes', $encryptedTest); //Save the ecnypted code somewhere.

				unlink($path);
				mysqli_query($connect,"INSERT INTO document(Doc_Name, Doc_Extension, Doc_Password, User_ID, Timestamp) VALUES ('".$ext[0]."','".$ext[1]."','".$key."','".$_SESSION["userid"]."',NOW())");
				$output=  "The file ".$name." has been uploaded";
			} 
			else
				$output= "There was an error uploading the file, please try again!";
		}
		else 
			$output= "No File Selected";
		echo $output;	
	}
?>
