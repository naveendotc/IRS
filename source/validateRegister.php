<?php
include("constants.php");
if(isset($_POST["submit"]))
{
	$name=$_POST["fname"];
	$eid=$_POST["eid"];
	$contact=$_POST["contact"];
	$pwd1=sha1($_POST["pwd1"]);
	$url=sha1($name);
	$uid=$_POST["uid"];
	//echo($name.$eid.$contact.$pwd1);
	error_reporting(E_ALL);
//error_reporting(E_STRICT);

	date_default_timezone_set('America/Toronto');

	require_once('class.phpmailer.php');
	//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

	$mail = new PHPMailer();
	//$body="Hello user...click on the below link to activate your account. Please use the same browser to activate your account  ";
	//print "<br/>";
	$link="http://".DBSERVER."/IRS_JSB/source/activate.php?eid=".sha1($eid)."&url=".$url;
	$body="Click here to activate your account ". $link;
	//$body=$link;

	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = "mail.yourdomain.com"; // SMTP server
	$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
	                                           // 1 = errors and messages
	                                           // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "qweertyuiop0@gmail.com";  // GMAIL username
	$mail->Password   = "7200793706";            // GMAIL password


	$mail->AddReplyTo("name@yourdomain.com","First Last");

	$mail->Subject    = "Activation Link from Issue Resolving System";

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

	$mail->MsgHTML($body);

	$address = $eid;
	$mail->AddAddress($address, "");

	//$mail->AddAttachment("images/phpmailer.gif");      // attachment
	//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
	//echo "Hello";
	if(!$mail->Send())
	{
	    //include('header.php');
	    echo "<h2><center><font color='red'>* Mailer Error: Error in sending activation link to mail because of slow internet connections or due to invalid mail id... check it again...</font></center></h2>";//. $mail->ErrorInfo;
	    //include('register1.php');
	}
	else
	{
	    //include('header.php');
	    $query="insert into users(full_name,user_id,password,acc_status,encrypt_url,email_id,phone_number,privileges,reset_status) values('$name','$uid','$pwd1',0,'$url','$eid','$contact',0,0)";
	    $con= mysqli_connect(DBSERVER,USER,PASSWORD,DATABASE);
        if(!isset($con))
        {
            echo "<h2><center><font color='red'>* Database server is presently inactive please try later</font></center></h2>";
        }
        if(mysqli_query($con,$query))
        {
        	include("index.php");
        	echo("<div class='alert alert-success'><center>Registration successfull: Please click on activation link sent to your registered email id</center></div>");
        }
        else
        {
        	include("index.php");
        	echo("<div class='alert alert-danger'><center>Registration failed: Email id or user id is already registered!!</center></div>");
        }
	    //echo "<h2><center><font color='blue'>* Feedback sent successfully</font></h2></center>";
	    //include('footer.php');
	}
}

?>
