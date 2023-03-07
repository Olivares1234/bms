 <?php require_once('../../../../private/initialize.php'); ?> 
<?php $page_title = 'Transfer Beneficiary'; ?>
<?php include(SHARED_PATH . "/city_hall/registration_staff/transfer/transfer_header.php"); ?>


<div id="vue-transfer" class="mt-4" v-cloak> 
	<div class="container">
		<div class="card px-3 pb-1 pt-3">
			<h4> Transfer Beneficiary</h4>
		</div>

		<div class="card px-3 mt-4 shadow-nohover">
			<div class="float-left mt-4">
				<label class="d-inline-block mr-1" for="show_entries">Show </label>
					<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="beneficiaries.length">All</option>
					</select>
				<label class="d-inline-block ml-1" for="show_entries">entries</label>

				<input type="text" v-model="search_beneficiary" class="form-control form-control-sm float-right col-md-2" placeholder="Search" arial-label="Search" v-if="filter == 'id' || filter == 'name' || filter == 'barangay'">

				<select v-model="search_beneficiary" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;" v-if="filter == 'status'">
					<option value="" disabled selected>Select status</option>
					<option value="1" selected>Active</option>
					<option value="0">Not Active</option>
				</select>

				<select v-model="filter" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
					<option value="" disabled selected>Select Field name</option>
					<option value="id">ID</option>
					<option value="name">Name</option>
					<option value="status">Status</option>
					<option value="barangay">Barangay</option>
				</select>
				<label class="mr-2 float-right mt-1">Filter: </label>
			</div>

			<table class="table table-hover table-bordered text-center mt-2">

				<thead class="thead-info">
					<tr class="table-color text-light">
						<th>Beneficiary ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Middle Name</th>
						<th>Status</th>
						<th>Barangay</th>
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
						<td>{{identifyBarangayName(beneficiary.barangay_id)}}</td>
						<td>
							<button @click="toggleTransferBeneficiaryModal(beneficiary.beneficiary_id)" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></button>
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
				<p class="float-left">Showing {{startIndex + 1}} to {{endIndex>this.beneficiaries.length? this.beneficiaries.length :endIndex}} of {{beneficiaries.length}} entries</p>

				<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-end">
				    <li class="page-item">
				      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
				    </li>
				    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.beneficiaries.length / this.show_entries) > 3 ? 3 : Math.ceil(this.beneficiaries.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
				    <li class="page-item">
				      <a class="page-link btn btn-sm text-dark py-1 px-2">Next</a>
				    </li>
				  </ul>
				</nav>
			</div>
		</div>

		<div class="modal" id="myModal" data-keyboard="false" data-backdrop="static"> 
	    	<div class="modal-dialog">
	     		<div class="modal-content">
		      	
			        <!-- Modal Header -->
			        <div class="modal-header">
			          	<h4 class="modal-title">Update Beneficiary</h4>
			          		<button type="button" class="btn closing-modal" data-dismiss="modal">
			          			<i class="fas fa-times"></i>
			          		</button>
			        </div>
		        	
			        <!-- Modal body -->
			        <div class="modal-body" id="modal-less-input">
					    <div class="input-group form-group">
							<div class="col-lg-12">
						    	<label>Barangay</label>
						       	<select v-model="barangay" :class="{'is-invalid' : barangay_error}" class="form-control form-control-sm">
						       		<option value="" disabled selected>Select Barangay</option>
						       		<option v-for="barangay in barangays" v-show="barangay.barangay_name != 'City Hall' && barangay.barangay_name != 'none'">{{barangay.barangay_name}}</option>
						       	</select>
						       	<div class="invalid-feedback">This field is required!</div>
						    </div>
				        </div>
				    </div>

			        <div class="modal-footer">
			        	<button @click="transferBeneficiary" class="btn btn-sm text-light bg-primary font-weight-bold float-right"><i class="far fa-save">&nbsp;</i> Save</button>
			    	</div>
	      		</div>
	      	</div>
	    </div>
	</div>
</div>



<?php include(SHARED_PATH . "/city_hall/registration_staff/transfer/transfer_footer.php"); ?>