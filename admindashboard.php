<?php
session_start();

?>
<!DOCTYPE html>
<html ng-app="formsApp">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <script type="text/javascript" src="http://localhost/angular/angular.js"></script>

  <script type="text/javascript" src="admindashboard.js"></script>
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body ng-controller="FormCtrl as ctrl" style="overflow-x:hidden;overflow-y:hidden;background-image:url('img/lol2.jpg');background-size:cover;background-repeat:no-repeat;">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

      <div class="navbar-menu-wrapper d-flex align-items-center" style="width:100%">

        <ul class="navbar-nav navbar-nav-right">

          <li class="nav-item dropdown d-none d-xl-inline-block">
            <span class="profile-text">Hello, <?php echo $_SESSION['admin']?> !</span>

              <br>
              <a>
                <a href="logout.php"><button>Sign Out</button></a>
              </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" style="background-color:rgba(120,120,0,0.5); min-width:255px" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="user-wrapper">

                <div class="text-wrapper">
                  <p class="profile-name" style="color:black"><?php echo $_SESSION['admin']?> <span class="status-indicator online"></span></p>

                </div>
              </div>
            </div>
          </li>
          <li class="nav-item" id="studenttab">
            <a class="nav-link" href="#student"  onclick="showstudent()">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title" id="studentspan">Students</span>
            </a>
          </li>
          <li class="nav-item" id="electivestab">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title" id="electivesspan">Query</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"  id="electivestab1">
                  <a class="nav-link" href="#electives1" id="electivesspan1" onclick="showelectives1()">Student-Elective Count</a>
                </li>
                <li class="nav-item" id="electivestab2">
                  <a class="nav-link" href="#electives2" id="electivesspan2" onclick="showelectives2()">Search Existing Electives</a>
                </li>
                <li class="nav-item" id="electivestab3">
                  <a class="nav-link" href="#electives3" id="electivesspan3" onclick="showelectives3()">Pass/Fail Rate</a>
                </li>
              </ul>
            </div>
          </li>
          <!--<li class="nav-item" id="cperftab">
            <a class="nav-link" href="#cperformance"  onclick="showcperf()">
              <i class="menu-icon mdi mdi-backup-restore"></i>
              <span class="menu-title" id="cperfspan">College Performance</span>
            </a>
          </li>-->
        </ul>
      </nav>
      <!-- partial -->
      <div id="student" style="width:100%;">
        <br>
        <div style="float:right;margin:2em;">
          <span style="color:black;font-size:0.5em;">Search for "<span ng-bind='ctrl.obj.studusn' id="ng"></span>..."</span><br>
          <script type="text/javascript">
          angular.module("formsApp",[])
          .controller("FormCtrl",[function()
                      {
                        self = this;
                        self.studusn = "";
                        self.sendToServer = function()
                        {
                          console.log("Sent: " + self.obj.studusn + " to server");
                        }

                      }]);

          </script>
          <input type="search" id="usn" style="border:1px solid black;font-size:1em;" placeholder="search" required name="usn" ng-model="ctrl.obj.studusn" onkeyup="ob.getstudents()" autocomplete="off"></input>
          <button onclick='ob.clearsearch()'>Clear</button>
          <div id="container" style="width:100%;margin-right:3em;max-height:8em;"></div>
        </div>
        <br><br><br><br>
        <div id="studenttable" style="margin:2em;margin-top:9em;width:100%;">
        </div>


    </div>
    <div id="electives1" style="margin:3em;width:700%;">
      <p> Get Student-Elective Count: </p>
      <label >Branch:<input type="text" name="branch" style="border:1px solid black" id="branchcount" placeholder="Enter branch" name="branch"></input></label>
      <button onclick='ob.fetchcount()'>Fetch</button>
      <button onclick='ob.clearcount()'>Clear</button>
      <div id="countcontainer">

      </div>

      <!--<div id="chartContainer" style="margin:0px auto;margin-top:5%;height: 300px; width: 50%;"> </div>-->
    </div>
    <div id="electives2" style="margin:3em;width:700%;">
      <p> Search for electives: </p>
      <label >Branch:<input type="text" name="branch" style="border:1px solid black" id="branchsearch" placeholder="Enter branch" name="branch"></input></label>
      <label>Code:<input type="text" name="code" style="border:1px solid black" id="code" placeholder="Enter full/partial code"></input></label>
      <label>Name:<input type="text" name="name" style="border:1px solid black" id="searchname" placeholder="Enter elective name"></input></label>
      <button onclick='ob.fetchelectives()'>Search</button>
      <button onclick='ob.clearelectives()'>Clear Search</button>
      <div id="electivescontainer">

      </div>
      <!--<div id="chartContainer" style="margin:0px auto;margin-top:5%;height: 300px; width: 50%;"> </div>-->
    </div>
    <div id="electives3" style="margin:3em;width:700%;">
      <p> Pass/Fail Rate: </p>
      <label >Branch:<input type="text" name="pfbranch" style="border:1px solid black" id="branchpf" placeholder="Enter branch"></input></label>
      <button onclick='ob.fetchpf()'>Fetch</button>
      <button onclick='ob.clearpf()'>Clear</button>
      <!--<label >Branch:<input type="text" name="branch" style="border:1px solid black" id="branchsearch" placeholder="Enter branch" name="branch"></input></label>
      <label>Code:<input type="text" name="code" style="border:1px solid black" id="code" placeholder="Enter full/partial code"></input></label>
      <label>Name:<input type="text" name="name" style="border:1px solid black" id="searchname" placeholder="Enter elective name"></input></label>
      <button onclick='ob.fetchelectives()'>Search</button>
      <button onclick='ob.clearelectives()'>Clear Search</button>-->
      <div id="pfcontainer">

      </div>
      <!--<div id="chartContainer" style="margin:0px auto;margin-top:5%;height: 300px; width: 50%;"> </div>-->
    </div>

    <div id="cperformance" style="width:100%">

      <div id="chartContainer1" style="margin:0px auto;margin-top:5%;height: 300px; width: 50%;"> </div>
      <!--<div id="chartContainer2" style="margin:0px auto;margin-top:5%;height: 300px; width: 50%;"> </div>-->
    </div>
    </div>
    </div>
  <!-- container-scroller -->
