var vm = new Vue({
	el : "#vue-returned-medicine",
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

		returned_medicines : [],
		supplier_medicines : [],
		categories : [],
		unit_categories : [],
		purchase_received_details : [],

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
		/////////////

		// identify methods
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
		identifyMedicinePrice : function(supplier_medicine_id) {
			for(var index = 0; index < this.supplier_medicines.length; index++) {
				if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
					return this.supplier_medicines[index].price;
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
			axios.get(this.urlRoot + this.api + "retrieve_all_city_hall_medicine.php")
			.then(function (response) {
				console.log(response);
				vm.purchase_received_details = response.data;
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
				total += parseInt(this.identifyMedicinePrice(this.returned_medicines[index].supplier_medicine_id)) * parseInt(this.returned_medicines[index].quantity);
			}
			return parseInt(total)  + ".00";
	   	},
	},
	created() {
		this.retrieveReturnedMedicine();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrievePurchaseReceivedDetails();
	}
})