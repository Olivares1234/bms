var vm = new Vue({
	el : "#vue-referral",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/barangay/health_worker/",

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		////// end of pagination /////////

		// titles
		add_referral : "Add referral",
		/////////

		beneficiary_list : true,

		beneficiaries : [],

		search_beneficiary : "",
		filter : "",

		view_referral : false,

		 beneficiary_id : "",
		 beneficiary_first_name : "",
		 beneficiary_last_name : ""
	},
	methods : {
		// for pagination
		showEntries : function(value) {
         	this.endIndex = value;
         	this.pagination(1);
		},
		pagination : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries) - this.show_entries;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries);
		},
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
		//////////////

		// search method
		searchBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "search_beneficiary.php?filter=" + this.filter + "&keyword=" + this.search_beneficiary)
			.then(function (response) {
				console.log(response);
				vm.beneficiaries = response.data;
			})
		},
		////////////////

		// toggle button
		toggleReferral : function(id, first_name, last_name) {
			$("#myModal2").modal('show');
			this.beneficiary_id = id
			this.beneficiary_first_name = first_name
			this.beneficiary_last_name = last_name
		},
		////////////////

		// retrieve method
		retrieveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary.php")
			.then(function (response) {
				vm.beneficiaries = response.data;
				console.log(response);
			})
		},
		viewReferral : function() {
			if (this.view_referral == false) {
				$('#myModal2').modal('hide');
				swal({
					title : "Great Job!",
					text : "Refer of beneficiary successfully!",
					icon : "success",
					timer : 3000,
					buttons : false,
					closeOnClickOutside : false
				}).then(() => {
					vm.view_referral = true;
					vm.beneficiary_list = false;
					
				});
				
			} else {
				this.view_referral = false;
				this.beneficiary_list = true;
			}
		},
		getSession : function() {
			axios.get(this.urlRoot + this.api + "get_session.php")
			.then(function (response) {
				console.log(response);

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
	    	return Math.ceil(this.beneficiaries.length / this.show_entries)
	   	},
    },
	created() {
		this.retrieveBeneficiary();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})