</body>
  <!-- plugins:js -->

  <script>
/*
  var chart = new CanvasJS.Chart("chartContainer1", {
	animationEnabled: true,

	title:{
		text:"Fortune 500 Companies by Country"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
		title: "Number of Companies"
	},
	data: [{
		type: "bar",
		name: "companies",
		axisYType: "secondary",
		color: "#014D65",
		dataPoints: [
			{ y: 3, label: "Sweden" },
			{ y: 7, label: "Taiwan" },
			{ y: 5, label: "Russia" },
			{ y: 9, label: "Spain" },
			{ y: 7, label: "Brazil" },
			{ y: 7, label: "India" },
			{ y: 9, label: "Italy" },
			{ y: 8, label: "Australia" },
			{ y: 11, label: "Canada" },
			{ y: 15, label: "South Korea" },
			{ y: 12, label: "Netherlands" },
			{ y: 15, label: "Switzerland" },
			{ y: 25, label: "Britain" },
			{ y: 28, label: "Germany" },
			{ y: 29, label: "France" },
			{ y: 52, label: "Japan" },
			{ y: 103, label: "China" },
			{ y: 134, label: "US" }
		]
	}]
});
chart.render();
*/



  </script>

  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->

  <script>
    var student=document.getElementById("student");
    var electives1=document.getElementById("electives1");
    var electives2=document.getElementById("electives2");
    var electives3=document.getElementById("electives3");
    //var cperf=document.getElementById("cperformance");
    var studenttab=document.getElementById("studenttab");
    var electivestab=document.getElementById("electivestab");
    var electivestab1=document.getElementById("electivestab1");
    var electivestab2=document.getElementById("electivestab2");
    var electivestab3=document.getElementById("electivestab3");
    //var cperftab=document.getElementById("cperftab");
    var studentspan=document.getElementById("studentspan");
    var electivesspan1=document.getElementById("electivesspan1");
    var electivesspan2=document.getElementById("electivesspan2");
    var electivesspan3=document.getElementById("electivesspan3");
    var electivesspan=document.getElementById("electivesspan");
    //var cperfspan=document.getElementById("cperfspan");
    showstudent();
    hideelectives1();
    hideelectives2();
    hideelectives3();
    //hidecperf();
    function hidestudent(){
      student.style.display="none";
      studenttab.style.background="#e6f2ff";
      studentspan.style.color="black";
    }
    function hideelectives1(){
      electives1.style.display="none";
      electivestab1.style.background="#e6f2ff";
      electivesspan1.style.color="black";
    }
    function hideelectives2(){
      electives2.style.display="none";
      electivestab2.style.background="#e6f2ff";
      electivesspan2.style.color="black";
    }
    function hideelectives3(){
      electives3.style.display="none";
      electivestab3.style.background="#e6f2ff";
      electivesspan3.style.color="black";
    }
    /*
    function hidecperf(){
      cperf.style.display="none";
      cperftab.style.background="#e6f2ff";
      cperfspan.style.color="black";
    }*/
    function showstudent(){
      //hidecperf();
      hideelectives1();
      hideelectives2();
      hideelectives3();
      student.style.display="block";
      studenttab.style.background="lightgray";
      studentspan.style.color="blue";
    }
    function showelectives1(){
      //alert("yah");
      hidestudent();
      //hidecperf();
      hideelectives2();
      hideelectives3();
      electives1.style.display="block";
      electivestab1.style.background="lightgray";
      electivesspan1.style.color="blue";
    }
    function showelectives2(){
      hidestudent();
      //hidecperf();
      hideelectives1();
      hideelectives3();
      electives2.style.display="block";
      electivestab2.style.background="lightgray";
      electivesspan2.style.color="blue";
    }
    function showelectives3(){
      hidestudent();
      //hidecperf();
      hideelectives1();
      hideelectives2();
      electives3.style.display="block";
      electivestab3.style.background="lightgray";
      electivesspan3.style.color="blue";
    }
/*
    function showcperf(){
      hidestudent();
      hideelectives1();
      hideelectives2();
      cperf.style.display="block";
      cperftab.style.background="lightgray";
      cperfspan.style.color="blue";
    }*/
  </script>


</html>
