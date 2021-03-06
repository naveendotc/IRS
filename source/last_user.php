<?php include("header.php"); include("constants.php"); ?>
  
  <script type="text/javascript">
    function validate()
    {

      if(document.getElementById("new_issue_type").value == "Select type of issue")
      {
        document.getElementById("p2").innerHTML = "* Select issue type";
        return false;
      }
    }
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      $('[data-toggle="popover"]').popover();
      $("#issue_btn").click(function(){
        $("#raise_issue").show(200);
      });
      $("#close").click(function(){
        $("#raise_issue").hide();
      });
      $("#update").click(function(){
        $("#row3").show(200);
      });
      $("#request_priv").click(function(){
        $("#row4").show(200);
      });
      $("#subject").focusin(function(){
        $(this).css("background-color", "#FFFFCC");
      });
      $("#subject").focusout(function(){
        $(this).css("background-color", "#FFFFFF");
        if ( $(this).val() == '' ) {
            $("#p1").html("* This field should not be blank");
        } 
        else
        {
          $("#p1").html("");
        }
      });
      $("select").focusout(function(){
        if ( $(this).val() == null ) {
            $("#p2").html("* This should not be blank");
        } 
        else
        {
          $("#p2").html("");
        }
      });
      $("#textarea").focusout(function(){
        $(this).css("background-color", "#FFFFFF");
        if ( $(this).val() == '' ) {
            $("#p3").html("* This field should not be blank");
        } 
        else
        {
          $("#p3").html("");
        }
      });
    });
  </script>
  <body>
    
    <h2 align="right" style="color: blue">Welcome <?php if(isset($_COOKIE["uid"]))
                                                            {
								// Do --> echo full_name here + CSS editing needed
                                                              echo($_COOKIE["uid"]);
                                                              echo("<br>");
                                                              echo("<a href='logout.php'>Logout</a>"); // Do --> Logout Button
                                                            }  
                                                                  
                                                        else 
                                                            {
                                                              header("Location: ../index.php");
                                                            } 
                                                  ?>
      </h2>
      <br>
      <div class="container">
        <div class="col-md-2">
          <ul class="nav nav-stacked">
            <li><button type="button" class="btn btn-primary" id="issue_btn"> <!-- Do : Better style/css needed here -->
              Raise Issue
            </button>
            </li>
            <?php 
              $uid = $_COOKIE['uid'];
              $query = "select privileges from users where user_id = '$uid'";
                      $con= mysqli_connect(DBSERVER,USER,PASSWORD,DATABASE);
                      if(!isset($con))
                      {
                          echo "<h2><center><font color='red'>* Database server is presently inactive please try later</font></center></h2>";
                      }
                      
                      $result = mysqli_query($con, $query);
                      while($row = mysqli_fetch_array($result, MYSQL_NUM))
                      {
                        $privilege = $row[0];
                        if($privilege == 0) // 0 => user only (1 => user+solver, 2 => user+solver+manager)
                        {
				echo("<li><button type='button' class='btn btn-primary' id='request_priv'>
                                Request for solver privileges
                                </button></li>");
                        }
                        else
                        { // ??? What is this and why needed?
                          echo("<li><button type='button' class='btn btn-primary' id='update'>
                                Update Solved Issue
                                </button></li>");
                          /*if($privilege == 1) // 1 => user+solver
                          {
                            //echo("<li role='presentation'><a href='#'>Update status of issues raised</a></li>");
                            echo("<li role='presentation'><a href='#'>View all issues raised</a></li>");
                          }*/
                          if($privilege == 2)// manager
                          {
                            echo("<li><button type='button' class='btn btn-primary' id='grant'>
                                Grant Permissions
                                </button></li>");
                          }
                        }
                      }
                      

            ?>
          </ul>
        </div> <!--- ending div col-md-2 -->

        <div class="col-md-10"><h2>Raise an issue by clicking here</h2> <!--- Should be a large button -->
          
          <div class="row">
            <div class="col-md-7">
            <!--<button type="button" class="btn btn-primary" id="issue_btn">
              Raise Issue
            </button>-->
            <?php 
                  if(isset($_POST["report"])) // Raise Issue Action
                    {
                      
                      
                      $subject = $_POST["subject"];
                      $type=$_POST["issue_type"];
                      $description = $_POST["description"];
                      $uid = $_COOKIE["uid"];
                      $status = 0;
                      //echo($subject.$type.$description);
                      $query = "insert into raised_issues (user_id,subject,type,description,status) values('$uid','$subject','$type','$description','$status')";
                      $con= mysqli_connect(DBSERVER,USER,PASSWORD,DATABASE);
                      if(!isset($con))
                      {
                          echo "<h2><center><font color='red'>* Database server is presently inactive. Please try later.</font></center></h2>";
                      }
                      if(mysqli_query($con, $query))
                      {
                        echo("<div class='alert alert-success' role='alert'>
                        <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Issue has been successfully raised. </div>");
                      }
                      else
                      {
                        echo("Unexpected Failure. Please try again.");
                      }
                      mysqli_close($con);
                    }
            ?>
            <div id="raise_issue" style="display:none">
              <br>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><center>Register New Issue</center></h3>
                </div>
                <div class="panel-body">
                  <form action="user.php" method="post" onsubmit="return validate()">
                    <input type="text" id="subject" class="form-control" placeholder="Subject" name="subject" style="width:490px" required>
                    <br>
                    <select class="selectpicker;btn btn-primary" name="issue_type" id = "new_issue_type">
                      <option selected disabled>Select Type of Issue</option>
                      <option value="Type-1">Type-1</option>
                      <option value="Type-2">Type-2</option>
                      <option value="Type-3">Type-3</option>
			<option value="DoNotKnow">Do Not Know</option>
                    </select><p id="p2" style="color:red"></p>
		<select class="selectpicker;btn btn-primary" name="issue_subtype" id = "new_issue_subtype"> <!-- From MySQL table -->
                      <option selected disabled>Select SubType of Issue</option>
                      <option value="SubType-1">SubType-1</option>
                      <option value="SubType-2">SubType-2</option>
                      <option value="SubType-3">SubType-3</option>
			<option value="DoNotKnow">Do Not Know</option>
                    </select><p id="p2" style="color:red"></p>
                    <br>
                    <br>
                    <textarea class="form-control" name="description" id="textarea" style="width:490px; height:150px;" placeholder="Description" required></textarea>
                    <br>
                    <div align="center">
                      <button type="button" class="btn btn-default" id="close">Close</button> <!-- Close button should clear -->
                      <input type="submit" class="btn btn-primary" name="report" value="Report" id="submit"/>
                    </div>
                  </form>
                </div>
              </div>
              
            </div>
          </div>
        </div>
        
    <br><br>
    
    <div class="row" id="row2">
        <?php
          $uid = $_COOKIE["uid"];
          $query = "select * from raised_issues where user_id = '$uid'";
          $con= mysqli_connect(DBSERVER,USER,PASSWORD,DATABASE);
          if(!isset($con))
            {
              echo "<h2><center><font color='red'>* Database server is presently inactive please try later</font></center></h2>";
            }
            $result = mysqli_query($con,$query);
            if(mysqli_num_rows($result) == 0)
            {
              echo("$uid.. NO issues raised by you !!");
            }
            else
            {
              echo("<form action='user.php' method='post'>");
              echo("<div class='panel panel-default'>
                      <div class='panel-heading'>
                        <h3 class='panel-title'><center><b>Issues Raised By You</b></center></h3>
                      </div>
                    <div class='panel-body'>");
              echo("<table class='table table-hover'>");
              echo("<tr><th>Issue Id</th><th>User Id</th><th>Subject</th><th>Type</th><th>Description</th><th>Current Status</th><th>Assigned to</th></tr>");
              while($row = mysqli_fetch_array($result, MYSQL_NUM))
              {
                $issue_type = $row[3]; 
                $query = "select full_name from users where user_id = (select solver_id from solvers where type_of_issue = '$issue_type')";
                $con = mysqli_connect(DBSERVER,USER,PASSWORD,DATABASE);
                $res = mysqli_query($con,$query);
                while($r = mysqli_fetch_array($res, MYSQL_NUM))
                {
                  echo("<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><button type='button' class='btn btn-primary' title='Description' data-toggle='popover' data-trigger='focus' data-content='$row[4]'>Click me</button></td><td>$row[5]</td><td>$r[0],</td></tr>");
                }
              }
              echo("</table>");
              echo("</div></div>");
            }
            mysqli_close($con);
        ?>
      </div>
      
      <div class="row" id="row3">
        <?php
          
            
              if(isset($_POST["update"]))
              {
                
                if(!isset($_POST['formDoor'])) 
                {
                  echo("You didn't select any issues.");
                } 
                else
                {
                  $aDoor = $_POST['formDoor'];
                  $N = count($aDoor);
               
                  echo("You selected $N issue(s): ");
                  for($i=0; $i < $N; $i++)
                  {
                    $id = $aDoor[$i];
                    $query = "update raised_issues set status = 1 where status = 0 and id ='$id'";
                    $con = mysqli_connect(DBSERVER,USER,PASSWORD,DATABASE);
                    if(mysqli_query($con,$query))
                    {
                      //header("Location: user.php");
                      echo("Issues status updated successfully");
                    }
                    else
                    {
                      echo("Issues updation failed");
                    }
                  }
                }
              }
              $uid = $_COOKIE["uid"];
              $query = "select * from raised_issues where type = (select type_of_issue from solvers where solver_id = '$uid') and status = 0";
              $con= mysqli_connect(DBSERVER,USER,PASSWORD,DATABASE);
            if(!isset($con))
              {
                echo "<h2><center><font color='red'>* Database server is presently inactive please try later</font></center></h2>";
              }
              $result = mysqli_query($con,$query);
              if(mysqli_num_rows($result) == 0)
              {
                echo("$uid.. NO issues to update !!");
              }
              else
              {
                echo("<form action='user.php' method='post'>");
                echo("<div class='panel panel-default'>
                        <div class='panel-heading'>
                          <h3 class='panel-title'><center><b>Update Issues</b></center></h3>
                        </div>
                      <div class='panel-body'>");
                echo("<table class='table table-hover'>");
                echo("<tr><th>Check it</th><th>Issue Id</th><th>User Id</th><th>Subject</th><th>Type</th><th>Description</th><th>Current Status</th></tr>");
                while($row = mysqli_fetch_array($result, MYSQL_NUM))
                {
                  $issue_type = $row[3]; 
                  //$query = "select full_name from users where user_id = (select solver_id from solvers where type_of_issue = '$issue_type')";
                  //$con = mysqli_connect(DBSERVER,USER,PASSWORD,DATABASE);
                  //$res = mysqli_query($con,$query);
                  echo("<tr><td><input type='checkbox' name='formDoor[]' value='$row[0]'/></td><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><button type='button' class='btn btn-primary' title='Description' data-toggle='popover' data-trigger='focus' data-content='$row[4]'>Click me</button></td><td>$row[5]</td></tr>");
                }
                echo("</table>");
                echo("</div><center><input type='submit' name='update' class='btn btn-primary' value='Update the checked issues'></center></div>");
                echo("</form>");
              }
            
            mysqli_close($con);
        ?>
      </div>
      <?php
                if(isset($_POST["request"]))
                {
                  $uid = $_COOKIE['uid'];
                  if(isset($_POST['issue_request']))
                  {
                    $forType=$_POST['issue_request'];
                    $query = "insert into solver_requests (user_id, for_type) values('$uid','$forType')";
                    $con = mysqli_connect(DBSERVER,USER,PASSWORD,DATABASE);
                    if(!isset($con))
                      {
                          echo "<h2><center><font color='red'>* Database server is presently inactive please try later</font></center></h2>";
                      }
                      if(mysqli_query($con, $query))
                      {
                        echo("<div class='alert alert-success' role='alert'>
                        <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Request has been successfully submitted </div>");
                      }
                      else
                      {
                        echo("failed");
                      }
                      mysqli_close($con);
                  }
                  else
                  {
                    echo("<div class='alert alert-danger' role='alert'>
                        <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Select the issue type </div>");
                  }
                }
      ?>
      <div class="row" id="row4" style="display:none">
          
          <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><center>Request for Solver Privileges</center></h3>
                </div>
                <div class="panel-body">
                  <form name="login" action="user.php" method="post">
                    <select class="selectpicker;btn btn-primary" name="issue_request" id = "select_issue">
                      <option selected disabled>Select type of issue</option>
                      <option value="Type-1">Type-1</option>
                      <option value="type-2">Type-2</option>
                      <option value="type-3">Type-3</option>
                    </select><p id="p5" style="color:red"></p>
                    <br>
                    <br>
                    <textarea class="form-control" name="description" id="textarea" style="width:490px; height:150px;" placeholder="Description .." required></textarea>
                    <br>
                    <div align="center">
                      <button type="button" class="btn btn-default" id="close">Close</button>
                      <input type="submit" class="btn btn-primary" name="request" value="Request" id="submit"/>
                    </div>
                  </form>
                </div>
              </div>
              
      </div> 
    </div>
  </div>
<?php include("footer.php"); ?>  
</body> 
</html>
