<?php

//Importing PHPMailer classes

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require './vendor/autoload.php';

//Creating a new PHPMailer instance
$mailer=new PHPMailer();

//Setting the parameters
$mailer->isSMTP(); //Configuring PHPMailer to use SMTP
$mailer->SMTPDebug=SMTP::DEBUG_OFF;//Viewing client & server messages
$mailer->Host='smtp.gmail.com'; 	//Configuring mailer to use gmail's SMTP server
$mailer->Port = '587';		        //Configuring port number to be used
$mailer->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;//Configuring server to use TLS implicitly
$mailer->SMTPAuth=  true; //Specifying whether to use SMTP authentication
$mailer->MessageID=uniqid();

//Configuring SMTP username and password
$mailer->Username="ndungu.muigai01@gmail.com";
$mailer->Password="likjeajjvnwrpkyk";

//Setting the sender address
$mailer->setFrom("ndungu.muigai01@gmail.com","Ndungu Muigai");

?>