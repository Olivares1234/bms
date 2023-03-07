<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Supplier'; ?>
<?php include(SHARED_PATH . '/city_hall/admin/supplier/supplier_header.php'); ?>

<div id="vue-supplier" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="supplier_list">
			<div class="card px-3 pb-1 pt-3"> 
				<h4> List of Supplier
					<a @click="toggleAddSupplier" class="btn bg-success text-light btn-sm font-weight-bold ml-2" :title="add_Supplier"><i class="fas fa-plus"></i></a>
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
							<option :value="suppliers.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<input @input="searchSupplier" type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_supplier" placeholder="Search" arial-label="Search" v-if="filter == 'name' || filter == 'address' || filter == 'contact'">

					<select @change="searchSupplier" v-model="search_supplier" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;" v-if="filter == 'status'">
						<option value="" disabled selected>Select status</option>
						<option value="1" selected>Active</option>
						<option value="0">Not Active</option>
					</select>

					<select v-model="filter" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option value="name">Name</option>
						<option value="address">Address</option>
						<option value="status">Status</option>
						<option value="contact">Contact no.</option>
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
					<tbody v-if="suppliers.length > 0">
						<tr v-for="(supplier, index) in suppliers" v-if="(index >= startIndex && index < endIndex) && (supplier.supplier_name != 'City Hall')" >
							<td>{{supplier.supplier_name}}</td>
							<td>{{supplier.supplier_address}}</td>
							<td v-if="supplier.supplier_status == 'Active'"><h6 class="text-light bg-success rounded">{{supplier.supplier_status}}</h6></td>
							<td v-if="supplier.supplier_status == 'Not Active'"><h6 class="text-light bg-warning rounded">{{supplier.supplier_status}}</h6></td>
							<td>{{supplier.supplier_contact_no}}</td>
							<td>
								<div class="btn-group">
									  <button class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split py-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
									    <i class="fas fa-cog">&nbsp;</i>
									  </button>
								    <div class="dropdown-menu" style="font-size:13px;">
									    <a class="dropdown-item" @click="toggleSupplierInfo(supplier.supplier_id)"><i class="fas fa-eye">&nbsp;</i> View</a>
									    <a class="dropdown-item" @click="toggleUpdateSupplier(supplier.supplier_id)"><i class="fas fa-edit">&nbsp;</i> Update</a>
									    <a class="dropdown-item" v-if="supplier.supplier_status == 'Active'" @click="toggleDeactivateSupplier(supplier.supplier_id)"><i class="fas fa-minus-circle">&nbsp;</i> Deactivate</a>
									    <a class="dropdown-item" v-if="supplier.supplier_status == 'Not Active'" @click="toggleActivateSupplier(supplier.supplier_id)"><i class="fas fa-plus-circle">&nbsp;</i> Activate</a>
									</div>
								</div>
								<!-- <button @click="toggleSupplierInfo(supplier.supplier_id)" :title="view_Medicine" class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></button>

								<button @click="toggleUpdateSupplier(supplier.supplier_id)" class="btn btn-outline-primary btn-sm" :title="update_Supplier"><i class="fas fa-edit"></i></button>

								<button @click="toggleDeactivateSupplier(supplier.supplier_id)" class="btn btn-outline-danger btn-sm" v-if="supplier.supplier_status == 'Active'" :title="deactivate_supplier" class="small-box-footer"><i class="fas fa-minus-circle"></i></button>

								<button @click="toggleActivateSupplier(supplier.supplier_id)" class="btn btn-outline-success btn-sm" v-if="supplier.supplier_status == 'Not Active'" :title="activate_supplier"><i class="fas fa-plus-circle"></i></button> -->

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
					<p class="float-left">Showing {{this.suppliers.length ? startIndex + 1 : 0}} to {{endIndex>this.suppliers.length? this.suppliers.length :endIndex}} of {{suppliers.length}} entries</p>

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
		</div>

		<div v-if="add_supplier">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Add new supplier
					<a @click="toggleAddSupplier" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 pb-4 mt-4 shadow-nohover">
				<h5 class="mt-4">Supplier Details</h5>
				<div class="mt-3 shadow-sm rounded bg-light pt-3 pb-3">
					<div class="form-row mt-2 px-3">

					    <div class="form-group col-md-4">
					    	<label>Supplier name</label>
					       <input type="text" v-model="supplier_name" :class="{'is-invalid' : supplier_name_error}" class="form-control form-control-sm" placeholder="Enter First name">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>

					    <div class="form-group col-md-4">
					    	<label>Address</label>
					       <input type="text" v-model="supplier_address" :class="{'is-invalid' : supplier_address_error}" class="form-control form-control-sm" placeholder="Enter Street">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>

					    <div class="form-group col-md-4">
					    	<label>Contact number</label>
					       <input maxlength="11" @keypress="isNumber($event)" type="text" v-model="supplier_contact_no" :class="{'is-invalid' : supplier_contact_no_error}" class="form-control form-control-sm" placeholder="Enter Contact no.">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>
					</div>
				</div>
				<div class="mt-3 float-right">
					<!--  -->
					<button @click="addSupplier" class="btn btn-sm text-light bg-primary font-weight-bold float-right"><i class="far fa-save">&nbsp;</i> Save Supplier Details</button>
				</div>
			</div>
		</div>

		<div v-if="update_supplier">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4>Update supplier
					<a @click="toggleUpdateSupplier('')" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 pb-4 mt-4 shadow-nohover">
				<h5 class="mt-4">Supplier Details</h5>
				<div class="mt-3 shadow-sm rounded bg-light pt-3 pb-3">
					<div class="form-row mt-2 px-3">

					    <div class="form-group col-md-4">
					    	<label>Supplier name</label>
					       <input type="text" v-model="supplier_name" :class="{'is-invalid' : supplier_name_error}" class="form-control form-control-sm" placeholder="Enter First name">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>

					    <div class="form-group col-md-4">
					    	<label>Address</label>
					       <input type="text" v-model="supplier_address" :class="{'is-invalid' : supplier_address_error}" class="form-control form-control-sm" placeholder="Enter Street">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>

					    <div class="form-group col-md-4">
					    	<label>Contact no</label>
					       <input type="text" v-model="supplier_contact_no" :class="{'is-invalid' : supplier_contact_no_error}" class="form-control form-control-sm" placeholder="Enter Contact no.">
					       <div class="invalid-feedback">This field is required!</div>
					    </div>
					</div>
				</div>
				<div class="float-right mt-4">
					<button @click="updateSupplier" class="btn btn-sm text-light bg-primary font-weight-bold float-right"><i class="far fa-save">&nbsp;</i> Update supplier</button>
				</div>
			</div>
		</div>

		<div v-if="supplier_medicine_list">
			<div class="card px-3 pb-1 pt-3"> 
				<h4> List of Supplier Medicine {{ "(" + supplier_medicines.length + ")" }}
					<a @click="toggleAddSupplierMedicine" class="btn bg-success text-light btn-sm font-weight-bold ml-2" :title="add_Medicine"><i class="fas fa-plus"></i></a>

					<a @click="toggleSupplierInfo('')" class="btn btn-sm text-light bg-info font-weight-bold ml-1"><i class="fas fa-arrow-left"></i></a>
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

					<!-- <input type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_supplier_medicine" @input="searchSupplierMedicine" placeholder="Search" arial-label="Search">
					<select class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option></option>
					</select>
					<label class="mr-2 float-right mt-1">Filter: </label> -->
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
					<tbody v-if="supplier_medicines.length > 0">
						<tr v-for="(supplier_medicine, index) in supplier_medicines">
							<td>{{supplier_medicine.medicine_name}}</td>
							<td>{{supplier_medicine.price}}</td>
							<td>{{identifyMedicineCategory(supplier_medicine.category_id)}}</td>
							<td>{{identifyMedicineUnitCategory(supplier_medicine.unit_category_id)}}</td>
							<td>
								<button @click="toggleUpdateSupplierMedicine(supplier_medicine.supplier_medicine_id)" :title="update_Medicine" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></button></td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{this.supplier_medicines.length ? startIndex + 1 : 0}} to {{endIndex>this.supplier_medicines.length? this.supplier_medicines.length :endIndex}} of {{supplier_medicines.length}} entries</p>

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

		<div class="modal" id="myModal1" > <!-- start update modal -->
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
								<input type="text" :class="{'is-invalid': supplier_medicine_name_error}" class="form-control" v-model="supplier_medicine_name" placeholder="Enter Medicine Name" required>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>

			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_price">Price</label>
								<input type="text" :class="{'is-invalid': supplier_medicine_price_error}" class="form-control" v-model="supplier_medicine_price" @keypress="onlyForCurrency" placeholder="Enter Price" required>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>

			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_category">Category</label>
								<select v-model="supplier_medicine_category" :class="{'is-invalid': supplier_medicine_category_error}" class="custom-select">
									<option disabled value="" selected>Select Category</option>
									<option v-for="category in categories">{{category.description}}</option>
								</select>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>

			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_unit_category">Unit</label>
								<select v-model="supplier_medicine_unit_category" :class="{'is-invalid': supplier_medicine_unit_category_error}" class="custom-select">
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
	 	</div> <!-- end update modal -->

	 	<div class="modal" id="myModal2" > <!-- start add modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			          <h4 class="modal-title">Add Medicine</h4>
			          <button @click="toggleCloseAddSupplierMedicine" type="button" class="btn closing-modal"><i class="fas fa-times"></i></button>
			        </div>
		        	
			        <!-- Modal body -->
			         <div class="modal-body">
			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_name">Medicine name</label>
								<input type="text" :class="{'is-invalid': supplier_medicine_name_error}" class="form-control" v-model="supplier_medicine_name" placeholder="Enter Medicine Name" required>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>

			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_price">Price</label>
								<input type="text" :class="{'is-invalid': supplier_medicine_price_error}" class="form-control" v-model="supplier_medicine_price" @keypress="onlyForCurrency" placeholder="Enter Price" required>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>

			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_category">Category</label>
								<select v-model="supplier_medicine_category" :class="{'is-invalid': supplier_medicine_category_error}" class="custom-select">
									<option disabled value="" selected>Select Category</option>
									<option v-for="category in categories">{{category.description}}</option>
								</select>
								<div class="invalid-feedback">This field is required!</div>
							</div>
						</div>

			         	<div class="input-group form-group">
							<div class="col-lg-12">
								<label for="supplier_medicine_unit_category">Unit</label>
								<select v-model="supplier_medicine_unit_category" :class="{'is-invalid': supplier_medicine_unit_category_error}" class="custom-select">
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

	 	<div class="modal" id="myModal3" data-keyboard="false" data-backdrop="static"> <!-- start deactivate modal -->
	    	<div class="modal-dialog">
	     		<div class="modal-content " style="height:auto">
		      
			        <!-- Modal Header -->
			        <div class="modal-header">
			        	<h4 class="modal-title">Deactivate Supplier</h4>
			        	<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
			        </div>
		        
			        <div class="modal-body" id="modal-less-input">
			        	<div class="form-group">
							<div class="col-lg-12">
								<b>Do you want to Deactivate supplier?</b> 
							</div>
						</div>
					</div>					
					<div class="modal-footer">
						<div class="col-lg-12">
							<button @click="deactivateSupplier" class="btn btn-danger float-right btn-sm ml-2">Yes</button>
						</div>
					</div>
	      		</div>
	    	</div>
	 	</div> <!-- end deactivate modal -->

	 	<div class="modal" id="myModal4" data-keyboard="false" data-backdrop="static"> <!-- start activate modal -->
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
							<button @click="activateSupplier" class="btn btn-success float-right btn-sm ml-2">Yes</button>
						</div>
					</div>
	      		</div>
	    	</div>
	 	</div> <!-- end activate modal -->
	</div>
</div>


<?php include(SHARED_PATH . '/city_hall/admin/supplier/supplier_footer.php'); ?>