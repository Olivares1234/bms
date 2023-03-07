<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Beneficiary'; ?>
<?php $barangay_name = 'Barangay ' . $_SESSION['barangay_name'] ?>
<?php include(SHARED_PATH . '/barangay/health_worker/beneficiary/beneficiary_header.php'); ?>

<div id="vue-beneficiary" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="transaction_button == false && beneficiary_info == false">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<!-- <div class="float-left"> -->
				<h4 class="float-left">List of Beneficiary {{"(" + beneficiaries.length + ")"}}</h4>
			</div>

			<div class="card px-3 mt-4 shadow-nohover">
				<div class="float-left mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="beneficiaries.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<!-- search for id -->
					<input @input="searchBeneficiary" type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_beneficiary" placeholder="Search beneficiary id" arial-label="Search" v-if="filter == 'id'" onfocus="this.value=''">
					<!--               -->

					<!-- search for name -->
					<input @input="searchBeneficiary" type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_beneficiary" placeholder="Search beneficiary name" arial-label="Search" v-if="filter == 'name'" onfocus="this.value=''">
					<!--               -->

					<!-- search for status -->
					<select @change="searchBeneficiary" v-model="search_beneficiary" class="form-control form-control-sm d-inline-block col-md-2 float-right" style="width: auto;" v-if="filter == 'status'">
						<option value="" disabled selected>Select Status</option>
						<option value="Active">Active</option>
						<option value="Not Active">Not Active</option>
					</select>
					<!--               -->
					
					<select v-model="filter" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option value="id">ID</option>
						<option value="name">Name</option>
						<option value="status">Status</option>
					</select>
					<label class="mr-2 float-right mt-1">Filter: </label>
				</div>

				<table class="table table-hover table-bordered text-center mt-2">
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Beneficiary Id</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Middle Name</th>
							<th>Status</th>
							<th>Current Amount</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="beneficiaries.length > 0">
						<tr v-for="(beneficiary, index) in beneficiaries" v-if="index >= startIndex && index < endIndex">
							<td>{{beneficiary.beneficiary_id}}</td>
							<td>{{beneficiary.first_name}}</td>
							<td>{{beneficiary.last_name}}</td>
							<td>{{beneficiary.middle_name}}</td>
							<td v-if="beneficiary.status == 'Active'"><h6 class="text-light bg-success rounded">{{beneficiary.status}}</h6></td>
							<td v-else><h6 class="text-light bg-warning rounded">{{beneficiary.status}}</h6></td>
							<td>&#8369;{{parseInt(beneficiary.balance) | currency}}</td>
							<td>
								<div class="btn-group">
									  <button class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split py-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
									    <i class="fas fa-cog">&nbsp;</i>
									  </button>
								    <div class="dropdown-menu" style="font-size:13px;">
									    <a class="dropdown-item" @click="beneficiaryDetailsButton(beneficiary.beneficiary_id)"><i class="fas fa-eye">&nbsp;</i> View</a>
									    <a class="dropdown-item" @click="toggleTransaction(beneficiary.beneficiary_id)" :disabled="beneficiary.balance >= 10000"><i class="fas fa-shopping-cart">&nbsp;</i> Transact</a>
									</div>
								</div>
								<!-- <button @click="beneficiaryDetailsButton(beneficiary.beneficiary_id)" class="btn btn-outline-warning btn-sm" :title="view_beneficiary_details"><i class="fas fa-eye"></i>
								</button>
								 
								<button @click="toggleTransaction(beneficiary.beneficiary_id)" :title="add_transaction" :disabled="beneficiary.balance >= 10000" class="btn btn-outline-info btn-sm"><i class="fas fa-shopping-cart"></i>
								</button> -->
							</td>
						</tr>
					</tbody>
					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"> <b>No data to show.</b> </td>
						</tr>
					</tbody>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{this.beneficiaries.length ? startIndex + 1 : 0}} to {{endIndex>this.beneficiaries.length? this.beneficiaries.length :endIndex}} of {{beneficiaries.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.beneficiaries.length / this.show_entries) > 3 ? 3 : Math.ceil(this.beneficiaries.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>

		<div v-show="transaction_button">
			<div v-show="show_transaction">
				<div class="card px-3 pb-1 pt-3">
					<h4>{{beneficiary_first_name_in_cart + "'" + "s"}} Cart
						<a @click="toggleTransaction('')" class="btn bg-info text-light btn-sm ml-2">
							<i class="fas fa-arrow-left"></i>
						</a>
					</h4>
				</div>

				<div class="card px-3 pb-3 mt-4">
					<div class="float-left mt-4">
						<label class="float-left">You have {{transactions.length}} item/s in your cart.</label>
						<button class="btn btn-success btn-sm font-weight-bold float-right" @click="viewGulodMedicine"><i class="fas fa-list text-light">&nbsp;</i> View Medicine</button>
					</div>
				
					<table class="table table-hover table-bordered text-center mt-2">		
						<thead class="thead-info">
							<tr class="table-color text-light">
								<th>Medicine Name</th>
								<th>Category</th>
								<th>Unit</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Total</th>
								<th colspan="2">Actions</th>
							</tr>
						</thead>
						<tbody v-if="transactions.length > 0">
							<tr v-for="(transaction, index) in transactions" :class="{editing: transaction == edit_user}" v-cloak>
								<td>{{transaction.name}}</td>
								<td>{{transaction.category}}</td>
								<td>{{transaction.unit_category}}</td>
								<td>&#8369;{{transaction.price}}</td>
								<td class="view">{{transaction.quantity}}</td>
								<td class="edit"><input type="number" v-on:keypress="isNumber($event)" v-model.number="transaction.quantity" class="form-control-sm text-right"></td>
								<td>&#8369;{{transaction.total | currency}}</td>
								<td colspan="2">
									<div class="btn-group">
										  <button class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split py-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
										    <i class="fas fa-cog">&nbsp;</i>
										  </button>
									    <div class="dropdown-menu" style="font-size:13px;">
										    <a class="dropdown-item" @click="editData(transaction)" :disabled='edit_disabled' :title="update_quantity" class="view"><i class="fa fa-edit">&nbsp;</i> Edit</a>
										    <a class="dropdown-item" @click="saveData(transaction.id)" :title="save_quantity" :disabled="transaction.quantity <= 0" class="edit"><i class="fa fa-save">&nbsp;</i> Save</a>
										    <a class="dropdown-item" @click="removeTransactionToCart(index,transaction.id)" :title="delete_row" :disabled='edit_disabled' class="delete"><i class="fas fa-trash-alt">&nbsp;</i> Delete</a>
										</div>
									</div>
								</td>
							</tr>
						</tbody>

						<tbody v-else>
							<tr>
								<td colspan="12" style="font-size: 20px"><b>No item/s in your cart.</b></td>
							</tr>
						</tbody>

						<tfoot>
							<tr>
								<th colspan="6" class="text-left">Total Amount:</th>
								<th class="text-right">&#8369;{{totalAmountInCart | currency}}</th>
							</tr>
							<tr>
								<th colspan="6" class="text-left">Remaining Balance:</th>
								<th class="text-right">&#8369;{{remainingBalance | currency}}</th>
							</tr>
						</tfoot>

					</table>

					<div>
						<button @click="saveTransaction" :disabled='edit_disabled' class="btn bg-primary text-light btn-sm font-weight-bold float-right"><i class="far fa-save">&nbsp;</i> Save Transaction</button>
					</div>
				</div>
			</div>
 
			<!-- Start of Receipt -->
			<div v-show="show_receipt">
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
							                        <th colspan="8"><h5 class="font-weight-bold">Brgy. <?php echo $_SESSION['barangay_name']; ?></h5></th>
							                        <th colspan="8"><h6>Transaction No:</h6></th>
							                    </tr>
				                      			<tr>
							                        <th colspan="8"><h6>{{identifyBarangayAddress(<?php echo $_SESSION['barangay_id']; ?>)}}</h6></th>
							                        <th colspan="8"><h6 class="text-danger">{{generateTransactionID()}}</h6></th>
				                      			</tr>
				                      			<tr>
							                        <th colspan="6"><h6>Phone : {{identifyBarangayContactNo(<?php echo $_SESSION['barangay_id'] ?>)}}</h6></th>
							                        <th colspan="8"></th>
				                      			</tr>
				                      
				                    		</thead>
				                    		<thead>
					                    	<tr>
						                        <th colspan="5">To :</th>
						                        <td>{{receipt_first_name}} {{receipt_last_name}}</td>
						                        <th colspan="5">Date :</th>
						                        <td><?php echo date("M d, Y");?> Time <?php echo date("h:i A");?></td>
					                      	</tr>
						                    <tr>
						                    	<th colspan="5">Address</th>
						                        <td>{{receipt_address}}</td>
						                        <th colspan="5">Contact no :</th>
						                        <td>{{receipt_contact_no}}</td>
						                    </tr>
						                    <tr>
						                        <th colspan="5"></th>
						                       	<th></th>
						                        <th colspan="5"></th>
						                        <th></th>
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
							            			<th colspan="1" class="text-right">Amount</th>			
							                    </tr>
				                    		</thead>
				                    		<tbody>
						                      	<tr v-for="(receipt, index) in receipts">
							                        <td>{{receipt.medicine_name}}</td>
							                        <td>{{receipt.category}}</td>
							                        <td>{{receipt.unit_category}}</td>
							                        <td>&#8369;{{receipt.price}}</td>
							                        <td>{{receipt.quantity}}</td>
							                        <td colspan="1" class="text-right">&#8369;{{receipt.total_amount | currency}}</td>	
						                      	</tr>
							                    <tr>
							                        <td></td>
							                        <td></td>
							                        <td></td>
							                        <td></td>
							                        <td class="text-right font-weight-bold">Total Amount :</td>
							                        <td class="text-right">&#8369;{{totalItem | currency}}</td>
							                    </tr>
							                    </tbody>
				                  		</table>

				                  		<div class="mt-5">
				                  			<label class="font-weight-bold">Prepared by: <u><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']?></u></label>
				                  			<label class="float-right font-weight-bold">___________________________</label><br>
				                  			<label class="font-weight-bold"></label>
				                  			<label class="float-right font-weight-bold mr-4">Beneficiary's Signature</label>
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
			<!-- End of Reciept -->

			<div class="modal" id="myModal6" data-keyboard="false" data-backdrop="static" class="text-dark" tabindex="1"> 
			    <div class="modal-dialog modal-lg">
			     	<div class="modal-content">
			     		<div class="modal-header">
			     			<h4>List of <?php echo $_SESSION['barangay_name'] ?> Medicine {{"(" + available_medicines.length + ")"}}</h4>
			     			<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			     		</div>

					  
					    <!-- Modal body -->
						<div class="modal-body" id="modal-medicine">
							<div class="float-right">
								<div class="input-group form-group">
									<input @input="searchAvailableMedicine" type="text" class="form-control form-control-sm mr-1" v-model="search_available_medicine" placeholder="Search medicine" arial-label="Search" autofocus>
								</div>
							</div>

							<table class="table table-hover table-bordered text-center mt-4">
								<thead class="thead-info">
									<tr class="table-color text-light">
										<th>Medicine Name</th>
										<th>Category</th>
										<th>Unit</th>
										<th>Quantity</th>
										<th>Price</th>
										<th>Actions</th>
									</tr>
								</thead> 
								<tbody v-if="available_medicines.length > 0">
									<tr v-for="(medicine, index) in available_medicines" v-if="index >= startIndex && index < endIndex">
										<td>{{identifyMedicineName(medicine.purchase_received_details_id)}}</td>
										<td>{{identifyCategoryName(medicine.purchase_received_details_id)}}</td>
										<td>{{identifyUnitCategoryName(medicine.purchase_received_details_id)}}</td>
										<td>{{medicine.quantity}}</td>
										<td>{{identifyMedicinePrice(medicine.purchase_received_details_id)}}</td>
										<td>
											<button id="terms" @click="addTransactionButton(medicine.received_order_details_id, medicine.purchase_received_details_id, medicine.quantity)" :disabled="medicine.disabled" :title="add_to_cart" data-toggle="modal" data-target="#myModal3" class="btn btn-outline-success btn-sm"><i class="fas fa-plus"></i></button>
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
								<p class="float-left">Showing {{this.available_medicines.length ? startIndex + 1 : 0}} to {{endIndex>this.available_medicines.length? this.available_medicines.length :endIndex}} of {{available_medicines.length}} entries</p>

								<nav aria-label="Page navigation example">
								  <ul class="pagination justify-content-end">
								    <li class="page-item">
								      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
								    </li>
								    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.available_medicines.length / this.show_entries) > 3 ? 3 : Math.ceil(this.available_medicines.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
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

			<!-- start add transaction modal -->
			<div class="modal" data-keyboard="false" data-backdrop="static" id="myModal3" class="text-dark">
				<div class="modal-dialog modal-dialog-centered modal-sm">
	 				<div class="modal-content bg-light">
	      
				        <div class="modal-header">
				          <h4 class="modal-title">Add Transaction</h4>
				          	<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
				        </div>

	        			
						<div class="modal-body mx-auto" id="modal-less-input">
							<label for="input_quantity">Quantity</label>
							<div class="input-group form-group">
								<input type="number" :class="{'is-invalid': input_quantity_error}" v-on:keypress="isNumber($event)" class="form-control"v-model="input_quantity" placeholder="Enter Quantity" required>
							</div> 
							<div class="invalid-feedback">{{input_quantity_error_description}}</div> 
						</div>
				        
						
				        <div class="modal-footer">
				          <button @click="addTransactionToCart" type="button" class="btn btn-success btn-sm" :disabled="!input_quantity || parseInt(input_quantity) < 1 || parseInt(input_quantity) > transaction_quantity"><i class="far fa-save">&nbsp;</i> Add to Cart</button>
				        </div>
			    	</div>
			 	</div> 
			</div>
			<!-- end add transaction modal -->
		</div>

		<!-- Start of View Transaction -->
		<div v-if="beneficiary_info">
			<div class="card px-3 pb-1 pt-3">
				<h4> Beneficiary Information 
					<a class="btn bg-info text-light btn-sm ml-2" @click="beneficiaryDetailsButton"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

            <div class="card px-3 pb-5 mt-4 shadow-nohover" id="details_beneficiary">
				<h5 class="mt-4">Beneficiary Details</h5>
				<div class="mt-3 shadow-sm rounded bg-light pt-3 pb-3">
					<div class="form-row mt-2 px-3">
					    <div class="form-group col-md-3">
					    	<label>First name : </label>
					    	<p class="font-weight-bold">{{beneficiary_info_first_name}}</p>

					    </div>
					    <div class="form-group col-md-3">
					    	<label>Last name : </label> 
					    	<p class="font-weight-bold">{{beneficiary_info_last_name}}</p>
					       
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Middle name : </label> 
					    	<p class="font-weight-bold">{{beneficiary_info_middle_name}}</p>
					      
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Birth Date : </label> 
					    	<p class="font-weight-bold">{{beneficiary_info_birth_date}}</p>
					       
					    </div>
					</div>

					<div class="form-row mt-2 px-3">
						<div class="form-group col-md-3">
					    	<label>Sex : </label> 
					    	<p class="font-weight-bold">{{beneficiary_info_sex}}</p>
					       	
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Phone no : </label> 
					    	<p class="font-weight-bold">{{beneficiary_info_contact_no}}</p>
					       
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Email Address : </label>
					    	<p class="font-weight-bold">{{beneficiary_info_email_address}}</p>
					      
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Religion : </label>
					    	<p class="font-weight-bold">{{beneficiary_info_religion}}</p>
					        
					    </div> 
					</div>

					<div class="form-row mt-2 px-3">
						
						<div class="form-group col-md-3">
					    	<label>Educational Attainment : </label> 
					    	<p class="font-weight-bold">{{beneficiary_educational_attainment}}</p>
					       	
					    </div>
					   
					    <div class="form-group col-md-3">
					    	<label>Occupation : </label>
					    	<p class="font-weight-bold">{{beneficiary_occupation}}</p>
					       	
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Civil Status : </label>
					    	<p class="font-weight-bold">{{beneficiary_civil_status}}</p>
					       
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Beneficiary Type : </label>
					    	<p class="font-weight-bold">{{beneficiary_beneficiary_type}}</p>
					    </div>
					</div>

					<div class="form-row mt-2 px-3">
						<div class="form-group col-md-3">
					    	<label>Status : </label>
					    	<p class="font-weight-bold">{{beneficiary_status}}</p>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Balance : </label>
					    	<p class="font-weight-bold">{{beneficiary_balance}}</p>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Address : </label>
					    	<p class="font-weight-bold">{{beneficiary_info_address}}</p>
					    </div>
					</div>
				</div>
			</div>
            
        	<div class="card px-3 pb-1 mt-4 shadow-nohover">
	        	<div class="float-left mt-4" id="show_entries">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="beneficiaries.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>
					<a class ="btn btn-primary text-light btn-sm float-right" id="print-transaction" onclick ="window.print()"><i class ="fa fa-print">&nbsp;</i> Print</a>
				</div>
	            <table class="table table-responsive-sm table-hover table-bordered text-center">
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Medicine</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Date</th>
							<th>Total</th>
							<th>Prepared By</th>
						</tr>
					</thead>
					<tbody v-if="transaction_details.length > 0">
						<tr v-for="(transaction_detail, index) in transaction_details" v-if="index >= startIndex && index < endIndex" >
							<td>{{transaction_detail.medicine_name}}</td>
							<td>{{transaction_detail.quantity}}</td>
							<td>{{transaction_detail.price}}</td>
							<td>{{transaction_detail.transaction_date}}</td>
							<td>&#8369;{{parseFloat(transaction_detail.total_price) | currency}}</td>
							<td>{{transaction_detail.first_name + " " + transaction_detail.last_name}}</td>
						</tr>
					</tbody>
					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No item/s in your cart.</b></td>
						</tr>
					</tbody>
					<tfoot v-if="transaction_details.length > 0">
						<tr>
							<th colspan="5" class="text-left">Total Transaction:</th>
							<th class="text-right">&#8369;{{totalBeneficiaryTransaction}}</th>
						</tr>
						<tr>
							<th colspan="5" class="text-left">Remaining Balance:</th>
							<th class="text-right">&#8369;{{totalBeneficiaryRemainingBalance}}</th>
						</tr>
					</tfoot>
				</table>
				<div class="mt-1">
					<p class="float-left">Showing {{this.transaction_details.length ? startIndex + 1 : 0}} to {{endIndex>this.transaction_details.length? this.transaction_details.length :endIndex}} of {{transaction_details.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.transaction_details.length / this.show_entries) > 3 ? 3 : Math.ceil(this.transaction_details.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
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


<?php include(SHARED_PATH . '/barangay/health_worker/beneficiary/beneficiary_footer.php'); ?>


