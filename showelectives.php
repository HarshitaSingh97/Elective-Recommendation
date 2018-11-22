<?php
session_start();
extract($_GET);

$usn=$_SESSION['usn'];
echo $pool2;
//echo $pool1;
//echo $pool2;
	$db_server = mysqli_connect('localhost', 'root', 'root','WT2');

	// Check connection
	if (!$db_server) {
		die("Connection failed: " . mysqli_connect_error());
	}


	mysqli_select_db($db_server, 'WT2')

	or die("Unable to select database: " . mysqli_error());
	//$search=$movie."%";
	if($pool1!="")
	{
		$pool1=explode(",",$pool1);
	}
	else{
		$pool1=array(1);
	}
	if($pool2!="")
	{
		$pool2=explode(",",$pool2);
		echo $pool2[0];
	}
	else{
		$pool2=array(1);
	}
$sem="";
//JOIN ISSUES//$user_check_query = "SELECT avg(g.sgpa) as cgpa,e.*,sp.* FROM grades g , electives e,specialization sp, student s WHERE g.usn='$usn' and s.usn='$usn' and s.branch=e.branch and s.branch=sp.branch";
//$result = mysqli_query($db, $query);
$query="select max(sem) from grades where usn='$usn'";
$result = mysqli_query($db_server,$query);

if (!$result) die ("Database access failed: " . mysqli_error($db_server));

$rows = mysqli_num_rows($result);

for ($j = 0 ; $j < $rows ; ++$j)

{

$row = mysqli_fetch_row($result);
$sem=$row[0]+1;
}
//$query2="select * from electives where elective_group=2 and specialization like $pool2[$j]";
//$user = mysqli_fetch_assoc($result);
/*if($user['password']==0)
{

}*/
//echo $sem."sem";
$i=0;
$j=0;

