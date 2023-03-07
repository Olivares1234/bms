<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = 'Purchase Received'; ?>
<?php include(SHARED_PATH . '/pharmacist_header.php'); ?>
<div id="vue-pharmacist" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="purchase_received_info == false && purchase_received_medicine_info == false">
			<h3>Purchase Receive</h3>

			<div class="float-right mt-5">
				<div class="input-group form-group">
					<input v-on:input="searchPurchasedOrdered" type="text" class="form-control-sm" v-model="search_purchase_ordered" placeholder="Search" arial-label="Search">
				</div>
			</div>
			<div class="float-left mt-4">
				<label class="d-inline-block mr-1" for="show_entries" style="font-size: 15px;">Show </label>
					<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block" id="show_entries" style="width: auto; margin-top: 35px;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option :value="purchase_order_using_id.length">All</option>
					</select>
				<label class="d-inline-block ml-1" for="show_entries" style="font-size: 15px;">entries</label>
			</div>

			<table class="table table-hover table-bordered text-center">		
				<thead class="thead-info">
					<tr class="table-color text-light">
						<th>PO Number</th>
						<th>Date Order</th>
						<th colspan="2">Actions</th>
					</tr>
				</thead>
				<tbody v-if="purchase_order_using_id.length > 0">
					<tr v-for="(purchase_order, index) in purchase_order_using_id"  v-cloak>
						<td>{{purchase_order.purchase_order_id}}</td>
						<td>{{purchase_order.date_ordered}}</td>
						<td>
							<!-- <button @click="toggleReceivedOrderInfo(purchase_order.purchase_order_id)" :title="view_Order" class="btn bg-warning btn-sm"><i class="far fa-eye text-light"></i></button> -->

							<button @click="toggleReceivedOrderInfo(purchase_order.purchase_order_id)" :title="view_Order" class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></button>
							
						</td>
					</tr>
				</tbody>

				<tbody v-else>
					<tr>
						<td colspan="6" style="font-size: 20px"><b>No data to show</b></td>
					</tr>
				</tbody>


				<!-- <tfoot v-if="countPurchaseOrder() > 0">
					<tr>
						<th colspan="6" class="text-left">Total Amount:</th>
						<th class="text-right">&#8369;{{totalPurchaseOrder}}</th>
					</tr>
				</tfoot> -->

			</table>

			<div class="pagination float-left mt-1">
				<p class="text-dark"><h6>Showing {{startIndex + 1}} to {{endIndex>this.purchase_order_using_id.length? this.purchase_order_using_id.length :endIndex}} of {{purchase_order_using_id.length}} entries</h6></p>
			</div>

			<nav aria-label="Page navigation example" class="pagination float-right mt-1">
				<ul class="pagination">
				    <li class="page-item"><a class="page-link btn-sm" @click="previous()">Previous</a></li>
				    <li class="page-item"><a class="page-link bg-primary text-light btn-sm" v-for="num in Math.ceil(this.purchase_order_using_id.length / this.show_entries) > 3 ? 3 : Math.ceil(this.purchase_order_using_id.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
				    <li class="page-item"><a class="page-link btn-sm" @click="nextPurchaseOrder()">Next</a></li> 
				</ul>
			</nav>
		</div>

		<div v-if="purchase_received_medicine_info">
			<h3>Medicine Details
				<a class="btn bg-info text-light btn-sm" @click="toggleReceivedOrderMedicineInfo(purchase_order_id,'','','','','','')"><i class="fas fa-arrow-left"></i></a>

			</h3>

           

            <div class="mt-5 profile-tab" id="myTabContent">
                <div class="row">
                    <div class="col-md-4 table-bordered ml-3">
                        <label class="font-weight-bold"><i class="fa fa-list-ol">&nbsp;</i> Medicine Name</label>
                    </div>
                    <div class="col-md-4 table-bordered">
                        <p>{{purchase_order_received_medicine_name}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 table-bordered ml-3">
                        <label class="font-weight-bold"><i class="far fa-money-bill-alt">&nbsp;</i> Price</label>
                    </div>
                    <div class="col-md-4 table-bordered">
                        <p>&#8369;{{purchase_order_received_price}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 table-bordered ml-3">
                        <label class="font-weight-bold"><i class="fas fa-tags">&nbsp;</i>Category</label>
                    </div>
                    <div class="col-md-4 table-bordered">
                        <p>{{purchase_order_received_category}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 table-bordered ml-3">
                        <label class="font-weight-bold"><i class="fas fa-prescription-bottle">&nbsp;</i>  Unit</label>
                    </div>
                    <div class="col-md-4 table-bordered">
                        <p>{{purchase_order_received_unit}}</p>
                    </div>       
                </div>
                <div class="row">
                    <div class="col-md-4 table-bordered ml-3">
                        <label class="font-weight-bold"><i class="fas fa-boxes">&nbsp;</i> Order Quantity</label>
                    </div>
                    <div class="col-md-4 table-bordered">
                        <p>{{purchase_order_received_quantity}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 table-bordered ml-3">
                        <label class="font-weight-bold"><i class="fas fa-city">&nbsp;</i> Supplier</label>
                    </div>
                    <div class="col-md-4 table-bordered">
                        <p>{{purchase_order_received_supplier}}</p>
                    </div>
                </div>
            </div>

            <table class="table table-hover table-bordered text-center mt-5">

				<thead class="thead-info">
					<tr class="table-color text-light">
						<th>Received Quantity</th>
						<th>Expiration Date</th>
						<th>Date Received</th>
						<th>Received By</th>
					</tr>
				</thead>
				<tbody v-if="purchase_received_details.length > 0">
					<tr v-for="(purchase_received_detail, index) in purchase_received_details">
						<td>{{purchase_received_detail.received_quantity}}</td>
						<td>{{purchase_received_detail.expiration_date}}</td>
						<td>{{purchase_received_detail.date_received}}</td>
						<td>{{purchase_received_detail.first_name + " " + purchase_received_detail.middle_name + " " + purchase_received_detail.last_name}}</td>
					</tr>
				</tbody>

				<tbody v-else>
					<tr>
						<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
					</tr>
				</tbody>
			</table>
        </div>

        <div v-if="purchase_received_info == true && purchase_received_medicine_info == false">
	 		<h3> Purchase Receive Details
	 			<a class="btn bg-info text-light btn-sm" @click="toggleReceivedOrderInfo('')" class="small-box-footer"><i class="fas fa-arrow-left"></i></a>
	 		</h3>

	 		<div class="float-right mt-5">
				<div class="input-group form-group">
					<input type="text" class="form-control-sm" v-model="search_purchase_details" @input="searchPurchaseDetails" placeholder="Search" arial-label="Search">
				</div>
			</div>

			<div class="float-left mt-4">
				<label class="d-inline-block mr-1" for="show_entries" style="font-size: 15px;">Show </label>
					<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block" id="show_entries" style="width: auto; margin-top: 35px;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option :value="purchase_details.length">All</option>
					</select>
				<label class="d-inline-block ml-1" for="show_entries" style="font-size: 15px;">entries</label>
			</div>

			<table class="table table-hover table-bordered text-center">

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
				<tbody v-if="purchase_details.length > 0">
					<tr v-for="(purchase_detail, index) in purchase_details" v-cloak>	
						<td>{{purchase_detail.medicine_name}}</td>
						<td>{{purchase_detail.description}}</td>
						<td>{{purchase_detail.unit}}</td>
						<td>{{purchase_detail.quantity}}</td>
						<td>{{purchase_detail.received_quantity}}</td>
						<td>
							<button @click="toggleReceivedOrderMedicineInfo(purchase_detail.purchase_order_id, purchase_detail.supplier_medicine_id, purchase_detail.medicine_name, purchase_detail.price, purchase_detail.description, purchase_detail.unit, purchase_detail.quantity, purchase_detail.supplier_name)" :title="view_Order" class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></button>

					        <button :disabled="purchase_detail.quantity == purchase_detail.received_quantity" @click="addPurchaseReceivedButton(purchase_detail.purchase_order_id,purchase_detail.quantity, purchase_detail.supplier_medicine_id, purchase_detail.received_quantity)" class="btn btn-outline-success btn-sm" role="group"><i class="fas fa-plus"></i>
					        </button>
						</td>
					</tr>
				</tbody>

				<tbody v-else>
					<tr>
						<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
					</tr>
				</tbody>
			</table>

			<div class="pagination float-left mt-1">
				<p class="text-dark"><h6>Showing {{startIndex + 1}} to {{endIndex>this.purchase_details.length? this.purchase_details.length :endIndex}} of {{purchase_details.length}} entries</h6></p>
			</div>

			<nav aria-label="Page navigation example" class="pagination float-right mt-1">
				<ul class="pagination">
				    <li class="page-item"><a class="page-link btn-sm" @click="previous()">Previous</a></li>
				    <li class="page-item"><a class="page-link bg-primary text-light btn-sm" v-for="num in Math.ceil(this.purchase_details.length / 10) > 3 ? 3 : Math.ceil(this.purchase_details.length / 10)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
				    <li class="page-item"><a class="page-link btn-sm" @click="nextPurchaseOrder()">Next</a></li> 
				</ul>
			</nav>

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
									<label for="purchase_received_quantity">Received Quantity</label>
									<input type="number" @keypress="isNumber($event)" :class="{'is-invalid': received_quantity_error}" class="form-control" v-model="purchase_received_quantity" placeholder="Enter Quantity" required>
									<div class="invalid-feedback">This field is required!</div>
								</div>
							</div>

							<div class="input-group form-group">
								<div class="col-lg-12">
									<label for="purchase_received_expiration_date">Expiration Date</label>
									<input type="date" :class="{'is-invalid': expiration_date_error}" class="form-control" v-model="purchase_received_expiration_date" placeholder="Enter Quantity" required><div class="invalid-feedback">This field is required!</div>
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
</div>

<?php include(SHARED_PATH . '/pharmacist_footer.php'); ?>
