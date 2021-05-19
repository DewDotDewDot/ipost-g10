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
        <input type="text" name="title" placeholder="Set your title here" required> <br>
        <textarea name="feedPost" rows="4" cols="50" placeholder="Put your text content here" required></textarea>
        <input type="submit" name="feedSubmit" value="Post">

        </form>

      <h1>See your friends!</h1> <!--feed set-->
        <div class="feed-posts">
          <?php if($result = $sql->query("SELECT * FROM tbl_feed")): ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <?php
                $tmp_post_id = $row["id"];
                $tmp_content = $row["content"];
                $tmp_user_id = $row["user_id"];
                $tmp_title = $row["header"];
                $tmp_timestamp = $row["timestamp"];
                $tmp_score = $row["like_score"];
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
                        <div class="post-content">
                          <p><?php echo $tmp_timestamp; ?></p>
                        </div>
                      </div>
                      <div class="post-content">
                        <p><?php echo $tmp_title; ?></p>
                      </div>
                      <div class="post-content">
                        <p><?php echo $tmp_content; ?></p>
                      </div>
                      <form action="handleScore.php?post_id=<?php echo $tmp_post_id?>" method="post">
                        <div class="post-content">
                          <?php
                            $up = "";
                            $down = "";
                            $sess_user_id = $_SESSION['user_id'];

                            $scoreCheckQuery = "SELECT score FROM tbl_score
                                                WHERE post_id = '$tmp_post_id' AND user_id = '$sess_user_id'";
                            $execQuery = mysqli_query($sql, $scoreCheckQuery);
                            $scoreFetch = mysqli_fetch_assoc($execQuery);

                            if (empty($scoreFetch['score'])) {
                              $up = "";
                              $down = "";
                            } else {
                              if($scoreFetch['score'] == 1) {
                                $up = "disabled";
                                $down = "";
                              }
                              if($scoreFetch['score'] == -1) {
                                $up = "";
                                $down = "disabled";
                              }
                            }

                          ?>
                          <button name="score" type="submit" value="1" <?php echo $up?>> ↑ </button>
                          <p><?php echo $tmp_score; ?></p>
                          <button name="score" type="submit" value="-1" <?php echo $down?>> ↓ </button>
                        </div>
                      </form
                    </div>

                <?php endwhile; ?>
              <?php endif; ?>
            <?php endwhile; ?>
          <?php endif; ?>
       </div>

    </div>
  </body>
 </html>
