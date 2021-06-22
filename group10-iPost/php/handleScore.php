<?php
  include_once("database.php");
  if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] === "admin")
  {
    header("location: index.php");
    exit();
  }

  $tmp_score_value = $_POST['score'];
  $tmp_post_id = $_GET['post_id'];
  $tmp_user_id = $_SESSION['user_id'];
  $sess_user_id = $_SESSION['user_id'];

  $scoreCheckQuery = "SELECT score FROM tbl_score
                      WHERE post_id = '$tmp_post_id' AND user_id = '$sess_user_id'";
  $execQuery = mysqli_query($sql, $scoreCheckQuery);
  $scoreFetch = mysqli_fetch_assoc($execQuery);

  if(empty($scoreFetch['score'])){
    $scoreQuery = "INSERT INTO tbl_score (post_id, user_id, score) VALUES ($tmp_post_id, $tmp_user_id, $tmp_score_value)";
    $scoreUpdateQuery = "UPDATE tbl_feed SET like_score = like_score + $tmp_score_value WHERE id = $tmp_post_id";
    $execQuery = mysqli_query($sql,$scoreQuery);
  } else {
    $scoreQuery = "UPDATE tbl_score SET score = '$tmp_score_value' WHERE post_id = '$tmp_post_id' AND user_id = '$sess_user_id'";
    $scoreUpdateQuery = "UPDATE tbl_feed SET like_score = like_score + ($tmp_score_value * 2) WHERE id = $tmp_post_id";
    $execScoreQuery = mysqli_query($sql,$scoreQuery);
  }
    $execScoreUpdateQuery = mysqli_query($sql,$scoreUpdateQuery);

?>

<script>
history.go(-1);
</script>
