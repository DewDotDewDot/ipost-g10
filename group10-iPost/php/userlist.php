<?php
include_once("database.php");

try {
  if ($_SESSION["user_type"] == 0)
  {
    header("location: index.php");
    exit();
  }
} catch(Exception $e){
  header("location: index.php");
  exit();
}
?>

<html>
<head>
  <title> Admin Index - <?php echo $_SESSION["siteName"] ?>  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/navbar.css" type="text/css">
  <link rel="stylesheet" href="../css/Post.css" type="text/css">
</head>
<body>
  <?php include_once("goodnavbar.php"); ?>
  <?php if(isset($_SESSION["alert_feedPost"])): ?>
    <script type="text/javascript">

      alert('<?php echo $_SESSION["alert_feedPost"]; ?>');
      <?php unset($_SESSION["alert_feedPost"]); ?>

    </script>
  <?php endif; ?>

  <div class="feed-itemsWrapper">
    <table>
      <tr>
        <th>
          Profile Picture
        </th>
        <th>
          Username
        </th>
        <th>
          User Type
        </th>
        <th>
          Delete User
        </th>
      </tr>
<?php
$query = "SELECT * from tbl_users";
if($result = $sql->query($query)):
  while($row = $result->fetch_assoc()):
      $tmp_profile_pic = $row["profile_pic"];
      $tmp_user_id = $row["id"];
      $tmp_username = $row["username"];
      $tmp_user_type = $row["user_type"];
    ?>

        <tr>
          <td>
            <div class="feed-item">
              <img src="<?php echo  "../img/$tmp_profile_pic"; ?>">
            </div>
          </td>
          <td>
            <div class="feed-item">
              <a href="profile.php?id=<?php echo $tmp_user_id ?>"><p><?php echo $tmp_username; ?><p></a>
            </div>
          </td>
          <td>
            <div class="post-content">
              <p><?php echo ($tmp_user_type = 0) ? "User" : "Admin"; ?></p>
            </div>
          </td>
          <td>
            <a href="deleteItem.php?id=<?php echo $tmp_user_id?>&type=user"><p>Delete</p></a>
          </td>
        </tr>
<?php
  endwhile;
endif;
?>
    </table>
  </div>
</body>
</html>
