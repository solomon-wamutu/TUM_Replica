<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$student_id = $_SESSION['student_id'];

$sel = "SELECT count(*) FROM `student`";
$stmt = $mysqli->prepare($sel);
$stmt->execute();
$stmt->bind_result($iBClients);
$stmt->fetch();
$stmt->close();

$sel = "SELECT count(*) FROM `ib_staff`";
$stmt = $mysqli->prepare($sel);
$stmt->execute();
$stmt->bind_result($iBStaff);
$stmt->fetch();
$stmt->close();

$sel = "SELECT count(*) FROM `ib_acc_types`";
$stmt = $mysqli->prepare($sel);
$stmt->execute();
$stmt->bind_result($iB_AccType);
$stmt->fetch();
$stmt->close();

$sel = "SELECT count(*) FROM `ib_bankaccounts`";
$stmt = $mysqli->prepare($sel);
$stmt->execute();
$stmt->bind_result($iB_Accs);
$stmt->fetch();
$stmt->close();

$student_id = $_SESSION['student_id'];
$sel = "SELECT SUM(transaction_amt) FROM `ib_transactions` WHERE student_id = ? AND tr_type = 'Deposit'";
$stmt = $mysqli->prepare($sel);
$stmt->bind_param('i', $student_id);
$stmt->execute();
$stmt->bind_result($iB_deposits);
$stmt->fetch();
$stmt->close();

$student_id = $_SESSION['student_id'];
$sel = "SELECT SUM(transaction_amt) FROM `ib_transactions` WHERE `student_id` = ? AND tr_type = 'Withdrawal'";
$stmt = $mysqli->prepare($sel);
$stmt->bind_param('i', $student_id);
$stmt->execute();
$stmt->bind_result($iB_withdrawal);
$stmt->fetch();
$stmt->close();

$student_id = $_SESSION['student_id'];
$sel = "SELECT SUM(transaction_amt) FROM `ib_transactions` WHERE `student_id` = ? AND tr_type = 'Transfers'";
$stmt = $mysqli->prepare($sel);
$stmt->bind_param('i',$student_id);
$stmt->execute();
$stmt->bind_result($iB_Transfers);
$stmt->fetch();
$stmt->close();

$student_id = $_SESSION['student_id'];
$sel = "SELECT SUM(transaction_amt) FROM `ib_transactions` WHERE `student_id` = ?";
$stmt = $mysqli->prepare($sel);
$stmt->bind_param('i', $student_id);
$stmt->execute();
$stmt->bind_result($acc_amt);
$stmt->fetch();
$stmt->close();

$TotalBalInAccount = (($iB_deposits)) - (($iB_Transfers)+($iB_withdrawal));

$student_id = $_SESSION['student_id'];
$sel = "SELECT SUM(transaction_amt) FROM `ib_transactions` WHERE `student_id` = ?";
$stmt = $mysqli -> prepare($sel);
$stmt ->bind_param('i', $student_id);
$stmt ->execute();
$stmt->bind_result($new_amt);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("dist/_partials/head.php"); ?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

  <div class="wrapper">
