<?php
session_start();
$usn="";
if(isset($_SESSION['usn'])){
  $usn=$_SESSION['usn'];
}
else{
    header('location: index.php');
}


$db_server = mysqli_connect('localhost', 'root', 'root','WT2');

// Check connection
if (!$db_server) {
  die("Connection failed: " . mysqli_connect_error());
}


mysqli_select_db($db_server, 'WT2')

or die("Unable to select database: " . mysqli_error());
$name="";
$query = "SELECT name FROM student WHERE usn='$usn'";
$result = mysqli_query($db_server,$query);

if (!$result) die ("Database access failed: " . mysqli_error($db_server));

$rows = mysqli_num_rows($result);

for ($j = 0 ; $j < $rows ; ++$j)

{

$row = mysqli_fetch_row($result);
$name=$row[0];
}

$sem="";
$query = "SELECT max(sem) FROM grades WHERE usn='$usn'";
$result = mysqli_query($db_server,$query);

if (!$result) die ("Database access failed: " . mysqli_error($db_server));

$rows = mysqli_num_rows($result);

for ($j = 0 ; $j < $rows ; ++$j)

{

$row = mysqli_fetch_row($result);
$sem=$row[0];
}


$branch="";

$query = "SELECT branch FROM student WHERE usn='$usn'";
$result = mysqli_query($db_server,$query);

if (!$result) die ("Database access failed: " . mysqli_error($db_server));

$rows = mysqli_num_rows($result);

for ($j = 0 ; $j < $rows ; ++$j)

{

$row = mysqli_fetch_row($result);
$branch=$row[0];
}
$branchid="";
if($branch=="CSE")
{
  $branchid="1";
}
if($branch=="ECE")
{
  $branchid="2";
}
if($branch=="EME")
{
  $branchid="3";
}
if($branch=="EEE")
{
  $branchid="4";
}
if($branch=="BT")
{
  $branchid="5";
}
$spec1=$branchid."1";
$spec2=$branchid."2";
$spec3=$branchid."3";
$query1="SELECT specialization FROM specialization WHERE specialization_id='$spec1'";
$query2="SELECT specialization FROM specialization WHERE specialization_id='$spec2'";
$query3="SELECT specialization FROM specialization WHERE specialization_id='$spec3'";
$result = mysqli_query($db_server,$query1);

if (!$result) die ("Database access failed: " . mysqli_error($db_server));

$rows = mysqli_num_rows($result);

for ($j = 0 ; $j < $rows ; ++$j)

{

$row = mysqli_fetch_row($result);
$spec1=$row[0];
}
$result = mysqli_query($db_server,$query2);

if (!$result) die ("Database access failed: " . mysqli_error($db_server));

$rows = mysqli_num_rows($result);

for ($j = 0 ; $j < $rows ; ++$j)

{

$row = mysqli_fetch_row($result);
$spec2=$row[0];
}
$result = mysqli_query($db_server,$query3);

if (!$result) die ("Database access failed: " . mysqli_error($db_server));

$rows = mysqli_num_rows($result);

for ($j = 0 ; $j < $rows ; ++$j)

