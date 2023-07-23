<?php
session_start();
include('conf/config.php'); 
if (isset($_POST['login'])) {
  $adm = $_POST['adm'];
  $password = sha1(md5($_POST['password'])); 
  $stmt = $mysqli->prepare("SELECT adm, password, student_id  FROM student  WHERE adm=? AND password=?");
  $stmt->bind_param('ss', $adm, $password);
  $stmt->execute(); 
  $stmt->bind_result($adm, $password, $student_id); 
  $rs = $stmt->fetch();
  $_SESSION['student_id'] = $student_id;
  $uip=$_SERVER['REMOTE_ADDR'];
  $ldate=date('d/m/Y h:i:s', time());
  if ($rs) { 
    $success = "successfully logged in";
    header("location:pages_dashboard.php");
    
  } else {
    // echo "<script>alert('Access Denied Please Check Your Credentials');</script>";
    $err = "Access Denied Please Check Your Credentials";
  }
}
$ret = "SELECT * FROM `ib_systemsettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($auth = $res->fetch_object()) {
 ?>

<!DOCTYPE html>
  <html>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <?php include("dist/_partials/head.php"); ?>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <p><?php echo $auth->sys_name; ?></p>
      </div>
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Log In To Start Session</p>

          <form method="post">
            <div class="input-group mb-3">
              <input type="adm" name="adm" class="form-control" placeholder="adm">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
              <div class="col-4">
                <button type="submit" name="login" class="btn btn-success btn-block">Log In</button>
              </div>
            </div>
          </form>



           <p class="mb-1">
            <a href="pages_reset_pwd.php">I forgot my password</a>
          </p> 


          <p class="mb-0">
            <a href="pages_client_signup.php" class="text-center">Register a new account</a>
          </p>

        </div>
      </div>
    </div>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/j/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>

  </body>

  </html>
  <?php
}
?>