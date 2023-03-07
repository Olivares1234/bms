<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Dependent'; ?>
<?php include(SHARED_PATH . "/city_hall/registration_staff/dependent/dependent_header.php"); ?>

<div id="vue-dependent" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="dependent_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4> List of Dependent
					<a @click="toggleAddDependent" class="btn bg-success text-light btn-sm font-weight-bold ml-2"><i class="fas fa-plus"></i></a>
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
							<option :value="dependents.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<input @change="searchDependent" type="text" v-model="search_dependent" class="form-control form-control-sm float-right col-md-2" placeholder="Search" arial-label="Search" v-if="filter == 'id' || filter == 'name' || filter == 'sex' || filter == 'voters'">

					<select @change="searchDependentCivil" v-model="search_dependent_civil" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;" v-if="filter == 'civil'">
						<option value="" disabled selected>Select Civil Status</option>
					    <option v-for="civil in civil_statuses">{{civil.description}}</option>
					</select>

					<select @change="searchDependentStatus" v-model="search_dependent_status" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;" v-if="filter == 'status'">
						<option value="" disabled selected>Select status</option>
						<option value="1" selected>Active</option>
						<option value="0">Not Active</option>
					</select>

					<select v-model="filter" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option value="id">ID</option>
						<option value="name">Name</option>
						<option value="sex">Sex</option>
						<option value="status">Status</option>
						<option value="voters">Voter's ID</option>
						<option value="civil">Civil Status</option>
					</select>
					<label class="mr-2 float-right mt-1">Filter: </label>
				</div>

				<table class="table table-hover table-bordered text-center mt-2">

					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Full Name</th>
							<th>Sex</th>
							<th>Civil Status</th>
							<th>Status</th>
							<th>Voter's ID</th>
							<th>Beneficiary</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="dependents.length > 0">
						<tr v-for="dependent in dependents">
							<td>{{dependent.fullname}}</td>
							<td>{{dependent.sex}}</td>
							<td>{{identifyCivilStatus(dependent.civil_status_id)}}</td>
							<td v-if="dependent.status == 'Not Active'"><h6 class="text-light bg-warning rounded">{{dependent.status}}</h6></td>
							<td v-else><h6 class="text-light bg-success rounded">{{dependent.status}}</h6></td>
							<td>{{dependent.voters_id}}</td>
							<td v-if="dependent.beneficiary_id != ''">{{dependent.beneficiary_id}}</td>
							<td v-else>none</td>
							<td>

								<button @click="toggleActivateDependent(dependent.dependent_id, dependent.voters_id)" v-if="dependent.status == 'Not Active'" class="btn btn-outline-success btn-sm"><i class="fas fa-plus-circle"></i></button>

								<button @click="toggleDeactivateDependent(dependent.dependent_id)" v-if="dependent.status == 'Active'" class="btn btn-outline-danger btn-sm"><i class="fas fa-minus-circle"></i> </button>
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
					<p class="float-left">Showing {{startIndex + 1}} to {{endIndex>this.dependents.length? this.dependents.length :endIndex}} of {{dependents.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.dependents.length / this.show_entries) > 3 ? 3 : Math.ceil(this.dependents.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>
		<div v-if="add_dependent_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>List of Beneficiary
					<a @click="toggleAddDependent" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
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
							<option :value="active_beneficiaries.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<!-- search for id -->
					<input  type="text" class="form-control form-control-sm float-right col-md-2"  placeholder="Search beneficiary id" arial-label="Search">
					<!--               -->
					
					<select class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
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
							<th>Barangay</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="active_beneficiaries.length > 0">
						<tr v-for="(active_beneficiary, index) in active_beneficiaries" v-if="index >= startIndex && index < endIndex">
							<td>{{active_beneficiary.beneficiary_id}}</td>
							<td>{{active_beneficiary.first_name}}</td>
							<td>{{active_beneficiary.last_name}}</td>
							<td>{{active_beneficiary.middle_name}}</td>
							<td v-if="active_beneficiary.status == 'Active'"><h6 class="text-light bg-success rounded">{{active_beneficiary.status}}</h6></td>
							<td v-else><h6 class="text-light bg-warning rounded">{{active_beneficiary.status}}</h6></td>
							<td>{{identifyBarangayName(active_beneficiary.barangay_id)}}</td>
							<td>
								<button @click="toggleDependentList(active_beneficiary.beneficiary_id)" :title="add_dependents" class="btn btn-outline-info btn-sm"><i class="fas fa-users"></i></button>
		
							</td>
						</tr>
					</tbody>
					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"> <b>No data to show</b> </td>
						</tr>
					</tbody>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{this.active_beneficiaries.length ? startIndex + 1 : 0}} to {{endIndex>this.active_beneficiaries.length? this.active_beneficiaries.length :endIndex}} of {{active_beneficiaries.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.active_beneficiaries.length / this.show_entries) > 3 ? 3 : Math.ceil(this.active_beneficiaries.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>

		<div v-if="possible_dependent_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Add New Dependent
					<a @click="toggleDependentList" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>
			<div class="card px-3 pb-4 mt-4 shadow-nohover">
				<div class="float-left mt-4">
					<label class="float-left"><h6>List of selected dependent</h6></label>
					<button @click="toggleSelectDependent" class="btn btn-success btn-sm font-weight-bold float-right"><i class="fas fa-list text-light">&nbsp;</i> Select dependent</button>
				</div>
				<table class="table table-hover table-bordered text-center mt-2">		
						<thead class="thead-info">
							<tr class="table-color text-light">
								<th>Full Name</th>
								<th>Sex</th>
								<th>Civil Status</th>
								<th>Educational Attainment</th>
								<th>Occupation</th>
								<th>voter's ID</th>
								<th colspan="2">Actions</th>
							</tr>
						</thead>
						<tbody v-if="addDependents.length > 0">
							<tr v-for="(addDependent, index) in addDependents" v-cloak>
								<td>{{addDependent.fullname}}</td>
								<td>{{addDependent.sex}}</td>
								<td>{{identifyCivilStatus(addDependent.civil_status)}}</td>
								<td>{{addDependent.educational_attainment}}</td>
								<td>{{addDependent.occupation}}</td>
								<td>{{addDependent.voters_id}}</td>
								<td>
									<button @click="removeDependent(index)" :title="remove_dependent" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
									
								</td>
							</tr>
						</tbody>

						<tbody v-else>
							<tr>
								<td colspan="7" style="font-size: 20px"><b>No dependent to show.</b></td>
							</tr>
						</tbody>

					</table>

				<div class="mt-4 float-right">
					<button @click="saveDependent" class="btn btn-sm bg-primary text-light font-weight-bold float-right"><i class="fas fa-save">&nbsp;</i> Save Dependent</button>
				</div>
			</div>
		</div>

		<div class="modal" id="myModal1" data-keyboard="false" data-backdrop="static"> 
	    	<div class="modal-dialog modal-xl">
	     		<div class="modal-content">
		      	
			        <!-- Modal Header -->
			        <div class="modal-header">
			          	<h4 class="modal-title">Select Beneficiary</h4>
			          		<button type="button" class="btn closing-modal" data-dismiss="modal">
			          			<i class="fas fa-times"></i>
			          		</button>
			        </div>
		        	
			        <!-- Modal body -->
			        <div style="height: 440px;" class="modal-body">
			        	<label class="d-inline-block mr-1" for="show_entries">Show </label>
							<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
								<option value="10" selected>10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
								<option :value="inactive_beneficiaries.length">All</option>
							</select>
						<label class="d-inline-block ml-1" for="show_entries">entries</label>

						<input type="text" class="form-control form-control-sm float-right col-md-2" placeholder="Search" arial-label="Search">

						<select class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
							<option value="" disabled selected>Select Field name</option>
							<option value="medicine name">Medicine name</option>
							<option value="category">Category</option>
							<option value="unit category">Unit Category</option>
						</select>
						<label class="mr-2 float-right mt-1">Filter: </label>
						<table class="table table-hover table-bordered text-center mt-2">
							<thead class="thead-info">
								<tr class="table-color text-light">
									<th>Beneficiary Id</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Middle Name</th>
									<th>Status</th>
									<th>Barangay</th>
									<th colspan="2">Actions</th>
								</tr>
							</thead>
							<tbody v-if="inactive_beneficiaries.length > 0">
								<tr v-for="(inactive_beneficiary, index) in inactive_beneficiaries" v-if="index >= startIndex && index < endIndex">
									<td>{{inactive_beneficiary.beneficiary_id}}</td>
									<td>{{inactive_beneficiary.first_name}}</td>
									<td>{{inactive_beneficiary.last_name}}</td>
									<td>{{inactive_beneficiary.middle_name}}</td>
									<td v-if="inactive_beneficiary.status == 'Active'"><h6 class="text-light bg-success rounded">{{beneficiary.status}}</h6></td>
									<td v-else><h6 class="text-light bg-warning rounded">{{inactive_beneficiary.status}}</h6></td>
									<td>{{identifyBarangayName(inactive_beneficiary.barangay_id)}}</td>
									<td>
										<button @click="addDependentToTable(inactive_beneficiary.beneficiary_id)" :disabled="disabledSelectDependentButton(inactive_beneficiary.voters_id) == inactive_beneficiary.voters_id" class="btn btn-outline-success btn-sm"><i class="fas fa-plus-circle"></i></button>
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
							<p class="float-left">Showing {{this.inactive_beneficiaries.length ? startIndex + 1 : 0}} to {{endIndex>this.inactive_beneficiaries.length? this.inactive_beneficiaries.length :endIndex}} of {{inactive_beneficiaries.length}} entries</p>

							<nav aria-label="Page navigation example">
							  <ul class="pagination justify-content-end">
							    <li class="page-item">
							      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
							    </li>
							    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.inactive_beneficiaries.length / this.show_entries) > 3 ? 3 : Math.ceil(this.inactive_beneficiaries.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
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

	 	<div class="modal" id="myModal2" data-keyboard="false" data-backdrop="static"> <!-- start deactivate modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			        	<h4 class="modal-title">Deactivate User</h4>
			        	<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>
		        
			        <div class="modal-body" id="modal-less-input">
			        	<div class="form-group">
							<div class="col-lg-12">
								<b>Do you want to Deactivate User?</b> 
							</div>
						</div>
					</div>					
					<div class="modal-footer">
						<div class="col-lg-12">
							<button @click="deactivateDependent" class="btn btn-danger float-right btn-sm ml-2">Yes</button>
						</div>
					</div>
	      		</div>
	    	</div>
	 	</div> <!-- end deactivate modal -->

	 	<div class="modal" id="myModal3" data-keyboard="false" data-backdrop="static"> <!-- start activate modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			        	<h4 class="modal-title">Activate User</h4>
			        	<button  type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>
		        
			        <div class="modal-body" id="modal-less-input">
			        	<div class="form-group">
							<div class="col-lg-12">
								<b>Do you want to Activate User?</b> 
							</div>
						</div>
					</div>					
					<div class="modal-footer">
						<div class="col-lg-12">
							<button @click="activateDependent" class="btn btn-success float-right btn-sm ml-2">Yes</button>
						</div>
					</div>
	      		</div>
	    	</div>
	 	</div> <!-- end activate modal -->
	</div>
</div>

<?php include(SHARED_PATH . "/city_hall/registration_staff/dependent/dependent_footer.php"); ?>