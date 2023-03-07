var vm = new Vue({
	el : "#vue-unavailable-medicine",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/barangay/health_worker/",

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		view_medicine_details : "View Medicine Details",

		unavailable_medicine_list : true,
		unavailable_medicine_details_list : false,
 
		unavailable_medicines : [],

		filter : "",
		search_unavailable_medicine : "",

		supplier_medicines : [],

		categories : [],

		unit_categories : [],

		purchase_received_details : [],

		
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

	   // identify methods
	   identifySupplierMedicineId : function(purchase_received_details_id) {
			for(var index = 0; index < this.purchase_received_details.length; index++) {
				for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
					if(purchase_received_details_id == this.purchase_received_details[index].purchase_received_details_id) {
						if(this.purchase_received_details[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
							return this.supplier_medicines[index1].supplier_medicine_id;
						}
						
					}
				}
				
			}
		},
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
								if(this.supplier_medicines[index1].category_id == this.categories[index2].category_id)
								return this.categories[index2].description;
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
								if(this.supplier_medicines[index1].unit_category_id == this.unit_categories[index2].unit_category_id)
								return this.unit_categories[index2].unit;
							}
							
						}
					}
					
				}
				
			}
		},
		identifyMedicinePrice : function(purchase_received_details_id) {
			for(var index = 0; index < this.purchase_received_details.length; index++) {
				for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
					if(purchase_received_details_id == this.purchase_received_details[index].purchase_received_details_id) {
						if(this.purchase_received_details[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
							return this.supplier_medicines[index1].price;
						}
						
					}
				}
				
			}
		},

		// search method
		searchUnavailableMedicine : function() {
			axios.get(this.urlRoot + this.api + "search_unavailable_medicine.php?filter=" + this.filter + "&keyword=" + this.search_unavailable_medicine)
			.then(function (response) {
				console.log(response);
				vm.unavailable_medicines = response.data;
			});
		},

	    // retrieve methods
	    retrieveUnavailableMedicine : function() {
	    	axios.get(this.urlRoot + this.api + "retrieve_unavailable_medicine_for_display.php")
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
		retrievePurchaseReceivedDetails : function() {
			axios.get(this.urlRoot + this.api + "retrieve_purchase_received_details.php")
			.then(function (response) {
				console.log(response);
				vm.purchase_received_details = response.data;
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
	    	return Math.ceil(this.unavailable_medicines.length / this.show_entries)
	   	},
		totalInventory: function() {
	     	let total = 0;

			for(let index = 0; index < this.unavailable_medicines.length; index++) {
				total += parseInt(this.identifyMedicinePrice(this.unavailable_medicines[index].purchase_received_details_id)) * parseInt(this.unavailable_medicines[index].quantity);
			}
			return parseInt(total)  + ".00";
	   	},
	},
	created() {
		this.retrieveUnavailableMedicine();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrievePurchaseReceivedDetails();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})