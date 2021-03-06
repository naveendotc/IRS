<?php include("constants.php"); include("header.php"); ?>



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
	$conn = mysqli_connect(DBSERVER, USER, PASSWORD, DATABASE);
	$query = "";

	// start Welcome and Sign Out button
	$query = "SELECT full_name from users where user_id='$uid'";
	$result = $conn->query($query);
	if($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$full_name = $row["full_name"];
		//echo ("Welcome ".$full_name);

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
                <li><a href="#" style="display:none" id="issue_btn">Raise New Issue</a></li>
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
	if($privilege == 1) // 1 => user+solver
	{
		echo("<script>document.getElementById('userview').style.display='';</script>");
	}
	else if($privilege == 2)
	{
		echo("<script>document.getElementById('userview').style.display='';</script>");
		echo("<script>document.getElementById('managerview').style.display='';</script>");
	}
	
		
	
	
?>

	<div class="container">
      	<div class="col-md-12">
		

	<!-- Show Open Issues Assigned To You -->
	<div class="row" id="row2">

	<div class='panel panel-default'>
		<div class='panel-heading'>
			<h3 class='panel-title'><center><b>Issues Currently Assigned To You</b></center></h3>
		</div>
		<div class='panel-body'>
		<table class='table table-hover'>
<?php
	if(!isset($conn)) {
		echo "<h2><center><font color='red'>
		* Database server is presently inactive. Please try later.
		</font></center></h2>";
	}
	$query = "SELECT * from issues where currDelegTo_uid='$uid' AND issue_status=0"; // 0 => open (not resolved)
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) == 0) {
		echo ("<tr><th>No Issues Currently Assigned To You</th></tr>");
	} else {
?>
		
		<tr>
			<th>Issue Id</th><th>Subject</th><th>Registered On</th><th>Registered By</th><th>More</th>
			<!-- More = Description, Issue History, Take Action (Solve This Issue/ Delegate This Issue) -->
		</tr>
<?php
		while($r = mysqli_fetch_array($result, MYSQL_NUM)) {
			echo ("
		<tr>
			<td>$r[0]</td><td>$r[3]<br><a href='#' title='Description' data-toggle='popover' data-trigger='focus' data-content='$r[5]'>Description</a></td><td>$r[2]</td><td>$r[1]</td>
			<td>
				<form method=post name='historyform' action='history.php'>
					<input type=hidden name='issueID' value='$r[0]'>
					<input type=hidden name='userID' value='$uid'>
					<input type=hidden name='landingFrom' value='solver'>
					<a href='javascript:;' onclick='parentNode.submit();'>Issue History</a>
				</form>
				<form method=post name='takeactionform' action='takeAction.php'>
					<input type=hidden name='issueID' value='$r[0]'>
					<input type=hidden name='solverID' value='$uid'>
					<a href='javascript:;' onclick='parentNode.submit();'>Take Action</a>
					<!-- <input type=submit value='Take Action' class='btn btn-primary'> -->
				</form>
			</td>
		</tr>
			");
		}
 	} // ending else ?>

	</table>
	</div>
	</div>

	</div> <!-- end div row2. Done with Show Open Issues Assigned To You. -->

<!-- Show All Issues Assigned To You -->
	<div class="row" id="row3">
	<div class='panel panel-default'>
		<div class='panel-heading'>
			<h3 class='panel-title'><center><b>All Issues Assigned To You</b></center></h3>
		</div>
		<div class='panel-body'>
		<table class='table table-hover'>
<?php
	if(!isset($conn)) {
		echo "<h2><center><font color='red'>
		* Database server is presently inactive. Please try later.
		</font></center></h2>";
	}
	$query = "SELECT * from issue_transactions where delegatedTo='$uid'";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) == 0) {
		echo ("<tr><th>No Issues Assigned To You</th></tr>");
	} else {
?>
		
		<tr>
			<th>Issue Id</th><th>Subject</th><th>Assigned To You On</th><th>Action Taken By You</th><th>More</th>
		</tr>
<?php
		while($r = mysqli_fetch_array($result, MYSQL_NUM)) {
			$issue_id = $r[4];
			
			$query = "SELECT subject, description from issues WHERE issue_id='$issue_id'";
			$resss = $conn->query($query);
			$rowww = $resss->fetch_assoc();
			$subject = $rowww["subject"];
			$description = $rowww["description"];
		
			$actionTaken = "Action ??";
			$whichActionQuery = "select * from issue_transactions where trans_id = (select max(trans_id) from issue_transactions where user_id = '$uid' AND issue_id='$issue_id')";
			$whichActionResult = mysqli_query($conn, $whichActionQuery) or die(mysqli_error($conn));
			
			if(mysqli_num_rows($whichActionResult) > 0) {
				$rowww = mysqli_fetch_array($whichActionResult);
				$actionTakenNum = $rowww["new_issue_status"];
				if($actionTakenNum === '0') {
					$delegatedTo = $rowww["delegatedTo"];
					$delegatedOn = $rowww["trans_time"];
					$actionTaken = "Delegated to ".$delegatedTo." on ".$delegatedOn;
				} else {
					$solvedOn = $rowww["trans_time"];
					$actionTaken = "Solved on ".$solvedOn;
				}
			} else {
				$actionTaken = "Pending<br>"."<form method=post name='takeactionform2' action='takeAction.php'>
					<input type=hidden name='issueID' value='$issue_id'>
					<input type=hidden name='solverID' value='$uid'>
					<a href='javascript:;' onclick='parentNode.submit();'>Take Action</a>
					<!-- <input type=submit value='Take Action' class='btn btn-primary'> -->
				</form>";
			}

			
			echo ("
		<tr>
			<td>$issue_id</td><td>$subject<br><a href='#' title='Description' data-toggle='popover' data-trigger='focus' data-content='$description'>Description</a></td><td>$r[1]</td><td>$actionTaken</td><td>
				<form method=post name='historyform2' action='history.php'>
					<input type=hidden name='issueID' value='$issue_id'>
					<input type=hidden name='userID' value='$uid'>
					<input type=hidden name='landingFrom' value='solver'>
					<a href='javascript:;' onclick='parentNode.submit();'>Issue History</a>
				</form>
			</td>
		</tr>
			");
		}
	} // ending else 
?>

		</table>
		</div>
		</div>

	</div> <!-- end div row3. Done with Show All Issues. -->


	</div> <!--- ending div col-md-10 -->
	</div> <!-- ending div container -->


<?php
	mysqli_close($conn);

	} // end if
?>
	
	




</body>
</html>
