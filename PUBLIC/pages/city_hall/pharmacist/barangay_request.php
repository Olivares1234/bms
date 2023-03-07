<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Barangay Request'; ?>
<?php include(SHARED_PATH . '/city_hall/pharmacist/barangay_request/barangay_request_header.php'); ?>

<div id="vue-barangay-request" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="request_order_info">
			<div class="card px-3 pb-1 pt-3">
				<h4>Request Per Barangay</h4>
			</div>

			<div class="card px-3 mt-4">
				<div class="float-left mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="request_orders.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<!-- search for name -->
					<input @input="searchRequestOrder" type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_request_order" placeholder="Search" arial-label="Search" onfocus="this.value=''" v-if="filter == 'id' || filter == 'date' || filter == 'barangay'">
					<!--               -->

					<!-- search for status -->
					<select @change="searchRequestOrderStatus" v-model="search_request_order_status" class="form-control form-control-sm d-inline-block col-md-2 float-right" style="width: auto;" v-if="filter == 'status'">
						<option value="" disabled selected>Select Status</option>
						<option value="">All</option>
						<option value="Pending">Pending</option>
						<option value="Completed">Completed</option>
					</select>
					
					<select v-model="filter" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option value="id">ID</option>
						<option value="date">Date request</option>
						<option value="status">Status</option>
						<option value="barangay">Barangays</option>
					</select>
					<label class="mr-2 float-right mt-1">Filter: </label>
				</div>

				<table class="table table-hover table-bordered text-center mt-2">		
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Request Order No.</th>
							<th>Request Date</th>
							<th>Status</th>	
							<th>Barangay</th>				
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="request_orders.length > 0">
						<tr v-for="(request_order, index) in request_orders" v-if="index >= startIndex && index < endIndex" v-cloak> 
							<td>{{request_order.request_order_id}}</td>
							<td>{{request_order.date_request}}</td>
							<td v-if="request_order.request_order_status == 'Pending'"><h6 class="text-light bg-warning rounded w-75 mx-auto">{{request_order.request_order_status}}</h6></td>
							<td v-else><h6 class="text-light bg-success rounded w-75 mx-auto">{{request_order.request_order_status}}</h6></td>
							<td>{{request_order.barangay_name}}</td>
							<td>

								<div class="btn-group">
									  <button class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split py-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
									    <i class="fas fa-cog">&nbsp;</i>
									  </button>
								    <div class="dropdown-menu" style="font-size:13px;">
									    <a class="dropdown-item" @click="toggleRequestOrderDetailsInfo(request_order.request_order_id)"><i class="fas fa-eye">&nbsp;</i> View</a>
									    <a class="dropdown-item" @click="toggleReceiptHistory(request_order.request_order_id, request_order.barangay_name, request_order.contact_no)" :disabled="request_order.request_order_status != 'Completed'"><i class="fas fa-print">&nbsp;</i> Print</a>
									    <a class="dropdown-item" @click="toggleRequestOrderInfo(request_order.request_order_id, request_order.barangay_name, request_order.contact_no,request_order.request_order_status)" :disabled="request_order.request_order_status == 'Completed'"><i class="fas fa-arrow-alt-circle-right">&nbsp;</i> Add</a>
									</div>
								</div>

								<!-- <button @click="toggleRequestOrderDetailsInfo(request_order.request_order_id)" class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></button>

								<button @click="toggleReceiptHistory(request_order.request_order_id, request_order.barangay_name, request_order.contact_no)" class="btn btn-outline-primary btn-sm" :disabled="request_order.request_order_status != 'Completed'"><i class="fas fa-print"></i></button>

								<button class="btn btn-outline-success btn-sm" @click="toggleRequestOrderInfo(request_order.request_order_id, request_order.barangay_name, request_order.contact_no,request_order.request_order_status)" :disabled="request_order.request_order_status == 'Completed'"><i class="fas fa-arrow-alt-circle-right"></i></button> -->
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
					<p class="float-left">Showing {{this.request_orders.length? startIndex + 1 : 0}} to {{endIndex>this.request_orders.length? this.request_orders.length :endIndex}} of {{request_orders.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.request_orders.length / this.show_entries) > 3 ? 3 : Math.ceil(this.request_orders.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextBeneficiaryDetails()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>

		<div v-if="request_order_medicine_info">
			<div class="card px-3 pb-1 pt-3">
				<h4>Medicine Details
					<a class="btn bg-info text-light btn-sm ml-2" @click="toggleRequestOrderDetailsInfo('')"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 mt-4">
	            <table class="table table-hover table-bordered text-center mt-4">

					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Date Send</th>
							<th>Send By</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="send_order_detail in send_order_details">
							<td>{{send_order_detail.date_send}}</td>
							<td>{{send_order_detail.first_name + " " + send_order_detail.last_name}}</td>
						</tr>
					</tbody>
				</table>
			</div>
        </div>

		<div v-if="request_order_info == false && request_order_receipt == false && request_order_medicine_info == false && request_receipt_history == false">
			<div class="card px-3 pb-1 pt-3">
				<h4>Request Details
					<a @click="toggleRequestOrderInfo" class="btn bg-info text-light btn-sm ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<!-- <div class="float-right mt-5">
				<div class="input-group form-group">
					<input @input="searchRequestOrderDetails" type="text" class="form-control-sm" v-model="search_request_order_details" placeholder="Search Request" arial-label="Search">
				</div>
			</div> -->


			<div class="card px-3 pb-3 mt-4">
				<div class="float-left mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="request_orders.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<!-- search for name -->
					<input @input="searchRequestOrderDetails" type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_request_order_details" placeholder="Search" arial-label="Search" onfocus="this.value=''" v-if="filter_two == 'name' || filter_two == 'category' || filter_two == 'unit' || filter_two == 'price'">
					<!--               -->
					
					<select v-model="filter_two" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option value="name">Medicine name</option>
						<option value="category">Category</option>
						<option value="unit">Unit Category</option>
						<option value="price">Price</option>
					</select>
					<label class="mr-2 float-right mt-1">Filter: </label>
				</div>

				<table class="table table-hover table-bordered text-center mt-2">		
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Medicine name</th>
							<th>Category</th>	
							<th>Unit Category</th>
							<th>Price</th>	
							<th>Approved Quantity</th>		
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="request_details.length > 0">
						<tr v-for="(request_detail, index) in request_details" v-cloak> 
							<td>{{identifyMedicineName(request_detail.purchase_received_details_id)}}</td>
							<td>{{identifyCategoryName(request_detail.purchase_received_details_id)}}</td>
							<td>{{identifyUnitCategoryName(request_detail.purchase_received_details_id)}}</td>
							<td>{{identifyMedicinePrice(request_detail.purchase_received_details_id)}}</td>
							<td v-if="request_detail.no_stock"><h6 class="text-light bg-danger rounded w-50 mx-auto">{{request_detail.delivered_quantity | stock}}</h6></td>
							<td v-else>{{request_detail.delivered_quantity}}</td>
							<td>
						        <button @click="deliverModal(request_detail.purchase_received_details_id, request_detail.delivered_quantity)" class="btn btn-outline-success btn-sm" :disabled="request_detail.no_stock || request_detail.delivered_quantity > 0"><i class="fas fa-plus"></i>
						        </button>

						        <button @click="updateDeliverModal(request_detail.purchase_received_details_id, request_detail.delivered_quantity)" class="btn btn-outline-primary btn-sm" v-if="request_detail.delivered_quantity > 0"><i class="fas fa-edit" ></i>
						        </button>
							</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="6" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
				</table>

				<div class="float-right mt-2">
					<button @click="addSendOrder" class="btn btn-sm text-light bg-primary font-weight-bold float-right"><i class="far fa-save">&nbsp;</i> Save Send Order</button>
				</div>
			</div>
		</div>

		<div class="modal fade" data-keyboard="false" data-backdrop="static" id="myModal" class="text-dark">
			<div class="modal-dialog">
	     		<div class="modal-content" style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			          <h4 class="modal-title">Add Quantity</h4>
			          <button @click="clearRequestQuantity" class="btn closing-modal"><i class="fas fa-times"></i></button>
			        </div>
		        	
			        <!-- Modal body -->
			        <div class="modal-body" id="modal-less-input">
			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="send_quantity">Approved Quantity</label>
								<input type="text" :class="{'is-invalid': send_quantity_error}" class="form-control" @keypress="isNumber($event)" v-model="send_quantity" placeholder="Enter Quantity" required>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>
					</div>

			        <!-- Modal footer -->
			        <div class="modal-footer">
			          <button type="button" @click="addApproveQuantity"  class="btn btn-primary btn-sm" ><i class="far fa-save">&nbsp;</i> Save</button>
			        </div>
	      		</div>
	    	</div> 
		</div>

		<div class="modal fade" data-keyboard="false" data-backdrop="static" id="myModal1" class="text-dark">
			<div class="modal-dialog modal-centered">
	     		<div class="modal-content" style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			          <h4 class="modal-title">Update Quantity</h4>
			          <button @click="clearRequestQuantity" class="btn closing-modal"><i class="fas fa-times"></i></button>
			        </div>
		        	
			        <!-- Modal body -->
			        <div class="modal-body" id="modal-less-input">
			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="send_quantity">Approved Quantity</label>
								<input type="text" :class="{'is-invalid': send_quantity_error}" class="form-control" @keypress="isNumber($event)" v-model="send_quantity" placeholder="Enter Quantity" required>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>
					</div>

			        <!-- Modal footer -->
			        <div class="modal-footer">
			          <button type="button" @click="updateApprovedQuantity" class="btn btn-primary btn-sm" ><i class="far fa-save">&nbsp;</i> Save</button>
			        </div>
	      		</div>
	    	</div> 
		</div>

		<div v-show="request_order_receipt">
			<div class="wrapper">
  				<div class="content-wrapper">
    				<div class="container">
			          	<section class="content mt-4">
			            	<div class="row">
				      			<div class="col-md-12">
			                
			                	<div class="box-body">
			                		<table class="table">
			                    		<thead>
			                      			<tr>
						                        <th colspan="12"><h5 class="font-weight-bold">Boticab City of Hall</h5></th>
						                        <th colspan="12"><h6>Send Order No:</h6><h6 style="color: red">{{generateSendOrderId()}}</h6></th>
						                    </tr>
			                      			<tr>
						                        <th colspan="12"><h6>F.B. Bailon Street, Cabuyao, Laguna, 4025, Philippines</h6></th>
						                        <th colspan="12"></th>
			                      			</tr>
			                      			<tr>
						                        <th colspan="12"><h6>Phone : (047) 578 5192</h6></th>
						                        <th colspan="12"></th>
			                      			</tr>
			                      
			                    		</thead>
			                    		<thead>
				                    	<tr>
					                        <th colspan="6">To :</th>
					                        <td colspan="6"><u>Brgy. {{request_order_barangay_name}}</u></td>
					                        <th colspan="6">Date :</th>
					                        <td colspan="6"><u><?php echo date("M d, Y");?> Time <?php echo date("h:i A");?></u></td>
				                      	</tr>
					                    <tr>
					                    	<th colspan="6">Address</th>
					                        <td colspan="6"><u>Health Center {{request_order_barangay_name}}, Cabuyao, 4025, Philippines</u></td>
					                        <th colspan="6">Contact no :</th>
					                        <td colspan="6"><u>{{request_order_contact_number}}</u></td>
					                    </tr>
			                      
			                    		</thead>
			                  		</table>
			                  		<table class="table table-bordered">
			                    		<thead>			                        
						                    <tr style="border: solid 1px #000">
						                      	<th>Medicine name</th>
												<th>Category</th>	
												<th>Unit Category</th>
												<th>Price</th>	
												<th>Quantity</th>
						                        <td class="font-weight-bold">Total</td>			
						                    </tr>
			                    		</thead>
			                    		<tbody>				                      	
						                    <tr v-for="(request_detail, index) in request_details">
						                        <td>{{identifyMedicineName(request_detail.purchase_received_details_id)}}</td>
												<td>{{identifyCategoryName(request_detail.purchase_received_details_id)}}</td>
												<td>{{identifyUnitCategoryName(request_detail.purchase_received_details_id)}}</td>
												<td>&#8369;{{identifyMedicinePrice(request_detail.purchase_received_details_id)}}</td>
												<td>{{request_detail.delivered_quantity |stock}}</td>
												<td class="text-right">&#8369;{{identifyMedicinePrice(request_detail.purchase_received_details_id) * request_detail.delivered_quantity | currency}}</td>  
						                    </tr>
						                    <tr>
						                    	<td class="text-right font-weight-bold" colspan="5">Total Amount :</td>
						                    	<td class="text-right" colspan="6">&#8369;{{totalAmount | currency}}</td> 
						                    </tr>
						                    </tbody>
			                  		</table>

			                  		<div class="mt-5">
			                  			<label class="font-weight-bold">Prepared by: <u><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']?></u></label>
			                  			<label class="float-right font-weight-bold">________________________</label><br>
			                  			<label class="font-weight-bold"></label>
			                  			<label class="float-right font-weight-bold mr-4">Receiver's Signature</label>
			                  		</div>
			                	</div>
								</div> 
			            	</div>
			            </section>
			            <div class="mt-3">
			                <a class ="btn btn-primary text-light float-left ml-2 btn-sm" onclick = "window.print()"><i class ="fa fa-print"></i> Print</a>
			            </div>
    				</div>
				</div>
			</div>	
		</div>

		<div v-show="request_receipt_history">
			<div class="wrapper">
  				<div class="content-wrapper">
    				<div class="container">
			          	<section class="content mt-4">
			            	<div class="row">
				      			<div class="col-md-12">
			                
			                	<div class="box-body">
			                		<a @click="toggleReceiptHistory" class="btn bg-info text-light btn-sm mb-1"><i class="fas fa-arrow-left"></i></a>
			                		<table class="table">
			                    		<thead>
			                      			<tr>
						                        <th colspan="12"><h5 class="font-weight-bold">Boticab City of Hall</h5></th>
						                        <th colspan="12"><h6>Send Order No:</h6><h6 style="color: red">{{identifySendOrderID(request_order_id)}}</h6></th>
						                    </tr>
			                      			<tr>
						                        <th colspan="12"><h6>F.B. Bailon Street, Cabuyao, Laguna, 4025, Philippines</h6></th>
						                        <th colspan="12"></th>
			                      			</tr>
			                      			<tr>
						                        <th colspan="12"><h6>Phone : (047) 578 5192</h6></th>
						                        <th colspan="12"></th>
			                      			</tr>
			                      
			                    		</thead>
			                    		<thead>
				                    	<tr>
					                        <th colspan="6">To :</th>
					                        <td colspan="6"><u>Brgy. {{request_order_barangay_name}}</u></td>
					                        <th colspan="6">Date :</th>
					                        <td colspan="6"><u><?php echo date("M d, Y");?> Time <?php echo date("h:i A");?></u></td>
				                      	</tr>
					                    <tr>
					                    	<th colspan="6">Address</th>
					                        <td colspan="6"><u>Health Center {{request_order_barangay_name}}, Cabuyao, 4025, Philippines</u></td>
					                        <th colspan="6">Contact no :</th>
					                        <td colspan="6"><u>{{request_order_contact_number}}</u></td>
					                    </tr>
			                      
			                    		</thead>
			                  		</table>
			                  		<table class="table table-bordered">
			                    		<thead>			                        
						                    <tr style="border: solid 1px #000">
						                      	<th>Medicine name</th>
												<th>Category</th>	
												<th>Unit Category</th>
												<th>Price</th>	
												<th>Quantity</th>
						                        <td class="font-weight-bold">Total</td>			
						                    </tr>
			                    		</thead>
			                    		<tbody>				                      	
						                    <tr v-for="(request_detail, index) in request_details">
						                        <td>{{identifyMedicineName(request_detail.purchase_received_details_id)}}</td>
												<td>{{identifyCategoryName(request_detail.purchase_received_details_id)}}</td>
												<td>{{identifyUnitCategoryName(request_detail.purchase_received_details_id)}}</td>
												<td>&#8369;{{identifyMedicinePrice(request_detail.purchase_received_details_id)}}</td>
												<td>{{request_detail.delivered_quantity |stock}}</td>
												<td class="text-right">&#8369;{{identifyMedicinePrice(request_detail.purchase_received_details_id) * request_detail.delivered_quantity}}</td>
						                    </tr>
						                    <tr>
						                    	<td class="text-right font-weight-bold" colspan="5">Total Amount :</td>
						                    	<td class="text-right" colspan="6">&#8369;{{totalAmount | currency}}</td> 
						                    </tr>
						                    </tbody>
			                  		</table>

			                  		<div class="mt-5">
			                  			<label class="font-weight-bold">Prepared by: <u><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']?></u></label>
			                  			<label class="float-right font-weight-bold">________________________</label><br>
			                  			<label class="font-weight-bold"></label>
			                  			<label class="float-right font-weight-bold mr-4">Receiver's Signature</label>
			                  		</div>
			                	</div>
								</div> 
			            	</div>
			            </section>
			            <div class="mt-3">
			                <a class ="btn btn-primary text-light float-left ml-2 btn-sm" onclick = "window.print()"><i class ="fa fa-print"></i> Print</a>
			            </div>
    				</div>
				</div>
			</div>	
		</div>
	</div>
</div>

<?php include(SHARED_PATH . '/city_hall/pharmacist/barangay_request/barangay_request_footer.php'); ?>
