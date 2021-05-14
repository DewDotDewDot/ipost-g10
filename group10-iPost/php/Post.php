<?php
  include_once("database.php");
  if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] === "admin")
  {
    header("location: index.php");
    exit();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $_SESSION["siteName"] ?></title>
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

      <div class="feed-wrapper">
        <form class="feed-formPost" action="handlePost.php" method="post">
         
        <h1>Welcome, <?php echo $_SESSION["user_name"]; ?></h1>
        <textarea name="feedPost" rows="4" cols="50" placeholder="Just Post it  <?php echo $_SESSION["user_name"]; ?>?" required></textarea>
        <input type="submit" name="feedSubmit" value="Post">
     
        </form>

      <h1>See your friends!</h1>
        <div class="feed-posts">
          <?php if($result = $sql->query("SELECT * FROM tbl_feed")): ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <?php
                $tmp_content = $row["feed_content"];
                $tmp_user_id = $row["feed_owner"];
              ?>
              
              <?php if($result2 = $sql->query("SELECT * FROM tbl_users WHERE id = '$tmp_user_id'")): ?>
                 
                <?php while($row2 = $result2->fetch_assoc()): ?>
                 
                  <?php
                    $tmp_username = $row2["username"];
                    $tmp_profile_pic = $row2["profile_pic"];
                  ?>

                    <div class="feed-itemsWrapper">
                      <div class="post-title">
                        <div class="feed-item">
                          <img src="<?php echo  "../img/$tmp_profile_pic"; ?>">
                        </div>
                      <div class="feed-item">
                          <h2><?php echo $tmp_username; ?></h2>
                        </div>
                      </div>
                      <div class="post-content">
                        <p><?php echo $tmp_content; ?></p>
                      </div>
                    </div>

                <?php endwhile; ?>
              <?php endif; ?>
            <?php endwhile; ?>
          <?php endif; ?>
       </div>

    </div>
  </body>
 </html>
