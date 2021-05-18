<?php
  include_once("database.php");
  if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] === "admin")
  {
    header("location: index.php");
    exit();
  }

  $tmp_feed_title = $_POST['title'];
  $tmp_feed_content = $_POST['feedPost'];
  $tmp_user_id = $_SESSION['user_id'];

  $query = "INSERT INTO tbl_feed (user_id, header, content) VALUES ('$tmp_user_id', '$tmp_feed_title', '$tmp_feed_content')";
  $execQuery = mysqli_query($sql, $query);

  header("location: Post.php");
?>
