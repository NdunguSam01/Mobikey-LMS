<?php
$servername="localhost";
$username="root";
$password="";
$db="mobikey";

$conn=new mysqli($servername,$username,$password,$db);

if($conn->connect_errno)
{
	die("Connection failed: ". $conn->connect_error);
}
?>