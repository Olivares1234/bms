<?php include('../private/initialize.php'); ?>
<?php checkSession(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    <title>BMS - Barangay Login</title>
    <script src="js/chart/chart.min.js"></script>
    <script src="js/vue/vue.js?v=<?php echo time(); ?>"></script>
    <link href="js/css/responsive-slider.css" rel="stylesheet">
    <link rel="stylesheet" href="js/css/animate.css">
    <link rel="stylesheet" href="js/skin/default.css">
    <link rel="shortcut icon"  href="images/logo.png?v=<?php echo time(); ?>">
    <link href="js/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link rel="stylesheet" href="js/datetimepicker/bootstrap-datetimepicker.min.css" />
    <link href="css/styles.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link href="js/fontawesome-free-5.8.1-web/css/all.min.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/sweetalert.min.css?v=<?php echo time(); ?>">
    <script src="js/sweet_alert/sweetalert.js?v=<?php echo time(); ?>"></script>
    <script src="js/Axios/axios.min.js?v=<?php echo time(); ?>"></script>


    <style>
      body {
        background-color : #fff;
      }
      #search-transaction:hover, #search-transaction:focus, #search-transaction:active {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff; 
      }
      footer.footer {
        padding-top:4rem;padding-bottom:4rem
      }
      a.scrollup {
        height: 40px;
        width: 40px;
        color: #fff;
        font-size: 22px;
        line-height: 40px;
        text-align: center;
        text-decoration: none;
        position: fixed;
        bottom: 10px;
        right: 10px;
        z-index: 9999;
        opacity: 0.5;
      }

    </style>
  </head>

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top sticky-top">
    
    <a class="navbar-brand text-light" href="#" style="font-size: 23px"><img class="float-left mr-2" src="images/logo.png" id="main-logo">BMS</a>
    <div class="container">
      <a class="navbar-brand text-white"></a>
      <a class="btn btn-outline-light btn-sm" href="<?php echo url_for('login/index.php'); ?>">Sign In</a>
    </div>
  </nav>

  <!-- Masthead -->
  <header class="masthead text-light text-center">
    <div id="random" class="carousel slide" data-ride="carousel">

      <!-- Indicators -->
      <ul class="carousel-indicators">
        <li data-target="#random" data-slide-to="0" class="active"></li>
        <li data-target="#random" data-slide-to="1"></li>
        <li data-target="#random" data-slide-to="2"></li>
        <li data-target="#random" data-slide-to="3"></li>
      </ul>
      
      <!-- The slideshow -->
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="images/image2.jpg" width="1400" height="556">
          <div class="carousel-caption">
              <h3>Brgy. Pulo</h3>
              <p>Libreng gamot para sa mga mahihirap</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="images/image3.jpg" width="1400" height="556">
            <div class="carousel-caption">
              <h3>Brgy. Marinig</h3>
              <p>Libreng gamot para sa mga mahihirap</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="images/image1.jpg" width="1400" height="556">
            <div class="carousel-caption">
              <h3>Brgy. Mamatid</h3>
              <p>Libreng gamot para sa mga mahihirap</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="images/image4.jpg" width="1400" height="556">
            <div class="carousel-caption">
              <h3>Brgy. Gulod</h3>
              <p>Libreng gamot para sa mga mahihirap</p>
          </div>
        </div>
      </div>
      
      <!-- Left and right controls -->
      <a class="carousel-control-prev" href="#random" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#random" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    </div>
    <div id="vue-search">
      <div class="container">
        <div class="row">
          <div class="col-xl-12 mx-auto">
            <h2 class="mb-5 font-weight-bold">"Malakas na katawan, Magaling na kaisipan" <br>
              <center>God Bless!</center></h2>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <form>
              <div class="form-row">
                <div class="col-12 col-md-9 mb-2 mb-md-0">
                  <input type="text" v-model="search_beneficiary" class="form-control form-control-lg border" placeholder="Enter Beneficiary ID...">
                </div>
                <div class="col-12 col-md-3">
                  <button @click="saveBeneficiaryId" type="button" id="search-transaction" class="btn btn-block btn-lg btn-outline-light" >Search</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>

  <section id="section-about" class="mt-5 pb-5">
    <div class="container">
      <div class="about">
        <div class="row mar-bot40">
          <div class="col-md-offset-3 col-md-6">
            <div class="title">
              <div class="wow bounceIn">

                <h3 class="section-heading animated font-weight-bold" data-animation="bounceInUp">Yes to Health Program</h3>


              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">

          <div class="row-slider">
            <div class="col-lg-6 float-left">
              <div class="responsive-slider" data-spy="responsive-slider" data-autoplay="true">
                <div class="slides" data-group="slides">
                  <ul>

                    <div class="slide-body" data-group="slide">
                      <li><img alt="" class="img-responsive" src="images/image2.jpg" width="100%" height="350" /></li>
                      <li><img alt="" class="img-responsive" src="images/image1.jpg" width="100%" height="350" /></li>
                      <li><img alt="" class="img-responsive" src="images/image3.jpg" width="100%" height="350" /></li>

                    </div>
                  </ul>
                  <a class="carousel-control-prev" href="#" data-jump="prev"><span class="carousel-control-prev-icon"></span></a>
                  <a class="carousel-control-next" href="#" data-jump="next"><span class="carousel-control-next-icon"></span></a>

                </div>
              </div>
            </div>

            <div class="col-lg-6 float-right">
              <div>
                <h4 class="text-justify">Anu-ano ang benepisyo ng Yes to Health Program? <span></span></h4>
              </div>
              <div class="list-style">
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-xs-12">
                    <ul>
                      <li class="pb-2 text-justify">Ang maaaring maging miyembro ng Yes to Health Program ay ang Senior Citizens, PWDs, miyembro ng 4P's at indigent Cabuyeño families (mahihirap na pamilyang Cabuyeño).</li>
                      <li class="pb-2 text-justify">&#8369;10,000.00 kada taon ang kabuuang halaga ng makukuhang medical assistance sa ilalim ng Yes to Health Program.
                        <li class="pb-2 ml-4 text-justify" style="list-style-type: none;">
                          &#10004;  &nbsp;&#8369;10,000.00 kada taon ang maaaring makuha ng bawat miyembrong Senior Citizen o PWD.
                        </li>
                        <li class="pb-2 ml-4 text-justify" style="list-style-type: none;">
                          &#10004;  &nbsp;&#8369;10,000.00 kada taon para naman sa buong pamilya ng miyembrong mula sa indigent Cabuyeño families. Ito ay ang pinagsama-samang halaga ng medical assistance na natatanggap sa bawat miyembrong nakalista sa Medical Record Booklet ng miyembro ng Yes to Health Program mula sa kanilang pamilya.
                        </li>
                      </li>
                      
                    </ul>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>
  </section>
  <a href="#header" class="scrollup"><i class="fa fa-chevron-up"></i></a>

  <section id="section-map" class="clearfix mb-0">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3866.6851972342433!2d121.12215231431682!3d14.271572188882313!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d8628fb69d4b%3A0x1b912a86af127ae7!2sCabuyao%20City%20Hall!5e0!3m2!1sen!2sph!4v1568880492860!5m2!1sen!2sph" width="100%" height="380" frameborder="0" style="border:0" allowfullscreen></iframe>
  </section>


  <!-- Footer -->
  <footer class="footer bg-light p-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <ul class="list-inline mb-2">
            <li class="list-inline-item">
              <a href="#">About</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Contact</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Terms of Use</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Privacy Policy</a>
            </li>
          </ul>
          <p class="text-muted small mb-4 mb-lg-0">&copy; Boticab Management System 2019. All Rights Reserved.</p>
        </div>
        <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
          
            <ul class="list-inline mb-0">
              <li class="list-inline-item text-primary ml-5 mr-3">
                <a class="btn-floating btn-tw mx-1" href="">
                  <i class="fab fa-facebook-square"></i>
                </a>
              </li>
              <li class="list-inline-item mr-3">
                <a class="btn-floating btn-tw mx-1 text-info" href="">
                  <i class="fab fa-twitter"></i>
                </a>
              </li>
              <li class="list-inline-item mr-3">
                <a class="btn-floating btn-tw mx-1 text-danger" href="">
                  <i class="fab fa-google-plus-g"></i>
                </a>
              </li>
              <li class="list-inline-item mr-3">
                <a class="btn-floating btn-tw mx-1 text-danger" href="">
                  <i class="fab fa-youtube"></i>
                </a>
              </li>
            </ul>
          </div>
      </div>
      </div>
    </div>
  </footer>
  <script src="js/jquery/jquery.min.js"></script>
  <script src="js/bootstrap/js/bootstrap.min.js"></script>
  <script src="js/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  <script src="js/js/jquery.js"></script>
  <script src="js/js/jquery.easing.1.3.js"></script>
  <script src="js/js/jquery.isotope.min.js"></script>
  <script src="js/js/jquery.nicescroll.min.js"></script>
  <script src="js/js/fancybox/jquery.fancybox.pack.js"></script>
  <script src="js/js/skrollr.min.js"></script>
  <script src="js/js/jquery.scrollTo.js"></script>
  <script src="js/js/jquery.localScroll.js"></script>
  <script src="js/js/stellar.js"></script>
  <script src="js/moment/moment.min.js"></script> 
  <script src="js/datetimepicker/bootstrap-datetimepicker.min.js"></script>
  <script src="js/search.js?v=<?php echo time(); ?>"></script>
  <script src="js/js/responsive-slider.js"></script>
  <script src="js/js/jquery.appear.js"></script>
  <script src="js/js/grid.js"></script>
  <script src="js/js/main.js"></script>
  <script src="js/js/wow.min.js"></script>
</body>
</html>






