<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Dashboard'; ?>
<?php include(SHARED_PATH . '/city_hall/pharmacist/dashboard/dashboard_header.php'); ?>
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
				                    	<h6 class="text-light">No of Request</h6>
				                    	<h3 class="text-light font-weight-bold">{{request_orders.length}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/city_hall/pharmacist/barangay_request.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
				            </div>

				            <div class="col-lg-3 col-xs-4">
				                <!-- small box -->
				                <div class="small-box rounded" id="stock-box">
				                	<div class="inner">
				                    	<h6 class="text-light">Total Send</h6>
				                    	<h3 class="text-light font-weight-bold">&#8369;{{totalSend}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/city_hall/pharmacist/barangay_request.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
							</div><!-- ./col -->

				            <div class="col-lg-3 col-xs-4">
				                <!-- small box -->
				                <div class="small-box rounded" id="total-received">
				                	<div class="inner">
				                    	<h6 class="text-light">No of Received</h6>
				                    	<h3 class="text-light font-weight-bold">{{purchase_receives.length}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/city_hall/pharmacist/purchase_received.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
				            </div><!-- ./col -->

				            <div class="col-lg-3 col-xs-4">
				                <!-- small box -->
				                <div class="small-box rounded" id="user-box">
				                	<div class="inner">
				                    	<h6 class="text-light">Total Received</h6>
				                   		<h3 class="text-light font-weight-bold">&#8369;{{totalReceived}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/city_hall/pharmacist/purchase_received.php')?>" class="small-box-footer">
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
				                <div class="small-box rounded" id="beneficiary-box">
				                	<div class="inner">
				                    	<h6 class="text-light">Total Stocks Qty</h6>
				                   		<h3 class="text-light font-weight-bold">{{totalStockQuantity}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/city_hall/pharmacist/available_medicine.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
				            </div><!-- ./col -->
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
				                  	<a href="<?php echo url_for('pages/city_hall/pharmacist/available_medicine.php')?>" class="small-box-footer">
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
				                  	<a href="<?php echo url_for('pages/city_hall/pharmacist/unavailable_medicine.php')?>" class="small-box-footer">
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
				                  	<a href="<?php echo url_for('pages/city_hall/pharmacist/expired_medicine.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
				            </div><!-- ./col -->
				        </div>
				    </div>
				</div>

				<div class="card px-3 pt-2 pb-3 mt-4 shadow-nohover">
					<div class="mt-3">
			          	<h6 class="float-left font-weight-bold">OUT OF STOCK MEDICINE LIST</h6>
					</div>
					
					<div class="float-left mt-4">
						<label class="d-inline-block mr-1" for="show_entries">Show </label>
							<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
								<option value="10" selected>10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
								<option :value="unavailable_medicines.length">All</option>
							</select>
						<label class="d-inline-block ml-1" for="show_entries">entries</label>
					</div>
					
					<table class="table table-hover table-bordered text-center mt-2">
						<thead class="thead-info">
							<tr class="table-color text-light">
								<th>Medicine Name</th>
								<th>Category</th>
								<th>Unit Category</th>
								<th>Stock</th>
								<th>Price</th>
							</tr>
						</thead>
						<tbody v-if="unavailable_medicines.length > 0">
							<tr v-for="(unavailable_medicine, index) in unavailable_medicines" v-if="index >= startIndex && index < endIndex">
								<td>{{ideitifyMedicineName(unavailable_medicine.supplier_medicine_id)}}</td>
								<td>{{idetifyCategory(unavailable_medicine.supplier_medicine_id)}}</td>
								<td>{{identifyUnitCategory(unavailable_medicine.supplier_medicine_id)}}</td>
								<td>{{unavailable_medicine.received_quantity}}</td>
								<td>&#8369;{{identifyMedicinePrice(unavailable_medicine.supplier_medicine_id)}}</td>
							</tr>
						</tbody>

						<tbody v-else>
							<tr>
								<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
							</tr>
						</tbody>

						<tfoot v-if="unavailable_medicines.length > 0">
							<tr>
								<th colspan="4" class="text-left">Total Amount:</th>
								<th class="mx-auto">&#8369;{{totalInventory}}</th>
							</tr>
						</tfoot>
					</table>

					<div class="mt-1">
						<p class="float-left">Showing {{this.unavailable_medicines.length ? startIndex + 1 : 0}} to {{endIndex>this.unavailable_medicines.length? this.unavailable_medicines.length :endIndex}} of {{unavailable_medicines.length}} entries</p>

						<nav aria-label="Page navigation example">
						  <ul class="pagination justify-content-end">
						    <li class="page-item">
						      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
						    </li>
						    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.unavailable_medicines.length / this.show_entries) > 3 ? 3 : Math.ceil(this.unavailable_medicines.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
						    <li class="page-item">
						      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextUnavailable()">Next</a>
						    </li>
						  </ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<?php include(SHARED_PATH . '/city_hall/pharmacist/dashboard/dashboard_footer.php'); ?>

