<?php 
require 'parts/db_config.php';
use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
  
    require 'PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';
  
if($_SERVER['REQUEST_METHOD']=='POST')
{
  $exist = false;
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];


  $sql1 = "select * from user where email = '$email' OR username='$username'";
  $result1 = mysqli_query($con,$sql1);
  $num1 = mysqli_num_rows($result1);
  if($num1>0)
  {
      $exist = true;
  }
  else
  {
      $exist = false;
  }
  $verification_id=rand(111111111,999999999); // verification
  if(($password == $cpassword) && $exist==false)
  {
    $hash = password_hash($password,PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (username,fname,lname, email, password, age, mobile_no, date_of_birth, gender, education, skills,current_location, branch, created_on, updated_on,verification_status,verification_id) VALUES ('$username',NULL,NULL, '$email', '$hash', NULL, NULL, NULL, NULL,NULL,NULL,NULL, NULL, current_timestamp(), current_timestamp(),'0','$verification_id')";
    $result=mysqli_query($con,$sql);

    //for email verification
		
		
		$msg="We've just sent a verification link to <strong>$email</strong>. Please check your inbox and click on the link to get started. If you can't find this email (which could be due to spam filters), just request a new one here.";
		
		$mailHtml="Please confirm your account registration by clicking the button or link below: <a href='http://localhost/Shrey/DNetwork/PHPFiles/check_verification.php?id=$verification_id'>http://localhost/Shrey/DNetwork/PHPFiles/check_verification.php?id=$verification_id</a>";
		
		// smtp_mailer($email,'Account Verification',$mailHtml);

    // $vijayEmail='receiveremail@gmail.com';

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    
    
    
  
    // Load Composer's autoloader
    //require 'vendor/autoload.php';
  
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
  
    try {
        //Server settings
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'dnetworkverify@gmail.com';                     // SMTP username
        $mail->Password   = 'DNetwork@1234  ';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
  
        //Recipients
        $mail->setFrom('dnetworkverify@gmail.com', 'Verify Registration');
        $mail->addAddress($email);     // Add a recipient
        // $mail->addAddress($email);          // Name is optional
        // $mail->addReplyTo('vijayphpmailerdemo@gmail.com', 'PHP Mailer Demo');
        
        // $mail->addCC('bineetganatra1010@gmail.com');
        //$mail->addBCC('bcc@example.com');
  
        // Attachments
        // $mail->addAttachment($_FILES["fileToUpload"]["tmp_name"], $_FILES["fileToUpload"]["name"]);          // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
  
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Verify Your DNetwork Acount';
        $mail->Body    = $mailHtml;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  
        $mail->send();
        $_SESSION['msg'] = 'Message has been sent';
    } 
    catch (Exception $e) 
    {
        $_SESSION['msg'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
		
	}
  else
  {
    echo 'Account already exist.';
    // echo "<a href='login.php'>Go to Login</a>";
  }
}



  // header('Location: login.php');
  // }
  // else{
  //   header('Location: signup.php');
  // }       
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Page</title>

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
<div class="register-box">
  <div class="register-logo">
    <div><img src="dnetwork_logo.png" alt="DNetwork Logo" width="150px"></div>
    <!-- <b>D</b>Network -->
  </div>

  <div class="card">
    <div class="card-body register-card-body">
    <!-- <center><h2><b>D</b>Network</h2></center> -->
      <p class="login-box-msg"><b>Signup</b> to use DNetwork</p>

      <form action="signup.php" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name = "email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name = "username" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
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
        <div class="input-group mb-3" >
          <input type="password" class="form-control" name="cpassword" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
        <div class="col-4">
            <button type="submit" class="btn btn-block btn-danger text-center">Register</button>
          </div>
          </div>
          <div class="message">
            <?php
            if(isset($msg)){
              echo $msg;
            }
            
            ?>
		      </div>
      </form>

      <div class="social-auth-links text-center">
        <!-- <p>- OR -</p>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google mr-2"></i>
          Sign up using Google
        </a> -->
      </div>
      <hr>
      <a href="login.php" class="btn btn-block btn-success text-center">Already have an account?</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>
