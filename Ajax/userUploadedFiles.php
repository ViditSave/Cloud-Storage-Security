<?php
	session_start();
	$file="ajax";
	include '../includeAll.php';
	echo '<h1 style="color:#000080; margin:0px;"><b><center>Uploaded Files</center></b></h1><hr>';
	$query = "SELECT Doc_ID, Doc_Name, Doc_Extension, Timestamp FROM document where User_ID='".$_SESSION['userid']."' ORDER BY Timestamp DESC";
	$result = mysqli_query($connect, $query);
	if(mysqli_num_rows($result)==0)
		echo "No Files Uploaded";
	else {
		$count=1;
		while($row = mysqli_fetch_array($result)) {
			echo '
			<div class="uploadedFiles" style="font-weight:bold;">
				<div class="head'.$count.' cardHead" onclick="openAccess(\'.body'.$count.'\')" style="margin:0px; padding:10px 20px;">
					<div style="width:45%; display:inline-block;" class="ellipsis">'.$count.'.&emsp;'.$row['Doc_Name'].'.'.$row['Doc_Extension'].'</div>
					<div style="width:45%; display:inline-block;" class="ellipsis">'.date('l - d M, Y (h:ia)',strtotime($row['Timestamp'])).'</div>
					<span class="fas fa-plus-circle" style="margin-left:20px; display:inline-block; vertical-align:super;"></span>
				</div>
				<div class="body'.$count.' hideDivision" style="border:2px solid #6666FF; padding:10px; border-radius-bottom:20%;">
					<div style="width:90%; margin:10px auto; padding:10px; border:1px solid #00000000;">						
						<label style="width:35%; float:left; line-height:32.5px;">Give Access to a User:</label>
						<input type="button" class="enterButton" onclick="addRemoveUser(\'Grant\','.$count.','.$row['Doc_ID'].')" value="&check;">
						<input class="form-control" id="inUname'.$count.'" placeholder="Enter Name To Grant Access" style="width:45%; height:20px; margin:0px auto;" list="userNames">
						<datalist id="userNames">';
							$queryName = "SELECT User_Name FROM user where User_Name not in ('".$_SESSION['username']."')";
							$resultName= mysqli_query($connect, $queryName);
							while($rowName = mysqli_fetch_array($resultName))
								echo '<option value="'.$rowName['User_Name'].'">';
						echo '
						</datalist>
					</div><hr>';
					$queryAccess = "SELECT Access_Expiry,User_Name FROM accessdocument WHERE Doc_ID='".$row['Doc_ID']."'";
					$resultAccess = mysqli_query($connect, $queryAccess);
					if(mysqli_num_rows($resultAccess)==0)
						echo "<div style='width:90%; margin:10px auto; padding:10px; border:1px solid #00000000;'>No Access keys sent</div>";
					else {
						$countAccess=1;
						echo"
						<div style='width:90%; margin:10px auto; padding:10px; border:1px solid #00000000;'>
							<div style='width:10%; display:inline-block;'>No.</div>
							<div style='width:32%; display:inline-block;'>User Name</div>
							<div style='width:40%; display:inline-block;'>Access Date</div>
							<div style='width:15%; display:inline-block;'>Actions</div>
						</div>";
						while($rowAccess = mysqli_fetch_array($resultAccess)) {
							echo "
							<div style='width:90%; margin:10px auto; padding:10px; border:1px solid #00000000;'>
								<div style='width:10%; display:inline-block;'>".$countAccess.".</div>
								<div style='width:32%; display:inline-block;'>".$rowAccess['User_Name']."</div>
								<div style='width:40%; display:inline-block;'>".date('l - d M, Y',strtotime($rowAccess['Access_Expiry']))."</div>
								<div style='width:15%; display:inline-block;'>
									<span class='fas fa-times' style='margin-left:10px' onclick='addRemoveUser(\"Revoke\",\"".$rowAccess['User_Name']."|".$count."\",".$row['Doc_ID'].")'></span>
									<span class='fas fa-qrcode' style='margin-left:10px' onclick='addRemoveUser(\"QRcode\",\"".$rowAccess['User_Name']."\",".$row['Doc_ID'].")'></span>
								</div>
							</div>";
							$countAccess+=1;
						}
					}
					echo "</div>
				</div>";
			$count+=1;
		}		
	}
?>