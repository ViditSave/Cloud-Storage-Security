<?php
	$connect = mysqli_connect("localhost", "root", "", "SecureStorage");
	if (!(isset($file)))
		echo '
			<script type="text/javascript" src="Libraries/JQuery/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
			<link rel="stylesheet" type="text/css" href="Libraries/Bootstrap/css/bootstrap.min.css">
			<script type="text/javascript" src="Libraries/Bootstrap/js/bootstrap.min.js"></script>';
	unset($file);
?>