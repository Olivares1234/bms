var vm = new Vue({
	el : "#vue-unavailable-medicine",
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

		unavailable_medicine_list : true,
		unavailable_medicine_details_list : false,
 
		unavailable_medicines : [],

		filter : "",
		search_unavailable_medicine : "",

		supplier_medicines : [],

		categories : [],

		unit_categories : [],

		
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
	    //////////////////////

	    // toggle button
	    toggleMedicineDetails : function(supplier_medicine_id) {
			if(this.unavailable_medicine_list == true) {
				this.unavailable_medicine_list = false;
				this.unavailable_medicine_details_list = true;

				this.retrieveMedicineDetails(supplier_medicine_id);
			}
			else {
				this.unavailable_medicine_list = true;
				this.unavailable_medicine_details_list = false;
			}
		},
	    ////////////////

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
		// search methods
		searchUnavailableMedicine : function(filter, keyword) {
			axios.get(this.urlRoot + this.api + "search_unavailable_medicine.php?filter=" + this.filter + "&keyword=" + this.search_unavailable_medicine)
			.then(function (response) {
				console.log(response);
				vm.unavailable_medicines = response.data;
			});
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
		totalInventory: function() {
	     	let total = 0;

			for(let index = 0; index < this.unavailable_medicines.length; index++) {
				total += parseInt(this.identifyMedicinePrice(this.unavailable_medicines[index].supplier_medicine_id)) * parseInt(this.unavailable_medicines[index].received_quantity);
			}
			return parseInt(total)  + ".00";
	   	},
	},
	created() {
		this.retrieveUnavailableMedicine();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})