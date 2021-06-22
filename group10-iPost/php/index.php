<?php
  include_once("database.php");

  if(!isset($_SESSION["user_type"]))
  {
    header("location: login.php");
    exit();
  }

  elseif ($_SESSION["user_type"] === 1)
  {
    header("location: adminindex.php");
    exit();
  }

  elseif ($_SESSION["user_type"] === 0)
  {
    header("location: post.php");
    exit();
  }
 ?>
