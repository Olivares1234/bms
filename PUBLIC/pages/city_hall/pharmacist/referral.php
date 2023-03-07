<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = ' Referral'; ?>
<?php include(SHARED_PATH . '/city_hall/pharmacist/referral/referral_header.php'); ?>

<div id="vue-referral" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="referral_beneficiary_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Referral</h4>
			</div>

			<div class="card px-3 mt-4 shadow-nohover">
				<div class="float-right mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="beneficiaries.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<input type="text" class="form-control form-control-sm float-right col-md-2" @input="searchBeneficiary" v-model="search_beneficiary" placeholder="Search" arial-label="Search beneficiary id" v-if="barangay_id != ''">

					<select @change="retrieveBeneficiary(barangay_id)" v-model="barangay_id" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Barangay</option>
						<option v-for="barangay in barangays" v-show="barangay.barangay_name != 'City Hall'" :value="barangay.barangay_id">{{barangay.barangay_name}}</option>
					</select>
					<label class="mr-2 float-right mt-1">Barangay: </label>
					
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
						<tr v-for="beneficiary in beneficiaries">
							<td>{{beneficiary.beneficiary_id}}</td>
							<td>{{beneficiary.first_name}}</td>
							<td>{{beneficiary.last_name}}</td>
							<td>{{beneficiary.middle_name}}</td>
							<td>{{beneficiary.status}}</td>
							<td>{{beneficiary.balance}}</td>
							<td>
								<button @click="toggleTransaction(beneficiary.beneficiary_id, beneficiary.balance)" :title="add_transaction" class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></button>
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
					<p class="float-left">Showing {{this.beneficiaries.length ? startIndex + 1 : 0}} to {{endIndex>this.beneficiaries.length? this.beneficiaries.length :endIndex}} of {{beneficiaries.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.beneficiaries.length / this.show_entries) > 3 ? 3 : Math.ceil(this.beneficiaries.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextSendOrder()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>

		<div v-if="transaction_list">
			<div class="card px-3 pb-1 pt-3">
				<h4>{{identifyBeneficiaryFirstName(beneficiary_id) + " " + identifyBeneficiaryLastName(beneficiary_id) + "'" + "s"}} Cart
					<a @click="toggleTransaction('')" class="btn bg-info text-light btn-sm ml-2">
						<i class="fas fa-arrow-left"></i>
					</a>
				</h4>
			</div>

			<div class="card px-3 pb-3 mt-4">
				<div class="float-left mt-4">
					<label class="float-left">You have {{transactions.length}} item/s in your cart.</label>

					<button class="btn btn-success btn-sm font-weight-bold float-right" data-toggle="modal" data-target="#myModal"><i class="fas fa-list text-light">&nbsp;</i> View Medicine</button>
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
							<td>{{transaction.medicine_name}}</td>
							<td>{{transaction.category_name}}</td>
							<td>{{transaction.unit_category_name}}</td>
							<td>&#8369;{{transaction.price}}</td>
							<td class="view">{{transaction.quantity}}</td>

							<td class="edit">
								<input type="number" v-on:keypress="isNumber($event)" v-model.number="transaction.quantity" class="form-control-sm text-right">
							</td>

							<td>&#8369;{{transaction.total_amount | currency}}</td>
							<td colspan="2">
								<div class="btn-group">
									  <button class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split py-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
									    <i class="fas fa-cog">&nbsp;</i>
									  </button>
								    <div class="dropdown-menu" style="font-size:13px;">
									    <a class="dropdown-item" @click="editData(transaction, transaction.id)" :disabled='edit_disabled' class="view"><i class="fa fa-edit">&nbsp;</i> Edit</a>
									    <a class="dropdown-item"@click="saveData(transaction.id)" :disabled="transaction.quantity <= 0" class="edit"><i class="fa fa-save">&nbsp;</i> Save</a>
									    <a class="dropdown-item" @click="removeTransactionToCart(index)" :disabled='edit_disabled' class="delete"><i class="fas fa-trash-alt">&nbsp;</i> Delete</a>
									</div>
								</div>

								<!-- <button @click="editData(transaction, transaction.id)" :disabled='edit_disabled' :title="update_quantity" class="view btn btn-outline-primary btn-sm" role="group"><i class="fa fa-edit" class="small-box-footer"></i>
						        </button> 
						       
						        <button @click="saveData(transaction.id)" :title="save_quantity" :disabled="transaction.quantity <= 0" class="edit btn btn-outline-primary btn-sm" role="group"><i class="fa fa-save"></i>
						        </button>
						      
								<button @click="removeTransactionToCart(index)" :title="delete_row" :disabled='edit_disabled' class="delete btn btn-outline-danger btn-sm" role="group"><i class="fas fa-trash-alt"></i>
								</button> -->
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
					<button @click="saveTransaction" class="btn bg-primary text-light btn-sm font-weight-bold float-right"><i class="far fa-save">&nbsp;</i> Save Transaction</button>
				</div>
			</div>
		</div>

		<div v-if="receipt_list">
			<!-- Start of Receipt -->
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
						                        <th colspan="8"><h6>Referral Transaction No:</h6></th>
						                    </tr>
			                      			<tr>
						                        <th colspan="8"><h6>{{identifyBarangayAddress(<?php echo $_SESSION['barangay_id']; ?>)}}</h6></th>
						                        <th colspan="8"><h6 class="text-danger">{{generateReferralTransactionId()}}</h6></th>
			                      			</tr>
			                      			<tr>
						                        <th colspan="6"><h6>Phone : {{identifyBarangayContactNo(<?php echo $_SESSION['barangay_id'] ?>)}}</h6></th>
						                        <th colspan="8"></th>
			                      			</tr>
			                      
			                    		</thead>
			                    		<thead>
				                    	<tr>
					                        <th colspan="5">To :</th>
					                        <td>{{identifyBeneficiaryFirstName(beneficiary_id)}} {{identifyBeneficiaryLastName(beneficiary_id)}}</td>
					                        <th colspan="5">Date :</th>
					                        <td><?php echo date("M d, Y");?> Time <?php echo date("h:i A");?></td>
				                      	</tr>
					                    <tr>
					                    	<th colspan="5">Address</th>
					                        <td>{{identifyBeneficiaryAddress(beneficiary_id)}}</td>
					                        <th colspan="5">Contact no :</th>
					                        <td>{{identifyBeneficiaryContactNo(beneficiary_id)}}</td>
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
						                        <td>{{receipt.category_name}}</td>
						                        <td>{{receipt.unit_category_name}}</td>
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
			<!-- End of Reciept -->
		</div>

		<div  class="modal" id="myModal" data-keyboard="false" data-backdrop="static" class="text-dark" tabindex="1"> 
		    <div class="modal-dialog modal-lg">
		     	<div class="modal-content">
		     		<div class="modal-header">
		     			<h4>List of City Hall available Medicine {{"(" + available_medicines.length + ")"}}</h4>
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
								<tr v-for="(available_medicine, index) in available_medicines">
									<td>{{identifyMedicineName(available_medicine.supplier_medicine_id)}}</td>

									<td>{{identifyCategoryName(available_medicine.supplier_medicine_id)}}</td>

									<td>{{identifyUnitCategoryName(available_medicine.supplier_medicine_id)}}</td>

									<td>{{available_medicine.received_quantity}}</td>

									<td>{{identifyMedicinePrice(available_medicine.supplier_medicine_id)}}</td>
									<td>
										<button @click="addTransactionButton(available_medicine.purchase_received_details_id, available_medicine.supplier_medicine_id, available_medicine.received_quantity)" id="terms" :title="add_to_cart" data-toggle="modal" data-target="#myModal1" class="btn btn-outline-success btn-sm"><i class="fas fa-plus"></i></button>
			  						</td>
								</tr>
							</tbody>

							<tbody v-else>
								<tr>
									<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div> <!-- end of modal -->

		<!-- start add transaction modal -->
		<div class="modal" data-keyboard="false" data-backdrop="static" id="myModal1" class="text-dark">
			<div class="modal-dialog modal-dialog-centered modal-sm">
 				<div class="modal-content bg-light">
      
			        <div class="modal-header">
			          <h4 class="modal-title">Add Transaction</h4>
			          	<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>

        			
					<div class="modal-body mx-auto" id="modal-less-input">
						<label for="input_quantity">Quantity</label>
						<div class="input-group form-group">
							<input type="number" :class="{'is-invalid': quantity_error}" v-on:keypress="isNumber($event)" class="form-control"v-model="quantity" placeholder="Enter Quantity" required>
							<div class="invalid-feedback">{{quantity_error_description}}</div> 
						</div> 
					</div>
			        
					
			        <div class="modal-footer">
			          <button @click="addTransactionToCart" :disabled="!quantity || parseInt(quantity) < 1 || parseInt(quantity) > transaction_quantity" type="button" class="btn btn-success btn-sm"><i class="far fa-save">&nbsp;</i> Add to Cart</button>
			        </div>
		    	</div>
		 	</div> 
		</div>
		<!-- end add transaction modal -->
	</div>
</div>

<?php include(SHARED_PATH . '/city_hall/pharmacist/referral/referral_footer.php'); ?>