{

$row = mysqli_fetch_row($result);
$spec3=$row[0];
}
?>

    <!DOCTYPE html>
    <html>
    <head>
      <link rel="stylesheet" href="se.css"/>
    	<link rel="stylesheet" href="style.css"/>

    	<link rel="stylesheet" href="dashboard.css"/>
      <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
      <!--__<script data-main="http://localhost/main.js" src="http://localhost/require.js"></script>-->

      <script type="text/javascript" src="dashboard.js"></script>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Student Dashboard</title>
      <!-- plugins:css -->
      <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
      <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
      <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">

      <!-- endinject -->
      <!-- plugin css for this page -->
      <!-- End plugin css for this page -->
      <!-- inject:css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- endinject -->
      <link rel="shortcut icon" href="images/favicon.png" />


    </head>
    <body onload="obj.load()" style="overflow-x:hidden;overflow-y:hidden;background-image:url('img/lol2.jpg');background-size:cover;background-repeat:no-repeat;">

        <div class="container-scroller">
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

        <div class="navbar-menu-wrapper d-flex align-items-center">
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown d-none d-xl-inline-block">
              <span class="col-sm-10 profile-text" ><h5 id="usn" style="display:inline-block;"><?php echo $usn;?><h5 id="branch" hidden style="display:inline-block;"><?php echo $branch;?></h5></span>


              <br>
              <a href="logout.php" style="width:50%;margin:0px auto;"><button style="width:100%;margin:0px auto;">Sign Out</button></a>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" style="background-color:rgba(120,120,0,0.5); min-width:255px" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <div class="nav-link">
                <div class="user-wrapper">
                  <!--<div class="profile-image">
                    <img src="images/faces/face1.jpg" alt="profile image">
                  </div>-->
                  <div class="text-wrapper">
                    <p class="profile-name"><?php echo $name;?></p>
                    <div>
                      <small class="designation text-muted" style="color:black !important;"><?php echo $branch?> (Sem: <span id="sem"><?php echo $sem+1?></span>)</small>
                      <span class="status-indicator online"></span>
                    </div>
                  </div>
                </div>
                <!--<button class="btn btn-success btn-block">New Project
                  <i class="mdi mdi-plus"></i>
                </button>-->
              </div>
            </li>
            <li class="nav-item nav-tab" id="rectab">
              <a class="nav-link" href="#recommendation" onclick="showrecommended()">
                <i class="menu-icon mdi mdi-television"></i>
                <span class="menu-title" id="recspan">Recommendation</span>
              </a>
            </li>
            <!--<li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-content-copy"></i>
                <span class="menu-title">Edit Electives</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="">Add New Electives</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="">Update Existing Electives</a>
                  </li>
                </ul>
              </div>
            </li>-->
            <li class="nav-item nav-tab" id="perftab">
              <a class="nav-link" href="#performance" onclick="showperformance()">
                <i class="menu-icon mdi mdi-backup-restore"></i>
                <span class="menu-title" id="perfspan">Performance</span>
              </a>
            </li>
          </ul>
        </nav>
        <div id="recommendation" style="width:100%;">
        <br><br><br>


        <div style="width:100%;font-size:15px;margin-top:2em;">


      			<div class="dropdown" style="float:right;margin-right:2em;width:7em;"> <!--style="width:100%;left-margin:40%;">-->
      				<div>
      					<center><span><a href="#"><button class="button,dropbtn" style="margin-top:-160px;width:5em;padding-left:0;padding-right:0;" data-button="Pool1">Group 2</button></a></span></center>
      					<div class="dropdown-content" style="width:10em">
      						<a href="#" class="pool1"><label><input type="checkbox" id="spec21" name="pool2" style="color:white;"/><?php echo $spec1;?></label></a>
      						<a href="#" class="pool1"><label><input type="checkbox" id="spec22" name="pool2" style="color:white;"/><?php echo $spec2;?></label></a>
      						<a href="#" class="pool1"><label><input type="checkbox" id="spec23" name="pool2" style="color:white;"/><?php echo $spec3;?></label></a>
      						<center><span><a href="#"><button  id="Apply2" name="Apply2" value="Apply" onclick="obj.filterpool2()" class="button" style="text-align:center;margin-top:0px;height:2em" data-button="Apply">APPLY</button></a></span></center>
      					</div>

      				</div>
      			</div>

      			<div class="dropdown" style="float:right;width:7em"> <!--style="width:100%;left-margin:40%;">-->
      				<div style="left-margin:50%;">
      					<center><span><a href="#"><button class="button,dropbtn" style="margin-top:-160px;width:5em;padding-left:0;padding-right:0;" data-button="Pool1">Group 1</button></a></span></center>
      					<div class="dropdown-content" style="width:10em">
      						<a href="#" class="pool1"><label><input type="checkbox" id="spec11" name="pool1" style="color:white;"/><?php echo $spec1;?></label></a>
      						<a href="#" class="pool1"><label><input type="checkbox" id="spec12" name="pool1" style="color:white;"/><?php echo $spec2;?></label></a>
      						<a href="#" class="pool1"><label><input type="checkbox" id="spec13" name="pool1" style="color:white;"/><?php echo $spec3;?></label></a>
      						<center><span><a href="#"><button  id="Apply1" name="Apply1" value="Apply" onclick="obj.filterpool1()" class="button" style="text-align:center;margin-top:0px;height:2em" data-button="Apply">APPLY</button></a></span></center>
      					</div>

      				</div>
      			</div>


        </div>
        <br><br>
            <div style="width:100%;display:inline-block;">
              <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <div style="display:inline-block;width:49%;margin-top:0px;">
                    <h5 style="text-align:center;">Group 1</h5>
                    <div id="divpool1"></div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div style="display:inline-block;width:49%;">
                    <h5 style="text-align:center;">Group 2</h5>
                    <div id="divpool2"></div>
                    </div>
                  </div>
                </div>
              </div>


          </div>
          <hr>
          <hr>
          <div id="clusterid" style="margin:2em;">


          </div>
      </div>
      <div id="performance" style=";width:100%">

        <div id="chartContainer" style="margin:0px auto;margin-top:5%;height: 300px; width: 50%;"> </div>
        </div>
      </div>
      </div>

</body>
<script>
  var recommended=document.getElementById("recommendation");
  var perf=document.getElementById("performance");
  var rectab=document.getElementById("rectab");
  var perftab=document.getElementById("perftab");

  var recspan=document.getElementById("recspan");
  var perfspan=document.getElementById("perfspan");
  showrecommended();
  hideperformance();
  function hiderecommended(){
    recommended.style.display="none";
    rectab.style.background="#e6f2ff";
    recspan.style.color="black";
  }
  function hideperformance(){
    perf.style.display="none";
    perftab.style.background="#e6f2ff";
    perfspan.style.color="black";
  }
  function showrecommended(){
    recommended.style.display="block";
    rectab.style.background="lightgray";
    recspan.style.color="blue";
    hideperformance();
  }
  function showperformance(){
    perf.style.display="block";
    perftab.style.background="lightgray";
    perfspan.style.color="blue";
    hiderecommended();
  }
</script>
</html>
