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
			$path = "..\\Uploads\\" . $name;
			if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
				$password = "123456789";
				$command = "python ../Python/aesFile.py Encrypt ".$ext[0]." ".$ext[1]." ".$password;
				$pid = popen( $command,"r");
				$py=fread($pid, 256);
				unlink($path);
				mysqli_query($connect,"INSERT INTO document(Doc_Name, Doc_Extension, Doc_Password, User_ID, Timestamp) VALUES ('".$ext[0]."','".$ext[1]."','".$password."','".$_SESSION["userid"]."',NOW())");
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
