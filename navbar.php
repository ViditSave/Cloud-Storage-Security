<style>
	#home { font-size:3vw; text-decoration:none; color:white;}
	.buttonView{ display: inline-block; background-color: #00000000; border: 0px; padding: 5px 15px; font-size:1.5vw; margin-top:5px; text-decoration: none; color:white;}
	.buttonView:hover {border-bottom:2px solid;}
	ul li{display:none;}
	ul:hover li{display:block; position:relative; top:50px; height:30px;}
	@media (min-width: 350px) and (max-width:550px)  {
		#home { font-size:6vw;}
		.buttonView{ border: 1px solid white; border-radius: 10%; font-size:2.5vw; margin-top:2px;}
	}		
</style>
	
<div style="height:50px; padding:7.5px 0px; color:white; background:#6666ff; position:sticky; width:100%; top:0px; left:0px; z-index:10;">
	<div style="float:left; height:30px; margin-left:30px;">
		<img src="Images/cloud_logo.png" alt="Logo" height="40px" style="margin-right:5px; vertical-align:initial;">
		<a id="home" href="index.php" style="line-height:10px;">Secure Storage</a>
	</div>
	<div style="float:right; margin-right:20px;">
	<?php
		if (isset($_SESSION["username"])&isset($_SESSION["userid"]))
			echo '<button class="buttonView" onclick="window.location.href=\'search.php\'"><span class="glyphicon glyphicon-search" style="margin-right:10px;"></span>Search</button>
			<button class="buttonView" onclick="window.location.href=\'profile.php\'"><span class="glyphicon glyphicon-user" style="margin-right:10px;"></span>Profile</button>
			<button class="buttonView" onclick="window.location.href=\'logout.php\'"><span class="glyphicon glyphicon-remove" style="margin-right:10px;"></span>Logout</button>';
		else
			echo '<button class="buttonView" onclick="window.location.href=\'login.php\'"><span class="glyphicon glyphicon-lock" style="margin-right:10px;"></span>Login</button>
			<button class="buttonView" onclick="window.location.href=\'signup.php\'"><span class="glyphicon glyphicon-user" style="margin-right:10px;"></span>Signup</button>';
	?>
	</div>
</div>