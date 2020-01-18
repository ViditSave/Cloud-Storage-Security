<?php
	session_start();
	$inputOrder="Doc_Name";
	if(isset($_GET['Order']))
      $inputOrder= $_GET['Order'];
	$sortDisp="";
	
	
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
						<div class="secTableData inSort" onclick="changeOrder('Doc_Name')">File Name Asc</div>
						<div class="secTableData inSort" onclick="changeOrder('Doc_Name DESC')">File Name Desc</div>
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
						$connect = mysqli_connect("localhost", "root", "", "SecureStorage");
						$query = "SELECT User_Fname, User_Lname, Doc_Name, Doc_Extension, Timestamp FROM User, Document where Document.User_ID = User.User_ID ORDER BY ".$inputOrder;
						$result= mysqli_query($connect, $query);
						$count=1;
						while($row = mysqli_fetch_array($result)) {
							echo '
							<div style="width:70%; height:70px; margin:2% 5%; border:1px solid #000080; padding:2% 10%; border-radius:10px;">
								<div style="width:30%; display:inline-block;">
									<label>Document Name</label><br>
									<label>Uploader ID</label><br>
									<label>Upload Time</label><br>
								</div>
								<div style="width:50%; display:inline-block;">
									<label>: '.$row['Doc_Name'].'.'.$row['Doc_Extension'].'</label><br>
									<label>: '.$row['User_Fname'].' '.$row['User_Lname'].'</label><br>
									<label>: '.date('d M, Y',strtotime($row['Timestamp'])).'</label><br>
								</div>
								<div style="width:58px; height:58px; margin:0.5%; background-color:cyan; display:inline-block; position:absolute; float:right;"><span>'.$row['Doc_Extension'].'</span></div>
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>  
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
</script>