<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Best Medicine Reports'; ?>
<?php include(SHARED_PATH . '/city_hall/admin/reports/purchase_order_reports/purchase_order_reports_header.php'); ?>

<div id="vue-purchase_orders-reports" class="mt-4" v-cloak>
	<div class="container">
		<div class="card px-3 pb-1 pt-3 shadow-nohover">
			<h4>Purchase Order Report</h4>
		</div>

		<div class="card px-3 pt-2 pb-3 mt-4 shadow-nohover">
			<div class="float-right mt-4">
				<select @change="retrievePurchaseOrderReports" v-model="select_reports" id="select_reports" class="form-control form-control-sm d-inline-block col-md-2 float-right" id="show_entries">
					<option value="lifetime">Lifetime</option>
					<option value="last_week">Last Week</option>
					<option value="this_week">This Week</option>
					<option value="last_month">Last Month</option>
					<option value="this_month">This Month</option>
					<option value="last_year">Last Year</option>
					<option value="this_year">This Year</option>
				</select>	
				<label class="d-inline-block mr-2 mt-1 float-right" for="select_reports">Time Period: </label>
			</div>	
			<div class="box-body chart-responsive" v-cloak>
				<div class="wrapper">
				    <canvas ref="myChart" width="650" height="200"></canvas>
				</div>
				<div class="wrapper mt-5">
				    <canvas ref="myChart2" width="600" height="250" class="mb-5"></canvas>
				</div>

				
				<label class="d-inline-block mr-1" for="show_entries">Show </label>
					<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option :value="purchase_orders.length">All</option>
					</select>
				<label class="d-inline-block ml-1" for="show_entries">entries</label>
				
				<button class="btn btn-sm text-light bg-primary float-right font-weight-bold" @click="download"><i class="far fa-file-pdf">&nbsp;</i> Export PDF</button>

				<table class="table table-hover table-bordered text-center">
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Date Request</th>
							<th>Supplier Name</th>
							<th>Total Order</th>
						</tr>
					</thead>
					<tbody v-if="purchase_orders.length > 0">
						<tr v-for="(purchase_order, index) in purchase_orders" v-if="index >= startIndex && index < endIndex">
							<td>{{purchase_order.Date_Request}}</td>
							<td>{{purchase_order.Supplier}}</td>
							<td>{{purchase_order.Total_Order}}</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>

					<tfoot v-if="purchase_orders.length > 0">
						<tr>
							<th colspan="2" class="text-left">Total Amount:</th>
							<th class="mx-auto">{{totalOrder}}</th>
						</tr>
					</tfoot>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{this.purchase_orders.length ? startIndex + 1 : 0}} to {{endIndex>this.purchase_orders.length? this.purchase_orders.length :endIndex}} of {{purchase_orders.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.purchase_orders.length / this.show_entries) > 3 ? 3 : Math.ceil(this.purchase_orders.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include(SHARED_PATH . '/city_hall/admin/reports/purchase_order_reports/purchase_order_reports_footer.php'); ?>