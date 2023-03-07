<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = 'Purchase Received'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>
<div id="vue-app" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="purchase_received_info == false && purchase_received_medicine_info == false">
			<h3>Purchase Received</h3>

			<div class="float-right mt-4">
				<div class="input-group form-group">
					<input v-on:input="searchPurchasedOrdered" type="text" class="form-control-sm py-2 border" v-model="search_purchase_ordered" placeholder="Search" arial-label="Search">
				</div>
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

							<button @click="toggleReceivedOrderInfo(purchase_order.purchase_order_id)" :title="view_Order" class="btn bg-warning btn-sm"><i class="far fa-eye text-light"></i></button>
							
						</td>
					</tr>
				</tbody>

				<tbody v-else>
					<tr>
						<td colspan="6" style="font-size: 20px"><b>No data to show</b></td>
					</tr>
				</tbody>

			</table>

			<div class="pagination float-left mt-1">
				<p class="text-dark"><h6>Showing {{startIndex + 1}} to {{endIndex>this.purchase_order_using_id.length? this.purchase_order_using_id.length :endIndex}} of {{purchase_order_using_id.length}} entries</h6></p>
			</div>

			<nav aria-label="Page navigation example" class="pagination float-right mt-1">
				<ul class="pagination">
				    <li class="page-item"><a class="page-link btn-sm" @click="previous()">Previous</a></li>
				    <li class="page-item"><a class="page-link bg-primary text-light btn-sm" v-for="num in Math.ceil(this.purchase_order_using_id.length / 10) > 3 ? 3 : Math.ceil(this.purchase_order_using_id.length / 10)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
				    <li class="page-item"><a class="page-link btn-sm" @click="nextPurchaseOrder()">Next</a></li> 
				</ul>
			</nav>
		</div>
		<div v-if="purchase_received_medicine_info">
			<h3>Medicine Details
				<a class="btn bg-info text-light btn-sm" @click="toggleReceivedOrderMedicineInfo('',purchase_order_id,'','','','')"><i class="fas fa-arrow-left"></i></a>

			</h3>

            <div class="container emp-profile">
	            <form method="post">
                    <div class="col-md-4">
                        <div class="profile-work">
                            
                        </div>
                    </div>

                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="font-weight-bold">Medicine Name</label>
                                </div>
                                <div class="col-md-3">
                                    <p>{{purchase_order_received_medicine_name}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="font-weight-bold">Price</label>
                                </div>
                                <div class="col-md-3">
                                    <p>&#8369;{{purchase_order_received_price}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="font-weight-bold">Category</label>
                                </div>
                                <div class="col-md-3">
                                    <p>{{purchase_order_received_category}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="font-weight-bold">Unit</label>
                                </div>
                                <div class="col-md-3">
                                    <p>{{purchase_order_received_unit}}</p>
                                </div>       
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="font-weight-bold">Order Quantity</label>
                                </div>
                                <div class="col-md-3">
                                    <p>{{purchase_order_received_quantity}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-hover table-bordered text-center mt-4">

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
	            </form>           
        	</div><!-- End of View Transaction -->
		</div>

		<div v-if="purchase_received_info == true && purchase_received_medicine_info == false">
	 		<h3> Purchase Receive Details
	 			<a class="btn bg-info text-light btn-sm" @click="toggleReceivedOrderInfo('')" class="small-box-footer"><i class="fas fa-arrow-left"></i></a>
	 		</h3>

	 		<div class="float-right mt-5">
				<div class="input-group form-group">
					<input type="text" class="form-control-sm py-2 border" v-model="search_medicine" @keyup.enter="searchMedicine" placeholder="Search" arial-label="Search">
				</div>
			</div>
			
			<div class="float-left mt-4">
	 			<p class="text-danger font-weight-bold" style="font-size: 17px; margin-top: 35px;">Purchase Order No: {{purchase_order_id}}</p>
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
				<tbody v-if="purchase_orders.length > 0">
					<tr v-for="(purchase_order, index) in purchase_orders" :class="{editing: purchase_order == editedUser}" v-cloak>	
						<td>{{purchase_order.medicine_name}}</td>
						<td>{{purchase_order.description}}</td>
						<td>{{purchase_order.unit}}</td>
						<td>{{purchase_order.quantity}}</td>
						<td>{{purchase_order.received_quantity}}</td>
						<td>
							<button @click="toggleReceivedOrderMedicineInfo(purchase_order.purchase_order_details_id, purchase_order.purchase_order_id, purchase_order.medicine_name, purchase_order.price, purchase_order.description, purchase_order.unit, purchase_order.quantity)" :title="view_Order" class="btn bg-warning btn-sm"><i class="far fa-eye text-light"></i></button>

					       <button :disabled="purchase_order.quantity == purchase_order.received_quantity" @click="addPurchaseReceivedButton(purchase_order.purchase_order_id,purchase_order.quantity, purchase_order.supplier_medicine_id, purchase_order.received_quantity)" class="btn bg-success btn-sm" role="group"><i class="fas fa-plus text-light"></i>
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
				<p class="text-dark"><h6>Showing {{startIndex + 1}} to {{endIndex>this.purchase_orders.length? this.purchase_orders.length :endIndex}} of {{purchase_orders.length}} entries</h6></p>
			</div>

			<nav aria-label="Page navigation example" class="pagination float-right mt-1">
				<ul class="pagination">
				    <li class="page-item"><a class="page-link btn-sm" @click="previous()">Previous</a></li>
				    <li class="page-item"><a class="page-link bg-primary text-light btn-sm" v-for="num in Math.ceil(this.purchase_orders.length / 10) > 3 ? 3 : Math.ceil(this.purchase_orders.length / 10)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
				    <li class="page-item"><a class="page-link btn-sm" @click="nextPurchaseOrder()">Next</a></li> 
				</ul>
			</nav>

			<div class="modal fade" data-keyboard="false" data-backdrop="static" id="myModal3" class="text-dark">
				<div class="modal-dialog modal-dialog-centered">
		     		<div class="modal-content" style="height:auto">
			      
				        <!-- Modal Header -->
				        <div class="modal-header">
				          <h4 class="modal-title">Add Purchase</h4>
				          <button @click="closePurchasReceivedModal" type="button" class="close"><i class="fas fa-times"></i></button>
				        </div>
			        	
				        <!-- Modal body -->
				        <div class="modal-body">
				         	<div class="input-group form-group">
								<div class="col-lg-12">
									<label for="purchase_received_quantity">Received Quantity</label>
									<input type="number" @keypress="isNumber($event)" class="form-control" id="purchase_received_quantity" name="purchase_received_quantity" v-model="purchase_received_quantity" placeholder="Enter Quantity" required>
								</div>
							</div>

							<div class="input-group form-group">
								<div class="col-lg-12">
									<label for="purchase_received_expiration_date">Expiration Date</label>
									<input type="date" class="form-control" id="purchase_received_expiration_date" name="purchase_received_expiration_date" v-model="purchase_received_expiration_date" placeholder="Enter Quantity" required>
								</div>
							</div>
						</div>

				        <!-- Modal footer -->
				        <div class="modal-footer">
				          <button @click="addPurchaseReceived" type="button" class="btn btn-primary" ><i class="far fa-save">&nbsp;</i> Save purchase received</button>
				        </div>
		      		</div>
		    	</div> 
			</div>
		</div>
	</div>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
