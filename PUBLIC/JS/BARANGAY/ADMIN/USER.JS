var vm = new Vue({
	el : "#vue-user",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/barangay/admin/",

		// titles //
		update_User : "Update User",
		view_User : "View User",
		deactivate_User : "Deactive User",
		activate_user : "Activate User",
		reset_account : "Reset Account",
		///////////////////

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		user_list : true,
		update_user : false,
		view_user : false,

		users : [],
		barangays : [],
		all_users : [],

		username : "",
		password : "",
		new_password : "",

		user_id : "",
		first_name : "",
		last_name : "",
		middle_name : "",
		birth_month : "",
		birth_day : "",
		birth_year : "",
		sex : "",
		contact_no : "",
		email_address : "",
		email_extension : "",
		street : "",
		house_no : "",
		subdivision : "",
		user_type : "",

		username_error : false,
		password_error : false,
		first_name_error : false,
		last_name_error : false,
		middle_name_error : false,
		birth_month_error : false,
		birth_day_error : false,
		birth_year_error : false,
		sex_error : false,
		contact_no_error : false,
		email_address_error : false,
		email_extension_error : false,
		street_error : false,
		house_no_error : false,
		subdivision_error : false,
		user_type_error : false,

		barangay : "",
		barangay_error : false,

		birth_day_description : "",
		birth_year_description : "",
		contact_no_description : "",

		filter : "",
		search_user : "",
	},
	methods : {
		// keypress validation
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
		//////////////////
		// default
		userErrorDefault : function() {
	 		this.username_error = false;
			this.password_error = false;
			this.first_name_error = false;
			this.last_name_error = false;
			this.middle_name_error = false;
			this.contact_no_error = false;
			this.birth_month_error = false;
			this.birth_date_error = false;
			this.birth_year_error = false;
			this.email_address_error = false;
			this.email_extension_error = false;
			this.sex_error = false;
			this.house_no_error = false;
			this.street_error = false;
			this.subdivision_error = false;
			this.user_type_error = false;
			this.barangay_error = false;
	 	},
	 	clearUser : function() {
			this.username = "";
			this.password = "";
			this.new_password = "";
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
			this.house_no = "";
			this.street = "";
			this.subdivision = "";
			this.user_type = "";
			this.barangay = "";
		},
		///////
		// pagination methods
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
	    nextUser: function() {
	      if (this.currentPage < this.totalActiveUser) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    ////////////////

	    // validation method
	    //validation methods
 		userValidation : function() {
 			var date = new Date();
 			if(this.username == "") {
				this.username_error = true;
			}
			else {
				this.username_error = false;
			}

			if(this.password == "") {
				this.password_error = true;
			}
			else {
				this.password_error = false;
			}

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

			if(this.contact_no == "") {
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

			if(this.birth_day == "") {
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

			if(this.birth_year == "") {
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

			if(this.birth_month == "") {
				this.birth_month_error = true;
			}
			else {
				this.birth_month_error = false;
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

			if(this.sex == "") {
				this.sex_error = true;
			}
			else {
				this.sex_error = false;
			}

			if(this.house_no == "") {
				this.house_no_error = true;
			}
			else {
				this.house_no_error = false;
			}

			if(this.street == "") {
				this.street_error = true;
			}
			else {
				this.street_error = false;
			}

			if(this.barangay == "") {
				this.barangay_error = true;
			}
			else {
				this.barangay_error = false;
			}

			if(this.user_type == "") {
				this.user_type_error = true;
			}
			else {
				this.user_type_error = false;
			}
 		},
 		userConfirmation : function() {
 			if(this.username != "" && this.password != "" && this.first_name != "" && this.last_name != "" && this.middle_name != "" && this.birth_date != "" && this.sex != "" && this.contact_no != "" && this.email_address != "" && this.email_extension != "" && this.street != "" && this.house_no != "" && this.barangay != "" && this.user_type != "") {
 				return true;
 			}
 		},
 		checkUsernameIfExist : function() {
 			for(var index = 0; index < this.all_users.length; index++) {
 				if(this.username.toLowerCase() == this.all_users[index].username.toLowerCase()) {
 					return false;
 				}
 			}
 		},
 		checkUsernameIfExistInUpdate : function() {
 			for(var index = 0; index < this.all_users.length; index++) {
 				if(this.user_id != this.all_users[index].user_id) {
 					if(this.username.toLowerCase() == this.all_users[index].username.toLowerCase()) {
 						return false;
 					}
 				}
 				
 			}
 		},
 		checkEmailAddressIfExist : function() {
 			for(var index = 0; index < this.all_users.length; index++) {
 				var email_address = this.email_address + this.email_extension;
 				if(email_address == this.all_users[index].email_address) {
 					return false;
 				}
 			}
 		},
 		checkEmailAddressIfExistInUpdate : function() {
 			for(var index = 0; index < this.all_users.length; index++) {
 				if(this.user_id != this.all_users[index].user_id) {
 					var email_address = this.email_address + this.email_extension;
	 				if(email_address == this.all_users[index].email_address) {
	 					return false;
	 				}
 				}
 				
 			}
 		},
 		checkUserError : function() {
 			if(this.username_error == false && this.password_error == false && this.first_name_error == false && this.last_name_error == false && this.birth_month_error == false && this.birth_day_error == false && this.birth_year_error == false && this.sex_error == false && this.contact_no_error == false && this.email_address_error == false && this.email_extension_error == false && this.street_error == false && this.house_no_error == false && 	this.user_type_error == false) {
 				return true;
 			}
 		},
	    ////////////////////

	    // toggle button
	    toggleUpdateUser : function(user_id) {
	    	if(this.user_list == true) {
	    		this.user_list = false;
	    		this.update_user = true;
	    		this.identifyUser(user_id);


	    	}
	    	else {
	    		this.user_list = true;
	    		this.update_user = false;

	    		this.userErrorDefault();
	    		this.clearUser();
	    	}
	    },
	    toggleViewUser : function(user_id) {
	    	if(this.user_list == true) {
	    		this.user_list = false;
	    		this.view_user = true;
	    		this.identifyUser(user_id);


	    	}
	    	else {
	    		this.user_list = true;
	    		this.view_user = false;
	    	}
	    },
	    togggleDeactivateUser : function(user_id) {
	    	$('#myModal2').modal('show');
	    	this.user_id = user_id;
	    },
	    togggleActivateUser : function(user_id) {
	    	$('#myModal3').modal('show');
	    	this.user_id = user_id;
	    },
	    toggleResetAccount : function(user_id) {
	    	$('#myModal5').modal('show');
	    	this.user_id = user_id;
	    },
	    ////////////////

	    // identify method
	    identifyBarangay : function(barangay_id) {
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
 		identifyUser : function(user_id) {
 			for(var index = 0; index < this.users.length; index++) {
 				if(user_id == this.users[index].user_id) {
 					this.user_id = this.users[index].user_id;
 					this.username = this.users[index].username;
 					this.password = this.users[index].password;
 					this.first_name = this.users[index].first_name;
 					this.last_name = this.users[index].last_name;
 					this.middle_name = this.users[index].middle_name;
 					this.birth_month = this.identifyBirthMonth(this.users[index].birth_date);
 					this.birth_day = this.identifyBirthDay(this.users[index].birth_date);
 					this.birth_year = this.identifyBirthYear(this.users[index].birth_date);
 					this.sex = this.users[index].sex;
 					this.contact_no = this.users[index].contact_no;
 					this.email_address = this.identifyEmail(this.users[index].email_address);
 					this.email_extension = this.identifyEmailExtension(this.users[index].email_address);
 					this.street = this.identifyStreet(this.users[index].address);
 					this.house_no = this.identifyHouseNo(this.users[index].address);
 					this.subdivision = this.identifySubdivision(this.users[index].address);
 					this.user_type = this.identifyUserType(this.users[index].user_type_id);
 				}
 			}
 		},
 		identifyUserType : function(user_type_id) {
 			for(var index = 0; index < this.user_types.length; index++) {
 				if(user_type_id == this.user_types[index].user_type_id) {
 					return this.user_types[index].description;
 				}
 			}
 		},
 		identifyUserTypeId : function(user_type) {
 			for(var index = 0; index < this.user_types.length; index++) {
 				if(user_type == this.user_types[index].description) {
 					return this.user_types[index].user_type_id;
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

	    // retrieve methods
	 	retrieveUser : function(response) {
	 		axios.get(this.urlRoot + this.api + "retrieve_user.php")
	 		.then(function (response) {
	 			console.log(response);
	 			vm.users = response.data;
	 		})
	 	},
	 	retrieveBarangays : function() {
	 		axios.get(this.urlRoot + this.api + "retrieve_barangay.php")
	 		.then(function (response) {
	 			console.log(response);
	 			vm.barangays = response.data;
	 		})
	 	},
	 	retrieveUserType : function() {
	 		axios.get(this.urlRoot + this.api + "retrieve_user_type.php")
	 		.then(function (response) {
	 			console.log(response);
	 			vm.user_types = response.data;
	 		});
	 	},
	 	retrieveAllUser : function() {
	 		axios.get(this.urlRoot + this.api + "retrieve_all_user.php")
	 		.then(function (response) {
	 			console.log(response);
	 			vm.all_users = response.data;
	 		})
	 	},
	 	//////////////////
	 	saveUpdateUser : function() {
	 		this.userValidation();
	 		
	 		if(this.new_password != "") {
	 			this.password = this.new_password;
	 		}

	 		if(this.checkUserError() == true) {
	 			if(this.checkUsernameIfExistInUpdate() == false) {
	 				swal({
						title : "Error!",
						text : "Username already exist!",
						icon : "error",
						timer : "2000",
						buttons : false,
						closeOnClickOutside: false
					});
	 			}
	 			else if (this.checkEmailAddressIfExistInUpdate() == false) {
	 				swal({
						title : "Error!",
						text : "Email Address already exist!",
						icon : "error",
						timer : "3000",
						buttons : false,
						closeOnClickOutside: false
					});
	 			}
	 			else {
	 				this.updateUser();
	 			}
	 		}
	 		
	 	},
	 	updateUser : function() {
	 		axios.post(this.urlRoot + this.api + "update_user.php", {
	 			user_id : this.user_id,
	 			username : this.username,
	 			new_password : this.new_password,
	 			password : this.password,
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
	 			house_no : this.house_no,
	 			street : this.street,
	 			subdivision : this.subdivision,
	 			is_employed : "1",
	 			user_type_id : this.identifyUserTypeId(this.user_type)
	 		}).then(function (response) {
	 			console.log(response);
	 			if(response.data.status == "NOT_OK") {
	 				
					vm.username_error = response.data.username_error;
					vm.password_error = response.data.password_error;
					vm.first_name_error = response.data.first_name_error;
					vm.last_name_error = response.data.last_name_error;
					vm.middle_name_error = response.data.middle_name_error;
					vm.contact_no_error = response.data.contact_no_error;
					vm.birth_month_error = response.data.birth_month_error;
					vm.birth_day_error = response.data.birth_day_error;
					vm.birth_year_error = response.data.birth_year_error;
					vm.email_address_error = response.data.email_address_error;
					vm.email_extension_error = response.data.email_extension_error;
					vm.sex_error = response.data.sex_error;
					vm.house_no_error = response.data.house_no_error;
					vm.street_error = response.data.street_error;
					vm.user_type_error = response.data.user_type_error;

					vm.birth_day_description = response.data.birth_day_description;
					vm.birth_year_description = response.data.birth_year_description;
					vm.contact_no_description = response.data.contact_no_description;	
	 			}
	 			else {
	 				swal({
						title : "Success!",
						text : "User update successfully!",
						icon : "success",
						timer : "1050",
						buttons : false,
						closeOnClickOutside: false
					}).then(() => {
						vm.retrieveUser();
		 				vm.clearUser();
		 				vm.userErrorDefault();
		 				vm.toggleUpdateUser('');

					});
	 			} 
	 		});
	 	},
	 	deactivateUser : function() {
	 		axios.post(this.urlRoot + this.api + "deactivate_user.php", {
	 			user_id : this.user_id
	 		}).then(function (response) {
	 			console.log(response);
	 			swal({
					title : "Success!",
					text : "User deactivate successfully!",
					icon : "success",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveUser();
	 				vm.clearUser();
	 				vm.userErrorDefault();
	 				$('#myModal2').modal('hide');
				});
	 		});
	 	},
	 	activateUser : function() {
	 		axios.post(this.urlRoot + this.api + "activate_user.php", {
	 			user_id : this.user_id
	 		}).then(function (response) {
	 			console.log(response);
	 			swal({
					title : "Success!",
					text : "User activate successfully!",
					icon : "success",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveUser();
	 				vm.clearUser();
	 				vm.userErrorDefault();
	 				$('#myModal3').modal('hide');
				});
	 		})
	 	},
	 	resetAccount : function() {
	 		axios.post(this.urlRoot + this.api + "reset_account.php", {
	 			user_id : this.user_id
	 		}).then(function (response) {
	 			console.log(response);
	 			swal({
					title : "Success!",
					text : "Account reset successfully!",
					icon : "success",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveUser();
	 				$('#myModal5').modal('hide');
				});
	 		});
	 	},
	 	searchUser : function() {
			axios.get(this.urlRoot + this.api + "search_user.php?filter=" + this.filter + "&keyword=" + this.search_user)
			.then(function (response) {
				console.log(response);
				vm.users = response.data;
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
	},
	created() {
		this.retrieveUser();
	 	this.retrieveBarangays();
	 	this.retrieveUserType();
	 	this.retrieveAllUser();

	 	setInterval(() => {
			this.getSession();
		}, 3000)
	}
});