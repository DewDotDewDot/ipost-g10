<div class="navbar-main">
  <nav class="navbg navbar">
    <ul>
      <?php if(!isset($_SESSION["user_type"])): ?>
        <li> <a href="index.php">IPOST</a> </li>
        <li> <a href="login.php">Login</a> </li>
        <li> <a href="register.php">Register</a> </li>
      <?php elseif($_SESSION["user_type"] === "user"): ?>
        <li> <a href="index.php">IPOST</a> </li>
        <li> <a href="profile.php">Profile</a> </li>
        <li class="sendRight"> <a href="logout.php">Log out</a> </li>
        <li>Welcome, <?php echo $_SESSION["user_name"]; ?></li>
      <?php elseif($_SESSION["user_type"] === "admin"): ?>
        <li> <a href="index.php">IPOST</a> </li>
        <li class="sendRight"> <a href="logout.php">Log out</a> </li>
      <?php endif; ?>
    </ul>
  </nav>
</div>
