<?php

extract($_GET);
if (isset($who) && $who=="admin"){
  include('adminloginvalidation.php');
  	//header('location: admindashboard.php');
}
else if (isset($who) && $who=="student"){
  include('loginvalidation.php');
}
else{
  include('loginvalidation.php');
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Elective Recommendation Portal</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="bstyle.css">

        <link rel="stylesheet" href="se.css"/>
        <link rel="stylesheet" href="style.css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="form-1/assets/ico/favicon.png">

        <style>

        body{
          background: url("img/lol2.jpg");
        }
        .layouts{
            background: rgba(0, 0, 0, 0.35);
            width:100%;

        }
        button{
          color:black;
        }
        h3{

          color:white;
        }
        </style>
    </head>

    <body>

    	<div class="top layouts">
        <div class="row" style="width:20%;float:right;">
            <div class="col-sm-4">
                <button style="width:5em;" onclick="showadmin()">Admin</button>
              </div>
              <div class="col-sm-8" style="float:right;">
                  <button style="width:5em;" onclick="showstudent()">Student</button>
              </div>
            </div>
    	</div>
      <div align="center" id="admin">
        <form method="POST" action="index.php?who=admin" style="width:30%;height:60%;">
          <?php include('errorsadmin.php'); ?>
          <br>
          <br>
          <label><span class="col-sm-5">ADMIN ID: </span><input class="col-sm-6" type="text" id="adminid" name="adminid" placeholder="Enter ID" required></input></label><br><br>
          <label><span class="col-sm-5">PASSWORD: </span><input class="col-sm-6" type="password" id="pwdadmin" minlength="8" name="pwdadmin" placeholder="Enter Password" required></input></label><br><br>
          <span style="color:black;"><input type="submit" style="width:30%;" value="LOG IN"></input></span>
        </form>
      </div>

      <div align="center" id="student">
        <form method="POST" action="index.php?who=student" style="width:30%;height:60%;">
          <?php include('errors.php'); ?>
          <br>
          <br>
          <label><span class="col-sm-5">USN: </span><input class="col-sm-6" type="text" id="usn" name="usn" placeholder="Enter USN" required></input></label><br><br>
          <label><span class="col-sm-5">PASSWORD: </span><input class="col-sm-6" type="password" id="pwd" minlength="8" name="pwd" placeholder="Enter Password" required></input></label><br><br>
          <span style="color:black;"><input type="submit" style="width:30%;" value="LOG IN"></input></span>
        </form>
      </div>

        <!--<div class="container footer">
            <div class="row">
                <div class="col-sm-12">
                	&copy; Bootstrap Login Form Templates by <a href="http://azmind.com" target="_blank">Azmind</a>.
                </div>
            </div>
        </div>-->

    </body>
    <script>
    var admintab=document.getElementById("admin");

    var studenttab=document.getElementById("student");
    admintab.style.display="none";
    studenttab.style.display="none";

    if('<?php if(isset($who)){echo $who;}else {echo "";}?>'=="admin"){
      admintab.style.display="block";
      hidestudent();
    }
    else if('<?php if(isset($who)){echo $who;}else {echo "";}?>'=="student"){
      studenttab.style.display="block";
      hideadmin();
    }

    //admintab.addEventListener("load",hideadmin,false);
    //studenttab.addEventListener("load",hidestud,false);
    function hideadmin() {
      admintab.style.display="none";
    }
    function hidestudent() {
      studenttab.style.display="none";
    }
    function showadmin(){
      admintab.style.display="block";
      hidestudent();
    }

    function showstudent(){
      hideadmin();
      studenttab.style.display="block";
    }

    </script>
</html>
