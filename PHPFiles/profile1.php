<?php 
  session_start();
  error_reporting(0);
  $uid = $_GET['uid'];
  $user_id=$_SESSION['user_id'];
  
  include 'parts/db_config.php';
  $username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile | DNetwork</title>
  <?php
    require("parts/css_js.php");
  ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php
    require("parts/navbar.php");
    require("parts/sidebar.php");
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profile </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<?php 
  $sql = "SELECT * FROM user where user_id='$uid' and verification_status=1";
   $result=mysqli_query($con,$sql);
    $row=mysqli_fetch_assoc($result);
    ?>
    
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-success card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="../dist/img/user4-128x128.jpg" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $row['fname'].' '.$row['lname']?></h3>

                <p class="text-muted text-center"><?php echo $row['branch']?></p>

                <?php 
                
                $sql9 = "SELECT * from follow where user_id='$user_id' or u_id='$user_id'";
                  $result9=mysqli_query($con,$sql9);
                  $num9 = mysqli_num_rows($result9);
                ?>


                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Connections</b> <a class="float-right"><?php echo $num9;?></a>
                  </li>
                 
                </ul><?php
                //if(!isset($_GET['me'])){

                
                  $sql1 = "SELECT * FROM FOLLOW WHERE user_id='$user_id' and u_id='$uid'";
                  $result1=mysqli_query($con,$sql1);
                  $row1=mysqli_fetch_assoc($result1);
                  $num1 = mysqli_num_rows($result1);


                  $sql2 = "SELECT * FROM FOLLOW WHERE user_id='$user_id' and u_id='$uid' and is_accepted='0'";
                  $result2=mysqli_query($con,$sql2);
                  $row2=mysqli_fetch_assoc($result2);
                  $num2 = mysqli_num_rows($result2);


                  $sql3 = "SELECT * FROM FOLLOW WHERE user_id='$user_id' and u_id='$uid' and is_accepted='1'";
                  $result3=mysqli_query($con,$sql3);
                  $row3=mysqli_fetch_assoc($result3);
                  $num3 = mysqli_num_rows($result3);

                  $sql4 = "SELECT * FROM FOLLOW WHERE user_id='$uid' and u_id='$user_id' and is_accepted='1'";
                  $result4=mysqli_query($con,$sql4);
                  $row4=mysqli_fetch_assoc($result4);
                  $num4 = mysqli_num_rows($result4);

                  $sql5 = "SELECT * FROM FOLLOW WHERE user_id='$uid' and u_id='$user_id' and is_accepted='0'";
                  $result5=mysqli_query($con,$sql5);
                  $row5=mysqli_fetch_assoc($result5);
                  $num5 = mysqli_num_rows($result5);

                  if(isset($_GET['me'])){?>
                    <a href="update_profile.php?uid=<?php echo $uid?>" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                  <?php
                  }
                  else{
                    if($num4==1){
                      $_SESSION['unfollow'] = "1";?>
                      
                        <a href="con_follow.php?uid=<?php echo $uid?>" class="btn btn-secondary btn-block"><b>Disconnect</b></a>
                      <?php
                    }
                    else{
                      if($num1==0){
                        if($num5==1){?>
                        <a href="con_requests.php?do=1&uid=<?php echo $row['user_id'];?>&from=1" class="btn btn-primary btn-block"><b>Accept</b></a>
                        <?php
                        }
                        else{?>
                          <a href="con_follow.php?uid=<?php echo $uid?>" class="btn btn-success btn-block"><b>Connect</b></a>
                          <?php
                        }
                        ?>
                        
                      <?php 
                    
                    }
                      else if($num2==1){
                        $_SESSION['pending'] = "1";
                      ?>
                        <a href="con_follow.php?uid=<?php echo $uid?>" class="btn btn-secondary btn-block"><b>Pending</b></a>
                      <?php }
                      else if($num3==1){
                        $_SESSION['unfollow'] = "1";?>
                          <a href="con_follow.php?uid=<?php echo $uid?>" class="btn btn-secondary btn-block"><b>Disconnect</b></a>
                        <?php }
                    }
                  } 
                ?>
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                <?php echo $row['education'];?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted"><?php echo $row['current_location'];?></p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger"><?php echo $row['skills'];?></span>
                </p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
                  <?php 
                  $sql5 = "SELECT * FROM post where user_id='$uid'";
                  $result5=mysqli_query($con,$sql5);
                  $num5 = mysqli_num_rows($result5);
                  if($num5>=1){
                      while($row5=mysqli_fetch_assoc($result5)){
                  ?>


              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post --><?php
                    $sql1 = "SELECT * from post INNER JOIN post_file ON post.post_id=post_file.post_id  where user_id='$uid'";
                      $result1=mysqli_query($con,$sql1);
                      // echo $sql1;
                      $num1 = mysqli_num_rows($result1);
                      // echo $num1;
                      while($row1=mysqli_fetch_assoc($result1)){
                        $pid=$row1['post_id'];?>
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username">
                          <a href="#"><?php 
                            $sql2 = "SELECT * from user where user_id='$uid'";
                            $result2=mysqli_query($con,$sql2);
                            $row2=mysqli_fetch_assoc($result2);
                            echo $row2['fname'].' '.$row2['lname'];?></a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description"><?php echo $row5['created_on'];?></span>
                        
                      </div>
                      
                      <!-- /.user-block -->
                      <p><?php
                      

                      
                      echo $row1['post_desc'];
                      ?>
                      </p>
                      <center><div><img class="img-fluid pad" width="50%" src="<?php echo $row1['file_path'];?>" alt="Photo"></div></center>
                      <p>
                        <br>
                      <?php 
                          $sql7 = "SELECT * FROM likes where post_id='$pid' and u_id='$user_id'";
                          $result7=mysqli_query($con,$sql7);
                          $num7 = mysqli_num_rows($result7);
                          // echo $num7;
                          // echo $sql7;
                          if($num7>=1){?>
                            <button type="button" class="btn btn-default btn-sm" onclick="window.location='con_like.php?pid=<?php echo $pid?>&userid=<?php echo $user_id; ?>&from=profile&from=1&uid=<?php echo $uid; ?>'"><i class="far fa-thumbs-down"></i> Dislike</button>
                            <?php
                          }
                          else{?>
                            <button type="button" class="btn btn-default btn-sm" onclick="window.location='con_like.php?pid=<?php echo $pid?>&userid=<?php echo $user_id; ?>&from=profile&do=1&from=1&uid=<?php echo $uid; ?>'"><i class="far fa-thumbs-up"></i> Like</button>
                            <?php
                          }
                      ?>
                        
                        <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Share</button>
                          <span class="float-right text-muted"><?php
                          $sql8 = "SELECT * FROM likes where post_id='$pid'";
                          $result8=mysqli_query($con,$sql8);
                          $num8 = mysqli_num_rows($result8);
                          //  echo $sql8;
                            echo $num8;?> likes - <?php 
                          
                            $sql6 = "SELECT * from comments where post_id='$pid'";
                              $result6=mysqli_query($con,$sql6);
                              $row6 = mysqli_fetch_assoc($result6);
                              $num6 = mysqli_num_rows($result6);
                              echo $num6;
                          
                          ?> comments</span>
                      </p>
                      <div class="card-footer card-comments"><?php
                          $sql7 = "SELECT * from comments where post_id='$pid'";
                          $result7=mysqli_query($con,$sql7);
                          
                          // echo $sql7;
                          $num7 = mysqli_num_rows($result7);
                          while($row7=mysqli_fetch_assoc($result7))
                          {?>
                            <div class="comment-text">
                              <span class="username">
                                <?php 
                                
                                echo $row2['fname'].' '.$row2['lname'];
                                ?>
                                <span class="text-muted float-right"><?php echo $row7['created_on'];?></span>
                              </span><!-- /.username -->
                              <?php 
                              
                              // echo $sql5;
                              echo $row7['description'];
                              ?>
                            </div>
                            <!-- /.comment-text -->
                            
                            <?php
                          }?>
                          </div>
                      <div class="card-footer">
                  <form action="con_comment.php?uid=<?php echo $fid; ?>&pid=<?php echo $pid;?>&from=profile" method="post">
                    <img class="img-fluid img-circle img-sm" src="../dist/img/user4-128x128.jpg" alt="Alt Text">
                    <!-- .img-push is used to add margin to elements next to floating images -->
                    <div class="img-push">
                      <input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment" name="comment">
                      <input class="btn btn-info btn-sm" type="submit" value="Enter">
                    </div>
                  </form>
                </div>   
                      <!-- <input class="form-control form-control-sm" type="text" placeholder="Type a comment" name="comment"> -->
                    </div>
                  <?php
                  }?>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Mobile No.</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="inputName" name="mobile_no">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Date of Birth</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" id="inputName" name="date_of_birth">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Age</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="inputName" name="age">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Gander</label>
                        <div class="col-sm-10">
                          <input type="radio" name="gender" value="Male">  Male
                          <input type="radio" name="gender" value="Female">  Female
                          <input type="radio" name="gender" value="Other">  Other
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Branch</label>
                        <div class="col-sm-10">
                          <select name="branch">
                            <option value="computer">Computer</option>
                            <option value="civil">Civil</option>
                            <option value="mechanical">Mechanical</option>
                            <option value="electrical">Electrical</option>
                            <option value="ec">E.C.</option>
                          </select>
                        </div>
                      </div>
                      <!-- <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div> -->
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
              <?php 
              }
            }
              ?>
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<?php
  require("parts/footer.php");
?>
<div class="loader"></div>
</body>
</html>