<?php
session_start();
error_reporting(0);
require 'parts/db_config.php';
$user_id = $_SESSION['user_id'];

// for sign in with google
include '../vendor/config.php';
$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];
$login_button = '';

if (isset($_GET["code"])) {
  $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
  if (!isset($token['error'])) {
    $google_client->setAccessToken($token['access_token']);
    $_SESSION['access_token'] = $token['access_token'];
    $google_service = new Google_Service_Oauth2($google_client);
    $data = $google_service->userinfo->get();

    if (!empty($data['family_name'])) {
      $_SESSION['user_last_name'] = $data['family_name'];
    }

    if (!empty($data['email'])) {
      $_SESSION['user_email_address'] = $data['email'];
      $googleemail = $data['email'];
      $sql = "SELECT * FROM user where email='$googleemail' and verification_status=1";
      $result = mysqli_query($con, $sql);
      $num = mysqli_num_rows($result);
      if ($num == 0) {
        $_SESSION['msg'] = "First signup.";
        header("Location: login.php");
      }
      $emailgoogle = $_SESSION['user_email_address'];
      $sql1 = "SELECT * FROM user where email='$emailgoogle'";
      $result1 = mysqli_query($con, $sql1);

      $row = mysqli_fetch_assoc($result1);
      $_SESSION['username'] = $row['username'];
      $_SESSION['user_id'] = $row['user_id'];
    }

    if (!empty($data['gender'])) {
      $_SESSION['user_gender'] = $data['gender'];
    }

    if (!empty($data['picture'])) {
      $_SESSION['user_image'] = $data['picture'];
    }
  }
}

if (!isset($_SESSION['access_token'])) {
  $login_button = '<a href="' . $google_client->createAuthUrl() . '">Login With Google</a>';
}

if (!empty($data['given_name'])) {
  $_SESSION['user_first_name'] = $data['given_name'];
}

if (!isset($_SESSION['email'])) {
  if (!isset($_SESSION['user_email_address'])) {
    $_SESSION['msg'] = "Something went wrong.";
    header("Location: login.php");
  }
}

