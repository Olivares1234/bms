<?php require_once('../../private/initialize.php'); ?>
<?php checkSession(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>BMS - Barangay Login</title>
	<script src="../js/vue/vue.js?v=<?php echo time(); ?>"></script>
	<link rel="shortcut icon"  href="../images/logo.png?v=<?php echo time(); ?>">

	<link href="../js/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet">
	<link href="../css/styles.css?v=<?php echo time(); ?>" rel="stylesheet">
	<link href="../js/fontawesome-free-5.8.1-web/css/all.min.css?v=<?php echo time(); ?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/sweetalert.min.css?v=<?php echo time(); ?>">
	<script src="../js/sweet_alert/sweetalert.js?v=<?php echo time(); ?>"></script>
	<script src="../js/axios/axios.min.js?v=<?php echo time(); ?>"></script>
	<style>
    	[v-cloak] {
        	display:none;
      	}
    </style>
</head>
<body>
      <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top sticky-top">
  	
  	<a class="navbar-brand text-light" href="#" style="font-size: 23px"><img class="float-left mr-2" src="../images/logo.png" id="main-logo">BMS</a>
    <div class="container">
      <a class="navbar-brand text-white mr-5"></a>
      <a class="btn btn-outline-light btn-sm" href="<?php echo url_for('index.php'); ?>">Home</a>
    </div>
  </nav>
  	<div id="vue-login">
  		<div class="container">
  			<div class="card card-login mx-auto text-center bg-light shadow p-3 mb-5 rounded">
			
				<div class="card-header mx-auto bg-light text-dark">
					
					<span class="logo_title">BMS - Login</span>
				</div>
				<div class="card-body">
					<form @submit.prevent="loginUser">
						<div class="input-group form-group">

							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>

							<input type="text" v-model="username" :class="{'is-invalid': username_error}" class="form-control form-control-ms" id="usernames" placeholder="Username" v-focus>
							<div class="invalid-feedback">{{username_error_text}}</div>
						</div>

						<div class="input-group form-group">

							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>

							<input type="password" v-model="password" :class="{'is-invalid': password_error}" class="form-control" placeholder="Password">
							<div class="invalid-feedback">{{password_error_text}}</div>

						</div>

						<div class="checkbox float-left">
							<label><input type="checkbox"> Remember me</label>
						</div>

						<div class="form-group mt-4">
							<input type="submit" value="Login" class="btn btn-outline-info float-right btn-block login_btn">
						</div>
					</form>
				</div>
			</div>
  		</div>
  	</div>
	<div class="login-spacing"></div>
	<hr>
	
	<footer class="page-footer font-small special-color-dark">
			<div class="footer-copyright text-center text-light text-dark">Copyright &copy; <?php echo date('Y') ?> 			
				<a href="#" class="text-dark"> Boticab Management System</a>.
				All rights reserved
			</div>
			<div class="container py-2">
				<ul class="list-unstyled list-inline text-center">
					<li class="list-inline-item text-primary">
						<a class="btn-floating btn-tw mx-1" href="">
							<i class="fab fa-facebook-square"></i>
						</a>
					</li>
					<li class="list-inline-item">
						<a class="btn-floating btn-tw mx-1 text-info" href="">
							<i class="fab fa-twitter"></i>
						</a>
					</li>
					<li class="list-inline-item">
						<a class="btn-floating btn-tw mx-1 text-danger" href="">
							<i class="fab fa-google-plus-g"></i>
						</a>
					</li>
					<li class="list-inline-item">
						<a class="btn-floating btn-tw mx-1 text-danger" href="">
							<i class="fab fa-youtube"></i>
						</a>
					</li>
				</ul>
			</div>
		</footer>
		<script src="../js/jquery/jquery.min.js"></script>
  		<script src="../js/bootstrap/js/bootstrap.min.js"></script>
  			<script src="../js/login.js?v=<?php echo time(); ?>"></script>
	</body>
</html>
