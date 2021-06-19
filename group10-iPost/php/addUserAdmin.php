<?php
//header("location: register.php?type=admin");
?>
<html>
<title> Add user admin </title>
<body>
  <form action="register.php" method=POST>
  <h1> You are registering an
    <input type="text" name="userType" value="admin" readonly="true">
    account. Please confirm. <br>
  </h1>
  <input type="submit">
  </form>
</body>
<html>
