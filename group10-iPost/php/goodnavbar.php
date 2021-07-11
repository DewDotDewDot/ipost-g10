<?php
include_once("database.php");
?>
<style>
  .navbar navbar-expand-lg navbg {
    background-color: #000000;
  }
</style>
<nav class="navbar navbar-expand-lg navbg ">
  <div class="container-fluid">
    <a class="navbar-brand  text-reset text-decoration-none" href="index.php">IPOST</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if(ISSET($_SESSION['user_type']) && $_SESSION['not_register']) { ?>
        <li>
          <a class="nav-link active text-reset text-decoration-none" aria-current="page" href="profile.php?id=<?php echo $_SESSION['user_id'] ?>">Profile</a>
        </li>
       <li> <!-- Needs CSS. Search Bar for users-->
         <form action="searchUser.php" method="post">
           <input type="text" name="username" required>
           <input type="submit" value="Find User">
         </form>
       </li>
       <li class="nav-item">
        <a class="nav-link active  text-reset text-decoration-none" aria-current="page" href="logout.php">Log-out</a>
      </li>
      <?php }
        $_SESSION['not_register'] = true;
      ?>
      </ul>
    </div>
  </div>
</nav>
