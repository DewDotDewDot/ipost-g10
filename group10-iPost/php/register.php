<?php
  include_once("database.php");

  $_SESSION['not_register'] = false;

  $userType = 0;
  $isAdmin = false;
  if (isset($_SESSION["user_type"])) {
    if ($_SESSION["user_type"] == 1) {
      $isAdmin = true;
    }
  }
  if (isset($_POST['userType'])) {
    if ($_POST["userType"] == "admin")
    $isAdmin = true;
  }
  if ($isAdmin) {
    $userType = 1;
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $_SESSION["siteName"] ?></title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/form.css" type="text/css">
    <link rel="stylesheet" href="../css/navbar.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="../css/body.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>
    <?php include_once("goodnavbar.php"); ?>
    <?php if(isset($_SESSION["alert_err"])): ?>
      <script type="text/javascript">
        var alertNotice = '<?php echo $_SESSION["alert_err"]; ?>';
        alert(alertNotice);
        <?php unset($_SESSION["alert_err"]); ?>
      </script>
    <?php endif; ?>

   <div class="form-wrapper">
     <form class="form-main" action="handleRegister.php" method="post" >

      <div class="formItem">
        <h1>Registration</h1>
      </div>
      <table id="row-bordered">
        <tr>
          <td>First name</td>
          <td>
            <input type="text" name="firstName" required>
          </td>
        </tr>
        <tr>
          <td>Last name</td>
          <td>
            <input type="text" name="lastName" required>
          </td>
        </tr>
        <tr>
        <td>Birthdate</td>
          <td>
            <input type="date" name="birthdate" required>
          </td>
        </tr>
        <tr>
        <td>Email</td>
          <td>
            <input type="email" name="email" required>
          </td>
        </tr>
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
        	<td>Confirm Password</td>
        	<td>
        		<input type="password" name="password_confirm" required="">
        	</td>
        </tr>
        <tr>
         <td>Sex:</td>
          <td>
          <select name="sex" class="form-select">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Prefer not say">Prefer not say</option>
          </select>
          </td>
        </tr>
        <?php if ($userType == 1) {?>
          <tr>
           <td>Type:</td>
           <td>
             <input type="text" name="userType" value="admin" readonly="true">
           </td>
          </td>
          </tr>
        <?php } ?>
      </table>
      <input type="submit" name="registerForm" value="Register">
      <div class="formItem">
      </div>
     </form>
   </div>
  </form>
   </div>
  </body>
</html>
