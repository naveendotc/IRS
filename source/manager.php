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
	$uid = $_COOKIE["uid"];
	$con = mysqli_connect(DBSERVER, USER, PASSWORD, DATABASE);
	$result = mysqli_query($con,"SELECT full_name from users where user_id='$uid'");
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


?>