<?php

if(isset($_COOKIE['uid']))
{
	setcookie("uid", "", time() - 3600);
	include('index.php');
	echo("<center><h2 class='alert alert-success'>Signed Out Successfully</h2></center>");
}
?>
