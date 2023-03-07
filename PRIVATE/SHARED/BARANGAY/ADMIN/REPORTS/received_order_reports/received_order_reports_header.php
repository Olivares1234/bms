<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>BMS - <?php echo $page_title; ?></title>
    <script src="../../../js/chart/chart.min.js"></script>
    <script src="../../../js/vue/vue.js"></script>
    <link rel="shortcut icon"  href="../../../images/logo.png?v=<?php echo time(); ?>">
    <link href="../../../js/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link rel="stylesheet" href="../../../js/datetimepicker/bootstrap-datetimepicker.min.css" />
    <link href="../../../css/styles.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link href="../../../js/fontawesome-free-5.8.1-web/css/all.min.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../../css/sweetalert.min.css?v=<?php echo time(); ?>">
    <script src="../../../js/sweet_alert/sweetalert.js?v=<?php echo time(); ?>"></script>
    <script src="../../../js/axios/axios.min.js?v=<?php echo time(); ?>"></script>
    <style>
      [v-cloak] > * { display:none; }
      [v-cloak]::before { 
        content: "\00a0\00a0\00a0\00a0\00a0Loading...";
        display: block;
        width: 16px;
        height: 16px;
        background-image: url('data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==');
        position: absolute;
        top: 25%;
        left: 60%;
        margin: -60px 0px 0px -60px;
      }
      .edit {
        display: none;
      }
      .editing .edit {
        display: inline-block
      }
      .editing .view {
        display: none;
        overflow: hidden
       }
    </style>

</head>

<body class="hold-transition">

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right position-fixed" id="sidebar-wrapper">
      <div class="sidebar-heading">
        <a href="#" class="navbar-left text-dark"><img class="mx-auto d-block" src="../../../images/logo.png" id="logo"></a>
      </div>
      <div class="list-group list-group-flush">
        <a href="<?php echo url_for('pages/barangay/admin/dashboard.php')?>" class="list-group-item list-group-item-action bg-light text-dark font-weight-bold">
          <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <a href="<?php echo url_for('pages/barangay/admin/user.php')?>" class="list-group-item list-group-item-action bg-light text-dark font-weight-bold">
          <i class="fas fa-user"></i> User
        </a>      

        <a href="<?php echo url_for('pages/barangay/admin/request_order.php')?>" class="list-group-item list-group-item-action bg-light text-dark font-weight-bold">
          <i class="fas fa-shopping-cart">&nbsp;</i> Request Order
        </a>

        <li class="list-group list-group-flush" id="dropdown-menu">
          <a href="#medicineSubMenu" data-toggle="collapse" aria-expanded="false" class="list-group-item list-group-item-action bg-light text-dark dropdown-container font-weight-bold">
            <i class="fas fa-chart-bar">&nbsp;</i> Reports
            <i class="fa fa-caret-down" style="float: right;padding-right: 8px; margin-top: 4px;"></i>
          </a>

            <ul class="collapse list-unstyled" id="medicineSubMenu">
              <li class="list-group-item">
                <a href="<?php echo url_for('pages/barangay/admin/distributed_reports.php')?>" class="dropdown-item bg-light text-dark font-weight-bold">Distributed Report
                </a>
              </li>

              <li class="list-group-item">
                <a href="<?php echo url_for('pages/barangay/admin/best_medicine_reports.php')?>" class="dropdown-item bg-light text-dark font-weight-bold">Best Medicines Report
                </a>
              </li>

              <li class="list-group-item">
                <a href="<?php echo url_for('pages/barangay/admin/best_beneficiary_reports.php')?>" class="dropdown-item bg-light text-dark font-weight-bold">Best Beneficiaries Report
                </a>
              </li>

              <li class="list-group-item">
                <a href="<?php echo url_for('pages/barangay/admin/request_order_reports.php')?>" class="dropdown-item bg-light text-dark font-weight-bold">Requests Order Report
                </a>
              </li>

              <li class="list-group-item">
                <a href="<?php echo url_for('pages/barangay/admin/received_order_reports.php')?>" class="dropdown-item bg-light text-dark font-weight-bold">Received Order Report
                </a>
              </li>
            </ul>
        </li>   

      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-success border-bottom sticky-top">
        <button class="btn btn-outline-light btn-sm" id="menu-toggle">Hide Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link text-light" href="<?php echo url_for('pages/barangay/admin/dashboard.php')?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light"><i class="fas fa-building"></i> <?php echo $barangay_name; ?></a>
            </li>
            <li class="nav-item dropdown">
              <a class="btn nav-link dropdown-toggle text-light pt-1" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top: 1.5px;">
                <i class="fas fa-user"></i> <?php echo "<span class='user-name'>" . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "</span>"?>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="<?php echo url_for('pages/barangay/admin/profile.php')?>">See Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../../../../public/api's/login/logout.php">Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
     
        
      

  <script src="../../../js/jquery-1-11-3/jquery-1.11.3.min.js"></script>
   <script src="../../../js/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../../js/router/vue-router.js"></script>
  <script src="../../../js/vue-bootstrap/vuebootstrap.js"></script>
  <script src="../../../js/moment/moment.min.js"></script> 
  <script src="../../../js/datetimepicker/bootstrap-datetimepicker.min.js"></script>
  <script src="../../../js/jspdf/jspdf.min.js"></script> 
  <script src="../../../js/jspdf/jspdf.plugin.autotable.min.js"></script>
  
  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
      if(e.target.innerText == "Show Menu") {
        e.target.innerText = "Hide Menu";
        document.getElementById("page-content-wrapper").style.marginLeft = "15rem";
      }
      else {
        e.target.innerText = "Show Menu";
        document.getElementById("page-content-wrapper").style.marginLeft = "0";
      }
    });
  </script>

  