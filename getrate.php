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
//$query = "select e.elective_name, e.elective_code, e.branch, count(s.usn) as prate from electives e,subjects s where e.branch like '$branchsearch' and (s.subject4=e.elective_code or s.subject5=e.elective_code) group by e.elective_code;";
//$query= "select e.branch, e.elective_name, e.elective_code, count(s.usn) as prate, count(s1.usn) as frate from electives e, subjects s, subjects s1 where e.branch like '$branchsearch' and ((s.subject4=e.elective_code and s.grade4 IN ('A','B','C','D','E')) or (s.subject5=e.elective_code and s.grade5 IN ('A','B','C','D','E'))) and ((s1.subject4=e.elective_code and s1.grade4 NOT IN ('A','B','C','D','E')) or (s1.subject5=e.elective_code and s1.grade5 NOT IN ('A','B','C','D','E'))) group by e.elective_code";
//$query= "select e.branch, e.elective_name, e.elective_code, count(s.usn) as prate from electives e, subjects s where e.branch like '$branchsearch' and ((s.subject4=e.elective_code and s.grade4 IN ('A','B','C','D','E')) or (s.subject5=e.elective_code and s.grade5 IN ('A','B','C','D','E'))) group by e.elective_code";
$query= "select e.branch, e.elective_name, e.elective_code, count(s.usn) as frate from electives e, subjects s where e.branch like '$branchsearch' and ((s.subject4=e.elective_code and s.grade4 NOT IN ('A','B','C','D','E')) or (s.subject5=e.elective_code and s.grade5 NOT IN ('A','B','C','D','E'))) group by e.elective_code";
$result = mysqli_query($db_server,$query);
$ecode="";
if (!$result) die ("Database access failed: " . mysqli_error($db_server));
$electivedeets="";
$rows = mysqli_num_rows($result);

for ($k = 0 ; $k < $rows ; ++$k)

{
  $row = mysqli_fetch_assoc($result);
	$ecode=$ecode.$row['elective_code'];
	if($k!=$rows-1)
		$ecode=$ecode.",";
	//$fail=(int)$row['prate'];
  //$rate=((int)$row['prate']/((int)$row['prate']+(int)$row['frate']))*100;
  $GLOBALS['electivedeets']=$GLOBALS['electivedeets'].$row['branch'].",".$row['elective_name'].",".$row['elective_code'].",".$row['frate']."newentry";
	//$GLOBALS['electivedeets']=$GLOBALS['electivedeets'].$row['branch'].",".$row['elective_name'].",".$row['elective_code'].",".$row['prate'].",";

}
//$ids = join("','",$ecode);

echo $GLOBALS['electivedeets'];

?>
