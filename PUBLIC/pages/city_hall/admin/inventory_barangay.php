<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Inventory per Barangay'; ?>
<?php include(SHARED_PATH . '/city_hall/admin/barangay_inventory/barangay_inventory_header.php'); ?>

<div id="vue-inventory" class="mt-4" v-cloak>
	<div class="container">
		<div class="card px-3 pb-1 pt-3"> 
			<h4> Barangay Inventory</h4>
		</div>

		<div class="card px-3 mt-4">
			<div class="float-left mt-4">
				<select @change="retrieveInventoryPerBarangay" v-model="select_status" id="select_status" class="form-control form-control-sm d-inline-block col-md-2 float-right">
					<option disabled value="" selected>Select Status</option>
					<option value="available">Available</option>
					<option value="unavailable">Unavailable</option>
					<option value="expired">Expired</option>
				</select>	
				<label class="d-inline-block mr-2 mt-1 float-right ml-2" for="select_reports">Status: </label>

				<select v-model="filter_search" class="form-control form-control-sm d-inline-block col-md-2 float-right mr-3" style="width: auto;">
					<option value="" disabled selected>Select Barangay</option>
					<option v-for="barangay in barangays" v-show="barangay.barangay_name != 'City Hall'" :value="barangay.barangay_id">{{barangay.barangay_name}}</option>
				</select>
				<label class="mr-2 float-right mt-1">Barangay: </label>

				<label class="d-inline-block mr-1" for="show_entries">Show </label>
				<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
					<option value="10" selected>10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="100">100</option>
					<option :value="barangay_inventories.length">All</option>
				</select>
				<label class="d-inline-block ml-1" for="show_entries">entries</label>
			</div>

			<table class="table table-hover table-bordered text-center mt-2">
				<thead class="thead-info">
					<tr class="table-color text-light">
						<th>Medicine Name</th>
						<th>Category</th>
						<th>Unit Category</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Barangay</th>
					</tr>
				</thead>
				<tbody v-if="barangay_inventories.length > 0">
					<tr v-for="(barangay, index) in barangay_inventories" v-if="index >= startIndex && index < endIndex">
						<td>{{barangay.medicine_name}}</td>
						<td>{{barangay.description}}</td>
						<td>{{barangay.unit}}</td>
						<td>{{barangay.quantity}}</td>
						<td>{{barangay.price}}</td>
						<td>{{barangay.barangay_name}}</td>
					</tr>
				</tbody>

				<tbody v-else>
					<tr>
						<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
					</tr>
				</tbody>
			</table>

			<div class="mt-1">
				<p class="float-left">Showing {{this.barangay_inventories.length ? startIndex + 1 : 0}} to {{endIndex>this.barangay_inventories.length? this.barangay_inventories.length :endIndex}} of {{barangay_inventories.length}} entries</p>

				<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-end">
				    <li class="page-item">
				      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
				    </li>
				    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.barangay_inventories.length / this.show_entries) > 3 ? 3 : Math.ceil(this.barangay_inventories.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
				    <li class="page-item">
				      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next()">Next</a>
				    </li>
				  </ul>
				</nav>
			</div>
		</div>
	</div>
</div>

<?php include(SHARED_PATH . '/city_hall/admin/barangay_inventory/barangay_inventory_footer.php'); ?>