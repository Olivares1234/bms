var vm = new Vue({
	el : "#vue-purchase-received",
	data : {
		urlRoot : "/bms/public/", 
		api : "api's/city_hall/pharmacist/",

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
		purchase_order_details_list : false,
		purchase_received_details_list : false,


		purchase_orders : [],
		purchase_order_id : "",
		purchase_order_details : [],

		purchase_receives : [],
		purchase_received_details : [],

		categories : [],
		unit_categories : [],
		supplier_medicines : [],

		received_quantity_error : false,
		expiration_month_error : false,
		expiration_day_error : false,
		expiration_year_error : false,
		barcode_error : false,

		received_quantity : "",
		expiration_month : "",
		expiration_day : "",
		expiration_year : "",
		barcode : "",

		expiration_month_description : "",
		expiration_day_description : "",
		expiration_year_description : "",
		barcode_description : "",

		supplier_medicine_id : "",

		purchase_details_id : "",

		medicines : [],

		price : "",
		order_quantity : "",
		supplier : "",

		search_purchase_received : "",

		search_purchase_details : "",
		filter : ""
	},
	methods : {
		str_pad : function(n) {
 			return String("00" + n).slice(-2);
		},
		//// pagination methods
		pagination : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries) - this.show_entries;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries);
		},
		previous: function() {
	      if (this.currentPage > 1) {
	        this.pagination(this.currentPage - 1);
	      }
	    },
	    nextPurchaseOrder: function() {
	    	if (this.currentPage < this.totalPurchaseOrder) {
	        	this.pagination(this.currentPage + 1);
	      }
	    },
		///////////////////////

		//// validation method
		isNumber : function(evt, value) {
			evt = (evt) ? evt : window.event;
      		var charCode = (evt.which) ? evt.which : evt.keyCode;

      		if ((charCode > 31 && (charCode < 48 || charCode > 57 || charCode == 189)) || charCode == 46) {
        		evt.preventDefault();;
      		} 
      		else if(value.length > 12) {
      			evt.preventDefault();
      		}
      		else {
        		return true;
      		}
		},
		clearData : function() {
			this.received_quantity = "";
			this.expiration_month = "";
			this.expiration_day = "";
			this.expiration_year = "";
		},
		purchaseReceivedValidation : function() {
			if(this.received_quantity == '') {
				this.received_quantity_error = true;
			}
			else {
				this.received_quantity_error = false;
			}

			if(this.expiration_month == '') {
				this.expiration_month_error = true;
				this.expiration_month_description = "This field is required!";
			}
			else {
				this.expiration_month_error = false;
				this.expiration_month_description = "";
			}

			if(this.expiration_day == '') {
				this.expiration_day_error = true;
				this.expiration_day_description = "This field is required!";
			}
			else if(this.expiration_day.length > 2 || parseInt(this.expiration_day) >= 32) {
				this.expiration_day_error = true;
				this.expiration_day_description = "Invalid day!";
			}
			else {
				this.expiration_day_error = false;
				this.expiration_day_description = "";
			}

			if(this.expiration_year == '') {
				this.expiration_year_error = true;
				this.expiration_year_description = "This field is required!";
			}
			else if(this.expiration_year.length != 4) {
				this.expiration_year_error = true;
				this.expiration_year_description = "Invalid year!";
			}
			else {
				this.expiration_year_error = false;
				this.expiration_year_description = "";
			}

			if(this.barcode.trim == '') {
				this.barcode_error = true;
				this.barcode_description = "This field is required!";
			}
			else if(this.barcode.length != 13) {
				this.barcode_error = true;
				this.barcode_description = "Invalid barcode length!";
			}
			else {
				this.barcode_error = false;
				this.barcode_description = "";
			}
		},
		///////////////////////

		//// toggle buttons
		togglePurchaseOrderDetails : function(purchase_order_id) {
			if(this.purchase_order_list == true) {
				this.purchase_order_list = false;
				this.purchase_order_details_list = true;

				this.purchase_order_id = purchase_order_id

				this.retrievePurchaseOrderDetails(purchase_order_id);
			}
			else {
				this.purchase_order_list = true;
				this.purchase_order_details_list = false;
			}
		},
		togglePurchaseReceivedDetails : function(supplier_medicine_id, price, quantity, supplier_name) {
			if(this.purchase_received_details_list == true) {
				this.purchase_received_details_list = false;
				this.purchase_order_details_list = true;

				
			}
			else {
				this.purchase_received_details_list = true;
				this.purchase_order_details_list = false;

				this.supplier_medicine_id = supplier_medicine_id;
				this.price = price;
				this.order_quantity = quantity;
				this.supplier = supplier_name;
				this.retrievePurchaseReceivedDetails(supplier_medicine_id);
			}
		},
		toggleAddPurchaseReceivedModal : function(purchase_details_id, supplier_medicine_id, quantity, received_quantity) {
			if(quantity == received_quantity) {
				swal({
					title : "Error!",
					text : "Purchase received completed!",
					icon : "error",
					buttons : false,
					closeOnClickOutside : false,
					timer : 1000
				});
			}
			else {
				$('#myModal3').modal('show');
				this.supplier_medicine_id = supplier_medicine_id;
				this.purchase_details_id = purchase_details_id;
			}
		},
		closePurchasReceivedModal : function() {
			$('#myModal3').modal('hide');
		},
		///////////////////

		//// identify methods
		identifyMedicineName : function(supplier_medicine_id) {
			for(var index = 0; index < this.supplier_medicines.length; index++) {
				if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
					return this.supplier_medicines[index].medicine_name;
				}
			}
		},
		identifyCategory : function(supplier_medicine_id) {
			for(var index = 0; index < this.supplier_medicines.length; index++) {
				for(var index1 = 0; index1 < this.categories.length; index1++) {
					if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
						if(this.supplier_medicines[index].category_id == this.categories[index1].category_id) {
							return this.categories[index1].description;
						}
					}
				}
			}	
		},
		identifyUnitCategory : function(supplier_medicine_id) {
			for(var index = 0; index < this.supplier_medicines.length; index++) {
				for(var index1 = 0; index1 < this.unit_categories.length; index1++) {
					if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
						if(this.supplier_medicines[index].unit_category_id == this.unit_categories[index1].unit_category_id) {
							return this.unit_categories[index1].unit;
						}
					}
				}
			}
		},
		/////////////////////

		generatePurchaseReceivedId : function() {
			var id = "";
			var pad = "0000";

			var date = new Date();

			if(this.purchase_receives.length == 0) {
				id = "PR" + date.getUTCFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate())  + "0001";
			}
			else {
				for(var index = 0; index < this.purchase_receives.length; index++) {
					id = this.purchase_receives[index].purchase_received_id;
				}
				id = id.slice(10);
				id = pad.substring(0, pad.length - id.length) + id;
				id = date.getUTCFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + id;
				id = parseInt(id) + 1;
				id = "PR" + id;
			}
			return id;
		},

		//// retrieve methods
		retrievePurchaseOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_purchase_order.php")
			.then(function (response) {
				vm.purchase_orders = response.data;
				console.log(response);
			});
		},
		retrievePurchaseOrderDetails : function(purchase_order_id) {
			axios.get(this.urlRoot + this.api + "retrieve_purchase_order_details.php?purchase_order_id=" + purchase_order_id)
			.then(function (response) {
				vm.purchase_order_details = response.data;
				console.log(response);
			});
		},
		retrieveSupplierMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_supplier_medicine.php")
			.then(function (response) {
				vm.supplier_medicines = response.data;
				console.log(response);
			});
		},
		retrieveCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_category.php")
			.then(function (response) {
				vm.categories = response.data;
				console.log(response);
			});
		},
		retrieveUnitCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_unit_category.php")
			.then(function (response) {
				vm.unit_categories = response.data;
				console.log(response);
			})
		},
		retrievePurchaseReceived : function() {
			axios.get(this.urlRoot + this.api + "retrieve_purchase_received.php")
			.then(function (response) {
				vm.purchase_receives = response.data;
				console.log(response);
			})
		},
		retrieveMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_medicine.php")
			.then(function (response) {
				vm.medicines = response.data;
				console.log(response);
			});
		},
		retrievePurchaseReceivedDetails : function(supplier_medicine_id) {
			axios.get(this.urlRoot + this.api + "retrieve_purchase_received_details.php?purchase_order_id=" + this.purchase_order_id + "&supplier_medicine_id=" + supplier_medicine_id)
			.then(function (response) {
				vm.purchase_received_details = response.data;
				console.log(response);
			});
		},
		/////////////////////
		savePurchaseReceived : function() {
			this.purchaseReceivedValidation();

			if(this.received_quantity_error == false && this.expiration_month_error == false && this.expiration_day_error == false && this.expiration_year_error == false && this.barcode_error == false) {
				for(var index = 0; index < this.purchase_order_details.length; index++) {
					if(this.supplier_medicine_id == this.purchase_order_details[index].supplier_medicine_id) {
						var quantity = parseInt(this.purchase_order_details[index].received_quantity) + parseInt(this.received_quantity);
						if(quantity > this.purchase_order_details[index].quantity) {
							swal({
								title : "Error!",
								text : "Received quantity cannot be more than order quantity!",
								icon : "error",
								buttons : false,
								closeOnClickOutside : false,
								timer : 1000
							})
						}
						else {
							this.addPurchaseReceived();
						}
					}
				}
			}
		},
		addPurchaseReceived : function() {
			var date = new Date();

			axios.post(this.urlRoot + this.api + "add_purchase_received.php", {
				purchase_received_id : this.generatePurchaseReceivedId(),
				purchase_order_id : this.purchase_order_id,
				date_received : date.getUTCFullYear() + "-" + this.str_pad(date.getMonth() + 1) + "-" + this.str_pad(date.getDate())
			}).then(function (response) {
				console.log(response);
				vm.addPurchaseReceivedDetails();
			})
		},
		addPurchaseReceivedDetails : function() {
			axios.post(this.urlRoot + this.api + "add_purchase_received_details.php", {
				supplier_medicine_id : this.supplier_medicine_id,
				received_quantity : this.received_quantity,
				expiration_date : this.expiration_year + "-" + this.str_pad(this.expiration_month) + "-" + this.str_pad(this.expiration_day),
				status : "Active",
				barcode : this.barcode
			}).then(function (response) {
				console.log(response);
				vm.updatePurchaseDetails();
			})
		},
		updatePurchaseDetails : function() {
			axios.post(this.urlRoot + this.api + "update_purchase_details.php", {
				supplier_medicine_id : this.supplier_medicine_id,
				purchase_details_id : this.purchase_details_id,
				purchase_order_details : this.purchase_order_details,
				received_quantity : this.received_quantity,
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Good Job!",
					text : "Purchase received successfully!",
					icon : "success",
					buttons : false,
					closeOnClickOutside : false,
					timer : 1000
				}).then(() => {
					vm.clearData();
					vm.retrievePurchaseOrderDetails(vm.purchase_order_id);
					$("#myModal3").modal("hide");
				})
			})
		},
		searchPurchaseReceived : function(keyword) {
			axios.get(this.urlRoot + this.api + "search_purchase_received.php?keyword=" + this.search_purchase_received)
			.then(function (response) {
				console.log(response);
				vm.purchase_orders = response.data;
			})
		},
		searchPurchaseReceivedDetails : function(purchase_order_id, filter, keyword) {
			axios.get(this.urlRoot + this.api + "search_purchase_received_details.php?purchase_order_id=" + this.purchase_order_id + "&filter=" + this.filter + "&keyword=" + this.search_purchase_details)
			.then(function (response) {
				console.log(response);
				vm.purchase_order_details = response.data;
			})
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
	created() {
		this.retrievePurchaseOrder();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrievePurchaseReceived();
		this.retrieveMedicine();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})