 var vm = new Vue({
	el : "#vue-4Ps",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/registration_staff_api/",

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

		beneficiary_info : true,
		dependent_info : false,

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
			birth_date : null,
			sex : null,
			contact_no : null,
			email_address : null,
			religion : null,
			educational_attainment : null,
			occupation : null,
			street : null,
			house_no : null,
			subdivision : null,
			civil_status : null,
			barangay : null
		},

		dependent_first_name : "",
		dependent_last_name : "",
		dependent_middle_name : "",
		dependent_birth_date : "",
		dependent_sex : "",
		dependent_contact_no : "",
		dependent_email_address : "",
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

		add_beneficiaries : [],
		add_beneficiary_temporary : {
			first_name : null,
			last_name : null,
			middle_name : null,
			birth_date : null,
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
			barangay : null
		},


	},
	methods : {
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


		toggle4PsBeneficiaryInfo : function() {
			if (this.beneficiary_info == false) {
				this.beneficiary_info = true;
				this.dependent_info = false;
				this.add_new_dependent = false;
			}
			else {
				this.beneficiary_info = false;
				this.dependent_info = false;
				this.add_new_dependent = false;

			}
		},
		toggle4PsDependentInfo : function(beneficiary_id) {
			if (this.dependent_info == false) {
				this.dependent_info = true;
				this.beneficiary_info = false;
				this.add_new_dependent = false;

				this.identifyBeneficiary(beneficiary_id);
			}
			else {
				this.dependent_info = false;
				this.beneficiary_info = true;
				this.add_new_dependent = false;
				this.clearBeneficiaryData();
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
					

					return this.beneficiaries[index].address.slice(0, location);
				}
			}
		},
		identifyStreet : function(address) {
			for(var index = 0; index < this.beneficiaries.length; index++) {
				if(address == this.beneficiaries[index].address) {
					var firstLocation = this.beneficiaries[index].address.indexOf(',');
					var secondLocation = this.beneficiaries[index].address.indexOf(',', parseInt(firstLocation + 1));

					return this.beneficiaries[index].address.slice(firstLocation + 1, secondLocation) ;
				}
			}
		},
		identifySubdivision : function(address) {
			for(var index = 0; index < this.beneficiaries.length; index++) {
				if(address == this.beneficiaries[index].address) {
					var firstLocation = this.beneficiaries[index].address.indexOf(',');
					var secondLocation = this.beneficiaries[index].address.indexOf(',', parseInt(firstLocation + 1));

					return this.beneficiaries[index].address.slice(secondLocation + 2) ;
				}
			}
		},
		identifyEmail : function(email_address) {
			for(var index = 0; index < this.beneficiaries.length; indedx++) {
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

					return this.beneficiaries[index].email_address.slice(firstLocation);
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
		addDependentToTable : function() {
			this.add_dependent.first_name = this.dependent_first_name;
			this.add_dependent.last_name = this.dependent_last_name;
			this.add_dependent.middle_name = this.dependent_middle_name;
			this.add_dependent.birth_date = this.dependent_birth_date;
			this.add_dependent.sex = this.dependent_sex;
			this.add_dependent.contact_no = this.dependent_contact_no;
			this.add_dependent.email_address = this.dependent_email_address;
			this.add_dependent.religion = this.dependent_religion;
			this.add_dependent.educational_attainment = this.dependent_educational_attainment;
			this.add_dependent.occupation = this.dependent_occupation;
			this.add_dependent.street = this.dependent_street;
			this.add_dependent.house_no = this.dependent_house_no;
			this.add_dependent.subdivision = this.dependent_subdivision;
			this.add_dependent.civil_status = this.dependent_civil_status;
			this.add_dependent.barangay = this.dependent_barangay;

			this.addDependents.push({...this.add_dependent});

			this.clearDependentData();
		},
		removeDependent : function(index) {
			this.addDependents.splice(index, 1);
		},
		toggleAddDependent : function() {
			alert("test");
		},



		generateBeneficiaryId : function() {
			var date = new Date();
			var pad = "00000000";

			var id = "";

			if(this.beneficiaries.length == 0) {
				id = "BF-4PS" + "-" + date.getFullYear() + "" + "00000001";
			}
			else {
				for(var index = 0; index < this.beneficiaries.length; index++) {
					id = this.beneficiaries[index].beneficiary_id;
				}
			}

			return id;
		},
		addBeneficiaryTemporarily : function() {
			this.BeneficiaryTemporaryValidation();
			// this.toggleAddDependent();
		},
		addBeneficiary : function() {
			axios.post(this.urlRoot + this.api + "add_4ps_beneficiary.php", {
				beneficiary_id : this.generateBeneficiaryId(),
				first_name : this.first_name,
				last_name : this.last_name,
				middle_name : this.middle_name,
				contact_no : this.contact_no,
				birth_date : this.birth_date,
				email_address : this.email_address,
				sex : this.sex,
				address : this.house_no + " " + this.street + " " + this.subdivision,
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
			})
			// alert(this.identifyCivilStatusId(this.beneficiary_civil_status));
		},
		addBeneficiaryDetails : function() {
			var date = new Date();

			axios.post(this,urlRoot + this.api + "add_beneficiary_details", {
				date_added :  date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate()
			}).then(function (response) {
				console.log(response);
			});
		},
		updateButton : function(beneficiary_id) {
			$('#myModal1').modal('show');

			this.identifyBeneficiary(beneficiary_id);
		},
		updateBeneficiary : function() {
			// alert(this.balance);
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
				});
				
			});
		},
		addBeneficiaryToTemporary : function() {
			this.add_beneficiary_temporary.first_name = this.first_name;
			this.add_beneficiary_temporary.last_name = this.last_name;
			this.add_beneficiary_temporary.middle_name = this.middle_name;
			this.add_beneficiary_temporary.birth_date = this.birth_date;
			this.add_beneficiary_temporary.sex = this.sex;
			this.add_beneficiary_temporary.contact_no = this.contact_no;
			this.add_beneficiary_temporary.email_address = this.email_address;
			this.add_beneficiary_temporary.email_extension = this.email_extension;
			this.add_beneficiary_temporary.religion = this.religion;
			this.add_beneficiary_temporary.educational_attainment = this.educational_attainment;
			this.add_beneficiary_temporary.occupation = this.occupation;
			this.add_beneficiary_temporary.street = this.street;
			this.add_beneficiary_temporary.civil_status = this.beneficiary_civil_status;
			this.add_beneficiary_temporary.barangay = this.barangay;
			this.add_beneficiary_temporary.subdivision = this.subdivision;
			this.add_beneficiary_temporary.house_no = this.house_no;


			this.add_beneficiaries.push({...this.add_beneficiary_temporary});
		},

		// validation
		BeneficiaryTemporaryValidation : function() {
			if(this.first_name == '' || this.last_name == '' || this.middle_name == '' || this.birth_date == '' || this.sex == '' || this.contact_no == '' || this.email_address == '' || this.email_extension == '' || this.religion == '' || this.educational_attainment == '' || this.occupation == '' || this.street == '' || this.house_no == '' || this.beneficiary_civil_status == '' || this.barangay == '') {
				swal({
					title: "Error occur!",
				    text: "Please fill up all!",
				    icon: "error",
				    timer: 2050,
				    buttons : false,
				    closeOnClickOutside: false
				});
			}
			else {
				this.toggleAddDependent();
				this.addBeneficiaryToTemporary();
				console.log(this.add_beneficiaries);
			}

		},


		// clear data methods
		clearDependentData : function() {
			this.dependent_first_name = "";
			this.dependent_last_name = "";
			this.dependent_middle_name = "";
			this.dependent_birth_date = "";
			this.dependent_sex = "";
			this.dependent_contact_no = "";
			this.dependent_email_address = "";
			this.dependent_religion = "";
			this.dependent_educational_attainment = "";
			this.dependent_occupation = "";
			this.dependent_street = "";
			this.dependent_house_no = "";
			this.dependent_subdivision = "";
			this.dependent_civil_status = "";
			this.dependent_barangay = "";

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
		}
	},
	created() {
		this.retrieveBarangay();
		this.retrieveCivilStatus();
		this.retrieveBeneficiaryType();
		this.retrieveBeneficiary();
	}
})