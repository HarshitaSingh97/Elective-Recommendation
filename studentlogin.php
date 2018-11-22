<?php include('loginvalidation.php') ?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="se.css"/>
  <link rel="stylesheet" href="style.css"/>

</head>
<body>
  <div align="center">
    <form method="POST" action="index.php" style="width:20em;height:10em;border:solid 1px green;">
      <?php include('errors.php'); ?>
      <br>
      <br>
      <label><span style="float:left;">USN: </span><input type="text" id="usn" name="usn" placeholder="Enter USN" style="float:right;" required></input></label><br><br>
      <label><span style="float:left;">PASSWORD: </span><input type="password" id="pwd" minlength="8" min name="pwd" placeholder="Enter Password" style="float:right;" required></input></label><br><br>
      <input type="submit" value="LogIn"></input>
    </form>
  </div>
</body>
</html>
