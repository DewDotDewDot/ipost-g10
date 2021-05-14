<?php
  include_once("database.php");
  session_destroy();
  header("location: index.php");
  exit();
 ?>
