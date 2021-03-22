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
            <h1 class="m-0 text-dark">Update Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Update Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
      <div class="container-fluid">
        <?php 
        if(isset($_SESSION['msg'])){
              echo $_SESSION['msg'];
              unset($_SESSION['msg']);
            }
        ?>
        <div class="card card-info card-outline">
            <div class="card-body">
                <form class="form-horizontal" action="con_add_edit_detail.php?uid=<?php echo $user_id ?>" method="post" enctype="multipart/form-data">

                  <?php
                      $sql = "SELECT * FROM user WHERE user_id=$user_id;";
                      $result = mysqli_query($con,$sql);
                      $row = mysqli_fetch_assoc($result);
                  ?>

                       <div class="form-group row">
                        <label class="col-sm-2 col-form-label">First Name :</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" name="fname" placeholder="Enter First name" value="<?php echo $row['fname'] ?>">
                        </div>
                      </div>
                       <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Last Name :</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" name="lname" placeholder="Enter Last name" value="<?php echo $row['lname'] ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Mobile No. :</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="inputName" name="mobile_no" value="<?php echo $row['mobile_no'] ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Date of Birth :</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" id="inputName" name="date_of_birth"value="<?php echo $row['date_of_birth'] ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Age :</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="inputName" name="age"value="<?php echo $row['age'] ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Gander :</label>
                        <div class="col-sm-10">
                          <input type="radio" name="gender" value="Male" <?php if(isset($row) && $row['gender']=='Male') { echo "checked"; } ?>> Male<br>
                          <input type="radio" name="gender" value="Female" <?php if(isset($row) && $row['gender']=='Female') { echo "checked"; } ?>> Female<br>
                          <input type="radio" name="gender" value="Other" <?php if(isset($row) && $row['gender']=='Other') { echo "checked"; } ?>> Other
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Branch :</label>
                        <div class="col-sm-10">
                          <select name="branch">
                            <option value="Computer">Computer</option>
                            <option value="Civil">Civil</option>
                            <option value="Mechanical">Mechanical</option>
                            <option value="Electrical">Electrical</option>
                            <option value="E.C.">E.C.</option>
                          </select>
                        </div>
                      </div>
                       <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Location :</label>
                        <div class="col-sm-10">
                           <select name="current_location">
                            <option value="Rajkot">Rajkot</option>
                            <option value="Morbi">Morbi</option>
                            <option value="Surat">Surat</option>
                            <option value="Surendra nagar">Surendra nagar</option>
                            <option value="Ahmedabad">Ahmedabad</option>
                            <option value="Jamnagar">Jamnagar</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Education :</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" name="education"value="<?php echo $row['education'] ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Skills :</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" name="skills"value="<?php echo $row['skills'] ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="postfile">Upload Profile Picture</label>
                        <span class="description">(if any)</span>
                        <input type="file" class="form-control" name="postfile" id="postfile">
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
                          <button type="submit" class="btn btn-outline-info">Submit</button>
                        </div>
                      </div>
                    </form>
                </div>
              </div>
            </div>
        </section>
     </div>
  <!-- /.content-wrapper -->
  </div>
<!-- ./wrapper -->
<?php
  require("parts/footer.php");
?>
</body>
</html>