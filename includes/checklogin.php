<?php
function check_login()
{
if(strlen($_SESSION['id'])==0)
	{	
		$host = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="loginroute.php";		
		$_SESSION["id"]="";
		header("Location: http://$host$uri/$extra");
	}
}
?>