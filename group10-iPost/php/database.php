<?php
  $source_db = "ipostdb";
  $sql = new mysqli("localhost","root","",$source_db);
  $sql_p = mysqli_connect("localhost","root","",$source_db);
  session_start();

   $_SESSION["siteName"] = "IPOST";

   //test if push works
?>
