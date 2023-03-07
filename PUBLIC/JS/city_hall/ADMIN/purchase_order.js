var vm = new Vue({
	el : "#vue-purchase-order",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/admin/",

		// titles
		update_Quantity : "Update Quantity",
		save_Quantity : "Save Quantity",
		delete_Row : "Delete Row",

		view_Medicine : "View Medicine",
		add_Medicine : "Add Medicine",
		/////////

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		purchase_order_list : true,
		editDisabled : false,
		showPurchaseReceipt : false,
		editedUser : null,

		showPurchaseOrder : false,
		purchase_order_to_carts : [],
		add_purchase_orders : {
			medicine_id : null,
			medicine_name : null,
			category : null,
			unit_category : null,
			quantity : null,
			price : null,
			supplier : null
		},

		purchase_order_medicine_id : "",
		purchase_order_medicine_quantity : 1,

		suppliers : [],
		supplier_name : "",

		supplier_medicines : [],

		purchase_order_using_id : [],

		purchase_orders : [],

		unit_categories : [],

		categories : [],

		search_supplier_medicine : ""

		
	},
	methods : {
		str_pad : function(n) {
 			return String("00" + n).slice(-2);
		},
		isNumber : function(evt) {
			evt = (evt) ? evt : window.event;
      		var charCode = (evt.which) ? evt.which : evt.keyCode;

      		if ((charCode > 31 && (charCode < 48 || charCode > 57 || charCode == 189)) || charCode == 46) {
        		evt.preventDefault();
      		} 
      		else {
        		return true;
      		}
		},
		next: function() {
	      if (this.currentPage < this.totalPages) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    previous: function() {
	      if (this.currentPage > 1) {
	        this.pagination(this.currentPage - 1);
	      }

	    },
	    showEntries : function(value) {
         	this.endIndex = value;
         	this.pagination(1);
		},
		pagination : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries) - this.show_entries;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries);
		},
		editData : function (transaction) {
		    this.editDisabled = true;
		    this.beforEditCache = transaction;
		    this.editedUser = transaction;
   		},
   		savePurchaseData : function (medicine_id) {
    		this.editDisabled = false;
			this.editUser = null;
			this.beforEditCache = null;
			this.editedUser = null;
			swal("Congrats!", "Successfully Update", "success");
    		
    	},
    	removePurchaseOrder : function(index) {
    		this.purchase_order_to_carts.splice(index, 1);
    	},

		// toggle button
		showSupplierMedicine : function() {
			if(this.supplier_name == "") {
				swal({
					title : "Warning",
					text : "Select supplier first!",
					icon : "warning",
					timer : "1000",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					$('#myModal6').modal('hide');
				});
				
			}
			else {
				$('#myModal6').modal('show');
			}
		},
		purchaseOrderButton : function(id){
			this.purchase_order_medicine_id = id;
		},
		togglePurchaseOrder : function() {
			if(this.purchase_order_list == true) {
				this.purchase_order_list = false;
				this.showPurchaseOrder = true;
			}
			else {
				this.purchase_order_list = true;
				this.showPurchaseOrder = false;
			}
		},
		////////////////

		// identify methods
		identifyMedicineCategory : function(category_id) {
			for(var index = 0; index < this.categories.length; index++) {
				if(category_id == this.categories[index].category_id) {
					return this.categories[index].description;
				}
			}
		},
		identifyMedicineUnitCategory : function(unit_category_id) {
			for(var index = 0; index < this.unit_categories.length; index++) {
				if(unit_category_id == this.unit_categories[index].unit_category_id) {
					return this.unit_categories[index].unit;
				}
			}
		},

		// retrieve methods
		retrievePurchaseOrder : function() {
			axios({
				method : "GET",
				url : this.urlRoot + this.api + "retrieve_purchase_order.php"
			}).then(function (response){
				vm.purchase_order_using_id = response.data;
			});
		},
		retrieveSupplierMedicineInPurchase : function() {

			for(var index = 0; index < this.suppliers.length; index++) {
				if(this.suppliers[index].supplier_name === this.supplier_name) {
					this.supplier_id = this.suppliers[index].supplier_id;
					break;
				}
			}
			this.retrieveSupplierMedicine(this.supplier_id);
		},

		retrieveSupplier : function() {
			axios.get(this.urlRoot + this.api + "retrieve_supplier.php")
			.then(function (response) {
				console.log(response);
				vm.suppliers = response.data;
			})
		},
		retrieveSupplierMedicine : function(supplier_id) {
			axios.get(this.urlRoot + this.api + "retrieve_supplier_medicine.php?supplier_id=" + supplier_id)
			.then(function (response) {
				vm.supplier_medicines = response.data;
				console.log(response);
			});
		},
		retrieveUnitCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_unit_category.php")
			.then(function (response) {
				vm.unit_categories = response.data;
			});
		},
		retrieveCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_category.php")
			.then(function (response) {
				vm.categories = response.data;
			});
		},
		/////////////////////

		purchaseOrderAddToCart : function() {

			var found1 = true;
			var found2 = false;

			for(var index = 0; index < this.supplier_medicines.length; index++) {
				if(this.purchase_order_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
					this.add_purchase_orders.medicine_id = this.supplier_medicines[index].supplier_medicine_id;
					this.add_purchase_orders.medicine_name = this.supplier_medicines[index].medicine_name;
					this.add_purchase_orders.category = this.identifyMedicineCategory(this.supplier_medicines[index].category_id);
					this.add_purchase_orders.unit_category = this.identifyMedicineUnitCategory(this.supplier_medicines[index].unit_category_id);
					this.add_purchase_orders.price = this.supplier_medicines[index].price;
					this.add_purchase_orders.quantity = this.purchase_order_medicine_quantity;
					this.add_purchase_orders.supplier = this.supplier_medicines[index].supplier_name;
				}
			}

			for(var index1 = 0; index1 < this.purchase_order_to_carts.length; index1++) {
				if (this.add_purchase_orders.medicine_id == this.purchase_order_to_carts[index1].medicine_id) {
					var quantity = parseInt(this.add_purchase_orders.quantity) + parseInt(this.purchase_order_to_carts[index1].quantity);

					found1 = false;
					found2 = true;

					this.purchase_order_to_carts[index1].quantity = quantity;
				}
			}

			if(found1) {
				this.purchase_order_to_carts.push({...this.add_purchase_orders});
				$("#myModal6").modal("show");
				$("#myModal3").modal("hide");
			}

			if(found2) {
				$("#myModal6").modal("show");
				$("#myModal3").modal("hide");
			}
			this.purchase_order_medicine_quantity = 1;
		},
		generatePurchaseOrderID : function() {
			var  id = "";
			var pad = "0000";
			var date = new Date();

			if(this.purchase_order_using_id.length <= 0) {
				id = "PO" +  date.getUTCFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + "0001";
			}
			else {
				for(var index = 0; index < this.purchase_order_using_id.length; index++) {
					id = this.purchase_order_using_id[index].purchase_order_id;

				}

				id = id.slice(10);
				id = pad.substring(0, pad.length - id.length) + id;
				id = date.getUTCFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + id;
				id = parseInt(id) + 1;
				id = "PO" + id;
			}
			return id;
		},

		addPurchaseOrder : function() {
			var date = new Date();

			if(this.purchase_order_to_carts.length == 0) {
				swal({
					title : "Error!",
					text : "No medicine/s to purchase",
					icon : "error",
					timer : "1000",
					buttons : false,
					closeOnClickOutside: false
				});
			}
			else {
				axios.post(this.urlRoot + this.api + "add_purchase_order.php", {
					purchase_order_id : this.generatePurchaseOrderID(),
					date_ordered : date.getUTCFullYear() + "-" + this.str_pad(date.getMonth() + 1) + "-" + this.str_pad(date.getDate())
				}).then(function (response) {
					console.log(response);
					vm.addPurchaseOrderDetails();
				});
			}
		},
		addPurchaseOrderDetails : function() {
			axios.post(this.urlRoot + this.api + "add_purchase_order_details.php", {
				purchase_order_to_carts : this.purchase_order_to_carts
			}).then(function (response) {
				console.log(response);
				vm.addPurchaseDetails();
			});
		},
		addPurchaseDetails : function() {
			axios.post(this.urlRoot + this.api + "add_purchase_details.php", {
				purchase_order_to_carts : this.purchase_order_to_carts
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Success!",
					text : "Purchase order successfully!",
					icon : "success",
					timer : "1000",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.showPurchaseReceipt = true;
					vm.showPurchaseOrder = false;
				});
			});
		},
		searchMedcineSupplier : function(supplier_id, keyword) {
			axios.post(this.urlRoot + this.api + "search_supplier_medicine.php?supplier_id=" + this.supplier_id + "&keyword=" + this.search_supplier_medicine)
			.then(function (response) {
				vm.supplier_medicines = response.data;
				console.log(response);
			});
		},
		getSession : function() {
			axios.get(this.urlRoot + this.api + "get_session.php")
			.then(function (response) {
				if(response.data == "") {
					
					swal({
						title : "Session expired!",
						text : "Please login to continue!",
						icon : "info",
						buttons : false,
						closeOnClickOutside : false,
						timer : 2000
					}).then(() => {
						window.location = '../../../../../bms/public/login/index.php';
					});
				}
			})
		},
	},
	computed : {
		totalPages: function() {
	    	return Math.ceil(this.supplier_medicines.length / this.show_entries)
	   	},
	},
	created() {
		this.retrieveSupplier();
		this.retrievePurchaseOrder();
		this.retrieveUnitCategory();
		this.retrieveCategory();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})