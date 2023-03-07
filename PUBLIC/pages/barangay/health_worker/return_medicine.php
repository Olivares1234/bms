<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Return Medicine'; ?>
<?php $barangay_name = 'Barangay ' . $_SESSION['barangay_name'] ?>
<?php include(SHARED_PATH . '/barangay/health_worker/return_medicine/return_medicine_header.php'); ?>

<div id="vue-return-medicine" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="transaction_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Return Medicine</h4>
			</div>

			<div class="card px-3 mt-4 shadow-nohover">
				<div class="float-right mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="transactions.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<input type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_transaction" @input="searchTransaction" placeholder="Search" arial-label="Search" onfocus="this.value=''">
				</div>

				<table class="table table-hover table-bordered text-center mt-2">		
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Transaction No.</th>
							<th>Transaction Date</th>						
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="transactions.length > 0">
						<tr v-for="(transaction, index) in transactions" v-if="index >= startIndex && index < endIndex" v-cloak>
							<td>{{transaction.transaction_id}}</td>
							<td>{{transaction.transaction_date}}</td>
							<td>
								<div class="btn-group">
									  <button class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split py-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
									    <i class="fas fa-cog">&nbsp;</i>
									  </button>
								    <div class="dropdown-menu" style="font-size:13px;">
									    <a class="dropdown-item" @click="toggleReturnDetails(transaction.transaction_id)"><i class="fas fa-eye">&nbsp;</i> View</a>
									    <a class="dropdown-item" @click="toggleTransactionDetails(transaction.transaction_id, transaction.beneficiary_id)"><i class="fas fa-arrow-alt-circle-right">&nbsp;</i> Return</a>
									</div>
								</div>
								<!-- <button @click="toggleReturnDetails(transaction.transaction_id)" class="btn btn-outline-warning btn-sm" :title="view_return"><i class="fas fa-eye"></i></button>

								<button @click="toggleTransactionDetails(transaction.transaction_id, transaction.beneficiary_id)" :title="add_return" class="btn btn-outline-success btn-sm"><i class="fas fa-arrow-alt-circle-right"></i></button> -->

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
					<p class="float-left">Showing {{this.transactions.length ? startIndex + 1 : 0}} to {{endIndex>this.transactions.length? this.transactions.length :endIndex}} of {{transactions.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.transactions.length / this.show_entries) > 3 ? 3 : Math.ceil(this.transactions.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>

		<div v-if="return_medicine_details_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Return Medicine Details
					<a class="btn bg-info text-light btn-sm ml-2" @click="toggleReturnDetails"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>
			<div class="card px-3 mt-4 shadow-nohover">
				<table class="table table-hover table-bordered text-center mt-2" v-cloak>
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Return Quantity</th>
							<th>Beneficiary ID</th>
							<th>Date Return</th>
							<th>Total Amount</th>
							<th>Barangay</th>
							<th>Return By</th>
						</tr>
					</thead>
					<tbody v-if="return_medicine_details.length > 0">
						<tr v-for="(return_medicine_detail, index) in return_medicine_details" v-if="index >= startIndex && index < endIndex">
							<td>{{return_medicine_detail.quantity}}</td>
							<td>{{return_medicine_detail.beneficiary_id}}</td>
							<td>{{return_medicine_detail.date_return}}</td>
							<td>{{parseFloat(return_medicine_detail.total_amount) | currency}}</td>
							<td>{{return_medicine_detail.barangay_name}}</td>
							<td>{{return_medicine_detail.first_name + " " + return_medicine_detail.last_name}}</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>

					<tfoot>
						<tr>
							<th colspan="5" class="text-left">Total Amount:</th>
							<th class="text-right">&#8369;{{totalAmountInCart | currency}}</th>
						</tr>
					</tfoot>
				</table>
			</div>
			
		</div>

		<div v-if="transaction_details_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Transaction Details
					<a class="btn bg-info text-light btn-sm ml-2" @click="toggleTransactionDetails('','')"><i class="fas fa-arrow-left"></i></a>
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
						<option :value="transaction_details.length">All</option>
					</select>
					<label class="d-inline-block ml-1" for="show_entries_two">entries</label>

					<input @input="searchReturnMedicine" v-model="search_user" type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_transaction_details" placeholder="Search" arial-label="Search" onfocus="this.value=''" v-if="filter == 'medicine name' || filter == 'category' || filter == 'unit_category'">

					<select v-model="filter" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option value="medicine name">Medicine name</option>
						<option value="category">Category</option>
						<option value="unit_category">Unit Category</option>
					</select>
					<label class="mr-2 float-right mt-1">Filter: </label>
				</div>
		
				<table class="table table-hover table-bordered text-center mt-2" v-cloak>
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Medicine Name</th>
							<th>Category</th>
							<th>Unit Category</th>
							<th>Quantity</th>
							<th>Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody v-if="transaction_details.length > 0">
						<tr v-for="(transaction_detail, index) in transaction_details" v-if="index >= startIndex && index < endIndex">
							<td>{{identifyMedicineName(transaction_detail.received_order_details_id)}}</td>
							<td>{{identifyCategoryName(transaction_detail.received_order_details_id)}}</td>
							<td>{{identifyUnitCategoryName(transaction_detail.received_order_details_id)}}</td>
							<td>{{transaction_detail.quantity}}</td>
							<td>&#8369;{{parseFloat(transaction_detail.total_price) | currency}}</td>
							<td>
								<button @click="toggleAddReturnMedicine(transaction_detail.received_order_details_id, transaction_detail.quantity)" :disabled="transaction_detail.quantity == '0'" :title="create_Return" class="btn btn-outline-danger btn-sm"><i class="fas fa-minus-circle"></i>
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

				<div class="mt-1">
					<p class="float-left">Showing {{this.transaction_details.length ? startIndex + 1 : 0}} to {{endIndex>this.transaction_details.length? this.transaction_details.length :endIndex}} of {{transaction_details.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous_two()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.transaction_details.length / this.show_entries_two) > 3 ? 3 : Math.ceil(this.transaction_details.length / this.show_entries_two)" @click="pagination_two(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next_two()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>

		<div class="modal" id="myModal" > <!-- start add modal -->
			<div class="modal-dialog">
					<div class="modal-content " style="height:auto">
	  
		        	<!-- Modal Header -->
		        	<div class="modal-header">
		          		<h4 class="modal-title"> Return Medicine</h4>
		          			<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
		        	</div>
	        	
			        <!-- Modal body -->
			        <div class="modal-body">
			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="medicine_quantity">Quantity</label>
								<input type="number" @keypress="isNumber" class="form-control" :class="{'is-invalid': return_medicine_quantity_error}" v-model="return_medicine_quantity" placeholder="Enter Quantity" autofocus required>
								<div class="invalid-feedback">{{return_medicine_quantity_description}}</div>
							</div>
						</div>

			         	<div class="form-group">
							<div class="col-lg-12">
								<label for="">Remarks</label>
								<textarea class="form-control" rows="5" :class="{'is-invalid': return_medicine_remarks_error}" v-model="return_medicine_remarks" id="" placeholder="Enter Remarks"></textarea>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>
					</div>

			        <!-- Modal footer -->
			        <div class="modal-footer">
			          <button @click="saveReturnMedicine" type="button" :disabled="quantity <= '0'" class="btn btn-primary btn-sm"><i class="far fa-save">&nbsp;</i> Save return medicine</button>
			        </div>
					</div>
			</div>
		</div> <!-- end add modal -->
	</div>
</div>

<?php include(SHARED_PATH . '/barangay/health_worker/return_medicine/return_medicine_footer.php'); ?>