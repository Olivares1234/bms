var vm = new Vue({
	el : "#vue-available-medicine",
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

		// title
		view_medicine_details : "View Medicine Details",
		////////

		available_medicine_list : true,
		available_medicine_details_list : false,

		
		filter : "",
		search_available_medicine : "",

		available_medicines : [],

		available_medicine_details : [],

		supplier_medicines : [],

		categories : [],

		unit_categories : [],
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

		/// toggle button
		toggleMedicineDetails : function(supplier_medicine_id) {
			if(this.available_medicine_list == true) {
				this.available_medicine_list = false;
				this.available_medicine_details_list = true;

				this.retrieveMedicineDetails(supplier_medicine_id);
			}
			else {
				this.available_medicine_list = true;
				this.available_medicine_details_list = false;
			}
		},
		/////////////////

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
		searchAvailableMedicine : function(filter, search_available_medicine) {
			axios.get(this.urlRoot + this.api + "search_available_medicine.php?filter=" + this.filter + "&keyword=" + this.search_available_medicine)
			.then(function (response) {
				console.log(response);
				vm.available_medicines = response.data;
			});
		},
		// retrieve methods
		retrieveAvailableMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_available_medicine.php")
			.then(function (response) {
				vm.available_medicines = response.data;
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

			for(let index = 0; index < this.available_medicines.length; index++) {
				total += parseInt(this.identifyMedicinePrice(this.available_medicines[index].supplier_medicine_id)) * parseInt(this.available_medicines[index].received_quantity);
			}
			return parseInt(total)  + ".00";
	   	},
	},
	created() {
		this.retrieveAvailableMedicine();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		
		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})