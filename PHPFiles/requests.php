<?php 
    require 'parts/db_config.php';
    include 'parts/css_js.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Projects</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar --><?php
  include 'parts/navbar.php';
  include 'parts/sidebar.php';?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Connection Requests</li>
              
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Connection Requests</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 20%">
                          Connection Name
                      </th>
                      <th style="width: 40%">
                          Profile Picture
                      </th>
                      <th style="width: 20%" align="center">
                      Actions
                      </th>
                  </tr>
              </thead>
              <tbody>

                <?php 
                $user_id = $_SESSION['user_id'];
                    $sql = "SELECT * FROM follow
                    INNER JOIN user
                    ON follow.user_id=user.user_id
                    where follow.u_id='$user_id' and is_accepted='0'";
                    $result=mysqli_query($con,$sql);
                    $num = mysqli_num_rows($result);
                    // echo $sql;
                    while($row=mysqli_fetch_assoc($result)){
                        $uid = $row['user_id'];
                        $sql4 = "SELECT * FROM follow where u_id='$uid'";
                        $result4=mysqli_query($con,$sql4);
                        $num4 = mysqli_num_rows($result4);
                        $row4=mysqli_fetch_assoc($result4);
                        // echo $sql4;

                        ?>
                        <tr>
                      <td>
                        <?php echo $num?>
                      </td>
                      <td>
                          <a>
                              <?php echo $row['fname'].' '.$row['lname']?>
                          </a>
                          <br/>
                          <small>
                            <?php echo $row['created_on']?>
                          </small>
                      </td>
                      <td>
                          <ul class="list-inline">
                              <li class="list-inline-item">
                              <?php
                        $sql7 = "SELECT * from user where user_id='$uid'";
                        $result7 = mysqli_query($con, $sql7);
                        $row7 = mysqli_fetch_assoc($result7); ?>
                        <img class="img-fluid img-circle img-sm" src="<?php if ($row7['profile_picture'] != null) {
                                                                        echo $row7['profile_picture'];
                                                                      } else {
                                                                        echo "../dist/img/avatar5.png";
                                                                      } ?>" alt="Alt Text">
                              </li>
                             
                          </ul>
                      </td>
                      
                      
                      <td class="project-actions text-left">
                          <!-- <a class="btn btn-primary btn-sm" href="notification.php">
                              <i class="fas fa-folder">
                              </i>
                              View Profile
                          </a> -->
                          <a class="btn btn-info btn-sm" href="con_requests.php?do=1&uid=<?php echo $row['user_id'];?>">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Accept
                          </a>
                          <a class="btn btn-danger btn-sm" href="con_requests.php?do=2&uid=<?php echo $row['user_id'];?>">
                              <i class="fas fa-trash">
                              </i>
                              Delete
                          </a>
                      </td>
                  </tr>
                   <?php }?>
                
                
                  
              </tbody>
              
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
