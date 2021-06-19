<?php
  include_once("database.php");
  if (isset($_SESSION["user_type"]) || !isset($_POST["loginForm"]))
  {
    header("location: index.php");
    exit();
  }

  $listEmptyVars = [];
  foreach ($_POST as $key => $value)
  {
    $_POST[$key] = trim($value);
    $listEmptyVars[$key] = empty($_POST[$key]);
  }

  if (in_array(true, $listEmptyVars, true))
  {
    $errorString = "ERROR: EMPTY VALUES FOUND\\nThe following fields were found empty:\\n";
    foreach ($listEmptyVars as $key => $value)
    {
      if($value)
      {
        $errorString .= "\\n".ucfirst($key);
      }
    }
    $errorString .= "\\n\\nLogin Failed";

    $_SESSION["alert_err"] = $errorString;
    header("location: login.php");
    exit();
  }

  else
  {
    $existingUsernames = [];
    if($result = $sql->query("SELECT * FROM tbl_users"))
    {
      while($row = $result->fetch_assoc())
      {
        $existingUsernames[] = $row["username"];
      }
    }

    if(!in_array($_POST["username"], $existingUsernames))
    {
      $errorString = "ERROR: This username is not registered or wrong password.\\n\\nLogin Failed.";

      $_SESSION["alert_err"] = $errorString;
      header("location: login.php");

    }
    else
    {
      extract($_POST, EXTR_PREFIX_ALL, "form");
      if($result = $sql->query("SELECT * FROM tbl_users WHERE username = '$form_username'"))
      {
        while($row = $result->fetch_assoc())
        {
          if(password_verify($form_password, $row["password"]))
          { //check the user type
            $userType = ($row["user_type"] == 1) ? "admin":"user";
            $_SESSION["user_type"] = $userType;
            $_SESSION["user_name"] = $form_username;
            $_SESSION["user_id"] = $row["id"];



            header("location: index.php");
            exit();

          }

          else
          {
            $errorString = "ERROR: Passwords do not match.\\n\\nLogin Failed.";


            $_SESSION["alert_err"] = $errorString;
            header("location: login.php");
            exit();
          }
        }
      }
    }
  }
?>
