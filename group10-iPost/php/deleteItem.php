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

$id = $_GET['id'];
$type = $_GET['type'];

if ($type == "post") {
  $query = "DELETE from tbl_feed WHERE id = '$id'";
}

if ($type == "user") {
  $query = "DELETE from tbl_users WHERE id = '$id'";
}

$sql->query($query);

if($_SESSION['user_id'] == $id) {
  header("location: logout.php");
  exit();
}

header("location: adminindex.php");
exit();
?>
