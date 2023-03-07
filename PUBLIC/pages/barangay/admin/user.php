 <?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = ' User'; ?>
<?php $barangay_name = 'Barangay ' . $_SESSION['barangay_name'] ?>
<?php include(SHARED_PATH . '/barangay/admin/user/user_header.php'); ?>

<div id="vue-user" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="user_list">
			<div class="card px-3 pb-1 pt-3">
				<h4> List of User {{ "(" + users.length + ")" }}</h4>
			</div>

			<div class="card px-3 mt-4">
	 			<div class="float-left mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>

					<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option :value="users.length">All</option>
					</select>

					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<input @input="searchUser" type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_user" placeholder="Search" arial-label="Search" v-if="filter == 'name' || filter == 'username'">

					<select @change="searchUser" v-model="search_user" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;" v-if="filter == 'status'">
						<option value="" disabled selected>Select status</option>
						<option value="">All</option>
						<option value="1">Active</option>
						<option value="0">Not Active</option>
					</select>

					<select v-model="filter" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option value="username">Username</option>
						<option value="name">Name</option>
						<option value="status">Status</option>
					</select>
					<label class="mr-2 float-right mt-1">Filter: </label>
				</div>

				<table class="table table-hover table-bordered text-center mt-2">
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Username</th>
							<th>Firstname</th>
							<th>Lastname</th>
							<th>Status</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="users.length > 0">
						<tr v-for="(user, index) in users" v-if="index >= startIndex && index < endIndex">
							<td>{{user.username}}</td>
							<td>{{user.first_name}}</td>
							<td>{{user.last_name}}</td>
							<td v-if="user.is_employed == 1"><h6 class="text-light bg-success rounded">Active</h6></td>
							<td v-if="user.is_employed == 0"><h6 class="text-light bg-warning rounded">Inactive</h6></td>
							<td>
								<div class="btn-group">
									  <button class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split py-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
									    <i class="fas fa-cog">&nbsp;</i>
									  </button>
								    <div class="dropdown-menu" style="font-size:13px;">
									    <a class="dropdown-item"@click="toggleViewUser(user.user_id)"><i class="fas fa-eye">&nbsp;</i> View</a>
									    <a class="dropdown-item" @click="toggleUpdateUser(user.user_id)"><i class="fas fa-edit">&nbsp;</i> Edit</a>
									    <a class="dropdown-item" @click="togggleDeactivateUser(user.user_id)" v-if="user.is_employed == 1"><i class="fas fa-minus-circle">&nbsp;</i> Deactivate</a>
									    <a class="dropdown-item" @click="togggleActivateUser(user.user_id)" v-if="user.is_employed == 0" :title="activate_user"><i class="fas fa-plus-circle">&nbsp;</i> Activate</a>
									    <a class="dropdown-item" @click="toggleResetAccount(user.user_id)"><i class="fas fa-undo">&nbsp;</i> Reset</a>
									</div>
								</div>
