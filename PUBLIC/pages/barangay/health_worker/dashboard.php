<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = ' Dashboard'; ?>
<?php $barangay_name = 'Barangay ' . $_SESSION['barangay_name'] ?>
<?php include(SHARED_PATH . '/barangay/health_worker/dashboard/dashboard_header.php'); ?>

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
				               	<div class="small-box rounded" id="available-box">
				                 	<div class="inner">
				                    	<h6 class="text-light">Available</h6>
				                    	<h3 class="text-light">{{available_medicines.length}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/barangay/health_worker/available_medicine.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
				            </div>

				            <div class="col-lg-3 col-xs-4">
				                <!-- small box -->
				                <div class="small-box rounded" id="unavailable-box">
				                	<div class="inner">
				                    	<h6 class="text-light">Unavailable</h6>
				                    	<h3 class="text-light">{{unavailable_medicines.length}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/barangay/health_worker/unavailable_medicine.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
							</div><!-- ./col -->

				            <div class="col-lg-3 col-xs-4">
				                <!-- small box -->
				                <div class="small-box rounded" id="expired-box">
				                	<div class="inner">
				                    	<h6 class="text-light">Expired</h6>
				                    	<h3 class="text-light">{{expired_medicines.length}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-pills fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/barangay/health_worker/expired_medicine.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                  	</a>
				                </div>
				            </div><!-- ./col -->

				            <div class="col-lg-3 col-xs-4">
				                <!-- small box -->
				                <div class="small-box rounded" id="beneficiary-box">
				                	<div class="inner">
				                    	<h6 class="text-light">Beneficiary</h6>
				                   		<h3 class="text-light">{{beneficiaries.length}}</h3>
				                  	</div>
				                  	<div class="icon">
				                    	<i class="fas fa-user-check fa-xs mr-2"></i>
				                  	</div>
				                  	<a href="<?php echo url_for('pages/barangay/health_worker/beneficiary.php')?>" class="small-box-footer">
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
					
					<table class="table table-hover table-bordered text-center">
						<thead class="thead-info">
							<tr class="table-color text-light">
								<th>Medicine Name</th>
								<th>Category</th>
								<th>Unit Category</th>
								<th>Stock</th>
								<th>Price</th>
							</tr>
						</thead>
						<tbody v-if="out_of_stocks.length > 0">
							<tr v-for="(out_of_stock, index) in out_of_stocks" v-if="index >= startIndex && index < endIndex">
								<td>{{ideitifyMedicineName(out_of_stock.supplier_medicine_id)}}</td>
								<td>{{idetifyCategory(out_of_stock.supplier_medicine_id)}}</td>
								<td>{{identifyUnitCategory(out_of_stock.supplier_medicine_id)}}</td>
								<td>{{out_of_stock.quantity}}</td>
								<td>&#8369;{{identifyMedicinePrice(out_of_stock.supplier_medicine_id)}}</td>
							</tr>
						</tbody>

						<tbody v-else>
							<tr>
								<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
							</tr>
						</tbody>

						<tfoot v-if="out_of_stocks.length > 0">
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
				

				<div class="card px-3 pt-2 pb-3 mt-4 shadow-nohover">
					<div class="mt-3">
			          	<h6 class="float-left font-weight-bold">RECENT TRANSACTION</h6>
					</div>
					
					<div class="float-left mt-4">
						<label class="d-inline-block mr-1" for="show_entries">Show </label>
							<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
								<option value="10" selected>10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
								<option :value="reports.length">All</option>
							</select>
						<label class="d-inline-block ml-1" for="show_entries">entries</label>

						<div class="form-group float-right">
				          	<div class="input-group date">
								<input type="text" v-model="start_date" class="datepicker form-control form-control-sm" placeholder="From">
																
							    <input type="text" v-model="end_date" class="datepicker2 form-control form-control-sm ml-2" placeholder="To">

								<button @click="searchByDate" class="btn btn-sm bg-primary text-light ml-2">Search</button>
							</div>

						</div>
					</div>
					
					<table class="table table-hover table-bordered text-center">
						<thead class="thead-info">
							<tr class="table-color text-light">
								<th>Transaction ID</th>
								<th>Medicine Name</th>
								<th>Category</th>
								<th>Unit Category</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Date</th>
								<th colspan="7">Total</th>
							</tr>
						</thead>
						<tbody v-if="reports.length > 0">
							<tr v-for="(report, index) in reports" v-if="index >= startIndex && index < endIndex">
								<td>{{report.transaction_id}}</td>
								<td>{{report.medicine_name}}</td>
								<td>{{report.description}}</td>
								<td>{{report.unit}}</td>
								<td>{{report.quantity}}</td>
								<td>{{report.price}}</td>
								<td>{{report.transaction_date}}</td>
								<td colspan="4">&#8369;{{report.total_price}}.00</td>
							</tr>
						</tbody>

						<tbody v-else>
							<tr>
								<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
							</tr>
						</tbody>

						<tfoot v-if="reports.length > 0">
							<tr>
								<th colspan="7" class="text-left">Total Amount:</th>
								<th class="mx-auto">&#8369;{{totalTransactionReportsToday | currency}}</th>
							</tr>
						</tfoot>
					</table>

					<div class="mt-1">
						<p class="float-left">Showing {{this.reports.length? startIndex + 1 : 0}} to {{endIndex>this.reports.length? this.reports.length :endIndex}} of {{reports.length}} entries</p>

						<nav aria-label="Page navigation example">
						  <ul class="pagination justify-content-end">
						    <li class="page-item">
						      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
						    </li>
						    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.reports.length / this.show_entries) > 3 ? 3 : Math.ceil(this.reports.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
						    <li class="page-item">
						      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next()">Next</a>
						    </li>
						  </ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<?php include(SHARED_PATH . '/barangay/health_worker/dashboard/dashboard_footer.php'); ?>