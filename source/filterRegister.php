<?php
	$fname=$_POST["fname"];
	$activation_url = sha1($uname);
	$pass = sha1($_POST["pwd1"]);
	$eid = $_POST["eid"];
	$current_status = 0;
	
?>