$epool1="";
$epool2="";
if(count($pool1)==1 and count($pool2)==1){
	//echo "66";
  $query1="select distinct e.elective_name from electives e, grades g where e.elective_group=1 and e.sem='$sem' and e.cgpa_criteria<=(select avg(sgpa) from grades where usn='$usn') and (e.prerequisites in (select Subject1 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject2 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject3 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject4 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject5 from subjects s1 where s1.usn='$usn'))";
	//"select e.elective_name from electives e, subjects s,grades g, student st where st.usn='$usn' and g.usn='$usn' and (e.prerequisites in (select Subject1 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject2 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject3 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject4 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject5 from subjects s1 where s1.usn='$usn')) and e.elective_group=1 and e.sem='$sem' HAVING avg(g.sgpa)>=e.cgpa_criteria";
  $query2="select distinct e.elective_name from electives e, grades g where e.elective_group=2 and e.sem='$sem' and e.cgpa_criteria<=(select avg(sgpa) from grades where usn='$usn') and (e.prerequisites in (select Subject1 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject2 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject3 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject4 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject5 from subjects s1 where s1.usn='$usn'))";
	//select e.elective_name from electives e, subjects s,grades g, student st where st.usn='$usn' and g.usn='$usn' and (e.prerequisites in (select Subject1 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject2 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject3 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject4 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject5 from subjects s1 where s1.usn='$usn')) and e.elective_group=2 and e.sem='$sem'";
	processquery($query1,$query2,$db_server);
}
else if(count($pool1)==1){
	for($i=0; $i < count($pool2)-1;$i++)
	{
		$pool2spec="%".$pool2[$i]."%";
		//echo $pool2spec;
		//echo $pool1spec;
    $query1="select distinct e.elective_name from electives e, grades g where e.elective_group=1 and e.sem='$sem' and e.cgpa_criteria<=(select avg(sgpa) from grades where usn='$usn') and (e.prerequisites in (select Subject1 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject2 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject3 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject4 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject5 from subjects s1 where s1.usn='$usn'))";
    $query2="select distinct e.elective_name from electives e, grades g where e.elective_group=2 and e.sem='$sem' and e.cgpa_criteria<=(select avg(sgpa) from grades where usn='$usn') and (e.prerequisites in (select Subject1 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject2 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject3 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject4 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject5 from subjects s1 where s1.usn='$usn')) and e.specialization_id like '$pool2spec'";
    processquery($query1,$query2,$db_server);
	}
}
else if(count($pool2)==1){
	for($i=0; $i < count($pool1)-1;$i++)
	{
		$pool1spec="%".$pool1[$i]."%";
		//echo $pool2spec;
		//echo $pool1spec;
    $query1="select distinct e.elective_name from electives e, grades g where e.elective_group=1 and e.sem='$sem' and e.cgpa_criteria<=(select avg(sgpa) from grades where usn='$usn') and (e.prerequisites in (select Subject1 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject2 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject3 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject4 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject5 from subjects s1 where s1.usn='$usn')) and e.specialization_id like '$pool1spec'";
    $query2="select distinct e.elective_name from electives e, grades g where e.elective_group=2 and e.sem='$sem' and e.cgpa_criteria<=(select avg(sgpa) from grades where usn='$usn') and (e.prerequisites in (select Subject1 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject2 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject3 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject4 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject5 from subjects s1 where s1.usn='$usn'))";
	    processquery($query1,$query2,$db_server);
	}
}
else{
	for($i=0; $i < count($pool1)-1;$i++)
	{


		$pool1spec="%".$pool1[$i]."%";
		for($j=0;$j < count($pool2)-1;$j++)
		{

			$pool2spec="%".$pool2[$j]."%";
			//echo $pool2spec;
			//echo $pool1spec;
      $query1="select distinct e.elective_name from electives e, grades g where e.elective_group=1 and e.sem='$sem' and e.cgpa_criteria<=(select avg(sgpa) from grades where usn='$usn') and (e.prerequisites in (select Subject1 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject2 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject3 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject4 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject5 from subjects s1 where s1.usn='$usn')) and e.specialization_id like '$pool1spec'";
      $query2="select distinct e.elective_name from electives e, grades g where e.elective_group=2 and e.sem='$sem' and e.cgpa_criteria<=(select avg(sgpa) from grades where usn='$usn') and (e.prerequisites in (select Subject1 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject2 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject3 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject4 from subjects s1 where s1.usn='$usn') or e.prerequisites in (select Subject5 from subjects s1 where s1.usn='$usn')) and e.specialization_id like '$pool2spec'";
			processquery($query1,$query2,$db_server);
		}
	}
}
function processquery($query1,$query2,$db_server)
{
		//$imgarray=array();
		//echo "115";
		$result = mysqli_query($db_server,$query1);
		if (!$result) die ("Database access failed: " . mysqli_error($db_server));

		$rows = mysqli_num_rows($result);
		for ($k = 0 ; $k < $rows ; ++$k)

		{
			$row = mysqli_fetch_row($result);
			$GLOBALS['epool1']=$GLOBALS['epool1'].$row[0].",";
				//echo $row[0];
				//echo "126 ".$row[0]."   ";

		}
		//$GLOBALS['epool1']=$GLOBALS['epool1']."yaya";
		$result = mysqli_query($db_server,$query2);
		if (!$result) die ("Database access failed: " . mysqli_error($db_server));
		$rows = mysqli_num_rows($result);
		for ($k = 0 ; $k < $rows ; ++$k)

		{
			$row = mysqli_fetch_row($result);
			$GLOBALS['epool2']=$GLOBALS['epool2'].$row[0].",";
			//echo "138 ".$row[0]."   ";
		}
		//$GLOBALS['epool1']=$GLOBALS['epool1']."yaya";



	}
	//$GLOBALS['ret']=$GLOBALS['ret'].$GLOBALS['nameret']."moviemaniaseparator".$GLOBALS['imgret']."moviemaniaseparator".$GLOBALS['urlret'];//."moviemaniasetseparator";
	//$GLOBALS['ret']=$GLOBALS['ret'].$GLOBALS['nameret']."moviemaniaseparator".$GLOBALS['criticret']."moviemaniaseparator".$GLOBALS['avguserret']."moviemaniaseparator".$GLOBALS['urlret'];//."moviemaniasetseparator";
	$json_array=array();
	$query="select sgpa,sem from grades where usn='$usn'";
	$result = mysqli_query($db_server,$query);

	if (!$result) die ("Database access failed: " . mysqli_error($db_server));
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		//$monthName = date('F', mktime(0, 0, 0, $row['mon'], 10));
		$row_array['label']=$row['sem'];
		$row_array['y'] =(float)$row['sgpa'];
		array_push($json_array,$row_array);

	}

	echo $GLOBALS['epool1'].";".$GLOBALS['epool2']."analyze".json_encode($json_array);
	mysqli_close($db_server);

?>
