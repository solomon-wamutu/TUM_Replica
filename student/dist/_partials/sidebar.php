<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <?php
  $student_id = $_SESSION['student_id'];
  $ret = "SELECT * FROM  student  WHERE student_id = ? ";
  $stmt = $mysqli->prepare($ret);
  $stmt->bind_param('i', $student_id);
  $stmt->execute(); //ok
  $res = $stmt->get_result();
  while ($row = $res->fetch_object()) {
      $profile_picture = "<img src='../admin/dist/img/user_icon.png' class=' elevation-2' alt='User Image'>
                ";
    $ret = "SELECT * FROM `ib_systemsettings` ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($sys = $res->fetch_object()) {
  ?>

      <a href="pages_dashboard.php" class="brand-link">
        <img src="../admin/dist/img/<?php echo $sys->sys_logo;?>" alt="iBanking Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo $sys->sys_name;?></span>
      </a>

      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <?php echo $profile_picture; ?>
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $row->name; ?></a>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item has-treeview">
              <a href="pages_dashboard.php" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard

                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages_account.php" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                  Account
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-briefcase"></i>
                <p>
                  iBank Accounts
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages_open_acc.php" class="nav-link">
                    <i class="fas fa-lock-open nav-icon"></i>
                    <p>Open iBank Acc</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_manage_acc_openings.php" class="nav-link">
                    <i class="fas fa-cog nav-icon"></i>
                    <p>My iBank Accounts</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-dollar-sign"></i>
                <p>
                  Finances
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages_deposits.php" class="nav-link">
                    <i class="fas fa-upload nav-icon"></i>
                    <p>Deposits</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_withdrawals.php" class="nav-link">
                    <i class="fas fa-download nav-icon"></i>
                    <p>Withdrawals</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_transfers.php" class="nav-link">
                    <i class="fas fa-random nav-icon"></i>
                    <p>Transfers</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="pages_view_client_bank_acc.php" class="nav-link">
                    <i class="fas fa-money-bill-alt nav-icon"></i>
                    <p>Balance Enquiries</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header">Advanced Modules</li>
            <li class="nav-item">
              <a href="pages_transactions_engine.php" class="nav-link">
                <i class="nav-icon fas fa-exchange-alt"></i>
                <p>
                  Transactions History
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                <p>
                  Finacial Reports
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages_financial_reporting_deposits.php" class="nav-link">
                    <i class="fas fa-file-upload nav-icon"></i>
                    <p>Deposits</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_financial_reporting_withdrawals.php" class="nav-link">
                    <i class="fas fa-cart-arrow-down nav-icon"></i>
                    <p>Withdrawals</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_financial_reporting_transfers.php" class="nav-link">
                    <i class="fas fa-random nav-icon"></i>
                    <p>Transfers</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="pages_logout.php" class="nav-link">
                <i class="nav-icon fas fa-power-off"></i>
                <p>
                  Log Out
                </p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
</aside>
<?php
    }
  } ?>