<?php
  include_once("database.php");
  if (!isset($_SESSION["user_type"]))
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
    <link rel="stylesheet" href="../css/comments.css" type="text/css">
    <link rel="stylesheet" href="../css/nav.css" type="text/css">
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
        <form class="feed-formPost" action="handlePost.php?type=post" method="post" enctype='multipart/form-data'>

        <h1>Welcome, <?php echo $_SESSION["user_name"]; ?></h1>
        <input type="text" name="title" placeholder="Set your title here" required> <br>
        <pre><textarea name="feedPost" rows="4" cols="50" placeholder="Put your text content here" required></textarea></pre>
        <input class="post-content" type="file" name="feed_pic" accept="image/*">
        <input type="submit" name="feedSubmit" value="Post">

        </form>

      <h1>See your friends!</h1> <!--feed set-->
        <div class="feed-posts">
          <form action="post.php" method="post">
            <select name="sortOption">
              <option value="new">Newest</option>
              <option value="hot">Hottest</option>
            </select>
            <button type="submit">Sort</button>
          </form>
          <?php
          $sortQuery = "SELECT * FROM tbl_feed ORDER BY timestamp DESC";
          if(empty($_POST['sortOption'])) {
            $sortQuery = "SELECT * FROM tbl_feed ORDER BY timestamp DESC"; ?>
            <p class="sort"> Sorted by: Newest </p>
             <?php
          } else {
            if ($_POST['sortOption'] == "new") {
              $sortQuery = "SELECT * FROM tbl_feed ORDER BY timestamp DESC"; ?>
              <p class="sort"> Sorted by: Newest </p>
               <?php
            }
            if ($_POST['sortOption'] == "hot") {
              $sortQuery = "SELECT * FROM tbl_feed ORDER BY like_score DESC"; ?>
              <p class="sort"> Sorted by: Hottest </p>
               <?php
            }
          }

          if($result = $sql->query($sortQuery)): ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <?php
                unset($tmp_image);
                $tmp_post_id = $row["id"];
                $tmp_content = $row["content"];
                $tmp_user_id = $row["user_id"];
                $tmp_title = $row["header"];
                if (!is_null($row["image"])) {
                $tmp_image = $row["image"];
                }
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
                      <table>
                        <tr>
                          <td>
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
                          </form>
                          </td>
                          <td>
                            <div class="post-title">
                                <div class="feed-item">
                                  <img class="profile_pic" src="<?php echo  "../img_assets/pfp/$tmp_profile_pic"; ?>">
                                </div>
                              <div class="feed-item">
                                <a class="post_title"  href="profile.php?id=<?php echo $tmp_user_id ?>"><h4><?php echo $tmp_username; ?></h4></a>
                              </div>
                              <div class="post-content">
                                <p><?php echo $tmp_timestamp; ?></p>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="post-content">
                              <h2><a class="post_title" href="comments.php?id=<?php echo $tmp_post_id?>"><?php echo $tmp_title; ?></a></h2>
                            </div>
                            <?php if (isset($tmp_image)) { ?>
                            <div>
                              <img class="post_image" src="<?php echo  "../img_assets/posts/$tmp_image"; ?>">
                            </div>
                          <?php } ?>
                            <div class="post-content">
                              <p><pre><?php echo $tmp_content; ?></pre></p>
                            </div>
                          </td>
                          <?php if($_SESSION['user_type'] == 1 || $sess_user_id == $tmp_user_id) { ?>
                          <td>
                            <div>
                              <a href="deleteItem.php?id=<?php echo $tmp_post_id?>&type=post&user_id=<?php echo $tmp_user_id?>"><h6>Delete</h6></a>
                            </div>
                          </td>
                        <?php } ?>
                        </tr>
                        <hr>
                      </table>
                    </div>

                <?php endwhile; ?>
              <?php endif; ?>
            <?php endwhile; ?>
          <?php endif; ?>
       </div>

    </div>
  </body>
 </html>
