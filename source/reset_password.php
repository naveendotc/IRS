<?php
include("constants.php");
	$eid = $_GET["eid"];
	$pwd = $_GET["pwd"];
	$query = "select * from users where email_id='$eid' and reset_status = 1";
	$con= mysqli_connect(DBSERVER,USER,PASSWORD,DATABASE);
	if(!isset($con))
	{
	    echo("<h2><center><font color='red'>* Database server is presently inactive please try later</font></center></h2>");
	}
	$result = mysqli_query($con,$query);
	if(mysqli_num_rows($result) == 1)
	{
		$row = mysqli_fetch_array($result);
		$query = "update irs.users set reset_status = 0 and password = '$pwd' where email_id='$eid'";
		if(mysqli_query($con,$query))
		{
			include("index.php");
			echo("<div class='alert alert-success' role='alert'>
                        		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<center>Password Reset Successfull: Login with new password. <center></div>");
			//echo("Password Reset Successfull: Login with new password");
		}

	}


?>