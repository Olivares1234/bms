var vm = new Vue({
	el : "#vue-pwd",
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
		choose_status : true,

		dependent_first_name : "",
		dependent_last_name : "",
		dependent_middle_name : "",
		dependent_birth_date : "",
		dependent_sex : "",
		dependent_contact_no : "",
		dependent_email_address : "",
		dependent_email_extension : "",
		dependent_religion : "",
		dependent_educational_attainment : "",
		dependent_occupation : "",
		dependent_street : "",
		dependent_house_no : "",
		dependent_subdivision : "",
		dependent_civil_status : "",
		dependent_barangay : "",

		beneficiary_id : "",
		first_name : "",
		last_name : "",
		middle_name : "",
		birth_date : "",
		sex : "",
		contact_no : "",
		email_address : "",
		religion : "",
		educational_attainment : "",
		occupation : "",
		street : "",
		house_no : "",
		subdivision : "",
		beneficiary_civil_status : "",
		barangay : "",
		email_extension : "",
		status : "",
		balance : "",
		beneficiary_type : "",

		add_new_dependent : false,

		profile : "",
		buzz : "",

		first_name_error : false,
		last_name_error : false,
		middle_name_error : false,
		birth_date_error : false,
		sex_error : false,
		contact_no_error : false,
		email_address_error : false,
		email_extension_error : false,
		religion_error : false,
		educational_attainment_error : false,
		occupation_error : false,
		civil_status_error : false,
		street_error : false,
		house_no_error : false,
		subdivision_error : false,
		barangay_error : false,

		dependent_first_name_error : false,
		dependent_last_name_error : false,
		dependent_middle_name_error : false,
		dependent_birth_date_error : false,
		dependent_sex_error : false,
		dependent_contact_no_error : false,
		dependent_email_address_error : false,
		dependent_email_extension_error : false,
		dependent_religion_error : false,
		dependent_educational_attainment_error : false,
		dependent_occupation_error : false,
		dependent_civil_status_error : false,
		dependent_street_error : false,
		dependent_house_no_error : false,
		dependent_subdivision_error : false,
		dependent_barangay_error : false,

		barangays : [],
		civil_status : [],

		add_member : false,
		main_body : true,

		pwd_beneficiaries : [],
		beneficiaries : [],
	},
	methods: {
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

	    // toggle buttons
	    toggleAddMember : function() {
	    	if(this.main_body == true) {
	    		this.main_body = false;
	    		this.add_member = true;
	    	}
	    	else {
	    		this.main_body = true;
	    		this.add_member = false;
	    	}
	    },
	    //////////////////

		// identify Methods
		identifyBarangayName : function(barangay_id) {
			for(var index = 0; index < this.barangays.length; index++) {
				if(barangay_id == this.barangays[index].barangay_id) {
					return this.barangays[index].barangay_name;
				}
			}
		},
		///////////////////
	    retrieveBarangay : function() {
			axios({
				method : "GET",
				url : this.urlRoot + this.api + "retrieve_barangay.php"
			}).then(function (response){
				vm.barangays = response.data;
			});
		},
		retrieveCivilStatus : function() {
			axios.get(this.urlRoot + this.api + "retrieve_civil_status.php")
			.then(function (response) {
				vm.civil_status = response.data;
			});
		},
		retrievePwdBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_pwd_beneficiary.php")
			.then(function (response) {
				vm.pwd_beneficiaries = response.data
				console.log(response);
			});
		},
		retrieveAllBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_all_beneficiary.php?beneficiary_type_id=" + 2)
			.then(function (response) {
				vm.beneficiaries = response.data;
				console.log(response);
			});
		},
	},
	created() {
		this.retrieveBarangay();
		this.retrieveCivilStatus();
		this.retrievePwdBeneficiary();
		this.retrieveAllBeneficiary();
	}
});