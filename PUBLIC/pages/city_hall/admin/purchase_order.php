<?php require_once('../../../../private/initialize.php'); ?>
<?php $page_title = 'Purchase Order'; ?>
<?php include(SHARED_PATH . '/city_hall/admin/purchase_order/purchase_order_header.php'); ?>
<div id="vue-purchase-order" class="mt-4" v-cloak>
	<div class="container">
		<div v-if="purchase_order_list">
			<div class="card px-3 pb-1 pt-3">
				<h4>List of Purchase Order
					<a @click="togglePurchaseOrder" class="btn bg-success text-light btn-sm font-weight-bold ml-2"><i class="fas fa-plus"></i></a>
				</h4>
			</div>
			<div class="card px-3 pb-3 mt-4">
				<div class="float-left mt-4">
					<label class="d-inline-block mr-1" for="show_entries">Show </label>
						<select @change="showEntries(show_entries)" v-model="show_entries" class="form-control form-control-sm d-inline-block col-md-2" id="show_entries" style="width: auto;">
							<option value="10" selected>10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option :value="purchase_order_using_id.length">All</option>
						</select>
					<label class="d-inline-block ml-1" for="show_entries">entries</label>
				</div>

				<table class="table table-hover table-bordered text-center mt-2">		
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Purchase Order ID</th>
							<th>Date Ordered</th>
							<th>Supplier</th>
							<th>Ordered By</th>
						</tr>
					</thead>
					<tbody v-if="purchase_order_using_id.length > 0">
						<tr v-for="(purchase_order, index) in purchase_order_using_id" v-if="index >= startIndex && index < endIndex" v-cloak>
							<td>{{purchase_order.purchase_order_id}}</td>
							<td>{{purchase_order.date_ordered}}</td>
							<td>{{purchase_order.supplier_name}}</td>
							<td>{{purchase_order.first_name + " " + purchase_order.last_name}}</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="7" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
				</table>

				<div class="mt-1">
					<nav aria-label="Page navigation example ">
					  <ul class="pagination justify-content-end float-left">
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
					    </li>
					    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.purchase_order_using_id.length / this.show_entries) > 3 ? 3 : Math.ceil(this.purchase_order_using_id.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
					    <li class="page-item">
					      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="nextActiveBeneficiary()">Next</a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>
		<div v-show="showPurchaseOrder">
			<div class="card px-3 pb-1 pt-3">
				<h4>Purchase Order
					<a @click="togglePurchaseOrder" class="btn btn-sm text-light bg-info font-weight-bold ml-2"><i class="fas fa-arrow-left"></i></a>
				</h4>
			</div>

			<div class="card px-3 pb-3 mt-4">
				<div class="float-left mt-4">
					<label class="d-inline-block mr-1 float-left mb-0 mt-1" for="barangay_name" v-if="purchase_order_to_carts.length == 0">Supplier : </label>

					<select @change="retrieveSupplierMedicineInPurchase()" v-model="supplier_name" id="supplier_name" class="form-control form-control-sm col-md-2 float-left" style="width: auto;" v-if="purchase_order_to_carts.length == 0">
						<option disabled value="">Select supplier</option>
						<option v-for="supplier in suppliers" v-if="supplier.supplier_id != '1'" :value="supplier.supplier_name">{{supplier.supplier_name}}</option>
					</select>

					<button @click="showSupplierMedicine" class="btn btn-success btn-sm font-weight-bold float-right" :title="view_Medicine">
						<i class="fas fa-list text-light">&nbsp;</i> View Medicine
					</button>
				</div>

				<table class="table table-hover table-bordered text-center mt-2">		
					<thead class="thead-info">
						<tr class="table-color text-light">
							<th>Medicine Name</th>
							<th>Category</th>
							<th>Unit Category</th>
							<th>Price</th>
							<th>Quantity</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody v-if="purchase_order_to_carts.length > 0">
						<tr v-for="(purchase_order, index) in purchase_order_to_carts" :class="{editing: purchase_order == editedUser}" v-cloak>
							<td>{{purchase_order.medicine_name}}</td>
							<td>{{purchase_order.category}}</td>
							<td>{{purchase_order.unit_category}}</td>
							<td>{{purchase_order.price}}</td>
							<td class="view">{{purchase_order.quantity}}</td>
							<td class="edit"><input type="number" v-on:keypress="isNumber($event)" v-model.number="purchase_order.quantity" class="form-control-sm text-right"></td>
							<td colspan="2">
								<div class="btn-group">
									  <button class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split py-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
									    <i class="fas fa-cog">&nbsp;</i>
									  </button>
								    <div class="dropdown-menu" style="font-size:13px;">
									    <a class="dropdown-item" @click="editData(purchase_order)" :disabled='editDisabled' class="view"><i class="fa fa-edit">&nbsp;</i> Edit</a>
									    <a class="dropdown-item" @click="savePurchaseData(purchase_order.medicine_id)" :title="save_Quantity" class="edit"><i class="fa fa-save">&nbsp;</i> Save</a>
									    <a class="dropdown-item" @click="removePurchaseOrder(index)" :disabled='editDisabled'><i class="fas fa-trash-alt">&nbsp;</i> Delete</a>
									</div>
								</div>
								<!-- <button @click="editData(purchase_order)" :disabled='editDisabled' :title="update_Quantity" class="view btn btn-outline-primary btn-sm" role="group"><i class="fa fa-edit" class="small-box-footer"></i>
						        </button> 
						       
						        <button @click="savePurchaseData(purchase_order.medicine_id)" :title="save_Quantity" class="edit btn btn-outline-primary btn-sm" role="group"><i class="fa fa-save" class="small-box-footer"></i>
						        </button>

								<button @click="removePurchaseOrder(index)" :disabled='editDisabled' :title="delete_Row" class="delete btn btn-outline-danger btn-sm" role="group"><i class="fas fa-trash-alt"></i>
								</button> -->
							</td>
						</tr>
					</tbody>

					<tbody v-else>
						<tr>
							<td colspan="7" style="font-size: 20px"><b>No data to show</b></td>
						</tr>
					</tbody>
				</table>

				<div class="float-right mt-2">
					<button @click="addPurchaseOrder" :disabled='editDisabled' class="btn bg-primary text-light btn-sm font-weight-bold float-right">
						<i class="far fa-save">&nbsp;</i> Save Purchase Order
					</button>
				</div>
				<div class="modal" id="myModal6" data-keyboard="false" data-backdrop="static" class="text-dark" tabindex="1">

				    <div class="modal-dialog modal-lg">
				     	<div class="modal-content">
				     		<div class="modal-header">
				     			<h3>List of Supplier Medicine {{"(" + supplier_medicines.length + ")"}}</h3>
				     			<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
				     		</div>

						  
						    <!-- Modal body -->
							<div class="modal-body" id="modal-medicine">
								<div v-show="supplier_name != ''">
									<div class="float-right mt-4" >
										<div class="input-group form-group">
											<input @input="searchMedcineSupplier" type="text" class="form-control form-control-sm mr-1" v-model="search_supplier_medicine" placeholder="Search Medicine" arial-label="Search">
										</div>
									</div>
								</div>
								
								<table class="table table-hover table-bordered text-center mt-4">
									<thead class="thead-info">
										<tr class="table-color text-light">
											<th>Medicine Name</th>
											<th>Category</th>
											<th>Unit</th>
											<th>Price</th>
											<th>Actions</th>
										</tr>
									</thead>

									<tbody v-if="supplier_medicines.length > 0">
										<tr v-for="(medicine, index) in supplier_medicines" v-if="index >= startIndex && index < endIndex" v-cloak>
											<td>{{medicine.medicine_name}}</td>
											<td>{{identifyMedicineCategory(medicine.category_id)}}</td>
											<td>{{identifyMedicineUnitCategory(medicine.unit_category_id)}}</td>
											<td>{{medicine.price}}</td>
											<td>
												<button @click="purchaseOrderButton(medicine.supplier_medicine_id)" :title="add_Medicine" class="btn btn-outline-success btn-sm" href="#add" data-toggle="modal" data-target="#myModal3" class="small-box-footer"><i class="fas fa-plus"></i></button>
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
									<p class="float-left">Showing {{this.supplier_medicines.length? startIndex + 1 : 0}} to {{endIndex>this.supplier_medicines.length? this.supplier_medicines.length :endIndex}} of {{supplier_medicines.length}} entries</p>

									<nav aria-label="Page navigation example">
									  <ul class="pagination justify-content-end">
									    <li class="page-item">
									      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="previous()">Previous</a>
									    </li>
									    <li class="page-item"><a class="page-link btn btn-sm bg-primary text-light py-1 px-2" v-for="num in Math.ceil(this.supplier_medicines.length / this.show_entries) > 3 ? 3 : Math.ceil(this.supplier_medicines.length / this.show_entries)" @click="pagination(num)" style="display: inline-block">{{num}}</a></li>
									    <li class="page-item">
									      <a class="page-link btn btn-sm text-dark py-1 px-2" @click="next()">Next</a>
									    </li>
									  </ul>
									</nav>
								</div>
								
							</div>

							<div class="modal-footer">
					        	
					    	</div>
						</div> 
					</div>
				</div>

				<div class="modal" data-keyboard="false" data-backdrop="static" id="myModal3" class="text-dark">
					<div class="modal-dialog modal-dialog-centered modal-sm">
		 				<div class="modal-content bg-light">
		      
					        <div class="modal-header">
					          <h4 class="modal-title">Add Purchase Order</h4>
					          	<button type="button" class="btn closing-modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
					        </div>

		        			
							<div class="modal-body mx-auto" id="modal-less-input">
								<label for="purchase_order_medicine_quantity">Quantity</label>
								<div class="input-group form-group">
									<input type="number" @keypress="isNumber($event)" class="form-control" v-model.number="purchase_order_medicine_quantity" placeholder="Enter Quantity" required>
								</div> 
							</div>
					        
							
					        <div class="modal-footer">
					          <button @click="purchaseOrderAddToCart" type="button" class="btn btn-success btn-sm" :disabled="!purchase_order_medicine_quantity || parseInt(purchase_order_medicine_quantity) < 1"><i class="fas fa-shopping-cart">&nbsp;</i> Add to cart</button>
					        </div>
				    	</div>
				 	</div> 
				</div>
			</div>
		</div>
		<div v-show="showPurchaseReceipt">
			<div class="wrapper">
  				<div class="content-wrapper">
    				<div class="container">
			          	<section class="content mt-4">
			            	<div class="row">
				      			<div class="col-md-12">
			                
			                	<div class="box-body">
			                		<table class="table">
			                    		<thead>
			                    			<tr>
			                    				<th colspan="10"><h2 class="float-right font-weight-bold">Purchase Order</h2></th>
			                    			</tr>
			                    			<tr>
			                    				<td colspan="10"><p class="float-right">P.O. Date: &nbsp;&nbsp;<?php echo date("M d, Y");?></p></td>
			                    			</tr> 
			                      			<tr>
						                        <th colspan="8"><h3 class="font-weight-bold">BOTICAB</h3></th>
						                        <th><h6>Purchase Order No:</h6></th>
						                    </tr>
			                      			<tr>
						                        <td colspan="8">F.B. Bailon Street, Cabuyao, Laguna, 4025, Philippines</td>
						                        <th><h6 class="text-danger">{{generatePurchaseOrderID()}}</h6></th>
			                      			</tr>
			                      			<tr>
						                        <td colspan="8">Phone : (047) 578 5192</td>
						                        <td></td>
			                      			</tr>
			                      			<tr>
			                      				<th colspan="7">SUPPLIER</th>
						                        <th colspan="7">SHIP TO</th>
			                      			</tr>
			                      			<tr>
			                      				<th colspan="7">{{supplier_name}}</th>
						                        <th colspan="7">Boticab City of Hall</th>
			                      			</tr>
			                      			<tr>
			                      				<td colspan="7">F.B. Bailon Street, Cabuyao, Laguna, </td>
						                        <td colspan="7">F.B. Bailon Street, Cabuyao, Laguna, </td>
			                      			</tr>
			                      			<tr>
			                      				<td colspan="7">4025, Philippines</td>
						                        <td colspan="7">4025, Philippines</td>
			                      			</tr>
			                      			<tr>
			                      				<td colspan="7">(047) 578 5192</td>
						                        <td colspan="7">(047) 578 5192</td>
			                      			</tr>
			                      
			                    		</thead>
			                  		</table>
			                  		<table class="table table-bordered">
			                    		<thead>
			                        
						                    <tr style="border: solid 1px #000">
						                      	<th>Medicine name</th>
						                        <th>Category</th>
						                        <th>Unit Category</th>
						                        <th>Quantity</th>
						                        <th>Price</th>
						                    </tr>
			                    		</thead>
			                    		<tbody>
					                      	<tr v-for="(purchased_receipt, index) in purchase_order_to_carts">
						                        <td>{{purchased_receipt.medicine_name}}</td>
						                        <td>{{purchased_receipt.category}}</td>
						                        <td>{{purchased_receipt.unit_category}}</td>
						                        <td class="text-right">{{purchased_receipt.quantity}}</td>
						                        <td>{{purchased_receipt.price}}</td>
					                      	</tr>
						                 
						               	</tbody>
			                  		</table>

			                  		<div class="mt-5">
			                  			<label class="font-weight-bold">Prepared by: <u>Admin of City Hall</u></label>
			                  			<label class="float-right font-weight-bold">__________________________________</label><br>
			                  			<label class="font-weight-bold"></label>
			                  			<label class="float-right font-weight-bold mr-4">Receiver's Signature</label>
			                  		</div>
			                	</div>
								</div>  
			            	</div>
			            </section>
			            <div class="mt-3">
			                <a class ="btn btn-primary text-light float-left ml-2" onclick = "window.print()"><i class ="fa fa-print"></i> Print</a>
			            </div>
    				</div>
				</div>
			</div>	
		</div>
	</div>
</div>


<?php include(SHARED_PATH . '/city_hall/admin/purchase_order/purchase_order_footer.php'); ?>