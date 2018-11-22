<?php
session_start();

$admin = "";
$email    = "";
$errorsadmin = array();

$errors = array();
$_SESSION['usn']="";

$db = mysqli_connect('localhost', 'root', 'root', 'WT2');
if(isset($_POST['adminid']))
{
	//echo("in if");
	$admin=$_POST['adminid'];
	$password=md5($_POST['pwdadmin']);
  $user_check_query = "SELECT * FROM admin WHERE admin_id='$admin'";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);
  if(strcasecmp($user['password'],$password)==0)
	{
		$_SESSION['admin']=$admin;
		header('location: admindashboard.php');
	}
	else if(!$user)
	{
		array_push($errorsadmin, "Not a member. Please register!");
    $_SESSION['errorsadmin']=$errorsadmin;
    //header('location: dashboard1.html');

	}
	else if(strcasecmp($user['password'],$password)!=0)
	{
		array_push($errorsadmin, "Wrong password");
    // header('location: dashboard2.html');
		$_SESSION['errorsadmin']=$errorsadmin;

	}
}
?>
