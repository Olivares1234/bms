var vm = new Vue({
	el : "#vue-available-medicine",
	data : { 
		urlRoot : "/bms/public/",
		api : "api's/barangay/health_worker",

		// available medicine data //
		gulod_medicines : [],
		gulod_available_medicine : true,
		search_gulod_medicine : "",
		gulod_medicine_info_name : "",
		gulod_medicine_info_price : "",
		gulod_medicine_info_category : "",
		gulod_medicine_info_category_unit : "",
		gulod_medicine_info_quantity : "",
		gulod_medicine_info_supplier : "",
		////////////////////////////////

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////
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
		
		//count methods
		countGulodMedicine : function() {
			var count = 0;

			for(var index  = 0; index < this.gulod_medicines.length; index++) {
				count++;
			}

			return count;
		},

		// search methods
		searchGulodMedicine : function() {
			axios.get(this.urlRoot + this.api + "search_medicine.php?keyword=" + this.search_gulod_medicine)
			.then(function (response) {
				vm.gulod_medicines = response.data;
			});
		},

		// retrieve methods
		retrieveGulodMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_active_medicine.php")
			.then(function (response) {
				vm.gulod_medicines = response.data;
			});
		},
	},
	computed : {
		totalGulodInventory: function() {
	     	let total = 0;

			for(let index = 0; index < this.gulod_medicines.length; index++) {
				total += parseInt(this.gulod_medicines[index].price) * parseInt(this.gulod_medicines[index].quantity);
			}
			return parseInt(total)  + ".00";
	   	},
	   },
	   created() {
	   	this.retrieveGulodMedicine();
	   }
})