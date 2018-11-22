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
$search="%".$usn."%";
//echo "la".$search;
$query = "select usn,branch from student where usn like '$search';";
$result = mysqli_query($db_server,$query);
if (!$result) die ("Database access failed: " . mysqli_error($db_server));
$userdeets="";
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
  $GLOBALS['userdeets']=$GLOBALS['userdeets'].$row['usn'].",".$row['branch']."newentry";

}
echo $GLOBALS['userdeets'];

?>
