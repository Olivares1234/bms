var vm = new Vue({
	el : "#vue-beneficiary",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/registration_staff/beneficiary/",

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		////// end of pagination /////////

		beneficiary_list : true,
		add_beneficiary_list : false,
		update_beneficiary_list : false,
		view_beneficiary_list : false,

		beneficiaries : [],
		barangays : [],
		civil_statuses : [],
		beneficiary_types : [],
		dependents : [],
		beneficiary_dependents : [],

		beneficiary_id : "",
		first_name : "",
		last_name : "",
		middle_name : "",
		contact_no : "",
		birth_month : "",
		birth_day : "",
		birth_year : "",
		email_address : "",
		email_extension : "",
		sex : "",
		street : "",
		house_no : "",
		subdivision : "",
		educational_attainment : "",
		occupation : "",
		religion : "",
		civil_status : "",
		barangay : "",
		voters_id : "",

		birth_date : "",
		address : "",
		status : "",
		balance : "",

		first_name_error : false,
		last_name_error : false,
		middle_name_error : false,
		contact_no_error : false,
		birth_month_error : false,
		birth_day_error : false,
		birth_year_error : false,
		email_address_error : false,
		email_extension_error : false,
		sex_error : false,
		street_error : false,
		house_no_error : false,
		subdivision_error : false,
		educational_attainment_error : false,
		occupation_error : false,
		religion_error : false,
		civil_status_error : false,
		barangay_error : false,
		voters_id_error : false,

		birth_year_description : "",
		birth_day_description : "",
		contact_no_description : "",

		beneficiary_type : "",
		beneficiary_type_error : false,

		const_beneficiary_type : "",

		search_beneficiary : "",
		filter : "",

		search_beneficiary_status : ""

	},
	methods : {
		str_pad : function(n) {
 			return String("00" + n).slice(-2);
		},
		// keypress method
		birthDayValidationKeypress : function(evt, value) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;

      		if ((charCode > 31 && (charCode < 48 || charCode > 57 || charCode == 189)) || charCode == 46) {
        		evt.preventDefault();
      		}
      		else if(value.length > 1) {
      			evt.preventDefault();
      		}
      		else {
        		return true;
      		}
		},
		birthYearValidationKeypress : function(evt, value) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;

      		if ((charCode > 31 && (charCode < 48 || charCode > 57 || charCode == 189)) || charCode == 46) {
        		evt.preventDefault();
      		}
      		else if(value.length > 3) {
      			evt.preventDefault();
      		}
      		else {
        		return true;
      		}
		},
		contactNoValidationKeypress : function(evt, value) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;

      		if ((charCode > 31 && (charCode < 48 || charCode > 57 || charCode == 189)) || charCode == 46) {
        		evt.preventDefault();
      		}
      		else if(value.length > 10) {
      			evt.preventDefault();
      		}
      		else {
        		return true;
      		}
		},
		emailAddressvalidation : function(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;

			if(charCode > 31 && (charCode < 46 || charCode == 64 || charCode == 47 || charCode == 94 || charCode == 96 || charCode == 91 || charCode == 92 || charCode == 93 || charCode == 94 || charCode == 123 || charCode == 124 || charCode == 125 || charCode == 126 || charCode == 61 || charCode == 58 || charCode == 59 || charCode == 63 || charCode == 60 || charCode == 62)) {
				evt.preventDefault();
			}
			else {
				return true;
			}
		},
		////////////////

		// validation method
		beneficiaryValidation : function() {
			var date = new Date();
			if(this.first_name.trim() == '') {
				this.first_name_error = true;
			}
			else {
				this.first_name_error = false;
			}

			if(this.last_name.trim() == '') {
				this.last_name_error = true;
			}
			else {
				this.last_name_error = false;
			}

			if(this.contact_no == '') {
				this.contact_no_error = true;
				this.contact_no_description = "This field is required!";
			}
			else if(this.contact_no.length != 11) {
				this.contact_no_error = true;
				this.contact_no_description = "Invalid phone number!";
			}
			else {
				this.contact_no_error = false;
				this.contact_no_description = "";
			}

			if(this.birth_month == '') {
				this.birth_month_error = true;
			}
			else {
				this.birth_month_error = false;
			}

			if(this.birth_day == '') {
				this.birth_day_error = true;
				this.birth_day_description = "This field is required!";
			}
			else if(this.birth_day > 31 || this.birth_day == 0) {
				this.birth_day_error = true;
				this.birth_day_description = "Invalid Day!";
			}
			else {
				this.birth_day_error = false;
				this.birth_day_description = "";
			}

			if(this.birth_year == '') {
				this.birth_year_error = true;
				this.birth_year_description = "This field is required!";
			}
			else if(this.birth_year < 1899 || this.birth_year > date.getFullYear()) {
				this.birth_year_error = true;
				this.birth_year_description = "Birth year out of range!";
			}
			else {
				this.birth_year_error = false;
				this.birth_year_description = "";
			}

			if(this.email_address.trim() == '') {
				this.email_address_error = true;
			}
			else {
				this.email_address_error = false;
			}

			if(this.email_extension.trim() == '') {
				this.email_extension_error = true;
			}
			else {
				this.email_extension_error = false;
			}

			if(this.sex.trim() == '') {
				this.sex_error = true;
			}
			else {
				this.sex_error = false;
			}

			if(this.street.trim() == '') {
				this.street_error = true;
			}
			else {
				this.street_error = false;
			}

			if(this.house_no.trim() == '') {
				this.house_no_error = true;
			}
			else {
				this.house_no_error = false;
			}

			if(this.educational_attainment.trim() == '') {
				this.educational_attainment_error = true;
			}
			else {
				this.educational_attainment_error = false;
			}

			if(this.occupation.trim() == '')  {
				this.occupation_error = true;
			}
			else {
				this.occupation_error = false;
			}

			if(this.religion.trim() == '') {
				this.religion_error = true;
			}
			else {
				this.religion_error = false;
			}

			if(this.civil_status.trim() == '') {
				this.civil_status_error = true;
			}
			else {
				this.civil_status_error = false;
			}

			if(this.barangay.trim() == "") {
				this.barangay_error = true;
			}
			else {
				this.barangay_error = false
			}

			if(this.voters_id.trim() == "") {
				this.voters_id_error = true;
			}
			else {
				this.voters_id_error = false;
			}
		},
		checkBeneficiaryError : function() {
			if(this.first_name_error == false && this.last_name_error == false && this.contact_no_error == false && this.birth_month_error == false && this.birth_day_error == false && this.birth_year_error == false && this.email_address_error == false && this.email_extension_error == false && this.sex_error == false && this.street_error == false && this.house_no_error == false && this.educational_attainment_error == false && this.occupation_error == false && this.religion_error == false && this.civil_status_error == false && this.barangay_error == false && this.beneficiary_type_error == false && this.voters_id_error == false) {
				return true;
			}
		},
		checkBeneficiaryExist : function() {
			for(var index = 0; index < this.beneficiaries.length; index++) {
				if(this.voters_id == this.beneficiaries[index].voters_id) {
					return true;
				}
			}
		},
		checkUpdateBeneficiaryExist : function(beneficiary_id) {
			for(var index = 0; index < this.beneficiaries.length; index++) {
				if(beneficiary_id != this.beneficiaries[index].beneficiary_id) {
					if(this.voters_id == this.beneficiaries[index].voters_id) {
						return true;
					}
				}
			}
		},
		checkIfBeneficiaryCanActivate : function(voters_id) {
			for(var index = 0; index < this.dependents.length; index++) {
				if(voters_id == this.dependents[index].voters_id) {
					return true;
				}
			}
		},
		////////////////////

		// clear data
		clearBeneficiaryData : function() {
			this.first_name = "";
			this.last_name = "";
			this.middle_name = "";
			this.contact_no = "";
			this.birth_month = "";
			this.birth_day = "";
			this.birth_year = "";
			this.email_address = "";
			this.email_extension = "";
			this.sex = "";
			this.street = "";
			this.house_no = "";
			this.subdivision = "";
			this.educational_attainment = "";
			this.occupation = "";
			this.religion = "";
			this.civil_status = "";
			this.barangay = "";
			this.voters_id = "";

			this.beneficiary_type = "";
			this.birth_date = "";
			this.address = "";
			this.status = "";
			this.balance = "";
		},
		beneficiaryErrorDefault : function() {
			this.first_name_error = false;
			this.last_name_error = false;
			this.middle_name_error = false;
			this.contact_no_error = false;
			this.birth_month_error = false;
			this.birth_day_error = false;
			this.birth_year_error = false;
			this.email_address_error = false;
			this.email_extension_error = false;
			this.sex_error = false;
			this.street_error = false;
			this.house_no_error = false;
			this.subdivision_error = false;
			this.educational_attainment_error = false;
			this.occupation_error = false;
			this.religion_error = false;
			this.civil_status_error = false;
			this.barangay_error = false;
			this.voters_id_error = false;

			this.beneficiary_type_error = false;
		},
		/////////////

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

		// toggle button
		toggleAddNewBeneficiary : function() {
			if(this.beneficiary_list == true) {
				this.beneficiary_list = false;
				this.add_beneficiary_list = true;
			}
			else {
				this.beneficiary_list = true;
				this.add_beneficiary_list = false;
				this.clearBeneficiaryData();
	 			this.beneficiaryErrorDefault();
			}
		},
		toggleUpdateBeneficiary : function(beneficiary_id) {
			if(this.beneficiary_list == true) {
				this.beneficiary_list = false;
				this.update_beneficiary_list = true;

				this.beneficiary_id = beneficiary_id;

				this.identifyBeneficiary(beneficiary_id);
			}
			else {
				this.beneficiary_list = true;
				this.update_beneficiary_list = false;
				this.clearBeneficiaryData();
	 			this.beneficiaryErrorDefault();
			}
		},
		toggleActivateBeneficiary : function(beneficiary_id, beneficiary_type_id, voters_id) {

			if(this.identifyBeneficiaryType(beneficiary_type_id) != 'none') {
				$('#myModal2').modal('show');
				this.beneficiary_id = beneficiary_id;
				this.voters_id = voters_id;
				this.beneficiary_type = this.identifyBeneficiaryType(beneficiary_type_id);
			}
			else {
				$('#myModal').modal('show');
				this.beneficiary_id = beneficiary_id;
				this.voters_id = voters_id;
			}
			
		},
		closeActivateBeneficiaryModal : function() {
			this.clearBeneficiaryData();
			this.beneficiaryErrorDefault();
			$('#myModal').modal('hide');
		},
		toggleDeactivateBeneficiary : function(beneficiary_id) {
			$('#myModal1').modal('show');
			this.beneficiary_id = beneficiary_id;
		},
		toggleViewBeneficiaryDetails : function(beneficiary_id) {
			if(this.beneficiary_list == true) {
				this.beneficiary_list = false;
				this.view_beneficiary_list = true;

				this.identifyBeneficiary(beneficiary_id);
				this.retrieveBeneficiaryDependent(beneficiary_id)
			}
			else {
				this.beneficiary_list = true;
				this.view_beneficiary_list = false;

				this.clearBeneficiaryData();
				this.beneficiaryErrorDefault();
			}
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
		identifyCivilStatus : function(civil_status_id) {
			for(var index = 0; index < this.civil_statuses.length; index++) {
				if(civil_status_id == this.civil_statuses[index].civil_status_id) {
					return this.civil_statuses[index].description;
				}
			}
		},
		identifyCivilStatusId : function(civil_status) {
			for(var index = 0; index < this.civil_statuses.length; index++) {
				if(civil_status == this.civil_statuses[index].description) {
					return this.civil_statuses[index].civil_status_id;
				}
			}
		},
		identifyBeneficiaryTypeId : function(beneficiary_type) {
			for(var index = 0; index < this.beneficiary_types.length; index++) {
				if(beneficiary_type == this.beneficiary_types[index].description) {
					return this.beneficiary_types[index].beneficiary_type_id;
				}
			}
		},
		identifyBeneficiaryType : function(beneficiary_type_id) {
			for(var index = 0; index < this.beneficiary_types.length; index++) {
				if(beneficiary_type_id == this.beneficiary_types[index].beneficiary_type_id) {
					return this.beneficiary_types[index].description;
				}
			}
		},
		identifyBeneficiary : function(beneficiary_id) {
			for(var index = 0; index < this.beneficiaries.length; index++) {
				if(beneficiary_id == this.beneficiaries[index].beneficiary_id) {
					this.first_name = this.beneficiaries[index].first_name;
					this.last_name = this.beneficiaries[index].last_name;
					this.middle_name = this.beneficiaries[index].middle_name;
					this.contact_no = this.beneficiaries[index].contact_no;
					this.birth_month = this.identifyBirthMonth(this.beneficiaries[index].birth_date);
					this.birth_day = this.identifyBirthDay(this.beneficiaries[index].birth_date);
					this.birth_year = this.identifyBirthYear(this.beneficiaries[index].birth_date);
					this.email_address = this.identifyEmail(this.beneficiaries[index].email_address);
					this.email_extension = this.identifyEmailExtension(this.beneficiaries[index].email_address);
					this.sex = this.beneficiaries[index].sex;
					this.street = this.identifyStreet(this.beneficiaries[index].address);
					this.house_no = this.identifyHouseNo(this.beneficiaries[index].address);
					this.subdivision = this.identifySubdivision(this.beneficiaries[index].address);
					this.educational_attainment = this.beneficiaries[index].educational_attainment;
					this.occupation = this.beneficiaries[index].occupation;
					this.religion = this.beneficiaries[index].religion;
					this.civil_status = this.identifyCivilStatus(this.beneficiaries[index].civil_status_id);
					this.barangay = this.identifyBarangayName(this.beneficiaries[index].barangay_id);
					this.voters_id = this.beneficiaries[index].voters_id;

					this.birth_date = this.beneficiaries[index].birth_date;
					this.address = this.beneficiaries[index].address;
					this.status = this.beneficiaries[index].status;
					this.balance = this.beneficiaries[index].balance;
					this.beneficiary_type = this.identifyBeneficiaryType(this.beneficiaries[index].beneficiary_type_id);
					this.const_beneficiary_type = this.identifyBeneficiaryType(this.beneficiaries[index].beneficiary_type_id);
				}
			}
		},
		identifyEmail : function(email_address) {
 			var locate = email_address.indexOf('@');

 			return email_address.slice(0, locate);
 		},
 		identifyEmailExtension : function(email_address) {
 			var locate = email_address.indexOf('@');

 			return email_address.slice(locate);
 		},
 		identifyHouseNo : function(address) {
 			var locate = address.indexOf(',');

 			return address.slice(0, locate);
 		},
 		identifyStreet : function(address) {
 			var firstLocation = address.indexOf(',');
 			var secondLocation = address.indexOf(',', parseInt(firstLocation + 1));

 			return address.slice(firstLocation + 2, secondLocation); 
 		},
 		identifySubdivision : function(address) {
 			var firstLocation = address.indexOf(',');
 			var secondLocation = address.indexOf(',', parseInt(firstLocation + 1));

 			return address.slice(secondLocation + 2);
 		},
 		identifyBirthYear : function(birth_date) {
			var locate = birth_date.indexOf('-');

			return birth_date.slice(0, locate);
		},
		identifyBirthMonth : function(birth_date) {
			var first_locate = birth_date.indexOf('-');
			var second_locate = birth_date.indexOf('-', parseInt(first_locate) + 1);

			return birth_date.slice(first_locate + 1, second_locate);
		},
		identifyBirthDay : function(birth_date) {
			var first_locate = birth_date.indexOf('-');
			var second_locate = birth_date.indexOf('-', parseInt(first_locate) + 1);

			return birth_date.slice(second_locate + 1);
		},
		//////////////////

		// generate id
		generateBeneficiaryId : function() {
			var date = new Date();
			var pad = "00000";

			var id = "";

			if(this.beneficiaries.length == 0) {
				id = "BF" + "" + date.getFullYear() + "" + this.str_pad(date.getMonth() + 1) + "" + this.str_pad(date.getDate()) + "00001";
			}
			else {
				for(var index = 0; index < this.beneficiaries.length; index++) {
					id = this.beneficiaries[index].beneficiary_id;
				}

				id = id.slice(11);
				id = pad.substring(0, pad.length - id.length) + id;
	    		id = date.getFullYear() + "" + this.str_pad(date.getMonth() + 1) + "" + this.str_pad(date.getDate()) + id;
	    		id = parseInt(id) + 1;
	    		id = "BF" + id;
			}

			return id;
		},
		//////////////

		// retrieve method
		retrieveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary.php")
			.then(function (response) {
				vm.beneficiaries = response.data;
			});
		},
		retrieveBarangay : function() {
			axios.get(this.urlRoot + this.api + "retrieve_barangay.php")
			.then(function (response) {
				vm.barangays = response.data;
			});
		},
		retrieveBeneficiaryType : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary_type.php")
			.then(function (response) {
				vm.beneficiary_types = response.data;
			});
		},
		retrieveCivilStatus : function() {
			axios.get(this.urlRoot + this.api + "retrieve_civil_status.php")
			.then(function (response) {
				vm.civil_statuses = response.data;
			});
		},
		retrieveDependent : function() {
			axios.get(this.urlRoot + this.api + "retrieve_dependent.php")
			.then(function (response) {
				vm.dependents = response.data;
			});
		},
		retrieveBeneficiaryDependent : function(beneficiary_id) {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary_dependent.php?beneficiary_id=" + beneficiary_id)
			.then(function (response) {
				console.log(response);
				vm.beneficiary_dependents = response.data;
			});
		},
		//////////////////

		saveBeneficiary : function() {
			this.beneficiaryValidation();

			if(this.checkBeneficiaryError() == true) {
				if(this.checkBeneficiaryExist() == true) {
					swal({
						title : "Error!",
						text : "Beneficiary already exist!",
						icon : "error",
						timer : "1050",
						buttons : false,
						closeOnClickOutside: false
					})
				}
				else {
					this.addBeneficiary();
				}
			}
		},
		addBeneficiary : function() {
			axios.post(this.urlRoot + this.api + "add_beneficiary.php", {
				beneficiary_id : this.generateBeneficiaryId(),
				first_name : this.first_name,
				last_name : this.last_name,
				middle_name : this.middle_name,
				contact_no : this.contact_no,
				birth_month : this.str_pad(this.birth_month),
				birth_day : this.str_pad(this.birth_day),
				birth_year : this.birth_year,
				email_address : this.email_address,
				email_extension : this.email_extension,
				sex : this.sex,
				street : this.street,
				house_no : this.house_no,
				subdivision : this.subdivision,
				educational_attainment : this.educational_attainment,
				occupation : this.occupation,
				religion : this.religion,
				civil_status_id : this.identifyCivilStatusId(this.civil_status),
				barangay_id : this.identifyBarangayId(this.barangay),
				voters_id : this.voters_id
			}).then(function (response) {
				console.log(response);

				if(response.data.status == "NOT_OK") {
					vm.first_name_error = response.data.first_name_error;
					vm.last_name_error = response.data.last_name_error;
					vm.contact_no_error = response.data.contact_no_error;
					vm.birth_month_error = response.data.birth_month_error;
					vm.birth_day_error = response.data.birth_day_error;
					vm.birth_year_error = response.data.birth_year_error;
					vm.email_address_error = response.data.email_address_error;
					vm.email_extension_error = response.data.email_extension_error;
					vm.sex_error = response.data.sex_error;
					vm.street_error = response.data.street_error;
					vm.house_no_error = response.data.house_no_error;
					vm.educational_attainment_error = response.data.educational_attainment_error;
					vm.occupation_error = response.data.occupation_error;
					vm.religion_error = response.data.religion_error;
					vm.civil_status_error = response.data.civil_status_error;
					vm.barangay_error = response.data.barangay_error;
					vm.voters_id_error = response.data.voters_id_error;

					vm.contact_no_description = response.data.contact_no_description;
					vm.birth_day_description = response.data.birth_day_description;
					vm.birth_year_description = response.data.birth_year_description;
				}
				else {
					vm.addBeneficiaryDetails();
					
				}
			})
		},
		addBeneficiaryDetails : function() {
			var date = new Date();
			axios.post(this.urlRoot + this.api + "add_beneficiary_details.php", {
				date_added : date.getFullYear() + "-" + this.str_pad(date.getMonth() + 1) + "-" + this.str_pad(date.getDate())
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Success!",
					text : "Beneficiary added sucessfully!",
					icon : "success",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveBeneficiary();
	 				vm.clearBeneficiaryData();
	 				vm.beneficiaryErrorDefault();
	 				vm.toggleAddNewBeneficiary();
				});
			});
		},
		saveUpdateBeneficiary : function() {
			this.beneficiaryValidation();

			if(this.checkBeneficiaryError() == true) {
				if(this.checkUpdateBeneficiaryExist(this.beneficiary_id) == true) {
					swal({
						title : "Error!",
						text : "Beneficiary already exist!",
						icon : "error",
						timer : "1050",
						buttons : false,
						closeOnClickOutside: false
					})
				}
				else {
					if(this.const_beneficiary_type == 'Senior' || this.const_beneficiary_type == 'PWD') {
						this.updateBeneficiary();
					}
					else {
						if(this.beneficiary_type == 'Senior') {
							swal({
								title : "Are you sure?",
								text : "If you set this beneficiary to Senior you cannot update it anymore!",
								icon : "warning",
								buttons : ["Cancel", "Update"],
								dangerMode: true,
								closeOnClickOutside : false,
							}).then((willDiscard) => {
								if(willDiscard) {
									this.updateBeneficiaryToPriority();
								}
							});
						}
						else if(this.beneficiary_type == 'PWD') {
							swal({
								title : "Are you sure?",
								text : "If you set this beneficiary to PWD you cannot update it anymore!",
								icon : "warning",
								buttons : ["Cancel", "Update"],
								dangerMode: true,
								closeOnClickOutside : false,
							}).then((willDiscard) => {
								if(willDiscard) {
									this.updateBeneficiaryToPriority();
								}
							});
						}
						else {
							this.updateBeneficiary();
						}
					}
					
					
				}

			}
		},
		updateBeneficiary : function() {
			if(this.const_beneficiary_type == "Senior") {
				this.beneficiary_type = "Senior";
			}
			if(this.const_beneficiary_type == "PWD") {
				this.beneficiary_type = "PWD";
			}
			axios.post(this.urlRoot + this.api + "update_beneficiary.php", {
					beneficiary_id : this.beneficiary_id,
					first_name : this.first_name,
					last_name : this.last_name,
					middle_name : this.middle_name,
					contact_no : this.contact_no,
					birth_month : this.birth_month,
					birth_day : this.birth_day,
					birth_year : this.birth_year,
					email_address : this.email_address,
					email_extension : this.email_extension,
					sex : this.sex,
					street : this.street,
					house_no : this.house_no,
					subdivision : this.subdivision,
					educational_attainment : this.educational_attainment,
					occupation : this.occupation,
					religion : this.religion,
					civil_status_id : this.identifyCivilStatusId(this.civil_status),
					barangay_id : this.identifyBarangayId(this.barangay),
					beneficiary_type_id : this.identifyBeneficiaryTypeId(this.beneficiary_type),
					voters_id : this.voters_id
				}).then(function (response) {
					console.log(response);

					if(response.data.status == "NOT_OK") {
						vm.first_name_error = response.data.first_name_error;
						vm.last_name_error = response.data.last_name_error;
						vm.contact_no_error = response.data.contact_no_error;
						vm.birth_month_error = response.data.birth_month_error;
						vm.birth_day_error = response.data.birth_day_error;
						vm.birth_year_error = response.data.birth_year_error;
						vm.email_address_error = response.data.email_address_error;
						vm.email_extension_error = response.data.email_extension_error;
						vm.sex_error = response.data.sex_error;
						vm.street_error = response.data.street_error;
						vm.house_no_error = response.data.house_no_error;
						vm.educational_attainment_error = response.data.educational_attainment_error;
						vm.occupation_error = response.data.occupation_error;
						vm.religion_error = response.data.religion_error;
						vm.civil_status_error = response.data.civil_status_error;
						vm.barangay_error = response.data.barangay_error;
						vm.voters_id_error = response.data.voters_id_error;

						vm.contact_no_description = response.data.contact_no_description;
						vm.birth_day_description = response.data.birth_day_description;
						vm.birth_year_description = response.data.birth_year_description;
					}
					else {
						swal({
							title : "Success!",
							text : "Beneficiary updated sucessfully!",
							icon : "success",
							timer : "1050",
							buttons : false,
							closeOnClickOutside: false
						}).then(() => {
							vm.retrieveBeneficiary();
			 				vm.clearBeneficiaryData();
			 				vm.beneficiaryErrorDefault();
			 				vm.toggleUpdateBeneficiary('');
						});
					}
				})
		},
		deactivateDependent : function() {
			axios.post(this.urlRoot + this.api + "deactivate_and_no_beneficiary_dependent.php", {
				beneficiary_id : this.beneficiary_id,
				dependents : this.dependents
			}).then(function (response) {
				console.log(response);
				vm.updateBeneficiaryIsDependent();
			})
		},
		updateBeneficiaryToPriority : function() {
			axios.post(this.urlRoot + this.api + "update_beneficiary_to_priority.php", {
				beneficiary_id : this.beneficiary_id,
				beneficiary_type_id : this.identifyBeneficiaryTypeId(this.beneficiary_type)
			}).then(function (response) {
				console.log(response);
			 	vm.deactivateDependent();
				
			})
		},
		updateBeneficiaryIsDependent : function() {
			axios.post(this.urlRoot + this.api + "update_beneficiary_is_dependent.php", {
				beneficiaries : this.beneficiaries,
				dependents : this.dependents,
				beneficiary_id : this.beneficiary_id
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Success!",
					text : "Beneficiary updated sucessfully!",
					icon : "success",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveBeneficiary();
	 				vm.clearBeneficiaryData();
	 				vm.beneficiaryErrorDefault();
	 				vm.toggleUpdateBeneficiary('');
				});
			});
		},
		activateBeneficiary : function() {
			if(this.beneficiary_type == '') {
				this.beneficiary_type_error = true;
			}
			else {
				this.beneficiary_type_error = false;
			}

			if(this.beneficiary_type_error == false) {

				if(this.checkIfBeneficiaryCanActivate(this.voters_id) == true) {
					swal({
						title : "Cannot be activate!",
						text : "Possible beneficiary already set as dependent!",
						icon : "error",
						timer : "3050",
						buttons : false,
						closeOnClickOutside: false
					})
				}
				else {
					if(this.beneficiary_type == 'Senior') {
							swal({
								title : "Are you sure?",
								text : "If you set this beneficiary to Senior you cannot update it anymore!",
								icon : "warning",
								buttons : ["Cancel", "Update"],
								dangerMode: true,
								closeOnClickOutside : false,
							}).then((willDiscard) => {
								if(willDiscard) {
									this.activateBeneficiaryConfirmed();
								}
							});
						}
						else if(this.beneficiary_type == 'PWD') {
							swal({
								title : "Are you sure?",
								text : "If you set this beneficiary to PWD you cannot update it anymore!",
								icon : "warning",
								buttons : ["Cancel", "Update"],
								dangerMode: true,
								closeOnClickOutside : false,
							}).then((willDiscard) => {
								if(willDiscard) {
									this.activateBeneficiaryConfirmed();
								}
							});
						}
						else {
							this.activateBeneficiaryConfirmed();
						}
					
				}
			}
		},
		activateBeneficiaryConfirmed : function() {
			axios.post(this.urlRoot + this.api + "activate_beneficiary.php", {
				beneficiary_id : this.beneficiary_id,
				beneficiary_type_id : this.identifyBeneficiaryTypeId(this.beneficiary_type)
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Success!",
					text : "Beneficiary activated sucessfully!",
					icon : "success",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveBeneficiary();
	 				vm.clearBeneficiaryData();
	 				vm.beneficiaryErrorDefault();
	 				vm.closeActivateBeneficiaryModal();
	 				$('#myModal2').modal('hide');
				});
			});
		},
		deactivateBeneficiary : function() {
			axios.post(this.urlRoot + this.api + "deactivate_beneficiary.php", {
				beneficiary_id : this.beneficiary_id
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Success!",
					text : "Beneficiary deactivated sucessfully!",
					icon : "success",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveBeneficiary();
	 				vm.clearBeneficiaryData();
	 				vm.beneficiaryErrorDefault();
	 				$('#myModal1').modal('hide');
				});
			})
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
		searchBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "search_beneficiary.php?filter=" + this.filter + "&keyword=" + this.search_beneficiary)
			.then(function (response) {
				console.log(response);
				vm.beneficiaries = response.data;
			})
		},

		searchBeneficiaryStatus : function(search_beneficiary_status) {
			axios.get(this.urlRoot + this.api + "search_beneficiary.php?filter=" + this.filter + "&keyword=" + search_beneficiary_status)
			.then(function (response) {
				console.log(response);
				vm.beneficiaries = response.data;
				vm.search_beneficiary = "";
			})
		},
	},
	created() {
		this.retrieveBeneficiary();
		this.retrieveBarangay();
		this.retrieveCivilStatus();
		this.retrieveBeneficiaryType();
		this.retrieveDependent();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})