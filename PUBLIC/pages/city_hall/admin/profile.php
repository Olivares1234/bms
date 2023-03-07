<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Profile'; ?>
<?php include(SHARED_PATH . '/city_hall/admin/profile/profile_header.php'); ?>

<div class="mt-4">
	<div class="container">
		<div class="card px-3 pb-1 pt-3 shadow-nohover">
			<h4>Update Account Details</h4>
		</div>
			 
		<div class="card px-3 pb-5 mt-4" style="width: 35rem;">
			<h5 class="mt-4">User Details
				<button type="submit" class="btn btn-sm btn-primary font-weight-bold float-right" data-toggle="modal" data-target="#myModal"><i class="fas fa-edit">&nbsp;</i> Change Password</button>
			</h5>
	        <section class="content mt-2 shadow-sm rounded bg-light pt-3">
	            <div class="row">
		      		<div class="col-md-12">
		          		<div class="box box-light" id="box-profile-change">
		            		<div class="box-body ml-2">

					  			<div class="form-group">
		                			<label for="username" class="font-weight-bold">Username :</label>
		                			<div class="input-group col-md-9">
		                  				
		                			</div>
		              			</div>

		              			<div class="form-group">
		                			<label for="fullname" class="font-weight-bold">First name :</label>
		                			<div class="input-group col-md-9">
		                  				
		                			</div>
		              			</div>

		              			<div class="form-group">
		                			<label for="fullname" class="font-weight-bold">Last name :</label>
		                			<div class="input-group col-md-9">
		                  				
		                			</div>
		              			</div>

		              			<div class="form-group">
		                			<label for="contact_no" class="font-weight-bold">Phone No. :</label>
		                			<div class="input-group col-md-9">
		                  				
		                			</div>
		              			</div>

		              			<div class="form-group float-right mt-1">
		                			<div class="input-group">
		                  				
		               				 </div>
		              			</div>
							</div>
						</div>
		            </div>
		        </div>
		    </section>
		</div>
		<div class="modal fade" id="myModal" data-keyboard="false" data-backdrop="static"> <!-- start reset account modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			        	<h4 class="modal-title">Change Password</h4>
			        	<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>
		        
			        <div class="modal-body" id="modal-less-input-change">
			        	<label for="password">New Password :</label>
						<div class="input-group form-group">
							<input type="password" class="form-control" placeholder="Enter New Password">
						</div>
						
						<label for="password">Confirm New Password :</label>
						<div class="input-group form-group">
							<input type="confirm_password" class="form-control" placeholder="Enter Confirm Password">
						</div>
					</div>				
					<div class="modal-footer">
						<div class="col-lg-12">
							<button @click="resetAccount" class="btn btn-success float-right btn-sm ml-2"><i class="far fa-save">&nbsp;</i> Save</button>
						</div>
					</div>
	      		</div>
	    	</div>
	 	</div> <!-- end reset account modal -->
	</div>
</div>
<?php include(SHARED_PATH . '/city_hall/admin/profile/profile_footer.php'); ?>

