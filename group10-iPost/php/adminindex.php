<html>
<title> Admin Index </title>
<body>
<h1> Welcome, <?php

session_start();
$_SESSION["user_type"] = 1;
echo $_SESSION["user_name"];
?> </h1>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<a href="register.php"><input value="Register an admin" type="button"></a>
<a href="post.php"><input value="View posts" type="button"></a>
<a href="userlist.php"><input value="View users" type="button"></a>
<a href="logout.php"><input value="Log out" type="button"></a>

</body>
</html>
