<?php
  include_once("database.php");
  if (!isset($_SESSION["user_type"]) || !isset($_GET['id']))
  {
    header("location: index.php");
    exit();
  }

  $id = $_GET['id'];

  if (isset($_GET['privSet'])) {
    $privSet = ($_GET['privSet'] == 0) ? 1 : 0;
    $query = "UPDATE tbl_users SET `privacy` = '$privSet' WHERE `id` = '$id'";
    $sql->query($query);

    header("location: editProfileForm.php?id=" . $id);
    exit();
  }

  if(isset($_GET['passChange'])) {

    $passQuery = "SELECT password from tbl_users WHERE id = '$id'";
    $result = $sql->query($passQuery);
    while($row = $result->fetch_assoc()) {
       $tmp_check_pass = $row['password'];
    }

    if (password_verify($_POST['oldPass'], $tmp_check_pass)) {
      if ($_POST['newPass'] == $_POST['confPass']) {
        $newPass = password_hash($_POST['newPass'], PASSWORD_DEFAULT);
        $query = "UPDATE tbl_users SET `password` = '$newPass' WHERE `id` = '$id'";
        $sql->query($query);
        $_SESSION['alertMessage'] = "Password succesfully changed";
      } else {
        $_SESSION['alertMessage'] = "Password confirmation is incorrect";
      }
    } else {
      $_SESSION['alertMessage'] = "Current password is incorrect";
    }

    header("location: editProfileForm.php?id=" . $id);
    exit();
  }

  $tmp_username = $_POST['username'];
  $tmp_fname = $_POST['fname'];
  $tmp_lname = $_POST['lname'];
  $tmp_email = $_POST['email'];
  $tmp_birthdate = date('Y-m-d',strtotime($_POST['birthdate']));
  $tmp_sex = $_POST['sex'];


  $query = "UPDATE tbl_users SET `username` = '$tmp_username', `fname` = '$tmp_fname', `lname` = '$tmp_lname', `sex` = '$tmp_sex', `email` = '$tmp_email', `birthdate` = '$tmp_birthdate' WHERE `id` = '$id'";
  $sql->query($query);
  $_SESSION['user_name'] = $tmp_username;
  header("location: editProfileForm.php?id=" . $id);
  exit();
?>
