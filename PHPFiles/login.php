<?php 
require 'parts/db_config.php';
session_start();
// for formal login by username and password
if($_SERVER['REQUEST_METHOD']=='POST'){
  
  $email = $_POST['email'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM user where email='$email' and verification_status=1";
  $result=mysqli_query($con,$sql);
  $num = mysqli_num_rows($result);
  if($num==1){
    while($row=mysqli_fetch_assoc($result)){
      if(password_verify($password, $row['password'])){
          session_start();
          
          $_SESSION['email'] = $email;
          $_SESSION['user_id'] = $row['user_id'];
          echo $_SESSION['user_id'];
          header('Location: welcome.php');
      } 
      else
      {
          echo "Invalid details. Please check your username and password.";
          // header('Location: login.php');
      }
    }
  }
  else{
    echo "Please Sign Up first and then verify the verification email sent to your email.";
  }
  
  
}

// for sign in with google

include('../vendor/config.php');
$login_button = '';

if(isset($_GET["code"]))
{
  $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
  if(!isset($token['error']))
  {
    $google_client->setAccessToken($token['access_token']);
    $_SESSION['access_token'] = $token['access_token'];
    $google_service = new Google_Service_Oauth2($google_client);
    $data = $google_service->userinfo->get();
    if(!empty($data['given_name']))
    {
    $_SESSION['user_first_name'] = $data['given_name'];
    }
    if(!empty($data['family_name']))
    {
    $_SESSION['user_last_name'] = $data['family_name'];
    }
    if(!empty($data['email']))
    {
      $_SESSION['user_email_address'] = $data['email'];
      $_SESSION['email'] = $data['email'];
      
    }
    if(!empty($data['gender']))
    {
    $_SESSION['user_gender'] = $data['gender'];
    }
    if(!empty($data['picture']))
    {
    $_SESSION['user_image'] = $data['picture'];
    }
      
  }
  if(!isset($_SESSION['access_token']))
  {
  $login_button = '<a href="'.$google_client->createAuthUrl().'">Login With Google</a>';
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page" style="background-image: url(bg.jpg);">
<div class="login-box">
  <div class="login-logo">
  <div><img src="dnetwork_logo.png" alt="DNetwork Logo" width="150px"></div>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    <!-- <center><h2><b>D</b>Network</h2></center> -->
      <p class="login-box-msg"><b>Login</b> to start your session</p>
      <P style="text-align:center"><?php if(isset($_SESSION['msg'])){
              echo $_SESSION['msg'];
              $_SESSION['msg']='';
            }?></p>
      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email Address">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <?php 
        $login_button = '<a class="btn btn-block btn-danger" href="'.$google_client->createAuthUrl().'"> <i class="fab fa-google mr-2"></i> Sign in using Google
        </a>';
        echo '<div align="center">'.$login_button . '</div>';?>
         
      </div>
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
      <hr>
      <p class="mb-0">
        
        <a href="signup.php" class="btn btn-block btn-success text-center">Create an Account</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

</body>

<!-- 187671256532-c9jj9o1uc5062jfcbrnr5dsqr8vr9pjj.apps.googleusercontent.com
     w27w8SWDw3-j0kL1dIImFzd2 -->