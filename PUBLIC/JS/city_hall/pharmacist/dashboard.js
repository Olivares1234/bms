var vm = new Vue({
	el : "#vue-dashboard",
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
		
		request_orders : [],

		purchase_receives : [],

		available_medicines : [],

		unavailable_medicines : [],

		purchase_order_details : [],

		supplier_medicines : [],

		received_medicines : [],

		send_medicines : [],

		categories : [],

		unit_categories : [],

		expired_medicines : []
	},
	methods : {
		// pagination methods
		nextUnavailable: function() {
	      if (this.currentPage < this.totalUnavailable) {
	        this.pagination(this.currentPage + 1);
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
		previous: function() {
	      if (this.currentPage > 1) {
	        this.pagination(this.currentPage - 1);
	      }

	    },
		retrieveRequestOrder : function() {
			axios.get(this.urlRoot + "api's/city_hall/admin/" + "retrieve_request_order.php")
			.then(function (response) {
				console.log(response);
				vm.request_orders = response.data;
			})
		},
		retrievePurchaseReceived : function() {
			axios.get(this.urlRoot + this.api + "retrieve_purchase_received.php")
			.then(function (response) {
				vm.purchase_receives = response.data;
				console.log(response);
			})
		},
		retrieveTotalPurchaseReceived : function() {
			axios.get(this.urlRoot + "api's/city_hall/admin/" + "retrieve_total_purchase_received.php")
			.then(function (response) {
				vm.received_medicines = response.data;
				console.log(response);
			})
		},
		retrieveTotalSendMedicines : function() {
			axios.get(this.urlRoot + this.api + "retrieve_total_send_order.php")
			.then(function (response) {
				vm.send_medicines = response.data;
				console.log(response);
			})
		},
		retrieveSupplierMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_supplier_medicine.php")
			.then(function (response) {
				vm.supplier_medicines = response.data;
				console.log(response);
			})
		},
		retrieveExpiredMedicine : function() {
	    	axios.get(this.urlRoot + this.api + "retrieve_expired_medicine.php")
	    	.then(function (response) {
	    		vm.expired_medicines = response.data;
	    		console.log(response);
	    	});
	    },
		retrieveAvailableMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_available_medicine.php")
			.then(function (response) {
				console.log(response);
				vm.available_medicines = response.data;
			});
		},
		 // identify methods
		ideitifyMedicineName : function(supplier_medicine_id) {
			for(var index = 0; index < this.supplier_medicines.length; index++) {
				if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
					return this.supplier_medicines[index].medicine_name;
				}
			}
		},
		idetifyCategory : function(supplier_medicine_id) {
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
		identifyMedicinePrice : function(supplier_medicine_id) {
			for(var index = 0; index < this.supplier_medicines.length; index++) {
				if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
					return this.supplier_medicines[index].price;
				}
			}
		},
		// retrieve methods
	    retrieveUnavailableMedicine : function() {
	    	axios.get(this.urlRoot + this.api + "retrieve_unavailable_medicine.php")
	    	.then(function (response) {
	    		vm.unavailable_medicines = response.data;
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
		totalStockQuantity :  function() {
			let total = 0;
			for(let i = 0; i < this.available_medicines.length; i++) {
				total += parseFloat(this.available_medicines[i].received_quantity);
			}
			return total;
		},
		totalReceived() {
			let total = 0;
			for(let index = 0; index < this.received_medicines.length; index++) {
				total += parseFloat(this.received_medicines[index].Total_Amount);
			}
		    return total;
		},
		totalSend() {
			let total = 0;
			for(let index = 0; index < this.send_medicines.length; index++) {
				total += parseFloat(this.send_medicines[index].Total_Amount);
			}
		    return total;
		},
		totalInventory: function() {
	     	let total = 0;

			for(let index = 0; index < this.unavailable_medicines.length; index++) {
				total += parseInt(this.identifyMedicinePrice(this.unavailable_medicines[index].supplier_medicine_id)) * parseInt(this.unavailable_medicines[index].received_quantity);
			}
			return parseInt(total)  + ".00";
	   	},
	},
	created() {
		this.retrieveAvailableMedicine();
		this.retrieveUnavailableMedicine();
		this.retrieveRequestOrder();
		this.retrievePurchaseReceived();
		this.retrieveSupplierMedicine();
		this.retrieveTotalPurchaseReceived();
		this.retrieveTotalSendMedicines();
		this.retrieveUnitCategory();
		this.retrieveCategory();
		this.retrieveExpiredMedicine();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}

});