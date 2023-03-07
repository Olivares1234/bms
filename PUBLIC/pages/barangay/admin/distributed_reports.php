<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Request Order'; ?>
<?php $barangay_name = 'Barangay ' . $_SESSION['barangay_name']; ?>
<?php include(SHARED_PATH . '/barangay/admin/reports/distributed_reports/distributed_header.php'); ?>

<div id="vue-reports" class="mt-4" v-cloak>
	<div class="container">
		<div class="card px-3 pb-1 pt-3 shadow-nohover">
			<h4>Distributed Medicine Report</h4>
		</div>

		<div class="card px-3 pt-2 pb-3 mt-4 shadow-nohover">
			<div class="float-right mt-4">
				<select @change="selectReports" v-model="select_reports" id="select_reports" class="form-control form-control-sm d-inline-block col-md-2 float-right" id="show_entries">
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
			<div v-show="first" class="box-body chart-responsive" v-cloak>
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
						<option :value="transaction_per_day.length">All</option>
					</select>
				<label class="d-inline-block ml-1" for="show_entries">entries</label>
				
				<button class="btn btn-sm text-light bg-primary float-right font-weight-bold" @click="download"><i class="far fa-file-pdf">&nbsp;</i> Export PDF</button>

				<table class="table table-hover table-bordered text-center">
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Date</th>
							<th>Order Qty</th>
							<th>Total Order</th>
							<th>Grand Total</th>
							<th>Avg. Qty</th>
							<th>Avg. Order</th>
							<th>Avg. Grand Total</th>
						</tr>
					</thead>
					<tbody v-if="transaction_per_day.length >= 0">
						<tr v-for="(distributed, index) in transaction_per_day" v-if="index >= startIndex && index < endIndex">
							<td>{{distributed.Day}}</td>
							<td>{{distributed.Quantity}}</td>
							<td>{{distributed.Beneficiary}}</td>
							<td>&#8369;{{distributed.Amount}}.00</td>
							<td>{{(distributed.Quantity / totalAmount * 100) ? (distributed.Quantity / totalAmount * 100) : (0) | currency}}%</td>

							<td>{{(distributed.Beneficiary / totalBeneficiary * 100) ? (distributed.Beneficiary / totalBeneficiary * 100) : (0) | currency}}%</td>

							<td>{{(distributed.Amount / totalAmount * 100) ? (distributed.Amount / totalAmount * 100) : (0) | currency}}%</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{this.transaction_per_day.length ? startIndex + 1 : 0}} to {{endIndex>this.transaction_per_day.length? this.transaction_per_day.length :endIndex}} of {{transaction_per_day.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.transaction_per_day.length / this.show_entries) > 3 ? 3 : Math.ceil(this.transaction_per_day.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>

			<div v-show="second" class="box-body chart-responsive">
				<div class="wrapper">
				    <canvas ref="myChart3" width="650" height="200"></canvas>
				</div>
				<div class="wrapper mt-5">
				    <canvas ref="myChart4" width="600" height="250" class="mb-5"></canvas>
				</div>

				<label class="d-inline-block mr-1" for="show_entries">Show </label>
					<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option :value="transaction_per_year.length">All</option>
					</select>
				<label class="d-inline-block ml-1" for="show_entries">entries</label>

				<button class="btn btn-sm text-light bg-primary float-right font-weight-bold" @click="download_two"><i class="far fa-file-pdf">&nbsp;</i> Export PDF</button>

				<table class="table table-hover table-bordered text-center">
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Month</th>
							<th>Order Qty</th>
							<th>Total Order</th>
							<th>Grand Total</th>
							<th>Avg. Qty / Monthly</th>
							<th>Avg. Order / Monthly</th>
							<th>Avg. Grand Total / Monthly</th>
						</tr>
					</thead>
					<tbody v-if="transaction_per_year.length > 0">
						<tr v-for="(distributed, index) in transaction_per_year" v-if="index >= startIndex && index < endIndex">
							<td>{{distributed.Month}}</td>
							<td>{{distributed.Quantity}}</td>
							<td>{{distributed.Beneficiary}}</td>
							<td>&#8369;{{distributed.Amount}}.00</td>

							<td>{{(distributed.Quantity / totalThisYearQuantity * 100) ? (distributed.Quantity / totalThisYearQuantity * 100) : (0) | currency}}%</td>

							<td>{{(distributed.Beneficiary / totalThisYearBeneficiary * 100) ? (distributed.Beneficiary / totalThisYearBeneficiary * 100) : (0) | currency}}%</td>

							<td>{{(distributed.Amount / totalThisYearAmount * 100) ? (distributed.Amount / totalThisYearAmount * 100) : (0) | currency}}%</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{this.transaction_per_year.length ? startIndex + 1 : 0}} to {{endIndex>this.transaction_per_year.length? this.transaction_per_year.length :endIndex}} of {{transaction_per_year.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.transaction_per_year.length / this.show_entries) > 3 ? 3 : Math.ceil(this.transaction_per_year.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
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
<?php include(SHARED_PATH . '/barangay/admin/reports/distributed_reports/distributed_footer.php'); ?>