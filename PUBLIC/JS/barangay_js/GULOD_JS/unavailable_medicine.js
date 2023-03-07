var vm = new Vue({
	el : "#vue-unavailable-medicine",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/gulod_api/",

		// inactive medicine data //
		gulod_inactive_medicines : [],
		gulod_inactive_medicine : true,
		search_gulod_medicine : "",

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

		// retrieve methods
		retrieveGulodInactiveMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_inactive_medicine.php")
			.then(function (response) {
				vm.gulod_inactive_medicines = response.data;
			});
		},

		// count methods
		countGulodInactiveMedicine : function() {
			var count = 0;

			for(var index = 0; index < this.gulod_inactive_medicines.length; index++) {
				count++;
			}
			return count;
		},

		// search methods
		searchGulodUnavailableMedicine : function() {
			axios.get(this.urlRoot + this.api + "search_unavailable_medicine.php?keyword=" + this.search_gulod_medicine)
			.then(function (response) {
				vm.gulod_inactive_medicines = response.data;
				console.log(response);
			});
		},


	},
	computed : {
		totalGulodInventory: function() {
	     	let total = 0;

			for(let index = 0; index < this.gulod_inactive_medicines.length; index++) {
				total += parseInt(this.gulod_inactive_medicines[index].price) * parseInt(this.gulod_inactive_medicines[index].quantity);
			}
			return parseInt(total)  + ".00";
	   	},
	},
	created() {
		this.retrieveGulodInactiveMedicine();
	}
})