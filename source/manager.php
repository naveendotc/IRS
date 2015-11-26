<?php include("header.php"); include("constants.php");  ?>

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
<?php

if(isset($_COOKIE["uid"])) { // First If

	$uid = $_COOKIE["uid"];
	$conn = mysqli_connect(DBSERVER, USER, PASSWORD, DATABASE);
	$result = mysqli_query($conn,"SELECT full_name from users where user_id='$uid'");
	$row = mysqli_fetch_array($result);
	$full_name = $row["full_name"];

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
                <li><a href="user.php" id='userview'>User View</a></li>
                <li><a href="solver.php" id='solverview'>Solver View</a></li>
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

	// Manager Page will be organized as follows: Unassigned Issues For Your Attention
	// Manager Analytics
	// Settings and Permissions
?>
<div class="container">
      	<div class="col-md-12">
		
	<!-- ****************************** START Unassigned Issues ************************* -->
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
				
				<div class='form-group'>
				<form method=post name='assigntype' action='assigntype.php'>
				<div class='col-md-9'>
					<select class='form-control' name='assigntype' id ='assigntype'>
						<option selected disabled value='Set Type As'>Set Type As</option>
						<option value='Type-1'>Type-1</option>
						<option value='Type-2'>Type-2</option>
						<option value='Type-3'>Type-3</option>
					</select>
				</div>
					<input type=hidden name='issueID' value='$r[0]'>
					<input type=hidden name='managerID' value='$uid'>
				
					&nbsp;&nbsp;<input type='submit' value='Assign' class='btn btn-primary'>
				
				</form>
				</div>
				
			</td>
		</tr>
			");
		}
 	} // ending else ?>

	</table>
	</div>
	</div>

	</div> <!-- end div row2. Done with Show Unassigned -->
	<!-- ****************************** END Unassigned Issues ************************* -->


	<!-- ****************************** START Managerial Analytics ******************** -->
<?php
	// Introducing NJQL - Naveen-Jaspreet Query Language
	// Query Structure is as follows:
	// <Action> <HowMany> <Who> with <Superlative> <Metric>
?>

	<div class="row" id="row22">

	<div class='panel panel-default'>
		<div class='panel-heading'>
			<h3 class='panel-title'><center><b>Managerial Analytics</b></center></h3>
		</div>
		<div class='panel-body'>
	<div class="form-group">
	<center>
	<form method=post name='analytics' action='analytics.php'>
	<!-- 1. Action -->
	<div class='col-md-2'>
	<select class="form-control" name="action_1" id = "action_1">
		<option selected disabled value="Choose Action">Choose Action</option>
		<option value="action_list">List</option>
		<option value="action_plot">Plot</option>
	</select>
	</div>
	<!-- 2. HowMany -->
	<div class='col-md-2'>
	<select class="form-control" name="how_2" id = "how_2">
		<option selected disabled value="How many">How Many</option>
		<option value="All">All</option>
		<option value="Top_One">Top</option>
		<option value="Top_Five">Top Five</option>
		<option value="Top_Ten">Top Ten</option>
	</select>
	</div>
	<!-- 3. Who -->
	<div class='col-md-2'>
	<select class="form-control" name="who_3" id = "who_3">
		<option selected disabled value="Who">Who</option>
		<option value="Users">Users</option>
		<option value="Solvers">Solvers</option>
	</select>
	</div>
	<!-- 4. Superlative -->
	<div class='col-md-2'>
	<select class="form-control" name="sup_4" id = "sup_4">
		<option selected disabled value="With">With</option>
		<option value="Highest">Highest</option>
		<option value="Lowest">Lowest</option>
	</select>
	</div>
	<!-- 5. Metric -->
	<div class='col-md-3'>
	<select class="form-control" name="metric_5" id = "metric_5">
		<option selected disabled value="Metric">Metric</option>
		<option value="Issues_Registered">Issues Registered</option>
		<option value="Issues_Assigned">Issues Assigned</option>
		<option value="Issues_Solved">Issues Solved</option>
		<option value="Issues_Pending">Issues Pending</option>
		<!-- <option value="Issues_Solved_To_Assigned_Ratio">Issues Solved To Assigned Ratio</option>
		<option value="Issues_Delegated_To_Assigned_Ratio">Issues Solved To Assigned Ratio</option>
		<option value="Time_Taken_Per_Solver_Action">Time Taken Per Solver Action</option> -->
	</select>
	</div>
<?php echo("
	<input type=hidden name='managerID' value='$uid'>
	<input type=submit value='Submit' class='btn btn-primary'> ");
?>
	</form>
	<!-- ****************************** END Managerial Analytics ******************** -->
	</div> <!-- Close div btn group -->
	</center>

	</div>
	</div>

	</div> <!-- end div row22. -->

</div> <!--- ending div col-md-12 -->
	</div> <!-- ending div container -->


<?php
	mysqli_close($conn);

	} // end First if
?>
	
	




</body>
</html>
