<style>
	#home { font-size:3vw; text-decoration:none; color:white;}
	.buttonView{ display: inline-block; background-color: #6666ff; border: 1px solid white; padding: 5px 15px; border-radius: 10%; font-size:1.5vw; margin-top:5px; text-decoration: none; color:white;}
	@media (min-width: 350px) and (max-width:550px)  {
		#home { font-size:6vw;}
		.buttonView{ border: 1px solid white; border-radius: 10%; font-size:2.5vw; margin-top:2px;}
	}		
</style>
<div style="height:50px; padding:10px 0px; color:white;">
	<div style="float:left; height:30px; margin-left:20px;">
		<a id="home" href="index.php">Secure Storage</a>
	</div>
	<div style="float:right; margin-right:20px;">
	<?php
		if (isset($_SESSION["username"])&isset($_SESSION["userid"])) {
			echo '	<button class="buttonView">'.$_SESSION["username"].'</button>
					<button class="buttonView" onclick="window.location.href=\'logout.php\'">Logout</button>';
		}
		else {
			echo '	<button class="buttonView" onclick="window.location.href=\'login.php\'">Login</button>
					<button class="buttonView" onclick="window.location.href=\'signup.php\'">Signup</button>';
		}
	?>
	</div>
</div>