<?php
session_start();

$usn = "";
$email    = "";
$errors = array();
$errorsadmin = array();
$_SESSION['usn']="";

$db = mysqli_connect('localhost', 'root', 'root', 'WT2');
if(isset($_POST['usn']))
{
	//echo("in if");
	$usn=$_POST['usn'];
	$password=md5($_POST['pwd']);
  $user_check_query = "SELECT * FROM student WHERE usn='$usn'";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);
  if(strcasecmp($user['password'],$password)==0)
	{
		$_SESSION['usn']=$usn;
		header('location: dashboard.php');
	}
	else if(!$user)
	{
		array_push($errors, "Not a member. Please register!");
    $_SESSION['errors']=$errors;
		$_SESSION['errorsadmin']="";
    //header('location: dashboard1.html');

	}
	else if(strcasecmp($user['password'],$password)!=0)
	{
		array_push($errors, "Wrong password");
    // header('location: dashboard2.html');
		$_SESSION['errors']=$errors;
		$_SESSION['errorsadmin']="";

	}
}
?>
