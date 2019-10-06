<html>
	<head>
		<title>Secure Storage</title>
		<style>
			*{font-family:Verdana; color:white;}
			.ptag{width:65%; margin:10px auto; font-size: 1.5vw; text-align:center;}
			#link {width:49.7vw; float:left; border-right:0.2vw dotted white;}
			#upload {width:49.7vw; float:right;}
			#welcome {width: 50vw; margin: 75px auto; font-size: 2vw; text-align:center;}
			@media (min-width: 350px) and (max-width:550px)  {
				#link { float: none; width: 100vw; border-right: none; border-bottom:0.5vw dotted white; border-top:0.5vw dotted white; padding:10px 0px;}
				#link p { font-size:5vw;}
				#upload { float: none; width: 100vw; border-right: none; border-bottom:0.5vw dotted white; padding:10px 0px 20px 0px;}
				#upload p { font-size:5vw;}
				#welcome { width: 75vw; font-size: 5vw; margin: 50px auto;}
			}
		</style>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<?php include 'navbar.php'; ?>
	<body style="background-image: linear-gradient(#000080, #6666ff, #6666ff); margin:0px; position:relative;">
	<p id="welcome"> Welcome to Secure Storage. <br> Enter your link below or click on generate a link.</p>
	<div style="width:100vw; margin:25px 0px 25px 0px;">
		<div id="link">
			<p class="ptag">Enter the Link</p>
			<input type="text" style="width:60%; height:35px; margin:10px auto; display:block; border-radius:10px; color:blue;">
		</div>
		<div id="upload">
			<p class="ptag">Upload a file</p>
			<center><button class="buttonView" onclick="window.location.href='upload.php'" style="margin-bottom:10pxx;">Upload</button></center>
		</div>
	</div>
	<br>
	</body>
	<?php include 'footer.php'; ?>
</html>