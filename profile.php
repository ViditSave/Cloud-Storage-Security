<?php 	
	session_start();
	include 'includeAll.php';
	if (!(isset($_SESSION["username"])&isset($_SESSION["userid"])))
		header('Location:index.php');
	else { 
		$output="";?>
		<html>
			<head>
				<title>Profile Page</title>
				<style>
					*{font-family:Verdana; box-sizing:unset !important;}
					.secTable{width:22.5%; padding:0% 0.75%; margin:0px 0.5% 10px 4%; float:left;}
					.secTableData{background-color:white; border-radius:10px; margin-bottom:5px; font-size:1.25rem; padding:10px 25px; cursor: pointer;}
					.secMain {width:65%; padding:2% 0.75%; border-radius:10px; margin:0px 4% 20px 0.5%; float:right; background-color:white;}
					.uploadedFiles{width:90% !important; margin:25px auto;}
					.hideDivision{display:none;}
					.showDivision{display:block;}
				</style>
			</head>
			<?php include 'navbar.php'; ?>
			<body style="background-image: linear-gradient(#6666ff,#55AAD0); margin:0px; position:relative;">
				<div style="min-height:70%; width:1200px; margin:60px auto 0px auto">
					<div class="secTable">
						<div class="secTableData" onclick="changeTab('.tab1')">User Information</div>
						<div class="secTableData" onclick="changeTab('.tab2')">Your Uploaded Files</div>
						<div class="secTableData" onclick="changeTab('.tab3')">Upload a New File</div>
						<div class="secTableData" onclick="changeTab('.tab4')">Requests Sent</div>
						<div class="secTableData" onclick="changeTab('.tab5')">Access Requests</div>
						<div class="secTableData" onclick="changeTab('.tab6')">Accessible Files</div>
					</div>
					<div class="secMain">
						<div id="User_Info" class="tab1">
							<h1 style="color:#000080; margin:0px;"><b><center>User Information</center></b></h1><hr>
							<?php
								$query1 = "SELECT * FROM user where User_ID='".$_SESSION['userid']."'";
								$result1= mysqli_query($connect, $query1);
								$row1	= mysqli_fetch_array($result1);
								$query2 = "SELECT Count(Doc_ID) FROM document where User_ID='".$_SESSION['userid']."'";
								$result2= mysqli_query($connect, $query2);
								$row2	= mysqli_fetch_array($result2);
								echo '
								<div style="width:70%; margin:5% 15%;">
									<div style="width:50%; float:left;">
										<label>Full Name</label><br>
										<label>Email ID</label><br>
										<label>No. of Documents Uploaded</label><br>
									</div>
									<div style="width:50%; float:right;">
										<label>: '.$row1['User_Fname'].' '.$row1['User_Lname'].'</label><br>
										<label>: '.$row1['User_email'].'</label><br>
										<label>: '.$row2['Count(Doc_ID)'].'</label><br>
									</div>
								</div>';
							?>
						</div>
						
						<div id="Uploaded_Files" class="tab2 hideDivision"></div>
						
						<div id="New_Upload" class="tab3 hideDivision">
							<h1 style="color:#000080; margin:0px;"><b><center>Upload New File</b></h1><hr>
							<div style="padding:20px 40px;">
								<form id="form" action="Ajax/uploadFiles.php" method="post" enctype="multipart/form-data">
									<label> Choose the file to Upload:</label>
									<input id="uploadImage" type="file" accept="*" name="uploaded_file" style="display:inline-block; margin-left:20px;"/><br>
									<center><input class="btn buttonView" type="submit" value="Upload" style="background-color:#6666FF; margin-top:25px; border:0px; padding:10px 25px;"></center>
								</form>
								<p style="color:red; text-align:center;" id="output"><?php echo $output; ?></p>
							</div>
						</div>
						
						<div id="Sent_Requests" class="tab4 hideDivision">
							<h1 style="color:#000080; margin:0px;"><b><center>Requests You Sent</b></h1><hr>
							<?php
								$query = "SELECT Doc_ID, Timestamp FROM requestdocument WHERE User_ID='".$_SESSION['userid']."'";
								$result = mysqli_query($connect, $query);
								if(mysqli_num_rows($result)==0)
									echo "You don't have read privileges to any files";
								else {
									$count=1;
									while($row = mysqli_fetch_array($result)) {
										$result1 = mysqli_query($connect, "SELECT Doc_Name,Doc_Extension FROM document WHERE Doc_ID=".$row['Doc_ID']);
										$row1 = mysqli_fetch_array($result1);
										echo  '
										<div style="width:80%; height:70px; margin:2% 5%; border:1px solid #000080; padding:2% 5%; border-radius:10px;">
											<label>Document Name&emsp; : '.$row1['Doc_Name'].'.'.$row1['Doc_Extension'].'</label><br>
											<label>Request Time &emsp; &emsp; : '.date('d M, Y',strtotime($row['Timestamp'])).'</label>
										</div>';
									}
								}
							?>
						</div>
						
						<div id="Access_Requests" class="tab5 hideDivision">
							<h1 style="color:#000080; margin:0px;"><b><center>Give Access</b></h1><hr>
						</div>
						
						<div id="Granted_Access" class="tab6 hideDivision">
							<h1 style="color:#000080; margin:0px;"><b><center>Accessible Files</center></b></h1><hr>
							<?php
								$query = "SELECT Doc_ID, Access_Expiry FROM accessdocument WHERE User_Name='".$_SESSION['username']."'";
								$result = mysqli_query($connect, $query);
								if(mysqli_num_rows($result)==0)
									echo "You don't have read privileges to any files";
								else {
									$count=1;
									while($row = mysqli_fetch_array($result)) {
										$result1 = mysqli_query($connect, "SELECT Doc_Name,Doc_Extension,User_ID FROM document WHERE Doc_ID=".$row['Doc_ID']);
										$row1 = mysqli_fetch_array($result1);
										$result2 = mysqli_query($connect, "SELECT User_Name FROM user WHERE User_ID=".$row1['User_ID']);
										$row2 = mysqli_fetch_array($result2);
										echo '<div class="head'.$count.'" style="background-color:#6666FF; color:white; padding:10px; cursor:pointer; font-weight:bold; margin:15px; padding:20px;">
												<div style="width:7.5%; display:inline-block;">'.$count.'.</div>
												<div style="width:40%; display:inline-block;">File Name : '.$row1['Doc_Name'].'.'.$row1['Doc_Extension'].'</div>
												<div style="width:40%; display:inline-block; float:right;">File Owner : '.$row2['User_Name'].'</div>
												<div style="width:90%; display:inline-block; margin-left:8%; margin-top:10px;">Expiry Date : '.date('d M, Y - h:ia',strtotime($row['Access_Expiry'])).'</div>
											</div>';
										$count+=1;
									}
								}
							?>
						</div>
					</div>
				</div>
			<div class="modal fade" id="QRModal" role="dialog">
				<div class="modal-dialog">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Modal Header</h4>
					</div>
					<div class="modal-body">
						<img src='Images/QRcodes/50user123.png' style='width:120px; height:120px;'>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			</div>
			<?php include 'footer.php'; ?>
			</body>	
		</html>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script>
			function changeTab(selectedTab){
				for (i=1; i<=6; i++) {
						var nameTemp='.tab'+i;
						$(nameTemp).addClass('hideDivision');
						$(nameTemp).removeClass('showDivision');
				}
				if (selectedTab==".tab2")
					$.ajax({
						url: "Ajax/userUploadedFiles.php",
						success: function(tab2){
							document.getElementById("Uploaded_Files").innerHTML = tab2;
						}          
					});
				$(selectedTab).addClass('showDivision');
			}
			
			function openAccess(selectedDoc) {
				const element = document.querySelector(selectedDoc);
				if (element.classList.contains("showDivision")) {
					$(selectedDoc).addClass('hideDivision');
					$(selectedDoc).removeClass('showDivision');
				}
				else {
					$(selectedDoc).addClass('showDivision');
					$(selectedDoc).removeClass('hideDivision');
				}
			}
			
			function alterUser(type,textField,documentID) {
				if (type=="Grant")
					var temp=document.getElementById(textField).value;
				else
					var temp=textField;
				$.ajax({
					type:'post',
					url:'Ajax/alterUserAccess.php',
					data:{ 
						Uname:temp,
						DocID:documentID,
						Type:type,
					},
					success:function(data){
						if (type!="QRcode")
							changeTab('.tab2');
						else
							$("#QRModal").modal();
					}
				});
			}
			
			$(document).ready(function (e) {
				$("#form").on('submit',(function(e) {
					e.preventDefault();
					$.ajax({
						url: "Ajax/uploadNewFile.php",
						type: "POST",
						data:  new FormData(this),
						contentType: false,
						cache: false,
						processData:false,
						success: function(finResult){
							document.getElementById("output").innerHTML = finResult;
						}          
					});
				 }));
			});
		</script>
<?php } ?>