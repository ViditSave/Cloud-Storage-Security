<?php 	
	session_start();
?>
<html>
	<head>
		<title>Sign Up Page</title>
		<style>
			* {font-family:Verdana; box-sizing:unset !important;}
			label {line-height:30px;}
			.form {width:400px; margin:auto;}
			.form-control {width:250px !important; float:right; height:20px !important;}
			.form-control-feedback {top:0px !important; color:orange;}
			.blur{width: 50%; padding:25px 20px; background-color:white; border-radius: 25px; margin:35px auto;}
			.signUpButton{color:white; background-color:#000080; width:25%; font-size:1vw; padding:2px; border-radius:15px; margin:auto;}
			.signUpButton:hover { background-color: #6666ff;}
		</style>
	</head>
	<?php include 'navbar.php'; ?>
	<body style="background-image: linear-gradient(#6666ff,#55AAD0); margin:0px; position:relative;">
		<div class="blur">
			<h1 style="color:#000080; margin:0px;"><b><center>Sign Up</center></b></h2><hr>
			<form class="form" role="form">
				<div class="form-group has-feedback" id="Fname">
					<label>First Name</label>
					<input type="text" class="form-control" id="inFname" placeholder="Enter your First Name">
					<span class="glyphicon glyphicon-asterisk form-control-feedback" id="icFname"></span>
				</div>
				<div class="form-group has-feedback" id="Lname">
					<label>Last Name</label>
					<input type="text" class="form-control" id="inLname" placeholder="Enter your Last Name">
					<span class="glyphicon glyphicon-asterisk form-control-feedback" id="icLname"></span>
				</div>
				<div class="form-group has-feedback" id="Uname">
					<label>User Name</label>
					<input type="text" class="form-control" id="inUname" placeholder="Enter your User Name">
					<span class="glyphicon glyphicon-asterisk form-control-feedback" id="icUname"></span>
				</div>
				<div class="form-group has-feedback" id="Pass">
					<label>Password</label>
					<input type="password" class="form-control" id="inPass" placeholder="Enter your Password">
					<span class="glyphicon glyphicon-asterisk form-control-feedback" id="icPass"></span>
				</div>
				<div class="form-group has-feedback" id="Email">
					<label>Email</label>
					<input type="text" class="form-control" id="inEmail" placeholder="Enter your Email Address">
					<span class="glyphicon glyphicon-asterisk form-control-feedback" id="icEmail"></span>
				</div>
				<div class="form-group has-feedback" id="Contact">
					<label>Contact</label>
					<input type="text" class="form-control" id="inContact" placeholder="Enter your Contact Number">
					<span class="glyphicon glyphicon-asterisk form-control-feedback" id="icContact"></span>
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>  
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
				$('span').removeClass('glyphicon-asterisk');
				$('span').removeClass('glyphicon-remove');
				$('span').addClass('glyphicon-ok');
				$('.form-group').removeClass('has-error');	
				$('.form-group').addClass('has-success');
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
						$(icTemp).removeClass('glyphicon-ok');
						$(icTemp).addClass('glyphicon-remove');
						$(inTemp).removeClass('has-success');
						$(inTemp).addClass('has-error');
					}
					document.getElementById("output").innerHTML = "Please check the information you entered";
				}
			}
		});
	}	
</script>