<?php 	session_start();
		include 'includeAll.php';
?>
<html>
	<head>
		<title>Secure Storage</title>
		<style>
			* {font-family:Verdana; box-sizing:unset !important;}
			html {scroll-behavior: smooth;}
			.buttonStyle { display: inline-block; background-color: #00000000; border: 1.5px solid white; padding: 8px 30px; border-radius: 10%; font-size:2vw; margin:0px 30px; color:white;} 
			.blocks {width:26%; height:50%; margin:0% 3.25%; float:left; background-color:#c4c4fa; border-radius:25px; border:5px solid black; padding-top:20px;}
			.blocks img, a img{border-radius: 60px; box-shadow: 0px 0px 15px black; padding:7.5px; width:4vw; height:4vw;}
			#respDesign {border-radius:0px; box-shadow:none; padding:5px; height:auto; max-height:70%; margin:70px auto; display:block;}
		</style>
	</head>
	<?php include 'navbar.php'; ?>
	<body id="page1" style="margin:0px; position:relative;">
		<div style="height:80%; width:100%; background-image: linear-gradient(#6666ff,#55AAD0); color:white;">
			<div style="width:49%; float:left; height:80%;">
				<div style="margin:70px 0px 0px 60px; display:block">
					<p style="font-size:3vw;">Welcome to Secure Storage</p>
					<p style="font-size:2vw; width:85%; margin:0% 5%; text-align:justify;">We aim to provide you a secure, identity based encryption scheme to provide a revocable access at your fingertips.</p>
					<div style="width:85%; padding:5% 3%;">
						<center>
							<?php
							if (isset($_SESSION["username"])&isset($_SESSION["userid"]))
								echo '<button onclick="window.location.href=\'profile.php\'" class="buttonStyle">Profile</button>';
							else
								echo '<button onclick="window.location.href=\'login.php\'"  class="buttonStyle">Login</button>
									  <button onclick="window.location.href=\'signup.php\'" class="buttonStyle">Signup</button>';
							?>
						</center>
					</div>
				</div>
			</div>
			<div style="width:49%; float:right; height:80%;">
				<img src="Images/responsive_screen.png" id="respDesign" alt="Responsive Blank" height="10px">
			</div>
			<div style="width:100%; clear:both; padding-top:20px;">
				<center><a href="#page2"><img src="Images/chevron-circle-down-solid.svg" alt="Go Down" height="10px"></a></center>
			</div>
		</div>
		<?php 
			$color="white";
			$bgColor="#55AAD0";
			$count=1;
			$text=0;
			include 'footer.php'; 
		?>
		<div id="page2" style="height:90%; width:94%; background-color:white; padding:0px 3%; color:black;">
			<p style="font-size:3vw; text-align:center; padding-top:80px; padding-bottom:25px; margin:0px;">What do we offer</p>
			<div class="blocks">
				<center>
					<img src="Images/shield-alt-solid.svg" alt="Sheild">
					<p style="font-size:2vw; margin:20px 0px 10px 0px;">Encrypted Sharing</p>
				</center>
				<p style="text-align:justify; padding:0px 40px; margin-top:0px;">All the files on the server are encrypted. Hence in case of an attack, sensitive information can't be accessed.<br>The Multi-key Decryption scheme ensures that no two people have the same key.</p>
			</div>
			<div class="blocks">
				<center>
					<img src="Images/user-cog-solid.svg" alt="User Cog">
					<p style="font-size:2vw; margin:20px 0px 10px 0px;">Control Viewers</p>
				</center>
				<p style="text-align:justify; padding:0px 40px; margin-top:0px;">The data source has the facility to restrict or block the access of files to any reciever<br>The key of this user is disabled to prevent further access.</p>
			</div>
			<div class="blocks">
				<center>
					<img src="Images/handshake-solid.svg" alt="handshake">
					<p style="font-size:2vw; margin:20px 0px 10px 0px;">User Friendly</p>
				</center>
				<p style="text-align:justify; padding:0px 40px; margin-top:0px;">We value the user experience and try to create a website accessible and user friendly.</p>
			</div>
			<div style="width:100%; clear:both; padding-top:20px;">
				<center><a href="#top"><img src="Images/chevron-circle-up-solid.svg" alt="Go Up" height="10px"></a></center>
			</div>
		</div>
		<?php 
			$color="#55AAD0";
			$count=2;
			$textWidth="90%";
			include 'footer.php';
		?>
	</body>
</html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">