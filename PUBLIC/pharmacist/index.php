<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = 'Dashboard'; ?>
<?php include(SHARED_PATH . '/pharmacist_header.php'); ?>
<div id="vue-pharmacist" class="mt-4" v-cloak>
	<section class="content">
		<div class="col-md-12">
			<div class="box box-primary">
			    <div class="box-header with-border">
			        <h3 class="box-title">Dashboard</h3>
			    </div><!-- /.box-header -->
			        <div class="box-body">
			          <div class="row">
			              <div class="col-lg-4 col-xs-6">
			                <!-- small box -->
			                <div class="small-box" id="medicine-box">
			                  <div class="inner">
			                    <h3 class="text-light">Medicine{{ "(" + countMedicine() + ")" }}</h3>
			                    <p class="text-light">View/Add</p>
			                  </div>
			                  <div class="icon" style="margin-top:10px">
			                    <i class="fas fa-pills"></i>
			                  </div>
			                  <a href="<?php echo url_for('medicine/index.php')?>" class="small-box-footer">
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
<?php include(SHARED_PATH . '/pharmacist_footer.php'); ?>

