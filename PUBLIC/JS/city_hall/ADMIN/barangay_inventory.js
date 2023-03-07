var vm = new Vue({
	el : "#vue-inventory",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/admin/",

		barangays : [],

		barangay_inventories : [],

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////
		select_status : "available",
		filter_search : "1",
	},
	methods : {
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
		retrieveBarangays : function() {
	 		axios.get(this.urlRoot + this.api + "retrieve_barangay.php")
	 		.then(response => { 
	 			console.log(response);
	 			vm.barangays = response.data;
	 		});
	 	},
	 	retrieveInventoryPerBarangay : function(filter, barangay_id) {
	 		if(this.select_status && this.filter_search) {
		 		axios.get(this.urlRoot + this.api + "retrieve_inventory_per_barangay.php?filter=" + this.select_status + "&barangay_id=" + this.filter_search)
		 		.then(response => { 
		 			console.log(response);
		 			vm.barangay_inventories = response.data;
		 		});
		 	}
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
	    	return Math.ceil(this.barangay_inventories.length / this.show_entries)
	   	},
	},
	created() {
		this.retrieveBarangays();
		this.retrieveInventoryPerBarangay();

		setInterval(() => {
			this.getSession();
		}, 3000)

	}
});
