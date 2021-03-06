<?php 
	session_start();
	include 'includeAll.php';
?>
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
			@media (min-width: 350px) and (max-width:550px)  {
				.blur { width:80%;}
				.loginButton { font-size:2.5vw; margin-top:2px; padding:10px 5px;}
				.respParentDiv { padding:7.5% 0% 50% 0% !important;}
				.form-control { width:100px; float:none;}
				.form {width:100%; margin:auto;}
			}		
		</style>
	</head>
	<body style="background-image: linear-gradient(#6666ff,#55AAD0); margin:0px; position:relative;">
		<div style="height:40%; padding:9.5% 0%;" class="respParentDiv">
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
				else if (output[1]=="2")
					document.getElementById("output").innerHTML = output[0];
				else if (output[1]=="3")
					window.location.href=output[0];
			}
		});
	}
</script>