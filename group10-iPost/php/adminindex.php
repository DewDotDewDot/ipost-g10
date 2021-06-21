<html>
<title> Admin Index </title>
<body>
<h1> Welcome, <?php

session_start();
$_SESSION["user_type"] = 1;
echo $_SESSION["user_name"]
?> </h1>


<a href="register.php"><input name="userType" value="Register an admin" type="button"></a>



</body>
</html>
