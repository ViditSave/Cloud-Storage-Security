<?php 	
	session_start();	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require 'C:\xampp\htdocs\SecureStorage\Libraries\PHPMailer\src\Exception.php';
	require 'C:\xampp\htdocs\SecureStorage\Libraries\PHPMailer\src\PHPMailer.php';
	require 'C:\xampp\htdocs\SecureStorage\Libraries\PHPMailer\src\SMTP.php';
	$mailType=$_POST["Type"];
	if ($mailType=="Sign Up") {
		if(isset($_POST['Fname']) & isset($_POST['Lname']) & isset($_POST['Email']) & isset($_POST['Type']) & isset($_POST['Uname']) ) {
			
			$firstName= $_POST["Fname"];
			$fullName = $_POST["Fname"]." ".$_POST["Lname"];
			$emailAddr= $_POST["Email"];
			$userName = $_POST["Uname"];
	
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Mailer = "smtp";

			$mail->SMTPDebug  = 1;  
			$mail->SMTPAuth   = TRUE;
			$mail->SMTPSecure = "tls";
			$mail->Port       = 587;
			$mail->Host       = "smtp.gmail.com";
			$mail->Username   = "viditsave@gmail.com";
			$mail->Password   = "ViditVirajSave123$";
			$mail->setFrom('viditsave@gmail.com','Secure Storage');

			$mail->IsHTML(true);
			$mail->AddAddress($emailAddr, $fullName);

			$mail->Subject = "Activation key for your account";
			$content = "
			Hi <b>".$firstName."</b><br>
			We have recieved your request to create a new account. To activate your account please click on the following link: <br><br>
			You can find your login details below<br>
			User Name : ".$userName."<br>
			Full Name : ".$fullName."<br>
			Email Addr: ".$emailAddr."<br>";
			$mail->MsgHTML($content); 
			if(!$mail->Send()) {
			  echo "0";
			  var_dump($mail);
			}
			else {
			  echo "1";
			}
		}
		else
			header('Location:index.php');
	}
	else
		header('Location:index.php');
?> 