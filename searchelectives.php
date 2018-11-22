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
$codesearch="%".$code."%";
$namesearch="%".$name."%";
//echo "la".$search;
$query = "select * from electives where branch like '$branchsearch' and elective_code like '$codesearch' and elective_name like '$namesearch';";
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
  $GLOBALS['electivedeets']=$GLOBALS['electivedeets'].$row['elective_name'].",".$row['elective_code'].",".$row['branch'].",".$row['sem']."newentry";

}
echo $GLOBALS['electivedeets'];

?>
