<?php



// require_once(“phpmailer/PHPMailer-master/PHPMailerAutoload.php”);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "phpmailer/PHPMailer-master/src/PHPMailer.php";
require "phpmailer/PHPMailer-master/src/SMTP.php";
require "phpmailer/PHPMailer-master/src/Exception.php";

	// require_once "constants.php";

	$mail = new PHPMailer(true);

	    $mail->isSMTP();
	    $mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
	    $mail->SMTPAuth = true;
	    $mail->Username = "noreplybankproject@gmail.com";   //username
	    $mail->Password = "Abank243zz!@";   //password
	    $mail->SMTPSecure = 'ssl';
	    $mail->Port = 465;                    //smtp port

	    $mail->setFrom('noreplybankproject@gmail.com', 'BankBot');


   ?>
