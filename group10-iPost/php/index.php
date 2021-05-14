<?php
  include_once("database.php");

  if(!isset($_SESSION["user_type"]))
  {
    header("location: login.php");
    exit();
  }

  elseif ($_SESSION["user_type"] === "admin") 
  {
    header("location: listofusers.php");
    exit();
  }

  elseif ($_SESSION["user_type"] === "user") 
  {
    header("location: Post.php");
    exit();
  }
 ?>
