<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>BMS - <?php echo $page_title; ?></title>
  <script src="../../../js/vue/vue.js"></script>
  <link href="../../../js/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet">
  <link href="../../../css/styles.css?v=<?php echo time(); ?>" rel="stylesheet">
  <link href="../../../js/fontawesome-free-5.8.1-web/css/all.min.css?v=<?php echo time(); ?>" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../../../css/sweetalert.min.css?v=<?php echo time(); ?>">
  <script src="../../../js/sweet_alert/sweetalert.js?v=<?php echo time(); ?>"></script>
  <script src="../../../js/axios/axios.min.js?v=<?php echo time(); ?>"></script>
  
  <style>
    [v-cloak] > * { 
      display:none 
    }
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
    span.number {
      font-size: 14px;
      justify-content: center;
      align-items: center;
      width: 25px;
      height: 25px;
      border: 1px solid #fff;
      border-radius: 50px;
      display: inline-block;
      padding-top: 1px;
      padding-left: 1px;
      color: #000;
      list-style-type: none;
    }
    span.title {
      display: inline-block;
      margin-left: 5px; 
      color: #000;
      list-style-type: none;
    }
    .nav-link.active {
      background-color: #117a8b !important;
    }
  </style>

</head>

<body class="hold-transition">

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right position-fixed" id="sidebar-wrapper">
      <div class="sidebar-heading">
        <a href="#" class="navbar-left text-dark"><img class="mx-auto d-block" src="../../../images/logo.jpg" id="logo"></a>
      </div>
      <div class="list-group list-group-flush">
        <a href="<?php echo url_for('pages/city_hall/registration_staff/dashboard.php')?>" class="list-group-item list-group-item-action bg-light text-dark font-weight-bold"><i class="fas fa-tachometer-alt">&nbsp;</i> Dashboard</a>

        <li class="list-group list-group-flush">
          <a href="#beneficiarySubMenu" data-toggle="collapse" aria-expanded="false" class="list-group-item list-group-item-action bg-light text-dark dropdown-container font-weight-bold">
            <i class="fas fa-users"></i> Beneficiary
            <i class="fa fa-caret-down" style="float: right;padding-right: 8px; margin-top: 4px;"></i>
          </a>

            <ul class="collapse list-unstyled" id="beneficiarySubMenu">

              <li class="list-group-item">
                <a style="text-align: center;" class="dropdown-item bg-light text-dark font-weight-bold" href="<?php echo url_for("pages/city_hall/registration_staff/4P's.php")?>">4P's</a>
              </li>

              <li class="list-group-item">
                <a href="<?php echo url_for("pages/city_hall/registration_staff/pwd.php")?>" style="text-align: center;" class="dropdown-item bg-light text-dark font-weight-bold" href="">PWD</a>
              </li>

              <li class="list-group-item">
                <a href="<?php echo url_for("pages/city_hall/registration_staff/senior.php")?>" style="text-align: center;" class="dropdown-item bg-light text-dark font-weight-bold" href="">Senior</a>
              </li>

              <li class="list-group-item">
                <a style="text-align: center;" class="dropdown-item bg-light text-dark font-weight-bold" href="">Indigent</a>
              </li>

            </ul>
        </li>
        <a href="<?php echo url_for('pages/city_hall/registration_staff/transfer.php')?>" class="list-group-item list-group-item-action bg-light text-dark font-weight-bold"><i class="fas fa-tachometer-alt">&nbsp;</i> Transfer Beneficiary</a>
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
              <a class="nav-link text-light" href="<?php echo url_for('pages/city_hall/registration_staff/dashboard.php')?>"><i class="fas fa-tachometer-alt"></i> Dashboard<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link text-light"><i class="fas fa-building"></i> City Hall</a>
            </li>
            <li class="nav-item dropdown">
              <a class="btn nav-link dropdown-toggle text-light pt-1" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top: 1.5px;">
                <i class="fas fa-user"></i> <?php echo "<span class='user-name'>" . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "</span>"?>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="<?php echo url_for('pages/city_hall/registration_staff/profile.php')?>">See Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../../../../public/api's/login/logout.php">Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
     
        
      

  <script src="../../../js/jquery/jquery.min.js"></script>
  <script src="../../../js/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../../js/router/vue-router.js"></script>
  
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

  