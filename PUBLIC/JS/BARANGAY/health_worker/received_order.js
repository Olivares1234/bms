 var vm = new Vue({
	el : "#vue-received-order",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/barangay/health_worker/",

		// titles
		view_Order : "View Order",

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		send_order_info : true,
		search_send_order : "",

		filter : "",
		search_send_order_details : "",

		accept_order_details : false,

		send_orders : [],

		received_order_details : [],

		send_details : [],

		received_order_quantity : "",
		expiration_month : "",
		expiration_day : "",
		expiration_year : "",
		barcode : "",

		expiration_month_description : "",
		expiration_day_description : "",
		expiration_year_description : "",
		barcode_description : "",

		received_order_quantity_description : "",

		received_order_quantity_error : false,
		expiration_month_error : false,
		expiration_day_error : false,
		expiration_year_error : false,
		barcode_error  : false,

		received_orders : [],

		send_order_id : "",

		supplier_medicine_id : "",

		supplier_medicines : [],

		categories : [],

		unit_categories : [],

		purchase_received_details : [],

		purchase_received_details_id : "",
	}, 
	methods : {
		str_pad : function(n) {
 			return String("00" + n).slice(-2);
		},
		//received order clear data
		clearReceivedOrder : function() {
			this.received_order_quantity = "";
			this.expiration_month = "";
			this.expiration_day = "";
			this.expiration_year = "";
			this.barcode = "";


			this.expiration_month_error = false;
			this.expiration_day_error = false;
			this.expiration_year_error = false;
			this.barcode_error  = false;
		},
 
		//received order validation
		receivedOrderValidation : function() {
			if(this.received_order_quantity == "") {
				this.received_order_quantity_error = true;
				this.received_order_quantity_description = "This field is required!";
			}
			else {
				this.received_order_quantity_error = false;
				this.received_order_quantity_description = "";
			}

			if(this.barcode == "") {
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
		},

		// medicine validation
		checkMedicineIfExist : function(supplier_medicine_id) {
			for(var index = 0; index < this.medicines.length; index++) {
				if(supplier_medicine_id == this.medicines[index].supplier_medicine_id) {
					return false;
				}
			}
		},
		/////////////////////

		// input type
		isNumber : function(evt, value) {
			evt = (evt) ? evt : window.event;
      		var charCode = (evt.which) ? evt.which : evt.keyCode;

      		if ((charCode > 31 && (charCode < 48 || charCode > 57 || charCode == 189)) || charCode == 46) {
        		evt.preventDefault();
      		}
      		else if(value.length > 12) {
      			evt.preventDefault();
      		}
      		else {
        		return true;
      		}
		},

		// pagination methods
		showEntries : function(value) {
         	this.endIndex = value;
         	this.pagination(1);
		},
		showEntries_two : function(value) {
         	this.endIndex = value;
         	this.pagination_two(1);
		},
		pagination : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries) - this.show_entries;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries);
		},
		pagination_two : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries_two) - this.show_entries_two;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries_two);
		},
		nextSendOrderDetails : function() {
	      if (this.currentPage < this.totalSendOrderDetails) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    nextSendOrder : function() {
			if (this.currentPage < this.totalSendOrder) {
	        this.pagination(this.currentPage + 1);
	      }
		},
		previous: function() {
	      if (this.currentPage > 1) {
	        this.pagination(this.currentPage - 1);
	      }

	    },
	    ///////////////

	    // identify method
	    identifyMedicineName : function(purchase_received_details_id) {
	    	for(var index = 0; index < this.purchase_received_details.length; index++) {
	    		for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
	    			if(purchase_received_details_id == this.purchase_received_details[index].purchase_received_details_id) {
	    				if(this.purchase_received_details[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
	    					return this.supplier_medicines[index1].medicine_name;
	    				}
	    			}
	    		}
	    	}
	    },
	    identifyCategoryName : function(purchase_received_details_id) {
	    	for(var index = 0; index < this.purchase_received_details.length; index++) {
	    		for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
	    			for(var index2 = 0; index2 < this.categories.length; index2++) {
	    				if(purchase_received_details_id == this.purchase_received_details[index].purchase_received_details_id) {
	    					if(this.purchase_received_details[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
	    						if(this.supplier_medicines[index1].category_id == this.categories[index2].category_id) {
	    							return this.categories[index2].description;
	    						}
	    					}
	    				}
	    			}
	    			
	    		}
	    	}
	    },
	    identifyUnitCategoryName : function(purchase_received_details_id) {
	    	for(var index = 0; index < this.purchase_received_details.length; index++) {
	    		for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
	    			for(var index2 = 0; index2 < this.unit_categories.length; index2++) {
	    				if(purchase_received_details_id == this.purchase_received_details[index].purchase_received_details_id) {
	    					if(this.purchase_received_details[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
	    						if(this.supplier_medicines[index1].unit_category_id == this.unit_categories[index2].unit_category_id) {
	    							return this.unit_categories[index2].unit;
	    						}
	    					}
	    				}
	    			}
	    			
	    		}
	    	}
	    },
	    //////////////////

		// search methods
		searchSendOrder : function() {
    		axios.get(this.urlRoot + this.api + "search_send_order.php?keyword=" + this.search_send_order)
    		.then(function (response) {
    			vm.send_orders = response.data;
    			console.log(response);
    		});
    	},
    	searchSendOrderDetails : function() {
    		axios.get(this.urlRoot + this.api + "search_send_details.php?filter=" + this.filter + "&keyword=" + this.search_send_order_details + "&send_order_id=" + this.send_order_id)
    		.then(function (response) {
    			vm.send_details = response.data;
				console.log(response);
    		});
    	},

    	// retrieve methods
    	retrieveSendOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_send_order.php")
			.then(function (response) {
				vm.send_orders = response.data;
				console.log(response);
			});
		},
		retrieveSendDetails : function(send_order_id) {
			axios.get(this.urlRoot + this.api + "retrieve_send_details.php?send_order_id=" + send_order_id)
			.then(function (response) {
				vm.send_details = response.data;
				console.log(response);
			});
		},
		retrieveReceivedOrderDetails : function(send_order_id, purchase_received_details_id) {
			axios.post(this.urlRoot + this.api + "retrieve_received_order_details.php?send_order_id=" + send_order_id + "&purchase_received_details_id=" + purchase_received_details_id)
			.then(function (response) {
				vm.received_order_details = response.data;
				console.log(response);
			});
		},
		retrieveReceivedOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_received_order.php")
			.then(function (response) {
				vm.received_orders = response.data;
				console.log(response);
			});
		},
		retrievePurchaseReceivedDetails : function() {
			axios.get(this.urlRoot + this.api + "retrieve_purchase_received_details.php")
			.then(function (response) {
				vm.purchase_received_details = response.data;
				console.log(response);
			});
		},
		retrieveSupplierMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_supplier_medicine.php")
			.then(function (response) {
				vm.supplier_medicines = response.data;
				console.log(response);
			})
		},
		retrieveCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_category.php")
			.then(function (response) {
				console.log(response);
				vm.categories = response.data;
			});
		},
		retrieveUnitCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_unit_category.php")
			.then(function (response) {
				console.log(response);
				vm.unit_categories = response.data;
			});
		},

		// toggle buttons
		toggleRequestOrderDetailsInfo : function(id) {
			if (this.send_order_info == false) {
				this.send_order_info = true;
			} else {
				this.send_order_info = false;
			}

			this.send_order_id = id;

			this.retrieveSendDetails(id);
		},
		closeAddReceivedOrder : function() {
			this.received_order_quantity = "";
			this.received_order_expiration_date = "";
			$('#myModal3').modal('hide');
		},
		toggleReceivedOrderDetails : function (send_order_id, purchase_received_details_id) {
			if (this.accept_order_details == false) {
				this.send_order_info = false;
				this.accept_order_details = true;
				
				this.retrieveReceivedOrderDetails(send_order_id, purchase_received_details_id);

			}
			else {
				this.accept_order_details = false;
			}

		},
		toggleReceivedOrder : function(purchase_received_details_id, quantity, send_details_id, received_quantity) {
			this.purchase_received_details_id = purchase_received_details_id;
			this.received_orders_quantity = quantity;
			this.send_details_id = send_details_id;
			this.received_order_received_quantity = received_quantity;
			if(quantity == "No stock") {
				swal("Cannot add", " Nothing to add!", "warning"); // paayos ng message
			}
			else {
				$('#myModal3').modal('show');
			}

		},

		// generate id
		generateReceivedOrderId : function() {
			var id = "";
    		var pad = "0000";
    		var date = new Date();

    		if(this.received_orders.length <= 0) {
    			id = "RCO" + date.getFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + "0001";
    		}
    		else {
    			for(var index = 0; index < this.received_orders.length; index++) {

    				id = this.received_orders[index].received_order_id;
    			}
	    		id = id.slice(11);
	    		id = pad.substring(0, pad.length - id.length) + id;
	    		id = date.getFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + id;
	    		id = parseInt(id) + 1;
	    		id = "RCO" + id;
	    	}

	    	return id;

		},
 
		/////
		saveReceivedOrder : function() {
			this.receivedOrderValidation();
			if(this.received_order_quantity_error == false && this.expiration_month_error == false && this.expiration_day_error == false && this.expiration_year_error == false && this.barcode_error == false) {
				if((parseInt(this.received_order_received_quantity) + parseInt(this.received_order_quantity)) > this.received_orders_quantity) {
					this.received_order_quantity_error = true;
					this.received_order_quantity_description = "cannot be more than order quantity!"
				}
				else {
					this.addReceivedOrder();
				}
			}
			
		},
		addReceivedOrder : function() {
			var date = new Date();
			axios.post(this.urlRoot + this.api + "add_received_order.php", {
				received_order_id : this.generateReceivedOrderId(),
				send_order_id : this.send_order_id,
				date_received : date.getUTCFullYear() + "-" + this.str_pad(date.getMonth() + 1) + "-" + this.str_pad(date.getDate()),
			}).then(function (response) {
				console.log(response);
				vm.addReceivedOrderDetails();
			});
		},
		addReceivedOrderDetails : function() {
			axios.post(this.urlRoot + this.api + "add_received_order_details.php", {
				purchase_received_details_id : this.purchase_received_details_id,
				quantity : this.received_order_quantity,
				expiration_month :this.str_pad(this.expiration_month),
				expiration_day : this.str_pad(this.expiration_day),
				expiration_year : this.expiration_year,
				status : "Active",
				barcode : this.barcode
			}).then(function (response) {
				console.log(response);
				if(response.status == 200) {
					vm.updateSendDetails();
				}
				else {
					vm.received_order_quantity_error = response.data.received_order_quantity_error;
					vm.received_order_expiration_date_error = response.data.received_order_expiration_date_error;
					vm.expiration_year_error = response.data.expiration_year_error;
					vm.expiration_day_error = response.data.expiration_day_error;
					vm.expiration_month_error = response.data.expiration_month_error;
				}
			});
		},
		updateSendDetails : function() {
			axios.post(this.urlRoot + this.api + "update_send_details.php", {
				send_details_id : this.send_details_id,
				previos_received_quantity : this.received_order_received_quantity,
				received_quantity : this.received_order_quantity
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Good Job!",
					text : "Received order successfully!",
					icon : "success",
					timer : "3000",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveSendDetails(vm.send_order_id);
					vm.clearReceivedOrder();

					vm.received_order_quantity_error = false;
					vm.received_order_expiration_date_error = false;
					vm.expiration_year_error = false;
					vm.expiration_day_error = false;
					vm.expiration_month_error = false;

					$('#myModal3').modal('hide');
				});
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
		totalSendOrder: function() {
	    	return Math.ceil(this.send_orders.length / this.show_entries)
	   	},
	   	totalSendOrderDetails: function() {
	    	return Math.ceil(this.send_details.length / this.show_entries_two)
	   	}
	},
	created() {
		this.retrieveSendOrder();
		this.retrieveReceivedOrder();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrievePurchaseReceivedDetails();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})