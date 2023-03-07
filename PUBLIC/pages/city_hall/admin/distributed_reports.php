<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Distributed Medicine Reports'; ?>
<?php include(SHARED_PATH . '/city_hall/admin/reports/distributed_reports/distributed_header.php'); ?>

<div id="vue-distributed-medicine-reports" class="mt-4" v-cloak>
	<div class="container">
		<div class="card px-3 pb-1 pt-3 shadow-nohover">
			<h4>Distributed Medicine Report</h4>
		</div>

		<div class="card px-3 pt-2 pb-3 mt-4 shadow-nohover">
			<div class="float-right mt-4">
				<select @change="selectReports" v-model="select_reports" id="select_reports" class="form-control form-control-sm d-inline-block col-md-2 float-right">
					<option disabled value="" selected>Select Time Period</option>
					<option value="lifetime">Lifetime</option>
					<option value="last_week">Last Week</option>
					<option value="this_week">This Week</option>
					<option value="last_month">Last Month</option>
					<option value="this_month">This Month</option>
					<option value="last_year">Last Year</option>
					<option value="this_year">This Year</option>
				</select>	
				<label class="d-inline-block mr-2 mt-1 float-right ml-2" for="select_reports">Time Period: </label>

				<select v-model="filter_search" id="select_reports" class="form-control form-control-sm d-inline-block col-md-2 float-right">
					<option disabled value="" selected>Select Branch</option>
              			<option v-for="barangay in barangays" v-show="barangay.barangay_name != 'City Hall'" :value="barangay.barangay_id">{{barangay.barangay_name}}</option> 
				</select>	
				<label class="d-inline-block mr-2 mt-1 float-right" for="select_reports">Barangay: </label>
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
						<option :value="distributed_reports.length">All</option>
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
					<tbody v-if="distributed_reports.length > 0">
						<tr v-for="(distributed_report, index) in distributed_reports" v-if="index >= startIndex && index < endIndex">
							<td>{{distributed_report.Day}}</td>
							<td>{{distributed_report.Quantity}}</td>
							<td>{{distributed_report.Beneficiary}}</td>
							<td>&#8369;{{distributed_report.Amount}}.00</td>
							<td>{{(distributed_report.Quantity / totalQuantity * 100) ? (distributed_report.Quantity / totalQuantity * 100) : (0) | currency}}%</td>

							<td>{{(distributed_report.Beneficiary / totalBeneficiary * 100) ? (distributed_report.Beneficiary / totalBeneficiary * 100) : (0) | currency}}%</td>

							<td>{{(distributed_report.Amount / totalAmount * 100) ? (distributed_report.Amount / totalAmount * 100) : (0) | currency}}%</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>

					<tfoot v-if="distributed_reports.length > 0">
						<tr>
							<th colspan="1" class="text-left">Total:</th>
							<th class="mx-auto">{{totalQuantity}}</th>
							<th class="mx-auto">{{totalBeneficiary}}</th>
							<th class="mx-auto">&#8369;{{totalAmount | currency}}</th>
							<th class="mx-auto">{{(sumAllYearQuantity) ? (sumAllYearQuantity) : (0) | currency}}%</th>
							<th class="mx-auto">{{(sumAllYearBeneficiary) ? (sumAllYearBeneficiary) : (0) | currency}}%</th>
							<th class="mx-auto">{{(sumAllYearAmount) ? (sumAllYearAmount) : (0) | currency}}%</th>
						</tr>
					</tfoot>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{this.distributed_reports.length ? startIndex + 1 : 0}} to {{endIndex>this.distributed_reports.length? this.distributed_reports.length :endIndex}} of {{distributed_reports.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.distributed_reports.length / this.show_entries) > 3 ? 3 : Math.ceil(this.distributed_reports.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>

			<div v-show="second" class="box-body chart-responsive" v-cloak>
				<div class="wrapper">
				    <canvas ref="myChart3" width="650" height="200"></canvas>
				</div>
				<div class="wrapper mt-5">
				    <canvas ref="myChart4" width="600" height="250" class="mb-5"></canvas>
				</div>

				
				<label class="d-inline-block mr-1" for="show_entries_two">Show </label>
					<select @change="showEntries_two(show_entries_two)" v-model="show_entries_two" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries_two" style="width: auto;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option :value="distributed_reports_per_year.length">All</option>
					</select>
				<label class="d-inline-block ml-1" for="show_entries_two">entries</label>
				

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
					<tbody v-if="distributed_reports_per_year.length > 0">
						<tr v-for="(distributed_report, index) in distributed_reports_per_year" v-if="index >= startIndex && index < endIndex">
							<td>{{distributed_report.Day}}</td>
							<td>{{distributed_report.Quantity}}</td>
							<td>{{distributed_report.Beneficiary}}</td>
							<td>&#8369;{{distributed_report.Amount}}.00</td>
							<td>{{(distributed_report.Quantity / totalThisYearQuantity * 100) ? (distributed_report.Quantity / totalThisYearQuantity * 100) : (0) | currency}}%</td>

							<td>{{(distributed_report.Beneficiary / totalThisYearBeneficiary * 100) ? (distributed_report.Beneficiary / totalThisYearBeneficiary * 100) : (0) | currency}}%</td>

							<td>{{(distributed_report.Amount / totalThisYearAmount * 100) ? (distributed_report.Amount / totalThisYearAmount * 100) : (0) | currency}}%</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>

					<tfoot v-if="distributed_reports.length > 0">
						<tr>
							<th colspan="1" class="text-left">Total:</th>
							<th class="mx-auto">{{totalThisYearQuantity}}</th>
							<th class="mx-auto">{{totalThisYearBeneficiary}}</th>
							<th class="mx-auto">&#8369;{{totalThisYearAmount | currency}}</th>
							<th class="mx-auto">{{sumAllYearQuantity | currency}}%</th>
							<th class="mx-auto">{{sumAllYearBeneficiary | currency}}%</th>
							<th class="mx-auto">{{sumAllYearAmount | currency}}%</th>
						</tr>
					</tfoot>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{this.distributed_reports_per_year.length ? startIndex + 1 : 0}} to {{endIndex>this.distributed_reports_per_year.length? this.distributed_reports_per_year.length :endIndex}} of {{distributed_reports_per_year.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.distributed_reports_per_year.length / this.show_entries_two) > 3 ? 3 : Math.ceil(this.distributed_reports_per_year.length / this.show_entries_two)" @click="pagination_two(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next_two()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include(SHARED_PATH . '/city_hall/admin/reports/distributed_reports/distributed_footer.php'); ?>