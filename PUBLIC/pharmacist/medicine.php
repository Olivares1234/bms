<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = 'Medicine'; ?>
<?php include(SHARED_PATH . '/pharmacist_header.php'); ?>
<div id="vue-pharmacist" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="gulod_available_medicine">
			<h3> List of Medicine {{ "(" + countMedicine() + ")" }}  </h3>
			<div class="float-right mt-5">
				<div class="input-group form-group">
				<input type="text" class="form-control-sm col-sm-12" v-model="search_medicine" @input="searchMedicine" placeholder="Search" arial-label="Search">
				</div>
			</div>
			<div class="float-left mt-4">
				<label class="d-inline-block mr-1" for="show_entries" style="font-size: 15px;">Show </label>
					<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block" id="show_entries" style="width: auto; margin-top: 35px;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option :value="medicines.length">All</option>
					</select>
				<label class="d-inline-block ml-1" for="show_entries" style="font-size: 15px;">entries</label>
			</div>
			<table class="table table-hover table-bordered text-center mt-4">

				<thead class="thead-info">
					<tr class="table-color text-light">
						<th>Medicine Name</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Category</th>
						<th>Unit Category</th>
						<th>Supplier</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody v-if="countMedicine() > 0">
					<tr v-for="(medicine, index) in medicines" v-if="index >= startIndex && index < endIndex">
						<td>{{medicine.medicine_name}}</td>
						<td>{{medicine.quantity}}</td>
						<td>{{medicine.price}}</td>
						<td>{{medicine.description}}</td>
						<td>{{medicine.unit}}</td>
						<td>{{medicine.supplier_name}}</td>
						<td>
							<button @click="toggleMedicineInfo(medicine.medicine_id,medicine.medicine_name,medicine.price,medicine.description,medicine.unit,medicine.quantity,medicine.supplier_name)" :title="view_Medicine" class="btn btn-outline-warning btn-sm"><i class="fas fa-eye"></i></button>
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

		<div v-if="gulod_medicine_info">
        	<h3>Medicine Information 
				<a class="btn bg-info text-light btn-sm" @click="toggleMedicineInfo('','','','')" class="small-box-footer"><i class="fas fa-arrow-left"></i></a>
			</h3>


            <div class="card mt-5 border-info shadow-sm rounded bg-light" style="width: 60%;">
            	<div class="card-header mb-0 m-0 px-3 py-2 text-light bg-info">
				    <h5 class="mb-1">Details</h5>
				</div>
                <div class="row" style="width: 119.7%;">
                    <div class="col-md-5 table-bordered ml-3">
                        <label class="font-weight-bold mt-1">Medicine Name</label>
                    </div>
                    <div class="col-md-5 table-bordered">
                        <p class="mt-1">{{gulod_medicine_info_name}}</p>
                    </div>
                </div>
                <div class="row" style="width: 119.7%;">
                    <div class="col-md-5 table-bordered ml-3">
                        <label class="font-weight-bold mt-1">Price</label>
                    </div>
                    <div class="col-md-5 table-bordered">
                        <p class="mt-1">&#8369;{{gulod_medicine_info_price}}</p>
                    </div>
                </div>
                <div class="row" style="width: 119.7%;">
                    <div class="col-md-5 table-bordered ml-3">
                        <label class="font-weight-bold mt-1">Category</label>
                    </div>
                    <div class="col-md-5 table-bordered">
                        <p class="mt-1">{{gulod_medicine_info_category}}</p>
                    </div>
                </div>
                <div class="row" style="width: 119.7%;">
                    <div class="col-md-5 table-bordered ml-3">
                        <label class="font-weight-bold mt-1">Unit</label>
                    </div>
                    <div class="col-md-5 table-bordered">
                        <p class="mt-1">{{gulod_medicine_info_category_unit}}</p>
                    </div>       
                </div>
                <div class="row" style="width: 119.7%;">
                    <div class="col-md-5 table-bordered ml-3">
                        <label class="font-weight-bold mt-1">Quantity</label>
                    </div>
                    <div class="col-md-5 table-bordered">
                        <p class="mt-1">{{gulod_medicine_info_quantity}}</p>
                    </div>
                </div>
                <div class="row" style="width: 119.7%;">
                    <div class="col-md-5 table-bordered ml-3">
                        <label class="font-weight-bold mt-1">Supplier</label>
                    </div>
                    <div class="col-md-5 table-bordered">
                        <p class="mt-1">{{gulod_medicine_info_supplier}}</p>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>

<?php include(SHARED_PATH . '/pharmacist_footer.php'); ?>