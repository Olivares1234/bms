<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = ' Received Order'; ?>
<?php $barangay_name = 'Barangay ' . $_SESSION['barangay_name'] ?>
<?php include(SHARED_PATH . '/barangay/health_worker/received_order/received_order_header.php'); ?>

<div id="vue-received-order" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="send_order_info">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Received Order</h4>
			</div>

			<div class="card px-3 mt-4 shadow-nohover">
				<div class="float-right mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="send_orders.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<input type="text" class="form-control form-control-sm float-right col-md-2" @input="searchSendOrder" v-model="search_send_order" placeholder="Search" arial-label="Search" onfocus="this.value=''">
				</div>

				<table class="table table-hover table-bordered text-center mt-2">		
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Send Order No.</th>
							<th>Date Send</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="send_orders.length > 0">
						<tr v-for="(send_order, index) in send_orders" v-if="index >= startIndex && index < endIndex" v-cloak>
							<td>{{send_order.send_order_id}}</td>
							<td>{{send_order.date_send}}</td>
							<td>

								<button @click="toggleRequestOrderDetailsInfo(send_order.send_order_id)" :title="view_Order" class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></button>
								
							</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="6" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{this.send_orders.length ? startIndex + 1 : 0}} to {{endIndex>this.send_orders.length? this.send_orders.length :endIndex}} of {{send_orders.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.send_orders.length / this.show_entries) > 3 ? 3 : Math.ceil(this.send_orders.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextSendOrder()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>

		<div v-if="send_order_info == false && accept_order_details == false">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
		 		<h4> Receive Order Details
		 			<a class="btn bg-info text-light btn-sm" @click="toggleRequestOrderDetailsInfo('')"><i class="fas fa-arrow-left"></i></a>
		 		</h4>
		 	</div>

		 	<div class="card px-3 mt-4 shadow-nohover">
				<div class="float-left mt-4">
					<label class="d-inline-block mr-1" for="show_entries_two">Show </label>
						<select @change="showEntries_two(show_entries_two)" v-model="show_entries_two" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries_two" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="send_details.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries_two">entries</label>

					<input @input="searchSendOrderDetails" type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_send_order_details" placeholder="Search" arial-label="Search" onfocus="this.value=''" v-if="filter == 'medicine name' || filter == 'category' || filter == 'unit category'">

					<select v-model="filter" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option value="medicine name">Medicine name</option>
						<option value="category">Category</option>
						<option value="unit category">Unit Category</option>
					</select>
					<label class="mr-2 float-right mt-1">Filter: </label>
				</div>

				<table class="table table-hover table-bordered text-center mt-2">
 
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Medicine Name</th>
							<th>Category</th>
							<th>Unit Category</th>
							<th>Quantity</th>
							<th>Received Quantity</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody v-if="send_details.length > 0">
						<tr v-for="(send_detail, index) in send_details" v-if="index >= startIndex && index < endIndex" v-cloak>	
							<td>{{identifyMedicineName(send_detail.purchase_received_details_id)}}</td>
							<td>{{identifyCategoryName(send_detail.purchase_received_details_id)}}</td>
							<td>{{identifyUnitCategoryName(send_detail.purchase_received_details_id)}}</td>
							<td>{{send_detail.quantity}}</td>
							<td>{{send_detail.received_quantity}}</td>
							<td>
								<div class="btn-group">
									  <button class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split py-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
									    <i class="fas fa-cog">&nbsp;</i>
									  </button>
								    <div class="dropdown-menu" style="font-size:13px;">
									    <a class="dropdown-item" @click="toggleReceivedOrderDetails(send_detail.send_order_id, send_detail.purchase_received_details_id)" :disabled="send_detail.quantity == 'No stock'"><i class="fas fa-eye">&nbsp;</i> View</a>
									    <a class="dropdown-item" @click="toggleReceivedOrder(send_detail.purchase_received_details_id, send_detail.quantity, send_detail.send_details_id, send_detail.received_quantity)" :disabled="send_detail.quantity == 'No stock' || send_detail.quantity == send_detail.received_quantity"><i class="fas fa-plus-square">&nbsp;</i> Add</a>
									</div>
								</div>
								<!-- <button @click="toggleReceivedOrderDetails(send_detail.send_order_id, send_detail.purchase_received_details_id)" :disabled="send_detail.quantity == 'No stock'" class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></button>

								<button @click="toggleReceivedOrder(send_detail.purchase_received_details_id, send_detail.quantity, send_detail.send_details_id, send_detail.received_quantity)" :disabled="send_detail.quantity == 'No stock' || send_detail.quantity == send_detail.received_quantity" class="btn btn-outline-success btn-sm"><i class="fas fa-plus-square"></i></button> -->
							</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{this.send_details.length ? startIndex + 1 : 0}} to {{endIndex>this.send_details.length? this.send_details.length :endIndex}} of {{send_details.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.send_details.length / this.show_entries_two) > 3 ? 3 : Math.ceil(this.send_details.length / this.show_entries_two)" @click="pagination_two(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextSendOrderDetails()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>

		<div v-show="accept_order_details">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h3>Medicine Details
					<a class="btn bg-info text-light btn-sm ml-2" @click="toggleReceivedOrderDetails()"><i class="fas fa-arrow-left"></i></a>
				</h3>
			</div>

			<div class="card px-3 mt-4 shadow-nohover">
	            <table class="table table-hover table-bordered text-center mt-4">
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Received Quantity</th>
							<th>Expiration Date</th>
							<th>Date Received</th>
							<th>Barcode</th>
							<th>Received By</th>
						</tr>
					</thead>
					<tbody v-if="received_order_details.length > 0">
						<tr v-for="received_order_detail in received_order_details">
							<td>{{received_order_detail.quantity}}</td>
							<td>{{received_order_detail.expiration_date}}</td>
							<td>{{received_order_detail.date_received}}</td>
							<td>{{received_order_detail.barcode}}</td>
							<td>{{received_order_detail.first_name + " " + received_order_detail.last_name}}</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="modal fade" data-keyboard="false" data-backdrop="static" id="myModal3" class="text-dark">
			<div class="modal-dialog modal-dialog-centered">
	     		<div class="modal-content" style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			          <h4 class="modal-title">Add Received Order</h4>
			          <button type="button" @click="clearReceivedOrder" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>
		        	
			        <!-- Modal body -->
			        <div class="modal-body">
			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="received_order_quantity">Quantity</label>
								<input type="number" @keypress="isNumber($event)" class="form-control" :class="{'is-invalid': received_order_quantity_error}" v-model="received_order_quantity" placeholder="Enter Quantity" required>
								<div class="invalid-feedback">{{received_order_quantity_description}}</div> 
							</div>
						</div>

						<div class="input-group form-group">
							<div class="col-md-4 ">
								<label>Expiration Date</label>
								<select v-model="expiration_month" :class="{'is-invalid': expiration_month_error}" class="form-control" id="show_entries">
									<option value="" disabled selected>Month</option>
									<option value="1">January</option>
									<option value="2">February</option>
									<option value="3">March</option>
									<option value="4">April</option>
									<option value="5">May</option>
									<option value="6">June</option>
									<option value="7">July</option>
									<option value="8">August</option>
									<option value="9">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
								</select>
								<div class="invalid-feedback">{{expiration_month_description}}</div>
							</div>

							<div class="col-md-4">
								<label for="expiration_day">Expiration Day</label>
								<input type="number" @keypress="isNumber($event)" :class="{'is-invalid': expiration_day_error}" class="form-control" v-model="expiration_day" placeholder="Day" min="1" max="31" required>
								<div class="invalid-feedback">{{expiration_day_description}}</div>
							</div>

							<div class="col-md-4">
								<label for="expiration_year">Expiration Year</label>
								<input type="number" @keypress="isNumber($event)" :class="{'is-invalid': expiration_year_error}" class="form-control" v-model="expiration_year" placeholder="Year" maxlength="4" required>
								<div class="invalid-feedback">{{expiration_year_description}}</div>
							</div>
						</div>
						<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="expiration_year">Barcode</label>
								<input type="number" @keypress="isNumber($event, $event.target.value)" class="form-control" :class="{'is-invalid': barcode_error}" v-model="barcode" placeholder="Enter Barcode" required>
								<div class="invalid-feedback">{{barcode_description}}</div>
							</div>
						</div>
					</div>

			        <!-- Modal footer -->
			        <div class="modal-footer">
			          <button @click="saveReceivedOrder" type="button" class="btn btn-primary btn-sm"><i class="far fa-save">&nbsp;</i> Save received order</button>
			        </div>
	      		</div>
	    	</div> 
		</div>
	</div>
</div>

<?php include(SHARED_PATH . '/barangay/health_worker/received_order/received_order_footer.php'); ?>