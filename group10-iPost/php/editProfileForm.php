<?php
  include_once("database.php");
  if (!isset($_SESSION["user_type"]))
  {
    header("location: index.php");
    exit();
  }


  $sexSet = array("Male","Female","Prefer not say");

  if(isset($_SESSION['alertMessage'])) {
    ?>
      <script>
        alert("<?php echo $_SESSION['alertMessage']?>");
      </script>
    <?php
    unset($_SESSION['alertMessage']);
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <html>
      <head>
        <title><?php echo $_SESSION["siteName"] ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/navbar.css" type="text/css">
        <link rel="stylesheet" href="../css/Post.css" type="text/css">
      </head>

      <?php include_once("goodnavbar.php"); ?>

      <h1>Edit profile: </h1>

        <div class="feed-posts">

          <?php

          if (ISSET($_GET['id'])){
              $tmp_profile_id = ($_GET['id'] == $_SESSION['user_id']) ? $_SESSION['user_id'] : $_GET['id'];
          } else {
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
          }

          $profileQuery = "SELECT * FROM tbl_users WHERE id = '$tmp_profile_id'";

          if($result = $sql->query($profileQuery)): ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <?php
                $tmp_user_id = $row["id"];
                $tmp_fname = $row["fname"];
                $tmp_lname = $row["lname"];
                $tmp_email = $row["email"];
                $tmp_username = $row["username"];
                $tmp_birthdate = $row["birthdate"];
                $tmp_sex = $row["sex"];
                $tmp_profile_pic = $row["profile_pic"];
                $tmp_privacy = $row["privacy"];
                $privacy_str = ($tmp_privacy == 0) ? "off" : "on";
              ?>

                <div class="feed-itemsWrapper">
                  <table>
                    <tr>
                      <td colspan="2">
                        <div>
                          <form action='handleEditProfile.php?changePfp=1&id=<?php echo $tmp_user_id ?>' method='POST' enctype='multipart/form-data'>
                          <div>
                            <img src="<?php echo  "../img_assets/pfp/$tmp_profile_pic"; ?>">
                            <input type="file" name="profile_pic" accept="image/*" required>
                            <input type="submit" value="Change Profile Picture">
                          </div>
                          </form>
                          <form action="handleEditProfile.php?id=<?php echo $tmp_user_id ?>" method="post">
                          <div>
                            <h6>Username: </h6>
                            <input type="text" name="username" value="<?php echo $tmp_username; ?>" required>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>
                          <p>First Name: </p>
                          <input type="text" name="fname" value="<?php echo $tmp_fname; ?>" required>
                        </div>
                      </td>
                      <td>
                        <div>
                          <p>Last Name: </p>
                          <input type="text" name="lname" value="<?php echo $tmp_lname; ?>" required>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div>
                          <p>Email: </p>
                          <input type="email" name="email" value="<?php echo $tmp_email; ?>" required>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>
                          <p>Birthdate: </p>
                          <input type="date" name="birthdate" value="<?php echo $tmp_birthdate; ?>" required>
                        </div>
                      </td>
                      <td>
                        <div>
                          <p>Sex: </p>
                          <select name="sex">
                            <option value="<?php echo $tmp_sex; ?>"><?php echo $tmp_sex; ?></option>
                            <?php
                            for($i = 0; $i < 3; $i++) {
                              if ($sexSet[$i] == $tmp_sex) {
                                continue;
                              } ?>
                              <option value="<?php echo $sexSet[$i]; ?>"><?php echo $sexSet[$i]; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>
                          <p>Privacy is set to: </p>
                          <a href="handleEditProfile.php?id=<?php echo $tmp_user_id ?>&privSet=<?php echo $tmp_privacy?>"><?php echo $privacy_str?></a>
                        </div>
                      </td>
                    <?php if($_SESSION['user_id'] == $tmp_user_id) { ?>
                      <td>
                        <div>
                          <a href="deleteItem.php?id=<?php echo $tmp_user_id?>&type=user"><h6>Delete</h6></a>
                        </div>
                      </td>
                    <?php } ?>
                    </tr>
                  </table>
                  <input type="submit" value="Save changes">
                </form>
                </div>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
    <div>
      <h2> Change Password: </h2>
      <form action="handleEditProfile.php?id=<?php echo $tmp_user_id?>&passChange=true" method="post">
        <label> Current Password: </label>
        <input type="password" name="oldPass" required> <br>
        <label> New Password: </label>
        <input type="password" name="newPass" required> <br>
        <label> Confirm Password: </label>
        <input type="password" name="confPass" required> <br>
        <input type="submit" value="change password"d>
      </form>
    </div>
  </body>
</html>
