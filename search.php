<?php
 	session_start();
	include 'includeAll.php';
	$inputOrder="Doc_Name";
	$sortDisp="";
	if(isset($_GET['Order'])) {
		$inputOrder= $_GET['Order'];
		$sortDisp= $_GET['Order'];
	}
?>
<html>
	<head>
		<title>Search Page</title>
		<style>
			*{font-family:Verdana; box-sizing:unset !important;}
			.secTable{width:25%; padding:0% 0.75%; margin:0px 0.5% 10px 4%; float:left;}
			.secTableData{background-color:white; border-radius:10px; margin-bottom:5px; font-size:1.5rem; padding:10px 25px; cursor: pointer;}
			.inSort{width:75%; margin:5px auto; border:2px solid #ccc; padding:5px 10px; font-size:1rem;}
			.secMain {width:62.5%; padding:2% 0.75%; border-radius:10px; margin:0px 4% 20px 0.5%; float:right; background-color:white;}
			.uploadedFiles{width:90% !important; margin:25px auto;}
			.hideDivision{display:none;}
			.showDivision{display:block;}
		</style>
	</head>
	<?php $isSearchPage=1; include 'navbar.php'; ?>
	<body style="background-image: linear-gradient(#6666ff,#55AAD0); margin:0px; position:relative;">		
		<div style="min-height:55%; width:1200px; margin:55px auto 0px auto">
			<div class="secTable">
				<div class="secTableData">Search Document : 
					<div class="form-group has-feedback" style="margin:0px;">
						<input type="text" class="form-control" id="inDname" placeholder="Enter Document Name" style="width:75%; display:inline-block; height:20px; margin:10px 0px;">
						<span class="glyphicon glyphicon-search form-control-feedback" style="margin:10px;"></span>
					</div>
				</div>
				<div class="secTableData" onclick="showSort()"> Sort Documents : <?php echo $sortDisp; ?>
					<div class="form-group has-feedback hideDivision" style="margin:15px;" id="changeSort">
						<div class="secTableData inSort" onclick="changeOrder('Doc_Name')">Document Name Asc</div>
						<div class="secTableData inSort" onclick="changeOrder('Doc_Name DESC')">Document Name Desc</div>
						<div class="secTableData inSort" onclick="changeOrder('Doc_Extension')">File Type Asc</div>
						<div class="secTableData inSort" onclick="changeOrder('Doc_Extension DESC')">File Type Desc</div>
						<div class="secTableData inSort" onclick="changeOrder('User_Fname')">Uploader Name Asc</div>
						<div class="secTableData inSort" onclick="changeOrder('User_Fname DESC')">Uploader Name Desc</div>
						<div class="secTableData inSort" onclick="changeOrder('Timestamp')">Upload Date Asc</div>
						<div class="secTableData inSort" onclick="changeOrder('Timestamp DESC')">Upload Date Desc</div>
					</div>
				</div>
			</div>
			<div class="secMain">
				<div>
					<?php
						$query = "SELECT User_Fname, User_Lname, Doc_ID, Doc_Name, Doc_Extension, Timestamp FROM user, document where document.User_ID = user.User_ID ORDER BY ".$inputOrder;
						$result= mysqli_query($connect, $query);
						$count=1;
						while($row = mysqli_fetch_array($result)) {
							echo '
							<div style="width:80%; height:70px; margin:2% 5%; border:1px solid #000080; padding:2% 5%; border-radius:10px;">
								<div class="container">
									<div class="row">
										<div class="col-2" style=" background-color:red; height:10px;">
											<span>';
										if ($row['Doc_Extension']=="pdf")
											echo '<i class="fas fa-file-pdf"></i>';
										else if ($row['Doc_Extension']=="xlsx")
											echo '<i class="fas fa-file-excel"></i>';
										else
											echo '<i class="fas fa-file-alt"></i>';
										echo '</span>
										</div>
										<div class="col-6" style=" background-color:green; height:10px;">
											<label>Document Name&emsp;: '.$row['Doc_Name'].'.'.$row['Doc_Extension'].'</label><br>
											<label>Uploader ID &emsp; &emsp; &nbsp;: '.$row['User_Fname'].' '.$row['User_Lname'].'</label><br>
											<label>Upload Time &emsp; &emsp; : '.date('d M, Y',strtotime($row['Timestamp'])).'</label><br>
										</div>
										<div class="col-2" style=" background-color:cyan; height:10px;">';
										$action="";
										if (!(isset($_SESSION["username"])&isset($_SESSION["userid"])))
											$action="window.location.href ='login.php';";
										else
											$action="alterUser('Request','".$_SESSION["userid"]."','".$row['Doc_ID']."')";
										echo '
											<span class="glyphicon glyphicon-remove" onclick="'.$action.'">Request Access</span>
										</div>
									</div>
								</div>
							</div>';
						}
					?>
				</div>
			</div>
		</div>
	</body>
</html>
<?php include 'footer.php'; ?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>
	function showSort() {
		const element = document.querySelector('#changeSort');
		if (element.classList.contains("showDivision")) {
			$('#changeSort').addClass('hideDivision');
			$('#changeSort').removeClass('showDivision');
		}
		else {
			$('#changeSort').addClass('showDivision');
			$('#changeSort').removeClass('hideDivision');
		}
	}
	function changeOrder(selectedType) {
		window.location = "search.php?Order="+selectedType;
	}
	function alterUser(type,userID,documentID) {
		$.ajax({
			type:'post',
			url:'Ajax/alterUserAccess.php',
			data:{ 
				Uname:userID,
				DocID:documentID,
				Type:type,
			},
			success:function(data){
				alert("Request Sent");
			}
		});
	}
</script>