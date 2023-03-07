<?php require_once('../../private/initialize.php'); ?>
<?php $_SESSION['beneficiary_id'] ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>BMS - Search</title>
	<script src="../js/chart/chart.min.js"></script>
	<script src="../js/vue/vue.js?v=<?php echo time(); ?>"></script>
	<link rel="shortcut icon"  href="../images/logo.jpg?v=<?php echo time(); ?>">
	<link href="../js/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link rel="stylesheet" href="../js/datetimepicker/bootstrap-datetimepicker.min.css" />
	<link href="../css/styles.css?v=<?php echo time(); ?>" rel="stylesheet">
	<link href="../js/fontawesome-free-5.8.1-web/css/all.min.css?v=<?php echo time(); ?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/sweetalert.min.css?v=<?php echo time(); ?>">
	<script src="../js/sweet_alert/sweetalert.js?v=<?php echo time(); ?>"></script>
	<script src="../js/Axios/axios.min.js?v=<?php echo time(); ?>"></script>
	<style>
    	[v-cloak] {
        	display:none;
      	}
      	#page-content-wrapper {
		    min-width: 0;
		    width: 100%;
		    margin-left: 0;
		}
    </style>
</head>
<body>
	<nav class="navbar navbar-light bg-light static-top sticky-top">
  	
	  	<a class="navbar-brand text-light" href="#" style="font-size: 23px"><img class="float-left mr-2" src="../images/logo.jpg" id="main-logo">BMS</a>
	    <div class="container">
	      <a class="navbar-brand text-white mr-5"></a>
	      <a class="btn btn-outline-light btn-sm" href="<?php echo url_for('index.php'); ?>">Home</a>
	    </div>
	 </nav>
	 <div id="vue-search" class="mt-4" v-cloak>
		<div class="container">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Transaction Details
					<a class="btn bg-info text-light btn-sm ml-2" @click="backToHomepage"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 mt-4">
				<div class="float-left mt-4" id="show_entries">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="beneficiary_transactions.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<div class="form-group float-right">
			          	<div class="input-group date">
							<input type="text" v-model="start_date" class="datepicker form-control form-control-sm" placeholder="From">
															
						    <input type="text" v-model="end_date" class="datepicker2 form-control form-control-sm ml-2" placeholder="To">

							<button @click="searchByDate" class="btn btn-sm bg-primary text-light ml-2">Search</button>
						</div>

					</div>
					<a class ="btn btn-primary text-light btn-sm font-weight-bold ml-2" id="print-transaction" onclick ="window.print()"><i class ="fa fa-print">&nbsp;</i> Print</a>
				</div>
	
				<table class="table table-hover table-bordered text-center">

					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Date</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody v-if="beneficiary_transactions.length > 0">
						<tr v-for="transaction in beneficiary_transactions">
							<td>{{transaction.transaction_date}}</td>
							<td>&#8369;{{transaction.price}}</td>
							<td>{{transaction.quantity}}</td>
							<td>&#8369;{{formatPrice(transaction.total_price)}}</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
					<tfoot v-if="beneficiary_transactions.length > 0">
						<tr>
							<th colspan="3" class="text-left">Total Amount:</th>
							<th class="text-center">&#8369;{{totalAmount | currency()}}</th>
						</tr>
						<tr>
							<th colspan="3" class="text-left">Remaining Balance:</th>
							<th class="text-center">&#8369;{{totalBeneficiaryRemainingBalance | currency()}}</th>
						</tr>
					</tfoot>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{this.beneficiary_transactions.length ? startIndex + 1 : 0}} to {{endIndex>this.beneficiary_transactions.length? this.beneficiary_transactions.length :endIndex}} of {{beneficiary_transactions.length}} entries</p>

					<nav aria-label="Page navigation example">
						<ul class="pagination justify-content-end">
					    	<li class="page-item">
					    		<a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    	</li>
					    	<li class="page-item">
					    		<a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.beneficiary_transactions.length / this.show_entries) > 3 ? 3 : Math.ceil(this.beneficiary_transactions.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}
					    		</a>
					    	</li>
					    	<li class="page-item">
					    		<a class="page-link btn btn-sm text-dark py-1 px-2" @click="next()">Next</a>
					    	</li>
					  	</ul>
					</nav>
				</div>
			</div> 
		</div>

	<div class="spacing"></div>
	
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
	</div>
		<script src="../js/jquery-1-11-3/jquery-1.11.3.min.js"></script>
  		<script src="../js/bootstrap/js/bootstrap.min.js"></script>
  		<script src="../js/moment/moment.min.js"></script> 
   		<script src="../js/datetimepicker/bootstrap-datetimepicker.min.js"></script>
   		<script src="../js/search.js?v=<?php echo time(); ?>"></script>
	</body>
</html>
