<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = 'Dashboard'; ?>
<?php include(SHARED_PATH . "/registration_staff/4P's_header.php"); ?>

<div id="vue-4Ps" class="mt-4" v-cloak>
	<section class="content">
		<div class="col-md-12">
			<div class="box box-primary">
			    <div class="box-header with-border">
			        <h3 class="box-title">Dashboard</h3>
			    </div><!-- /.box-header -->
			        <div class="box-body">
			          	<div class="row">
				            <div class="col-sm-3 col-xs-4">
				                <!-- small box -->
					            <div class="small-box" id="user-box">
					                <div class="inner">
					                    <h3 class="text-light">Indigent's</h3>
					                    <p class="text-light">View</p>
					                </div>
					                <div class="icon" style="margin-top:10px">
					                    <i class="fas fa-users"></i>
					                </div>
					                    <a href="<?php echo url_for('user/index.php')?>" class="small-box-footer">
					                    <i class="fas fa-angle-double-right"></i>
					                	</a>
				                </div>
				            </div><!-- ./col -->

				            <div class="col-sm-3 col-xs-4">
				                <!-- small box -->
				           		<div class="small-box" id="pwd-box">
				                	<div class="inner">
				                    	<h3 class="text-light">4P's</h3>
				                    	<p class="text-light">View/Activate</p>
				                	</div>
				                	<div class="icon" style="margin-top:10px">
				                    	<i class="fas fa-users"></i>
				                	</div>
				                    	<a href="<?php echo url_for('user/index.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                		</a>
				                </div>
				            </div><!-- ./col -->

				            <div class="col-sm-3 col-xs-4">
				                <!-- small box -->
				           		<div class="small-box" id="senior-box">
				                	<div class="inner">
				                    	<h3 class="text-light">Senior's</h3>
				                    	<p class="text-light">View/Activate</p>
				                	</div>
				                	<div class="icon" style="margin-top:10px">
				                    	<i class="fas fa-users"></i>
				                	</div>
				                    	<a href="<?php echo url_for('user/index.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                		</a>
				                </div>
				            </div><!-- ./col -->

				            <div class="col-sm-3 col-xs-4">
				                <!-- small box -->
				           		<div class="small-box" id="medicine-box">
				                	<div class="inner">
				                    	<h3 class="text-light">PWD's</h3>
				                    	<p class="text-light">View/Activate</p>
				                	</div>
				                	<div class="icon" style="margin-top:10px">
				                    	<i class="fas fa-users"></i>
				                	</div>
				                    	<a href="<?php echo url_for('user/index.php')?>" class="small-box-footer">
				                    	<i class="fas fa-angle-double-right"></i>
				                		</a>
				                </div>
				            </div><!-- ./col -->
			        	</div>
			    	</div>
				</div>
			</div>
		</section>
	</div>
<?php include(SHARED_PATH . "/registration_staff/4P's_footer.php"); ?>