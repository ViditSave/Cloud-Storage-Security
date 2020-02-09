<?php 	session_start();
		include 'includeAll.php';
?>
<html>
	<head>
		<title>Sign Up Page</title>
		<style>
			* {font-family:Verdana; box-sizing:unset !important;}
			label {line-height:30px;}
			.form {width:400px; margin:auto;}
			.form-control {width:250px !important; float:right; height:20px !important;}
			.form-group .fas {line-height:30px; color:orange; float:right; margin-left:10px;}
			.blur{width: 60%; padding:25px 20px; background-color:white; border-radius: 25px; margin:35px auto;}
			.signUpButton{color:white; background-color:#000080; width:25%; font-size:1vw; padding:2px; border-radius:15px; margin:auto;}
			.signUpButton:hover { background-color: #6666ff;}
			.success {color:green !important;}
			.failure {color:red !important; margin-left:20px !important;}
		</style>
	</head>
	<body style="background-image: linear-gradient(#6666ff,#55AAD0); margin:0px; position:relative;">
		<div class="blur">
			<h1 style="color:#000080; margin:0px;"><b><center>Sign Up</center></b></h2><hr>
			<form class="form" role="form">
				<div class="form-group" id="Fname">
					<label>First Name</label>
					<span class="fas fa-asterisk" id="icFname"></span>
					<input type="text" class="form-control" id="inFname" placeholder="Enter your First Name">
				</div>
				<div class="form-group" id="Lname">
					<label>Last Name</label>
					<span class="fas fa-asterisk" id="icLname"></span>
					<input type="text" class="form-control" id="inLname" placeholder="Enter your Last Name">
				</div>
				<div class="form-group" id="Uname">
					<label>User Name</label>
					<span class="fas fa-asterisk" id="icUname"></span>
					<input type="text" class="form-control" id="inUname" placeholder="Enter your User Name">
				</div>
				<div class="form-group" id="Pass">
					<label>Password</label>
					<span class="fas fa-asterisk" id="icPass"></span>
					<input type="password" class="form-control" id="inPass" placeholder="Enter your Password">
				</div>
				<div class="form-group" id="Email">
					<label>Email</label>
					<span class="fas fa-asterisk" id="icEmail"></span>
					<input type="text" class="form-control" id="inEmail" placeholder="Enter your Email Address">
				</div>
				<div class="form-group" id="Contact">
					<label>Contact</label>
					<span class="fas fa-asterisk" id="icContact"></span>
					<input type="text" class="form-control" id="inContact" placeholder="Enter your Contact Number">
				</div>
				<p style="color:red; text-align:center;" id="output"></p>
				<center><input type="button" onclick="checkSignUp()" class="signUpButton" id="submitButton" value="Submit"></center>
			</form>
		</div>
	</body>
	<?php include 'footer.php'; ?>
</html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>
	function checkSignUp() {
		$.ajax({
			type:'post',
			url:'Ajax/signupData.php',
			data:{
				Fname:document.getElementById("inFname").value,
				Lname:document.getElementById("inLname").value,
				Uname:document.getElementById("inUname").value,
				Pass :document.getElementById("inPass").value,
				Email:document.getElementById("inEmail").value,
				Contact:document.getElementById("inContact").value,
			},
			success:function(data){
				$('span').removeClass('fa-asterisk');
				$('span').removeClass('fa-exclamation');
				$('span').addClass('fa-check');
				$('span').removeClass('failure');	
				$('span').addClass('success');
				errors = data.split(' | ');
				if (errors[0]=="6") {
					document.getElementById("submitButton").disabled = true;
					$.ajax({
						type:'post',
						url:'Ajax/sendMail.php',
						data:{
							Fname:document.getElementById("inFname").value,
							Lname:document.getElementById("inLname").value,
							Email:document.getElementById("inEmail").value,
							Uname:document.getElementById("inUname").value,
							Type :"Sign Up",
						},
						success:function(data){
							window.location.href='index.php';
						}
					});
				}
				else {
					var i;
					for (i=0; i<(errors.length-1); i++) {
						var inTemp="#"+errors[i];
						var icTemp='#ic'+errors[i];
						$(icTemp).removeClass('fa-check');
						$(icTemp).addClass('fa-exclamation');
						$(icTemp).removeClass('success');
						$(icTemp).addClass('failure');
					}
					document.getElementById("output").innerHTML = "Please check the information you entered";
				}
			}
		});
	}	
</script>