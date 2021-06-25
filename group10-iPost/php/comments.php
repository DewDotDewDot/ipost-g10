<?php
  include_once("database.php");
  if (!isset($_SESSION["user_type"]))
  {
    header("location: index.php");
    exit();
  }

  $post_id = $_GET['id'];
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
    <?php endif;
    $postQuery = "SELECT * FROM tbl_feed WHERE id = '$post_id'";

    if($result = $sql->query($postQuery)): ?>
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
                          <img src="<?php echo  "../img/$tmp_profile_pic"; ?>">
                        </div>
                        <div class="feed-item">
                          <h4><?php echo $tmp_username; ?></h2>
                        </div>
                        <div class="post-content">
                          <p><?php echo $tmp_timestamp; ?></p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="post-content">
                        <h2><?php echo $tmp_title; ?></h2>
                      </div>
                      <div class="post-content">
                        <p><pre><?php echo $tmp_content; ?></pre></p>
                      </div>
                    </td>
                    <?php if($_SESSION['user_type'] == 1) { ?>
                    <td>
                      <div>
                        <a href="deleteItem.php?id=<?php echo $tmp_post_id?>&type=post&user_id=<?php echo $tmp_user_id?>"><h6>Delete</h6></a>
                      </div>
                    </td>
                  <?php } ?>
                  </tr>
                </table>
              </div>

          <?php endwhile; ?>
        <?php endif; ?>
      <?php endwhile; ?>
    <?php endif; ?>

      <div class="feed-wrapper">

      <h1>Comments:</h1> <!--Comment set-->

        <form class="feed-formPost" action="handlePost.php?type=comment&post_id=<?php echo $post_id?>" method="post">

          <pre><textarea name="comment" rows="4" cols="50" placeholder="Share your thoughts" required></textarea></pre>
          <input type="submit" name="feedSubmit" value="Enter">

        </form>

          <?php
          $query = "SELECT * FROM tbl_comments WHERE post_id = '$post_id' ORDER BY id DESC";

          if($result = $sql->query($query)): ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <?php
                $tmp_comment_id = $row["id"];
                $tmp_comment = $row["comment"];
                $tmp_user_id = $row["user_id"];
                $tmp_timestamp = $row["timestamp"];
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
                          </form>
                          </td>
                          <td>
                            <div class="post-title">
                              <div class="feed-item">
                                <img src="<?php echo  "../img/$tmp_profile_pic"; ?>">
                              </div>
                              <div class="feed-item">
                                <h4><?php echo $tmp_username; ?></h2>
                              </div>
                              <div class="post-content">
                                <p><?php echo $tmp_timestamp; ?></p>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="post-content">
                              <p><?php echo $tmp_comment; ?></p>
                            </div>
                          </td>
                          <?php if($_SESSION['user_type'] == 1 || $sess_user_id == $tmp_user_id) { ?>
                          <td>
                            <div>
                              <a href="deleteItem.php?id=<?php echo $tmp_comment_id?>&type=comment&user_id=<?php echo $tmp_user_id?>"><h6>Delete</h6></a>
                            </div>
                          </td>
                          <?php } ?>
                        </tr>
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
