<?php
  include_once("database.php");


  $validData = [];
  $existingUsernames = [];
  $existingEmails = [];
  if($result = $sql->query("SELECT * FROM tbl_users;"))
  {
    while($row = $result->fetch_assoc())
    {
      $existingUsernames[] = $row["username"];
      $existingEmails[] = $row["email"];
    }
  }

  $validData["the_username_is_already_exists"] = in_array($_POST["username"], $existingUsernames);
  $validData["the_email_is_already_registered"] = in_array($_POST["email"], $existingEmails);
  $validData["the_password_less_than_8_characters"] = (strlen($_POST["password"]) < 8);
  $validData["the_passwords_is_not_match"] = (strcmp($_POST["password"],$_POST["password_confirm"])!==0);

  if(in_array(true, $validData))
    {
      foreach ($validData as $key => $value)
      {
        if($value)
        {
          $errorString .= "\\n".str_replace("_"," ",ucfirst($key));
        }
      }
      $errorString .= "\\n\\nRegistration Error!";
      $_SESSION["alert_err"] = $errorString;

      if ($_SESSION["user_type"] == 1) {
        header("location: adminindex.php");
        exit();
      }

      header("location: register.php");
      exit();
    }
    else
    {
      extract($_POST, EXTR_PREFIX_ALL, "form");
      $form_birthdate = date('Y-m-d',strtotime($form_birthdate));
      $form_userType = ($form_userType == "admin") ? 1:0;
      $form_password = password_hash($form_password, PASSWORD_DEFAULT);
      $queryString = "INSERT INTO tbl_users(fname, lname, birthdate,  email, sex, username, password, user_type)
      VALUES ('$form_firstName','$form_lastName', '$form_birthdate','$form_email','$form_sex','$form_username', '$form_password','$form_userType')";
      $sql->query($queryString);
      $successString = "Registration Successfully Completed! \\n Please log in with your credentials. Welcome to iPost";
      $_SESSION["alert_success"] = $successString;

      if ($_SESSION["user_type"] == 1) {
        header("location: adminindex.php");
        exit();
      }
      header("location: index.php");
      exit();
    }


?>
