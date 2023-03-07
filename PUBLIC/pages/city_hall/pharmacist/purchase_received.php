<?php require_once('../../../../private/initialize.php'); ?> 
<?php $page_title = 'Dashboard'; ?>
<?php include(SHARED_PATH . '/city_hall/pharmacist/purchase_received/purchase_received_header.php'); ?>
<div id="vue-purchase-received" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="purchase_order_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4 class="float-left"> Purchase Received</h4>
			</div>

			<div class="card px-3 mt-4 shadow-nohover">
				<div class="float-left mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
					<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option :value="purchase_orders.length">All</option>
					</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<input @input="searchPurchaseReceived" v-model="search_purchase_received" type="text" class="form-control form-control-sm float-right col-md-2" placeholder="Search" arial-label="Search">
				</div>

				<table class="table table-hover table-bordered text-center mt-2">		
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>PO Number</th>
							<th>Date Order</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="purchase_orders.length > 0">
						<tr v-for="purchase_order in purchase_orders"  v-cloak>
							<td>{{purchase_order.purchase_order_id}}</td>
							<td>{{purchase_order.date_ordered}}</td>
							<td>

								<button @click="togglePurchaseOrderDetails(purchase_order.purchase_order_id)" class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></button>
								
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
					<p class="float-left">Showing {{this.purchase_orders.length ? startIndex + 1 : 0}} to {{endIndex>this.purchase_orders.length? this.purchase_orders.length :endIndex}} of {{purchase_orders.length}} entries</p>
				

					<nav aria-label="Page navigation example">
						<ul class="pagination justify-content-end">
					    	<li class="page-item">
					    		<a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    	</li>
					    	<li class="page-item">
					    		<a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.purchase_orders.length / this.show_entries) > 3 ? 3 : Math.ceil(this.purchase_orders.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}
					    		</a>
					    	</li>
					    	<li class="page-item">
					    		<a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextPurchaseOrder()">Next</a>
					    	</li>
					  	</ul>
					</nav>
				</div>
			</div>
		</div>
		<div v-if="purchase_order_details_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4 class="float-left"> Purchase Received Details
					<a @click="togglePurchaseOrderDetails('')" class="btn bg-info text-light btn-sm"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>
			<div class="card px-3 mt-4 shadow-nohover">
				<div class="float-left mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
					<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option :value="purchase_orders.length">All</option>
					</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<input @input="searchPurchaseReceivedDetails" type="text" v-model="search_purchase_details" class="form-control form-control-sm float-right col-md-2" placeholder="Search" arial-label="Search" v-if="filter == 'name' || filter == 'category' || filter == 'unit' || filter == 'quantity' || filter == 'received'">

					<select v-model="filter" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option value="name">Medicine name</option>
						<option value="category">Category</option>
						<option value="unit">Unit Category</option>
						<option value="quantity">Quantity</option>
						<option value="received">Received Quantity</option>
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
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="purchase_order_details.length > 0">
						<tr v-for="purchase_order_detail in purchase_order_details"  v-cloak>
							<td>{{identifyMedicineName(purchase_order_detail.supplier_medicine_id)}}</td>
							<td>{{identifyCategory(purchase_order_detail.supplier_medicine_id)}}</td>
							<td>{{identifyUnitCategory(purchase_order_detail.supplier_medicine_id)}}</td>
							<td>{{purchase_order_detail.quantity}}</td>
							<td>{{purchase_order_detail.received_quantity}}</td>
							<td>

								<div class="btn-group">
									  <button class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split py-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
									    <i class="fas fa-cog">&nbsp;</i>
									  </button>
								    <div class="dropdown-menu" style="font-size:13px;">
									    <a class="dropdown-item" @click="togglePurchaseReceivedDetails(purchase_order_detail.supplier_medicine_id, purchase_order_detail.price, purchase_order_detail.quantity, purchase_order_detail.supplier_name)"><i class="fa fa-edit">&nbsp;</i> View</a>
									    <a class="dropdown-item":disabled="purchase_order_detail.quantity == purchase_order_detail.received_quantity" @click="toggleAddPurchaseReceivedModal(purchase_order_detail.purchase_details_id, purchase_order_detail.supplier_medicine_id, purchase_order_detail.quantity, purchase_order_detail.received_quantity)"><i class="fa fa-save">&nbsp;</i> Add</a>
									</div>
								</div>
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
					<p class="float-left">Showing {{this.purchase_order_details.length ? startIndex + 1 : 0}} to {{endIndex>this.purchase_order_details.length? this.purchase_order_details.length :endIndex}} of {{purchase_order_details.length}} entries</p>
				

					<nav aria-label="Page navigation example">
						<ul class="pagination justify-content-end">
					    	<li class="page-item">
					    		<a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    	</li>
					    	<li class="page-item">
					    		<a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.purchase_order_details.length / this.show_entries) > 3 ? 3 : Math.ceil(this.purchase_order_details.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}
					    		</a>
					    	</li>
					    	<li class="page-item">
					    		<a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextPurchaseOrder()">Next</a>
					    	</li>
					  	</ul>
					</nav>
				</div>

				<div class="modal fade" data-keyboard="false" data-backdrop="static" id="myModal3" class="text-dark">
					<div class="modal-dialog modal-dialog-centered">
			     		<div class="modal-content" style="height:auto">
				      
					        <!-- Modal Header -->
					        <div class="modal-header">
					          <h4 class="modal-title">Add Purchase Receive</h4>
					          <button @click="closePurchasReceivedModal" type="button" class="btn closing-modal"><i class="fas fa-times"></i></button>
					        </div>
				        	
					        <!-- Modal body -->
					        <div class="modal-body">
					         	<div class="input-group form-group">
									<div class="col-lg-12">
										<label for="received_quantity">Received Quantity</label>
										<input type="number" @keypress="isNumber($event)" :class="{'is-invalid': received_quantity_error}" class="form-control" v-model="received_quantity" placeholder="Enter Quantity" required>
										<div class="invalid-feedback">This field is required!</div>
									</div>
								</div>

								<div class="input-group form-group">
									<div class="col-md-4 ">
										<label>Expiration Month</label>
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
										<label for="barcode">Barcode</label>
										<input type="number" @keypress="isNumber($event, $event.target.value)" class="form-control" :class="{'is-invalid': barcode_error}" v-model="barcode">
										<div class="invalid-feedback">{{barcode_description}}</div>
									</div>
								</div>
							</div>

					        <!-- Modal footer -->
					        <div class="modal-footer">
					          <button @click="savePurchaseReceived" type="button" class="btn btn-primary btn-sm" ><i class="far fa-save">&nbsp;</i> Save purchase received</button>
					        </div>
			      		</div>
			    	</div>
			    </div>
			</div>
		</div>
		<div v-if="purchase_received_details_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4 class="float-left"> Medicine Received Details
					<a @click="togglePurchaseReceivedDetails('')" class="btn bg-info text-light btn-sm"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>
			<div class="card px-3 pb-3 pt-3 mt-4 shadow-nohover">
				<div class="mt-2" id="myTabContent" style="margin-left: 230px">
		            <div class="row">
		                <div class="col-md-4 table-bordered ml-3">
		                    <label class="font-weight-bold"><i class="fa fa-list-ol">&nbsp;</i> Medicine Name</label>
		                </div>
		                <div class="col-md-4 table-bordered">
		                    <p>{{identifyMedicineName(supplier_medicine_id)}}</p>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-md-4 table-bordered ml-3">
		                    <label class="font-weight-bold"><i class="far fa-money-bill-alt">&nbsp;</i> Price</label>
		                </div>
		                <div class="col-md-4 table-bordered">
		                    <p>&#8369;{{price}}</p>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-md-4 table-bordered ml-3">
		                    <label class="font-weight-bold"><i class="fas fa-tags">&nbsp;</i>Category</label>
		                </div>
		                <div class="col-md-4 table-bordered">
		                    <p>{{identifyCategory(supplier_medicine_id)}}</p>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-md-4 table-bordered ml-3">
		                    <label class="font-weight-bold"><i class="fas fa-prescription-bottle">&nbsp;</i>  Unit</label>
		                </div>
		                <div class="col-md-4 table-bordered">
		                    <p>{{identifyUnitCategory(supplier_medicine_id)}}</p>
		                </div>       
		            </div>
		            <div class="row">
		                <div class="col-md-4 table-bordered ml-3">
		                    <label class="font-weight-bold"><i class="fas fa-boxes">&nbsp;</i> Order Quantity</label>
		                </div>
		                <div class="col-md-4 table-bordered">
		                    <p>{{order_quantity}}</p>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-md-4 table-bordered ml-3">
		                    <label class="font-weight-bold"><i class="fas fa-city">&nbsp;</i> Supplier</label>
		                </div>
		                <div class="col-md-4 table-bordered">
		                    <p>{{supplier}}</p>
		                </div>
		            </div>
		        </div>
		    </div>
		    <div class="card px-3 pb-3 pt-3 mt-4 shadow-nohover">

		        <table class="table table-hover table-bordered text-center mt-2">
		        	<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Received Quantity</th>
							<th>Expiration Date</th>
							<th>Date Received</th>
							<th>Received By</th>
						</tr>
					</thead>
					<tbody v-if="purchase_received_details.length > 0">
						<tr v-for="purchase_received_detail in purchase_received_details">
							<td>{{purchase_received_detail.received_quantity}}</td>
							<td>{{purchase_received_detail.expiration_date}}</td>
							<td>{{purchase_received_detail.date_received}}</td>
							<td>{{purchase_received_detail.first_name + " " + purchase_received_detail.last_name}}</td>
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
	</div>
</div>
<?php include(SHARED_PATH . '/city_hall/pharmacist/purchase_received/purchase_received_footer.php'); ?>