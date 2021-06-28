<?php
  include_once("database.php");

  if(!isset($_SESSION["user_type"]))
  {
    header("location: login.php");
    exit();
  }

  elseif ($_SESSION["user_type"] === 1 || $_SESSION["user_type"] === "admin")
  {
    $_SESSION['not_register'] = true;
    header("location: adminindex.php");
    exit();
  }

  elseif ($_SESSION["user_type"] === 0 || $_SESSION["user_type"] === "user")
  {
    header("location: post.php");
    exit();
  }
 ?>
