<?php 	
	session_start();
	include 'includeAll.php';
	if (!(isset($_SESSION["username"]) & isset($_SESSION["userid"]))) {
		$_SESSION["viewFile"]=$_SERVER['REQUEST_URI'];
		header('Location:login.php');
	}
	else {
		if (isset($_GET['DocID']) & isset($_GET['Pass'])) {
			$query = "SELECT Doc_Name, Doc_Extension FROM document where Doc_ID = ".$_GET['DocID'];
			$result= mysqli_query($connect, $query);
			if(mysqli_num_rows($result)==0) {
				$fileName = "";
				$dispView = "<span style='margin:50px auto; color:red; display:block; width:fit-content; font-size:1.5rem;'>Please Check Your Link. It appears to be damaged.</span>";
			}
			else {
				$row = mysqli_fetch_array($result);
				$password = "123456789";
				$command = "python Python/aesFile.py Decrypt ".$row['Doc_Name']." ".$row['Doc_Extension']." ".$password;
				$pid = popen( $command,"r");
				$py=fread($pid, 256);
				
				$path = "Uploads/tempDecrypted/".$row['Doc_Name'].".".$row['Doc_Extension'];
				$fileName = " : ".$row['Doc_Name'].".".$row['Doc_Extension'];
				$dispView = "";
				$DocExt = $row['Doc_Extension'];
				if ($DocExt=='txt' | $DocExt=='html')
					$dispView = '<p><iframe src="'.$path.'" frameborder="0" height="550px" width="100%"></iframe></p>';
				else if ($DocExt=='pdf')
					$dispView = '<embed src="'.$path.'#toolbar=0" width="100%" height="550px"/>';
				else if ($DocExt=="png" | $DocExt=='gif' | $DocExt=='jpg')
					$dispView = '<img src='.$path.'  height="550px" style="margin:auto; display:block;"/>';
				else if ($DocExt=="mp4")
					$dispView = '<video height="550px" style="margin:auto; display:block;" autoplay><source src="'.$path.'" type=video/mp4></video>';
			}
		}
?>
			<html>
				<head>
					<title>Login Screen</title>
					<meta charset="utf-8">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<style>
						* {font-family:Verdana; box-sizing:unset !important;}
						.blur{width: 75%; padding:25px 50px; background-color:white; border-radius: 25px; margin:auto;}
						@media (min-width: 350px) and (max-width:550px)  {
							.blur { margin-top:10%;}
							.respParentDiv { padding:15% 0% !important;}
						}
					</style>
				</head>
				<body style="background-image: linear-gradient(#6666ff,#55AAD0); margin:0px; position:relative;">
					<div style="padding:2.5% 0%;">
						<div class="blur">
							<h1 style="color:#000080; margin-bottom:20px;"><b><center>View File<?php echo $fileName; ?></center></b></h1>
							<div style="border:2px solid #000080; padding:20px 40px; border-radius:15px;"><?php echo $dispView;?></div>
						</div>
					</div>
				<?php include 'footer.php'; ?>
				</body>
			</html>
<?php
	}
?>
