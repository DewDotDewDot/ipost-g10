<?php include_once("database.php");?>

<html>
<head>
  <title> Admin Index - <?php echo $_SESSION["siteName"] ?>  </title>
    <link rel="stylesheet" href="../css/admin.css" type="text/css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/navbar.css" type="text/css">
  <link rel="stylesheet" href="../css/post.css" type="text/css">
</head>
<body>
  <?php include_once("goodnavbar.php"); ?>
  <?php if(isset($_SESSION["alert_feedPost"])): ?>
    <script type="text/javascript">

      alert('<?php echo $_SESSION["alert_feedPost"]; ?>');
      <?php unset($_SESSION["alert_feedPost"]); ?>

    </script>
  <?php endif; ?>
<h1> Welcome, <?php

$_SESSION["user_type"] = 1;
echo $_SESSION["user_name"];
?> </h1>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<a href="register.php"><input value="Register an admin" type="button"></a>
<a href="post.php"><input value="View posts" type="button"></a>
<a href="userlist.php"><input value="View users" type="button"></a>

</body>
</html>
