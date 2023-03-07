var vm = new Vue({
	el : "#vue-4Ps",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/registration_staff/4P's/",

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		////// end of pagination /////////

		// titles
		view_beneficiary_details : "View details",
		update_beneficiary : "Update beneficiary",
		////////

		beneficiary_list : true,
		add_new_beneficiary : false,
		add_old_beneficiary : false,
		status_info : false,
		beneficiary_info : false,
		view_beneficiary : false,
		update_beneficiary : false,


		barangays : [],

		civil_status : [],

		beneficiary_types : [],

		beneficiaries : [],
		search_beneficiary : "",

		addDependents : [],
		add_dependent : {
			first_name : null,
			last_name : null,
			middle_name : null,
			birth_month : null,
			birth_day : null,
			birth_year : null,
			sex : null,
			contact_no : null,
			email_address : null,
			email_extension : null,
			religion : null,
			educational_attainment : null,
			occupation : null,
			street : null,
			house_no : null,
			subdivision : null,
			civil_status : null,
			barangay : null,
		},

		dependent_first_name : "",
		dependent_last_name : "",
		dependent_middle_name : "",
		dependent_contact_no : "",
		dependent_birth_month : "",
		dependent_birth_day : "",
		dependent_birth_year : "",
		dependent_email_address : "",
		dependent_email_extension : "",
		dependent_sex : "",
		dependent_street : "",
		dependent_house_no : "",
		dependent_subdivision : "",
		dependent_educational_attainment : "",
		dependent_occupation : "",
		dependent_religion : "",
		dependent_civil_status : "",
		

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
		dependent_birth_month_error : false,
		dependent_birth_day_error : false,
		dependent_birth_year_error : false,
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

		years : [],
		currentIndex : "",

		dependents : [],

		indigents : [],

	},
	methods : {
		getYear : function() {
			var date = new Date();
			for(var index = 1900; index <= date.getFullYear(); index++) {
				this.years.push(index);
			}
			// console.log(this.years);
		},
		str_pad : function(n) {
 			return String("00" + n).slice(-2);
		},
		isLetter(event) {
          	if (!(event.key.toLowerCase() >= 'a' && event.key.toLowerCase() <= 'z' || event.key == ' '))
                event.preventDefault();
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

	    toggleAddBeneficiary : function() {
	    	if(this.beneficiary_list == false) {
	    		this.beneficiary_list = true;
	    		this.status_info = false;
	    	}
	    	else {
	    		this.beneficiary_list = false;
	    		this.status_info = true;
	    	}
	    },
	    toggleAddNewBeneficiary : function() {
	    	if(this.add_new_beneficiary == false) {
	    		this.add_new_beneficiary = true;
	    		this.beneficiary_list = false;
	    		this.status_info = false;
	    	}
	    	else {
	    		this.add_new_beneficiary = false;
	    		this.beneficiary_list = false;
	    		this.status_info = true;
	    	}
	    },
	    toggleAddOldBeneficiary : function() {
	    	if(this.add_old_beneficiary == false) {
	    		this.add_old_beneficiary = true;
	    		this.beneficiary_list = false;
	    		this.status_info = false;

	    		this.retrieveIndigent();
	    	}
	    	else {
	    		this.add_old_beneficiary = false;
	    		this.beneficiary_list = false;
	    		this.status_info = true;
	    	}
	    },
		toggle4PsDependentInfo : function(beneficiary_id) {
			if (this.add_new_beneficiary == false) {
				this.add_new_beneficiary = true;
				this.beneficiary_list = false;
				this.view_beneficiary = false;

				this.identifyBeneficiary(beneficiary_id);
			}
			else {
				this.add_new_beneficiary = false;
				this.beneficiary_list = true;
				this.view_beneficiary = false;
				this.clearBeneficiaryData();
			}
		},
		toggleViewBeneficiary : function(beneficiary_id) {
			if (this.view_beneficiary == false) {
				this.view_beneficiary = true;
				this.add_new_beneficiary = false;
				this.beneficiary_list = false;

				this.identifyBeneficiary(beneficiary_id);
				this.retrieveDependent(beneficiary_id);
			}
			else {
				this.add_new_beneficiary = false;
				this.beneficiary_list = true;
				this.view_beneficiary = false;
			}
		},
		toggleUpdateDependentDetails : function(index) {
			this.currentIndex = index;

			for(var index1 = 0; index1 < this.addDependents.length; index1++) {
				if(index == index1) {
					this.dependent_first_name = this.addDependents[index1].first_name;
					this.dependent_last_name =this.addDependents[index1].last_name;
					this.dependent_middle_name = this.addDependents[index1].middle_name;
					this.dependent_birth_month = this.addDependents[index1].birth_month;
					this.dependent_birth_day = this.addDependents[index1].birth_day;
					this.dependent_birth_year =this.addDependents[index1].birth_year;
					this.dependent_sex = this.addDependents[index1].sex;
					this.dependent_contact_no = this.addDependents[index1].contact_no;
					this.dependent_email_address = this.addDependents[index1].email_address;
					this.dependent_email_extension =this.addDependents[index1].email_extension;
					this.dependent_religion = this.addDependents[index1].religion;
					this.dependent_educational_attainment = this.addDependents[index1].educational_attainment;
					this.dependent_occupation = this.addDependents[index1].occupation;
					this.dependent_civil_status =this.addDependents[index1].civil_status;
					this.dependent_street = this.addDependents[index1].street;
					this.dependent_house_no = this.addDependents[index1].house_no;
					this.dependent_subdivision =this.addDependents[index1].subdivision;
				}
			}

			$('#myModal6').modal('show');
		},
		viewDependentDetails : function(index) {
			for(var index1 = 0; index1 < this.addDependents.length; index1++) {
				if(index == index1) {
					this.dependent_first_name = this.addDependents[index1].first_name;
					this.dependent_last_name =this.addDependents[index1].last_name;
					this.dependent_middle_name = this.addDependents[index1].middle_name;
					this.dependent_birth_month = this.addDependents[index1].birth_month;
					this.dependent_birth_day = this.addDependents[index1].birth_day;
					this.dependent_birth_year =this.addDependents[index1].birth_year;
					this.dependent_sex = this.addDependents[index1].sex;
					this.dependent_contact_no = this.addDependents[index1].contact_no;
					this.dependent_email_address = this.addDependents[index1].email_address;
					this.dependent_email_extension =this.addDependents[index1].email_extension;
					this.dependent_religion = this.addDependents[index1].religion;
					this.dependent_educational_attainment = this.addDependents[index1].educational_attainment;
					this.dependent_occupation = this.addDependents[index1].occupation;
					this.dependent_civil_status =this.addDependents[index1].civil_status;
					this.dependent_street = this.addDependents[index1].street;
					this.dependent_house_no = this.addDependents[index1].house_no;
					this.dependent_subdivision =this.addDependents[index1].subdivision;
				}
			}
		},
		toggleUpdateBeneficiary : function(beneficiary_id) {
			if(this.update_beneficiary == false) {
				this.update_beneficiary = true;
				this.beneficiary_list = false;
				this.identifyBeneficiary(beneficiary_id);
			}
			else {
				this.update_beneficiary = false;
				this.beneficiary_list = true;
			}

		},
		updateDependentDetails : function() {
			this.dependentValidation();
			if(this.dependent_first_name != '' && this.dependent_last_name != '' && this.dependent_middle_name != '' && this.dependent_birth_month != '' && this.dependent_birth_day != '' && this.dependent_birth_year != '' && this.dependent_sex != '' && this.dependent_contact_no != '' && this.dependent_email_address != '' && this.dependent_email_extension != '' && this.dependent_religion != '' && this.dependent_educational_attainment != '' && this.dependent_occupation != '' && this.dependent_street != '' && this.dependent_house_no != '' && this.dependent_civil_status != '') {
				for(var index1 = 0; index1 < this.addDependents.length; index1++) {
					if(this.currentIndex == index1) {
						this.addDependents[index1].first_name = this.dependent_first_name;
						this.addDependents[index1].last_name = this.dependent_last_name;
						this.addDependents[index1].middle_name = this.dependent_middle_name;
						this.addDependents[index1].birth_month = this.dependent_birth_month;
						this.addDependents[index1].birth_day = this.dependent_birth_day;
						this.addDependents[index1].birth_year = this.dependent_birth_year;
						this.addDependents[index1].sex = this.dependent_sex;
						this.addDependents[index1].contact_no = this.dependent_contact_no;
						this.addDependents[index1].email_address = this.dependent_email_address;
						this.addDependents[index1].email_extension = this.dependent_email_extension;
						this.addDependents[index1].religion = this.dependent_religion;
						this.addDependents[index1].educational_attainment = this.dependent_educational_attainment;
						this.addDependents[index1].occupation = this.dependent_occupation;
						this.addDependents[index1].civil_status = this.dependent_civil_status;
						this.addDependents[index1].street = this.dependent_street;
						this.addDependents[index1].house_no = this.dependent_house_no;
						this.addDependents[index1].subdivision = this.dependent_subdivision;

						swal({
							title : "Congrats!",
							text : "Update dependent details successfully!",
							icon : "success",
							buttons : false,
							timer : 2000,
							closeOnClickOutside : false,
						}).then(() => {
							vm.clearDependentData();
							vm.dependentErrorDefault();
							$('#myModal6').modal('hide');
						})
					}
				}
			}
		},

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
		identifyCivilStatusId : function(civil_status) {
			for(var index = 0; index < this.civil_status.length; index++) {
				if(civil_status == this.civil_status[index].description) {
					return this.civil_status[index].civil_status_id;
				}
			}
		},
		identifyCivilStatus : function(civil_status_id) {
			for(var index = 0; index < this.civil_status.length; index++) {
				if(civil_status_id == this.civil_status[index].civil_status_id) {
					return this.civil_status[index].description;
				}
			}
		},
		identifyHouseNo : function(address) {
			for(var index = 0; index < this.beneficiaries.length; index++) {
				if(address == this.beneficiaries[index].address) {
					var location = this.beneficiaries[index].address.indexOf(',');
					

					return this.beneficiaries[index].address.slice(0, location).trim();
				}
			}
		},
		identifyStreet : function(address) {
			for(var index = 0; index < this.beneficiaries.length; index++) {
				if(address == this.beneficiaries[index].address) {
					var firstLocation = this.beneficiaries[index].address.indexOf(',');
					var secondLocation = this.beneficiaries[index].address.indexOf(',', parseInt(firstLocation + 1));

					return this.beneficiaries[index].address.slice(firstLocation + 1, secondLocation).trim();
				}
			}
		},
		identifySubdivision : function(address) {
			for(var index = 0; index < this.beneficiaries.length; index++) {
				if(address == this.beneficiaries[index].address) {
					var firstLocation = this.beneficiaries[index].address.indexOf(',');
					var secondLocation = this.beneficiaries[index].address.indexOf(',', parseInt(firstLocation + 1));

					return this.beneficiaries[index].address.slice(secondLocation + 2).trim();
				}
			}
		},
		identifyEmail : function(email_address) {
			for(var index = 0; index < this.beneficiaries.length; index++) {
				if(email_address == this.beneficiaries[index].email_address) {
					var firstLocation = this.beneficiaries[index].email_address.indexOf('@');

					return this.beneficiaries[index].email_address.slice(0, firstLocation);
				}
			}
		},
		identifyEmailExtension : function(email_address) {
			for(var index = 0; index < this.beneficiaries.length; index++) {
				if(email_address == this.beneficiaries[index].email_address) {
					var firstLocation = this.beneficiaries[index].email_address.indexOf('@');

					return this.beneficiaries[index].email_address.slice(firstLocation).trim();
				}
			}
		},
		identifyBeneficiaryType : function(beneficiary_type) {
			for(var index = 0; index < this.beneficiary_types.length; index++) {
				if(beneficiary_type == this.beneficiary_types[index].beneficiary_type_id) {
					return this.beneficiary_types[index].description;
				}
			}
		},
		identifyBeneficiary : function(beneficiary_id) {
			for(var index = 0; index < this.beneficiaries.length; index++) {
				if(beneficiary_id == this.beneficiaries[index].beneficiary_id) {
					this.beneficiary_id = this.beneficiaries[index].beneficiary_id;
					this.first_name = this.beneficiaries[index].first_name;
					this.last_name = this.beneficiaries[index].last_name;
					this.middle_name = this.beneficiaries[index].middle_name;
					this.birth_date = this.beneficiaries[index].birth_date;
					this.sex = this.beneficiaries[index].sex;
					this.contact_no = this.beneficiaries[index].contact_no;
					this.email_address = this.identifyEmail(this.beneficiaries[index].email_address)
					this.religion = this.beneficiaries[index].religion;
					this.educational_attainment = this.beneficiaries[index].educational_attainment
					this.occupation = this.beneficiaries[index].occupation;
					this.street = this.identifyStreet(this.beneficiaries[index].address);
					this.house_no = this.identifyHouseNo(this.beneficiaries[index].address);
					this.subdivision = this.identifySubdivision(this.beneficiaries[index].address);
					this.beneficiary_civil_status = this.identifyCivilStatus(this.beneficiaries[index].civil_status_id); 
					this.barangay = this.identifyBarangayName(this.beneficiaries[index].barangay_id);
					this.email_extension = this.identifyEmailExtension(this.beneficiaries[index].email_address);
					this.status = this.beneficiaries[index].status;
					this.balance = this.beneficiaries[index].balance;
					this.beneficiary_type = this.identifyBeneficiaryType(this.beneficiaries[index].beneficiary_type_id);
				}
			}
		},

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
		addBeneficiary : function() {

			this.beneficiaryValidation();

			if(this.addDependents.length == 0) {
				swal({
					title : "Error!",
					text : "Dependent are required!",
					icon : "error",
					buttons : false,
					timer : 2000,
					closeOnClickOutside : false,
				});
			}

			if(this.first_name != '' && this.last_name != '' && this.middle_name != '' && this.birth_date != '' && this.sex != '' && this.contact_no != '' && this.email_address != '' && this.email_extension != '' && this.religion != '' && this.educational_attainment != '' && this.occupation != '' && this.street != '' && this.house_no != '' && this.subdivision != '' && this.beneficiary_civil_status != '' && this.barangay != '') {
				axios.post(this.urlRoot + this.api + "add_4ps_beneficiary.php", {
					beneficiary_id : this.generateBeneficiaryId(),
					first_name : this.first_name,
					last_name : this.last_name,
					middle_name : this.middle_name,
					contact_no : this.contact_no,
					birth_date : this.birth_date,
					email_address : this.email_address,
					sex : this.sex,
					address : this.house_no + ", " + this.street + ", " + this.subdivision,
					occupation: this.occupation,
					educational_attainment : this.educational_attainment,
					religion : this.religion,
					civil_status_id : this.identifyCivilStatusId(this.beneficiary_civil_status),
					status : "Active",
					beneficiary_type_id : "1",
					balance : "0",
					barangay_id : this.identifyBarangayId(this.barangay)
				}).then(function (response) {
					console.log(response);
					
					vm.addBeneficiaryDetails();
				});
			}
		},
		addBeneficiaryDetails : function() {
			var date = new Date();

			axios.post(this.urlRoot + this.api + "add_beneficiary_details.php", {
				date_added :  date.getUTCFullYear() + "-" + this.str_pad(date.getMonth() + 1) + "-" + this.str_pad(date.getDate())
			}).then(function (response) {
				console.log(response);
				vm.addDependent();
			});
		},
		addDependent : function() {
			axios.post(this.urlRoot + this.api + "add_dependent.php", {
				addDependents : this.addDependents,
				barangay_id : this.identifyBarangayId(this.barangay)
			}).then(function (response) {
				console.log(response);
			})
		},
		updateBeneficiary : function() {
			axios.post(this.urlRoot + this.api + "update_4ps_beneficiary.php", {
					beneficiary_id : this.beneficiary_id,
					first_name : this.first_name,
					last_name : this.last_name,
					middle_name : this.middle_name,
					contact_no : this.contact_no,
					birth_date : this.birth_date,
					email_address : this.email_address + this.email_extension,
					sex  : this.sex,
					address : this.house_no + ", " + this.street + ", " + this.subdivision,
					educational_attainment : this.educational_attainment,
					occupation : this.occupation,
					religion : this.religion,
					civil_status_id : this.identifyCivilStatusId(this.beneficiary_civil_status),
					status : this.status,
					beneficiary_type_id : "1",
					balance : this.balance,
					barangay_id : this.identifyBarangayId(this.barangay)
			}).then(function (response) {
				console.log(response);
				$('#myModal1').modal('hide');
				swal({
					title: "Good Job!",
				    text: "Update beneficiary successfully!",
				    icon: "success",
				    timer: 2050,
				    buttons : false,
				    closeOnClickOutside: false
				}).then((value) => {
  					vm.retrieveBeneficiary();
  					vm.clearBeneficiaryData();
  					vm.update_beneficiary = false;
  					vm.beneficiary_list = true;
				});
			});
		},

		addDependentToTemporary : function() {
			this.dependentValidation();

			if(this.dependent_first_name != '' && this.dependent_last_name != '' && this.dependent_middle_name != '' && this.dependent_birth_month != '' && this.dependent_birth_day != '' && this.dependent_birth_year != '' && this.dependent_sex != '' && this.dependent_contact_no != '' && this.dependent_email_address != '' && this.dependent_email_extension != '' && this.dependent_religion != '' && this.dependent_educational_attainment != '' && this.dependent_occupation != '' && this.dependent_street != '' && this.dependent_house_no != '' && this.dependent_civil_status != '') {
				this.add_dependent.first_name = this.dependent_first_name;
				this.add_dependent.last_name = this.dependent_last_name;
				this.add_dependent.middle_name = this.dependent_middle_name;
				this.add_dependent.birth_month = this.dependent_birth_month;
				this.add_dependent.birth_day = this.dependent_birth_day;
				this.add_dependent.birth_year = this.dependent_birth_year;
				this.add_dependent.sex = this.dependent_sex;
				this.add_dependent.contact_no = this.dependent_contact_no;
				this.add_dependent.email_address = this.dependent_email_address;
				this.add_dependent.email_extension = this.dependent_email_extension;
				this.add_dependent.religion = this.dependent_religion;
				this.add_dependent.educational_attainment = this.dependent_educational_attainment;
				this.add_dependent.occupation = this.dependent_occupation;
				this.add_dependent.street = this.dependent_street;
				this.add_dependent.civil_status = this.dependent_civil_status;
				this.add_dependent.subdivision = this.dependent_subdivision;
				this.add_dependent.house_no = this.dependent_house_no;

				swal({
					title : "Congrats!",
					text : "Add dependent successfully!",
					icon : "success",
					buttons : false,
					timer : 1000,
					closeOnClickOutside : false
				}).then(() => {
					vm.addDependents.push({...vm.add_dependent});
					vm.clearDependentData();
					vm.dependentErrorDefault();
					console.log(vm.addDependents);
				})
			}
		},

		// validation
		beneficiaryValidation : function() {
			if(this.first_name == "") {
				this.first_name_error = true;
			}
			else {
				this.first_name_error = false;
			}

			if(this.last_name == "") {
				this.last_name_error = true;
			}
			else {
				this.last_name_error = false;
			}

			if(this.middle_name == "") {
				this.middle_name_error = true;
			}
			else {
				this.middle_name_error = false;
			}

			if(this.birth_date == "") {
				this.birth_date_error = true;
			}
			else {
				this.birth_date_error = false;
			}

			if(this.sex == "") {
				this.sex_error = true;
			}
			else {
				this.sex_error = false;
			}

			if(this.contact_no == "") {
				this.contact_no_error = true;
			}
			else {
				this.contact_no_error = false;
			}

			if(this.email_address == "") {
				this.email_address_error = true;
			}
			else {
				this.email_address_error = false;
			}

			if(this.email_extension == "") {
				this.email_extension_error = true;
			}
			else {
				this.email_extension_error = false;
			}

			if(this.religion == "") {
				this.religion_error = true;
			}
			else {
				this.religion_error = false;
			}

			if(this.educational_attainment == "") {
				this.educational_attainment_error = true;
			}
			else {
				this.educational_attainment_error = false;
			}

			if(this.occupation == "") {
				this.occupation_error = true;
			}
			else {
				this.occupation_error = false;
			}

			if(this.beneficiary_civil_status == "") {
				this.civil_status_error = true;
			}
			else {
				this.civil_status_error = false;
			}

			if(this.street == "") {
				this.street_error = true;
			}
			else {
				this.street_error = false;
			}

			if(this.house_no == "") {
				this.house_no_error = true;
			}
			else {
				this.house_no_error = false;
			}

			if(this.subdivision == "") {
				this.subdivision_error = true;
			}
			else {
				this.subdivision_error = false;
			}

			if(this.barangay == "") {
				this.barangay_error = true;
			}
			else {
				this.barangay_error = false;
			}
		},
		dependentValidation : function() {
			if(this.dependent_first_name == "") {
				this.dependent_first_name_error = true;
			}
			else {
				this.dependent_first_name_error = false;
			}

			if(this.dependent_last_name == "") {
				this.dependent_last_name_error = true;
			}
			else {
				this.dependent_last_name_error = false;
			}

			if(this.dependent_middle_name == "") {
				this.dependent_middle_name_error = true;
			}
			else {
				this.middle_name_error = false;
			}

			if(this.dependent_birth_month == "") {
				this.dependent_birth_month_error = true;
			}
			else {
				this.dependent_birth_month_error = false;
			}

			if(this.dependent_birth_day == "") {
				this.dependent_birth_day_error = true;
			}
			else {
				this.dependent_birth_day_error = false;
			}

			if(this.dependent_birth_year == "") {
				this.dependent_birth_year_error = true;
			}
			else {
				this.dependent_birth_year_error = false;
			}

			if(this.dependent_sex == "") {
				this.dependent_sex_error = true;
			}
			else {
				this.dependent_sex_error = false;
			}

			if(this.dependent_contact_no == "") {
				this.dependent_contact_no_error = true;
			}
			else {
				this.dependent_contact_no_error = false;
			}

			if(this.dependent_email_address == "") {
				this.dependent_email_address_error = true;
			}
			else {
				this.dependent_email_address_error = false;
			}

			if(this.dependent_email_extension == "") {
				this.dependent_email_extension_error = true;
			}
			else {
				this.dependent_email_extension_error = false;
			}

			if(this.dependent_religion == "") {
				this.dependent_religion_error = true;
			}
			else {
				this.dependent_religion_error = false;
			}

			if(this.dependent_educational_attainment == "") {
				this.dependent_educational_attainment_error = true;
			}
			else {
				this.dependent_educational_attainment_error = false;
			}

			if(this.dependent_occupation == "") {
				this.dependent_occupation_error = true;
			}
			else {
				this.dependent_occupation_error = false;
			}

			if(this.dependent_civil_status == "") {
				this.dependent_civil_status_error = true;
			}
			else {
				this.dependent_civil_status_error = false;
			}

			if(this.dependent_street == "") {
				this.dependent_street_error = true;
			}
			else {
				this.dependent_street_error = false;
			}

			if(this.dependent_house_no == "") {
				this.dependent_house_no_error = true;
			}
			else {
				this.dependent_house_no_error = false;
			}
		},


		// clear data methods
		clearDependentData : function() {
			this.dependent_first_name = "";
			this.dependent_last_name = "";
			this.dependent_middle_name = "";
			this.dependent_birth_month = "";
			this.dependent_birth_day = "";
			this.dependent_birth_year = "";
			this.dependent_sex = "";
			this.dependent_contact_no = "";
			this.dependent_email_address = "";
			this.dependent_email_extension = "";
			this.dependent_religion = "";
			this.dependent_educational_attainment = "";
			this.dependent_occupation = "";
			this.dependent_street = "";
			this.dependent_house_no = "";
			this.dependent_subdivision = "";
			this.dependent_civil_status = "";

		},
		clearBeneficiaryData : function() {
			this.beneficiary_id = "";
			this.first_name = "";
			this.last_name = "";
			this.middle_name = "";
			this.birth_date = "";
			this.sex = "";
			this.contact_no = "";
			this.email_address = "";
			this.email_extension = "";
			this.religion = "";
			this.educational_attainment = "";
			this.occupation = "";
			this.street = "";
			this.house_no = "";
			this.subdivision = "";
			this.beneficiary_civil_status = "";
			this.barangay = "";
			this.email_extension = "";
			this.status = "";
			this.balance = "";
			this.beneficiary_type = "";
		},
		beneficiaryErrorDefault : function() {
			this.first_name_error = false;
			this.last_name_error = false;
			this.middle_name_error = false;
			this.birth_date_error = false;
			this.sex_error = false;
			this.contact_no_error = false;
			this.email_address_error = false;
			this.email_extension_error = false;
			this.religion_error = false;
			this.educational_attainment_error = false;
			this.occupation_error = false;
			this.civil_status_error = false;
			this.street_error = false;
			this.house_no_error = false;
			this.subdivision_error = false;
			this.barangay_error = false;
		},
		dependentErrorDefault : function() {
			this.dependent_first_name_error = false;
			this.dependent_last_name_error = false;
			this.dependent_middle_name_error = false;
			this.dependent_birth_date_error = false;
			this.dependent_sex_error = false;
			this.dependent_contact_no_error = false;
			this.dependent_email_address_error = false;
			this.dependent_email_extension_error = false;
			this.dependent_religion_error = false;
			this.dependent_educational_attainment_error = false;
			this.dependent_occupation_error = false;
			this.dependent_civil_status_error = false;
			this.dependent_street_error = false;
			this.dependent_house_no_error = false;
			this.dependent_subdivision_error = false;
		},
		// search methods
		search4psBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "search_4ps_beneficiary.php?keyword=" + this.search_beneficiary)
			.then(function (response) {
				vm.beneficiaries = response.data;
			});
		},

		// retrieves method
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
		retrieveBeneficiaryType : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary_type.php")
			.then(function (response) {
				vm.beneficiary_types = response.data;
			});
		},
		retrieveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_4ps_beneficiary.php")
			.then(function (response) {
				vm.beneficiaries = response.data;
				console.log(response);
			});
		},
		retrieveDependent : function(beneficiary_id) {
			axios.get(this.urlRoot + this.api + "retrieve_dependent.php?beneficiary_id=" + beneficiary_id)
			.then(function (response) {
				console.log(response);
				vm.dependents = response.data;
			})
		},
		retrieveIndigent : function() {
			axios.get(this.urlRoot + this.api + "retrieve_indigent.php")
			.then(function (response) {
				console.log(response);
				vm.indigents = response.data;
			})
		}
		//////////////////////////////
	},
	created() {
		this.retrieveBarangay();
		this.retrieveCivilStatus();
		this.retrieveBeneficiaryType();
		this.retrieveBeneficiary();
		this.getYear();
	}
})