<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Beneficiary'; ?>
<?php include(SHARED_PATH . "/city_hall/registration_staff/beneficiary/beneficiary_header.php"); ?>

<div id="vue-beneficiary" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="beneficiary_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4> List of Beneficiary
					<a @click="toggleAddNewBeneficiary" class="btn bg-success text-light btn-sm font-weight-bold ml-2"><i class="fas fa-plus"></i></a>
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

					<input @input="searchBeneficiary" type="text" v-model="search_beneficiary" class="form-control form-control-sm float-right col-md-2" placeholder="Search" arial-label="Search" v-if="filter == 'id' || filter == 'name'">

					<select @change="searchBeneficiary" v-model="search_beneficiary" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;" v-if="filter == 'barangay'">
			       		<option value="" disabled selected>Select Barangay</option>
			       		<option v-for="barangay in barangays" v-show="barangay.barangay_name != 'City Hall' && barangay.barangay_name != 'none'">{{barangay.barangay_name}}</option>
			       	</select>

					<select @change="searchBeneficiaryStatus(search_beneficiary_status)" v-model="search_beneficiary_status" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;" v-if="filter == 'status'">
						<option value="" disabled selected>Select status</option>
						<option value="">All</option>
						<option value="Active">Active</option>
						<option value="Not Active">Not Active</option>
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
							<th>Full Name</th>
							<th>Status</th>
							<th>Type</th>
							<th>Barangay</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="beneficiaries.length > 0">
						<tr v-for="(beneficiary, index) in beneficiaries" v-if="index >= startIndex && index < endIndex">
							<td>{{beneficiary.beneficiary_id}}</td>
							<td>{{beneficiary.first_name + " " + beneficiary.middle_name + " " + beneficiary.last_name}}</td>
							<td v-if="beneficiary.status == 'Active'"><h6 class="text-light bg-success rounded">{{beneficiary.status}}</h6></td>
							<td v-else><h6 class="text-light bg-warning rounded">{{beneficiary.status}}</h6></td>
							<td>{{identifyBeneficiaryType(beneficiary.beneficiary_type_id)}}</td>
							<td>{{identifyBarangayName(beneficiary.barangay_id)}}</td>
							<td>

								<div class="btn-group">
									  <button class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split py-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
									    <i class="fas fa-cog">&nbsp;</i>
									  </button>
								    <div class="dropdown-menu" style="font-size:12px;">
									    <a class="dropdown-item" @click="toggleViewBeneficiaryDetails(beneficiary.beneficiary_id)"><i class="fas fa-eye">&nbsp;</i> View</a>
									    <a class="dropdown-item" @click="toggleUpdateBeneficiary(beneficiary.beneficiary_id)"><i class="fas fa-edit">&nbsp;</i> Edit</a>
									    <a class="dropdown-item" @click="toggleActivateBeneficiary(beneficiary.beneficiary_id, beneficiary.beneficiary_type_id, beneficiary.voters_id)" v-if="beneficiary.status == 'Not Active'"><i class="fas fa-plus-circle">&nbsp;</i> Activate</a>
									    <a class="dropdown-item" @click="toggleDeactivateBeneficiary(beneficiary.beneficiary_id)" v-if="beneficiary.status == 'Active'"><i class="fas fa-plus-circle">&nbsp;</i> Deactivate</a>
									</div>
								</div>
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
		<div v-if="add_beneficiary_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Add New Beneficiary
					<a @click="toggleAddNewBeneficiary" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>
			<div class="card px-3 pb-4 mt-4 shadow-nohover">
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
					    	<label>Middle name (Optional)</label>
					       <input type="text" v-model="middle_name" :class="{'is-invalid' : middle_name_error}"  class="form-control form-control-sm" placeholder="Enter Middle name">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>

					    <div class="form-group col-md-3">
					    	<label>Phone no</label>
					       <input @keypress="contactNoValidationKeypress($event, $event.target.value)" type="text" v-model="contact_no" :class="{'is-invalid' : contact_no_error}" class="form-control form-control-sm" placeholder="Enter Contact no.">
					       <div class="invalid-feedback">{{contact_no_description}}</div>
					    </div>

					</div>

					<div class="form-row mt-2 px-3">
						<div class="form-group col-md-3">
					    	<label>Birth Month</label>
					    	<select v-model="birth_month" :class="{'is-invalid' : birth_month_error}" class="form-control form-control-sm">
					       		<option value="" disabled selected>Select Month</option>
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

						<div class="form-group col-md-3">
					    	<label>Birth Day</label>
					    	<input type="text" @keypress="birthDayValidationKeypress($event, $event.target.value)" v-model="birth_day" :class="{'is-invalid' : birth_day_error}"  class="form-control form-control-sm" placeholder="Day">
					       <div class="invalid-feedback">{{birth_day_description}}</div>
					    </div>

					    <div class="form-group col-md-3">
					    	<label>Birth Year</label>
					    	<input type="text" @keypress="birthYearValidationKeypress($event, $event.target.value)" v-model="birth_year" :class="{'is-invalid' : birth_year_error}"  class="form-control form-control-sm" placeholder="Year">
					       <div class="invalid-feedback">{{birth_year_description}}</div>
					    </div>

					    <div class="form-group col-md-3">
					    	<label>Email Address</label>
					    	<input type="text" @keypress="emailAddressvalidation($event)" v-model="email_address" :class="{'is-invalid' : email_address_error}" id="email_address" class="form-control form-control-sm" placeholder="Enter Email address">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>

					</div>

					<div class="form-row mt-2 px-3">
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
					    	<label>Street</label>
					       <input type="text" v-model="street" :class="{'is-invalid' : street_error}" class="form-control form-control-sm" placeholder="Enter Street">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>

					    <div class="form-group col-md-3">
					       <label>House No.</label>
					       <input type="text" v-model="house_no" :class="{'is-invalid' : house_no_error}" class="form-control form-control-sm" placeholder="Enter House No.">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>
					    
					</div>

					<div class="form-row mt-2 px-3">
						<div class="form-group col-md-6">
					    	<label>Subdivision (Optional)</label>
					       <input type="text" v-model="subdivision" :class="{'is-invalid' : subdivision_error}" class="form-control form-control-sm" placeholder="Enter Subdivision">
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
					</div>

					<div class="form-row mt-2 px-3">
					    <div class="form-group col-md-3">
					    	<label>Religion</label>
					        <input type="text" v-model="religion" :class="{'is-invalid' : religion_error}" class="form-control form-control-sm" placeholder="Enter Religion">
					        <div class="invalid-feedback">This field is required!</div>
					    </div>

					    <div class="form-group col-md-3">
					    	<label>Civil Status</label>
					       	<select v-model="civil_status" :class="{'is-invalid' : civil_status_error}" class="form-control form-control-sm">
					       		<option value="" disabled selected>Select Civil Status</option>
					       		<option v-for="civil in civil_statuses">{{civil.description}}</option>
					       	</select>
					       	<div class="invalid-feedback">This field is required!</div>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Barangay</label>
					       	<select v-model="barangay" :class="{'is-invalid' : barangay_error}" class="form-control form-control-sm">
					       		<option value="" disabled selected>Select Barangay</option>
					       		<option v-for="barangay in barangays" v-show="barangay.barangay_name != 'City Hall'">{{barangay.barangay_name}}</option>
					       	</select>
					       	<div class="invalid-feedback">This field is required!</div>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Voter's Id</label>
					        <input type="text" v-model="voters_id" :class="{'is-invalid' : voters_id_error}" class="form-control form-control-sm" placeholder="Enter voter's id">
					        <div class="invalid-feedback">This field is required!</div>
					    </div>
					</div>
				</div>
				<div class="mt-3 float-right">
					<!--  -->
					<button @click="saveBeneficiary" class="btn btn-sm text-light bg-primary font-weight-bold float-right"><i class="far fa-save">&nbsp;</i> Save Beneficiary</button>
				</div>
			</div>
		</div>

		<div v-if="update_beneficiary_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Update Beneficiary
					<a @click="toggleUpdateBeneficiary('')" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>
			<div class="card px-3 pb-4 mt-4 shadow-nohover">
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
					    	<label>Middle name (Optional)</label>
					       <input type="text" v-model="middle_name" :class="{'is-invalid' : middle_name_error}"  class="form-control form-control-sm" placeholder="Enter Middle name">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>

					    <div class="form-group col-md-3">
					    	<label>Contact no</label>
					       <input @keypress="contactNoValidationKeypress($event, $event.target.value)" type="text" v-model="contact_no" :class="{'is-invalid' : contact_no_error}" class="form-control form-control-sm" placeholder="Enter Contact no.">
					       <div class="invalid-feedback">{{contact_no_description}}</div>
					    </div>

					</div>

					<div class="form-row mt-2 px-3">
						<div class="form-group col-md-3">
					    	<label>Birth Month</label>
					    	<select v-model="birth_month" :class="{'is-invalid' : birth_month_error}" class="form-control form-control-sm">
					       		<option value="" disabled selected>Select Month</option>
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

						<div class="form-group col-md-3">
					    	<label>Birth Day</label>
					    	<input type="text" @keypress="birthDayValidationKeypress($event, $event.target.value)" v-model="birth_day" :class="{'is-invalid' : birth_day_error}"  class="form-control form-control-sm" placeholder="Day">
					       <div class="invalid-feedback">{{birth_day_description}}</div>
					    </div>

					    <div class="form-group col-md-3">
					    	<label>Birth Year</label>
					    	<input type="text" @keypress="birthYearValidationKeypress($event, $event.target.value)" v-model="birth_year" :class="{'is-invalid' : birth_year_error}"  class="form-control form-control-sm" placeholder="Year">
					       <div class="invalid-feedback">{{birth_year_description}}</div>
					    </div>

					    <div class="form-group col-md-3">
					    	<label>Email Address</label>
					    	<input type="text" @keypress="emailAddressvalidation($event)" v-model="email_address" :class="{'is-invalid' : email_address_error}" id="email_address" class="form-control form-control-sm" placeholder="Enter Email address">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>

					</div>

					<div class="form-row mt-2 px-3">
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
					    	<label>Street</label>
					       <input type="text" v-model="street" :class="{'is-invalid' : street_error}" class="form-control form-control-sm" placeholder="Enter Street">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>

					    <div class="form-group col-md-3">
					       <label>House No.</label>
					       <input type="text" v-model="house_no" :class="{'is-invalid' : house_no_error}" class="form-control form-control-sm" placeholder="Enter House No.">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>
					    
					</div>

					<div class="form-row mt-2 px-3">
						<div class="form-group col-md-6">
					    	<label>Subdivision (Optional)</label>
					       <input type="text" v-model="subdivision" :class="{'is-invalid' : subdivision_error}" class="form-control form-control-sm" placeholder="Enter Subdivision">
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
					</div>

					<div class="form-row mt-2 px-3">
					    <div class="form-group col-md-3">
					    	<label>Religion</label>
					        <input type="text" v-model="religion" :class="{'is-invalid' : religion_error}" class="form-control form-control-sm" placeholder="Enter Religion">
					        <div class="invalid-feedback">This field is required!</div>
					    </div>

					    <div class="form-group col-md-3">
					    	<label>Civil Status</label>
					       	<select v-model="civil_status" :class="{'is-invalid' : civil_status_error}" class="form-control form-control-sm">
					       		<option value="" disabled selected>Select Civil Status</option>
					       		<option v-for="civil in civil_statuses">{{civil.description}}</option>
					       	</select>
					       	<div class="invalid-feedback">This field is required!</div>
					    </div>

					    <div class="form-group col-md-3">
					    	<label>Beneficiary Type</label>
					    	<select v-model="beneficiary_type" :class="{'is-invalid' : beneficiary_type_error}" class="form-control form-control-sm">
				       			<option value="" disabled selected>Select beneficiary type</option>
				       			<option v-for="type in beneficiary_types" v-if="type.description != 'none'">{{type.description}}</option>
				       		</select>
				       		<div class="invalid-feedback">This field is required!</div>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Voter's Id</label>
					        <input type="text" v-model="voters_id" :class="{'is-invalid' : voters_id_error}" class="form-control form-control-sm" placeholder="Enter voter's id">
					        <div class="invalid-feedback">This field is required!</div>
					    </div>
					</div>
				</div>
				<div class="mt-3 float-right">
					<!--  -->
					<button @click="saveUpdateBeneficiary" class="btn btn-sm text-light bg-primary font-weight-bold float-right"><i class="far fa-save">&nbsp;</i> Update Beneficiary</button>
				</div>
			</div>
		</div>

		<div v-if="view_beneficiary_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>View 4P's Beneficiary
					<a @click="toggleViewBeneficiaryDetails('')" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
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
					    	<label><b>Contact no :</b> {{contact_no}}</label>
					    </div>
					   
					</div>

					<div class="form-row mt-2 px-3">
						 <div class="form-group col-md-3">
					    	<label><b>Birth Date :</b> {{birth_date}}</label>
					       
					    </div>

					     <div class="form-group col-md-3">
					    	<label><b>Email Address :</b> {{email_address + email_extension}}</label>
					    </div>

						<div class="form-group col-md-3">
					    	<label><b>Sex :</b> {{sex}}</label>	
					    </div>
					   	
					   	<div class=" form-group col-md-3">
					    	<label><b>Address :</b> {{address}}</label>
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
					    	<label><b>Religion :</b> {{religion}}</label>
					    </div>

					    <div class="form-group col-md-3">
					    	<label><b>Civil Status :</b> {{civil_status}}</label>
					    </div>
					    
					</div>

					<div class="form-row mt-2 px-3">

						<div class="form-group col-md-3">
					    	<label><b>Status :</b> {{status}}</label>
					    </div>

						<div class="form-group col-md-3">
					    	<label><b>Beneficiary Type :</b> {{beneficiary_type}}</label>
					    </div>

					    <div class="form-group col-md-3">
					    	<label><b>Balance :</b> {{balance}}</label>
					    </div>

						<div class="form-group col-md-3">
					    	<label><b>Barangay :</b> {{barangay}}</label>
					    </div>

					    
					</div>

					<div class="form-row mt-2 px-3">
						<div class="form-group col-md-3">
					    	<label><b>Voter's ID :</b> {{voters_id}}</label>
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
							<option :value="beneficiary_dependents.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>
				</div>
				<table class="table table-hover table-bordered text-center mt-4">
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Full Name</th>
							<th>Sex</th>
							<th>Civil Status</th>
							<th>Educational Attainment</th>
							<th>Occupation</th>
							<th>Status</th>
							<th>Voter's ID</th>
						</tr>
					</thead>

					<tbody v-if="beneficiary_dependents.length > 0">
						<tr v-for="(beneficiary_dependent, index) in beneficiary_dependents">
							<td>{{beneficiary_dependent.fullname}}</td>
							<td>{{beneficiary_dependent.sex}}</td>
							<td>{{identifyCivilStatus(beneficiary_dependent.civil_status_id)}}</td>
							<td>{{beneficiary_dependent.educational_attainment}}</td>
							<td>{{beneficiary_dependent.occupation}}</td>
							<td>{{beneficiary_dependent.status}}</td>
							<td>{{beneficiary_dependent.voters_id}}</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No dependent to show</b></td>
						</tr>
					</tbody>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{startIndex + 1}} to {{endIndex>this.beneficiary_dependents.length? this.beneficiary_dependents.length :endIndex}} of {{beneficiary_dependents.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.beneficiary_dependents.length / this.show_entries) > 3 ? 3 : Math.ceil(this.beneficiary_dependents.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>

	    <div class="modal fade" id="myModal" data-keyboard="false" data-backdrop="static"> <!-- start  modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			        	<h4 class="modal-title">Activate beneficiary</h4>
			        	<button @click="closeActivateBeneficiaryModal" type="button" class="btn closing-modal"><i class="fas fa-times"></i></button>
			        </div>
		        
			        <div class="modal-body" id="modal-less-input">
			        	<div class="form-group">
							<div class="form-group col-lg-12">
								<label>Beneficiary Type</label>
					       		<select v-model="beneficiary_type" :class="{'is-invalid' : beneficiary_type_error}" class="form-control form-control-sm">
					       			<option value="" disabled selected>Select beneficiary type</option>
					       			<option v-for="type in beneficiary_types" v-if="type.description != 'none'">{{type.description}}</option>
					       		</select>
					       		<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>
					</div>					
					<div class="modal-footer">
						<div class="col-lg-12">
							<button @click="activateBeneficiary" class="btn btn-success float-right btn-sm ml-2">Confirm</button>
						</div>
					</div>
	      		</div>
	    	</div>
	 	</div> <!-- end  modal -->

	 	<div class="modal fade" id="myModal1" data-keyboard="false" data-backdrop="static"> <!-- start deactivate modal -->
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
							<button @click="deactivateBeneficiary" class="btn btn-danger float-right btn-sm ml-2">Yes</button>
						</div>
					</div>
	      		</div>
	    	</div>
	 	</div> <!-- end deactivate modal -->

	 	<div class="modal fade" id="myModal2" data-keyboard="false" data-backdrop="static"> <!-- start deactivate modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			        	<h4 class="modal-title">Activate Beneficiary</h4>
			        	<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>
		        
			        <div class="modal-body" id="modal-less-input">
			        	<div class="form-group">
							<div class="col-lg-12">
								<b>Do you want to Activate this beneficiary?</b> 
							</div>
						</div>
					</div>					
					<div class="modal-footer">
						<div class="col-lg-12">
							<button @click="activateBeneficiary" class="btn btn-success float-right btn-sm ml-2">Yes</button>
						</div>
					</div>
	      		</div>
	    	</div>
	 	</div> <!-- end deactivate modal -->
	</div>
</div>


<?php include(SHARED_PATH . "/city_hall/registration_staff/beneficiary/beneficiary_footer.php"); ?>