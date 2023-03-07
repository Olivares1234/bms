<?php require_once('../../../../private/initialize.php'); ?> 
<?php $page_title = 'Dashboard'; ?>
<?php include(SHARED_PATH . "/city_hall/registration_staff/4P's/4P's_header.php"); ?>

<div id="vue-4Ps" class="mt-4" v-cloak> 
	<div class="container">
		<div v-if="beneficiary_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4> List of 4P's Beneficiary
					<a @click="toggleAddBeneficiary" class="btn bg-success text-light btn-sm font-weight-bold ml-2"><i class="fas fa-plus"></i></a>
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
					<tbody v-if="beneficiaries.length > 0">
						<tr v-for="beneficiary in beneficiaries">
							<td>{{beneficiary.first_name}}</td>
							<td>{{beneficiary.last_name}}</td>
							<td>{{beneficiary.middle_name}}</td>
							<td v-if="beneficiary.status == 'Inactive'"><h6 class="text-light bg-warning rounded">{{beneficiary.status}}</h6></td>
							<td v-else><h6 class="text-light bg-success rounded">{{beneficiary.status}}</h6></td>
							<td>{{identifyBarangayName(beneficiary.barangay_id)}}</td>
							<td>
								<button @click="toggleViewBeneficiary(beneficiary.beneficiary_id)" class="btn btn-sm btn-outline-warning"><i class="fas fa-eye"></i></button>
								<button @click="toggleUpdateBeneficiary(beneficiary.beneficiary_id)" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></button>
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

		<div v-if="status_info">
			<div class="card px-3 pb-1 pt-3">
				<h4> 4P's Beneficiary 
					<a @click="toggleAddBeneficiary" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>
			<div class="card px-3 pb-5 mt-4">
				<div class="mt-5">
					<h3 class="text-center pb-4" style="font-variant: small-caps;">choose status :</h3>
					<button @click="toggleAddOldBeneficiary" class="button_choose btn btn-sm btn-outline-primary p-2 ml-5 font-weight-bold shadow float-left mb-5"><h1>old beneficiary</h1></button>
					<button @click="toggleAddNewBeneficiary" class="button_choose btn btn-sm btn-outline-primary p-2 mr-5 font-weight-bold shadow float-right mb-5"><h1>new beneficiary</h1></button>
					<p class="pb-3"></p>
				</div>
			</div>
		</div>

		<div v-if="add_new_beneficiary">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Add New 4P's Beneficiary
					<a @click="toggleAddNewBeneficiary" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 pb-5 mt-4 shadow-nohover">
				<h5 class="mt-4">Beneficiary Details</h5>
				<div class="mt-3 shadow-sm rounded bg-light pt-3 pb-3">
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
					       	<select v-model="beneficiary_civil_status" :class="{'is-invalid' : civil_status_error}" class="form-control form-control-sm">
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
			</div>

			<div class="card px-3 pb-3 mt-4 shadow-nohover">
				<h5 class="mt-4">Dependent Details
					<a class="btn bg-success text-light btn-sm font-weight-bold ml-2" href="#add" data-toggle="modal" data-target="#myModal5"><i class="fas fa-plus"></i></a>
				</h5>
					<table class="table table-hover table-bordered text-center mt-4">
						<thead class="thead-info">
							<tr class="table-color text-light">
								<th>First Name</th>
								<th>Middle Name</th>
								<th>Last Name</th>
								<th>Sex</th>
								<th>Contact Number</th>
								<th>Actions</th>
							</tr>
						</thead>

						<tbody v-if="addDependents.length > 0">
							<tr v-for="(addDependent, index) in addDependents">
								<td>{{addDependent.first_name}}</td>
								<td>{{addDependent.middle_name}}</td>
								<td>{{addDependent.last_name}}</td>
								<td>{{addDependent.sex}}</td>
								<td>{{addDependent.contact_no}}</td>
								<td>
									<button @click="viewDependentDetails(index)" class="btn btn-sm btn-outline-warning" href="#add" data-toggle="modal" data-target="#myModal7"><i class="fas fa-eye"></i></button>
									<button @click="toggleUpdateDependentDetails(index)" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></button></button>
								</td>
							</tr>
						</tbody>

						<tbody v-else>
							<tr>
								<td colspan="12" style="font-size: 20px"><b>No dependent to show</b></td>
							</tr>
						</tbody>
					</table>

				<div class="mt-3 float-right">
					<!--  -->
					<button @click="addBeneficiary" class="btn btn-sm text-light bg-primary font-weight-bold float-right"><i class="far fa-save">&nbsp;</i> Save Beneficiary Details</button>
				</div>
			</div>

			<div class="modal" id="myModal6" data-keyboard="false" data-backdrop="static"> 
		    	<div class="modal-dialog modal-xl">
		     		<div class="modal-content">
			      	
				        <!-- Modal Header -->
				        <div class="modal-header">
				          	<h4 class="modal-title">Update Dependent</h4>
				          		<button type="button" class="btn closing-modal" data-dismiss="modal">
				          			<i class="fas fa-times"></i>
				          		</button>
				        </div>
			        	
				        <!-- Modal body -->
				        <div style="height: 440px;" class="modal-body">
							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-3">
							    	<label>First name</label>
							       <input type="text" v-model="dependent_first_name" :class="{'is-invalid' : dependent_first_name_error}" class="form-control form-control-sm" placeholder="Enter First name">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Last name</label>
							       <input type="text" v-model="dependent_last_name" :class="{'is-invalid' : dependent_last_name_error}" class="form-control form-control-sm" placeholder="Enter Last name">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Middle name</label>
							       <input type="text" v-model="dependent_middle_name" :class="{'is-invalid' : dependent_middle_name_error}"  class="form-control form-control-sm" placeholder="Enter Middle name">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Birth Month</label>
							      	<select v-model="dependent_birth_month" :class="{'is-invalid' : dependent_birth_month_error}" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select month</option>
							       		<option value="01">January</option>
							       		<option value="02">February</option>
							       		<option value="03">March</option>
							       		<option value="04">April</option>
							       		<option value="05">May</option>
							       		<option value="06">June</option>
							       		<option value="07">July</option>
							       		<option value="08">August</option>
							       		<option value="09">September</option>
							       		<option value="10">October</option>
							       		<option value="11">November</option>
							       		<option value="12">December</option>
							       	</select>
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-3">
							    	<label>Birth Day</label>
							      	<select v-model="dependent_birth_day" :class="{'is-invalid' : dependent_birth_day_error}" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Day</option>
							       		<option value="01">1</option>
							       		<option value="02">2</option>
							       		<option value="03">3</option>
							       		<option value="04">4</option>
							       		<option value="05">5</option>
							       		<option value="06">6</option>
							       		<option value="07">7</option>
							       		<option value="08">8</option>
							       		<option value="09">9</option>
							       		<option value="10">10</option>
							       		<option value="11">11</option>
							       		<option value="12">12</option>
							       		<option value="13">13</option>
							       		<option value="14">14</option>
							       		<option value="15">15</option>
							       		<option value="16">16</option>
							       		<option value="17">17</option>
							       		<option value="18">18</option>
							       		<option value="19">19</option>
							       		<option value="20">20</option>
							       		<option value="21">21</option>
							       		<option value="22">22</option>
							       		<option value="23">23</option>
							       		<option value="24">24</option>
							       		<option value="25">25</option>
							       		<option value="26">26</option>
							       		<option value="27">27</option>
							       		<option value="28">28</option>
							       		<option value="29">29</option>
							      		<option value="30">30</option>
							      		<option value="31">31</option>
							       	</select>
							       <div class="invalid-feedback">This field is required!</div>
							    </div>

							    <div class="form-group col-md-3">
							    	<label>Birth Year</label>
							      	<select v-model="dependent_birth_year" :class="{'is-invalid' : dependent_birth_year_error}" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Year</option>
							       		<option v-for="year in years">{{year}}</option>
							       	</select>
							       <div class="invalid-feedback">This field is required!</div>
							    </div>

							    <div class="form-group col-md-3">
							    	<label>Sex</label>
							       	<select v-model="dependent_sex" :class="{'is-invalid' : dependent_sex_error}" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Sex</option>
							       		<option value="Male">Male</option>
							       		<option value="Female">Female</option>
							       	</select>
							       	<div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Contact no</label>
							       <input type="text" v-model="dependent_contact_no" :class="{'is-invalid' : dependent_contact_no_error}" class="form-control form-control-sm" placeholder="Enter Contact no.">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
								
							    <div class="form-group col-md-3">
							    	<label>Email Address</label>
							       <input type="text" v-model="dependent_email_address" :class="{'is-invalid' : dependent_email_address_error}" class="form-control form-control-sm" placeholder="Enter Email address">
							       <div class="invalid-feedback">This field is required!</div>
							    </div> 
							    <div class="form-group col-md-3">
							    	<label>Extension</label>
							      	<select v-model="dependent_email_extension" :class="{'is-invalid' : dependent_email_extension_error}" class="form-control form-control-sm">
							      		<option value="" disabled selected>Select extension</option>
							       		<option value="@gmail.com">@gmail.com</option>
							       		<option value="@yahoo.com">@yahoo.com</option>
							       		<option value="@rocketmail.com">@rocketmail.com</option>
							       	</select>
							       	<div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Religion</label>
							        <input type="text" v-model="dependent_religion" :class="{'is-invalid' : dependent_religion_error}" class="form-control form-control-sm" placeholder="Enter Religion">
							        <div class="invalid-feedback">This field is required!</div>
							    </div>
								<div class="form-group col-md-3">
							    	<label>Educational Attainment</label>
							       	<select v-model="dependent_educational_attainment" :class="{'is-invalid' : dependent_educational_attainment_error}" class="form-control form-control-sm">
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
							</div>

							<div class="form-row mt-2 px-3">
								
							   
							    <div class="form-group col-md-3">
							    	<label>Occupation</label>
							       	<select v-model="dependent_occupation" :class="{'is-invalid' : dependent_occupation_error}" class="form-control form-control-sm">
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
							       	<select v-model="dependent_civil_status" :class="{'is-invalid' : dependent_civil_status_error}" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Civil Status</option>
							       		<option v-for="civil in civil_status">{{civil.description}}</option>
							       	</select>
							       	<div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Street</label>
							       <input type="text" v-model="dependent_street" :class="{'is-invalid' : dependent_street_error}" class="form-control form-control-sm" placeholder="Enter Street">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							       <label>House No.</label>
							       <input type="text" v-model="dependent_house_no" :class="{'is-invalid' : dependent_house_no_error}" class="form-control form-control-sm" placeholder="Enter House No.">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-6">
							    	<label>Subdivision</label>
							       <input type="text" v-model="dependent_subdivision" :class="{'is-invalid' : dependent_subdivision_error}" class="form-control form-control-sm" placeholder="Enter Subdivision">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							</div>
				        </div>

				        <div class="modal-footer">
				        	<button @click="updateDependentDetails" class="btn btn-sm text-light bg-primary font-weight-bold float-right"><i class="far fa-save">&nbsp;</i> Save Dependent</button>
				    	</div>
		      		</div>
		      	</div>
		     </div>

		     <div class="modal" id="myModal5" data-keyboard="false" data-backdrop="static"> 
		    	<div class="modal-dialog modal-xl">
		     		<div class="modal-content">
			      	
				        <!-- Modal Header -->
				        <div class="modal-header">
				          	<h4 class="modal-title">Add Dependent</h4>
				          		<button type="button" class="btn closing-modal" data-dismiss="modal">
				          			<i class="fas fa-times"></i>
				          		</button>
				        </div>
			        	
				        <!-- Modal body -->
				        <div style="height: 440px;" class="modal-body">
							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-3">
							    	<label>First name</label>
							       <input type="text" v-model="dependent_first_name" :class="{'is-invalid' : dependent_first_name_error}" class="form-control form-control-sm" placeholder="Enter First name">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Last name</label>
							       <input type="text" v-model="dependent_last_name" :class="{'is-invalid' : dependent_last_name_error}" class="form-control form-control-sm" placeholder="Enter Last name">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Middle name</label>
							       <input type="text" v-model="dependent_middle_name" :class="{'is-invalid' : dependent_middle_name_error}"  class="form-control form-control-sm" placeholder="Enter Middle name">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Birth Month</label>
							      	<select v-model="dependent_birth_month" :class="{'is-invalid' : dependent_birth_month_error}" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select month</option>
							       		<option value="01">January</option>
							       		<option value="02">February</option>
							       		<option value="03">March</option>
							       		<option value="04">April</option>
							       		<option value="05">May</option>
							       		<option value="06">June</option>
							       		<option value="07">July</option>
							       		<option value="08">August</option>
							       		<option value="09">September</option>
							       		<option value="10">October</option>
							       		<option value="11">November</option>
							       		<option value="12">December</option>
							       	</select>
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-3">
							    	<label>Birth Day</label>
							      	<select v-model="dependent_birth_day" :class="{'is-invalid' : dependent_birth_day_error}" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Day</option>
							       		<option value="01">1</option>
							       		<option value="02">2</option>
							       		<option value="03">3</option>
							       		<option value="04">4</option>
							       		<option value="05">5</option>
							       		<option value="06">6</option>
							       		<option value="07">7</option>
							       		<option value="08">8</option>
							       		<option value="09">9</option>
							       		<option value="10">10</option>
							       		<option value="11">11</option>
							       		<option value="12">12</option>
							       		<option value="13">13</option>
							       		<option value="14">14</option>
							       		<option value="15">15</option>
							       		<option value="16">16</option>
							       		<option value="17">17</option>
							       		<option value="18">18</option>
							       		<option value="19">19</option>
							       		<option value="20">20</option>
							       		<option value="21">21</option>
							       		<option value="22">22</option>
							       		<option value="23">23</option>
							       		<option value="24">24</option>
							       		<option value="25">25</option>
							       		<option value="26">26</option>
							       		<option value="27">27</option>
							       		<option value="28">28</option>
							       		<option value="29">29</option>
							      		<option value="30">30</option>
							      		<option value="31">31</option>
							       	</select>
							       <div class="invalid-feedback">This field is required!</div>
							    </div>

							    <div class="form-group col-md-3">
							    	<label>Birth Year</label>
							      	<select v-model="dependent_birth_year" :class="{'is-invalid' : dependent_birth_year_error}" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Year</option>
							       		<option v-for="year in years">{{year}}</option>
							       	</select>
							       <div class="invalid-feedback">This field is required!</div>
							    </div>

							    <div class="form-group col-md-3">
							    	<label>Sex</label>
							       	<select v-model="dependent_sex" :class="{'is-invalid' : dependent_sex_error}" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Sex</option>
							       		<option value="Male">Male</option>
							       		<option value="Female">Female</option>
							       	</select>
							       	<div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Contact no</label>
							       <input type="text" v-model="dependent_contact_no" :class="{'is-invalid' : dependent_contact_no_error}" class="form-control form-control-sm" placeholder="Enter Contact no.">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
								
							    <div class="form-group col-md-3">
							    	<label>Email Address</label>
							       <input type="text" v-model="dependent_email_address" :class="{'is-invalid' : dependent_email_address_error}" class="form-control form-control-sm" placeholder="Enter Email address">
							       <div class="invalid-feedback">This field is required!</div>
							    </div> 
							    <div class="form-group col-md-3">
							    	<label>Extension</label>
							      	<select v-model="dependent_email_extension" :class="{'is-invalid' : dependent_email_extension_error}" class="form-control form-control-sm">
							      		<option value="" disabled selected>Select extension</option>
							       		<option value="@gmail.com">@gmail.com</option>
							       		<option value="@yahoo.com">@yahoo.com</option>
							       		<option value="@rocketmail.com">@rocketmail.com</option>
							       	</select>
							       	<div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Religion</label>
							        <input type="text" v-model="dependent_religion" :class="{'is-invalid' : dependent_religion_error}" class="form-control form-control-sm" placeholder="Enter Religion">
							        <div class="invalid-feedback">This field is required!</div>
							    </div>
								<div class="form-group col-md-3">
							    	<label>Educational Attainment</label>
							       	<select v-model="dependent_educational_attainment" :class="{'is-invalid' : dependent_educational_attainment_error}" class="form-control form-control-sm">
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
							</div>

							<div class="form-row mt-2 px-3">
								
							   
							    <div class="form-group col-md-3">
							    	<label>Occupation</label>
							       	<select v-model="dependent_occupation" :class="{'is-invalid' : dependent_occupation_error}" class="form-control form-control-sm">
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
							       	<select v-model="dependent_civil_status" :class="{'is-invalid' : dependent_civil_status_error}" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Civil Status</option>
							       		<option v-for="civil in civil_status">{{civil.description}}</option>
							       	</select>
							       	<div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Street</label>
							       <input type="text" v-model="dependent_street" :class="{'is-invalid' : dependent_street_error}" class="form-control form-control-sm" placeholder="Enter Street">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-3">
							       <label>House No.</label>
							       <input type="text" v-model="dependent_house_no" :class="{'is-invalid' : dependent_house_no_error}" class="form-control form-control-sm" placeholder="Enter House No.">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							    <div class="form-group col-md-6">
							    	<label>Subdivision</label>
							       <input type="text" v-model="dependent_subdivision" :class="{'is-invalid' : dependent_subdivision_error}" class="form-control form-control-sm" placeholder="Enter Subdivision">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							</div>
				        </div>

				        <div class="modal-footer">
				        	<button @click="addDependentToTemporary" class="btn btn-sm text-light bg-success font-weight-bold float-right"><i class="fas fa-plus">&nbsp;</i> Add Dependent</button>
				    	</div>
		      		</div>
		      	</div>
		     </div>


			<div class="modal" id="myModal7" data-keyboard="false" data-backdrop="static"> 
		    	<div class="modal-dialog modal-xl">
		     		<div class="modal-content">
			      	
				        <!-- Modal Header -->
				        <div class="modal-header">
				          	<h4 class="modal-title">View Dependent</h4>
				          		<button type="button" class="btn closing-modal" data-dismiss="modal">
				          			<i class="fas fa-times"></i>
				          		</button>
				        </div>
			        	
				        <!-- Modal body -->
				        <div style="height: 440px;" class="modal-body">
							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-3">
							    	<label>First name</label>
							       <input type="text" v-model="dependent_first_name" class="form-control form-control-sm" disabled="">
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Last name</label>
							       <input type="text" v-model="dependent_last_name"  class="form-control form-control-sm" disabled="">
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Middle name</label>
							       <input type="text" v-model="dependent_middle_name"   class="form-control form-control-sm" disabled="">
							       
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Birth Month</label>
							      	<select v-model="dependent_birth_month"  class="form-control form-control-sm" disabled="">
							       		<option value="" disabled selected>Select month</option>
							       		<option value="01">January</option>
							       		<option value="02">February</option>
							       		<option value="03">March</option>
							       		<option value="04">April</option>
							       		<option value="05">May</option>
							       		<option value="06">June</option>
							       		<option value="07">July</option>
							       		<option value="08">August</option>
							       		<option value="09">September</option>
							       		<option value="10">October</option>
							       		<option value="11">November</option>
							       		<option value="12">December</option>
							       	</select>
							       
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-3">
							    	<label>Birth Day</label>
							      	<select v-model="dependent_birth_day"  class="form-control form-control-sm" disabled="">
							       		<option value="" disabled selected>Select Day</option>
							       		<option value="01">1</option>
							       		<option value="02">2</option>
							       		<option value="03">3</option>
							       		<option value="04">4</option>
							       		<option value="05">5</option>
							       		<option value="06">6</option>
							       		<option value="07">7</option>
							       		<option value="08">8</option>
							       		<option value="09">9</option>
							       		<option value="10">10</option>
							       		<option value="11">11</option>
							       		<option value="12">12</option>
							       		<option value="13">13</option>
							       		<option value="14">14</option>
							       		<option value="15">15</option>
							       		<option value="16">16</option>
							       		<option value="17">17</option>
							       		<option value="18">18</option>
							       		<option value="19">19</option>
							       		<option value="20">20</option>
							       		<option value="21">21</option>
							       		<option value="22">22</option>
							       		<option value="23">23</option>
							       		<option value="24">24</option>
							       		<option value="25">25</option>
							       		<option value="26">26</option>
							       		<option value="27">27</option>
							       		<option value="28">28</option>
							       		<option value="29">29</option>
							      		<option value="30">30</option>
							      		<option value="31">31</option>
							       	</select>
							       
							    </div>

							    <div class="form-group col-md-3">
							    	<label>Birth Year</label>
							      	<select v-model="dependent_birth_year"  class="form-control form-control-sm" disabled="">
							       		<option value="" disabled selected>Select Year</option>
							       		<option v-for="year in years">{{year}}</option>
							       	</select>
							       
							    </div>

							    <div class="form-group col-md-3">
							    	<label>Sex</label>
							       	<select v-model="dependent_sex"  class="form-control form-control-sm" disabled="">
							       		<option value="" disabled selected>Select Sex</option>
							       		<option value="Male">Male</option>
							       		<option value="Female">Female</option>
							       	</select>
							       	
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Contact no</label>
							       <input type="text" v-model="dependent_contact_no" class="form-control form-control-sm" disabled="">
							       <div class="invalid-feedback">This field is required!</div>
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
								
							    <div class="form-group col-md-3">
							    	<label>Email Address</label>
							       <input type="text" v-model="dependent_email_address" class="form-control form-control-sm" disabled="">
							       
							    </div> 
							    <div class="form-group col-md-3">
							    	<label>Extension</label>
							      	<select v-model="dependent_email_extension"  class="form-control form-control-sm" disabled="">
							      		<option value="" disabled selected>Select extension</option>
							       		<option value="@gmail.com">@gmail.com</option>
							       		<option value="@yahoo.com">@yahoo.com</option>
							       		<option value="@rocketmail.com">@rocketmail.com</option>
							       	</select>
							 
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Religion</label>
							        <input type="text" v-model="dependent_religion"  class="form-control form-control-sm" disabled="">
							        
							    </div>
								<div class="form-group col-md-3">
							    	<label>Educational Attainment</label>
							       	<select v-model="dependent_educational_attainment" class="form-control form-control-sm" disabled="">
							       		<option value="" disabled selected>Select Educational Attainment</option>
							       		<option value="None">None</option>
							       		<option value="Primary/Elementary">Primary/Elementary</option>
							       		<option value="Secondary/High School">Secondary/High School</option>
							       		<option value="Associate's degree">Associate's degree</option>
							       		<option value="Bachelor's degree">Bachelor's degree</option>
							       		<option value="Master's degree">Master's degree</option>
							       		<option value="Doctorate degree">Doctorate degree</option>
							       	</select>
							       	
							    </div>
							</div>

							<div class="form-row mt-2 px-3">

							    <div class="form-group col-md-3">
							    	<label>Occupation</label>
							       	<select v-model="dependent_occupation" class="form-control form-control-sm" disabled="">
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
							       	
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Civil Status</label>
							       	<select v-model="dependent_civil_status" class="form-control form-control-sm" disabled="">
							       		<option value="" disabled selected>Select Civil Status</option>
							       		<option v-for="civil in civil_status">{{civil.description}}</option>
							       	</select>
							       	
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Street</label>
							       <input type="text" v-model="dependent_street" class="form-control form-control-sm" disabled="">
							       
							    </div>
							    <div class="form-group col-md-3">
							       <label>House No.</label>
							       <input type="text" v-model="dependent_house_no" class="form-control form-control-sm" disabled="">
							       
							    </div>
							    <div class="form-group col-md-6">
							    	<label>Subdivision</label>
							       <input type="text" v-model="dependent_subdivision" class="form-control form-control-sm" disabled="">
							       
							    </div>
							</div>
				        </div>

						<div class="modal-footer">
				        	
				    	</div>
		      		</div>
		    	</div>
		 	</div> 
		</div>

		<div v-if="view_beneficiary">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>View 4P's Beneficiary
					<a @click="toggleViewBeneficiary" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 pb-5 mt-4 shadow-nohover">
				<h5 class="mt-4">Beneficiary Details</h5>
				<div class="mt-3 shadow-sm rounded bg-light pt-3 pb-3">
					<div class="form-row mt-2 px-3">
					    <div class="form-group col-md-3">
					    	<label><b>First name :</b> {{first_name}}</label>

					    </div>
					    <div class="form-group col-md-3">
					    	<label><b>Last name :</b> {{last_name}}</label>
					       
					    </div>
					    <div class="form-group col-md-3">
					    	<label><b>Middle name :</b> {{middle_name}}</label>
					      
					    </div>
					    <div class="form-group col-md-3">
					    	<label><b>Birth Date :</b> {{birth_date}}</label>
					       
					    </div>
					</div>

					<div class="form-row mt-2 px-3">
						<div class="form-group col-md-3">
					    	<label><b>Sex :</b> {{sex}}</label>
					       	
					    </div>
					    <div class="form-group col-md-3">
					    	<label><b>Contact no :</b> {{contact_no}}</label>
					       
					    </div>
					    <div class="form-group col-md-3">
					    	<label><b>Email Address :</b> {{email_address + email_extension}}</label>
					      
					    </div>
					    <div class="form-group col-md-3">
					    	<label><b>Religion :</b> {{religion}}</label>
					        
					    </div> 
					</div>

					<div class="form-row mt-2 px-3">
						
						<div class="form-group col-md-3">
					    	<label><b>Educational Attainment : </b>{{educational_attainment}}</label>
					       	
					    </div>
					   
					    <div class="form-group col-md-3">
					    	<label><b>Occupation :</b> {{occupation}}</label>
					       	
					    </div>
					    <div class="form-group col-md-3">
					    	<label><b>Civil Status :</b> {{beneficiary_civil_status}}</label>
					       
					    </div>
					    <div class="form-group col-md-3">
					    	<label><b>Street </b>: {{street}}</label>
					       
					    </div>
					    <div class="form-group col-md-3">
					       <label><b>House No :</b> {{house_no}}</label>
					       
					    </div>
					    <div class="form-group col-md-6">
					    	<label><b>Subdivision :</b> {{subdivision}}</label>
					       
					    </div>

					    <div class="form-group col-md-3">
					    	<label><b>Beneficiary Type :</b> {{beneficiary_type}}</label>
					    </div>
					    
					</div>

					<div class="form-row mt-2 px-3">
						<div class="form-group col-md-3">
					    	<label><b>Status :</b> {{status}}</label>
					    </div>
					    <div class="form-group col-md-3">
					    	<label><b>Balance :</b> {{balance}}</label>
					    </div>
						<div class="form-group col-md-3">
					    	<label><b>Barangay :</b> {{barangay}}</label>
					    </div>
					</div>
				</div>
			</div>

			<div class="card px-3 pb-3 mt-4 shadow-nohover">
				<h5 class="mt-4">Dependent Details</h5>
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
				</div>
				<table class="table table-hover table-bordered text-center mt-4">
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>First Name</th>
							<th>Middle Name</th>
							<th>Last Name</th>
							<th>Sex</th>
							<th>Contact Number</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody v-if="dependents.length > 0">
						<tr v-for="(dependent, index) in dependents">
							<td>{{dependent.first_name}}</td>
							<td>{{dependent.middle_name}}</td>
							<td>{{dependent.last_name}}</td>
							<td>{{dependent.sex}}</td>
							<td>{{dependent.contact_no}}</td>
							<td>
								<button class="btn btn-sm btn-outline-warning" href="#add" data-toggle="modal" data-target="#myModal7"><i class="fas fa-eye"></i></button>
								<button class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></button></button>
							</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No dependent to show</b></td>
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
		<div v-if="add_old_beneficiary">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4> Select Beneficiary
					<a @click="toggleAddOldBeneficiary" class="btn bg-info text-light btn-sm font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
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
					<tbody v-if="indigents.length > 0">
						<tr v-for="indigent in indigents">
							<td>{{indigent.first_name}}</td>
							<td>{{indigent.last_name}}</td>
							<td>{{indigent.middle_name}}</td>
							<td v-if="indigent.status == 'Inactive'"><h6 class="text-light bg-warning rounded">{{indigent.status}}</h6></td>
							<td v-else><h6 class="text-light bg-success rounded">{{indigent.status}}</h6></td>
							<td>{{identifyBarangayName(indigent.barangay_id)}}</td>
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
					<p class="float-left">Showing {{startIndex + 1}} to {{endIndex>this.indigents.length? this.indigents.length :endIndex}} of {{indigents.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.indigents.length / this.show_entries) > 3 ? 3 : Math.ceil(this.indigents.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>

		<div v-if="beneficiary_info">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Beneficiary Information
					<a @click="toggle4PsDependentInfo" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 pb-3 mt-4 shadow-nohover">
				<div class="nav nav-pills mt-4">
				    <button class="nav-link active btn btn-sm text-light bg-info font-weight-bold float-left" href="#profile" role="tab" data-toggle="tab">
				    	<span class="number text-light">1</span> 
				    	<span class="title text-light font-weight-bold pr-2">Beneficiary Details </span>
				    </button>

				    <button class="nav-link btn btn-sm text-light bg-info font-weight-bold float-left ml-2" href="#buzz" role="tab" data-toggle="tab">
				    	<span class="number text-light">2</span> 
				    	<span class="title text-light font-weight-bold pr-2">Dependent Details </span>
				    </button>
				</div>
			
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade show active" id="profile">
						<div class="mt-3 shadow-sm rounded bg-light pt-3 pb-3">
							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-3">
							    	<label>First name</label>
							       <input type="text" v-model="first_name" class="form-control form-control-sm" placeholder="Enter First name">
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Last name</label>
							       <input type="text" v-model="last_name" class="form-control form-control-sm" placeholder="Enter Last name">
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Middle name</label>
							       <input type="text" v-model="middle_name"  class="form-control form-control-sm" placeholder="Enter Middle name">
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Birth Date</label>
							       <input type="date" v-model="birth_date" class="form-control form-control-sm" placeholder="Enter Birthdate">
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
								<div class="form-group col-md-3">
							    	<label>Sex</label>
							       	<select v-model="sex" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Sex</option>
							       		<option value="Male">Male</option>
							       		<option value="Female">Female</option>
							       	</select>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Contact no</label>
							       <input type="text" v-model="contact_no" class="form-control form-control-sm" placeholder="Enter Contact no.">
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Email Address</label>
							       <input type="text" v-model="email_address" class="form-control form-control-sm" placeholder="Enter Email address">
							    </div> 
							    <div class="form-group col-md-3">
							    	<label>Extension</label>
							      	<select v-model="email_extension" class="form-control form-control-sm">
							       		<option value="@gmail.com" selected>@gmail.com</option>
							       		<option value="@yahoo.com">@yahoo.com</option>
							       		<option value="@rocketmail.com">@rocketmail.com</option>
							       	</select>
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
								<div class="form-group col-md-3">
							    	<label>Religion</label>
							        <input type="text" v-model="religion" class="form-control form-control-sm" placeholder="Enter Religion">
							    </div>
								<div class="form-group col-md-3">
							    	<label>Educational Attainment</label>
							       	<select v-model="educational_attainment" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Educational Attainment</option>
							       		<option value="None">None</option>
							       		<option value="Primary/Elementary">Primary/Elementary</option>
							       		<option value="Secondary/High School">Secondary/High School</option>
							       		<option value="Associate's degree">Associate's degree</option>
							       		<option value="Bachelor's degree">Bachelor's degree</option>
							       		<option value="Master's degree">Master's degree</option>
							       		<option value="Doctorate degree">Doctorate degree</option>
							       	</select>
							    </div>
							   
							    <div class="form-group col-md-3">
							    	<label>Occupation</label>
							       	<select v-model="occupation" class="form-control form-control-sm">
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
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Civil Status</label>
							       	<select v-model="beneficiary_civil_status" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Civil Status</option>
							       		<option v-for="civil in civil_status">{{civil.description}}</option>
							       	</select>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Street</label>
							       <input type="text" v-model="street" class="form-control form-control-sm" placeholder="Enter Street">
							    </div>
							    <div class="form-group col-md-3">
							       <label>House No.</label>
							       <input type="text" v-model="house_no" class="form-control form-control-sm" placeholder="Enter House No.">
							    </div>
							    <div class="form-group col-md-6">
							    	<label>Subdivision</label>
							       <input type="text" v-model="subdivision" class="form-control form-control-sm" placeholder="Enter Subdivision">
							    </div>
							    
							</div>

							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-3">
							    	<label>Barangay</label>
							       	<select v-model="barangay" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Barangay</option>
							       		<option v-for="barangay in barangays" v-show="barangay.barangay_name != 'City Hall'">{{barangay.barangay_name}}</option>
							       	</select>
							    </div>
							</div>
						</div>

						<div class="float-right mt-3">
							<button class="btn btn-sm text-light bg-info font-weight-bold"> Update</button>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane fade" id="buzz">
						<table class="table table-hover table-bordered text-center mt-5">
							<thead class="thead-info">
								<tr class="table-color text-light">
									<th>First Name</th>
									<th>Last Name</th>
									<th>Middle Name</th>
									<th>Sex</th>
									<th>Civil Status</th>
									<th>Occupation</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>
										<button class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></button>
									</td>
								</tr>
							</tbody>
							<!-- <tbody v-else>
								<tr>
									<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
								</tr>
							</tbody> -->
						</table>
					</div>
				</div>
			</div>
		</div>
		<div v-if="update_beneficiary">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4> Update Beneficiary
					<a @click="toggleUpdateBeneficiary" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>	

			<div class="card px-3 pb-5 mt-4 shadow-nohover">
				<h5 class="mt-4">Beneficiary Details</h5>
				<div class="mt-3 shadow-sm rounded bg-light pt-3 pb-3">
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
					       	<select v-model="beneficiary_civil_status" :class="{'is-invalid' : civil_status_error}" class="form-control form-control-sm">
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
				<div class="form-row mt-2 px-3">
					<button @click="updateBeneficiary">Update beneficiary</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include(SHARED_PATH . "/city_hall/registration_staff/4P's/4P's_footer.php"); ?>
