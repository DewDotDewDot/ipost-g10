<?php
//data based accesed or connected
  include_once("database.php");
  if (isset($_SESSION["user_type"]))
  {
    header("location: index.php");
    exit();
  }
  $allowInputRequired = false;
?>
<!DOCTYPE html>
<html>
   <head>
     <title> <?php echo $_SESSION["siteName"] ?></title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="../css/form.css" type="text/css">
    <link rel="stylesheet" href="../css/navbar.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="../css/body.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
   <body>
    <!--Navbar-->
     <?php include_once("goodnavbar.php"); ?>
      <?php if(isset($_SESSION["alert_err"])): ?>
        <script type="text/javascript">
          var alertNotice = '<?php echo $_SESSION["alert_err"]; ?>';
          alert(alertNotice);
          <?php unset($_SESSION["alert_err"]); ?>
        </script>
      <?php endif; ?>
<!-- REGISTRATION -->
      <?php if(isset($_SESSION["alert_success"])): ?>
        <script type="text/javascript">
          var successNotice = '<?php echo $_SESSION["alert_success"]; ?>';
          alert(successNotice);
          <?php unset($_SESSION["alert_success"]); ?>
        </script>
      <?php endif; ?>

   <?php if($allowInputRequired): ?>
    <div class="form-wrapper">
      <form class="form-main" action="handlelogin.php" method="post" >
        <div class="formItem">
          <h1>Log In</h1>
        </div>
        <div class="formItem">
          <label for="username">Username</label>
        </div>
        <div class="formItem">
          <input type="text" name="username" required>
        </div>

        <div class="formItem">
          <label for="password">Password</label>
        </div>
        <div class="formItem">
          <input type="password" name="password" required>
        </div>

        <div class="formItem">
          <input type="submit" name="loginForm" value="Log In">
        </div>

      </form>
    </div>

   <?php else: ?>
     <div class="form-wrapper">
       <form class="form-main" action="handleLogin.php" method="post" >
       	<table id="row-bordered">
          <tr>
            <td>Username</td>
            <td>
              <input type="text" name="username" required>
            </td>
          </tr>

          <tr>
          	<td>Password</td>
            <td>
              <input type="password" name="password" required>
            </td>
          </tr>

          <tr>
            <td colspan="2" style="text-align: center;">
            <a href="register.php"><p style="color:white"> Register Now!</p></a>
            </td>
          </tr>

          <tr>
            <td colspan="2" style="text-align: center;">
              <div class="formItem">
              <input type="submit" name="loginForm" value="Log In">
              </div>
            </td>
          </tr>

       </form>
     </div>

   <?php endif; ?>

   </body>
</html>
