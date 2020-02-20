<?php
	$connect = mysqli_connect("localhost", "root", "", "SecureStorage");
	if (!(isset($file))) {
		
		echo '
			<script type="text/javascript" src="Libraries/JQuery/jquery.min.js"></script>
			<script type="text/javascript" src="Libraries/Bootstrap/js/bootstrap.min.js"></script>
			<link rel="stylesheet" type="text/css" href="Libraries/Bootstrap/css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="Libraries/FontAwesome/css/all.css">
			
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>';
		echo '
			<style>
				#home { font-size:3vw; text-decoration:none; color:white;}
				.buttonView1, .buttonView2{ display: inline-block; background-color: #00000000; border: 0px; padding: 5px 20px; font-size:1.5vw; margin-top:5px; text-decoration: none; color:white;}
				.buttonView1:hover, .buttonView2:hover {border-bottom:2px solid;}
				ul li{display:none;}
				ul:hover li{display:block; position:relative; top:50px; height:30px;}
				@media (min-width: 350px) and (max-width:550px)  {
					#home { font-size:6vw;}
					.buttonView1 { border: 1px solid white; border-radius: 10%; font-size:2.5vw; margin:25px 0px 0px 22%;}
					.buttonView2 { border: 1px solid white; border-radius: 10%; font-size:2.5vw; margin:25px 0px 0px 8%;}
					.sidebar {clear:both; width:100%; margin:auto;}
					.nav_bar {height:100px !important;}
				}		
			</style>
			<div class="nav_bar" style="height:50px; padding:7.5px 0px; color:white; background:#6666ff; position:sticky; width:100%; top:0px; left:0px; z-index:10;">
				<div style="float:left; height:30px; margin-left:30px;">
					<img src="Images/cloud_logo.png" alt="Logo" height="40px" style="margin-right:5px; vertical-align:initial;">
					<a id="home" href="index.php" style="line-height:10px;">Secure Storage</a>
				</div>
				<div class="sidebar" style="float:right; margin-right:20px;">';
					if (isset($_SESSION["username"])&isset($_SESSION["userid"]))
						echo '
						<button class="buttonView2" onclick="window.location.href=\'search.php\'"><i class="fas fa-search"  style="margin-right:10px;"></i>Search</button>
						<button class="buttonView2" onclick="window.location.href=\'profile.php\'"><i class="fas fa-user-tie" style="margin-right:10px;"></i>Profile</button>
						<button class="buttonView2" onclick="window.location.href=\'logout.php\'"><i class="fas fa-times-circle" style="margin-right:10px;"></i>Logout</button>';
					else
						echo '
						<button class="buttonView1" onclick="window.location.href=\'login.php\'"><i class="fas fa-user-lock" style="margin-right:10px;"></i>Login</button>
						<button class="buttonView1" onclick="window.location.href=\'signup.php\'"><i class="fas fa-user-plus" style="margin-right:10px;"></i>Signup</button>';
				echo '
				</div>
			</div>';
	}
	unset($file);
?>