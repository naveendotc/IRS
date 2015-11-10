<?php include("header.php"); ?>	
	<script>
 function validateForm() {
      var a = document.forms["register"]["fname"].value;
      //var b = document.forms["register"]["eid"].value;
      var c = document.forms["register"]["pwd1"].value;
      var d = document.forms["register"]["pwd2"].value;
      var filter = /^[A-Za-z\s]+$/;
      
      if(filter.test(a)
      {
      	document.getElementById("eid").innerHTML = "* Name should contain only alphabetic characters";
      	return false;
      }
      /*if (a == null || a == "") {
          document.getElementById("fname").innerHTML = "* Name field should not be empty";
          return false;
      }
      if (!filter.test(b)) {
    	alert('Please provide a valid email address');
    	b.focus;
    	return false;
 		}*/
      if (c == null || c == "") {
          document.getElementById("pwd1").innerHTML = "* Password field should not be empty";
          return false;
      }
      else
      {
      	document.getElementById("pwd1").innerHTML = "";
      }
      if(c != d)
      {
      	document.getElementById("pwd2").innerHTML = "* Password Mismatch !!";
        return false;
      }
      else
      {
      	document.getElementById("pwd2").innerHTML = "";
      }
  }

  </script>
	<body background="../images/1.png">
		
		<form class="form-horizontal" role="form" method="post" action="filterRegister.php" onsubmit="return validateForm()" name="register">
			<div class="col-md-4"></div>
			<div class="container-fluid">
				<div class="col-md-4">
					<div class="well">
						<center><h2>Register</h2></center><br>
						<div class="input-group input-group-lg">
						 	<span class="input-group-addon">
						    	<span class="glyphicon glyphicon-user"></span>
						  	</span>
						  	<input class="form-control" type="text" placeholder="Full Name" name="fname" required>
						</div>
						<p id="fname" style="color:red"></p>
						<br>
						<div class="input-group input-group-lg">
						 	<span class="input-group-addon">
						    	<span class="glyphicon glyphicon-envelope"></span>
						  	</span>
						  	<input type="email" name='eid' class="form-control" id="eid" placeholder="Email" data-error="Bruh, that email address is invalid" required>
						</div>
						<p id="eid" style="color:red"></p>
						<br>
						<div class="input-group input-group-lg">
						 	<span class="input-group-addon">
						    	<span class="glyphicon glyphicon-phone"></span>
						  	</span>
						  	<input type="tel" name='contact' class="form-control" id="contact" placeholder="Contact No" min="1000000000" max="9999999999" required>
						</div>
						<p id="eid" style="color:red"></p>
						<br>
						<div class="input-group input-group-lg">
							<span class="input-group-addon">
						    	<span class="glyphicon glyphicon-lock"></span>
						  	</span>
						  	<input class="form-control" type="password" placeholder="Password" name="pwd1" required>
						</div>
						<p id="pwd1" style="color:red"></p>
						<br>
						<div class="input-group input-group-lg">
							<span class="input-group-addon">
						    	<span class="glyphicon glyphicon-lock"></span>
						  	</span>
						  	<input class="form-control" type="password" placeholder="Confirm Password" name="pwd2" required>
						</div>
						<p id="pwd2" style="color:red"></p>
						<br>
						<center><input type="submit" name="submit" value="Register" class="btn btn-primary"/>
					</div>
				</div>
			</div>
		</form> 
	</body>

</html>
