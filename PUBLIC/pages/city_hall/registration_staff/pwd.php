 <?php require_once('../../../../private/initialize.php'); ?> 
<?php $page_title = 'Dashboard'; ?>
<?php include(SHARED_PATH . "/city_hall/registration_staff/pwd/pwd_header.php"); ?>


<div id="vue-pwd" class="mt-4" v-cloak> 
	<div class="container">
		<div v-if="main_body">
			<div class="card px-3 pb-1 pt-3">
				<h4> Person with Disability (PWD)
					<a @click="toggleAddMember" class="btn bg-success text-light btn-sm font-weight-bold ml-2"><i class="fas fa-plus"></i></a>
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
							<option :value="beneficiaries.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<input type="text" class="form-control form-control-sm float-right col-md-2" placeholder="Search" arial-label="Search">
					<select class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option>ID</option>
						<option>Name</option>
						<option>Barangay</option>
					</select>
					<label class="mr-2 float-right mt-1">Filter: </label>
				</div>

				<table class="table table-hover table-bordered text-center mt-2">

					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>First Name</th>
							<th>Last Name</th>
							<th>Middle Name</th>
							<th>Status</th>
							<th>Barangay</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="pwd_beneficiaries.length > 0">
						<tr v-for="pwd_beneficiary in pwd_beneficiaries">
							<td>{{pwd_beneficiary.first_name}}</td>
							<td>{{pwd_beneficiary.last_name}}</td>
							<td>{{pwd_beneficiary.middle_name}}</td>
							<td v-if="pwd_beneficiary.status == 'Inactive'"><h6 class="text-light bg-warning rounded">{{pwd_beneficiary.status}}</h6></td>
							<td v-else><h6 class="text-light bg-success rounded">{{pwd_beneficiary.status}}</h6></td>
							<td>{{identifyBarangayName(pwd_beneficiary.barangay_id)}}</td>
							<td>
								<button class="btn btn-sm btn-outline-warning"><i class="fas fa-eye"></i></button>
								<button class="btn btn-outline-primary btn-sm"><i class="fas fa-edit" href="#add" data-toggle="modal" data-target="#myModal1"></i></button>
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
					<p class="float-left">Showing {{startIndex + 1}} to {{endIndex>this.beneficiaries.length? this.pwd_beneficiaries.length :endIndex}} of {{pwd_beneficiaries.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.beneficiaries.length / this.show_entries) > 3 ? 3 : Math.ceil(this.pwd_beneficiaries.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>
 	
		<div v-if="add_member">
			<div class="card px-3 pb-1 pt-3">
				<h4> Person with Disability (PWD)
					<a @click="toggleAddMember" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 pb-5 mt-4">
				<div class="mt-5">
					<h3 class="text-center pb-4" style="font-variant: small-caps;">choose status :</h3>
					<button class="button_choose btn btn-sm btn-outline-primary p-2 ml-5 font-weight-bold shadow float-left mb-5" href="#add" data-toggle="modal" data-target="#myModal2"><h1>old member</h1></button>
					<button class="button_choose btn btn-sm btn-outline-primary p-2 mr-5 font-weight-bold shadow float-right mb-5" href="#add" data-toggle="modal" data-target="#myModal1"><h1>new member</h1></button>
					<p class="pb-3"></p>
				</div>
			</div>
		</div>
		
		

		<div class="modal" id="myModal1" data-keyboard="false" data-backdrop="static"> 
	    	<div class="modal-dialog modal-xl">
	     		<div class="modal-content">
		      	
			        <!-- Modal Header -->
			        <div class="modal-header">
			          	<h4 class="modal-title">Add New Beneficiary</h4>
			          		<button type="button" class="btn closing-modal" data-dismiss="modal">
			          			<i class="fas fa-times"></i>
			          		</button>
			        </div>
		        	
			        <!-- Modal body -->
			        <div style="height: 440px" class="modal-body">
						<div class="form-row mt-2 px-3">
						    <div class="form-group col-md-3">
						    	<label>First name</label>
						       <input type="text" v-model="first_name" :class="{'is-invalid' : first_name_error}" class="form-control form-control-sm" placeholder="Enter First name">
						       <div class="invalid-feedback">This field is required!</div>
						    </div>
						    <div class="form-group col-md-3">
						    	<label>Last name</label>
						       <input type="text" v-model="last_name" :class="{'is-invalid' : last_name_error}" class="form-control form-control-sm" placeholder="Enter Last name">
						       <div class="invalid-feedback">This field is required!</div>
						    </div>
						    <div class="form-group col-md-3">
						    	<label>Middle name</label>
						       <input type="text" v-model="middle_name" :class="{'is-invalid' : middle_name_error}"  class="form-control form-control-sm" placeholder="Enter Middle name">
						       <div class="invalid-feedback">This field is required!</div>
						    </div>
						    <div class="form-group col-md-3">
						    	<label>Birth Date</label>
						       <input type="date" v-model="birth_date" :class="{'is-invalid' : birth_date_error}" class="form-control form-control-sm" placeholder="Enter Birthdate">
						       <div class="invalid-feedback">This field is required!</div>
						    </div>
						</div>

						<div class="form-row mt-2 px-3">
							<div class="form-group col-md-3">
						    	<label>Sex</label>
						       	<select v-model="sex" :class="{'is-invalid' : sex_error}" class="form-control form-control-sm">
						       		<option value="" disabled selected>Select Sex</option>
						       		<option value="Male">Male</option>
						       		<option value="Female">Female</option>
						       	</select>
						       	<div class="invalid-feedback">This field is required!</div>
						    </div>
						    <div class="form-group col-md-3">
						    	<label>Contact no</label>
						       <input type="text" v-model="contact_no" :class="{'is-invalid' : contact_no_error}" class="form-control form-control-sm" placeholder="Enter Contact no.">
						       <div class="invalid-feedback">This field is required!</div>
						    </div>
						    <div class="form-group col-md-3">
						    	<label>Email Address</label>
						       <input type="text" v-model="email_address" :class="{'is-invalid' : email_address_error}" class="form-control form-control-sm" placeholder="Enter Email address">
						       <div class="invalid-feedback">This field is required!</div>
						    </div> 
						    <div class="form-group col-md-3">
						    	<label>Extension</label>
						      	<select v-model="email_extension" :class="{'is-invalid' : email_extension_error}" class="form-control form-control-sm">
						      		<option value="" disabled selected>Select extension</option>
						       		<option value="@gmail.com">@gmail.com</option>
						       		<option value="@yahoo.com">@yahoo.com</option>
						       		<option value="@rocketmail.com">@rocketmail.com</option>
						       	</select>
						       	<div class="invalid-feedback">This field is required!</div>
						    </div>
						</div>

						<div class="form-row mt-2 px-3">
							<div class="form-group col-md-3">
						    	<label>Religion</label>
						        <input type="text" v-model="religion" :class="{'is-invalid' : religion_error}" class="form-control form-control-sm" placeholder="Enter Religion">
						        <div class="invalid-feedback">This field is required!</div>
						    </div>
							<div class="form-group col-md-3">
						    	<label>Educational Attainment</label>
						       	<select v-model="educational_attainment" :class="{'is-invalid' : educational_attainment_error}" class="form-control form-control-sm">
						       		<option value="" disabled selected>Select Educational Attainment</option>
						       		<option value="None">None</option>
						       		<option value="Primary/Elementary">Primary/Elementary</option>
						       		<option value="Secondary/High School">Secondary/High School</option>
						       		<option value="Associate's degree">Associate's degree</option>
						       		<option value="Bachelor's degree">Bachelor's degree</option>
						       		<option value="Master's degree">Master's degree</option>
						       		<option value="Doctorate degree">Doctorate degree</option>
						       	</select>
						       	<div class="invalid-feedback">This field is required!</div>
						    </div>
						   
						    <div class="form-group col-md-3">
						    	<label>Occupation</label>
						       	<select v-model="occupation" :class="{'is-invalid' : occupation_error}" class="form-control form-control-sm">
						       		<option value="" disabled selected>Select Occupation</option>
						       		<option value="Police/Military employee">Police/Military employee</option>
						       		<option value="Pensioner/Retired">Pensioner/Retired</option>
						       		<option value="Housewife">Housewife</option>
						       		<option value="Unemployed">Unemployed</option>
						       		<option value="Student">Student</option>
						       		<option value="Driver">Driver</option>
						       		<option value="Self-employed">Self-employed</option>
						       		<option value="Government employee">Government employee</option>
						       		<option value="Crew/Factory worker">Crew/Factory worker</option>
						       		<option value="Contract employee">Contract employee</option>
						       		<option value="Office worker">Office worker</option>
						       		<option value="Supervisor">Supervisor</option>
						       		<option value="Manager">Manager</option>
						       		<option value="Business owner">Business owner</option>
						       		<option value="Other">Other</option>
						       	</select>
						       	<div class="invalid-feedback">This field is required!</div>
						    </div>
						    <div class="form-group col-md-3">
						    	<label>Civil Status</label>
						       	<select v-model="civil_status" :class="{'is-invalid' : civil_status_error}" class="form-control form-control-sm">
						       		<option value="" disabled selected>Select Civil Status</option>
						       		<option v-for="civil in civil_status">{{civil.description}}</option>
						       	</select>
						       	<div class="invalid-feedback">This field is required!</div>
						    </div>
						    <div class="form-group col-md-3">
						    	<label>Street</label>
						       <input type="text" v-model="street" :class="{'is-invalid' : street_error}" class="form-control form-control-sm" placeholder="Enter Street">
						       <div class="invalid-feedback">This field is required!</div>
						    </div>
						    <div class="form-group col-md-3">
						       <label>House No.</label>
						       <input type="text" v-model="house_no" :class="{'is-invalid' : house_no_error}" class="form-control form-control-sm" placeholder="Enter House No.">
						       <div class="invalid-feedback">This field is required!</div>
						    </div>
						    <div class="form-group col-md-6">
						    	<label>Subdivision</label>
						       <input type="text" v-model="subdivision" :class="{'is-invalid' : subdivision_error}" class="form-control form-control-sm" placeholder="Enter Subdivision">
						       <div class="invalid-feedback">This field is required!</div>
						    </div>
						    
						</div>

						<div class="form-row mt-2 px-3"> 
						    <div class="form-group col-md-3">
						    	<label>Barangay</label>
						       	<select v-model="barangay" :class="{'is-invalid' : barangay_error}" class="form-control form-control-sm">
						       		<option value="" disabled selected>Select Barangay</option>
						       		<option v-for="barangay in barangays" v-show="barangay.barangay_name != 'City Hall'">{{barangay.barangay_name}}</option>
						       	</select>
						       	<div class="invalid-feedback">This field is required!</div>
						    </div>
						</div>
			        </div>

			        <div class="modal-footer">
			        	<button class="btn btn-sm text-light bg-primary font-weight-bold float-right"><i class="far fa-save">&nbsp;</i> Save Dependent</button>
			    	</div>
	      		</div>
	      	</div>
	     </div>

	     <div class="modal" id="myModal2" data-keyboard="false" data-backdrop="static"> 
	    	<div class="modal-dialog modal-xl">
	     		<div class="modal-content">
		      	
			        <!-- Modal Header -->
			        <div class="modal-header">
			          	<h4 class="modal-title">Add New Beneficiary</h4>
			          		<button type="button" class="btn closing-modal" data-dismiss="modal">
			          			<i class="fas fa-times"></i>
			          		</button>
			        </div>
		        	
			        <!-- Modal body -->
			        <div style="height: 440px" class="modal-body">
			        	<div class="card px-3 mt-4 shadow-nohover">
							<div class="float-left mt-4">
								<label class="d-inline-block mr-1" for="show_entries">Show </label>
									<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
										<option value="10" selected>10</option>
										<option value="25">25</option>
										<option value="50">50</option>
										<option value="100">100</option>
										<option value="">All</option>
									</select>
								<label class="d-inline-block ml-1" for="show_entries">entries</label>

								<input type="text" class="form-control form-control-sm float-right col-md-2" placeholder="Search" arial-label="Search">
								<select class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
									<option value="" disabled selected>Select Field name</option>
									<option></option>
								</select>
								<label class="mr-2 float-right mt-1">Filter: </label>
							</div>

							<table class="table table-hover table-bordered text-center mt-2">

								<thead class="thead-info">
									<tr class="table-color text-light">
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
										<td>{{beneficiary.first_name}}</td>
										<td>{{beneficiary.last_name}}</td>
										<td>{{beneficiary.middle_name}}</td>
										<td v-if="beneficiary.status == 'Inactive'"><h6 class="text-light bg-warning rounded">{{beneficiary.status}}</h6></td>
										<td v-else><h6 class="text-light bg-success rounded">{{beneficiary.status}}</h6></td>
										<td>{{identifyBarangayName(beneficiary.barangay_id)}}</td>
										<td>
											<button class="btn btn-sm btn-outline-warning"><i class="fas fa-eye"></i></button>
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
					</div>
					<div class="modal-footer">
			     
			    	</div>
				</div>
			</div>
		</div>
	</div>
</div>



<?php include(SHARED_PATH . "/city_hall/registration_staff/pwd/pwd_footer.php"); ?>