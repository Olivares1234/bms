<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = 'Category'; ?>
<?php include(SHARED_PATH . '/pharmacist_header.php'); ?>
<div id="vue-pharmacist" class="mt-4" v-cloak>
	<div class="container">
		<h3> List of Category {{ "(" + countCategory() + ")" }}  
			<a class="btn bg-success text-light btn-sm font-weight-bold" href="#add"  data-toggle="modal" data-target="#myModal" class="small-box-footer"><i class="fas fa-plus">&nbsp;</i> Add new</a>
		</h3>
		<div class="float-right mt-5">
			<div class="input-group form-group">
			<input type="text" class="form-control-sm col-sm-12" v-model="search_category" @input="searchCategory" placeholder="Search" arial-label="Search">
			</div>
		</div>
		<div class="float-left mt-4">
			<label class="d-inline-block mr-1" for="show_entries" style="font-size: 15px;">Show </label>
				<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block" id="show_entries" style="width: auto; margin-top: 35px;">
					<option value="10" selected>10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="100">100</option>
					<option :value="categories.length">All</option>
				</select>
			<label class="d-inline-block ml-1" for="show_entries" style="font-size: 15px;">entries</label>
		</div>

		<table class="table table-hover table-bordered text-center mt-4">

			<thead class="thead-info">
				<tr class="table-color text-light">
					<th>Description</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody v-if="countCategory() > 0">
				<tr v-for="(category, index) in categories" v-if="index >= startIndex && index < endIndex">
					<td>{{category.description}}</td>
					<td><button @click="updateCategoryButton(category.category_id,category.description)" :title="update_Category" class="btn btn-outline-primary btn-sm" href="#add"  data-toggle="modal" data-target="#myModal1"><i class="fas fa-edit"></i></button></td>
				</tr>
			</tbody>
			<tbody v-else>
				<tr>
					<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
				</tr>
			</tbody>
		</table>

		<div class="pagination float-left mt-1">
			<p>Showing {{startIndex + 1}} to {{endIndex>this.categories.length? this.categories.length :endIndex}} of {{categories.length}} entries</p>
		</div>

		<nav aria-label="Page navigation example" class="pagination float-right mt-1">
		  	<ul class="pagination">
			    <li class="page-item"><a class="page-link btn-sm" @click="previous()">Previous</a></li>
			    <li class="page-item"><a class="page-link bg-primary text-light btn-sm" v-for="num in Math.ceil(this.categories.length / show_entries) > 3 ? 3 : Math.ceil(this.categories.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li> 
			    <li class="page-item"><a class="page-link btn-sm" @click="nextCategory()">Next</a></li>
		  	</ul>
		</nav>

		<div class="modal" id="myModal" > <!-- start add modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			          <h4 class="modal-title">Add Category</h4>
			          <button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>
		        	
			        <!-- Modal body -->
			        <div class="modal-body" id="modal-less-input">
			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="category_description">Description</label>
								<input type="text" :class="{'is-invalid' : category_description_error}" class="form-control" id="category_description" name="category_description" v-model="category_description" @keydown="isLetter($event)" placeholder="Enter Description" required>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>
					</div>
		        
			        <!-- Modal footer -->
			        <div class="modal-footer">
			          <button type="button" @click="addCategory" class="btn btn-primary btn-sm"><i class="far fa-save">&nbsp;</i> Save</button>
			        </div>
	      		</div>
	    	</div>
	 	</div> <!-- end add modal -->

	 	<div class="modal" id="myModal1" > <!-- start update modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			          <h4 class="modal-title">Update Category</h4>
			          <button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>
		        	
			        <!-- Modal body -->
			        <div class="modal-body" id="modal-less-input">
			         	<div class="form-group">
							<div class="col-lg-12">
								<input type="hidden" class="form-control" id="category_id" name="category_id" v-model="category_id" disabled>
							</div>
						</div>

						<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="_category_description">Description</label>
								<input type="text" :class="{'is-invalid' : category_description_error}" class="form-control" id="_category_description" name="category_descriptions" @keydown="isLetter($event)" placeholder="Enter Description" v-model="category_description">
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>
					</div>
       
			        <!-- Modal footer -->
			        <div class="modal-footer">
			          <button type="button" @click="updateCategory" class="btn btn-primary btn-sm"><i class="far fa-save">&nbsp;</i> Save</button>
			        </div>
	      		</div>
	    	</div>
	 	</div> <!-- end update modal -->
	</div>
</div>

<?php include(SHARED_PATH . '/pharmacist_footer.php'); ?>