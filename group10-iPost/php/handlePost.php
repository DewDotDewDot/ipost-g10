<?php
  include_once("database.php");
  if (!isset($_SESSION["user_type"]))
  {
    header("location: index.php");
    exit();
  }

  $type = $_GET['type'];

  if ($type == "post") {

    $maxQuery = "SELECT max(id) FROM tbl_feed";
    $execMaxQuery =  $sql->query($maxQuery);
    while ($result = $execMaxQuery->fetch_assoc()) {
      $post_id = 1 + $result['max(id)'];
    }


    $targetDirectory = "../img_assets/posts/";
        if(!empty($_FILES["feed_pic"])){

            $fileName = $_FILES["feed_pic"]["name"];
            $check = getimagesize($_FILES["feed_pic"]["tmp_name"]);
            if ($check) {
                echo "File is an image!";
                $newFileName = $post_id . $fileName;
                $destination = $targetDirectory . $newFileName;
                echo "<h2>Destination: $destination</h2>";

                $upload = move_uploaded_file($_FILES["feed_pic"]["tmp_name"], $destination);
                if ($upload) {
                    echo "<h2> Upload was successful! </h2>";

                }
                else {
                    echo "<h4>Uh-oh! Something went wrong </h4>";
                }
            }
            else {
                echo "<h4>File is NOT an image!</h4>";
            }
        }

    $tmp_feed_title = $_POST['title'];
    $tmp_feed_content = $_POST['feedPost'];
    $tmp_user_id = $_SESSION['user_id'];
    $query = "INSERT INTO tbl_feed (user_id, header, image, content) VALUES ('$tmp_user_id', '$tmp_feed_title', '$newFileName', '$tmp_feed_content')";
  } elseif ($type == "comment") {
    $tmp_post_id = $_GET['post_id'];
    $tmp_comment = $_POST['comment'];
    $tmp_user_id = $_SESSION['user_id'];
    $query = "INSERT INTO tbl_comments (post_id, user_id, comment) VALUES ('$tmp_post_id', '$tmp_user_id', '$tmp_comment')";
  }
  $execQuery = mysqli_query($sql, $query);

?>

<script>
//history.go(-1);
</script>
