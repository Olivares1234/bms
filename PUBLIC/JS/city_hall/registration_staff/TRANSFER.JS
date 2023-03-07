var vm = new Vue({
	el : "#vue-transfer",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/registration_staff/transfer/",

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		////// end of pagination /////////

		barangays : [],
		beneficiaries : [],

		barangay : "",
		beneficiary_id : "",

		barangay_error : false,

		search_beneficiary : "",
		filter : "",

	},
	methods : {
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
	    //////////////

	    // toggle button
	    toggleTransferBeneficiaryModal : function(beneficiary_id) {
	    	this.beneficiary_id = beneficiary_id;
	    	this.barangay = "";
	    	this.barangay_error = false;
	    	$('#myModal').modal('show');
	    },
	    ////////////////

	    // identify method
	    identifyBarangayName : function(barangay_id) {
	    	for(var index = 0; index < this.barangays.length; index++) {
	    		if(barangay_id == this.barangays[index].barangay_id) {
	    			return this.barangays[index].barangay_name;
	    		}
	    	}
	    },
	    identifyBarangayId : function(barangay_name) {
	    	for(var index = 0; index < this.barangays.length; index++) {
	    		if(barangay_name == this.barangays[index].barangay_name) {
	    			return this.barangays[index].barangay_id;
	    		}
	    	}
	    },
	    //////////////////

	    // retrieve method
	    retrieveBarangay : function() {
			axios.get(this.urlRoot + this.api + "retrieve_barangay.php")
			.then(function (response) {
				vm.barangays = response.data;
				console.log(response);
			});
		},
		retrieveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary.php")
			.then(function (response) {
				console.log(response);
				vm.beneficiaries = response.data;

			});
		},
		///////////
		transferBeneficiary : function() {
			if(this.barangay.trim() == '') {
				this.barangay_error = true;
			}
			else {
				this.barangay_error = false;
			}

			if(this.barangay_error == false) {
				axios.post(this.urlRoot + this.api + "transfer_beneficiary.php", {
					beneficiary_id : this.beneficiary_id,
					barangay_id : this.identifyBarangayId(this.barangay)
				}).then(function (response) {
					console.log(response);
					swal({
						title : "Great Job!",
						text : "Beneficiary transfer successfully!",
						icon : "success",
						timer : 2050,
						buttons : false,
						closeOnClickOutside : false
					}).then(() => {
						vm.retrieveBeneficiary();
						vm.barangay = "";
						vm.barangay_error = false;
						$('#myModal').modal('hide');
					});
				})
			}
		},
		///////////
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

	},
	created() {
		this.retrieveBarangay();
		this.retrieveBeneficiary();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
});