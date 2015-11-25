<?php
	include("constants.php");
//echo($_GET["eid"]."   ".$_GET["url"]);
	$query="select email_id,acc_status,encrypt_url from users";
	$con= mysqli_connect(DBSERVER,USER,PASSWORD,DATABASE);
    if(!isset($con))
    {
        echo "<h2><center><font color='red'>* Database server is presently inactive please try later</font></center></h2>";
    }
    $result=mysqli_query($con,$query);
    $flag=0;
    while($row = mysqli_fetch_array($result, MYSQL_NUM))
    {
    	if($_GET["eid"] == sha1($row[0]) && $_GET["url"] == $row[2] && $row[1] == 0)
    	{
    		mysqli_query($con,"update irs.users SET acc_status = 1 WHERE users.email_id = '$row[0]'");
    		include("index.php");
    		echo("<div class='alert alert-success'><center>Account activated</center></div>");
    		$flag=1;
    	}
    }
    if($flag == 0)
    {
    	include("index.php");
    	echo("<div class='alert alert-danger'><center>You are not a registered user</center></div>");
    }
?>