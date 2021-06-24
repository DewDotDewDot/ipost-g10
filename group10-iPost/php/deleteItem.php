<?php
include_once("database.php");

try {
  if ($_SESSION["user_type"] == 0 && !($_GET['user_id'] == $_SESSION['user_id']))
  {
    ?>
    <script>
    history.go(-1);
    </script>
    <?php
  }
} catch(Exception $e){
  header("location: index.php");
  exit();
}

$id = $_GET['id'];
$type = $_GET['type'];

if ($type == "post") {
  $query = "DELETE from tbl_feed WHERE id = '$id'";
}

if ($type == "user") {
  $query = "DELETE from tbl_users WHERE id = '$id'";
}

if ($type == "comment") {
  $query = "DELETE from tbl_comments WHERE id = '$id'";
}

$sql->query($query);

if($_SESSION['user_id'] == $id && $type == "user") {
  header("location: logout.php");
  exit();
}

if($type == "post")
header("location: post.php");
exit();
?>

<script>
history.go(-1);
</script>
