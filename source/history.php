<?php include("constants.php"); include("header.php"); ?>


<script type="text/javascript">
	function validate() {
		if(document.getElementById("new_issue_type").value == "Select Type of Issue") {
			document.getElementById("p2").innerHTML = "* Select issue type";
			return false;
		
	}
</script>

<script type="text/javascript">
	function goTakeAction() {
		window.location = 'takeAction.php';
	}
</script>
<script type="text/javascript">
    $(document).ready(function(){
	$("li").mouseover(function(){
              $(this).addClass("active");
	      });
	      $("li").mouseout(function(){
	              $(this).removeClass("active");
	      });
      $('[data-toggle="popover"]').popover();
      $("#issue_btn").click(function(){
        $("#raise_issue").show(200);
      });
      $("#close").click(function(){ // Do ---> clear all the fields
        $("#raise_issue").hide();
      });
      $("#update").click(function(){ // ???
        $("#row3").show(200);
      });
      $("#request_priv").click(function(){ // ???
        $("#row4").show(200);
      });
      $("#subject").focusin(function(){
        $(this).css("background-color", "#FFFFCC");
      });
      $("#subject").focusout(function(){
        $(this).css("background-color", "#FFFFFF");
        if ( $(this).val() == '' ) {
            $("#p1").html("* This field should not be blank"); // Check: Where is p1 ???
        } 
        else
        {
          $("#p1").html("");
        }
      });
      $("select").focusout(function(){
        if ( $(this).val() == null ) {
            $("#p2").html("* This should not be blank"); // Check/ Do: Add for p22
        } 
        else
        {
          $("#p2").html("");
        }
      });
      $("#textarea").focusout(function(){
        $(this).css("background-color", "#FFFFFF");
        if ( $(this).val() == '' ) {
            $("#p3").html("* This field should not be blank"); // Check: Where is p3 ???
        } 
        else
        {
          $("#p3").html("");
        }
      });
    });
</script>

<body>
<?php if(isset($_COOKIE["uid"])) {
	
	// extract $uid and Set Connection to MySQL server
	$uid = $_COOKIE["uid"];
	if (!($uid == $_POST["userID"])) { echo "Invalid Log In Priveleges"; // send this guy to log in page
					}
	
	$issue_id = $_POST["issueID"];
	$landing_from = $_POST["landingFrom"];

	$conn = mysqli_connect(DBSERVER, USER, PASSWORD, DATABASE);
	$query = "";

	// start Welcome and Sign Out button
	$query = "SELECT full_name from users where user_id='$uid'";
	$result = $conn->query($query);
	if($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$full_name = $row["full_name"];
		//echo ("Welcome ".$full_name);
?>
	
<?php
	} else {
		echo ("Error occurred :( ");
	} // Done with Welcome and Sign Out button
	
	// Extract Privileges
	$query = "SELECT privileges from users where user_id = '$uid'";
	if(!isset($conn)) {
		echo "<h2><center><font color='red'>* Database server is presently inactive please try later</font></center></h2>";
	}
	$result = mysqli_query($conn, $query);
	if (! ($result->num_rows == 1)) { echo "<br>Error extracting privileges<br>"; }
	while($row = mysqli_fetch_array($result, MYSQL_NUM)) {
		$privilege = $row[0]; // now holds 0 => user, 1 => user+solver, 2 => user+solver+manager
	}
	if( !($privilege == 0 || $privilege == 1 || $privilege == 2)) { echo "Invalid Privilege!! <br>"; }

?>
<div class="bs-example" style="margin-top: -20px;">
    <nav role="navigation" class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
        </div>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                
                <!-- <li><a href="#" id='profile'>Edit Profile</a></li> -->
                <li><a href="user.php" id='userview' style="display:none">User View</a></li>
                <li><a href="solver.php" id='solverview' style="display:none">Solver View</a></li>
                <li><a href="manager.php" id='managerview' style="display:none">Manager View</a></li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
            	<li><a href="#"><?php echo ("Welcome ".$full_name) ?></a></li>
                <li><a href="logout.php">Sign Out</a></li>
            </ul>
        </div>
    </nav>
</div>
<?php
	// Request Solver Privilege button
	
	if($privilege == 1)
	{
		//echo("<script>document.getElementById('userview').style.display='';</script>");
		echo("<script>document.getElementById('solverview').style.display='';</script>");
	}
	else if($privilege == 2)
	{
		echo("<script>document.getElementById('solverview').style.display='';</script>");
		echo("<script>document.getElementById('managerview').style.display='';</script>");
	}
	
		
	
	
?>

	<div class="container">
        <div class="col-md-2">
        	<ul class="nav nav-stacked">

<?php
	// Request Solver Privilege button
	if($privilege == 1) // 1 => user+solver
	{
		/* echo("<li><button type='button' class='btn btn-primary' id='request_priv'>
		Request for Manager Privileges
		</button></li>"); */
		echo("<script>document.getElementById('request_prev').style.display='';</script>");
	}
	


	// Get Details on The Issue at hand
	$query = "SELECT * from issues where issue_id='$issue_id'";
	if(!isset($conn)) {
		echo "<h2><center><font color='red'>* Database server is presently inactive please try later</font></center></h2>";
	}
	$result = mysqli_query($conn, $query);
	if (! ($result->num_rows == 1)) { echo "<br>Error extracting issue information<br>"; }
	$row = mysqli_fetch_array($result, MYSQL_NUM);

		
		$raisedBy = $row[1];
		$raisedTime = $row[2];
		$subject = $row[3];
		$type = $row[4];
		$description = $row[5];
		$prevDelegTo = $row[8];
		$prevComm = $row[9];
		$hist_times = $row[10];
		$hist_statuses = $row[11];
		$hist_delegs = $row[12];
		$hist_comms = $row[13];
	
		$ar_times = preg_split("/[;]/", $hist_times); // last one empty
		$ar_stats = preg_split("/[;]/", $hist_statuses);
		$ar_deles = preg_split("/[;]/", $hist_delegs);
		$ar_comms = preg_split("/[;]/", $hist_comms);
		if(!( sizeof($ar_times) === sizeof($ar_stats) && sizeof($ar_stats) === sizeof($ar_deles) && sizeof($ar_deles) === sizeof($ar_comms))) { 		echo("ERROR - All history arrays not equal<br>"); }
		else { $l = sizeof($ar_times); } // includes last one which is blank

		
	
	
?>
		</ul>
	</div> <!--- ending div col-md-2 -->



	<!-- START MAIN FRAME -->
	<div class="col-md-12">
		<div class="row" id="row2">

	<div class='panel panel-default'>
		<div class='panel-heading'>
			<h3 class='panel-title'><center><b>Issue History for Issue ID <?php echo ("$issue_id"." (Subject: ".$subject.")"); ?></b></center></h3>
		</div>
		<div class='panel-body'>
		<table class='table table-hover'>
		<tr>
			<th>Time and Date</th><th>Event</th><th>Comments</th>
		</tr>

<?php

		//<tr>
		//	<td>Time and Date</td><td>Delegatee</td><td>Action</td><td>Comments</td>
		//</tr>
		
		for($iter = 0; $iter < $l - 1; $iter++) {
			echo("<tr>
				<td>$ar_times[$iter]</td>");
			if($iter == 0) { echo("<td>Issue REGISTERED by $raisedBy<br>Issue ASSIGNED to $ar_deles[0]</td>");
					echo("<td>NEW: <a href='#' title='Description' data-toggle='popover' data-trigger='focus' data-content='$description'>Description</a></td>");
			}
			else {
				// write code here
				if($ar_stats[$iter] === '0') { // Not yet solved, hence Delegated
					$iterminus1 = $iter - 1;
					echo("<td>Issue DELEGATED by $ar_deles[$iterminus1]<br>Issue ASSIGNED to $ar_deles[$iter]</td>");
					echo("<td>".$ar_deles[$iterminus1].": $ar_comms[$iter]</td>");
				} // end if
				else { // solved
					$iterminus1 = $iter - 1;
					echo("<td>Issue SOLVED by $ar_deles[$iterminus1]</td>");
					echo("<td>".$ar_deles[$iterminus1].": $ar_comms[$iter]</td>");
					break;
				}
			} // end else
		
		} // end for
		
	
?>			


		</table>
	</div>
	</div>

	</div> <!-- end div row2. Done with Show Open Issues Assigned To You. -->
	
		<div class="wrapper" style="text-align:center;">
			
			
			
<?php
	if($landing_from === "user") {
		echo("
			<form name=\"backform\" action=\"user.php\">
				<input type=\"Submit\" value=\"Back\" class='btn btn-primary' style='margin:auto;display:block;'>
			</form>
			");
	}
	if($landing_from === "solver") {
		echo("
			<form name=\"backform\" action=\"solver.php\">
				<input type=\"Submit\" value=\"Back\" class='btn btn-primary' style='margin:auto;display:block;'>
			</form>
			");
	}
	if($landing_from === "manager") {
		echo("
			<form name=\"backform\" action=\"manager.php\">
				<input type=\"Submit\" value=\"Back\" class='btn btn-primary' style='margin:auto;display:block;'>
			</form>
			");
	}
	

?>
				
		</div>
		

	</div> <!--- ending div col-md-10 -->
	</div> <!-- ending div container -->


<?php
	mysqli_close($conn);

	} // end if
?>
	
	




</body>
</html>
