<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = 'User'; ?>
<?php include(SHARED_PATH . '/city_hall_header.php'); ?>
<div id="vue-city-hall" class="mt-4" v-cloak>
	<div class="container">
		<div class="card px-3 pb-1 pt-3">          
	    	<h4> List of User {{ "(" + countActiveUser() + ")" }}
	 			<a @click="addUserButton" class="btn bg-success font-weight-bold text-light btn-sm ml-2" :title="add_User">
	 				<i class="fas fa-plus"></i>
	 			</a>
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
					<option :value="active_users.length">All</option>
				</select>
				<label class="d-inline-block ml-1" for="show_entries">entries</label>

				<input type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_user" @input="searchUser" placeholder="Search" arial-label="Search">
				<select class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
					<option value="" disabled selected>Select Field name</option>
					<option></option>
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
						<th>Branch</th>
						<th colspan="2">Actions</th>
					</tr>
				</thead>
				<tbody v-if="countActiveUser() > 0">
					<tr v-for="(user, index) in active_users" v-if="index >= startIndex && index < endIndex">
						<td>{{user.username}}</td>
						<td>{{user.first_name}}</td>
						<td>{{user.last_name}}</td>
						<td v-if="user.is_employed == 1"><h6 class="text-light bg-success rounded">Active</h6></td>
						<td v-if="user.is_employed == 0"><h6 class="text-light bg-warning rounded">Inactive</h6></td>
						<td>{{user.barangay_name}}</td>
						<td>
							<button @click="updateUserButton(user.user_id,user.first_name,user.last_name,user.middle_name,user.contact_no,user.birth_date,user.email_address,user.sex,user.address,user.is_employed,user.barangay_name,user.username,user.password,user.user_type_id)" :title="update_User" class="btn btn-outline-primary btn-sm" href="#add" data-toggle="modal" data-target="#myModal1"><i class="fas fa-edit"></i></button>

							<button @click="deactivateUserButton(user.user_id,user.first_name,user.last_name,user.middle_name,user.contact_no,user.birth_date,user.email_address,user.sex,user.address,user.is_employed,user.barangay_name,user.username,user.password,user.user_type_id)" class="btn btn-outline-success btn-sm" v-if="user.is_employed == 1" :title="deactivate_User" href="#add" data-toggle="modal" data-target="#myModal2" class="small-box-footer"><i class="fas fa-minus-circle"></i></button>

							<button @click="updateUserButton(user.user_id,user.first_name,user.last_name,user.middle_name,user.contact_no,user.birth_date,user.email_address,user.sex,user.address,user.is_employed,user.barangay_name,user.username,user.password,user.user_type_id)" class="btn btn-outline-success btn-sm" v-if="user.is_employed == 0" href="#add" :title="activate_user" data-toggle="modal" data-target="#myModal3"><i class="fas fa-plus-circle"></i></button>
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
				<p class="float-left">Showing {{startIndex + 1}} to {{endIndex>this.active_users.length? this.active_users.length :endIndex}} of {{active_users.length}} entries</p>

				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-end">
				    	<li class="page-item">
				    		<a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
				    	</li>
				    	<li class="page-item">
				    		<a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.active_users.length / this.show_entries) > 3 ? 3 : Math.ceil(this.active_users.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a>
				    	</li>
				    	<li class="page-item">
				      		<a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextActiveUser()">Next</a>
				    	</li>
				 	</ul>
				</nav>
			</div>

			<div class="modal" id="myModal" data-keyboard="false" data-backdrop="static"> <!-- start add modal -->
	    		<div class="modal-dialog">
	     			<div class="modal-content " style="height:auto">
		      
				        <!-- Modal Header -->
				        <div class="modal-header">
				        	<h4 class="modal-title">Add User</h4>
				        	<button type="button"@click="clearUser" class="btn closing-modal" data-dismiss="modal">
				        		<i class="fas fa-times"></i>
				        	</button>
				        </div>
		        
				        <!-- Modal body -->
				        <div class="modal-body">
				        	<div class="input-group form-group">
								<div class="col-lg-12">
									<label for="username">Username</label>
									<input type="text" class="form-control" :class="{'is-invalid' : username_error}" v-model="username" id="username" placeholder="Enter username" required> 
									<div class="invalid-feedback">This field is required!</div> 
								</div>
							</div>

							<div class="input-group form-group">
								<div class="col-lg-12">
									<label for="password">Password</label>
									<input type="password" :class="{'is-invalid' : password_error}" class="form-control" v-model="password" id="password" placeholder="Enter password" required>  
									<div class="invalid-feedback">This field is required!</div>
								</div>
							</div>

				         	<div class="input-group form-group">
								<div class="col-lg-12">
									<label for="first_name">First name</label>
									<input type="text" :class="{'is-invalid' : first_name_error}" class="form-control" v-model="first_name" @keydown="isLetter($event)" placeholder="Enter Firstname" required>  
									<div class="invalid-feedback">This field is required!</div>
								</div>
							</div>

							<div class="input-group form-group">
				            	<div class="col-lg-12">
				            		<label for="last_name">Last name</label>
				              		<input type="text" :class="{'is-invalid' : last_name_error}" class="form-control" @keydown="isLetter($event)" placeholder="Enter Lastname" v-model="last_name" required>
				              		<div class="invalid-feedback">This field is required!</div>  
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12">
				            		<label for="middle_name">Middle name</label>
				              		<input type="text" :class="{'is-invalid' : middle_name_error}" class="form-control" @keydown="isLetter($event)" placeholder="Enter Middlename" v-model="middle_name" required>
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12">
				            		<label for="contact_no">Contact no</label>
				              		<input type="text" :class="{'is-invalid' : contact_no_error}" class="form-control" @keypress="isNumberKeyWithDash($event)" placeholder="Enter Contact No." v-model="contact_no" required> 
				              		<div class="invalid-feedback">This field is required!</div> 
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12">
				            		<label for="birth_date">Birth date</label>
				              		<input type="date" :class="{'is-invalid' : birth_date_error}" class="custom-select" v-model="birth_date" >
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="form-row">
				            	<div class="col-6 ml-3">
				        			<label for="email_address">Email</label>
				              		<input type="email" :class="{'is-invalid' : email_address_error}" class="form-control" placeholder="Enter Email Address" v-model="email_address" required> 
				              		<div class="invalid-feedback">This field is required!</div> 
				            	</div>
				            	<div class="col-5 mt-4 ml-2">
				            		<select v-model="email_extension" class="custom-select" style="margin-top: 8px;">
				              			<option disabled value="" selected>@gmail.com</option>
				              			<option value="Male">@yahoo.com</option>
				              			<option value="Female">@rocketmail.com</option>
				              		</select>
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12 mt-3">
				            		<label for="sex">Sex</label>
				              		<select v-model="sex" :class="{'is-invalid' : sex_error}" class="custom-select">
				              			<option disabled value="" selected>Select Sex</option>
				              			<option value="Male">Male</option>
				              			<option value="Female">Female</option>
				              		</select>  
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="form-row">
				            	<div class="col-6 ml-3">
				        			<label for="email_address">Street</label>
				              		<input type="email" :class="{'is-invalid' : email_address_error}" class="form-control" placeholder="Enter Street" v-model="street" required> 
				              		<div class="invalid-feedback">This field is required!</div> 
				            	</div>
				            	<div class="col-5 ml-2">
				            		<label for="email_address">House no</label>
				              		<input type="email" :class="{'is-invalid' : email_address_error}" class="form-control" placeholder="Enter House No." v-model="house_no" required> 
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12 mt-3">
				            		<label for="address">Subdivision</label>
				              		<input type="text" :class="{'is-invalid' : address_error}" class="form-control" placeholder="Enter Subdivision" v-model="subdivision" required>  
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12" >
				            		<label for="barangay_name">Branch</label>
				              		<select v-model="barangay_name" :class="{'is-invalid' : barangay_name_error}" class="custom-select" >
				              			<option disabled value="" selected>Select Branch</option>
				              			<option v-for="barangay in barangays">{{barangay.barangay_name}}</option>
				              		</select>
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12">
				            		<label for="user_type_id">User type</label>
				              		<select v-model="user_type_id" :class="{'is-invalid' : user_type_id_error}" class="custom-select" >
				              			<option disabled value="" selected>Select User Type</option>
				              			<option value="1">Administrator</option>
				              			<option value="2">Pharmacist</option>
				              			<option value="3">Registration Staff</option>
				              			<option value="4">Health Worker</option>
				              		</select>
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>
				        </div>
		        
				        <!-- Modal footer -->
				        <div class="modal-footer">
				          <button type="button" @click="addUser" class="btn btn-primary btn-sm"><i class="far fa-save">&nbsp;</i> Save</button>
				        </div>
	      			</div>
	    		</div>
	 		</div> <!-- end add modal -->

		 	<div class="modal" id="myModal1" data-keyboard="false" data-backdrop="static"> <!-- start update modal -->
		    	<div class="modal-dialog">
		     		<div class="modal-content " style="height:auto">
			      
				        <!-- Modal Header -->
				        <div class="modal-header">
				          <h4 class="modal-title">Update User</h4>
				          <button  type="button" @click="clearUser" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
				        </div>
			        
				        <!-- Modal body -->
				        <div class="modal-body">
				        	<div class="form-group">
								<div class="col-lg-12">
									<input type="hidden" class="form-control" v-model="user_id" disabled required>  
								</div>
							</div>

							<div class="input-group form-group">
								<div class="col-lg-12">
									<label for="username">Username</label>
									<input type="text" class="form-control username" :class="{'is-invalid': username_error}" v-model="username" id="usernames" placeholder="Enter username" required> 
									<div class="invalid-feedback">This field is required!</div> 
								</div>
							</div>

							<div class="input-group form-group">
								<div class="col-lg-12">
									<label for="password">New Password</label>
									<input type="password" class="form-control" name="password" v-model="new_password" placeholder="Enter password">  
								</div>
							</div>

				         	<div class="input-group form-group">
								<div class="col-lg-12">
									<label for="first_name">First name</label>
									<input type="text" :class="{'is-invalid': first_name_error}" class="form-control" v-model="first_name" @keydown="isLetter($event)" placeholder="Enter Firstname" required>  
									<div class="invalid-feedback">This field is required!</div>
								</div>
							</div>

							<div class="input-group form-group">
				            	<div class="col-lg-12">
				            		<label for="last_name">Last name</label>
				              		<input type="text" :class="{'is-invalid': last_name_error}" class="form-control" @keydown="isLetter($event)" placeholder="Enter Lastname" v-model="last_name" required>
				              		<div class="invalid-feedback">This field is required!</div>  
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12">
				            		<label for="middle_name">Middle name</label>
				              		<input type="text" :class="{'is-invalid': middle_name_error}" class="form-control" @keydown="isLetter($event)" placeholder="Enter Middlename" v-model="middle_name" required>
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12">
				            		<label for="contact_no">Contact no</label>
				              		<input type="text" :class="{'is-invalid': contact_no_error}" class="form-control" @keypress="isNumberKeyWithDash($event)" placeholder="Enter Contact No." v-model="contact_no" required> 
				              		<div class="invalid-feedback">This field is required!</div> 
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12">
				            		<label for="birth_date">Birth date</label>
				              		<input type="date" :class="{'is-invalid': birth_date_error}" class="custom-select" v-model="birth_date" >
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="form-row">
				            	<div class="col-6 ml-3">
				        			<label for="email_address">Email</label>
				              		<input type="email" :class="{'is-invalid' : email_address_error}" class="form-control" placeholder="Enter Email Address" v-model="email_address" required> 
				              		<div class="invalid-feedback">This field is required!</div> 
				            	</div>
				            	<div class="col-5 mt-4 ml-2">
				            		<select v-model="email_extension" class="custom-select" style="margin-top: 8px;">
				              			<option disabled value="" selected>@gmail.com</option>
				              			<option value="Male">@yahoo.com</option>
				              			<option value="Female">@rocketmail.com</option>
				              		</select>
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12">
				            		<label for="sex">Sex</label>
				              		<select v-model="sex" :class="{'is-invalid': sex_error}" class="custom-select" >
				              			<option disabled value="" selected>Select Sex</option>
				              			<option value="Male">Male</option>
				              			<option value="Female">Female</option>
				              		</select>  
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="form-row">
				            	<div class="col-6 ml-3">
				        			<label for="email_address">Street</label>
				              		<input type="email" :class="{'is-invalid' : email_address_error}" class="form-control" placeholder="Enter Street" v-model="street" required> 
				              		<div class="invalid-feedback">This field is required!</div> 
				            	</div>
				            	<div class="col-5 ml-2">
				            		<label for="email_address">House no</label>
				              		<input type="email" :class="{'is-invalid' : email_address_error}" class="form-control" placeholder="Enter House No." v-model="house_no" required> 
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12 mt-3">
				            		<label for="address">Subdivision</label>
				              		<input type="text" :class="{'is-invalid' : address_error}" class="form-control" placeholder="Enter Subdivision" v-model="subdivision" required>  
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12">
				            		<label for="is_employed">Status</label>
				              		<select v-model="is_employed" :class="{'is-invalid': is_employed_error}" class="custom-select" >
				              			<option disabled value="" selected>Select Employed Status</option>
				              			<option value="1">Yes</option>
				              			<option value="0">No</option>
				              		</select> 
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12" >
				            		<label for="barangay_name">Branch</label>
				              		<select v-model="barangay_name" :class="{'is-invalid': barangay_name_error}" class="custom-select" >
				              			<option disabled value="" selected>Select Branch</option>
				              			<option v-for="barangay in barangays">{{barangay.barangay_name}}</option>
				              		</select>
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>

				        	<div class="input-group form-group">
				            	<div class="col-lg-12">
				            		<label for="user_type_id">User type</label>
				              		<select v-model="user_type_id" :class="{'is-invalid': user_type_id_error}" class="custom-select" >
				              			<option disabled value="" selected>Select User Type</option>
				              			<option value="1">Administrator</option>
				              			<option value="2">Pharmacist</option>
				              			<option value="3">Registration Staff</option>
				              			<option value="4">Health Worker</option>
				              		</select>
				              		<div class="invalid-feedback">This field is required!</div>
				            	</div>
				        	</div>
				        </div>
			        
				        <!-- Modal footer -->
				        <div class="modal-footer">
				          <button type="button" @click="updateUser" class="btn btn-primary btn-sm"><i class="far fa-save">&nbsp;</i> Save
				        </div>
		      		</div>
		    	</div>
		 	</div> <!-- end update modal -->

		 	<div class="modal" id="myModal2" > <!-- start deactivate modal -->
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
								<button @click="deactivateUser" class="btn btn-danger float-right btn-sm ml-2" data-dismiss="modal">Yes</button>
							</div>
						</div>
		      		</div>
		    	</div>
		 	</div> <!-- end deactivate modal -->

		 	<div class="modal" id="myModal3" > <!-- start deactivate modal -->
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
								<button @click="activateUser" class="btn btn-success float-right btn-sm ml-2" data-dismiss="modal">Yes</button>
							</div>
						</div>
		      		</div>
		    	</div>
		 	</div> <!-- end deactivate modal -->
		 </div>
	</div>
</div>

<?php include(SHARED_PATH . '/city_hall_footer.php'); ?>