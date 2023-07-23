<?php 
session_start();
include('./conf/config.php');
if(isset($_POST['reset_password'])){
    $error = 0;
    if(isset($_POST['adm']) && !empty($_POST['adm'])){
        $adm = mysqli_real_escape_string($mysqli, trim($_POST['adm']));
    }
    else{
    $error = 1;
    $err = "Enter your adm address";
    }
     
    if(!filter_var($_POST['adm'], FILTER_VALIDATE_EMAIL)){
        $err = "Invalid adm address";
    }
    $checkadm = mysqli_query($mysqli, "SELECT `adm` FROM `student` WHERE `adm` = '" . $_POST['adm'] . "'") or exit(mysqli_error($mysqli));

    if (mysqli_num_rows($checkadm) > 0) {

        $n = date('y');
        $new_password = bin2hex(random_bytes($n));
        //Insert Captured information to a database table
        $query = "UPDATE student SET  password=? WHERE adm =?";
        $stmt = $mysqli->prepare($query);
        //bind paramaters
        $rc = $stmt->bind_param('ss', $new_password, $adm);
        $stmt->execute();
        $_SESSION['adm'] = $adm;
    
        if ($stmt) {
          /* Alert */
          $success = "Confim Your Password" && header("refresh:1; url=pages_confirm_password.php");
        } else {
          $err = "Password reset failed";
        }
      } else  // user does not exist
      {
        $err = "adm Does Not Exist";
      }
}

$sel = "SELECT * FROM `ib_systemsettings`";
$stmt = $mysqli->prepare($sel);
$stmt->execute();
$res = $stmt->get_result();
while ($auth = $res->fetch_object()) {
    ?>
<!DOCTYPE html>
  <html>
  <?php include("dist/_partials/head.php"); ?>
<body class="hold-transition login-page">
    
<div class="login-box">
      <div class="login-logo"> 
        <p><?php echo $auth->sys_name; ?> - <?php echo $auth->sys_tagline; ?></p>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

                    <form method="POST">
            <div class="input-group mb-3">
              <input type="text" name="adm" class="form-control" placeholder="adm" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <button type="submit" name="reset_password" class="btn btn-success btn-block">Request new password</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
          <p class="mt-3 mb-1">
            <a href="pages_client_index.php">Login</a>
          </p>

        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html>

<?php
}
?> 