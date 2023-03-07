<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Referral'; ?>
<?php $barangay_name = 'Barangay ' . $_SESSION['barangay_name'] ?>
<?php include(SHARED_PATH . '/barangay/health_worker/referral/referral_header.php'); ?>
 
<div id="vue-referral" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="beneficiary_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4 class="float-left">Referral</h4>
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
							<th>Beneficiary ID</th>
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
							<td>&#8369;{{beneficiary.balance}}</td>
							<td>	
								<button @click="toggleReferral(beneficiary.beneficiary_id,beneficiary.first_name, beneficiary.last_name)" id="terms" :title="add_referral" class="btn btn-outline-info btn-sm"><i class="far fa-file-alt"></i></button>
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

		<div class="modal fade" id="myModal2" data-keyboard="false" data-backdrop="static"> <!-- start deactivate modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			        	<h4 class="modal-title">Referral</h4>
			        	<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>
		        
			        <div class="modal-body" id="modal-less-input">
			        	<div class="form-group">
							<div class="col-lg-12">
								<b>Do you want to refer this beneficiary?</b> 
							</div>
						</div>
					</div>					
					<div class="modal-footer">
						<div class="col-lg-12">
							<button @click="viewReferral" class="btn btn-primary float-right btn-sm font-weight-bold ml-2">Confirm</button>
						</div>
					</div>
	      		</div>
	    	</div>
	 	</div> <!-- end deactivate modal -->

	 	<div v-if="view_referral">
	 		<div style="margin-left: 150px; width: 800px; background-color: #fff; padding: 20px; font-size: 14px;">
	 			<div class="text-center mt-4">
		          	<h6><b>Brgy. Gulod Branch</b></h6>  
		          	<p>Brgy. Gulod Health Center Gulod, Cabuyao, 4025, Philippines<br>
		          	Phone : (047) 578 5192</p>

					<div align="left" class="px-3 pb-5"><br><br>

					Date : <?php echo date("M d, Y");?><br><br>

						<div><br>

						To whom it may concern: <p>

						<p>
						This is to recommend <u>{{beneficiary_first_name + " " + beneficiary_last_name}}</u> to get free medicine at the City Hall of Cabuyao. The reason is the current stock of the needed medicine of beneficiary is not available at this moment. We refer this beneficiary to get medicine. If you have a any question just contact us.
						<br><br><br> Thank you for your understanding.<br><br><br> 

						Signed by:<br><br>
						<u><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></u> <br><br>
						<span style="font-size: 12px;">(put the signature as this is the most important part)</span>
						</p><br>

						Received by:<br><br>
						__________________ <br><br>
						<span style="font-size: 12px;">(put the signature as this is the most important part)</span>
						</p>
						<a class ="btn btn-primary text-light btn-sm font-weight-bold float-right" id="print-transaction" onclick ="window.print()"><i class ="fa fa-print">&nbsp;</i> Print</a>
						 

						</div>
			 		
			 		</div>
			 	</div>
			</div>
		</div>
	</div>
</div>

<?php include(SHARED_PATH . '/barangay/health_worker/referral/referral_footer.php'); ?>