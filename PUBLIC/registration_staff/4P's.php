<?php require_once('../../private/initialize.php'); ?> 
<?php $page_title = 'Dashboard'; ?>
<?php include(SHARED_PATH . "/registration_staff/4P's_header.php"); ?>

<div id="vue-4Ps" class="mt-4" v-cloak> 
	<div class="container">
		<div v-if="beneficiary_info">
			<div class="card px-3 pb-1 pt-3">
				<h4> List of 4P's Beneficiary
					<a @click="toggle4PsBeneficiaryInfo" class="btn bg-success text-light btn-sm font-weight-bold ml-2"><i class="fas fa-plus"></i></a>
				</h4>
			</div>

			<div class="card px-3 mt-4">
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
								<button @click="toggle4PsDependentInfo" class="btn btn-sm btn-outline-warning"><i class="fas fa-eye"></i></button>
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

		<div v-if="beneficiary_info == false && dependent_info == false">
			<div class="card px-3 pb-1 pt-3">
				<h4>Add New Beneficiary
					<a @click="toggle4PsBeneficiaryInfo" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 pb-3 mt-4">
				<div class="nav nav-pills mt-4">
				    <button class="nav-link active btn btn-sm text-light bg-info font-weight-bold float-left" href="#profile" role="tab" data-toggle="tab">
				    	<span class="number text-light">1</span> 
				    	<span class="title text-light font-weight-bold pr-2">Beneficiary Details </span>
				    </button>

				    <button class="nav-link btn btn-sm text-light bg-info font-weight-bold float-left ml-2" href="#buzz" role="tab" data-toggle="tab">
				    	<span class="number text-light">2</span> 
				    	<span class="title text-light font-weight-bold pr-2">Dependent Details </span>
				    </button>

				    <button class="nav-link btn btn-sm text-light bg-info font-weight-bold float-left ml-2" href="#references" role="tab" data-toggle="tab">
				    	<span class="number text-light">3</span> 
				    	<span class="title text-light font-weight-bold pr-2">Complete Details </span>
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
							    	<label>Religion</label>
							        <input type="text" v-model="religion" class="form-control form-control-sm" placeholder="Enter Religion">
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
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
							    	<label>Street</label>
							       <input type="text" v-model="street" class="form-control form-control-sm" placeholder="Enter Street">
							    </div>
							    <div class="form-group col-md-3">
							       <label>House No.</label>
							       <input type="text" v-model="house_no" class="form-control form-control-sm" placeholder="Enter House No.">
							    </div>
							    
							</div>

							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-6">
							    	<label>Subdivision</label>
							       <input type="text" v-model="subdivision" class="form-control form-control-sm" placeholder="Enter Subdivision">
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Civil Status</label>
							       	<select v-model="beneficiary_civil_status" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Civil Status</option>
							       		<option v-for="civil in civil_status">{{civil.description}}</option>
							       	</select>
							    </div>
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
							<button @click="toggleAddDependent" class="btn btn-sm text-light bg-info font-weight-bold"> Next</button>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane fade" id="buzz">
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
							    	<label>Religion</label>
							        <input type="text" v-model="religion" class="form-control form-control-sm" placeholder="Enter Religion">
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
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
							    	<label>Street</label>
							       <input type="text" v-model="street" class="form-control form-control-sm" placeholder="Enter Street">
							    </div>
							    <div class="form-group col-md-3">
							       <label>House No.</label>
							       <input type="text" v-model="house_no" class="form-control form-control-sm" placeholder="Enter House No.">
							    </div>
							    
							</div>

							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-6">
							    	<label>Subdivision</label>
							       <input type="text" v-model="subdivision" class="form-control form-control-sm" placeholder="Enter Subdivision">
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Civil Status</label>
							       	<select v-model="beneficiary_civil_status" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Civil Status</option>
							       		<option v-for="civil in civil_status">{{civil.description}}</option>
							       	</select>
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Barangay</label>
							       	<select v-model="barangay" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Barangay</option>
							       		<option v-for="barangay in barangays" v-show="barangay.barangay_name != 'City Hall'">{{barangay.barangay_name}}</option>
							       	</select>
							    </div>
							</div>
						</div>
						
						<div class="mt-3">
							<button class="btn btn-sm text-light bg-info font-weight-bold float-right"> Finish</button>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane fade" id="references">
						<div class="mt-3 shadow-sm rounded bg-light pt-3 pb-3">
							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-3">
							    	<label>First name :</label>
							       
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Last name :</label>
							       
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Middle name :</label>
							       
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Birth Date :</label>
							       
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
								<div class="form-group col-md-3">
							    	<label>Sex :</label>
							       	
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Contact no :</label>
							       
							    </div>
							     <div class="form-group col-md-3">
							    	<label>Email Address :</label>
							       
							    </div> 
							    <div class="form-group col-md-3">
							    	<label>Religion :</label>
							        
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
								<div class="form-group col-md-3">
							    	<label>Educational Attainment :</label>
							       	
							    </div>
							   
							    <div class="form-group col-md-3">
							    	<label>Occupation :</label>
							       	
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Street :</label>
							       
							    </div>
							    <div class="form-group col-md-3">
							       <label>House no. :</label>
							       
							    </div>
							    
							</div>

							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-6">
							    	<label>Subdivision :</label>
							   
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Civil Status :</label>
							       	
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Barangay :</label>
							       	
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
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
												<button class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></button>
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
			</div>   
		</div>

		<div v-if="dependent_info">
			<div class="card px-3 pb-1 pt-3">
				<h4>Beneficiary Information
					<a @click="toggle4PsDependentInfo" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 pb-3 mt-4">
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
							    	<label>Religion</label>
							        <input type="text" v-model="religion" class="form-control form-control-sm" placeholder="Enter Religion">
							    </div>
							</div>

							<div class="form-row mt-2 px-3">
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
							    	<label>Street</label>
							       <input type="text" v-model="street" class="form-control form-control-sm" placeholder="Enter Street">
							    </div>
							    <div class="form-group col-md-3">
							       <label>House No.</label>
							       <input type="text" v-model="house_no" class="form-control form-control-sm" placeholder="Enter House No.">
							    </div>
							    
							</div>

							<div class="form-row mt-2 px-3">
							    <div class="form-group col-md-6">
							    	<label>Subdivision</label>
							       <input type="text" v-model="subdivision" class="form-control form-control-sm" placeholder="Enter Subdivision">
							    </div>
							    <div class="form-group col-md-3">
							    	<label>Civil Status</label>
							       	<select v-model="beneficiary_civil_status" class="form-control form-control-sm">
							       		<option value="" disabled selected>Select Civil Status</option>
							       		<option v-for="civil in civil_status">{{civil.description}}</option>
							       	</select>
							    </div>
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
							<button @click="toggleAddDependent" class="btn btn-sm text-light bg-info font-weight-bold"> Update</button>
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
	</div>
</div>

<?php include(SHARED_PATH . "/registration_staff/4P's_footer.php"); ?>
