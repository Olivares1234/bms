<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Request Order'; ?>
<?php $barangay_name = 'Barangay ' . $_SESSION['barangay_name']; ?>
<?php include(SHARED_PATH . '/barangay/admin/request_order/request_order_header.php'); ?>

<div id="vue-request-order" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="request_order_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>List of Request Order
					<a @click="toggleAddRequestOrder" class="btn bg-success text-light btn-sm font-weight-bold ml-2"><i class="fas fa-plus"></i></a>
				</h4>
			</div>
			<div class="card px-3 pb-3 mt-4">
				<div class="float-left mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="request_orders_per_barangays.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>
				</div>

				<table class="table table-hover table-bordered text-center mt-2">		
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Request Order ID</th>
							<th>Status</th>
							<th>Date Request</th>
							<th>Barangay</th>
							<th>Request By</th>
						</tr>
					</thead>
					<tbody v-if="request_orders_per_barangays.length > 0">
						<tr v-for="(request_orders_per_barangay, index) in request_orders_per_barangays" v-if="index >= startIndex && index < endIndex" v-cloak>
							<td>{{request_orders_per_barangay.request_order_id}}</td>
							<td>{{request_orders_per_barangay.request_order_status}}</td>
							<td>{{request_orders_per_barangay.date_request}}</td>
							<td>{{identifyBarangayName(request_orders_per_barangay.barangay_id)}}</td>
							<td>{{identifyUserFirstName(request_orders_per_barangay.user_id) + " " + identifyUserLastName(request_orders_per_barangay.user_id)}}</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="7" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
				</table>

				<div class="mt-1">
					<nav aria-label="Page navigation example ">
					  <ul class="pagination justify-content-end float-left">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.request_orders_per_barangays.length / this.show_entries) > 3 ? 3 : Math.ceil(this.request_orders_per_barangays.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextActiveBeneficiary()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>

		<div v-show="show_request_order">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Request Medicine
					<a @click="toggleAddRequestOrder" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 pb-3 mt-4">
				<div class="float-left mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="request_medicines.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<button @click="showCityHallMedicine" class="btn btn-success btn-sm font-weight-bold float-right" :title="view_Medicine">
						<i class="fas fa-list text-light">&nbsp;</i> View Medicine
					</button>
				</div>

				<table class="table table-hover table-bordered text-center mt-2">		
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Medicine Name</th>
							<th>Category</th>
							<th>Unit Category</th>
							<th>Price</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="request_medicines.length > 0">
						<tr v-for="(request_medicine, index) in request_medicines" v-if="index >= startIndex && index < endIndex" v-cloak>
							<td>{{request_medicine.medicine_name}}</td>
							<td>{{request_medicine.category}}</td>
							<td>{{request_medicine.unit_category}}</td>
							<td>{{request_medicine.price}}</td>
							<td colspan="2">
								<button @click="removeRequestMedicines(index)" :title="delete_Row" class="delete btn btn-outline-danger btn-sm" role="group"><i class="fas fa-trash-alt"></i>
								</button>
							</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="7" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
				</table>

				<div class="mt-1">
					<button @click="saveRequestOrder" class="btn bg-primary text-light btn-sm font-weight-bold float-right">
						<i class="far fa-save">&nbsp;</i> Save Request Order
					</button>

					<nav aria-label="Page navigation example ">
					  <ul class="pagination justify-content-end float-left">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.request_medicines.length / this.show_entries) > 3 ? 3 : Math.ceil(this.request_medicines.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextActiveBeneficiary()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>

			<div class="modal" id="myModal6" data-keyboard="false" data-backdrop="static" class="text-dark" tabindex="1">

			    <div class="modal-dialog modal-lg">
			     	<div class="modal-content">
			     		<div class="modal-header">
			     			<h3>List of Medicine {{"(" + medicines.length + ")"}}</h3>
			     			<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			     		</div>

					    <!-- Modal body -->
						<div class="modal-body" id="modal-medicine">
							<div>
								<div class="float-right mt-4">
									<label class="mr-2 mt-1">Filter: </label>
									<select v-model="filter" class="form-control form-control-sm d-inline-block" style="width: auto;">
										<option value="" disabled selected>Select Field name</option>
										<option value="medicine name">Medicine Name</option>
										<option value="category">Category</option>
										<option value="unit category">Unit Category</option>
									</select>
									<input @input="searchCityHallAvaialableMedicine" type="text" class="form-control-sm ml-2" v-model="search_medicine" placeholder="Search" arial-label="Search">
								</div>
							</div>
							
							<table class="table table-hover table-bordered text-center mt-4">
								<thead class="thead-info">
									<tr class="table-color text-light">
										<th>Medicine Name</th>
										<th>Category</th>
										<th>Unit</th>
										<th>Price</th>
										<th>Actions</th>
									</tr>
								</thead>

								<tbody v-if="medicines.length > 0">
									<tr v-for="(medicine, index) in medicines" v-if="index >= startIndex && index < endIndex">
										<td>{{identifyMedicineName(medicine.purchase_received_details_id)}}</td>
										<td>{{identifyCategory(medicine.purchase_received_details_id)}}</td>
										<td>{{identifyUnitCategory(medicine.purchase_received_details_id)}}</td>
										<td>{{identifyMedicinePrice(medicine.purchase_received_details_id)}}</td>
										<td>
											<button :disabled="disabledRequestOrderButton(medicine.purchase_received_details_id) == medicine.purchase_received_details_id" @click="addRequestOrderButton(medicine.purchase_received_details_id)" :title="add_Medicine" class="btn btn-outline-success btn-sm"><i class="fas fa-plus"></i></button>
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
								<p class="float-left">Showing {{this.medicines.length ? startIndex + 1 : 0}} to {{endIndex>this.medicines.length? this.medicines.length :endIndex}} of {{medicines.length}} entries</p>

								<nav aria-label="Page navigation example">
								  <ul class="pagination justify-content-end">
								    <li class="page-item">
								      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
								    </li>
								    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.medicines.length / this.show_entries) > 3 ? 3 : Math.ceil(this.medicines.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
								    <li class="page-item">
								      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next()">Next</a>
								    </li>
								  </ul>
								</nav>
							</div>
						</div>

						<div class="modal-footer">
				        	
				    	</div>
					</div> 
				</div>
			</div>
		</div>

		<div v-show="show_request_order_receipt">
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
			                    				<th colspan="10"><h2 class="float-right font-weight-bold">Request Order</h2></th>
			                    			</tr>
			                    			<tr>
			                    				<td colspan="10"><p class="float-right">R.O. Date: &nbsp;&nbsp;<?php echo date("M d, Y");?></p></td>
			                    			</tr> 
			                      			<tr>
						                        <th colspan="8"><h3 class="font-weight-bold"><?php echo 'Brgy. ' . $_SESSION['barangay_name'] ?></h3></th>
						                        <th><h6>Request Order No:</h6><h6 style="color: red">{{generateRequestOrderID()}}</h6></th>
						                    </tr>
			                      			<tr>
						                        <td colspan="8">Brgy. Gulod Health Center Gulod, Cabuyao, 4025, Philippines</td>
						                        <th><h6 class="text-danger"></h6></th>
			                      			</tr>
			                      			<tr>
						                        <td colspan="8">Phone : (047) 578 5192</td>
						                        <td></td>
			                      			</tr>
			                      			<tr>
			                      				<th colspan="7">SUPPLIER</th>
						                        <th colspan="7">SHIP TO</th>
			                      			</tr>
			                      			<tr>
			                      				<th colspan="7">Boticab City of Hall</th>
						                        <th colspan="7"><?php echo 'Brgy. ' .  $_SESSION['barangay_name'] ?></th>
			                      			</tr>
			                      			<tr>
			                      				<td colspan="7">F.B. Bailon Street, Cabuyao, Laguna, </td>
						                        <td colspan="7">Brgy. Gulod Health Center Gulod, Cabuyao, </td>
			                      			</tr>
			                      			<tr>
			                      				<td colspan="7">4025, Philippines</td>
						                        <td colspan="7">4025, Philippines</td>
			                      			</tr>
			                      			<tr>
			                      				<td colspan="7">(047) 578 5192</td>
						                        <td colspan="7">(047) 578 5192</td>
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
						                    </tr>
			                    		</thead>
			                    		<tbody>
					                      	<tr v-for="(request_medicine, index) in request_medicines">
						                        <td>{{request_medicine.medicine_name}}</td>
						                        <td>{{request_medicine.category}}</td>
						                        <td>{{request_medicine.unit_category}}</td>
						                        <td>&#8369;{{request_medicine.price}}</td>
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

<?php include(SHARED_PATH . '/barangay/admin/request_order/request_order_footer.php'); ?>