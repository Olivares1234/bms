<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Available Medicine'; ?>
<?php $barangay_name = 'Barangay ' . $_SESSION['barangay_name'] ?>
<?php include(SHARED_PATH . '/barangay/health_worker/medicine/available_medicine/available_medicine_header.php'); ?>
 
<div id="vue-available-medicine" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="available_medicine_list">
			<div class="card px-3 pb-1 pt-3 shadow-nohover">
				<h4 class="float-left"> List of Available Medicine {{"(" + available_medicines.length + ")"}}</h4>
			</div>

			<div class="card px-3 mt-4 shadow-nohover">
				<div class="float-left mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="available_medicines.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>

					<input @input="searchAvailableMedicine" type="text" class="form-control form-control-sm float-right col-md-2" v-model="search_available_medicine" placeholder="Search" arial-label="Search" onfocus="this.value=''" v-if="filter == 'medicine name' || filter == 'category' || filter == 'unit category'">

					<select v-model="filter" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
						<option value="" disabled selected>Select Field name</option>
						<option value="medicine name">Medicine name</option>
						<option value="category">Category</option>
						<option value="unit category">Unit Category</option>
					</select>
					<label class="mr-2 float-right mt-1">Filter: </label>
				</div>
				 
				<table class="table table-hover table-bordered text-center mt-2" v-cloak>

					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Medicine Name</th>
							<th>Category</th>
							<th>Unit Category</th>
							<th>Stock</th>
							<th>Price</th>
						</tr>
					</thead>
					<tbody v-if="available_medicines.length > 0">
						<tr v-for="(medicine, index) in available_medicines" v-if="index >= startIndex && index < endIndex">
							<td>{{identifyMedicineName(medicine.purchase_received_details_id)}}</td>
							<td>{{identifyCategoryName(medicine.purchase_received_details_id)}}</td>
							<td>{{identifyUnitCategoryName(medicine.purchase_received_details_id)}}</td>
							<td>{{medicine.quantity}}</td>
							<td>{{identifyMedicinePrice(medicine.purchase_received_details_id)}}</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>

					<tfoot v-if="available_medicines.length > 0">
						<tr>
							<th colspan="4" class="text-left">Total Amount:</th>
							<th class="mx-auto">&#8369;{{totalInventory}}</th>
						</tr>
					</tfoot>
				</table>

				<div class="mt-1">
					<p class="float-left">Showing {{this.available_medicines.length ? startIndex + 1 : 0}} to {{endIndex>this.available_medicines.length? this.available_medicines.length :endIndex}} of {{available_medicines.length}} entries</p>

					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-end">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.available_medicines.length / this.show_entries) > 3 ? 3 : Math.ceil(this.available_medicines.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include(SHARED_PATH . '/barangay/health_worker/medicine/available_medicine/available_medicine_footer.php'); ?>