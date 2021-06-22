<html>
<title> Admin Index </title>
<body>
<h1> Welcome, <?php

session_start();
$_SESSION["user_type"] = 1;
echo $_SESSION["user_name"];
?> </h1>


<a href="register.php"><input value="Register an admin" type="button"></a>
<a href="post.php"><input value="View posts" type="button"></a>
<a href="userlist.php"><input value="View users" type="button"></a>
<a href="logout.php"><input value="Log out" type="button"></a>

</body>
</html>
