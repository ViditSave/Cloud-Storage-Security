<h1 style="color:#000080; margin:0px;"><b><center>Uploaded Files</center></b></h1><hr>
<?php
	session_start();
	$file="ajax";
	include '../includeAll.php';
	$query = "SELECT Doc_ID, Doc_Name, Doc_Extension, Timestamp FROM document where User_ID='".$_SESSION['userid']."' ORDER BY Timestamp DESC";
	$result = mysqli_query($connect, $query);
	if(mysqli_num_rows($result)==0)
		echo "No Files Uploaded";
	else {
		$count=1;
		while($row = mysqli_fetch_array($result)) {
			echo '<div class="uploadedFiles" style="font-weight:bold;">
					<div class="head'.$count.'" style="background-color:#6666FF; color:white; padding:10px; cursor:pointer;" onclick="openAccess(\'.body'.$count.'\')">
						<div style="width:7.5%; display:inline-block;">'.$count.'.</div>
						<div style="width:45%; display:inline-block;">'.$row['Doc_Name'].'.'.$row['Doc_Extension'].'</div>
						<div style="width:45%; display:inline-block;">'.date('l - d M, Y (h:ia)',strtotime($row['Timestamp'])).'</div>
					</div>
					<div class="body'.$count.' hideDivision" style="border:2px solid #6666FF; padding:10px; border-radius-bottom:20%;">
						<div style="width:90%; margin:10px auto; padding:10px; border:1px solid #00000000;">						
							<label style="width:25%; float:left; line-height:32.5px;">Insert a New User:</label>
							<input type="button" onclick="alterUser(\'Grant\',\'inUname'.$count.'\','.$row['Doc_ID'].')" value="&check;" style="width:26px; height:26px; margin:1px 0px; float:right; border-radius:50%; border:2px solid #000080; color:#000080; background-color:white;">
							<input class="form-control" id="inUname'.$count.'" placeholder="Enter User Name To Grant Access" style="width:50%; height:20px; margin:0px auto;">
						</div><hr>';
						$queryAccess = "SELECT Access_Expiry,User_Name FROM accessdocument WHERE Doc_ID='".$row['Doc_ID']."'";
						$resultAccess = mysqli_query($connect, $queryAccess);
						if(mysqli_num_rows($resultAccess)==0)
							echo "<div style='width:90%; margin:10px auto; padding:10px; border:1px solid #00000000;'>No Access keys sent</div>";
						else {
							$countAccess=1;
							echo"<div style='width:90%; margin:10px auto; padding:10px; border:1px solid #00000000;'>
									<div style='width:7.5%; display:inline-block;'>No.</div>
									<div style='width:30%; display:inline-block;'>User Name</div>
									<div style='width:47.5%; display:inline-block;'>Access Date</div>
									<div style='width:12.5%; display:inline-block;'>Actions</div>
								 </div>";
							while($rowAccess = mysqli_fetch_array($resultAccess)) {
								echo "<div style='width:90%; margin:10px auto; padding:10px; border:1px solid #00000000;'>
									<div style='width:7.5%; display:inline-block;'>".$countAccess.".</div>
									<div style='width:30%; display:inline-block;'>".$rowAccess['User_Name']."</div>
									<div style='width:47.5%; display:inline-block;'>".date('l - d M, Y (h:ia)',strtotime($rowAccess['Access_Expiry']))."</div>
									<div style='width:12.5%; display:inline-block;'>
										<span class='glyphicon glyphicon-remove' style='margin-left:10px' onclick='alterUser(\"Revoke\",\"".$rowAccess['User_Name']."\",".$row['Doc_ID'].")'></span>
										<span class='glyphicon glyphicon-qrcode' style='margin-left:10px' onclick='alterUser(\"QRcode\",\"".$rowAccess['User_Name']."\",".$row['Doc_ID'].")'></span>
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