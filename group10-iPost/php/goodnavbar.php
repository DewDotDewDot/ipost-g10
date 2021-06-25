<?php
include_once("database.php");
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">IPOST</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if(ISSET($_SESSION['user_type'])) { ?>
        <li>
          <a class="nav-link active" aria-current="page" href="profile.php?id=<?php echo $_SESSION['user_id'] ?>">Profile</a>
        </li>
       <li> <!-- Needs CSS. Search Bar for users-->
         <form action="searchUser.php" method="post">
           <input type="text" name="username" required>
           <input type="submit" value="Find user">
         </form>
       </li>
       <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="logout.php">Log-out</a>
      </li>
      <?php } ?>
      </ul>
    </div>
  </div>
</nav>