// else{
//   $_SESSION['msg']="First signup.";
//   header("Location: login.php");
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home | DNetwork</title>
  <?php
  require "parts/css_js.php";
  ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    require "parts/navbar.php";
    require "parts/sidebar.php";
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
              <center><a href="add_post.php"><button type="button" class="btn btn-outline-secondary float-sm-right" style="width:100%;">Add Post</button></center>
            </div><!-- /.col -->
            <div class="col-sm-2">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="welcome.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->


      <!-- Small boxes (Stat box) -->
      <?php
      //select friends from follow table
      $sql = "SELECT * from follow where user_id='$user_id' or u_id='$user_id'";
      // echo $sql;
      ?>
      <section class="content">
        <?php
        $result = mysqli_query($con, $sql);
        $num = mysqli_num_rows($result);
        // echo $num;
        while ($row = mysqli_fetch_assoc($result)) 
        {
          if ($row['user_id'] != $_SESSION['user_id']) {
            $fid = $row['user_id'];
          } else {
            $fid = $row['u_id'];
          }
          // $fid2=$row['user_id'];

          //to get the post of his/her friends
          $sql1 = "SELECT * from post INNER JOIN post_file ON post.post_id=post_file.post_id  where  user_id='$fid' ORDER BY post.post_id DESC";
          $result1 = mysqli_query($con, $sql1);
          // echo $sql1;
          $num1 = mysqli_num_rows($result1);

          while ($row1 = mysqli_fetch_assoc($result1)) {
            $pid = $row1['post_id'];
            $fid = $row1['user_id'];
          ?>

            <div class="container-fluid">
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="card card-widget" style="border-radius: 15px;">
                    <div class="card-header">
                      <div class="user-block">
                        <?php
                        //to get the details of the user who posted the photo
                        $sql2 = "SELECT * from user where user_id='$fid'";
                        $result2 = mysqli_query($con, $sql2);
                        $row2 = mysqli_fetch_assoc($result2); ?>
                        <img class="img-circle" src="<?php if ($row2['profile_picture'] != null) {
                                                        echo $row2['profile_picture'];
                                                      } else {
                                                        echo "../dist/img/avatar5.png";
                                                      } ?>" alt="User Image">
                        <span class="username"><a href="profile.php?uid=<?php echo $fid;?>">
                        <?php
                            echo $row2['fname'] . ' ' . $row2['lname']; ?></a></span>
                        <span class="description"><?php echo $row1['created_on']; ?></span>
                      </div>
                      <!-- /.user-block -->
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button> -->
                      </div>
                      <!-- /.card-tools -->
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                      <p><?php echo $row1['post_desc']; ?></p>
                      <center>
                        <div><img class="img-fluid pad" width="400px" src="<?php echo $row1['file_path']; ?>" alt="Photo">
                        </div>
                      </center>
                      <br>

                                                        
                      <?php
                      //to find whether user like particular post or not.
                      $sql3 = "SELECT * FROM likes where post_id='$pid' and u_id='$user_id'";
                      $result3 = mysqli_query($con, $sql3);
                      $num3 = mysqli_num_rows($result3);
                      // echo $num3;
                      // echo $sql3;
                      if ($num3 >= 1) { ?>
                        <button type="button" class="btn btn-default btn-sm" onclick="window.location='con_like.php?pid=<?php echo $pid ?>&uid=<?php echo $fid; ?>&do=1'"><i class="far fa-thumbs-down"></i> Dislike</button>
                      <?php
                      } else { ?>
                        <button type="button" class="btn btn-default btn-sm" onclick="window.location='con_like.php?pid=<?php echo $pid ?>&uid=<?php echo $fid; ?>'"><i class="far fa-thumbs-up"></i> Like</button>
                      <?php
                      }
                      ?>

                      <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Share</button>
                      <span class="float-right text-muted"><?php
                      // to get the number of like and comment
                              $sql4 = "SELECT * FROM likes where post_id='$pid'";
                              $result4 = mysqli_query($con, $sql4);
                              $num4 = mysqli_num_rows($result4);
                              //  echo $sql4;
                              echo $num4; ?> likes - <?php

                              $sql6 = "SELECT * from comments where post_id='$pid'";
                              $result6 = mysqli_query($con, $sql6);
                              $row6 = mysqli_fetch_assoc($result6);
                              $num6 = mysqli_num_rows($result6);
                              echo $num6;

                              ?> comments</span>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer card-comments"><?php
                                                            $sql5 = "SELECT * from comments INNER JOIN user ON comments.u_id=user.user_id where post_id='$pid'";
                                                            // echo $sql5;
                                                            $result5 = mysqli_query($con, $sql5);
                                                            while ($row5 = mysqli_fetch_assoc($result5)) { ?>
                        <div class="card-comment">
                          <!-- User image -->
                          <img class="img-circle img-sm" src="<?php if ($row5['profile_picture'] != null) {
                                                                echo $row5['profile_picture'];
                                                              } else {
                                                                echo "../dist/img/avatar5.png";
                                                              } ?>" alt="User Image">
                          <?php
                          ?>
                          <div class="comment-text">
                            <span class="username">
                              <?php
                                                              echo $row5['fname'] . ' ' . $row5['lname'];
                              ?>
                              <span class="text-muted float-right"><?php echo $row5['created_on']; ?></span>
                            </span><!-- /.username -->
                            <?php

                                                              // echo $sql5;
                                                              echo $row5['description'];
                            ?>
                          </div>
                          <!-- /.comment-text -->
                        </div>
                      <?php
                                                            }
                      ?>

                      <!-- /.card-comment -->
                    </div>
                    <!-- /.card-footer -->
                    <div class="card-footer">
                      <form action="con_comment.php?uid=<?php echo $fid; ?>&pid=<?php echo $pid; ?>" method="post">
                        <?php
                        $sql7 = "SELECT * from user where user_id='$user_id'";
                        $result7 = mysqli_query($con, $sql7);
                        $row7 = mysqli_fetch_assoc($result7); ?>
                        <img class="img-fluid img-circle img-sm" src="<?php if ($row7['profile_picture'] != null) {
                                                                        echo $row7['profile_picture'];
                                                                      } else {
                                                                        echo "../dist/img/avatar5.png";
                                                                      } ?>" alt="Alt Text">
                        <!-- .img-push is used to add margin to elements next to floating images -->
                        <div class="img-push">
                          <div class="container">
                            <div class="row">
                              <div class="col-md-11">
                                <input type="text" class="form-control form-control-sm" style="width:100%" placeholder="Press enter to post comment" name="comment">
                              </div>
                              <div class="col-md-1"><input class="btn btn-outline-primary btn-sm" type="submit" value="Enter"></div>
                            </div>
                          </div>


                        </div>
                      </form>
                    </div>
                    <!-- /.card-footer -->
                  </div>

                </div>
                <div class="col-md-2"></div>
              <?php
            } ?>

            <?php
          }
            ?>
              </div>
      </section>

      <!-- /.row -->
      <!-- /.container-fluid -->

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  </div>
  <!-- ./wrapper -->
  <?php
  require "parts/footer.php";
  ?>
  <div class="loader"></div>
  <script>
    $(window).on("load", function() {
      $(".loader").fadeOut("slow");
    });
  </script>
</body>

</html>