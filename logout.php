<?php
session_start();
unset($_SESSION['usn']);
unset($_SESSION['errors']);
unset($_SESSION['errorsadmin']);
unset($_SESSION['admin']);
session_destroy();

header('location: index.php');
exit;
 ?>