<?php include("dist/_partials/nav.php"); ?>
<?php include("dist/_partials/sidebar.php"); ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Client Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!--iBank Deposits -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-upload"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Deposits</span>
                  <span class="info-box-number">
                    Kshs. <?php echo $iB_deposits; ?>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-download"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Withdrawals</span>
                  <span class="info-box-number">Kshs. <?php echo $iB_withdrawal; ?> </span>
                </div>
              </div>
            </div>
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-random"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Transfers</span>
                  <span class="info-box-number">Kshs. <?php echo $iB_Transfers; ?></span>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-money-bill-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Wallet Balance</span>
                  <span class="info-box-number">Kshs. <?php echo $TotalBalInAccount; ?></span>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title">Advanced Analytics</h5>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="chart">
                        <div id="PieChart" class="col-md-6" style="height: 400px; max-width: 500px; margin: 0px auto;"></div>
                      </div>
                    </div>
                    <hr>
                    <div class="col-md-6">
                      <div class="chart">
                        <div id="AccountsPerAccountCategories" class="col-md-6" style="height: 400px; max-width: 500px; margin: 0px auto;"></div>
                      </div>
                    </div>

                  </div>
                </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-sm-3 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">Kshs. <?php echo $iB_deposits; ?></h5>
                        <span class="description-text">TOTAL DEPOSITS</span>
                      </div>
                    </div>
                    <div class="col-sm-3 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">Kshs. <?php echo $iB_withdrawal; ?></h5>
                        <span class="description-text">TOTAL WITHDRAWALS</span>
                      </div>
                    </div>
                    <div class="col-sm-3 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">Kshs. <?php echo $iB_Transfers; ?> </h5>
                        <span class="description-text">TOTAL TRANSFERS</span>
                      </div>
                    </div>
                    <div class="col-sm-3 col-6">
                      <div class="description-block">
                        <h5 class="description-header">Kshs. <?php echo $new_amt; ?> </h5>
                        <span class="description-text">TOTAL MONEY IN  Account</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Latest Transactions</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div><!-- Log on to codeastro.com for more projects! -->
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover m-0">
                      <thead>
                        <tr>
                          <th>Transaction Code</th>
                          <th>Account No.</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Acc. Owner</th>
                          <th>Timestamp</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $student_id = $_SESSION['student_id'];
                        $ret = "SELECT * FROM ib_transactions WHERE  student_id = ?  ORDER BY ib_transactions. created_at DESC ";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $student_id);
                        $stmt->execute(); //ok
                        $res = $stmt->get_result();
                        $cnt = 1;
                        while ($row = $res->fetch_object()) {
                          $transTstamp = $row->created_at;
                          if ($row->tr_type == 'Deposit') {
                            $alertClass = "<span class='badge badge-success'>$row->tr_type</span>";
                          } elseif ($row->tr_type == 'Withdrawal') {
                            $alertClass = "<span class='badge badge-danger'>$row->tr_type</span>";
                          } else {
                            $alertClass = "<span class='badge badge-warning'>$row->tr_type</span>";
                          }
                        ?>
                          <tr>
                            <td><?php echo $row->tr_code; ?></a></td>
                            <td><?php echo $row->account_number; ?></td>
                            <td><?php echo $alertClass; ?></td>
                            <td>Kshs. <?php echo $row->transaction_amt; ?></td>
                            <td><?php echo $row->client_name; ?></td>
                            <td><?php echo date("d-M-Y h:m:s ", strtotime($transTstamp)); ?></td>
                          </tr>

                        <?php } ?>

                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer clearfix">
                  <a href="pages_transactions_engine.php" class="btn btn-sm btn-info float-left">View All</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
   <?php include("dist/_partials/footer.php"); ?>

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="dist/js/demo.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>

  <!-- PAGE SCRIPTS -->
  <script src="dist/js/pages/dashboard2.js"></script>

  <!--Load Canvas JS -->
  <script src="plugins/canvasjs.min.js"></script>
  <!--Load Few Charts-->
  <script>
    window.onload = function() {

      var Piechart = new CanvasJS.Chart("PieChart", {
        exportEnabled: false,
        animationEnabled: true,
        title: {
          text: "Accounts Per Acc Types "
        },
        legend: {
          cursor: "pointer",
          itemclick: explodePie
        },
        data: [{
          type: "pie",
          showInLegend: true,
          toolTipContent: "{name}: <strong>{y}%</strong>",
          indexLabel: "{name} - {y}%",
          dataPoints: [{
              y: <?php
                  //return total number of accounts opened under savings acc type
                  $student_id = $_SESSION['student_id'];
                  $result = "SELECT count(*) FROM iB_bankAccounts WHERE  acc_type ='Savings' AND student_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $student_id);
                  $stmt->execute();
                  $stmt->bind_result($savings);
                  $stmt->fetch();
                  $stmt->close();
                  echo $savings;
                  ?>,
              name: "Savings Acc",
              exploded: true
            },

            {
              y: <?php
                  //return total number of accounts opened under  Retirement  acc type
                  $student_id  = $_SESSION['student_id'];
                  $result = "SELECT count(*) FROM iB_bankAccounts WHERE  acc_type =' Retirement' AND student_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $student_id);
                  $stmt->execute();
                  $stmt->bind_result($Retirement);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Retirement;
                  ?>,
              name: " Retirement Acc",
              exploded: true
            },

            {
              y: <?php
                  //return total number of accounts opened under  Recurring deposit  acc type
                  $student_id  = $_SESSION['student_id'];
                  $result = "SELECT count(*) FROM iB_bankAccounts WHERE  acc_type ='Recurring deposit' AND student_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $student_id);
                  $stmt->execute();
                  $stmt->bind_result($Recurring);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Recurring;
                  ?>,
              name: "Recurring deposit Acc ",
              exploded: true
            },

            {
              y: <?php
                  //return total number of accounts opened under  Fixed Deposit Account deposit  acc type
                  $student_id  = $_SESSION['student_id'];
                  $result = "SELECT count(*) FROM iB_bankAccounts WHERE  acc_type ='Fixed Deposit Account' AND student_id = ? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $student_id);
                  $stmt->execute();
                  $stmt->bind_result($Fixed);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Fixed;
                  ?>,
              name: "Fixed Deposit Acc",
              exploded: true
            },

            {
              y: <?php

                  //return total number of accounts opened under  Current account deposit  acc type
                  $student_id  = $_SESSION['student_id'];
                  $result = "SELECT count(*) FROM iB_bankAccounts WHERE  acc_type ='Current account' AND student_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $student_id);
                  $stmt->execute();
                  $stmt->bind_result($Current);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Current;
                  ?>,
              name: "Current Acc",
              exploded: true
            }
          ]
        }]
      });

      var AccChart = new CanvasJS.Chart("AccountsPerAccountCategories", {
        exportEnabled: false,
        animationEnabled: true,
        title: {
          text: "Transactions"
        },
        legend: {
          cursor: "pointer",
          itemclick: explodePie
        },
        data: [{
          type: "pie",
          showInLegend: true,
          toolTipContent: "{name}: <strong>{y}%</strong>",
          indexLabel: "{name} - {y}%",
          dataPoints: [{
              y: <?php
                  //return total number of transactions under  Withdrawals
                  $student_id  = $_SESSION['student_id'];
                  $result = "SELECT count(*) FROM iB_Transactions WHERE  tr_type ='Withdrawal' AND student_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $student_id);
                  $stmt->execute();
                  $stmt->bind_result($Withdrawals);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Withdrawals;
                  ?>,
              name: "Withdrawals",
              exploded: true
            },

            {
              y: <?php
                  //return total number of transactions under  Deposits
                  $student_id  = $_SESSION['student_id'];
                  $result = "SELECT count(*) FROM iB_Transactions WHERE  tr_type ='Deposit' AND student_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $student_id);
                  $stmt->execute();
                  $stmt->bind_result($Deposits);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Deposits;
                  ?>,
              name: "Deposits",
              exploded: true
            },

            {
              y: <?php
                  //return total number of transactions under  Deposits
                  $student_id  = $_SESSION['student_id'];
                  $result = "SELECT count(*) FROM iB_Transactions WHERE  tr_type ='Transfer' AND student_id =? ";
                  $stmt = $mysqli->prepare($result);
                  $stmt->bind_param('i', $student_id);
                  $stmt->execute();
                  $stmt->bind_result($Transfers);
                  $stmt->fetch();
                  $stmt->close();
                  echo $Transfers;
                  ?>,
              name: "Transfers",
              exploded: true
            }

          ]
        }]
      });
      Piechart.render();
      AccChart.render();
    }

    function explodePie(e) {
      if (typeof(e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
        e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
      } else {
        e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
      }
      e.chart.render();

    }
  </script>

</body>

</html>