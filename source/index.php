<?php include("header.php"); ?>
<script type="text/javascript">
	function checkPasswordMatch() {
    var password = $("#pwd1").val();
    var confirmPassword = $("#pwd2").val();

    if (password != confirmPassword)
    {
        $("#match").html("<center><font color='red'>Passwords do not match !</font></center>");
        document.getElementById("reset").disabled = true;
    }
    else
    {
        $("#match").html("<center><font color='blue'>Passwords match </font></center>");
        document.getElementById("reset").disabled = false;
    }

}
</script>
	<body background="../images/1.png">
		<form action="filterUser.php" method="post" name="login">
			<div class="col-md-4"></div>
				
			<div class="container-fluid">
				<div class="col-md-4" style="padding-top: 2cm">
					<div class="well" style="font-family:Verdana;">
						<center><h2>Sign In</h2></center><br>
						<div class="input-group input-group-lg">
						 	<span class="input-group-addon">
						    	<span class="glyphicon glyphicon-user"></span>
						  	</span>
						  	<input class="form-control" type="text" placeholder="User ID" name="uid" required>
						</div>
						<p id="uid" style="color:red"></p>
						<br>
						<div class="input-group input-group-lg">
							<span class="input-group-addon">
						    	<span class="glyphicon glyphicon-lock"></span>
						  	</span>
						  	<input class="form-control" type="password" placeholder="Password" name="pwd" required>
						</div>
						<p id="pwd" style="color:red"></p>
						<br>
						<p  style="text-align:right"><a href="#" data-toggle="modal" data-target="#myModal">Forgot Password ?</a></button></p>
						<center><input type="submit" name="submit" value="Sign In" class="btn btn-block btn-primary" style="font-size:18px;font-weight:700;"/><br><a href="register.php" class="btn btn-block btn-success" style="font-size:18px;font-weight:700;">Register</a></center>

					</div>	
				</div>
			</div>
			<div class="col-md-4"></div>
		</form>   
		<form action ="forgot_password.php" method="post">
			<div class="modal fade" id="myModal" role="dialog">
			    <div class="modal-dialog">
			    
			      <!-- Modal content-->
			      <div class="modal-content">
			        <div class="modal-header" style = "background-color: #6699ff">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title"><center><b>Reset Password</b></center></h4>
			        </div>
			        <div class="modal-body">
			        	<div class="input-group input-group-lg">
						 	<span class="input-group-addon">
						    	<span class="glyphicon glyphicon-user"></span>
						  	</span>
						  	<input type="email" class="form-control" type="text" placeholder="Email" name="eid" required>
						</div>
						<br>
						<div class="input-group input-group-lg">
						 	<span class="input-group-addon">
						    	<span class="glyphicon glyphicon-user"></span>
						  	</span>
						  	<input class="form-control" type="password" placeholder="Password" name="pwd1" id="pwd1" required>
						</div>
						<br>
						<div class="input-group input-group-lg">
						 	<span class="input-group-addon">
						    	<span class="glyphicon glyphicon-user"></span>
						  	</span>
						  	<input class="form-control" type="password" placeholder="Confirm Password" name="pwd2" id="pwd2" onkeyup="checkPasswordMatch()" required>
						</div>
						<p id="match"></p>
						<br>
			          	<center><input type="submit" disabled class="btn btn-primary" name="submit" value="Reset My Password" id="reset"></center>
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        </div>
			      </div>
			      
			    </div>
			</div>
		</form>
	</body>

</html>
