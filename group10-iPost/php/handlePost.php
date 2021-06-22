<?php
  include_once("database.php");
  if (!isset($_SESSION["user_type"]))
  {
    header("location: index.php");
    exit();
  }

  $type = $_GET['type'];

  if ($type == "post") {
    $tmp_feed_title = $_POST['title'];
    $tmp_feed_content = $_POST['feedPost'];
    $tmp_user_id = $_SESSION['user_id'];
    $query = "INSERT INTO tbl_feed (user_id, header, content) VALUES ('$tmp_user_id', '$tmp_feed_title', '$tmp_feed_content')";
  } elseif ($type == "comment") {
    $tmp_post_id = $_GET['post_id'];
    $tmp_comment = $_POST['comment'];
    $tmp_user_id = $_SESSION['user_id'];
    $query = "INSERT INTO tbl_comments (post_id, user_id, comment) VALUES ('$tmp_post_id', '$tmp_user_id', '$tmp_comment')";
  }
  $execQuery = mysqli_query($sql, $query);

?>

<script>
history.go(-1);
</script>
