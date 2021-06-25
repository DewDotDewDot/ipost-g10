<?php
include_once("database.php");

if (!isset($_SESSION["user_type"]))
{
  header("location: index.php");
  exit();
}

$username = $_POST['username'];

if($result = $sql->query("SELECT id FROM tbl_users WHERE username = '$username'")) {

  while($row = $result->fetch_assoc()) {

      $id = $row['id'];
      $locationString = "location: profile.php?id=". $id;
      header($locationString);

  }
}
?>

<script>
alert("No username found");
history.go(-1);
</script>
