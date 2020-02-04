<?php 	
	session_start();
	$file="ajax";
	include '../includeAll.php';
	if (isset($_SESSION["username"]) & isset($_SESSION["userid"])) {
		if (isset($_POST["DocID"])) {
			$query = "SELECT Doc_Name, Doc_Extension FROM document where Doc_ID = ".$_POST['DocID'];
			$result= mysqli_query($connect, $query);
			$row = mysqli_fetch_array($result);
			$command = "python ../Python/aesFile.py Decrypt ".$row['Doc_Name']." ".$row['Doc_Extension'];
			$pid = popen( $command,"r");
			$py=fread($pid, 256);
			
			echo $row['Doc_Name'].".".$row['Doc_Extension']."|||||";
			$path = "Uploads/tempDecrypted/".$row['Doc_Name'].".".$row['Doc_Extension'];

			if ($row['Doc_Extension']=='txt')
				echo '<p><iframe src="'.$path.'" frameborder="0" height="550px" width="100%"></iframe></p>';
			
			else if ($row['Doc_Extension']=='pdf')
				echo '<embed src="'.$path.'#toolbar=0" width="100%" height="550px"/>';
			
			else if ($row['Doc_Extension']=="png" | $row['Doc_Extension']=='gif')
				echo '<img src='.$path.'  height="550px" style="margin:auto; display:block;"/>';
			
			else if ($row['Doc_Extension']=="mp4")
				echo '<video height="550px" style="margin:auto; display:block;" autoplay> <source src="'.$path.'" type=video/mp4> </video>';
			
		}
		if (isset($_POST["fileName"])) {
			unlink("../Uploads/tempDecrypted/".$_POST["fileName"]);
		}
	}
?>