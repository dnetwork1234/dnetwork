<?php
require 'db_config.php';
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item">
      <a href="welcome.php" class="nav-link"><i class="fas fa-home"></i></a>
    </li>

  </ul>



  <!-- SEARCH FORM -->
  <form class="form-inline" action="accounts.php" method="post" style=" margin: 0 auto;
    display: inline-block;">
    <div class="input-group input-group-sm">
      <input class="form-control form-control-navbar" type="text" name="searchAccount" id="searchAccount" placeholder="Search" aria-label="Search" required>
      <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
  </form>

  <!-- Right navbar links -->
  <ul class="navbar-nav">
    <li>
      <a class="nav-link" href="requests.php">
        <i class="far fa-user"></i>
        <span class="badge badge-primary navbar-badge">
          <?php
            session_start();
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM follow
            INNER JOIN user
            ON follow.u_id=user.user_id
            where follow.u_id='$user_id' and is_accepted='0'";
            $result = mysqli_query($con, $sql);
            $num = mysqli_num_rows($result);
            echo $num;
          ?>
        </span>
      </a>
    </li>
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">3</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
            <img src="../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Brad Diesel
                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">Call me whenever you can...</p>
              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>
          <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
            <img src="../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                John Pierce
                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">I got your message bro</p>
              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>
          <!-- Message End -->
        </a>

      </div>
    </li>
    <!-- Notifications Dropdown Menu -->


  </ul>
</nav>

<!-- /.navbar -->