
<?php
include("constants.php");
if(isset($_POST["submit"]))
{
    $uid = $_POST["uid"];
    $pwd = sha1($_POST["pwd"]);
    $query = "select * from users where user_id = '$uid' and password = '$pwd'";
    $con= mysqli_connect(DBSERVER,USER,PASSWORD,DATABASE);
	if(!isset($con))
	{
	    echo("<h2><center><font color='red'>* Database server is presently inactive please try later</font></center></h2>");
	}
	$result = mysqli_query($con,$query);
	$num_rows = mysqli_num_rows($result);
	if($num_rows == 1)
	{
		if(!isset($_COOKIE["uid"]))
		{
        		setcookie("uid",$_POST["uid"]);
    		} else {
		// Delete old cookie and set new cookie
			setcookie("uid",$_POST["uid"]);
		}
	while($row = mysqli_fetch_array($result, MYSQL_NUM)) {
		$privilege = $row[7]; // now holds 0 => user, 1 => user+solver, 2 => user+solver+manager
	}
	switch($privilege) {
		case 0:
			header("Location: user.php");
			break;
		case 1:
			header("Location: solver.php");
			break;
		case 2:
			header("Location: manager.php");
			break;
		default:
			echo ("Error Occurred. Sorry. :( ");
	}
	}
	else
	{
		include("index.php");
		echo("<center><p style='color:red'> * Invalid Combination of user-id and password</p></center>");
	}
}
else
	header("Location: index.php")

?>

