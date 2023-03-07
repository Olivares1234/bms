 var vm = new Vue({
	el : "#vue-city-hall",
	data : {
		urlRoot : "/bms/public/", 
		api : "api's/city_hall_api/",

		// for buttons //
		editDisabled : false,
		editedUser : null,
 
		////////////////

		// errors //

		username_error : false,
		password_error : false,
		first_name_error : false,
		last_name_error : false,
		middle_name_error : false,
		contact_no_error : false,
		birth_date_error : false,
		email_address_error : false,
		sex_error : false,
		address_error : false,
		is_employed_error : false,
		barangay_name_error : false,
		user_type_id_error : false,

		supplier_id_error : false,
    	supplier_name_error : false,
    	supplier_address_error : false,
    	supplier_contact_no_error : false,
    	supplier_status_error : false,

    	supplier_medicine_name_error : false,
		supplier_medicine_category_id_error : false,
		supplier_medicine_unit_id_error : false,
		supplier_medicine_price_error : false,
		supplier_id_error : false,



		///////////

		////// start of barangay data /////////
		barangays : [],
		barangay_name : "",
		brangay_id : "",
		barangay_inventories : [],
		barangay_url : "",

		////// end of barangay data /////////

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		// titles //
		add_User : "Add User",
		update_User : "Update User",
		deactivate_User : "Deactive User",
		activate_user : "Activate User",

		view_Medicine : "View Medicine",
		add_Medicine : "Add Medicine",

		update_Quantity : "Update Quantity",
		save_Quantity : "Save Quantity",
		delete_Row : "Delete Row",

		add_Supplier : "Add Supplier",
		update_Supplier : "Update Supplier",

		update_Medicine : "Update Medicine",

		view_Order : "View Order",
		///////////

		active_users : [],
		userButtonToggle : true,
		search_user: "",

		user_id : "",
		first_name : "",
		middle_name : "",
		last_name : "",
		contact_no : "",
		birth_date : "",
		email_address : "",
		sex : "",
		address : "",
		is_employed : "",
		barangay_id : "",
		username : "",
		password : "",
		new_password : "",
		user_type_id : "",
		userButtonToggle : true,
		search_user: "",
		user_username : "",
		user_password : "",
		user_user_id : "",
		active_user : [],
		current_user : [],
		search_user_status : "",
		search_notUser : "",

		not_active_users : [],
		search_not_user : "",

		medicines : [],

		suppliers : [],
		supplier_id : "",
		supplier_name : "",
		search_supplier : "",
		supplier_address : "",
    	supplier_contact_no : "",
    	supplier_status : "",

		barangays : [],

		showPurchaseOrder : true,
		purchase_order_to_carts : [],
    	add_purchase_orders : {
			medicine_id : null,
			medicine_name : null,
			category : null,
			unit_category : null,
			quantity : null,
			price : null,
			supplier : null
		},
		purchase_order_medicine_quantity : 1,

		purchase_order_using_id : [],

		supplier_medicines : [],
		search_supplier_medicine : "",
		supplier_medicine_info : false,
		supplier_medicine_name : "",
		supplier_medicine_price : "",
		supplier_medicine_category_id : "",
		supplier_medicine_category : "",
		supplier_medicine_unit_id : "",
		supplier_medicine_unit : "",
		search_medicine : "",

		showPurchaseReceipt : false,

		categories : [],

		unit_categories : [],


		// new added
		request_orders : [],
		request_order_id : "",
		request_order_info  : true,
		request_order_details : [],
		search_request_order : "",
		request_order_supplier_medicine_id : "",

		request_order_medicine_info : false,
		request_order_details_id : "",
		request_order_details_medicine_name : "",
		request_order_details_category : "",
		request_order_details_unit : "",
		request_order_details_price : "",
 

		request_details : [],

		send_orders : [],
		send_order_id : "",
		send_quantity : "",
		send_order_supplier_medicine_id : "",
		send_quantity_error : false,
		search_request_order_details : "",

		//newly added
		request_order_receipt : false,
		request_receipt_history : false,
		street : "",
		house_no : "", 
		email_extension : "",
		subdivision : "",

		send_order_print_id : "",
		request_order_barangay_name : "",
		request_order_contact_number : "",


		medicines : [],

		send_order_details : [],
	},
	methods : {
		clearRequestQuantity : function() {
			this.send_quantity = "";

			this.send_quantity_error = false;
		},
		clearUser : function() {
			this.username = "";
			this.password = "";
			this.first_name = "";
			this.last_name = "";
			this.middle_name = "";
			this.contact_no = "";
			this.birth_date = "";
			this.email_address = "";
			this.sex = "";
			this.address = "";
			this.is_employed = "";
			this.barangay_name = "";
			this.user_type_id = "";

			this.username_error = false;
			this.password_error = false;
			this.first_name_error = false;
			this.last_name_error = false;
			this.middle_name_error = false;
			this.contact_no_error = false;
			this.birth_date_error = false;
			this.email_address_error = false;
			this.sex_error = false;
			this.address_error = false;
			this.is_employed_error = false;
			this.barangay_name_error = false;
			this.user_type_id_error = false;
		},
		clearSupplier : function() {
			this.supplier_name = "";
			this.supplier_address = "";
			this.supplier_contact_no = ""; 

			this.supplier_name_error = false;
			this.supplier_address_error = false;
			this.supplier_contact_no_error = false;
		},
		nextBarangayInventory: function() {
	    	if (this.currentPage < this.totalBarangayInventory) {
	        	this.pagination(this.currentPage + 1);
	      }
	    },
		nextMedicine: function() {
	      if (this.currentPage < this.totaMedicine) {
	        this.pagination(this.currentPage + 1);
	      }
	    }, 
		onlyForCurrency($event) {
	       let keyCode = ($event.keyCode ? $event.keyCode : $event.which);

	       if ((keyCode < 48 || keyCode > 57) && (keyCode !== 46 || this.price.indexOf('.') != -1)) { // 46 is dot
	        	$event.preventDefault();
	       }

	       if(this.price!=null && this.price.indexOf(".") > -1 && (this.price.split('.')[1].length > 1)){
	       		$event.preventDefault();
	   		}
     	},
		nextSupplier: function() {
	      if (this.currentPage < this.totalSupplier) {
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
		showEntries_two : function(value) {
         	this.endIndex = value;
         	this.pagination_two(1);
         	alert(this.endIndex);
		},
		pagination_two : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries_two) - this.show_entries_two;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries_two);
		},
		isNumber : function(evt) {
			evt = (evt) ? evt : window.event;
      		var charCode = (evt.which) ? evt.which : evt.keyCode;

      		if ((charCode > 31 && (charCode < 48 || charCode > 57 || charCode == 189)) || charCode == 46) {
        		evt.preventDefault();
      		} 
      		else {
        		return true;
      		}
		},
		savePurchaseData : function (medicine_id) {
    		this.editDisabled = false;
			this.editUser = null;
			this.beforEditCache = null;
			this.editedUser = null;
			swal("Congrats!", "Successfully Update", "success");
    		
    	},
		editData : function (transaction) {
		    this.editDisabled = true;
		    this.beforEditCache = transaction;
		    this.editedUser = transaction;
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
	    nextActiveUser: function() {
	      if (this.currentPage < this.totalActiveUser) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
		isLetter(event) {
          	if (!(event.key.toLowerCase() >= 'a' && event.key.toLowerCase() <= 'z' || event.key == ' '))
                event.preventDefault();
        },
        isNumberKeyWithDash : function(evt) {
			var charCode = (evt.which) ? evt.which : evt.keyCode;

			if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57)) {
			   	evt.preventDefault();
      		} 
      		else {
        		return true;
      		}
		},
		retrieveBarangay : function() {
			axios({
				method : "GET",
				url : this.urlRoot + this.api + "retrieve_barangay.php"
			}).then(function (response){
				vm.barangays = response.data;
			});
		},
		// user
		retrieveActiveUser : function() {
			axios({
				method : "GET",
				url : this.urlRoot + this.api + "retrieve_user.php"
			}).then(function (response){
				vm.active_users = response.data;
				console.log(response);
			});
		},
		countActiveUser : function() {
			var count_user = 0;
			for(var index = 0; index < this.active_users.length; index++){
				count_user++;
			}
			return count_user;
		},
		// medicine
		retrieveMedicine : function() {
			axios({
				method : "GET",
				url : this.urlRoot + this.api +  "retrieve_medicine.php"
			}).then(function (response){
				vm.medicines = response.data;
			});
		},
		countMedicine : function() {
			var count = 0;
			for(var index = 0; index < this.medicines.length; index++){
				count++;
			}
			return count;
		},

		retrieveSupplier : function() {
			axios({
				method : "GET",
				url : this.urlRoot + this.api + "retrieve_supplier.php"
			}).then(function (response){
				vm.suppliers = response.data;
			});
		},
		countSupplier : function() {
			var count_supplier = 0;
			for(var index = 0; index < this.suppliers.length; index++){
				count_supplier++;
			}
			return count_supplier;
		},
		userToggle : function() {
			if(this.userButtonToggle == true){
				this.userButtonToggle = false;
			}
			else {
				this.userButtonToggle = true;
			}
		},
		addUserButton : function() {
			this.username_error = false;
			this.password_error = false;
			this.first_name_error = false;
			this.last_name_error = false;
			this.middle_name_error = false;
			this.contact_no_error = false;
			this.birth_date_error = false;
			this.email_address_error = false;
			this.sex_error = false;
			this.address_error = false;
			this.is_employed_error = false;
			this.barangay_name_error = false;
			this.user_type_id_error = false;
			this.received_quantity_error = false;
			this.expiration_date_error = false;


			$("#myModal").modal("show");
		},
		checkUserIfExist : function() {
			for(var index = 0; index < this.active_users.length; index++) {
				if(this.username.toLowerCase() == this.active_users[index].username.toLowerCase() && this.first_name.toLowerCase() == this.active_users[index].first_name.toLowerCase() && this.last_name.toLowerCase() == this.active_users[index].last_name.toLowerCase() && this.middle_name.toLowerCase() == this.active_users[index].middle_name.toLowerCase() && this.contact_no.toLowerCase() == this.active_users[index].contact_no.toLowerCase() && this.birth_date.toLowerCase() == this.active_users[index].birth_date.toLowerCase() && this.email_address.toLowerCase() == this.active_users[index].email_address.toLowerCase() && this.sex.toLowerCase() == this.active_users[index].sex.toLowerCase() && this.address.toLowerCase() == this.active_users[index].address.toLowerCase() && this.is_employed == this.active_users[index].is_employed && this.barangay_id == this.active_users[index].barangay_id && this.user_type_id == this.active_users[index].user_type_id) {
					return false;
				}
			}
		},
		addUserValidation : function() {
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

			if(this.middle_name == "") {
				this.middle_name_error = true;
			}
			else {
				this.middle_name_error = false;
			}

			if(this.contact_no == "") {
				this.contact_no_error = true;
			}
			else {
				this.contact_no_error = false;
			}

			if(this.birth_date == "") {
				this.birth_date_error = true;
			}
			else {
				this.birth_date_error = false;
			}

			if(this.email_address == "") {
				this.email_address_error = true;
			}
			else {
				this.email_address_error = false;
			}

			if(this.sex == "") {
				this.sex_error = true;
			}
			else {
				this.sex_error = false;
			}

			if(this.address == "") {
				this.address_error = true;
			}
			else {
				this.address_error = false;
			}

			if(this.barangay_name == "") {
				this.barangay_name_error = true;
			}
			else {
				this.barangay_name_error = false;
			}

			if(this.user_type_id == "") {
				this.user_type_id_error = true;
			}
			else {
				this.user_type_id_error = false;
			}
		},
		addUser : function() {
			this.is_employed = 1;

			for(var index = 0; index < this.barangays.length; index++) {
				if(this.barangay_name == this.barangays[index].barangay_name) {
					this.barangay_id = this.barangays[index].barangay_id;
				}
			}

			this.addUserValidation();

			if(this.username != "" && this.password != "" && this.first_name != "" && this.last_name != "" && this.middle_name != "" && this.contact_no != "" && this.birth_date != "" && this.email_address != "" && this.sex != "" && this.address != "" && this.is_employed != "" && this.barangay_id != "" && this.user_type_id != "") {
				if(this.checkUserIfExist() == false) {
					swal("Error!", " User already exist in active users!", "error");
				}
				else {
					axios({
						method : "POST",
						url : this.urlRoot + this.api + "add_user.php",
						data : {
							username : this.username,
							password : this.password,
							first_name : this.first_name,
							last_name : this.last_name,
							middle_name : this.middle_name,
							contact_no : this.contact_no,
							birth_date : this.birth_date,
							email_address : this.email_address,
							sex : this.sex,
							address : this.address,
							is_employed : 1,
							barangay_id : this.barangay_id,
							user_type_id : this.user_type_id
						}
					}).then(function (response){
						console.log(response);
						if(response.status == 200) {
							vm.retrieveActiveUser();
							vm.retrieveNotActiveUser();
							swal("Congrats!", " User added successfully!", "success");	
							vm.clearUser();

							vm.username_error = false;
							vm.password_error = false;
							vm.first_name_error = false;
							vm.last_name_error = false;
							vm.middle_name_error = false;
							vm.contact_no_error = false;
							vm.birth_date_error = false;
							vm.email_address_error = false;
							vm.sex_error = false;
							vm.address_error = false;
							vm.is_employed_error = false;
							vm.barangay_name_error = false;
							vm.user_type_id_error = false;

							$('#myModal').modal('hide');
						}
						else {
							vm.username_error = response.data.username_error;
							vm.password_error = response.data.password_error;
							vm.first_name_error = response.data.first_name_error;
							vm.last_name_error = response.data.last_name_error;
							vm.middle_name_error = response.data.middle_name_error;
							vm.contact_no_error = response.data.contact_no_error;
							vm.birth_date_error = response.data.birth_date_error;
							vm.email_address_error = response.data.email_address_error;
							vm.sex_error = response.data.sex_error;
							vm.address_error = response.data.address_error;
							vm.is_employed_error = response.data.is_employed_error;
							vm.barangay_name_error = response.data.barangay_name_error;
							vm.user_type_id_error = response.data.user_type_id_error;
						}
					});
				}
			}
		},
		updateUserButton : function(user_id,first_name,last_name,middle_name,contact_no,birth_date,email_address,sex,address,is_employed,barangay_id,username,password,user_type_id) {
			this.user_id = user_id;
			this.first_name = first_name;
			this.last_name = last_name;
			this.middle_name = middle_name;
			this.contact_no = contact_no
			this.birth_date = birth_date;
			this.email_address = email_address;
			this.sex = sex;
			this.address = address;
			this.barangay_name = barangay_id;
			this.is_employed = is_employed;
			this.username = username;
			this.password = password;
			this.user_type_id = user_type_id;
		},
		updateUser : function() {
			for(var index = 0; index < this.barangays.length; index++){
				if(this.barangays[index].barangay_name == this.barangay_name){
					this.barangay_id = this.barangays[index].barangay_id;
				}
			}
			if(this.username == "") {
				this.username_error = true;
			}
			else {
				this.username_error = false;
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

			if(this.middle_name == "") {
				this.middle_name_error = true;
			}
			else {
				this.middle_name_error = false;
			}

			if(this.contact_no == "") {
				this.contact_no_error = true;
			}
			else {
				this.contact_no_error = false;
			}

			if(this.birth_date == "") {
				this.birth_date_error = true;
			}
			else {
				this.birth_date_error = false;
			}

			if(this.email_address == "") {
				this.email_address_error = true;
			}
			else {
				this.email_address_error = false;
			}

			if(this.sex == "") {
				this.sex_error = true;
			}
			else {
				this.sex_error = false;
			}

			if(this.address == "") {
				this.address_error = true;
			}
			else {
				this.address_error = false;
			}

			if(this.is_employed == "") {
				this.is_employed_error = true;
			}
			else {
				this.is_employed_error = false;
			}

			if(this.barangay_name == "") {
				this.barangay_name_error = true;
			}
			else {
				this.barangay_name_error = false;
			}

			if(this.user_type_id == "") {
				this.user_type_id_error = true;
			}
			else {
				this.user_type_id_error = false;
			}

			if(this.new_password != "") {
				this.password = this.new_password;
			}

			if(this.user_id != "" && this.username != "" && this.first_name != "" && this.last_name != "" &&this.middle_name != "" && this.contact_no != "" && this.birth_date != "" && this.email_address != "" && this.sex != "" && this.address != "" && this.is_employed != "" && this.barangay_id != "" && this.user_type_id != "") {
				axios({
					method : "POST",
					url : this.urlRoot + this.api + "update_user.php",
					data : {
						user_id : this.user_id,
						username : this.username,
						password : this.password,
						first_name : this.first_name,
						last_name : this.last_name,
						middle_name : this.middle_name,
						contact_no : this.contact_no,
						birth_date : this.birth_date,
						email_address : this.email_address,
						sex : this.sex,
						address : this.address,
						is_employed : this.is_employed,
						barangay_id : this.barangay_id,
						user_type_id : this.user_type_id
					}
				}).then(function (response){
					console.log(response);
					if(response.data.status == "OK") {
						vm.retrieveActiveUser();
						vm.retrieveNotActiveUser();
						swal("Congrats!", " Update user successfully!", "success");	
						vm.clearUser();

						vm.username_error = false;
						vm.first_name_error = false;
						vm.last_name_error = false;
						vm.middle_name_error = false;
						vm.contact_no_error = false;
						vm.birth_date_error = false;
						vm.email_address_error = false;
						vm.sex_error = false;
						vm.address_error = false;
						vm.is_employed_error = false;
						vm.barangay_name_error = false;
						vm.user_type_id_error = false;

						$('#myModal1').modal('hide');
					}
					else {
						vm.username_error = response.data.username_error;
						vm.username_error = response.data.username_error;
						vm.first_name_error = response.data.first_name_error;
						vm.last_name_error = response.data.last_name_error;
						vm.middle_name_error = response.data.middle_name_error;
						vm.contact_no_error = response.data.contact_no_error;
						vm.birth_date_error = response.data.birth_date_error;
						vm.email_address_error = response.data.email_address_error;
						vm.sex_error = response.data.sex_error;
						vm.address_error = response.data.address_error;
						vm.is_employed_error = response.data.is_employed_error;
						vm.barangay_name_error = response.data.barangay_name_error;
						vm.user_type_id_error = response.data.user_type_id_error;
					}
				});
			}
		},
		searchUser : function() {
			axios({
				method : "GET",
				url : this.urlRoot + this.api + "search_user.php?keyword=",
				params : {
					keyword : this.search_user
				}
			}).then(function (response){
				vm.active_users = response.data;
			});
		},
		searchUserStatus : function() {
			axios({
				method : "GET",
				url : this.urlRoot + this.api + "search_user_status.php?keyword=",
				params : {
					keyword : this.search_user_status
				}
			}).then(function (response){
				vm.active_users = response.data;
			});
		},
		retrieveNotActiveUser : function() {
			axios({
				method : "GET",
				url : this.urlRoot + this.api + "retrieve_inactive_user.php"
			}).then(function (response){
				vm.not_active_users = response.data;
			});
		},
		countNotActiveUser : function() {
			var count_user = 0;
				for(var index = 0; index < this.not_active_users.length; index++){
					count_user++;
				}
			return count_user;
		},
		searchNotUser : function() {
			axios({
				method : "GET",
				url : this.urlRoot + this.api + "search_inactive_user.php?keyword=",
				params : {
					keyword : this.search_not_user
				}
			}).then(function (response){
				vm.not_active_users = response.data;
			});
		},
		deactivateUserButton(user_id, first_name, last_name, middle_name, contact_no, birth_date, email_address, sex, address, is_employed, barangay_name, username, password, user_type_id) {
			this.user_id = user_id;
			this.username = username;
			this.password = password;
			this.first_name = first_name;
			this.last_name = last_name;
			this.middle_name = middle_name;
			this.contact_no = contact_no;
			this.birth_date = birth_date;
			this.email_address = email_address;
			this.sex = sex;
			this.address = address;
			this.is_employed = "0";
			this.barangay_name = barangay_name;
			this.user_type_id = user_type_id;

		},
		deactivateUser : function() {
			for(var index = 0; index < this.barangays.length; index++){
				if(this.barangays[index].barangay_name == this.barangay_name){
					this.barangay_id = this.barangays[index].barangay_id;
				}
			}
			
			axios({
				method : "POST",
				url : this.urlRoot + this.api + "deactivate_user.php",
				data : {
					user_id : this.user_id,
					username : this.username,
					password : this.password,
					first_name : this.first_name,
					last_name : this.last_name,
					middle_name : this.middle_name,
					contact_no : this.contact_no,
					birth_date : this.birth_date,
					email_address : this.email_address,
					sex : this.sex,
					address : this.address,
					is_employed : this.is_employed,
					barangay_id : this.barangay_id,
					user_type_id : this.user_type_id
				} 
			}).then(function (response){
				console.log(response);
				vm.retrieveActiveUser();
				vm.retrieveNotActiveUser();
				swal("Congrats!", " Deactivate user successfully!", "success");	
			});
		},
		activateUser : function() {
			for(var index = 0; index < this.barangays.length; index++){
				if(this.barangays[index].barangay_name == this.barangay_name){
					this.barangay_id = this.barangays[index].barangay_id;
				}
			}

			this.is_employed = 1;
			axios({
				method : "POST",
				url : this.urlRoot + this.api + "update_user.php",
				data : {
					user_id : this.user_id,
					username : this.username,
					password : this.password,
					first_name : this.first_name,
					last_name : this.last_name,
					middle_name : this.middle_name,
					contact_no : this.contact_no,
					birth_date : this.birth_date,
					email_address : this.email_address,
					sex : this.sex,
					address : this.address,
					is_employed : this.is_employed,
					barangay_id : this.barangay_id,
					user_type_id : this.user_type_id
				}
			}).then(function (response){
				vm.retrieveActiveUser();
				vm.retrieveNotActiveUser();
				swal("Congrats!", " Deactivate user successfully!", "success");	
			});
		},
		showSupplierMedicine : function() {
			if(this.supplier_name == "") {
				swal('Warning', ' Select supplier first!', 'warning');
				$('#myModal6').modal('hide');
			}
			else {
				$('#myModal6').modal('show');
			}
		},
		retrievePurchaseOrder : function() {
			axios({
				method : "GET",
				url : this.urlRoot + this.api + "retrieve_purchase_order.php"
			}).then(function (response){
				vm.purchase_order_using_id = response.data;
			});
		},
		countPurchaseOrder : function() {
			var count = 0;
			for(var index = 0; index < this.purchase_order_to_carts.length; index++) {
				count++;
			}
			return count;
		},
		purchaseOrderButton : function(id){
			this.purchase_order_medicine_id = id;
		},
		purchaseOrderAddToCart : function() {

			var found1 = true;
			var found2 = false;

			for(var index = 0; index < this.supplier_medicines.length; index++) {
				if(this.purchase_order_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
					this.add_purchase_orders.medicine_id = this.supplier_medicines[index].supplier_medicine_id;
					this.add_purchase_orders.medicine_name = this.supplier_medicines[index].medicine_name;
					this.add_purchase_orders.category = this.supplier_medicines[index].description;
					this.add_purchase_orders.unit_category = this.supplier_medicines[index].unit;
					this.add_purchase_orders.price = this.supplier_medicines[index].price;
					this.add_purchase_orders.quantity = this.purchase_order_medicine_quantity;
					this.add_purchase_orders.supplier = this.supplier_medicines[index].supplier_name;
				}
			}

			for(var index1 = 0; index1 < this.purchase_order_to_carts.length; index1++) {
				if (this.add_purchase_orders.medicine_id == this.purchase_order_to_carts[index1].medicine_id) {
					var quantity = parseInt(this.add_purchase_orders.quantity) + parseInt(this.purchase_order_to_carts[index1].quantity);

					found1 = false;
					found2 = true;

					this.purchase_order_to_carts[index1].quantity = quantity;
				}
			}

			if(found1) {
				this.purchase_order_to_carts.push({...this.add_purchase_orders});
				$("#myModal6").modal("show");
				$("#myModal3").modal("hide");
			}

			if(found2) {
				$("#myModal6").modal("show");
				$("#myModal3").modal("hide");
			}
		},
		generatePurchaseOrderID : function() {
			var  id = "";
			var pad = "0000";
			var date = new Date();

			if(this.purchase_order_using_id.length <= 0) {
				id = "PO" +  date.getUTCFullYear() + "0001";
			}
			else {
				for(var index = 0; index < this.purchase_order_using_id.length; index++) {
					id = this.purchase_order_using_id[index].purchase_order_id;

				}

				id = id.slice(6);
				id = pad.substring(0, pad.length - id.length) + id;
				id = date.getUTCFullYear() + "" + id;
				id = parseInt(id) + 1;
				id = "PO" + id;
			}
			return id;
		},
		addPurchaseOrder : function() {
			var date = new Date();
			var year = date.getFullYear();
			var month = date.getMonth() + 1;
			var day = date.getDate();

			if(this.purchase_order_to_carts.length == 0) {
				swal("Error!", " No item/s to purchase", "error");
			}
			else {
				axios.post(this.urlRoot + this.api + "add_purchase_order.php", {
					purchase_order_id : this.generatePurchaseOrderID(),
					date_ordered : year + "-" + month + "-" + day
				}).then(function (response) {
					console.log(response);
					vm.addPurchaseOrderDetails();
				});
			}
		},
		addPurchaseOrderDetails : function() {
			axios.post(this.urlRoot + this.api + "add_purchase_order_details.php", {
				purchase_order_to_carts : this.purchase_order_to_carts
			}).then(function (response) {
				console.log(response);
				vm.showPurchaseReceipt = true;
				vm.showPurchaseOrder = false;

				swal("Success!", " Purchase order successfully!", "success");
				vm.addPurchaseDetails();
			})
		},
		addPurchaseDetails : function() {
			axios.post(this.urlRoot + this.api + "add_purchase_details.php", {
				purchase_order_to_carts : this.purchase_order_to_carts
			}).then(function (response) {
				console.log(response);
			});
		},
		retrieveSupplierMedicineInPurchase : function() {

			for(var index = 0; index < this.suppliers.length; index++) {
				if(this.suppliers[index].supplier_name === this.supplier_name) {
					this.supplier_id = this.suppliers[index].supplier_id;
					break;
				}
			}
			this.retrieveSupplierMedicine(this.supplier_id);

		},
		retrieveSupplierMedicine : function(supplier_id) {
			axios.get(this.urlRoot + this.api + "retrieve_supplier_medicine.php?supplier_id=" + supplier_id)
			.then(function (response) {
				vm.supplier_medicines = response.data;
			});
		},
		countSupplierMedicine : function() {
			var count = 0;

			for(var index = 0; index < this.supplier_medicines.length; index++) {
				count++;
			}

			return count;
		},
		searchSupplierMedicine : function() {
			for(var index = 0; index < this.suppliers.length; index++) {
				if(this.supplier_name == this.suppliers[index].supplier_name) {
					this.supplier_id = this.suppliers[index].supplier_id;
				}
			}

			axios.get(this.urlRoot + this.api + "search_supplier_medicine.php?supplier_id=" + this.supplier_id + "&keyword=" + this.search_supplier_medicine)
			.then(function (response) {
				vm.supplier_medicines = response.data;
			});
		},
		removePurchaseOrder : function(index) {
    		this.purchase_order_to_carts.splice(index, 1);
    	},
    	searchSupplier : function() {
    		axios.get(this.urlRoot + this.api + "search_supplier.php?keyword=" + this.search_supplier)
    		.then(function (response) {
    			vm.suppliers = response.data;
    		});
		},
		toggleSupplierInfo : function(id) {
			if(this.supplier_medicine_info == false) {
				this.supplier_medicine_info = true;
			}
			else {
				this.supplier_medicine_info = false;
			} 

			this.supplier_id = id;

			this.retrieveSupplierMedicine(this.supplier_id);
		},
		updateButton : function(id,name,address,contact_no,status) {
			this.supplier_id = id;
			this.supplier_name = name;
			this.supplier_address = address;
			this.supplier_contact_no = contact_no;
			this.supplier_status = status;
		},
		addSupplierValidation : function() {
			if(this.supplier_name == "") {
				this.supplier_name_error = true;
			}
			else {
				this.supplier_name_error = false;
			}

			if(this.supplier_address == "") {
				this.supplier_address_error = true;
			}
			else {
				this.supplier_address_error = false;
			}

			if(this.supplier_contact_no == "") {
				this.supplier_contact_no_error = true;
			}
			else {
				this.supplier_contact_no_error = false;
			}
		},
		checkSupplierIfExist : function() {
			for(var index = 0; index < this.suppliers.length; index++) {
				if(this.supplier_name.toLowerCase() == this.suppliers[index].supplier_name.toLowerCase() && this.supplier_address.toLowerCase() == this.suppliers[index].supplier_address.toLowerCase() && this.supplier_contact_no == this.suppliers[index].supplier_contact_no) {
					return false;
				}
			}
		},
		addSupplier : function() {
			this.addSupplierValidation();
			if(this.checkSupplierIfExist() == false) {
				swal("Error!", " Supplier already exist in active supplier", "error")
			}
			else {
				if(this.supplier_name != "" && this.supplier_address != "" && this.supplier_contact_no != "") {
					axios.post(this.urlRoot + this.api + "add_supplier.php", {
						supplier_name : this.supplier_name,
						supplier_address : this.supplier_address,
						supplier_contact_no : this.supplier_contact_no,
						supplier_status : "Active"
					}).then(function (response) {
						console.log(response);
						if(response.status == 200) {
							vm.retrieveSupplier();
							swal("Congrats!", " New supplier added!", "success");
							vm.clearSupplier();	

							vm.supplier_name = false;
							vm.supplier_address = false;
							vm.supplier_contact_no = false;
							vm.supplier_status = false;

							$('#myModal').modal('hide');
						}
						else {
							vm.supplier_name_error = response.data.supplier_name_error;
							vm.supplier_address_error = response.data.supplier_address_error;
							vm.supplier_contact_no_error = response.data.supplier_contact_no_error;
							vm.supplier_status_error = response.data.supplier_status_error;
						}
					});
				}
			}
			
		},
		updateSupplier : function() {
			if(this.supplier_name == "") {
				this.supplier_name_error = true;
			}
			else {
				this.supplier_name_error = false;
			}

			if(this.supplier_address == "") {
				this.supplier_address_error = true;
			}
			else {
				this.supplier_address_error = false;
			}

			if(this.supplier_contact_no == "") {
				this.supplier_contact_no_error = true;
			}
			else {
				this.supplier_contact_no_error = false;
			}

			if(this.supplier_status == "") {
				this.supplier_status_error = true;
			}
			else {
				this.supplier_status_error = false;
			}

			if(this.supplier_id != "" && this.supplier_name != "" && this.supplier_address != "" && this.supplier_contact_no != "" && this.supplier_status != "") {
				axios.post(this.urlRoot + this.api + "update_supplier.php", {
					supplier_id : this.supplier_id,
					supplier_name : this.supplier_name,
					supplier_address : this.supplier_address,
					supplier_contact_no : this.supplier_contact_no,
					supplier_status : this.supplier_status
				}).then(function (response) {
					console.log(response);
					if(response.data.status == "OK") {
						vm.retrieveSupplier();
						swal("Congrats!", " Update supplier successfully!", "success");	
						vm.clearSupplier();

						vm.supplier_name = false;
						vm.supplier_address = false;
						vm.supplier_contact_no = false;
						vm.supplier_status = false;

						$('#myModal1').modal('hide');
					}
					else {
						vm.supplier_name_error = response.data.supplier_name_error;
						vm.supplier_address_error = response.data.supplier_address_error;
						vm.supplier_contact_no_error = response.data.supplier_contact_no_error;
						vm.supplier_status_error = response.data.supplier_status_error;
					}
				});
			}
		},
		addSupplierMedicine : function() {
			//get id of description in tbl_category
			for(var index = 0; index < this.categories.length; index++){
				if(this.categories[index].description == this.supplier_medicine_category){
					this.supplier_medicine_category_id = this.categories[index].category_id;
				}
			} 

			//get id of unit in tbl_unit_category
			for(var index = 0; index < this.unit_categories.length; index++){
				if(this.unit_categories[index].unit == this.supplier_medicine_unit){
					this.supplier_medicine_unit_id = this.unit_categories[index].unit_category_id;
				}
			}
			
			if(this.supplier_medicine_name == "") {
				this.supplier_medicine_name_error = true;
			}
			else {
				this.supplier_medicine_name_error = false;
			}

			if(this.supplier_medicine_category == "") {
				this.supplier_medicine_category_id_error = true;
			}
			else {
				this.supplier_medicine_category_id_error = false;
			}

			if(this.supplier_medicine_unit == "") {
				this.supplier_medicine_unit_id_error = true;
			}
			else {
				this.supplier_medicine_unit_id_error = false;
			}

			if(this.supplier_medicine_price == "") {
				this.supplier_medicine_price_error = true;
			}
			else {
				this.supplier_medicine_price_error = false;
			}

			if(this.supplier_id == "") {
				this.supplier_id_error = true;
			}
			else {
				this.supplier_id_error = false;
			}

			if(this.supplier_medicine_name != "" && this.supplier_medicine_category_id != "" && this.supplier_medicine_unit_id != "" && this.supplier_medicine_price != "" && this.supplier_id != "") {
				axios.post(this.urlRoot + this.api + "add_supplier_medicine.php", {
					medicine_name : this.supplier_medicine_name,
					category_id : this.supplier_medicine_category_id,
					unit_category_id : this.supplier_medicine_unit_id,
					price : this.supplier_medicine_price,
					supplier_id : this.supplier_id
				}).then(function (response) {
					if(response.status == 200) {
						vm.retrieveSupplierMedicine(vm.supplier_id);
						swal("Congrats!", " New medicine added!", "success");
						console.log(response);

						vm.supplier_medicine_name = false;
						vm.supplier_medicine_category_id = false;
						vm.supplier_medicine_unit_id = false;
						vm.supplier_medicine_price = false;
						vm.supplier_id = false;

						$('#myModal2').modal('hide');
					} 
					else {
						vm.supplier_medicine_name_error = response.data.supplier_medicine_name_error;
						vm.supplier_medicine_category_id_error = response.data.supplier_medicine_category_id_error;
						vm.supplier_medicine_unit_id_error = response.data.supplier_medicine_unit_id_error;
						vm.supplier_medicine_price_error = response.data.supplier_medicine_price_error;
						vm.supplier_id_error = response.data.supplier_id_error;
					}
				});
			}
		},
		updateSupplierMedicineButton : function(supplier_medicine_id,medicine_name,description,unit,price,supplier_id) {
			this.supplier_medicine_id = supplier_medicine_id;
			this.supplier_medicine_name = medicine_name;
			this.supplier_medicine_category = description;
			this.supplier_medicine_unit = unit;
			this.supplier_medicine_price = price;
			this.supplier_id = supplier_id;

		},
		updateSupplierMedicine : function() {
			//get id of description in tbl_category
			for(var index = 0; index < this.categories.length; index++){
				if(this.categories[index].description == this.supplier_medicine_category){
					this.supplier_medicine_category_id = this.categories[index].category_id;
				}
			} 

			//get id of unit in tbl_unit_category
			for(var index = 0; index < this.unit_categories.length; index++){
				if(this.unit_categories[index].unit == this.supplier_medicine_unit){
					this.supplier_medicine_unit_id = this.unit_categories[index].unit_category_id;
				}
			}

			if(this.supplier_medicine_name == "") {
				this.supplier_medicine_name_error = true;
			}
			else {
				this.supplier_medicine_name_error = false;
			}

			if(this.supplier_medicine_category == "") {
				this.supplier_medicine_category_id_error = true;
			}
			else {
				this.supplier_medicine_category_id_error = false;
			}

			if(this.supplier_medicine_unit == "") {
				this.supplier_medicine_unit_id_error = true;
			}
			else {
				this.supplier_medicine_unit_id_error = false;
			}

			if(this.supplier_medicine_price == "") {
				this.supplier_medicine_price_error = true;
			}
			else {
				this.supplier_medicine_price_error = false;
			}

			if(this.supplier_id == "") {
				this.supplier_id_error = true;
			}
			else {
				this.supplier_id_error = false;
			}

			if(this.supplier_medicine_name != "" && this.supplier_medicine_category_id != "" && this.supplier_medicine_unit_id != "" && this.supplier_medicine_price != "" && this.supplier_id != "") {
				axios.post(this.urlRoot + this.api + "update_supplier_medicine.php", {
					supplier_medicine_id : this.supplier_medicine_id,
					medicine_name : this.supplier_medicine_name,
					category_id : this.supplier_medicine_category_id,
					unit_category_id : this.supplier_medicine_unit_id,
					price : this.supplier_medicine_price,
					supplier_id : this.supplier_id
				}).then(function (response) {
					if(response.data.status == "OK") {
						swal("Congrats!", " Medicine update successfully!", "success");
						vm.retrieveSupplierMedicine(vm.supplier_id);

						vm.supplier_medicine_name = false;
						vm.supplier_medicine_category_id = false;
						vm.supplier_medicine_unit_id = false;
						vm.supplier_medicine_price = false;
						vm.supplier_id = false;

						$('#myModal3').modal('hide');
					} 
					else {
						vm.supplier_medicine_name_error = response.data.supplier_medicine_name_error;
						vm.supplier_medicine_category_id_error = response.data.supplier_medicine_category_id_error;
						vm.supplier_medicine_unit_id_error = response.data.supplier_medicine_unit_id_error;
						vm.supplier_medicine_price_error = response.data.supplier_medicine_price_error;
						vm.supplier_id_error = response.data.supplier_id_error;
					}
				});
			}
		},
		retrieveUnitCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_unit_category.php")
			.then(function (response) {
				vm.unit_categories = response.data;
			});
		},
		retrieveCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_category.php")
			.then(function (response) {
				vm.categories = response.data;
			});
		},
		searchSupplierMedicine : function() {

			axios.get(this.urlRoot + this.api + "search_supplier_medicine.php?supplier_id=" + this.supplier_id + "&keyword=" + this.search_supplier_medicine)
			.then(function (response) {
				vm.supplier_medicines = response.data;
			});
		},
		retrieveInventory : function() {
			for(var index = 0; index < this.barangays.length; index++){
				if(this.barangays[index].barangay_name == this.barangay_name){
					this.barangay_id = this.barangays[index].barangay_id;
				}
			}
			axios.get(this.urlRoot + this.api + "retrieve_inventory.php?barangay_id=" + this.barangay_id)
			.then(function (response) {
				vm.barangay_inventories = response.data;
				console.log(response);
			});
		},
		countBarangay : function() {
			var count_user = 0;
			for(var index = 0; index < this.barangay_inventories.length; index++){
				count_user++;
			}
			return count_user;
		},
		totalMedicinePrice : function() {
			var total = 0;

			for(var index = 0; index < this.barangay_inventories.length; index++) {
				total += parseInt(this.barangay_inventories[index].price) * parseInt(this.barangay_inventories[index].quantity);
			}
			return parseInt(total)  + ".00";
		},
		//// new added
		toggleRequestOrderInfo : function(id, barangay_name, contact_no, status) {
			if(status == "Completed") {
				swal("Error!", " this request already completed!", "error");
			}
			else {
				if(this.request_order_info == false) {
					this.request_order_info = true;
					this.request_order_medicine_info = false;
					this.request_order_receipt = false;
				}
				else {
					this.request_order_info = false;
					
				}
				this.request_order_id = id;
				this.request_order_barangay_name = barangay_name;
				this.request_order_contact_number = contact_no;
				this.retrieveRequestDetails(id);
			}
		},
		toggleRequestOrderDetailsInfo : function(id) {
			if(this.request_order_medicine_info == false) {
				this.request_order_medicine_info = true;
				this.request_order_receipt = false;
				this.request_order_info = false;
				this.request_receipt_history = false;
			}
			else {
				this.request_order_medicine_info = false;
				this.request_order_info = true;
			}

			this.request_order_id = id;

			this.retrieveSendOrderDetails(id);

		},
		toggleRequestOrderReceeipt : function() {
			if(this.request_order_receipt == false) {
				this.request_order_receipt = true;
				this.request_order_medicine_info = false;
				this.request_order_info = false;
				this.request_receipt_history = false;
			} 
			else {
				this.request_order_receipt = false;

			}
		},
		toggleReceiptHistory : function(id, barangay_name, contact_no) {
			if(this.request_receipt_history == false) {
				this.request_receipt_history = true;
				this.request_order_medicine_info = false;
				this.request_order_info = false;
				this.request_order_receipt = false;
			} 
			else {
				this.request_receipt_history = false;
				this.request_order_info = true;
				this.request_order_medicine_info = false;
			}
			this.request_order_id = id;
			this.request_order_barangay_name = barangay_name;
			this.request_order_contact_number = contact_no;
			this.retrieveRequestDetails(id);
		},
		retrieveBarangayRequestOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_barangay_request_orders.php")
			.then(function (response) {
				vm.request_orders = response.data;
				console.log(response);
			});
		},
		saveRequestOrderData : function (request_order_id) {
    		this.editDisabled = false;
			this.editUser = null;
			this.beforEditCache = null;
			this.editedUser = null;
			
			swal("Congrats!", "Successfully Update", "success");
    	},
    	searchRequestOrder : function() {
    		axios.get(this.urlRoot + this.api + "search_request_order.php?keyword=" + this.search_request_order)
    		.then(function (response) {
    			vm.request_orders = response.data;
				console.log(response);
    		});
    	},
    	retrieveRequestDetails : function(request_order_id) {
    		axios.get(this.urlRoot + this.api + "retrieve_request_details.php?request_order_id=" + request_order_id)
    		.then(function (response) {
    			console.log(response);
    			vm.request_details = response.data;
    		});
    	},
    	retrieveSendOrder : function() {
    		axios.get(this.urlRoot + this.api + "retrieve_send_order.php")
    		.then(function (response) {
    			vm.send_orders = response.data;
    			console.log(response);
    		});
    	},
    	checkSupplierMedicine : function(supplier_medicine_id) {
    		var status = true;
    		for(var index = 0; index < this.medicines.length; index++){
    			if(supplier_medicine_id == this.medicines[index].supplier_medicine_id) {
    				status = false;
    			}
    		}
    		return status;

    	},
    	deliverModal : function(supplier_medicine_id, delivered_quantity) {
    		if (delivered_quantity != 0) {
    			swal("Error", "This field is already sent!", "error");
    		}
    		else {

    			if(this.checkSupplierMedicine(supplier_medicine_id) == false) {
    				this.send_order_supplier_medicine_id = supplier_medicine_id;
    				$('#myModal').modal('show');
    			}
    			else {
					swal({
						title: "Out of stock",
						icon: "warning",
						buttons : "Ok",
						dangerMode : true,
						closeOnClickOutside: false
					})
					.then((setStatus) => {
						if (setStatus) {
							for(var index = 0; index < this.request_details.length; index++) {
									if(!this.request_details[index].no_stock) {
										Vue.set(this.request_details[index], 'no_stock', false);
									}
							}

							for(var index = 0; index < this.request_details.length; index++) {
								if(supplier_medicine_id == this.request_details[index].supplier_medicine_id) {
									this.request_details[index].no_stock = true;
									//Vue.set(this.request_details[index]);
								}
							}
						}
					});
    			}    			
    		}
    	},
    	generateSendOrderId : function() {
    		var  id = "";
			var pad = "00000000";
			var date = new Date();

			if(this.send_orders.length == 0) {
				id = "SO" +  date.getUTCFullYear() + "-" + "0000001";
			}
			else {
				for(var index = 0; index < this.send_orders.length; index++) {
					id = this.send_orders[index].send_order_id;
				}

				id = id.slice(7);
				id = pad.substring(0, pad.length - id.length) + id;
				id = date.getUTCFullYear() + id;
				id = parseInt(id) + 1;
				id = "SO" + id;
				id = id.substr(0, 6) + "-" + id.substr(7);
			}
			return id;
    	},
    	addSendOrder : function() {
    		var date = new Date();
			var year = date.getFullYear();
			var month = date.getMonth() + 1;
			var day = date.getDate();
    		axios.post(this.urlRoot + this.api + "add_send_order.php", {
    			send_order_id : this.generateSendOrderId(),
    			date_send : year + "-" + month + "-" + day,
    			request_order_id : this.request_order_id
    		}).then(function (response) {
    			vm.addSendOrderDetails();
    		});
    	},
    	addSendOrderDetails : function() {
    		axios.post(this.urlRoot + this.api + "add_send_order_details.php", {
    			request_details : this.request_details
    		}).then(function (response) {
    			console.log(response);
    			vm.updateRequestDetails();
    		})
    	},
    	updateRequestDetails : function() {
    		axios.post(this.urlRoot + this.api + "update_request_details.php", {
    			request_details : this.request_details
    		}).then(function (response) {
    			console.log(response);
    			vm.updateMedicineQuantity();
    		});
		},
		updateMedicineQuantity : function() {
			axios.post(this.urlRoot + this.api + "update_medicine.php", {
				request_details : this.request_details,
				medicines : this.medicines
			}).then(function (response) {
				console.log(response);
				vm.updateRequestOrder();
			});
		},
		updateRequestOrder : function() {
			axios.post(this.urlRoot + this.api + "update_request_order.php", {
				request_order_id : this.request_order_id
			}).then(function (response) {
				console.log(response);
				vm.addSendDetails();
			});
		},
		addApproveQuantity : function() {
			for(var index = 0; index < this.medicines.length; index++) {
				for(var index1 = 0; index1 < this.request_details.length; index1++) {
					if(this.send_order_supplier_medicine_id == this.medicines[index].supplier_medicine_id) {
						if(this.medicines[index].supplier_medicine_id == this.request_details[index1].supplier_medicine_id){
							if(parseInt(this.send_quantity) > parseInt(this.medicines[index].quantity)) {
								swal("Error!", " Approved quantity cannot be more than the stock quantity!", "error");
								$('#myModal').modal('show');
							}
							else {
								this.request_details[index1].delivered_quantity = this.send_quantity;
								$('#myModal').modal('hide');
							}
						}
					}
				}
			}
		},
		searchRequestOrderDetails : function() {
			axios.get(this.urlRoot + this.api + "search_request_order_details.php?keyword=" + this.search_request_order_details)
    		.then(function (response) {
    			vm.request_details = response.data;
				console.log(response);
    		});
		},
		retrieveSendOrderDetails : function(request_order_id) {
			axios.get(this.urlRoot + this.api + "retrieve_send_order_details.php?request_order_id=" + request_order_id)
			.then(function (response) {
				vm.send_order_details = response.data;
				console.log(response);
			});
		}, 
		addSendDetails : function() {
			axios.post(this.urlRoot + this.api + "add_send_details.php", {
				request_details : this.request_details
			}).then(function (response) {
				console.log(response);
				swal("Congrats!", "Send Order Successfully", "success");
				vm.toggleRequestOrderReceeipt();
			});
		},
		identifySendOrderID : function(request_order_id) {
			for(var index=0; index < this.send_orders.length; index++) {
				if (request_order_id == this.send_orders[index].request_order_id) {
					return this.send_orders[index].send_order_id;
				}
			}
		}
	},
	filters: {
      currency(value) {
        return value.toFixed(2);
      },
      stock(value) {
      	if(value == 0) {
      		return "No Stock";
      	} else {
      		return value;
      	}
      }
    },
	computed : {
		totalActiveUser: function() {
	    	return Math.ceil(this.active_users.length / this.show_entries)
	   	},
	   	// totalAmountNew: function() {
	    // 	let totalAmount = 0;
	    // 	for(let i = 0; i < this.request_details.length; i++){
	    // 		if (isNaN(this.request_details[i].delivered_quantity)) {
	    //   		return totalAmount = 0;
	    //   	} else if (this.request_details[i].delivered_quantity)  {
	    // 		return totalAmount = (parseFloat(this.request_details[i].price) * (parseFloat(this.request_details[i].delivered_quantity)));
	    //   	}	
	    //   } 	
	    //   // return totalAmount;
	    // },
	   	totalAmount: function() {
	    	let totalAmount = 0;
	    	for(let i = 0; i < this.request_details.length; i++){
	    		if(this.request_details[i].delivered_quantity == "Out of stock") {
	    			this.request_details[i].delivered_quantity = 0;
	    		}
	    		totalAmount += (parseFloat(this.request_details[i].price) * (parseFloat(this.request_details[i].delivered_quantity)));
	      	}
	      	return totalAmount;
	    }
	     	
	},
	created() {
		this.retrieveActiveUser();
		this.retrieveMedicine();
		this.retrieveSupplier();
		this.retrieveBarangay();
		this.retrieveNotActiveUser();
		this.retrievePurchaseOrder();
		this.retrieveUnitCategory();
		this.retrieveCategory();
		this.retrieveBarangayRequestOrder();
		this.retrieveSendOrder();

		for(var index = 0; index < this.request_details.length; index++) {
				Vue.set(this.request_details[index], 'no_stock', false);
		}
	}
})