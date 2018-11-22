<?php
session_start();
extract($_GET);

//$usn=$_SESSION['usn'];
$db_server = mysqli_connect('localhost', 'root', 'root','WT2');

// Check connection
if (!$db_server) {
	die("Connection failed: " . mysqli_connect_error());
}


mysqli_select_db($db_server, 'WT2')

or die("Unable to select database: " . mysqli_error());
$branchsearch="%".$branch."%";
//echo "la".$search;
$query = "select e.elective_name, e.elective_code, e.branch, count(s.usn) as count from electives e,subjects s where e.branch like '$branchsearch' and (s.subject4=e.elective_code or s.subject5=e.elective_code) group by e.elective_code;";
$result = mysqli_query($db_server,$query);
if (!$result) die ("Database access failed: " . mysqli_error($db_server));
$electivedeets="";
$rows = mysqli_num_rows($result);
if($rows>20){
  $rows=20;
}
for ($k = 0 ; $k < $rows ; ++$k)

{
  $row = mysqli_fetch_assoc($result);
  //echo $row[0];
  //echo ;
  //$imagearray[]=$row[0];
  $GLOBALS['electivedeets']=$GLOBALS['electivedeets'].$row['elective_name'].",".$row['elective_code'].",".$row['branch'].",".$row['count']."newentry";

}
echo $GLOBALS['electivedeets'];

?>
