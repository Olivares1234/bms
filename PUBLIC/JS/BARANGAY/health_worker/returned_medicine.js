var vm = new Vue({
	el : "#vue-returned-medicine",
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

		returned_medicine_list : true,

		returned_medicines : [],
		supplier_medicines : [],
		categories : [],
		unit_categories : [],
		purchase_received_details : [],
		received_order_details : [],

		filter : "",
		search_returned_medicine : ""
	},
	methods : {
		// pagination methods
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
		///////////////////

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
		//////////////////

		// retrieve method
		retrieveReturnedMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_returned_medicine.php")
			.then(function (response) {
				vm.returned_medicines = response.data;
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
		retrieveReceivedOrderDetails : function() {
			axios.get(this.urlRoot + this.api + "retrieve_all_received_order_details.php")
			.then(function (response) {
				console.log(response);
				vm.received_order_details = response.data;
			});
		},
		searchReturnedMedicine : function() {
			axios.get(this.urlRoot + this.api + "search_returned_medicine.php?filter=" + this.filter + "&keyword=" + this.search_returned_medicine)
			.then(function (response) {
				console.log(response);
				vm.returned_medicines = response.data;
			});
		}
		//////////////////
	},
	computed : {
		totalInventory: function() {
	     	let total = 0;

			for(let index = 0; index < this.returned_medicines.length; index++) {
				total += parseInt(this.identifyMedicinePrice(this.returned_medicines[index].purchase_received_details_id)) * parseInt(this.returned_medicines[index].quantity);
			}
			return parseInt(total)  + ".00";
	   	},
	},
	created() {
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrievePurchaseReceivedDetails();
		this.retrieveReceivedOrderDetails();
		this.retrieveReturnedMedicine();
	}
})