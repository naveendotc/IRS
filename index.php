<?php include("source/header.php"); ?>	

	<body background="images/1.png">
		<form action="source/filterUser.php" method="post" name="login">
			<div class="col-md-4"></div>
				
			<div class="container-fluid">
				<div class="col-md-4" style="padding-top: 2cm">
					<div class="well">
						<center><h2>Login</h2></center><br>
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
						<center><input type="submit" name="submit" value="Login" class="btn btn-primary"/><br><br><a href="source/register.php" class="btn btn-primary">Register</a></center>

					</div>	
				</div>
			</div>
			<div class="col-md-4"></div>
		</form>   
	</body>

</html>
