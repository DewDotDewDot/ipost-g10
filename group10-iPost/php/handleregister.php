<?php
  include_once("database.php");
  if(!isset($_POST["registerForm"]) || isset($_SESSION["user_type"]))
  {
    header("location: index.php");
    exit();
  }

  $debugMode = false;
  $listEmptyVars = [];
  foreach ($_POST as $key => $value)
  {
    $_POST[$key] = trim($_POST[$key]);
    $listEmptyVars[$key] = empty($_POST[$key]);
  }

  if($debugMode)
  {
    echo "<a href='register.php'>Go back to form</a>";
    echo "<h1>Form Data</h1>";
    foreach ($_POST as $key => $value)
    {
      echo "<h2>".$key." = ".$value."</h2>";
    }
    var_dump($_POST);

    echo "<h1>List of empty variables</h1>";
    echo "<h3> 1 = empty, none = full.</h3>";
    foreach ($listEmptyVars as $key => $value)
    {
      echo "<h2>".$key." => ".$value."</h2>";
    }
    var_dump($listEmptyVars);

    if(in_array(true, $listEmptyVars, true))
    {
      $errorString = "ERROR: MISSING DATA\\nThe following fields were found empty:\\n";
      foreach ($listEmptyVars as $key => $value)
       {
        if($value)
        {

          $errorString .= "\\n".str_replace("_"," ",ucfirst($key));
        }
      }
      $errorString .= "\\n\\n\\nRegistration Failed";

    }

    else
    {
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
      $validData["username_is_already_registered"] = in_array($_POST["username"], $existingUsernames);
      $validData["email_is_already_registered"] = in_array($_POST["email"], $existingEmails);
      $validData["password_less_than_8_characters"] = (strlen($_POST["password"]) < 8);
      $validData["given_passwords_do_not_match"] = (strcmp($_POST["password"],$_POST["password_confirm"])!==0);

      if(in_array(true, $validData)){
        $errorString = "ERROR: INVALID DATA\\nThe localhost returned the following errors:\\n";
        foreach ($validData as $key => $value)
        {
          if($value)
          {
            $errorString .= "\\n".str_replace("_"," ",ucfirst($key));
          }
        }
        $errorString .= "\\n\\n\\nRegistration Failed";
      }
      else
      {
        extract($_POST, EXTR_PREFIX_ALL, "form");
        $form_userType = ($form_userType === "admin") ? 1:0;
        $form_password = password_hash($form_password, PASSWORD_DEFAULT);
        var_dump(get_defined_vars());
        $queryString = "INSERT INTO tbl_users(fname, lname, email, gender, username, password, user_type)
        VALUES ('$form_firstName','$form_lastName', '$form_email','$form_sex','$form_username','$form_password','$form_userType')";
        $successString = "Registration Successfully Completed!";
      }
    }
  }

  else
  {
    if(in_array(true, $listEmptyVars, true))
    {
      $errorString = "ERROR: Missing Data\\nThe following fields are found empty:\\n";
      foreach ($listEmptyVars as $key => $value)
      {
        if($value)
        {
          $errorString .= "\\n".str_replace("_"," ",ucfirst($key));
        }
      }
      $errorString .= "\\n\\n\\nRegistration Failed";

      $_SESSION["alert_err"] = $errorString;
      header("location: register.php");
      exit();
   }

  else
  {
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
        header("location: register.php");
        exit();
      }
      else
      {
        extract($_POST, EXTR_PREFIX_ALL, "form");
        echo $form_userType;
        $form_birthdate = date('Y-m-d',strtotime($form_birthdate));
        $form_userType = ($form_userType == "admin") ? 1:0;
        $form_password = password_hash($form_password, PASSWORD_DEFAULT);
        $queryString = "INSERT INTO tbl_users(fname, lname, email, birthdate, sex, username, password, user_type)
        VALUES ('$form_firstName','$form_lastName', '$form_birthdate','$form_email','$form_sex','$form_username', '$form_password','$form_userType')";
        $sql->query($queryString);
        $successString = "Registration Successfully Completed! \\n Please log in with your credentials. Welcome to iPost";
        $_SESSION["alert_success"] = $successString;
        header("location: login.php");
        exit();
      }
    }
  }
?>
