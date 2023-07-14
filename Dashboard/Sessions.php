<?php
session_start();

if(!isset($_SESSION['username']))
{
    $_SESSION["status"]="Unauthorized";//Setting login status
    $_SESSION['msg']="Kindly log in to continue";//Setting message to be displayed
	header("Location: ../Login");//Redirecting to the login page
}
if(time()-$_SESSION["login_time"]>1800)
{
    $_SESSION["status"]="Expired";
    $_SESSION["msg"]="Login session expired. Kindly log in again";
    header("Location: ../Login");
}
?>