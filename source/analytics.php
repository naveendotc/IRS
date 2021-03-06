
<?php 
ob_start();
 include("header.php"); include("constants.php");  ?>

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
                <li><a href="#" id='profile'>Edit Profile</a></li>
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

	// Analytics Page will be organized as follows: 
	// If Action == List : Table in Center
	// Else (Action == Plot): Plot in Center

	$actionToBeDone = $_POST["action_1"];
	$howMany = $_POST["how_2"]; 
	$whoWho = $_POST["who_3"];
	$superlative = $_POST["sup_4"];
	$metric = $_POST["metric_5"];

	// set $num as number corresponding to $howMany
	if($howMany === "All") $num = 9999; // equivalent to All
	if($howMany === "Top_One") $num = 1;
	if($howMany === "Top_Five") $num = 5;
	if($howMany === "Top_Ten") $num = 10;

	if($superlative === "Lowest") $ascOrDesc = "ASC";
	else if($superlative === "Highest") $ascOrDesc = "DESC";
	else echo("Bad Sup! Invalid Query! Please try again.");
	}


	if($actionToBeDone === "action_list") {
		//echo("action_list selected");
		

?>
<div class="container">
      	<div class="col-md-12">
		
	<!-- ****************************** START List Action ************************* -->
	<div class="row" id="row2">

	<div class='panel panel-default'>
		<div class='panel-heading'>
			<h3 class='panel-title'><center><b><?php echo("List ".$howMany." ".$whoWho." with ".$superlative." ".$metric); ?></b></center></h3>
		</div>
		<div class='panel-body'>
		
<?php
	if(!isset($conn)) {
		echo "<h2><center><font color='red'>
		* Database server is presently inactive. Please try later.
		</font></center></h2>";
	}

	// Interpret the Query: users - 2 queries, solvers - 5 queries
	if($whoWho === "Users") {

		if($metric === "Issues_Registered") {
			$query = "SELECT user_id AS id, COUNT( user_id ) AS count FROM issues GROUP BY user_id ORDER BY count ".$ascOrDesc;
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) < $num) $num = mysqli_num_rows($result);
			echo("<table class='table table-hover'>");
			echo("
			<tr>
				<th>UserID</th>
				<th>Issues Registered</th>
			</tr>
			");
			for($i=0; $i < $num; $i++) {
				$r = mysqli_fetch_array($result, MYSQL_NUM);
				echo("
				<tr>
					<td>$r[0]</td>
					<td>$r[1]</td>
				</tr>
				");
			}

			echo("</table>");
			// run the query, get the rows, print them as rows of table
		} 

		else if ($metric === "Issues_Pending") {
			$query = "SELECT user_id AS id, COUNT( user_id ) AS count FROM issues WHERE issue_status=0 GROUP BY user_id ORDER BY count ".$ascOrDesc;
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) < $num) $num = mysqli_num_rows($result);
			echo("<table class='table table-hover'>");
			echo("
			<tr>
				<th>UserID</th>
				<th>Issues Registered</th>
			</tr>
			");
			for($i=0; $i < $num; $i++) {
				$r = mysqli_fetch_array($result, MYSQL_NUM);
				echo("
				<tr>
					<td>$r[0]</td>
					<td>$r[1]</td>
				</tr>
				");
			}

			echo("</table>");
			// run the query, get the rows, print them as rows of table
		} 

		else { echo("Invalid Query for Users! Please try again.");
		}

	} else if($whoWho === "Solvers") {

		if($metric === "Issues_Assigned") {
			$query = "SELECT delegatedTo AS id, COUNT( delegatedTo ) AS count FROM issue_transactions WHERE delegatedTo <> 'Solved' GROUP BY delegatedTo ORDER BY count ".$ascOrDesc;
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) < $num) $num = mysqli_num_rows($result);
			echo("<table class='table table-hover'>");
			echo("
			<tr>
				<th>SolverID</th>
				<th>Issues Assigned</th>
			</tr>
			");
			for($i=0; $i < $num; $i++) {
				$r = mysqli_fetch_array($result, MYSQL_NUM);
				echo("
				<tr>
					<td>$r[0]</td>
					<td>$r[1]</td>
				</tr>
				");
			}

			echo("</table>");
			// run the query, get the rows, print them as rows of table

		} else if ($metric === "Issues_Solved") {
			$query = "SELECT user_id AS id, COUNT( user_id ) AS count FROM issue_transactions WHERE delegatedTo='Solved' GROUP BY user_id ORDER BY count ".$ascOrDesc;
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) < $num) $num = mysqli_num_rows($result);
			echo("<table class='table table-hover'>");
			echo("
			<tr>
				<th>SolverID</th>
				<th>Issues Solved</th>
			</tr>
			");
			for($i=0; $i < $num; $i++) {
				$r = mysqli_fetch_array($result, MYSQL_NUM);
				echo("
				<tr>
					<td>$r[0]</td>
					<td>$r[1]</td>
				</tr>
				");
			}

			echo("</table>");
			// run the query, get the rows, print them as rows of table

		} else if ($metric === "Issues_Pending") {
			$query = "SELECT currDelegTo_uid AS id, COUNT( currDelegTo_uid ) AS count FROM issues WHERE issue_status=0 GROUP BY currDelegTo_uid ORDER BY count ".$ascOrDesc;
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) < $num) $num = mysqli_num_rows($result);
			echo("<table class='table table-hover'>");
			echo("
			<tr>
				<th>SolverID</th>
				<th>Issues PENDING</th>
			</tr>
			");
			for($i=0; $i < $num; $i++) {
				$r = mysqli_fetch_array($result, MYSQL_NUM);
				echo("
				<tr>
					<td>$r[0]</td>
					<td>$r[1]</td>
				</tr>
				");
			}

			echo("</table>");
			// run the query, get the rows, print them as rows of table

		//} else if ($metric === "Issues_Pending") {

		//} else if ($metric === "Issues_Pending") {

		} else { echo("Invalid Query for Solvers! Please try again.");
		}

	} else { echo("Bad Who User/Solver! Invalid Query! Please try again.");
	}


?>
	</div>
	</div>

	</div> <!-- end div row2. -->
	</div> <!--- ending div col-md-12 -->
	</div> <!-- ending div container -->
	<!-- ****************************** END List Action ************************* -->


	<!-- ****************************** START Plot Action ******************** -->
<?php
	}
	else if($actionToBeDone === "action_plot") {
		//echo("action_plot selected");

?>
<div class="container">
      	<div class="col-md-12">
		
	<div class="row" id="row2">

	<div class='panel panel-default'>
		<div class='panel-heading'>
			<h3 class='panel-title'><center><b><?php echo("List ".$howMany." ".$whoWho." with ".$superlative." ".$metric); ?></b></center></h3>
		</div>
		<div class='panel-body'>
		
<?php
	if(!isset($conn)) {
		echo "<h2><center><font color='red'>
		* Database server is presently inactive. Please try later.
		</font></center></h2>";
	}

	// Interpret the Query: users - 2 queries, solvers - 5 queries
	if($whoWho === "Users") {

		if($metric === "Issues_Registered") {
			$query = "SELECT user_id AS id, COUNT( user_id ) AS count FROM issues GROUP BY user_id ORDER BY count ".$ascOrDesc;
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) < $num) $num = mysqli_num_rows($result);
			echo("<table class='table table-hover'>");
			echo("
			<tr>
				<th>UserID</th>
				<th>Issues Registered</th>
			</tr>
			");
			$datay=[];
			$str = "?";
			for($i=0; $i < $num; $i++) {
				$r = mysqli_fetch_array($result, MYSQL_NUM);
				echo("
				<tr>
					<td>$r[0]</td>
					<td>$r[1]</td>
				</tr>
				");
				$str= $str . $r[0]."=".$r[1]."&";
			}
			$loc = "gnu_test.php".$str;
			header("Location: ".$loc);
			echo("</table>");
			// run the query, get the rows, print them as rows of table
		} 

		else if ($metric === "Issues_Pending") {
			$query = "SELECT user_id AS id, COUNT( user_id ) AS count FROM issues WHERE issue_status=0 GROUP BY user_id ORDER BY count ".$ascOrDesc;
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) < $num) $num = mysqli_num_rows($result);
			echo("<table class='table table-hover'>");
			echo("
			<tr>
				<th>UserID</th>
				<th>Issues Registered</th>
			</tr>
			");
			$datay=[];
			$str = "?";
			for($i=0; $i < $num; $i++) {
				$r = mysqli_fetch_array($result, MYSQL_NUM);
				echo("
				<tr>
					<td>$r[0]</td>
					<td>$r[1]</td>
				</tr>
				");
				$str= $str . $r[0]."=".$r[1]."&";
			}
			$loc = "gnu_test.php".$str;
			header("Location: ".$loc);
			echo("</table>");
			// run the query, get the rows, print them as rows of table
		} 

		else { echo("Invalid Query for Users! Please try again.");
		}

	} else if($whoWho === "Solvers") {

		if($metric === "Issues_Assigned") {
			$query = "SELECT delegatedTo AS id, COUNT( delegatedTo ) AS count FROM issue_transactions WHERE delegatedTo <> 'Solved' GROUP BY delegatedTo ORDER BY count ".$ascOrDesc;
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) < $num) $num = mysqli_num_rows($result);
			echo("<table class='table table-hover'>");
			echo("
			<tr>
				<th>SolverID</th>
				<th>Issues Assigned</th>
			</tr>
			");
			$datay=[];
			$str = "?";
			for($i=0; $i < $num; $i++) {
				$r = mysqli_fetch_array($result, MYSQL_NUM);
				echo("
				<tr>
					<td>$r[0]</td>
					<td>$r[1]</td>
				</tr>
				");
				$str= $str . $r[0]."=".$r[1]."&";
			}
			$loc = "gnu_test.php".$str;
			header("Location: ".$loc);
			echo("</table>");
			// run the query, get the rows, print them as rows of table

		} else if ($metric === "Issues_Solved") {
			$query = "SELECT user_id AS id, COUNT( user_id ) AS count FROM issue_transactions WHERE delegatedTo='Solved' GROUP BY user_id ORDER BY count ".$ascOrDesc;
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) < $num) $num = mysqli_num_rows($result);
			echo("<table class='table table-hover'>");
			echo("
			<tr>
				<th>SolverID</th>
				<th>Issues Solved</th>
			</tr>
			");
			$datay=[];
			$str = "?";
			for($i=0; $i < $num; $i++) {
				$r = mysqli_fetch_array($result, MYSQL_NUM);
				echo("
				<tr>
					<td>$r[0]</td>
					<td>$r[1]</td>
				</tr>
				");
				$str= $str . $r[0]."=".$r[1]."&";
			}
			$loc = "gnu_test.php".$str;
			header("Location: ".$loc);
			echo("</table>");
			// run the query, get the rows, print them as rows of table

		} else if ($metric === "Issues_Pending") {
			$query = "SELECT currDelegTo_uid AS id, COUNT( currDelegTo_uid ) AS count FROM issues WHERE issue_status=0 GROUP BY currDelegTo_uid ORDER BY count ".$ascOrDesc;
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) < $num) $num = mysqli_num_rows($result);
			echo("<table class='table table-hover'>");
			echo("
			<tr>
				<th>SolverID</th>
				<th>Issues PENDING</th>
			</tr>
			");
			$datay=[];
			$str = "?";
			for($i=0; $i < $num; $i++) {
				$r = mysqli_fetch_array($result, MYSQL_NUM);
				echo("
				<tr>
					<td>$r[0]</td>
					<td>$r[1]</td>
				</tr>
				");
				$str= $str . $r[0]."=".$r[1]."&";
			}
			$loc = "gnu_test.php".$str;
			header("Location: ".$loc);
			echo("</table>");
			// run the query, get the rows, print them as rows of table

		//} else if ($metric === "Issues_Pending") {

		//} else if ($metric === "Issues_Pending") {

		} else { echo("Invalid Query for Solvers! Please try again.");
		}

	} else { echo("Bad Who User/Solver! Invalid Query! Please try again.");
	}


?>
	</div>
	</div>

	</div> <!-- end div row2. -->
	</div> <!--- ending div col-md-12 -->
	</div> <!-- ending div container -->
	

	<!-- ****************************** END Plot Action ******************** -->
<?php
	
	} else {
		echo("Invalid Action Selected");
	}


	mysqli_close($conn);

	
?>
	
	




</body>
</html>
