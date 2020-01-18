<?php session_start();?>
<html>
	<head>
		<title>Login Screen</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>
			* {font-family:Verdana; box-sizing:unset !important;}
			label {line-height:30px;}
			.form {width:400px; margin:auto;}
			.form-control {width:250px !important; float:right; height:20px !important;}
			.form-control-feedback {top:0px !important; color:orange;}
			.blur{width: 50%; padding:25px 20px; background-color:white; border-radius: 25px; margin:auto;}
			.loginButton{color:white; background-color:#000080; width:25%; font-size:1vw; padding:2px; border-radius:15px; margin:auto;}
			.loginButton:hover { background-color: #6666ff;}
		</style>
	</head>
	<?php include 'navbar.php'; ?>
	<body style="background-image: linear-gradient(#6666ff,#55AAD0); margin:0px; position:relative;">
		<div style="height:40%; padding:9.5% 0%;">
			<div class="blur">
				<h1 style="color:#000080; margin:0px;"><b><center>Log In</center></b></h2><hr>
				<form class="form" role="form">
					<div class="form-group" id="Uname">
						<label>User Name</label>
						<input type="text" class="form-control" id="inUname" placeholder="Enter your User Name">
					</div>
					<div class="form-group" id="Pass">
						<label>Password</label>
						<input type="password" class="form-control" id="inPass" placeholder="Enter your Password">
					</div>
					<p style="color:red; text-align:center;" id="output"></p>
					<center><input type="button" onclick="checkLogin()" class="loginButton" id="loginButton" value="Submit"></center>
				</form>
			</div>
		</div>
	<?php include 'footer.php'; ?>
	</body>
</html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>  
<script>
	function checkLogin() {
		$.ajax({
			type:'post',
			url:'Ajax/loginData.php',
			data:{
				Uname:document.getElementById("inUname").value,
				Pass :document.getElementById("inPass").value,
			},
			success:function(data){
				output=data.split(' | ');
				if (output[1]=="1")
					window.location.href='index.php';
				else
					document.getElementById("output").innerHTML = output[0];
			}
		});
	}
</script>