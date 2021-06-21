<?php
include_once("database.php");

try {
  if ($_SESSION["user_type"] == 0)
  {
    header("location: index.php");
    exit();
  }
} catch(Exception $e){
  header("location: index.php");
  exit();
}
?>
  <div class="feed-itemsWrapper">
    <table>
      <tr>
        <th>
          Profile Picture
        </th>
        <th>
          Username
        </th>
        <th>
          User Type
        </th>
        <th>
          Delete User
        </th>
      </tr>
<?php
$query = "SELECT * from tbl_users";
if($result = $sql->query($query)):
  while($row = $result->fetch_assoc()):
      $tmp_profile_pic = $row["profile_pic"];
      $tmp_user_id = $row["id"];
      $tmp_username = $row["username"];
      $tmp_user_type = $row["user_type"];
    ?>

        <tr>
          <td>
            <div class="feed-item">
              <img src="<?php echo  "../img/$tmp_profile_pic"; ?>">
            </div>
          </td>
          <td>
            <div class="feed-item">
              <p><?php echo $tmp_username; ?><p>
            </div>
          </td>
          <td>
            <div class="post-content">
              <p><?php echo ($tmp_user_type = 0) ? "User" : "Admin"; ?></p>
            </div>
          </td>
          <td>
            <a href="deleteItem.php?id=<?php echo $tmp_user_id?>&type=user"><p>Delete</p></a>
          </td>
        </tr>
<?php
  endwhile;
endif;
?>
    </table>
  </div>