<!-- 
								<button @click="toggleViewUser(user.user_id)" :title="view_User" class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></button>

								<button @click="toggleUpdateUser(user.user_id)" :title="update_User" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></button>


								<button @click="togggleDeactivateUser(user.user_id)" class="btn btn-outline-danger btn-sm" v-if="user.is_employed == 1" :title="deactivate_User" class="small-box-footer"><i class="fas fa-minus-circle"></i></button>

								<button @click="togggleActivateUser(user.user_id)" class="btn btn-outline-success btn-sm" v-if="user.is_employed == 0" :title="activate_user"><i class="fas fa-plus-circle"></i></button>

								<button @click="toggleResetAccount(user.user_id)" class="btn btn-outline-success btn-sm" :title="reset_account"><i class="fas fa-undo"></i></button> -->

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
					<p class="float-left">Showing {{this.users.length ? startIndex + 1 : 0}} to {{endIndex>this.users.length? this.users.length :endIndex}} of {{users.length}} entries</p>

					<nav aria-label="Page navigation example">
						<ul class="pagination justify-content-end">
					    	<li class="page-item">
					    		<a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    	</li>
					    	<li class="page-item">
					    		<a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.users.length / this.show_entries) > 3 ? 3 : Math.ceil(this.users.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a>
					    	</li>
					    	<li class="page-item">
					      		<a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextUser()">Next</a>
					    	</li>
					 	</ul>
					</nav>
				</div>
			</div>
		</div>

		<div v-if="view_user">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>View user
					<a @click="toggleViewUser" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 pb-5 mt-4 shadow-nohover">
				<h5 class="mt-4">User Details</h5>
				<div class="mt-3 shadow-sm rounded bg-light pt-3 pb-3">
					<div class="form-row mt-2 px-3">
						<div class="form-group col-md-3">
					    	<label>Username :</label>
					    	<p class="font-weight-bold">{{username}}</p>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>First name :</label>
					    	<p class="font-weight-bold">{{first_name}}</p>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Last name :</label>
					    	<p class="font-weight-bold">{{last_name}}</p>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Middle name :</label>
					    	<p class="font-weight-bold">{{middle_name}}</p>
					    </div>
					</div>
					<div class="form-row mt-2 px-3">
					    <div class="form-group col-md-3">
					    	<label>Birth Date :</label>
					    	<p class="font-weight-bold">{{birth_month + "-" + birth_day + "-" + birth_year}}</p>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Sex :</label>
					    	<p class="font-weight-bold">{{sex}}</p>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Contact no. :</label>
					    	<p class="font-weight-bold">{{contact_no}}</p>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Email Address :</label>
					    	<p class="font-weight-bold">{{email_address + email_extension}}</p>
					    </div> 
					</div>

					<div class="form-row mt-2 px-3">
					    <div class="form-group col-md-6">
					    	<label>Address :</label>
					    	<p class="font-weight-bold">{{street + " " + house_no + " " + subdivision}}</p>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>User Type :</label>
					    	<p class="font-weight-bold">{{user_type}}</p>
					    </div>
					</div>
				</div>
			</div>
		</div>

		<div v-if="update_user">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Update user
					<a @click="toggleUpdateUser" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 pb-5 mt-4 shadow-nohover">
				<h5 class="mt-4">User Details</h5>
				<div class="mt-3 shadow-sm rounded bg-light pt-3 pb-3">
					<div class="form-row mt-2 px-3">
						<div class="form-group col-md-3">
					    	<label>Username</label>
					    	<input type="text" v-model="username" :class="{'is-invalid' : username_error}" class="form-control form-control-sm" placeholder="Enter Username">
					    	<div class="invalid-feedback">This field is required!</div>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>New password</label>
					    	<input type="text" v-model="new_password" class="form-control form-control-sm" placeholder="Enter new password">
					    	<div class="invalid-feedback">This field is required!</div>
					    </div>
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
					</div>
					<div class="form-row mt-2 px-3">
					    <div class="form-group col-md-3">
					    	<label>Middle name</label>
					       <input type="text" v-model="middle_name" :class="{'is-invalid' : middle_name_error}"  class="form-control form-control-sm" placeholder="Enter Middle name">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Birth Month</label>
					    	<select v-model="birth_month" :class="{'is-invalid' : birth_month_error}" class="form-control form-control-sm">
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
					    <div class="form-group col-md-3">
					    	<label>Birth Day</label>
					    	<input @keypress="birthDayValidationKeypress($event, $event.target.value)" type="number" v-model="birth_day" :class="{'is-invalid' : birth_day_error}" class="form-control form-control-sm" placeholder="Day">
					       <div class="invalid-feedback">{{birth_day_description}}</div>
					    </div>
					    <div class="form-group col-md-3">
					    	<label>Birth Year</label>
					    	<input @keypress="birthYearValidationKeypress($event, $event.target.value)" type="number" v-model="birth_year" :class="{'is-invalid' : birth_year_error}" class="form-control form-control-sm" placeholder="Year">
					       <div class="invalid-feedback">{{birth_year_description}}</div>
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
					    	<label>User Type</label>
					       	<select v-model="user_type" :class="{'is-invalid' : user_type_error}" class="form-control form-control-sm">
					       		<option value="" disabled selected>Select User type</option>
					       		<option v-for="user_type in user_types">{{user_type.description}}</option>
					       	</select>
					       	<div class="invalid-feedback">This field is required!</div>
					    </div>
					</div>


					<div class="float-right">
						<!--  -->
						<button @click="saveUpdateUser" class="btn btn-sm text-light bg-primary font-weight-bold float-right"><i class="far fa-save">&nbsp;</i> Update user</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="myModal2" data-keyboard="false" data-backdrop="static"> <!-- start deactivate modal -->
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
							<button @click="deactivateUser" class="btn btn-danger float-right btn-sm ml-2">Yes</button>
						</div>
					</div>
	      		</div>
	    	</div>
	 	</div> <!-- end deactivate modal -->

	 	<div class="modal fade" id="myModal3" data-keyboard="false" data-backdrop="static"> <!-- start activate modal -->
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
							<button @click="activateUser" class="btn btn-success float-right btn-sm ml-2">Yes</button>
						</div>
					</div>
	      		</div>
	    	</div>
	 	</div> <!-- end activate modal -->

	 	<div class="modal fade" id="myModal5" data-keyboard="false" data-backdrop="static"> <!-- start reset account modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			        	<h4 class="modal-title">Reset Account</h4>
			        	<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>
		        
			        <div class="modal-body" id="modal-less-input">
			        	<div class="form-group">
							<div class="col-lg-12">
								<b>Reset account of this user?</b> 
							</div>
						</div>
					</div>				
					<div class="modal-footer">
						<div class="col-lg-12">
							<button @click="resetAccount" class="btn btn-success float-right btn-sm ml-2">Confirm</button>
						</div>
					</div>
	      		</div>
	    	</div>
	 	</div> <!-- end reset account modal -->
	</div>
</div>


<?php include(SHARED_PATH . '/barangay/admin/user/user_footer.php'); ?>