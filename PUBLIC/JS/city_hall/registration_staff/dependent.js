var vm = new Vue({
	el : "#vue-dependent",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/registration_staff/dependent/",

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		////// end of pagination /////////

		// title
		add_dependents : "Add Dependent",
		remove_dependent : "Remove Dependent",
		////////

		dependent_list : true,
		add_dependent_list : false,
		update_dependent_list : false,
		possible_dependent_list : false,

		dependents : [],
		active_beneficiaries : [],
		inactive_beneficiaries : [],
		barangays : [],
		civil_statuses : [],
		addDependents : [],
		add_dependent : {
			fullname : "",
			sex : "",
			civil_status : "",
			educational_attainment : "",
			occupation : "",
			voters_id : "",
		},

		dependent_id : "",
		fullname : "",
		civil_status : "",
		sex : "",
		educational_attainment : "",
		occupation : "",
		beneficiary_id : "Select Beneficiary",

		search_beneficiary_id : "",

		voters_id : "",

		search_dependent: "",
		search_dependent_civil : "",
		search_dependent_status : "",
		filter : "",

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

		//validation method
		checkIfDependentCanActivate : function(voters_id) {
			for(var index = 0; index < this.active_beneficiaries.length; index++) {
				if(voters_id == this.active_beneficiaries[index].voters_id) {
					return true;
				}
			}
		},
		///////////////////

		// toggle button
		toggleAddDependent : function() {
			if(this.dependent_list == true) {
				this.dependent_list = false;
				this.add_dependent_list = true;
			}
			else {
				this.dependent_list = true;
				this.add_dependent_list = false;
			}
		},
		toggleDeactivateDependent : function(dependent_id) {
			this.dependent_id = dependent_id;

			$('#myModal2').modal('show');
		},
		toggleActivateDependent : function(dependent_id, voters_id) {
			this.dependent_id = dependent_id;
			this.voters_id = voters_id;

			$('#myModal3').modal('show');
		},
		toggleSelectDependent : function() {
			$('#myModal1').modal('show');
		},
		toggleDependentList : function(beneficiary_id) {

			if(this.add_dependent_list == true) {
				this.add_dependent_list = false;
				this.possible_dependent_list = true;

				this.beneficiary_id = beneficiary_id;
			}
			else {

				if(this.addDependents.length > 0) {
					swal({
						title : "Are you sure?",
						text : "The selected dependent/s will be discard!",
						icon : "warning",
						buttons : ["Cancel", "Discard"],
						dangerMode: true,
						closeOnClickOutside : false,
					}).then((willDiscard) => {
						if(willDiscard) {
							this.add_dependent_list = true;
							this.possible_dependent_list = false;
							this.addDependents = [];
						}
						else {
						}
					});
				}
				else {
					this.add_dependent_list = true;
					this.possible_dependent_list = false;
				}
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
		identifyBeneficiary : function(beneficiary_id) {
			for(var index = 0; index < this.inactive_beneficiaries.length; index++) {
				if(beneficiary_id == this.inactive_beneficiaries[index].beneficiary_id) {
					this.fullname = this.inactive_beneficiaries[index].first_name + " " + this.inactive_beneficiaries[index].middle_name + " " + this.inactive_beneficiaries[index].last_name;
					this.sex = this.inactive_beneficiaries[index].sex;
					this.civil_status = this.inactive_beneficiaries[index].civil_status_id;
					this.educational_attainment = this.inactive_beneficiaries[index].educational_attainment;
					this.occupation = this.inactive_beneficiaries[index].occupation;
					this.voters_id = this.inactive_beneficiaries[index].voters_id;
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
		//////////////////

		// retrieve method
		retrieveDependent : function() {
			axios.post(this.urlRoot + this.api + "retrieve_dependent.php")
			.then(function (response) {
				console.log(response);
				vm.dependents = response.data;
			})
		},
		retrieveActiveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_active_beneficiary.php")
			.then(function (response) {
				vm.active_beneficiaries = response.data;
			});
		},
		retrieveInactiveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_inactive_beneficiary.php")
			.then(function (response) {
				console.log(response);
				vm.inactive_beneficiaries = response.data;
			});
		},
		retrieveBarangay : function() {
			axios.get(this.urlRoot + this.api + "retrieve_barangay.php")
			.then(function (response) {
				console.log(response);
				vm.barangays = response.data;
			});
		},
		retrieveCivilStatus : function() {
			axios.get(this.urlRoot + this.api + "retrieve_civil_status.php")
			.then(function (response) {
				console.log(response);
				vm.civil_statuses = response.data;
			});
			
		},
		//////////////////

		// search
		searchBeneficiaryId : function() {
			axios.get(this.urlRoot + this.api + "search_beneficiary_id.php?beneficiary_id=" + this.search_beneficiary_id)
			.then(function (response) {
				vm.beneficiaries = response.data;
			});
		},
		/////////
		disabledSelectDependentButton : function(voters_id) {
			for(var index = 0; index < this.addDependents.length; index++) {
				if(voters_id == this.addDependents[index].voters_id) {
					return this.addDependents[index].voters_id
				}
			}
		},

		selectBeneficiary : function(beneficiary_id) {
			this.beneficiary_id = beneficiary_id;
			$('#myModal').modal('hide');
			this.search_beneficiary_id = "";
		},

		removeDependent : function(index) {
			this.addDependents.splice(index, 1);
		},
		/////////////////

		addDependentToTable : function(beneficiary_id) {
			this.identifyBeneficiary(beneficiary_id);

			this.add_dependent.fullname = this.fullname;
			this.add_dependent.sex = this.sex;
			this.add_dependent.civil_status = this.civil_status;
			this.add_dependent.educational_attainment = this.educational_attainment;
			this.add_dependent.occupation = this.occupation;
			this.add_dependent.voters_id = this.voters_id;

			this.addDependents.push({...this.add_dependent});
		},

		/////////////////

		saveDependent : function() {
			if(this.addDependents.length == 0) {
				swal({
					title : "Error!",
					text : "No dependent to save!",
					icon : "error",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				})
			}
			else {
				this.addDependent();

			}
		},
		addDependent : function() {
			axios.post(this.urlRoot + this.api + "add_dependent.php", {
				beneficiary_id : this.beneficiary_id,
				addDependents : this.addDependents
			}).then(function (response) {
				console.log(response);

				if(response.data.status ==  "NOT_OK") {
					swal({
						title : "Error!",
						text : "No dependent to save!",
						icon : "error",
						timer : "1050",
						buttons : false,
						closeOnClickOutside: false
					})
				}
				else {
					vm.updateBeneficiary();
				}
				
			})
		},
		updateBeneficiary : function() {
			axios.post(this.urlRoot + this.api + "update_beneficiary.php", {
				addDependents : this.addDependents
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Great Job!",
					text : "Dependent save successfully!",
					icon : "success",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.addDependents = [];
					vm.toggleDependentList();
					vm.toggleAddDependent();
					vm.retrieveDependent();
					vm.retrieveInactiveBeneficiary();

				});
			})
		},
		deactivateDependent : function() {
			axios.post(this.urlRoot + this.api + "deactivate_dependent.php", {
				dependent_id : this.dependent_id
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Success!",
					text : "Dependent deactivate successfully!",
					icon : "success",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveDependent();
					$('#myModal2').modal('hide');
				})
			});
		},
		activateDependent : function() {
			if(this.checkIfDependentCanActivate(this.voters_id) == true) {
				swal({
					title : "Cannot be activate!",
					text : "Dependent already set as beneficiary!",
					icon : "error",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				})
			}
			else {
				axios.post(this.urlRoot + this.api + "activate_dependent.php", {
					dependent_id : this.dependent_id
				}).then(function (response) {
					console.log(response);
					swal({
						title : "Success!",
						text : "Dependent activate successfully!",
						icon : "success",
						timer : "1050",
						buttons : false,
						closeOnClickOutside: false
					}).then(() => {
						vm.retrieveDependent();
						$('#myModal3').modal('hide');
					});
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
		searchDependent : function() {
			axios.get(this.urlRoot + this.api + "search_dependent.php?filter=" + this.filter + "&keyword=" + this.search_dependent)
			.then(function (response) {
				console.log(response);
				vm.dependents = response.data;
			})
		},

		searchDependentStatus : function() {
			axios.get(this.urlRoot + this.api + "search_dependent.php?filter=" + this.filter + "&keyword=" + this.search_dependent_status)
			.then(function (response) {
				console.log(response);
				vm.dependents = response.data;
			})
			this.search_dependent = "";
		},
		searchDependentCivil : function() {
			axios.get(this.urlRoot + this.api + "search_dependent.php?filter=" + this.filter + "&keyword=" + this.search_dependent_civil)
			.then(function (response) {
				console.log(response);
				vm.dependents = response.data;
			})
			this.search_dependent = "";
		},
	},
	created() {
		this.retrieveDependent();
		this.retrieveActiveBeneficiary();
		this.retrieveInactiveBeneficiary();
		this.retrieveBarangay();
		this.retrieveCivilStatus();
		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})