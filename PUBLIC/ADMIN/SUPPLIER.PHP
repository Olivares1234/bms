<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = 'Supplier'; ?>
<?php include(SHARED_PATH . '/city_hall_header.php'); ?>
<div id="vue-city-hall" class="mt-4" v-cloak> 
	<div class="container">
		<div v-if="supplier_medicine_info == false">
			<div class="card px-3 pb-1 pt-3"> 
				<h4> List of Supplier
					<a class="btn bg-success text-light btn-sm font-weight-bold ml-2" :title="add_Supplier" href="#add" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus"></i></a>
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

					<input type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_supplier" @input="searchSupplier" placeholder="Search" arial-label="Search">
					<select class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option></option>
					</select>
					<label class="mr-2 float-right mt-1">Filter: </label>
				</div>

				<table class="table table-hover table-bordered text-center mt-2">
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Supplier Name</th>
							<th>Address</th>
							<th>Status</th>
							<th>Contact No</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody v-if="countSupplier()">
						<tr v-for="(supplier, index) in suppliers" v-if="(index >= startIndex && index < endIndex) && (supplier.supplier_id != '1')" >
							<td>{{supplier.supplier_name}}</td>
							<td>{{supplier.supplier_address}}</td>
							<td v-if="supplier.supplier_status == 'Active'"><h6 class="text-light bg-success rounded">{{supplier.supplier_status}}</h6></td>
							<td v-if="supplier.supplier_status == 'Inactive'"><h6 class="text-light bg-warning rounded">{{supplier.supplier_status}}</h6></td>
							<td>{{supplier.supplier_contact_no}}</td>
							<td>
								<button @click="toggleSupplierInfo(supplier.supplier_id)" :title="view_Medicine" class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></button>
								<button @click="updateButton(supplier.supplier_id,supplier.supplier_name,supplier.supplier_address,supplier.supplier_contact_no,supplier.supplier_status)" class="btn btn-outline-primary btn-sm" :title="update_Supplier" href="#add" data-toggle="modal" data-target="#myModal1"><i class="fas fa-edit"></i></button>

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
					<p class="float-left">Showing {{startIndex + 1}} to {{endIndex>this.suppliers.length? this.suppliers.length :endIndex}} of {{suppliers.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.suppliers.length / this.show_entries) > 3 ? 3 : Math.ceil(this.suppliers.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextSupplier()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>

				<!-- <div class="pagination float-left mt-1">
					<p class="text-dark">Showing {{startIndex + 1}} to {{endIndex>this.suppliers.length? this.suppliers.length - 1 :endIndex}} of {{suppliers.length - 1}} entries</p>
				</div> -->
			</div>

			<div class="modal" id="myModal" data-keyboard="false" data-backdrop="static"> 
		    	<div class="modal-dialog">
		     		<div class="modal-content">
			      
				        <!-- Modal Header -->
				        <div class="modal-header">
				          <h4 class="modal-title">Add Supplier</h4>
				          <button type="button" @click="clearSupplier" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
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
						</div>
				        <!-- Modal footer -->
				        <div class="modal-footer">
				          <button type="button" @click="addSupplier" class="btn btn-primary btn-sm"><i class="far fa-save">&nbsp;</i> Save</button>
				        </div>
		      		</div>
		    	</div>
		 	</div> <!-- end add modal -->

		 	<div class="modal" id="myModal1" data-keyboard="false" data-backdrop="static"> <!-- start update modal -->
		    	<div class="modal-dialog">
		     		<div class="modal-content " style="height:auto">
			      
				        <!-- Modal Header -->
				        <div class="modal-header">
				          <h4 class="modal-title">Update Category</h4>
				          <button type="button" @click="clearSupplier" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
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
									<input type="text" :class="{'is-invalid': supplier_contact_no_error}" class="form-control" id="_supplier_contact" name="supplier_contact" @keypress="isNumberKeyWithDash($event)" v-model="supplier_contact_no" placeholder="Enter Supplier Contact no" required>
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
			<div class="card px-3 pb-1 pt-3"> 
		 		<h4> List of Medicine {{ "(" + supplier_medicines.length + ")" }}
		 			<a class="btn bg-success text-light btn-sm font-weight-bold ml-2" :title="add_Medicine" href="#add" data-toggle="modal" data-target="#myModal2"><i class="fas fa-plus"></i></a>

		 			<a class="btn bg-info text-light btn-sm font-weight-bold" @click="toggleSupplierInfo" class="small-box-footer"><i class="fas fa-arrow-left"></i></a>
		 		</h4>
		 	</div>

		 	<div class="card px-3 mt-4">
		 		<div class="float-left mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries_two(show_entries_two)" v-model="show_entries_two" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="supplier_medicines.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<input type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_supplier_medicine" @input="searchSupplierMedicine" placeholder="Search" arial-label="Search">
					<select class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option></option>
					</select>
					<label class="mr-2 float-right mt-1">Filter: </label>
				</div>
	 		
				<table class="table table-hover table-bordered text-center mt-2">

					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Medicine Name</th>
							<th>Price</th>
							<th>Category</th>
							<th>Unit Category</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody v-if="countSupplierMedicine() > 0">
						<tr v-for="(supplier_medicine, index) in supplier_medicines">
							<td>{{supplier_medicine.medicine_name}}</td>
							<td>{{supplier_medicine.price}}</td>
							<td>{{supplier_medicine.description}}</td>
							<td>{{supplier_medicine.unit}}</td>
							<td>
								<button @click="updateSupplierMedicineButton(supplier_medicine.supplier_medicine_id, supplier_medicine.medicine_name,  supplier_medicine.description, supplier_medicine.unit, supplier_medicine.price, supplier_medicine.supplier_id)":title="update_Medicine" class="btn btn-outline-primary btn-sm" href="#add"  data-toggle="modal" data-target="#myModal3"><i class="fas fa-edit"></i></button></td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{startIndex + 1}} to {{endIndex>this.supplier_medicines.length? this.supplier_medicines.length :endIndex}} of {{supplier_medicines.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.supplier_medicines.length / this.show_entries_two) > 3 ? 3 : Math.ceil(this.supplier_medicines.length / this.show_entries_two)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
		 	</div>
		 </div>

	 	<div class="modal" id="myModal2" > <!-- start add modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			          <h4 class="modal-title">Add New Medicine</h4>
			          <button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
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
								<input type="text" :class="{'is-invalid': supplier_medicine_price_error}" class="form-control" id="supplier_medicine_price" name="supplier_medicine_price" v-model="supplier_medicine_price" placeholder="Enter Price" required>
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
			          <button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
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

<?php include(SHARED_PATH . '/city_hall_footer.php'); ?>