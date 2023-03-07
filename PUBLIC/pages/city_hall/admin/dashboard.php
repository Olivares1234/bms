<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Dashboard'; ?>
<?php include(SHARED_PATH . '/city_hall/admin/dashboard/dashboard_header.php'); ?>
<div id="vue-dashboard" class="mt-4" v-cloak>
	<section class="content">
		<div class="col-md-12">
			<div class="box box-primary">
		    	<div class="card px-3 pb-1 pt-3 shadow-nohover">
		        	<h4>Dashboard</h4>
		        </div>

			    <div class="mt-3 shadow-nohover">
				    <div class="box-body">
				        <div class="row">
				            <div class="col-lg-3 col-xs-4">
				                	<!-- small box -->
				               	<div class="small-box rounded" id="total-box">
				                 	<div class="inner">
				                    	<h6 class="text-light">Total Distribute</h6>
				                    	<h3 class="text-light font-weight-bold">{{"&#8369;" + totalDistribute}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/admin/available_medicine.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
				            </div>

				            <div class="col-lg-3 col-xs-4">
				                <!-- small box -->
				                <div class="small-box rounded" id="stock-box">
				                	<div class="inner">
				                    	<h6 class="text-light">Total Received</h6>
				                    	<h3 class="text-light font-weight-bold">{{"&#8369;" + totalPurchaseReceivedQuantity}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/admin/unavailable_medicine.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
							</div><!-- ./col -->

				            <div class="col-lg-3 col-xs-4">
				                <!-- small box -->
				                <div class="small-box rounded" id="total-received">
				                	<div class="inner">
				                    	<h6 class="text-light">Total Stocks Qty</h6>
				                    	<h3 class="text-light font-weight-bold">{{totalStockQuantity}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/admin/expired_medicine.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
				            </div><!-- ./col -->

				            <div class="col-lg-3 col-xs-4">
				                <!-- small box -->
				                <div class="small-box rounded" id="user-box">
				                	<div class="inner">
				                    	<h6 class="text-light">User</h6>
				                   		<h3 class="text-light font-weight-bold">{{active_users.length}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-user-plus fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/admin/beneficiary.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
				            </div><!-- ./col -->
				        </div>
				    </div>
				</div>

				<div class="mt-3 shadow-nohover">
				    <div class="box-body">
				        <div class="row">
				            <div class="col-lg-3 col-xs-4">
				                	<!-- small box -->
				               	<div class="small-box rounded" id="available-box">
				                 	<div class="inner">
				                    	<h6 class="text-light">Available</h6>
				                    	<h3 class="text-light font-weight-bold">{{available_medicines.length}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/admin/available_medicine.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
				            </div>

				            <div class="col-lg-3 col-xs-4">
				                <!-- small box -->
				                <div class="small-box rounded" id="unavailable-box">
				                	<div class="inner">
				                    	<h6 class="text-light">Unavailable</h6>
				                    	<h3 class="text-light font-weight-bold">{{unavailable_medicines.length}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/admin/unavailable_medicine.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
							</div><!-- ./col -->

				            <div class="col-lg-3 col-xs-4">
				                <!-- small box -->
				                <div class="small-box rounded bg-danger" id="expired-box">
				                	<div class="inner">
				                    	<h6 class="text-light">Expired</h6>
				                    	<h3 class="text-light font-weight-bold">{{expired_medicines.length}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/admin/expired_medicine.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
				            </div><!-- ./col -->

				            <div class="col-lg-3 col-xs-4">
				                <!-- small box -->
				                <div class="small-box rounded" id="beneficiary-box">
				                	<div class="inner">
				                    	<h6 class="text-light">Beneficiary</h6>
				                   		<h3 class="text-light font-weight-bold">{{beneficiaries.length}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-user-check fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/admin/beneficiary.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
				            </div><!-- ./col -->
				        </div>
				    </div>
				</div>

				<div style="overflow:hidden">
					<div class="card px-3 pt-2 pb-3 mt-4 shadow-nohover float-left" style="width:40rem; overflow:hidden">
						<div class="box-body chart-responsive float-left">
		    				<div class="wrapper">
							    <canvas ref="myChart" width="650" height="400"></canvas>
							</div>
		  				</div>
		  			</div>

		  			<div class="card px-3 pt-2 pb-3 mt-4 shadow-nohover float-right" style="width:26rem;">
						
						<div class="box-body chart-responsive float-right">
		    				<div class="wrapper">
							    <canvas ref="myChart3" width="650" height="400"></canvas>
							</div>
		  				</div>
		  			</div>
		  		</div>

		  		<div style="overflow:hidden">
		  			<div class="card px-3 pt-2 pb-3 mt-4 shadow-nohover float-left" style="width:40rem; overflow:hidden">
						
						<div class="box-body chart-responsive float-left">
		    				<div class="wrapper">
							    <canvas ref="myChart2" width="650" height="400"></canvas>
							</div>
		  				</div>
		  			</div>

		  			<div class="card px-3 pt-2 pb-3 mt-4 shadow-nohover float-right" style="width:26rem;">
						
						<div class="box-body chart-responsive float-right">
		    				<div class="wrapper">
							    <canvas ref="myChart4" width="650" height="400"></canvas>
							</div>
		  				</div>
		  			</div>
	  			</div>
			</div>
		</div>
	</section>
</div>


<?php include(SHARED_PATH . '/city_hall/admin/dashboard/dashboard_footer.php'); ?>

