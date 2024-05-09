
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #153448; position: sticky; top: 0;">
  <!-- Left navbar links -->
  <ul class="navbar-nav" style="color: white;">
    <li class="nav-item">
      <a class="nav-link" style="color: white;" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="dashboard.php" class="nav-link" style="color: white;">Bureau of Jail Management and Penology</a>
    </li>
  </ul>


  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto" >
    <li class="nav-item" >
      <a class="nav-link" style="color: white;" data-toggle="dropdown" href="#"><i class="fa-solid fa-user"></i> 
      <?php echo $_SESSION['name']; ?>
     </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="dropdown-divider"></div>
        <a href="profile.php" class="dropdown-item">
        <i class="fa-solid fa-user mr-2"></i> profile
        </a>
        <div class="dropdown-divider"></div>
        <a href="changepassword.php" class="dropdown-item">
        <i class="fa-solid fa-gear mr-2"></i>password 
        </a>
        <div class="dropdown-divider"></div>
        <a href="logout.php" class="dropdown-item">
          <i class="fa-solid fa-right-from-bracket mr-2"></i> logout 
        </a>
      </div>
    </li>
  </ul>
</nav>
    <!-- /.navbar -->