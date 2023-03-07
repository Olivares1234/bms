<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = 'Supplier'; ?>
<?php include(SHARED_PATH . '/pharmacist_header.php'); ?>
<div id="vue-app" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="supplier_medicine_info == false">
			<h3> List of Supplier
				<a class="btn bg-success text-light btn-sm font-weight-bold" :title="add_Supplier" href="#add" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus">&nbsp;</i> Add New</a>
			</h3>
			<div class="float-right mt-5">
				<div class="input-group form-group">
					<input type="text" class="form-control-sm" placeholder="Search" v-model="search_supplier"  @input="searchSupplier" arial-label="Search">
				</div>
			</div>
			<div class="float-left mt-4">
				<label class="d-inline-block mr-1" for="show_entries" style="font-size: 15px;">Show </label>
					<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block" id="show_entries" style="width: auto; margin-top: 35px;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="All">All</option>
					</select>
				<label class="d-inline-block ml-1" for="show_entries" style="font-size: 15px;">entries</label>
			</div>
			<table class="table table-hover table-bordered text-center mt-4">
				<thead class="thead-info">
					<tr class="table-color text-light">
						<th>Supplier Name</th>
						<th>Address</th>
						<th>Contact No</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody v-if="countSupplier()">
					<tr v-for="(supplier, index) in suppliers" v-if="(index >= startIndex && index < endIndex) && (supplier.supplier_id != '1')">
						<td>{{supplier.supplier_name}}</td>
						<td>{{supplier.supplier_address}}</td>
						<td>{{supplier.supplier_contact_no}}</td>
						<td>{{supplier.supplier_status}}</td>
						<td>
							<button @click="toggleSupplierInfo(supplier.supplier_id)" :title="view_Medicine" class="btn bg-warning btn-sm"><i class="far fa-eye text-light"></i></button>
							<button @click="updateButton(supplier.supplier_id,supplier.supplier_name,supplier.supplier_address,supplier.supplier_contact_no,supplier.supplier_status)" class="btn bg-primary btn-sm" :title="update_Supplier" href="#add" data-toggle="modal" data-target="#myModal1"><i class="fas fa-edit text-light"></i></button>

						</td>
					</tr>
				</tbody>

				<tbody v-else>
					<tr>
						<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
					</tr>
				</tbody>
			</table>

			<div class="pagination float-left mt-1">
				<p class="text-dark">Showing {{startIndex + 1}} to {{endIndex>this.suppliers.length? this.suppliers.length :endIndex}} of {{suppliers.length}} entries</p>
			</div>
			
			<nav aria-label="Page navigation example" class="pagination float-right mt-1">
			  	<ul class="pagination">
				    <li class="page-item"><a class="page-link btn-sm" @click="previous()">Previous</a></li>
				    <li class="page-item"><a class="page-link bg-primary text-light btn-sm" v-for="num in Math.ceil(this.suppliers.length / this.show_entries) > 3 ? 3 : Math.ceil(this.suppliers.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
				    <li class="page-item"><a class="page-link btn-sm" @click="nextSupplier()">Next</a></li>
			  	</ul> 
			</nav>

			<div class="modal" id="myModal" > 
		    	<div class="modal-dialog">
		     		<div class="modal-content">
			      
				        <!-- Modal Header -->
				        <div class="modal-header">
				          <h4 class="modal-title">Add Supplier</h4>
				          <button @click="clearData" type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
				        </div>
			        	
				        <!-- Modal body -->
				        <div class="modal-body">
				         	<div class="form-group">
								<div class="col-lg-12">
									<label for="supplier_name">Supplier name</label>
									<input type="text" :class="{'is-invalid': supplier_name_error}" class="form-control" id="supplier_name" name="supplier_name" v-model="supplier_name" @keydown="isLetter($event)" placeholder="Enter Supplier name" required>
									<div class="invalid-feedback">This field is required!</div> 
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-12">
									<label for="supplier_address">Address</label>
									<input type="text" :class="{'is-invalid': supplier_address_error}" class="form-control" id="supplier_address" name="supplier_address" v-model="supplier_address" @keydown="isLetter($event)" placeholder="Enter Supplier address" required>
									<div class="invalid-feedback">This field is required!</div> 
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-12">
									<label for="supplier_contact">Contact no</label>
									<input type="text" :class="{'is-invalid': supplier_contact_no_error}" class="form-control" id="supplier_contact_no" name="supplier_contact" @keypress="isNumberKeyWithDash($event)" v-model="supplier_contact_no" placeholder="Enter Supplier Contact no" required>
									<div class="invalid-feedback">This field is required!</div> 
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<label for="supplier_status">Status</label>
									<select v-model="supplier_status" :class="{'is-invalid': supplier_status_error}" class="custom-select" id="supplier_status">
				              			<option disabled value="" selected>Select Supplier Status</option>
				              			<option value="Active">Active</option>
				              			<option value="Inactive">Inactive</option>
				              		</select> 
				              		<div class="invalid-feedback">This field is required!</div> 
								</div>
							</div>
						</div>

							
			        
				        <!-- Modal footer -->
				        <div class="modal-footer">
				          <button type="button" @click="addSupplier" class="btn btn-primary btn-sm"><i class="far fa-save">&nbsp;</i> Save</button>
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
				          <button @click="clearData" type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
				        </div>
			        	
				        <!-- Modal body -->
				         <div class="modal-body">
				         	<div class="form-group">
								<div class="col-lg-12">
									<label for="_supplier_name">Supplier name</label>
									<input type="text" :class="{'is-invalid': supplier_name_error}" class="form-control" id="_supplier_name" name="supplier_name" v-model="supplier_name" @keydown="isLetter($event)" placeholder="Enter Supplier name" required>
									<div class="invalid-feedback">This field is required!</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-12">
									<label for="_supplier_address">Address</label>
									<input type="text" :class="{'is-invalid': supplier_address_error}" class="form-control" id="_supplier_address" name="supplier_address" v-model="supplier_address" @keydown="isLetter($event)" placeholder="Enter Supplier address" required>
									<div class="invalid-feedback">This field is required!</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-12">
									<label for="_supplier_contact">Contact no</label>
									<input type="text" :class="{'is-invalid': supplier_contact_no_error}" class="form-control" id="_supplier_contact" @keypress="isNumberKeyWithDash($event)" name="supplier_contact" v-model="supplier_contact_no" placeholder="Enter Supplier Contact no" required>
									<div class="invalid-feedback">This field is required!</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<label for="supplier_status">Status</label>
									<select v-model="supplier_status" :class="{'is-invalid': supplier_status_error}" class="custom-select" id="supplier_status">
				              			<option disabled value="" selected>Select Supplier Status</option>
				              			<option value="Active">Active</option>
				              			<option value="Inactive">Inactive</option>
				              		</select> 
				              		<div class="invalid-feedback">This field is required!</div>
								</div>
							</div>
						</div>
	       
				        <!-- Modal footer -->
				        <div class="modal-footer">
				          <button @click="updateSupplier" type="button" class="btn btn-primary btn-sm"><i class="far fa-save">&nbsp;</i> Save</button>
				        </div>
		      		</div>
		    	</div>
		 	</div> <!-- end update modal -->

	 	</div>

	 	<div v-if="supplier_medicine_info">
	 		<h3> List of Medicine {{ "(" + countMedicine() + ")" }}
	 			<a class="btn bg-info text-light btn-sm" @click="toggleSupplierInfo" class="small-box-footer"><i class="fas fa-arrow-left"></i></a>
	 			<a class="btn bg-success text-light btn-sm font-weight-bold" :title="add_Medicine" href="#add" data-toggle="modal" data-target="#myModal2"><i class="fas fa-plus">&nbsp;</i> Add new</a>
	 		</h3>

	 		<div class="float-right mt-5">
				<div class="input-group form-group">
				<input type="text" class="form-control-sm" v-model="search_medicine" @input="searchMedicine" placeholder="Search" arial-label="Search">
				<!-- <button class="btn btn-success btn-sm" @click="searchMedicine"><i class="fas fa-search text-light"></i></button>
				<button class="btn btn-danger btn-sm" @click="retrieveActiveBeneficiary"><i class="fas fa-backspace"></i></button> -->
				</div>
			</div>

			<div class="float-left mt-4">
				<label class="d-inline-block mr-1" for="show_entries" style="font-size: 15px;">Show </label>
					<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block" id="show_entries" style="width: auto; margin-top: 35px;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="All">All</option>
					</select>
				<label class="d-inline-block ml-1" for="show_entries" style="font-size: 15px;">entries</label>
			</div>
			<table class="table table-hover table-bordered text-center mt-4">

				<thead class="thead-info">
					<tr class="table-color text-light">
						<th>Medicine Name</th>
						<th>Price</th>
						<th>Category</th>
						<th>Unit Category</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody v-if="countMedicine() > 0">
					<tr v-for="(supplier_medicine, index) in supplier_medicines">
						<td>{{supplier_medicine.medicine_name}}</td>
						<td>{{supplier_medicine.price}}</td>
						<td>{{supplier_medicine.description}}</td>
						<td>{{supplier_medicine.unit}}</td>
						<td>
							<button @click="updateSupplierMedicineButton(supplier_medicine.supplier_medicine_id, supplier_medicine.medicine_name,  supplier_medicine.description, supplier_medicine.unit, supplier_medicine.price, supplier_medicine.supplier_id)":title="update_Medicine" class="btn bg-primary btn-sm" href="#add"  data-toggle="modal" data-target="#myModal3"><i class="fas fa-edit text-light"></i></button></td>
					</tr>
				</tbody>

				<tbody v-else>
					<tr>
						<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
					</tr>
				</tbody>
			</table>

			<div class="pagination float-left mt-1">
				<p>Showing {{startIndex + 1}} to {{endIndex>this.medicines.length? this.medicines.length :endIndex}} of {{medicines.length}} entries</p>
			</div>

			<nav aria-label="Page navigation example" class="pagination float-right mt-1">
			  	<ul class="pagination">
				    <li class="page-item"><a class="page-link btn-sm" @click="previous()">Previous</a></li>
				    <li class="page-item"><a class="page-link bg-primary text-light btn-sm" v-for="num in Math.ceil(this.medicines.length / this.show_entries) > 3 ? 3 : Math.ceil(this.medicines.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li> 
				    <li class="page-item"><a class="page-link btn-sm" @click="nextMedicine()">Next</a></li>
			  	</ul>
			</nav>
	 	</div>

	 	<div class="modal" id="myModal2" > <!-- start add modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			          <h4 class="modal-title">Add New Medicine</h4>
			          <button @click="clearData" type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>
		        	
			        <!-- Modal body -->
			        <div class="modal-body">
			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_name">Medicine name</label>
								<input type="text" :class="{'is-invalid': supplier_medicine_name_error}" class="form-control" id="supplier_medicine_name" name="supplier_medicine_name" v-model="supplier_medicine_name" placeholder="Enter Medicine Name" required>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>

			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_price">Price</label>
								<input type="text" :class="{'is-invalid': supplier_medicine_price_error}" class="form-control" id="supplier_medicine_price" name="supplier_medicine_price" v-model="supplier_medicine_price" @keypress="onlyForCurrency" placeholder="Enter Price" required>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>

			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_category">Category</label>
								<select v-model="supplier_medicine_category" :class="{'is-invalid': supplier_medicine_category_id_error}" class="custom-select" id="supplier_medicine_category">
									<option disabled value="" selected>Select Category</option>
									<option v-for="category in categories">{{category.description}}</option>
								</select>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>

			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_unit_id">Unit</label>
								<select v-model="supplier_medicine_unit" :class="{'is-invalid': supplier_medicine_unit_id_error}" class="custom-select" id="supplier_medicine_unit">
									<option disabled value="" selected>Select Unit</option>
									<option v-for="unit_category_unit in unit_categories">{{unit_category_unit.unit}}</option>
								</select>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>
					</div>	
		        
			        <!-- Modal footer -->
			        <div class="modal-footer">
			          <button @click="addSupplierMedicine" type="button" class="btn btn-primary btn-sm"><i class="far fa-save">&nbsp;</i> Save</button>
			        </div>
	      		</div>
	    	</div>
	 	</div> <!-- end add modal -->

	 	<div class="modal" id="myModal3" > <!-- start add modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			          <h4 class="modal-title">Update Medicine</h4>
			          <button @click="clearData" type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>
		        	
			        <!-- Modal body -->
			         <div class="modal-body">
			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_name">Medicine name</label>
								<input type="text" :class="{'is-invalid': supplier_medicine_name_error}" class="form-control" id="supplier_medicine_name" name="supplier_medicine_name" v-model="supplier_medicine_name" placeholder="Enter Medicine Name" required>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>

			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_price">Price</label>
								<input type="text" :class="{'is-invalid': supplier_medicine_price_error}" class="form-control" id="supplier_medicine_price" name="supplier_medicine_price" v-model="supplier_medicine_price" @keypress="onlyForCurrency" placeholder="Enter Price" required>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>

			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_category">Category</label>
								<select v-model="supplier_medicine_category" :class="{'is-invalid': supplier_medicine_category_id_error}" class="custom-select" id="supplier_medicine_category">
									<option disabled value="" selected>Select Category</option>
									<option v-for="category in categories">{{category.description}}</option>
								</select>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>

			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_unit">Unit</label>
								<select v-model="supplier_medicine_unit" :class="{'is-invalid': supplier_medicine_unit_id_error}" class="custom-select" id="supplier_medicine_unit">
									<option disabled value="" selected>Select Unit</option>
									<option v-for="unit_category_unit in unit_categories">{{unit_category_unit.unit}}</option>
								</select>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>
					</div>	
		        
			        <!-- Modal footer -->
			        <div class="modal-footer">
			          <button @click="updateSupplierMedicine" type="button" class="btn btn-primary btn-sm"><i class="far fa-save">&nbsp;</i> Save</button>
			        </div>
	      		</div>
	    	</div>
	 	</div> <!-- end add modal -->
	</div>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>