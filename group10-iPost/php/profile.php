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

      <h1>Profile: </h1>

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
              ?>

                <div class="profile_info">
                  <table>
                    <tr>
                      <td colspan="2">
                        <div>
                          <div>
                            <img class="profile_pic" src="<?php echo  "../img_assets/pfp/$tmp_profile_pic"; ?>">
                          </div>
                          <div>
                            <h6>Username: <?php echo $tmp_username; ?></h6>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php if($tmp_privacy == 0 || $_SESSION['user_id'] == $tmp_user_id) { ?>
                    <tr>
                      <td>
                        <div>
                          <p>First Name: <?php echo $tmp_fname; ?></p>
                        </div>
                      </td>
                      <td>
                        <div>
                          <p>Last Name: <?php echo $tmp_lname; ?></p>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div>
                          <p>Email: <?php echo $tmp_email; ?></p>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>
                          <p>Birthdate: <?php echo $tmp_birthdate; ?></p>
                        </div>
                      </td>
                      <td>
                        <div>
                          <p>Sex: <?php echo $tmp_sex; ?></p>
                        </div>
                      </td>
                    </tr>
                    <?php } else { ?>
                    <h5> This user has their account on private </h5>
                  <?php } ?>
                    <tr>
                      <td>
                        <?php if($_SESSION['user_id'] == $tmp_user_id) { ?>
                          <div>
                            <a href="editProfileForm.php?id=<?php echo $_SESSION['user_id']?>"><h6>Edit</h6></a>
                          </div>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if($_SESSION['user_type'] == 1) { ?>
                        <div>
                          <a href="deleteItem.php?id=<?php echo $tmp_user_id?>&type=user"><h6>Delete</h6></a>
                        </div>
                        <?php } ?>
                      </td>
                    </tr>
                  </table>
                </div>
            <?php endwhile; ?>
          <?php endif; ?>

       <h1>Posts: </h1>
       <?php if($tmp_privacy == 0 || $_SESSION['user_id'] == $tmp_user_id) {

         $query = "SELECT * FROM tbl_feed WHERE user_id = '$tmp_user_id' ORDER BY timestamp DESC";

         if($result = $sql->query($query)): ?>
           <?php while($row = $result->fetch_assoc()): ?>
             <?php
              unset($tmp_image);
               $tmp_post_id = $row["id"];
               $tmp_content = $row["content"];
               $tmp_user_id = $row["user_id"];
               if (!is_null($row["image"])) {
               $tmp_image = $row["image"];
               }
               $tmp_title = $row["header"];
               $tmp_timestamp = $row["timestamp"];
               $tmp_score = $row["like_score"];
             ?>

             <?php if($result2 = $sql->query("SELECT * FROM tbl_users WHERE id = '$tmp_user_id'")): ?>

               <?php while($row2 = $result2->fetch_assoc()): ?>

                 <?php
                   $tmp_username = $row2["username"];
                 ?>

                   <div class="profile_info">
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
                               <h4><?php echo $tmp_username; ?></h2>
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
                     </table>
                   </div>

               <?php endwhile; ?>
             <?php endif; ?>
           <?php endwhile; ?>
         <?php endif; ?>

       <?php } else { ?>
         <h5> This user has their account on private </h5>
       <?php } ?>
       </div>
    </div>
  </body>
 </html>
