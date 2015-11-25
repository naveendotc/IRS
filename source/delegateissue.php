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
	if (!($uid == $_POST["solverID"])) { echo "Invalid Log In Priveleges"; // send this guy to log in page
					}
	
	$issue_id = $_POST["issueID"];

	$conn = mysqli_connect(DBSERVER, USER, PASSWORD, DATABASE);
	$query = "";

	// start Welcome and Sign Out button
	$query = "SELECT full_name from users where user_id='$uid'";
	$result = $conn->query($query);
	if($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$full_name = $row["full_name"];
		echo ("Welcome ".$full_name);
?>
	<form action="logout.php">
		<input type="submit" class="btn btn-primary" id="logout_btn" value="Sign Out"><!-- Check this and correct this -->
	</form>
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
	<div class="container">
        <div class="col-md-2">
        	<ul class="nav nav-stacked">

<?php
	// Request Solver Privilege button
	if($privilege == 1) // 1 => user+solver
	{
		echo("<li><button type='button' class='btn btn-primary' id='request_priv'>
		Request for Manager Privileges
		</button></li>");
	}
?>


<?php

	// Delegate Transaction: update in issues, issue_transactions, curr_issues, and then redirect to solver.php
		
		// required for update in issues
		$newDeleg = $_POST["newDeleg"];		
		$comments = $_POST["comms"];
		$timeNow = date('Y-m-d H:i:s');
		
		// In issues: Update status, currDeleg, Prev_Deleg, prevComment
		$query = "UPDATE issues SET currDelegTo_uid='$newDeleg', prevDelegTo_uid='$uid',
				prevComment='$comments'
				WHERE issue_id='$issue_id'";
		$result = mysqli_query($conn, $query);

		//required for update in issue_transactions
		

		// In issue_transactions: Insert:
		$query = "INSERT into issue_transactions (trans_time, user_id, trans_type, issue_id, 
								new_issue_status, new_issue_comments, delegatedTo)
				values('$timeNow', '$uid', 4, '$issue_id', 0, '$comments', '$newDeleg')"; // trans_type 4 => Delegate
		
		$result = mysqli_query($conn, $query);


		// required for update in curr_issues
		$subquery = "SELECT cur_issues from CurrentIssuesWithSolvers WHERE user_id='$uid'";
		$subresult = mysqli_query($conn, $subquery);
		$subrow = mysqli_fetch_array($subresult, MYSQL_NUM);
		$old_cur_issues = $subrow[0];
		$new_cur_issues = $old_cur_issues - 1;
		// In cur_issues: Decrement curr issues 
		$query = "UPDATE CurrentIssuesWithSolvers SET cur_issues='$new_cur_issues' WHERE user_id='$uid'";
		$result = mysqli_query($conn, $query);

		$subquery = "SELECT cur_issues from CurrentIssuesWithSolvers WHERE user_id='$newDeleg'";
		$subresult = mysqli_query($conn, $subquery);
		$subrow = mysqli_fetch_array($subresult, MYSQL_NUM);
		$old_cur_issues = $subrow[0];
		$new_cur_issues = $old_cur_issues + 1;
		// In cur_issues: Increment curr issues
		$query = "UPDATE CurrentIssuesWithSolvers SET cur_issues='$new_cur_issues' WHERE user_id='$newDeleg'";
		$result = mysqli_query($conn, $query);
		
?>






<?php
	mysqli_close($conn);

	header('Location: solver.php');    


	} // end if
?>
	
	




</body>
</html>
