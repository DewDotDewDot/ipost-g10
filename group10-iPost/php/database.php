<?php
  $source_db = "ipostdb";
  $sql = new mysqli("localhost","root","",$source_db);
  $sql_p = mysqli_connect("localhost","root","","finalsdb");
  session_start();

   $_SESSION["siteName"] = "IPOST";

?>