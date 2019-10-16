<?php
session_start();
if (isset($_SESSION["username"])&isset($_SESSION["userid"])) {
	$output="";
	if(!empty($_FILES['uploaded_file']))
	{
		$name=str_replace(" ","_",basename( $_FILES['uploaded_file']['name']));
		$ext=explode(".",$name);
		$path = "Uploads\\" . $name;
		if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
			$output=  "The file ".$name." has been uploaded";
			$command = "python aesFile.py Encrypt ".$ext[0]." ".$ext[1];
			$pid = popen( $command,"r");
			$py=fread($pid, 256);
			unlink($path);
			$connect = mysqli_connect("localhost", "root", "", "SecureStorage");
			mysqli_query($connect,"INSERT INTO Document(Doc_Name, Doc_Extension, User_ID,Timestamp) VALUES ('".$ext[0]."','".$ext[1]."','".$_SESSION["userid"]."',NOW())");
		} 
		else {
			$output= "There was an error uploading the file, please try again!";
		}
	}		
?>
<html>
	<head>
		<title>Upload Files</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>
			*{font-family:Verdana;}
			table{width:90%;text-align:left;margin:auto; color:black;}
			input{height:50px; width:60%; border:2px solid #000080; padding: 13px; font-size:1.5vw;}
			.blur{width: 75%; padding:25px 20px; background-color:white; border-radius: 25px; margin:100px auto;}
			.uplButton{color:white; background-color:#6666ff; padding: 7px 10px; width:60%; border-radius: 0px 0px 15px 15px; border:2px solid #000080; border-top:none; font-size:1.5vw;}
			@media (min-width: 350px) and (max-width:550px)  {
				input {font-size:3vw; width:80%;}
				.blur{width: 80%; margin: 80px auto;}
				.uplButton{padding: 7px 10px; width:80%; font-size:3.5vw;}
			}
		</style>
	</head>
	<?php include 'navbar.php'; ?>
	<body style="background-image: linear-gradient(#000080, #6666ff, #6666ff); margin:0px; position:relative; min-height:100%;">
		<div class="blur">
		<center>
			<h1 style="color:#000080; margin:0px;"><b>File Upload </b></h2><br>
			<form enctype="multipart/form-data" action="upload.php" method="POST">
				<input type="file" style="border-radius: 15px 15px 0px 0px;" name="uploaded_file"></input><br>
				<input type="submit" style="font-weight:bold; " class="uplButton" value="Upload"></input>
			</form>
			<p style="color:red; text-align:center;"><?php echo "$output"; ?></p>
		</center>
		</div>
	<?php include 'footer.php'; ?>
	</body>
</html>
<?php 
}
else {
	header('Location:login.php');	
}	?>