<?php include("header.php"); include("constants.php");  ?>


<script type="text/javascript">
	function validate() {
		if(document.getElementById("new_issue_type").value == "Select Type of Issue") {
			document.getElementById("p2").innerHTML = "* Select issue type";
			return false;
		
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
	$conn = mysqli_connect(DBSERVER, USER, PASSWORD, DATABASE);
	$query = "";
?>


<?php
	// start Welcome and Sign Out button
	$query = "SELECT full_name from users where user_id='$uid'";
	$result = $conn->query($query);
	if($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$full_name = $row["full_name"];
		//echo ("Welcome ".$full_name);
	}

	 else {
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
                <li><a href="#" id='profile'>Edit Profile</a></li>
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

<!--
<div class="bs-example" style="margin-top: -20px;">       
     		<ul class="nav nav-tabs">
     		  <li style="display:none"><a href="#" id='request_prev'>Request for Solver Privileges</a></li>
              <li style="display:none"><a href="#" id="issue_btn">Raise New Issue</a></li>
              <li class="dropdown">
			    <a class="dropdown-toggle"
			       data-toggle="dropdown"
			       href="#">
			        Switch to
			        <b class="caret"></b>
			      </a>
			    <ul class="dropdown-menu">
			      <li><a href="user.php">User View</a></li>
			      <li><a href="solver.php">Solver View</a></li>
			    </ul>
			  </li>
			  <li style"float: right;"><a><?php echo ("Welcome ".$full_name) ?></a></li>
              <li style="float: right;width:100px;"><a href="logout.php">Sign Out</a></li>
			</ul>  
</div>
-->

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

	<div class="col-md-12">
		<!--<button type="button" class="btn btn-primary" id="issue_btn"> 
		Register New Issue
		</button>-->

		

		<!-- Initially Hidden: Form for Register New Issue -->
		<div class="row">
		<div class="col-md-7">
		<br>
		<div id="raise_issue" style="display:none">
		<div class="panel panel-default">
			<div class="panel-heading">
			<h3 class="panel-title"><center>Register New Issue</center></h3>
                	</div>
		<div class="panel-body">
		<form action="user.php" method="post" onsubmit="return validate()">
			<input type="text" id="subject" class="form-control" placeholder="Subject" name="subject" style="width:490px" required><br>
			<select class="selectpicker;btn btn-primary" name="issue_type" id = "new_issue_type">
				<option selected disabled value="Select Type of Issue">Select Type of Issue</option>
				<option value="Type-1">Type-1</option>
				<option value="Type-2">Type-2</option>
				<option value="Type-3">Type-3</option>
				<option value="DoNotKnow">Do Not Know</option>
			</select><p id="p2" style="color:red"></p>
			
			<!-- From MySQL table -->

			<br><br>
			<textarea class="form-control" name="description" id="textarea" style="width:490px; height:150px;" placeholder="Description" required></textarea><br>
			<div align="center">
				<button type="button" class="btn btn-default" id="close">Close</button> <!-- Close button should clear -->
				<input type="submit" class="btn btn-primary" name="report" value="Submit" id="submit"/>
			</div>
		</form>

		</div>
		</div>
		</div>
		</div>
		</div>
		<!-- End: Form for Register New Issue -->


<?php		// Register New Issue - php action

		if(isset($_POST["report"])) { 
			
			$subject = $_POST["subject"];
			$type = $_POST["issue_type"];
			$description = $_POST["description"];
			$status = 0; // 0 => New and Unassigned (Being Processed)
			$timeNow = date('Y-m-d H:i:s');
			
			
			// Decide who to assign to
			if ($type == "DoNotKnow") {
				$currDelegTo = "Manager"; // assign to Manager
			} else {
				$query = "SELECT t1.user_id
						FROM CurrentIssuesWithSolvers AS t1, solvers_issueTypes AS t2
						WHERE  t1.user_id = t2.user_id AND t2.type =  '$type' AND t1.cur_issues = ( 
							SELECT MIN( cur_issues ) 
							FROM CurrentIssuesWithSolvers AS t1, solvers_issueTypes AS t2
							WHERE t1.user_id = t2.user_id
							AND t2.type =  '$type' )";
				$result = mysqli_query($conn, $query);
				$r = mysqli_fetch_array($result, MYSQL_NUM);
				// $currDelegTo = $r[0];
				$currDelegTo = "dotc";


			}
			// Decided who to assign to

			
			$query1 = "INSERT into issues (user_id, raisedTime, subject, type,
							description, issue_status, currDelegTo_uid) 
				values('$uid','$timeNow', '$subject','$type',
							'$description','$status','$currDelegTo')";

			if(!isset($conn)) {
				echo "<h2><center><font color='red'>
					* Database server is presently inactive. Please try later.
					</font></center></h2>";
			}

			if (mysqli_query($conn, $query1)) {
				$query = "SELECT LAST_INSERT_ID() from issues";
				$result = mysqli_query($conn, $query);
				$row = mysqli_fetch_array($result, MYSQL_NUM);
				$issue_id = $row[0];
								
				$query2 = "INSERT into issue_transactions (trans_time, user_id, trans_type, issue_id, 
								new_issue_status, new_issue_comments, delegatedTo)
				values('$timeNow', '$uid', 1, '$issue_id', '$status', 'NEW', '$currDelegTo')"; // trans_type 1 => Raise

				
				if (mysqli_query($conn, $query2)) {
                        		echo("<div class='alert alert-success' role='alert'>
                        		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					Issue has been successfully registered. </div>");
				

				$subquery = "SELECT cur_issues from CurrentIssuesWithSolvers WHERE user_id='$currDelegTo'";
				$subresult = mysqli_query($conn, $subquery);
				$subrow = mysqli_fetch_array($subresult, MYSQL_NUM);
				$old_cur_issues = $subrow[0];
				$new_cur_issues = $old_cur_issues + 1;


				// Increment curr issues to deleg to solver
				$query3 = "UPDATE CurrentIssuesWithSolvers SET cur_issues='$new_cur_issues' WHERE user_id='$currDelegTo'";
				$result = mysqli_query($conn, $query3);
				} else {
					echo("Unexpected Failure. Please try again.");
				}
			} else {
				echo("Unexpected Failure. Please try again.");
			}
			

			
		} // end if isset. 

		// Done with Register New Issue.
?>

	<!-- Show Open Issues Now -->
	<div class="row" id="row2">
<?php
	if(!isset($conn)) {
		echo "<h2><center><font color='red'>
		* Database server is presently inactive. Please try later.
		</font></center></h2>";
	}
	$query = "SELECT * from issues where user_id='$uid' AND issue_status=0"; // 0 => open (not resolved)
	$result = mysqli_query($conn, $query);
?>
	<div class='panel panel-default'>
		<div class='panel-heading'>
			<h3 class='panel-title'><center><b>Pending Issues Registered By Me</b></center></h3>
		</div>
		<div class='panel-body'>
		<table class='table table-hover'>
<?php
	if (mysqli_num_rows($result) == 0) {
		echo ("<tr><th>All Issues Registered by You have been Resolved/Closed.</th></tr>");
	} else {
?>
		
		<tr>
			<th>Issue Id</th><th>Subject</th><th>Registered On</th><th>Currently Assigned To</th><th>More</th>
			<!-- More = Description, Issue History, Escalate -->
		</tr>
<?php
		while($r = mysqli_fetch_array($result, MYSQL_NUM)) {
			echo ("
		<tr>
			<td>$r[0]</td><td>$r[3]</td><td>$r[2]</td><td>$r[7]</td>
			<td>
				<ul>
				<li><button type='button' class='btn btn-primary' title='Description' data-toggle='popover' data-trigger='focus' data-content='$r[5]'>Description</button></li>
				<li><a href='#'>Issue_History</a></li>
				<li>
					<form method=post name='escalateform' action='escalate.php'>
					<input type=hidden name='issueID' value='$r[0]'>
					<input type=hidden name='userID' value='$uid'>
					<input type=submit value='Escalate' class='btn btn-primary'>
					</form>
				</li>
				</ul>
			</td>
		</tr>
			");
		}
 	} // ending else ?>

	</table>
	</div>
	</div>

	</div> <!-- end div row2. Done with Show Open Issues. -->

<!-- Show All Issues Now -->
	<div class="row" id="row3">
	<div class='panel panel-default'>
		<div class='panel-heading'>
			<h3 class='panel-title'><center><b>All Issues Registered By Me</b></center></h3>
		</div>
		<div class='panel-body'>
		<table class='table table-hover'>
<?php
	if(!isset($conn)) {
		echo "<h2><center><font color='red'>
		* Database server is presently inactive. Please try later.
		</font></center></h2>";
	}
	$query = "SELECT * from issues where user_id='$uid'";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) == 0) {
		echo ("<tr><th>No Issues Registered by You</th></tr>");
	} else {
?>
		
		<tr>
			<th>Issue Id</th><th>Subject</th><th>Registered On</th><th>Current Status</th><th>More</th>
		</tr>
<?php
		while($r = mysqli_fetch_array($result, MYSQL_NUM)) {
			if ($r[6] == 0) $stat = "Being processed";
			else $stat = "Resolved";
			echo ("
		<tr>
			<td>$r[0]</td><td>$r[3]</td><td>$r[2]</td><td>$stat</td><td>More</td>
		</tr>
			");
		}
	} // ending else ?>

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
