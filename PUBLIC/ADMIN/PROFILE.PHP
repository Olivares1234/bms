<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = 'Category'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>
<div id="vue-app" class="mt-4" v-cloak>
	<div class="container">
		<h3> Update Account Details  </h3>
		<div class="mt-4">
			 
        <section class="content">
            <div class="row">
	      		<div class="col-md-12">
	          		<div class="box box-light" id="box-profile-change">
	            		<div class="box-body ml-2">
	              
	              		<form method="post">

	              			<div class="form-group">
	                			<label for="fullname" class="font-weight-bold">Fullname</label>
	                			<div class="input-group col-md-12">
	                  				<input type="text" class="form-control" id="fullname" name="name" placeholder="Enter Fullname" required>
	                			</div>
	              			</div>

				  			<div class="form-group">
	                			<label for="username" class="font-weight-bold">Username</label>
	                			<div class="input-group col-md-12">
	                  				<input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
	                			</div>
	              			</div>
				  			
				  			<div class="form-group">
	                			<label for="password" class="font-weight-bold">Change Password</label>
	                			<div class="input-group col-md-12">
	                  				<input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password">
	                			</div>
	              			</div>

				  			<div class="form-group">
	                			<label for="confirm_password" class="font-weight-bold">Confirm New Password</label>
	                			<div class="input-group col-md-12">
	                  				<input type="confirm_password" class="form-control" id="confirm_password" name="newpassword" placeholder="Enter Confirm Password">
	                			</div>
	              			</div>

	              			<div class="form-group float-right">
	                			<div class="input-group">
	                  				<button type="submit" class = "btn btn-primary"><i class="far fa-save">&nbsp;</i> Save</button>
					  				<button type="button" class="btn btn-danger ml-2"><i class="fas fa-window-close">&nbsp;</i> Clear</button>
	               				 </div>
	              			</div>
						</form>	
						</div>
					</div>
	            </div>
	        </div>
	    </section>
	</div>
</div>
<?php include(SHARED_PATH . '/footer.php'); ?>