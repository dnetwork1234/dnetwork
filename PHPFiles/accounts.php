<?php 
require 'parts/db_config.php';
include 'parts/css_js.php';
error_reporting(0);
session_start();
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Contacts</title>
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
  <!-- Navbar -->
  <?php include 'parts/navbar.php';?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'parts/sidebar.php';?>



  <?php 
  
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>List of Accounts</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Contacts</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row d-flex align-items-stretch">
            <?php 
            $searchAccount = $_POST['searchAccount'];
            $sql = "SELECT * FROM user where username like '$searchAccount%' and verification_status=1 and user_id!='$user_id'";
            $result=mysqli_query($con,$sql);
            $num = mysqli_num_rows($result);
            
            if($num>=1){
                while($row=mysqli_fetch_assoc($result)){
                ?>
                    <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch">
                      <div class="card bg-light">
                          
                          <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-12 text-center" style="margin-top: 25px;">
                                  <img src="../dist/img/user1-128x128.jpg" alt="" class="img-circle img-fluid">
                                </div>
                            </div>
                              <div class="card-header text-muted border-bottom-0" style="margin-top:10px;">
                                  <h2 class="lead" style="margin-bottom: 0px;text-align:center;"><b><?php echo $row["fname"]." ".$row["lname"];?></b></h2>
                              </div>
                              <div class="card-header text-muted border-bottom-0">
                                  <p style="text-align:center;margin-bottom:0px"><?php echo $row["username"];?></p>
                              </div>
                          </div>
                          <div class="card-footer">
                              <div class="text-right">
                                  <a href="#" class="btn btn-sm bg-teal">
                                  <i class="fas fa-comments"></i> Message
                                  </a>
                                  <a href="profile.php?uid=<?php echo $row['user_id']?>" class="btn btn-sm btn-primary">
                                  <i class="fas fa-user"></i> View Profile
                                  </a>
                              </div>
                          </div>
                      </div>
                    </div><?php
            }
        }
        else
        {
            echo "No such records.";
        }
            ?>
            
          </div>
        </div>
        <!-- /.card-body -->
        <!-- <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">4</a></li>
              <li class="page-item"><a class="page-link" href="#">5</a></li>
              <li class="page-item"><a class="page-link" href="#">6</a></li>
              <li class="page-item"><a class="page-link" href="#">7</a></li>
              <li class="page-item"><a class="page-link" href="#">8</a></li>
            </ul>
          </nav>
        </div> -->
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include 'parts/footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>$(window).on("load",function(){
     $(".loader-wrapper").fadeOut("slow");
});</script>
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
