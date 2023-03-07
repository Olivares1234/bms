<?php require_once('../../private/initialize.php'); ?>
<?php $page_title = 'Inventory Per Barangay'; ?>
<?php include(SHARED_PATH . '/city_hall_header.php'); ?>

<div id="vue-city-hall" class="mt-4" v-cloak>
	<div class="container">
		<div class="card px-3 pb-1 pt-3">
			<h4>Barangay Inventory</h4>
		</div>

		<div class="card px-3 mt-4">
			<div class="float-left mt-4">
				<label class="d-inline-block mr-1" for="show_entries">Show </label>
					<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
						<option value="10" selected>10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option :value="barangay_inventories.length">All</option>
					</select>
				<label class="d-inline-block ml-1" for="show_entries">entries</label>

				<select @change="retrieveInventory()" v-model="barangay_name" class="form-control form-control-sm col-md-2 float-right" id="barangay_name">
					<option disabled value="" selected>Select Barangay</option>
					<option v-for="barangay in barangays" v-show="barangay.barangay_name != 'City Hall' && barangay.barangay_name != 'None'">{{barangay.barangay_name}}</option>
				</select>
				<label class="d-inline-block float-right mt-1 mr-2" for="barangay_name">Barangay : </label>
			</div>

			<table class="table table-hover table-bordered text-center mt-2">
				<thead class="thead-info">
					<tr class="table-color text-light">
						<th>Medicine Name</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Category</th>
						<th>Unit Category</th>
						<th colspan="6">Total</th>

					</tr>
				</thead>
				<tbody v-if="countBarangay() > 0">
					<tr v-for="(inventory, index) in barangay_inventories" v-if="index >= startIndex && index < endIndex">
						<td>{{inventory.medicine_name}}</td>
						<td>{{inventory.quantity}}</td>
						<td>&#8369;{{inventory.price}}</td>
						<td>{{inventory.description}}</td>
						<td>{{inventory.unit}}</td>
						<td colspan="6">&#8369;{{inventory.price * inventory.quantity}}.00</td>
					</tr>
				</tbody>

				<tbody v-else>
					<tr>
						<td colspan="12" style="font-size: 20px"><b>No data to show</b></td>
					</tr>
				</tbody>

				<tfoot>
					<tr>
						<th colspan="5" style="text-align: left;">Total</th>
						<th style="text-align: right;">&#8369;{{totalMedicinePrice()}}</th>
					</tr>
				</tfoot>
			</table>

			<div class="mt-1">
				<p class="float-left">Showing {{startIndex + 1}} to {{endIndex>this.barangay_inventories.length? this.barangay_inventories.length :endIndex}} of {{barangay_inventories.length}} entries</p>

				<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-end">
				    <li class="page-item">
				      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
				    </li>
				    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.barangay_inventories.length / this.show_entries_two) > 3 ? 3 : Math.ceil(this.barangay_inventories.length / this.show_entries_two)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
				    <li class="page-item">
				      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextBarangayInventory()">Next</a>
				    </li>
				  </ul>
				</nav>
			</div>
		</div>
	</div>
</div>

<?php include(SHARED_PATH . '/city_hall_footer.php'); ?>