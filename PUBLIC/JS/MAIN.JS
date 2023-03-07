window.onload = function () {
var vm = new Vue({
	
	el : "#vue-app",
	data : {
		urlRoot : "/bms/public/",
		sample : "testing",

		//validation
		user_username_error : false,
		user_password_error : false,

		category_id_error : false,
		category_description_error : false,

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

		received_quantity_error : false,
		expiration_date_error : false,



		/// cannot delete//
		gulod_beneficiary_first_name_in_cart : "",
		gulod_transaction_beneficiary_id : "",

		gulod_receipt_first_name : "",
		gulod_receipt_last_name : "",
		gulod_receipt_contact_no : "",
		gulod_receipt_address : "",


		////// start of title /////////
		activate : "Activate Beneficiary",
		deactivate : "Deactive Beneficiary",

		add_Beneficiary : "Add Beneficiary",
		view_Beneficiary : "View Beneficiary",
		update_Beneficiary : "Update Beneficiary",
		beneficiary_Transaction : "Go To Transaction",
		activate_Account : "Activate Account",

		dependent_to_beneficiary : "Add To Beneficiary",
		add_Dependent : "Add Dependent",
		view_Dependent : "View Dependent",
		update_Dependent : "Update Dependent",

		add_Medicine : "Add Medicine",
		view_Medicine : "View Medicine",
		update_Medicine : "Update Medicine",
		delete_Medicine : "Remove All Expired Medicine",
		search_transaction_medicine : "Search Medicine",

		add_User : "Add User",
		view_User : "View User",
		update_User : "Update User",
		deactivate_User : "Deactive User",
		activate_user : "Activate User",
		assign_Barangay : "Assign to barangay",

		add_Category : "Add Category",
		update_Category : "Update Category",

		add_Unit : "Add Unit Category",
		update_Unit : "Update Unit Category",

		add_Supplier : "Add Supplier",
		update_Supplier : "Update Supplier",

		add_to_cart : "Add Medicine To Cart",
		update_Quantity : "Update Quantity",
		save_Quantity : "Save Quantity",
		delete_Row : "Delete Row",

		view_Defective : "View Defective Medicine",
		add_Defective : "Add Defective Medicine",
		create_Return : "Create Return Medicine",
		deactivate_Dependent : "Deactivate Dependent",

		receive_action : "Update Received",
		view_Order : "View Order",
		////// end of title /////////

		////// start of barangay data /////////
		barangays : [],
		barangay_name : "",
		brangay_id : "",
		barangay_inventories : [],
		barangay_url : "",

		////// end of barangay data /////////

		////// start of user data /////////
		active_users : [],
		not_active_users : [],
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
		search_notUser : "",
		////// end of user data /////////

		////// start of category data /////////
		categories : [],
		category_id : "",
		category_description : "",
		search_category : "",
		////// end of category data /////////

		////// start of unit_category data /////////
		unit_categories : [],
		unit_category_id : "",
		unit_category_description : "",
		unit_category_unit : "",
		search_unit_category : "",

		unit_category_id_error : false,
		unit_category_unit_error : false,
		////// end of unit_category data /////////

		////// start of medicine data /////////
		medicines : [],
		medicine_id : "",
		medicine_name : "",
		quantity : "",
		price : "",
		status : "",
		medicine_category_id : "",
		medicine_unit_category_id : "",
		medicine_barangay_id : "",
		search_medicine : "",
		////// end of medicine data /////////

		////// start of beneficiary data /////////
		// active_beneficiaries : [],
		// not_active_beneficiaries : [],
		// search_active_beneficiary : "",
		// search_not_active_beneficiary : "",
		// beneficiary_id : "",
		// beneficiary_first_name : "",
		// beneficiary_last_name : "",
		// beneficiary_middle_name : "",
		// beneficiary_contact_no: "",
		// beneficiary_birth_date : "",
		// beneficiary_email_address : "",
		// beneficiary_sex : "",
		// beneficiary_address : "",
		// beneficiary_is_active: "",
		// beneficiary_balance : "",
		// beneficiary_barangay_name : "",
		// beneficiary_barangay_id: "",
		// beneficiary_is_senior_citizen : "",
		// beneficiary_civil_status_id : "",
		// beneficiaryButtonToggle : true,
		////// end of beneficiary data /////////

		////// start of dependent data /////////
		// dependents : [],
		// all_dependents: [],
		// dependent_id : "",
		// dependent_first_name : "",
		// dependent_last_name : "",
		// dependent_middle_name : "",
		// dependent_contact_no : "",
		// dependent_birth_date : "",
		// dependent_email_address : "",
		// dependent_sex : "",
		// dependent_address : "",
		// dependent_status : "",
		// dependent_civil_status_id : "",
		// dependent_beneficiary_id : "",
		// search_dependent : "",
		// search_for_possible_dependent : "",
		// change_dependent : "",
		////// end of dependent data /////////

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		////// end of pagination /////////

		////// start of gulod /////////
		gulod_medicines : [],
		gulod_inactive_medicines : [],
		gulod_expired_medicines : [],
		gulod_out_of_stock : [],
		gulod_low_stock : [],
		gulod_active_beneficiaries : [],
		gulod_medicine_id : "",
		gulod_medicine_name : "",
		gulod_medicine_quantity : "",
		gulod_medicine_expiration_date : "",
		gulod_medicine_price : "",
		gulod_medicine_category : "",
		gulod_medicine_category_id : "",
		gulod_medicine_unit_category : "",
		gulod_medicine_unit_category_id : "",
		gulod_medicine_status : "",
		gulod_medicine_barangay_id : "",
		search_gulod_medicine : "",
		gulod_medicine_supplier_id : "",
		check_same_order : false,

		gulod_medicine_information : [],
		gulod_medicine_info : false,
		gulod_available_medicine : true,
		gulod_medicine_info_id : "",
		gulod_medicine_info_name : "",
		gulod_medicine_info_quantity : "",
		gulod_medicine_info_price : "",
		gulod_medicine_info_category : "",
		gulod_medicine_info_category_unit : "",
		gulod_medicine_info_supplier : "",

		gulod_beneficiary_id : "",
		gulod_beneficiary_first_name : "",
		gulod_beneficiary_last_name : "",
		gulod_beneficiary_middle_name : "",
		gulod_beneficiary_contact_no: "",
		gulod_beneficiary_birth_date : "",
		gulod_beneficiary_email_address : "",
		gulod_beneficiary_sex : "",
		gulod_beneficiary_address : "",
		gulod_beneficiary_is_active: "",
		gulod_beneficiary_balance : "",
		gulod_beneficiary_barangay_name : "",
		gulod_beneficiary_barangay_id: "",
		gulod_beneficiary_civil_status : "",
		gulod_beneficiary_civil_status_id : "",
		gulod_beneficiary_is_senior_citizen : "",
		search_gulod_beneficiary : "",
		gulod_transaction_button : false,
		gulod_beneficiary_name : "",

		gulod_beneficiary_info : false,
		gulod_beneficiary_info_beneficiary_id : "",
		gulod_beneficiary_info_first_name : "",
		gulod_beneficiary_info_last_name : "",
		gulod_beneficiary_info_contact_no : "",
		gulod_beneficiary_info_address : "",

		gulod_transactions : [],
		gulod_transaction_id : "",
		gulod_transaction_medicine_id : "",
		gulod_transaction_quantity : 1,
		gulod_transaction_medicine_name : "",
		gulod_transaction_medicine_category : "",
		gulod_transaction_medicine_unit_category : "",
		gulod_transaction_medicine_price : "",
		gulod_transaction_medicine_total_price : "",
		gulod_transaction_date : "",
		gulod_transaction_medicine_status : "",
		gulod_indigent_button : false,

		gulod_transaction_purchase: {
			id : 1,
			name : null,
			price : null,
			quantity : null,
			description : null,
			unit : null,
			total : null
		},
		gulod_transaction_receipt: {
			id : null,
			medicine_name : null,
			price : null,
			quantity : null,
			total_amount : null
		},

		gulod_receipts : [],
		gulod_save_transactions : [],
		gulod_transaction_details : [],
		list_transaction_button : false,

		return_medicines : [],
		defective_beneficiary_id: "",
		toggle_return_medicine : false,
		return_medicine_details_id : "",
		return_medicine_transaction_id: "",
		return_medicine_beneficiary_id : "",
		return_medicine_remarks : "",
		return_medicine_price : "",
		return_medicine_transaction_price : "",
		return_medicine_transaction_quantity : "",
		return_medicine_quantity : "",
		return_medicine_id : "",
		return_medicine_total_price : "",

		received_order_details : [],
		gulod_received_orders : [],
		received_orders : [],
		add_received_order : {
			medicine_id : 1,
			medicine_name : null,
			quantity : null,
			price : null,
			expiration_date : null,
			total_amount : null
		},

		received_order_toggle_button : false,
		received_order_details_id : "",
		received_order_id : "",
		received_order_medicine_id : "",
		received_order_medicine_name : "",
		received_order_quantity : "",
		received_order_price : "",
		received_order_expiration_date : "",
		received_order_is_updated : "",
		received_order_total_amount: "",
		////// end of gulod /////////



		///// start of beneficiary transaction toggle /////
		showReceipt : false,
		showTransaction : true,
		showBeneficiaryTransaction : false,
		///// end of beneficiary transaction toggle /////

		start_date : "",
		end_date : "",
		dateToday : [],

		input_quantity : 1,
		errors : "",

		search_transaction_details : [],
		search_details : false,
		search_pagination : false,
		search_no_details : true,
		search_id_details : "",

		dependent_button : false,
		beneficiary_button : false,
		mainButton : true,

		notActivebeneficiaryButtonToggle : false,


		editedUser : null,
    	editDisabled : false,

    	gulod_all_medicines : [],

    	gulod_beneficiary_view : true,

    	// single_resident: [],
    	// senior_citizen: [],
    	// senior_citizen_to_confirm : [],
    	// indigent_people: [],

    	select_dependent : null,
    	// search_city_hall_medicine : '',

    	suppliers : [],
    	supplier_id : "",
    	supplier_name : "",
    	supplier_address : "",
    	supplier_contact_no : "",
    	supplier_status : "",

    	supplier_id_error : false,
    	supplier_name_error : false,
    	supplier_address_error : false,
    	supplier_contact_no_error : false,
    	supplier_status_error : false,

    	search_supplier : "",
    	supplier_medicine_info : false, 
    	supplier_medicine_name : "",
		supplier_medicine_price : "",
		supplier_medicine_category_id : "",
		supplier_medicine_category : "",
		supplier_medicine_unit_id : "",
		supplier_medicine_unit : "", 
		// supplier_medicines : [],
		search_supplier_medicine : "",

		supplier_medicine_name_error : false,
		supplier_medicine_category_id_error : false,
		supplier_medicine_unit_id_error : false,
		supplier_medicine_price_error : false,
		supplier_id_error : false,

		purchase_order_supplier_id : "",
		purchase_order_supplier_name : "",

    	purchase_orders : [],
    	purchase_order_medicine_id : "",
    	purchase_order_medicine_name: "",
    	purchase_order_medicine_category_id : "",
    	purchase_order_medicine_category : "",
    	purchase_order_medicine_unit_category_id : "",
    	purchase_order_medicine_unit_category : "",
    	purchase_order_medicine_price : "",
    	purchase_order_medicine_quantity : 1,
    	purchase_order_medicine_total : "",
    	purchase_order_medicine_expiration_date : "",
    	// search_purchase_ordered : "",

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

		purchase_received : [],
		purchase_received_purchase_order_id : "",
		purchase_received_id : "",
		purchase_received_medicine_name: "",
		purchase_received_medicine_category : "",
		purchase_received_medicine_category_id : "",
		purchase_received_medicine_unit : "",
		purchase_received_medicine_unit_id : "",
		purchase_received_quantity : "",
		purchase_received_price : "",
		purchase_received_expiration_date : "",
		purchase_received_supplier_medicine_id : "",
		purchase_received_order_quantity : "",

		purchase_received_details : [],

		purchase_received_info : "",

		purchase_order_using_id : [],

		purchase_order_details : [],
		showPurchaseReceipt : false,
		showPurchaseOrder : true,

		purchased_received : [],
		purchase_received_medicine_info : false,

		purchase_order_received_id : "",
		purchase_order_received_medicine_id : "",
		purchase_order_received_price : "",
		purchase_order_received_medicine_name : "",
		purchase_order_received_category : "",
		purchase_order_received_unit : "",
		purchase_order_received_quantity : "",
		purchase_order_received_supplier : "",

		// purchase_order_details_id : "",
		// purchase_order_details_purchase_order_id : "",
		// purchase_order_details_supplier_medicine_id : "",
		// purchase_order_details_quantity : "",
		// purchase_order_details_supplier_id : "",
		category_table : true,
		add_new_category : false,

		// request order
		request_orders : [],
		add_request_order : {
			medicine_id : null,
			medicine_name : null,
			category : null,
			unit_category : null,
			price : null
		},
		show_request_order : true,
		show_request_order_receipt : false,
		retrieve_request_orders : [],

		purchase_details : []
	},
	methods : {
		toggleCategory() {
			this.add_new_category = true;
			this.category_table = false;
			
		},
		showEntries : function(value) {
         	this.endIndex = value;
         	this.pagination(1);
		},
		isDisabled : function(index) {
			if(this.select_dependent === null) {
				return false;
			}
			else {
				return index != this.select_dependent;
			}
		},
		innerText : function(index) {
			if(index === this.select_dependent) {
				return 'Selected';
			}
			else {
				return 'Select';
			}
		},
		backgroundColor : function(index) {
			if(index === this.select_dependent) {
				return 'backgroundColor : green';
			}
			else {
				return 'backgroundColor : #cc0000';
			}
		},
		getTransactionId : function() {
			var transaction_id = "";
			for(var index = 0; index < this.gulod_save_transactions.length; index++) {
				transaction_id = this.gulod_save_transactions[index].transaction_id;
			}
			return transaction_id
		},
		allowDouble : function(evt) {
			evt = (evt) ? evt : window.event;
      		var charCode = (evt.which) ? evt.which : evt.keyCode;
      		
      		if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode != 46) {
        		evt.preventDefault();;
      		} 
      		else {
        		return true;
      		}
		},
		isLetter(event) {
          	if (!(event.key.toLowerCase() >= 'a' && event.key.toLowerCase() <= 'z' || event.key == ' '))
                event.preventDefault();
        },
		isNumber : function(evt) {
			evt = (evt) ? evt : window.event;
      		var charCode = (evt.which) ? evt.which : evt.keyCode;

      		if ((charCode > 31 && (charCode < 48 || charCode > 57 || charCode == 189)) || charCode == 46) {
        		evt.preventDefault();;
      		} 
      		else {
        		return true;
      		}
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
		saveData : function (transaction_id) {

    		for(var index1 = 0; index1 < this.gulod_medicines.length; index1++) {
    			for(var index = 0; index < this.gulod_transactions.length; index++) {
    				if(transaction_id == this.gulod_transactions[index].id) {
    					if(this.gulod_transactions[index].id == this.gulod_medicines[index1].medicine_id) {
    						if(this.gulod_transactions[index].quantity == "" ) {
    							swal("Error Occured!", "Quantity cannot be blank!", "error");
    						}
    						else {
    							if(this.gulod_transactions[index].quantity > this.gulod_medicines[index1].quantity) {
    								swal("Error Occured!", "You exceed the maximum amount", "error");
	    						}
	    						else {
	    							this.gulod_transactions[index].total = parseFloat(this.gulod_transactions[index].quantity) * parseFloat(this.gulod_transactions[index].price);
	    							swal("Congrats!", "Successfully change the quantity", "success");
	    							this.editDisabled = false;
									this.editUser = null;
									this.beforEditCache = null;
									this.editedUser = null;
	    						}
    						}
    					}
    				}
    			}
    		}
    	},
    	saveDatas : function (medicine_id) {
    		this.editDisabled = false;
			this.editUser = null;
			this.beforEditCache = null;
			this.editedUser = null;
			for(var index = 0; index < this.received_orders.length; index++) {
				if(medicine_id == this.received_orders[index].medicine_id) {
					this.received_orders[index].total_amount = parseFloat(this.received_orders[index].quantity) * parseFloat(this.received_orders[index].price);
				}
			}
			swal("Congrats!", "Successfully Update", "success");
    		
    	},
    	savePurchaseData : function (medicine_id) {
    		this.editDisabled = false;
			this.editUser = null;
			this.beforEditCache = null;
			this.editedUser = null;
			// for(var index = 0; index < this.purchase_order_to_carts.length; index++) {
			// 	if(medicine_id == this.purchase_order_to_carts[index].medicine_id) {
			// 		this.purchase_order_to_carts[index].total_amount = parseFloat(this.purchase_order_to_carts[index].quantity) * parseFloat(this.received_orders[index].price);
			// 	}
			// }
			swal("Congrats!", "Successfully Update", "success");
    		
    	},
    	savePurchaseReceiveData : function (purchase_order_id) {
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
		alertMessage : function() {
			swal("Error Occured!", "This user is already assigned to barangay", "error");
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
	    next: function() {
	      if (this.currentPage < this.totalPages) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    nextSupplier: function() {
	      if (this.currentPage < this.totalSupplier) {
	        this.pagination(this.currentPage + 1);
	      }
	    }, 
	    nextActiveBeneficiary: function() {
	      if (this.currentPage < this.totalPageActive) {
	        this.pagination(this.currentPage + 1);
	      }
	    }, 
	    nextExpired: function() {
	      if (this.currentPage < this.totalPageExpired) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    nextUnavailable: function() {
	      if (this.currentPage < this.totalUnavailable) {
	        this.pagination(this.currentPage + 1);
	      }
	    }, 
	    nextBeneficiaryDetails: function() {
	      if (this.currentPage < this.totalBeneficiaryDetails) {
	        this.pagination(this.currentPage + 1);
	      }
	    }, 
	    nextActiveUser: function() {
	      if (this.currentPage < this.totalActiveUser) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    nextNotActiveUser: function() {
	      if (this.currentPage < this.totalNotActiveUser) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    nextCategory: function() {
	      if (this.currentPage < this.totalCategory) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    nextUnitCategory: function() {
	      if (this.currentPage < this.totalUnitCategory) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    nextMedicine: function() {
	      if (this.currentPage < this.totaMedicine) {
	        this.pagination(this.currentPage + 1);
	      }
	    }, 
	    nextBeneficiary: function() {
	      if (this.currentPage < this.totalActiveBeneficiary) {
	        this.pagination(this.currentPage + 1);
	      }
	    }, 
	    nextNotBeneficiary: function() {
	      if (this.currentPage < this.totalNotActiveBeneficiary) {
	        this.pagination(this.currentPage + 1);
	      }
	    }, 
	    nextTodayTransact: function() {
	      if (this.currentPage < this.totalTodayTransact) {
	        this.pagination(this.currentPage + 1);
	      }
	    }, 
	    nextBarangayInventory: function() {
	    	if (this.currentPage < this.totalBarangayInventory) {
	        	this.pagination(this.currentPage + 1);
	      }
	    },
	    nextPurchaseOrder: function() {
	    	if (this.currentPage < this.totalPurchaseOrder) {
	        	this.pagination(this.currentPage + 1);
	      }
	    },
		// clearData : function() {
		// 	this.barangay_name = "";
		// 	this.barangay_id = "";

		// 	this.first_name = "";
		// 	this.last_name = "";
		// 	this.middle_name = "";
		// 	this.contact_no = "";
		// 	this.birth_date = "";
		// 	this.email_address = "";
		// 	this.sex = "";
		// 	this.address = "";
		// 	this.is_employed = "";
		// 	this.barangay_id = "";
		// 	this.username = "";
		// 	this.password = "";
		// 	this.new_password = "";
		// 	this.user_type_id = "";
		// 	this.search_user = "";
		// 	this.search_notUser = "";

	 //    	this.supplier_address = "";
	 //    	this.supplier_contact_no = "";
	 //    	this.supplier_status = "";

		// 	this.category_id = "";
		// 	this.category_description = "";
		// 	this.search_category = "";

		// 	this.unit_category_id = "";
		// 	this.unit_category_description = "";
		// 	this.unit_category_unit = "";
		// 	this.search_unit_category = "";

		// 	this.medicine_id = "";
		// 	this.medicine_name = "";
		// 	this.quantity = "";
		// 	this.price = "";
		// 	this.medicine_category_id = "";
		// 	this.medicine_unit_category_id = "";
		// 	this.medicine_barangay_id = "";

		// 	this.beneficiary_id = "",
		// 	this.beneficiary_first_name = "";
		// 	this.beneficiary_last_name = "";
		// 	this.beneficiary_middle_name = "";
		// 	this.beneficiary_contact_no = "";
		// 	this.beneficiary_birth_date = "";
		// 	this.beneficiary_email_address = "";
		// 	this.beneficiary_sex = "";
		// 	this.beneficiary_address = "";
		// 	this.beneficiary_is_senior_citizen = "";
		// 	this.beneficiary_civil_status_id = "";
		// 	this.beneficiary_is_active= "";
		// 	this.beneficiary_barangay_name = "";
		// 	this.beneficiary_barangay_id = "";
		// 	this.search_active_beneficiary = "";
		// 	this.search_not_active_beneficiary = "";

		// 	this.dependent_id = "";
		// 	this.dependent_first_name = "";
		// 	this.dependent_last_name = "";
		// 	this.dependent_middle_name = "";
		// 	this.dependent_contact_no = "";
		// 	this.dependent_birth_date = "";
		// 	this.dependent_email_address = "";
		// 	this.dependent_sex = "";
		// 	this.dependent_address = "";
		// 	this.dependent_status = "";
		// 	this.dependent_beneficiary_id = "";

		// 	this.gulod_medicine_id = "";
		// 	this.gulod_medicine_name = "";
		// 	this.gulod_medicine_quantity = "";
		// 	this.gulod_medicine_price = "";
		// 	this.gulod_medicine_category = "";
		// 	this.gulod_medicine_category_id = "";
		// 	this.gulod_medicine_unit_category = "";
		// 	this.gulod_medicine_unit_category_id = "";
		// 	this.gulod_medicine_status = "";
		// 	this.gulod_medicine_expiration_date = "";
		// 	this.gulod_medicine_barangay_id = "";
		// 	this.search_gulod_medicine = "";

		// 	this.gulod_beneficiary_id = "";
		// 	this.gulod_beneficiary_first_name = "";
		// 	this.gulod_beneficiary_last_name = "";
		// 	this.gulod_beneficiary_middle_name = "";
		// 	this.gulod_beneficiary_contact_no = "";
		// 	this.gulod_beneficiary_birth_date ="";			
		// 	this.gulod_beneficiary_email_address = "";
		// 	this.gulod_beneficiary_sex = "";
		// 	this.gulod_beneficiary_address = "";
		// 	this.gulod_beneficiary_is_active = "";
		// 	this.gulod_beneficiary_barangay_name = "";
		// 	this.gulod_beneficiary_barangay_id = "";
		// 	this.search_gulod_beneficiary = "";

		// 	this.gulod_transaction_quantity = 1;
		// 	this.gulod_transaction_medicine_id = "";
		// 	this.gulod_transaction_medicine_name = "";
		// 	this.gulod_transaction_medicine_category = "";
		// 	this.gulod_transaction_medicine_unit_category = "";
		// 	this.gulod_transaction_medicine_price = "";

		// 	this.received_order_medicine_id = "";
		// 	this.received_order_medicine_name = "";
		// 	this.received_order_quantity = "";
		// 	this.received_order_price = "";
		// 	this.received_order_expiration_date = "";
		// 	this.received_order_is_updated = "";
		// 	this.received_order_total_amount = "";
		// 	this.search_gulod_medicine = "";

		// 	this.purchase_order_medicine_id = "";
	 //    	this.purchase_order_medicine_name = "";
	 //    	this.purchase_order_medicine_category_id = "";
	 //    	this.purchase_order_medicine_category = "";
	 //    	this.purchase_order_medicine_unit_category_id = "";
	 //    	this.purchase_order_medicine_unit_category = "";
	 //    	this.purchase_order_medicine_price = "";
	 //    	this.purchase_order_medicine_quantity = 1;
	 //    	this.purchase_order_medicine_total = "";
	 //    	this.purchase_order_medicine_expiration_date = "";
	 //    	this.purchase_order_supplier_name = "";

	 //    	this.search_purchase_ordered = "";
	 //    	this.purchased_received = [];
	 //    	this.search_supplier = "";
	 //    	this.search_medicine = "";

	 //    	this.supplier_medicine_name = "";
		// 	this.supplier_medicine_category = "";
		// 	this.supplier_medicine_unit = "";
		// 	this.supplier_medicine_price = "";

	    	// validation
	 //    	this.category_description_error = false;
		// 	this.username_error = false;
		// 	this.password_error = false;
		// 	this.first_name_error = false;
		// 	this.last_name_error = false;
		// 	this.middle_name_error = false;
		// 	this.contact_no_error = false;
		// 	this.birth_date_error = false;
		// 	this.email_address_error = false;
		// 	this.sex_error = false;
		// 	this.address_error = false;
		// 	this.is_employed_error = false;
		// 	this.barangay_name_error = false;
		// 	this.user_type_id_error = false;
		// 	this.received_quantity_error = false;
		// 	this.expiration_date_error = false;

	 //    	this.supplier_name_error = false;
	 //    	this.supplier_address_error = false;
	 //    	this.supplier_contact_no_error = false;
	 //    	this.supplier_status_error = false;

	 //    	this.supplier_medicine_name_error = false;
		// 	this.supplier_medicine_category_id_error = false;
		// 	this.supplier_medicine_unit_id_error = false;
		// 	this.supplier_medicine_price_error = false;
		// 	this.supplier_id_error = false;

		// 	this.category_id_error = false;
		// 	this.category_description_error = false;

		// 	this.unit_category_id_error = false
		// 	this.unit_category_unit_error = false
		// },
		////// start of barangay method /////////
		// retrieveBarangay : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_barangay.php"
		// 	}).then(function (response){
		// 		vm.barangays = response.data;
		// 	});
		// },
		////// end of barangay method /////////

		////// start of user method /////////
		loginUser : function() {
			if(this.user_username == '') {
				this.user_username_error = true;
			}
			else {
				this.user_username_error = false;
			}

			if(this.user_password == '') {
				this.user_password_error = true;
			}
			else {
				this.user_password_error = false;
			}
 
			if(this.user_username != '' && this.user_password != '') {
				axios({
					method : "POST",
					url : this.urlRoot + "admin/login.php",
					data : {
						username : this.user_username,
						password : this.user_password,
					}
				}).then(function (response){
					console.log(response);
					if(response.data.message == "incorrect password") {
						swal("Error Occured!", " Invalid username or password!", "error");
					}
					else {
						for(var index = 0; index < response.data.length; index++) {
							if(response.data[index].barangay_id == 1 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/gulod/admin/index.php';
							}
							else if(response.data[index].barangay_id == 1 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/pages/barangay/health_worker/dashboard.php';
							}
							else if(response.data[index].barangay_id == 2 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/mamatid/admin/index.php';
							}
							else if(response.data[index].barangay_id == 2 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/mamatid/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 3 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/niugan/admin/index.php';
							}
							else if(response.data[index].barangay_id == 3 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/niugan/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 4 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/casile/admin/index.php';
							}
							else if(response.data[index].barangay_id == 4 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/casile/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 5 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/san_isidro/admin/index.php';
							}
							else if(response.data[index].barangay_id == 5 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/san_isidro/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 6 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/baclaran/admin/index.php';
							}
							else if(response.data[index].barangay_id == 6 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/baclaran/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 7 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/banay_banay/admin/index.php';
							}
							else if(response.data[index].barangay_id == 7 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/banay_banay/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 8 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/banlic/admin/index.php';
							}
							else if(response.data[index].barangay_id == 8 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/banlic/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 9 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/butong/admin/index.php';
							}
							else if(response.data[index].barangay_id == 9 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/butong/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 10 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/diezmo/admin/index.php';
							}
							else if(response.data[index].barangay_id == 10 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/diezmo/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 11 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/marinig/admin/index.php';
							}
							else if(response.data[index].barangay_id == 11 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/marinig/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 12 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/pittland/admin/index.php';
							}
							else if(response.data[index].barangay_id == 12 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/pittland/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 13 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/sala/admin/index.php';
							}
							else if(response.data[index].barangay_id == 13 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/sala/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 14 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/poblacion_uno/admin/index.php';
							}
							else if(response.data[index].barangay_id == 14 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/poblacion_uno/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 15 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/poblacion_dos/admin/index.php';
							}
							else if(response.data[index].barangay_id == 15 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/poblacion_dos/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 16 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/poblacion_tres/admin/index.php';
							}
							else if(response.data[index].barangay_id == 16 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/poblacion_tres/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 17 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/pulo/admin/index.php';
							}
							else if(response.data[index].barangay_id == 17 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/pulo/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 18 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/barangay/bigaa/admin/index.php';
							}
							else if(response.data[index].barangay_id == 18 && response.data[index].user_type_id == 4) {
								window.location = '../../../bms/public/barangay/bigaa/health_worker/index.php';
							}
							else if(response.data[index].barangay_id == 19 && response.data[index].user_type_id == 1) {
								window.location = '../../../bms/public/admin/index.php';
							}
							else if(response.data[index].barangay_id == 19 && response.data[index].user_type_id == 2) {
								window.location = '../../../bms/public/pharmacist/index.php';
							}
							else if(response.data[index].barangay_id == 19 && response.data[index].user_type_id == 3) {
								window.location = '../../../bms/public/registration_staff/index.php';
							}
						}
					}
					
				});
			}
		},
		// retrieveActiveUser : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_user.php"
		// 	}).then(function (response){
		// 		vm.active_users = response.data;
		// 		//console.log(response);
		// 		vm.clearData();
		// 	});
		// },
		// retrieveNotActiveUser : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_deactive_user.php"
		// 	}).then(function (response){
		// 		vm.not_active_users = response.data;
		// 	});
		// },
		// addUserButton : function() {
		// 	this.username_error = false;
		// 	this.password_error = false;
		// 	this.first_name_error = false;
		// 	this.last_name_error = false;
		// 	this.middle_name_error = false;
		// 	this.contact_no_error = false;
		// 	this.birth_date_error = false;
		// 	this.email_address_error = false;
		// 	this.sex_error = false;
		// 	this.address_error = false;
		// 	this.is_employed_error = false;
		// 	this.barangay_name_error = false;
		// 	this.user_type_id_error = false;
		// 	this.received_quantity_error = false;
		// 	this.expiration_date_error = false;


		// 	$("#myModal").modal("show");
		// },
		// addUser : function() {
		// 	for(var index = 0; index < this.barangays.length; index++){
		// 		if(this.barangays[index].barangay_name == this.barangay_name){
		// 			this.barangay_id = this.barangays[index].barangay_id;
		// 		}
		// 	}

		// 	if(this.username == "") {
		// 		this.username_error = true;
		// 	}
		// 	else {
		// 		this.username_error = false;
		// 	}

		// 	if(this.password == "") {
		// 		this.password_error = true;
		// 	}
		// 	else {
		// 		this.password_error = false;
		// 	}

		// 	if(this.first_name == "") {
		// 		this.first_name_error = true;
		// 	}
		// 	else {
		// 		this.first_name_error = false;
		// 	}

		// 	if(this.last_name == "") {
		// 		this.last_name_error = true;
		// 	}
		// 	else {
		// 		this.last_name_error = false;
		// 	}

		// 	if(this.middle_name == "") {
		// 		this.middle_name_error = true;
		// 	}
		// 	else {
		// 		this.middle_name_error = false;
		// 	}

		// 	if(this.contact_no == "") {
		// 		this.contact_no_error = true;
		// 	}
		// 	else {
		// 		this.contact_no_error = false;
		// 	}

		// 	if(this.birth_date == "") {
		// 		this.birth_date_error = true;
		// 	}
		// 	else {
		// 		this.birth_date_error = false;
		// 	}

		// 	if(this.email_address == "") {
		// 		this.email_address_error = true;
		// 	}
		// 	else {
		// 		this.email_address_error = false;
		// 	}

		// 	if(this.sex == "") {
		// 		this.sex_error = true;
		// 	}
		// 	else {
		// 		this.sex_error = false;
		// 	}

		// 	if(this.address == "") {
		// 		this.address_error = true;
		// 	}
		// 	else {
		// 		this.address_error = false;
		// 	}

		// 	if(this.is_employed == "") {
		// 		this.is_employed_error = true;
		// 	}
		// 	else {
		// 		this.is_employed_error = false;
		// 	}

		// 	if(this.barangay_name == "") {
		// 		this.barangay_name_error = true;
		// 	}
		// 	else {
		// 		this.barangay_name_error = false;
		// 	}

		// 	if(this.user_type_id == "") {
		// 		this.user_type_id_error = true;
		// 	}
		// 	else {
		// 		this.user_type_id_error = false;
		// 	}

		// 	if(this.username != "" && this.password != "" && this.first_name != "" && this.last_name != "" && this.middle_name != "" && this.contact_no != "" && this.birth_date != "" && this.email_address != "" && this.sex != "" && this.address != "" && this.is_employed != "" && this.barangay_id != "" && this.user_type_id != "") {
		// 		axios({
		// 			method : "POST",
		// 			url : this.urlRoot + "admin/add_user.php",
		// 			data : {
		// 				username : this.username,
		// 				password : this.password,
		// 				first_name : this.first_name,
		// 				last_name : this.last_name,
		// 				middle_name : this.middle_name,
		// 				contact_no : this.contact_no,
		// 				birth_date : this.birth_date,
		// 				email_address : this.email_address,
		// 				sex : this.sex,
		// 				address : this.address,
		// 				is_employed : this.is_employed,
		// 				barangay_id : this.barangay_id,
		// 				user_type_id : this.user_type_id
		// 			}
		// 		}).then(function (response){
		// 			console.log(response);
		// 			if(response.status == 200) {
		// 				vm.retrieveActiveUser();
		// 				vm.retrieveNotActiveUser();
		// 				swal("Congrats!", " Update user successfully!", "success");	
		// 				vm.clearData();

		// 				vm.username_error = false;
		// 				vm.password_error = false;
		// 				vm.first_name_error = false;
		// 				vm.last_name_error = false;
		// 				vm.middle_name_error = false;
		// 				vm.contact_no_error = false;
		// 				vm.birth_date_error = false;
		// 				vm.email_address_error = false;
		// 				vm.sex_error = false;
		// 				vm.address_error = false;
		// 				vm.is_employed_error = false;
		// 				vm.barangay_name_error = false;
		// 				vm.user_type_id_error = false;

		// 				$('#myModal').modal('hide');
		// 			}
		// 			else {
		// 				vm.username_error = response.data.username_error;
		// 				vm.password_error = response.data.password_error;
		// 				vm.first_name_error = response.data.first_name_error;
		// 				vm.last_name_error = response.data.last_name_error;
		// 				vm.middle_name_error = response.data.middle_name_error;
		// 				vm.contact_no_error = response.data.contact_no_error;
		// 				vm.birth_date_error = response.data.birth_date_error;
		// 				vm.email_address_error = response.data.email_address_error;
		// 				vm.sex_error = response.data.sex_error;
		// 				vm.address_error = response.data.address_error;
		// 				vm.is_employed_error = response.data.is_employed_error;
		// 				vm.barangay_name_error = response.data.barangay_name_error;
		// 				vm.user_type_id_error = response.data.user_type_id_error;
		// 			}
		// 		});
		// 	}
			
		// },
		// updateUserButton : function(user_id,first_name,last_name,middle_name,contact_no,birth_date,email_address,sex,address,is_employed,barangay_id,username,password,user_type_id) {
		// 	this.user_id = user_id;
		// 	this.first_name = first_name;
		// 	this.last_name = last_name;
		// 	this.middle_name = middle_name;
		// 	this.contact_no = contact_no
		// 	this.birth_date = birth_date;
		// 	this.email_address = email_address;
		// 	this.sex = sex;
		// 	this.address = address;
		// 	this.barangay_name = barangay_id;
		// 	this.is_employed = is_employed;
		// 	this.username = username;
		// 	this.password = password;
		// 	this.user_type_id = user_type_id;
		// },
		// updateUser : function() {
		// 	for(var index = 0; index < this.barangays.length; index++){
		// 		if(this.barangays[index].barangay_name == this.barangay_name){
		// 			this.barangay_id = this.barangays[index].barangay_id;
		// 		}
		// 	}
		// 	if(this.username == "") {
		// 		this.username_error = true;
		// 	}
		// 	else {
		// 		this.username_error = false;
		// 	}

		// 	if(this.first_name == "") {
		// 		this.first_name_error = true;
		// 	}
		// 	else {
		// 		this.first_name_error = false;
		// 	}

		// 	if(this.last_name == "") {
		// 		this.last_name_error = true;
		// 	}
		// 	else {
		// 		this.last_name_error = false;
		// 	}

		// 	if(this.middle_name == "") {
		// 		this.middle_name_error = true;
		// 	}
		// 	else {
		// 		this.middle_name_error = false;
		// 	}

		// 	if(this.contact_no == "") {
		// 		this.contact_no_error = true;
		// 	}
		// 	else {
		// 		this.contact_no_error = false;
		// 	}

		// 	if(this.birth_date == "") {
		// 		this.birth_date_error = true;
		// 	}
		// 	else {
		// 		this.birth_date_error = false;
		// 	}

		// 	if(this.email_address == "") {
		// 		this.email_address_error = true;
		// 	}
		// 	else {
		// 		this.email_address_error = false;
		// 	}

		// 	if(this.sex == "") {
		// 		this.sex_error = true;
		// 	}
		// 	else {
		// 		this.sex_error = false;
		// 	}

		// 	if(this.address == "") {
		// 		this.address_error = true;
		// 	}
		// 	else {
		// 		this.address_error = false;
		// 	}

		// 	if(this.is_employed == "") {
		// 		this.is_employed_error = true;
		// 	}
		// 	else {
		// 		this.is_employed_error = false;
		// 	}

		// 	if(this.barangay_name == "") {
		// 		this.barangay_name_error = true;
		// 	}
		// 	else {
		// 		this.barangay_name_error = false;
		// 	}

		// 	if(this.user_type_id == "") {
		// 		this.user_type_id_error = true;
		// 	}
		// 	else {
		// 		this.user_type_id_error = false;
		// 	}

		// 	if(this.new_password != "") {
		// 		this.password = this.new_password;
		// 	}

		// 	if(this.user_id != "" && this.username != "" && this.first_name != "" && this.last_name != "" &&this.middle_name != "" && this.contact_no != "" && this.birth_date != "" && this.email_address != "" && this.sex != "" && this.address != "" && this.is_employed != "" && this.barangay_id != "" && this.user_type_id != "") {
		// 		axios({
		// 			method : "POST",
		// 			url : this.urlRoot + "admin/update_user.php",
		// 			data : {
		// 				user_id : this.user_id,
		// 				username : this.username,
		// 				password : this.password,
		// 				first_name : this.first_name,
		// 				last_name : this.last_name,
		// 				middle_name : this.middle_name,
		// 				contact_no : this.contact_no,
		// 				birth_date : this.birth_date,
		// 				email_address : this.email_address,
		// 				sex : this.sex,
		// 				address : this.address,
		// 				is_employed : this.is_employed,
		// 				barangay_id : this.barangay_id,
		// 				user_type_id : this.user_type_id
		// 			}
		// 		}).then(function (response){
		// 			console.log(response);
		// 			if(response.data.status == "OK") {
		// 				vm.retrieveActiveUser();
		// 				vm.retrieveNotActiveUser();
		// 				swal("Congrats!", " Update user successfully!", "success");	
		// 				vm.clearData();

		// 				vm.username_error = false;
		// 				vm.first_name_error = false;
		// 				vm.last_name_error = false;
		// 				vm.middle_name_error = false;
		// 				vm.contact_no_error = false;
		// 				vm.birth_date_error = false;
		// 				vm.email_address_error = false;
		// 				vm.sex_error = false;
		// 				vm.address_error = false;
		// 				vm.is_employed_error = false;
		// 				vm.barangay_name_error = false;
		// 				vm.user_type_id_error = false;

		// 				$('#myModal1').modal('hide');
		// 			}
		// 			else {
		// 				vm.username_error = response.data.username_error;
		// 				vm.username_error = response.data.username_error;
		// 				vm.first_name_error = response.data.first_name_error;
		// 				vm.last_name_error = response.data.last_name_error;
		// 				vm.middle_name_error = response.data.middle_name_error;
		// 				vm.contact_no_error = response.data.contact_no_error;
		// 				vm.birth_date_error = response.data.birth_date_error;
		// 				vm.email_address_error = response.data.email_address_error;
		// 				vm.sex_error = response.data.sex_error;
		// 				vm.address_error = response.data.address_error;
		// 				vm.is_employed_error = response.data.is_employed_error;
		// 				vm.barangay_name_error = response.data.barangay_name_error;
		// 				vm.user_type_id_error = response.data.user_type_id_error;
		// 			}
		// 		});
		// 	}
		// },
		// countActiveUser : function() {
		// 	var count_user = 0;
		// 	for(var index = 0; index < this.active_users.length; index++){
		// 		count_user++;
		// 	}
		// 	return count_user;
		// },
		// deactivateUser : function() {
		// 	for(var index = 0; index < this.barangays.length; index++){
		// 		if(this.barangays[index].barangay_name == this.barangay_name){
		// 			this.barangay_id = this.barangays[index].barangay_id;
		// 		}
		// 	}

		// 	this.is_employed = 0;
		// 	alert(this.is_employed);
			
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "admin/update_user.php",
		// 		data : {
		// 			user_id : this.user_id,
		// 			username : this.username,
		// 			password : this.password,
		// 			first_name : this.first_name,
		// 			last_name : this.last_name,
		// 			middle_name : this.middle_name,
		// 			contact_no : this.contact_no,
		// 			birth_date : this.birth_date,
		// 			email_address : this.email_address,
		// 			sex : this.sex,
		// 			address : this.address,
		// 			is_employed : this.is_employed,
		// 			barangay_id : this.barangay_id,
		// 			user_type_id : this.user_type_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveActiveUser();
		// 		vm.retrieveNotActiveUser();
		// 		swal("Congrats!", " Deactivate user successfully!", "success");	
		// 		vm.clearData();
		// 	});
		// },
		// countNotActiveUser : function() {
		// 	var count_user = 0;
		// 		for(var index = 0; index < this.not_active_users.length; index++){
		// 			count_user++;
		// 		}
		// 	return count_user;
		// },
		// activateUser : function() {
		// 	for(var index = 0; index < this.barangays.length; index++){
		// 		if(this.barangays[index].barangay_name == this.barangay_name){
		// 			this.barangay_id = this.barangays[index].barangay_id;
		// 		}
		// 	}

		// 	this.is_employed = 1;
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "admin/update_user.php",
		// 		data : {
		// 			user_id : this.user_id,
		// 			username : this.username,
		// 			password : this.password,
		// 			first_name : this.first_name,
		// 			last_name : this.last_name,
		// 			middle_name : this.middle_name,
		// 			contact_no : this.contact_no,
		// 			birth_date : this.birth_date,
		// 			email_address : this.email_address,
		// 			sex : this.sex,
		// 			address : this.address,
		// 			is_employed : this.is_employed,
		// 			barangay_id : this.barangay_id,
		// 			user_type_id : this.user_type_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveActiveUser();
		// 		vm.retrieveNotActiveUser();
		// 		swal("Congrats!", " Deactivate user successfully!", "success");	
		// 		vm.clearData();
		// 	});
		// },
		// userToggle : function() {
		// 	if(this.userButtonToggle == true){
		// 		this.userButtonToggle = false;
		// 	}
		// 	else {
		// 		this.userButtonToggle = true;
		// 	}
		// },
		// searchUser : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/search_user.php?keyword=",
		// 		params : {
		// 			keyword : this.search_user
		// 		}
		// 	}).then(function (response){
		// 		vm.active_users = response.data;
		// 	});
		// },
		// searchNotuser : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/search_notUser.php?keyword=",
		// 		params : {
		// 			keyword : this.search_notUser
		// 		}
		// 	}).then(function (response){
		// 		vm.not_active_users = response.data;
		// 	});
		// },
		////// end of user method /////////

		////// start of category method /////////
		// searchCategory : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/search_category.php?keyword=",
		// 		params : {
		// 			keyword : this.search_category
		// 		}
		// 	}).then(function (response){
		// 		vm.categories = response.data;
		// 	});
		// },
		// retrieveCategory : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_category.php"
		// 	}).then(function (response){
		// 		vm.categories = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// countCategory : function() {
		// 	var count_category = 0
		// 	for(var index = 0; index < this.categories.length; index++){
		// 		count_category++;
		// 	}

		// 	return count_category;
		// },
		// addCategory : function() {
		// 	if(this.category_description == "") {
		// 		this.category_description_error = true;
		// 	}
		// 	else {
		// 		this.category_description_error = false;
		// 	}

		// 	if(this.category_description != '') {
		// 		axios({
		// 			method : "POST",
		// 			url : this.urlRoot + "admin/add_category.php",
		// 			data : {
		// 				description : this.category_description
		// 			}
		// 		}).then(function (response){
		// 			console.log(response);
		// 			if(response.status == 200) {
		// 				vm.retrieveCategory();
		// 				swal("Congrats!", " New category added!", "success");	
		// 				vm.clearData();

		// 				vm.category_description = false;

		// 				$('#myModal').modal('hide');
		// 			} else {
		// 				vm.category_description_error = response.data.category_description_error;
		// 			}
					
		// 		});
		// 	}
		// },
		// updateCategoryButton : function(category_id,category_description) {
		// 	this.category_id = category_id;
		// 	this.category_description = category_description;
		// },
		// updateCategory : function() {
		// 	if(this.category_id == "") {
		// 		this.category_id_error = true;
		// 	}
		// 	else {
		// 		this.category_id_error = false;
		// 	}

		// 	if(this.category_description == "") {
		// 		this.category_description_error = true;
		// 	}
		// 	else {
		// 		this.category_description_error = false;
		// 	}

		// 	if(this.category_id != '' && this.category_description != '') {
		// 		axios({
		// 			method : "POST",
		// 			url : this.urlRoot + "admin/update_category.php",
		// 			data : {
		// 				category_id : this.category_id,
		// 				description : this.category_description
		// 			}
		// 		}).then(function (response){
		// 			console.log(response);
		// 			if(response.data.status == "OK") {
		// 				vm.retrieveCategory();
		// 				swal("Congrats!", " Update category successfully!", "success");	
		// 				vm.clearData();

		// 				vm.category_description_error = false;

		// 				$('#myModal1').modal('hide');
		// 			} else {
		// 				vm.category_description_error = response.data.category_description_error;
		// 			}

		// 		});
		// 	}
		// },
		////// end of category method /////////

		////// start of unit_category method /////////
		// searchUnitCategory : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/search_unit_category.php?keyword=",
		// 		params : {
		// 			keyword : this.search_unit_category
		// 		}
		// 	}).then(function (response){
		// 		vm.unit_categories = response.data;
		// 	});
		// },
		// retrieveUnitCategory : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_unit_category.php"
		// 	}).then(function (response){
		// 		vm.unit_categories = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// countUnitCategory : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.unit_categories.length; index++) {
		// 		count++;
		// 	}
		// 	return count;
		// },
		// addUnitCategory : function() {
		// 	if(this.unit_category_unit == "") {
		// 		this.unit_category_unit_error = true;
		// 	}
		// 	else {
		// 		this.unit_category_unit_error = false;
		// 	}

		// 	if(this.unit_category_unit != '') {
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "admin/add_unit_category.php",
		// 		data : {
		// 			unit : this.unit_category_unit
		// 		}
		// 	}).then(function (response){
		// 			console.log(response);
		// 			if(response.status == 200) {
		// 				vm.retrieveUnitCategory();
		// 				swal("Congrats!", " New unit category added!", "success");	
		// 				vm.clearData();

		// 				vm.unit_category_unit = false;

		// 				$('#myModal').modal('hide');
		// 			} else {
		// 				vm.unit_category_unit_error = response.data.unit_category_unit_error;
		// 			}

		// 		});
		// 	}
		// },
		// updateUnitCategoryButton : function(unit_category_id,unit_category_unit) {
		// 	this.unit_category_id = unit_category_id;
		// 	this.unit_category_unit = unit_category_unit;
		// },
		// updateUnitCategory : function() {
		// 	if(this.unit_category_id == "") {
		// 		this.unit_category_id_error = true;
		// 	}
		// 	else {
		// 		this.unit_category_id_error = false;
		// 	}
		// 	if(this.unit_category_unit == "") {
		// 		this.unit_category_unit_error = true;
		// 	}
		// 	else {
		// 		this.unit_category_unit_error = false;
		// 	}

		// 	if(this.unit_category_id != '' && this.unit_category_unit != '') {
		// 		axios({
		// 			method : "POST",
		// 			url : this.urlRoot + "admin/update_unit_category.php",
		// 			data : {
		// 				unit_category_id : this.unit_category_id,
		// 				unit : this.unit_category_unit
		// 			}
		// 		}).then(function (response){
		// 			console.log(response);
		// 			if (response.data.status == "OK") {
		// 				vm.retrieveUnitCategory();
		// 				swal("Congrats!", " Update category successfully!", "success");	
		// 				vm.clearData();

		// 				vm.unit_category_id = false;
		// 				vm.unit_category_unit = false;

		// 				$('#myModal1').modal('hide');
		// 			} else {
		// 				vm.unit_category_id_error = response.data.unit_category_id_error;
		// 				vm.unit_category_unit_error = response.data.unit_category_unit_error;
		// 			}
		// 		});
		// 	}
		// },
		////// end of unit_category method /////////

		////// start of medicine method /////////
		// retrieveMedicine : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_medicine.php"
		// 	}).then(function (response){
		// 		vm.medicines = response.data;
		// 	});
		// },
		// countMedicine : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.medicines.length; index++){
		// 		count++;
		// 	}
		// 	return count;
		// },
		// addMedicine : function() {
		// 	//get id of description in tbl_category
		// 	for(var index = 0; index < this.categories.length; index++){
		// 		if(this.categories[index].description == this.category_description){
		// 			this.medicine_category_id = this.categories[index].category_id;
		// 		}
		// 	} 

			//get id of unit in tbl_unit_category
		// 	for(var index = 0; index < this.unit_categories.length; index++){
		// 		if(this.unit_categories[index].unit == this.unit_category_unit){
		// 			this.medicine_unit_category_id = this.unit_categories[index].unit_category_id;
		// 		}
		// 	}

		// 	this.medicine_barangay_id = "19";
		// 	this.status = "Active"

		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "admin/add_medicine.php",
		// 		data : {
		// 			medicine_name : this.medicine_name,
		// 			quantity : this.quantity,
		// 			price : this.price,
		// 			category_id : this.medicine_category_id,
		// 			unit_category_id : this.medicine_unit_category_id,
		// 			status : this.status,
		// 			barangay_id : this.medicine_barangay_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveMedicine();
		// 		swal("Congrats!", " New medicine added!", "success");
		// 		console.log(response);
		// 		vm.clearData();
		// 	});
		// },
		// updateMedicineButton : function(medicine_id,medicine_name,quantity,price,category_description,unit_category_unit,status,barangay_name) {
		// 	this.medicine_id = medicine_id;
		// 	this.medicine_name = medicine_name;
		// 	this.quantity = quantity;
		// 	this.price = price;
		// 	this.category_description = category_description;
		// 	this.unit_category_unit = unit_category_unit;
		// 	this.status = status;
		// 	this.barangay_name = barangay_name;

		// 	alert(status);
		// },
		// updateMedicine : function() {
			//get id of description in tbl_category
			// for(var index = 0; index < this.categories.length; index++){
			// 	if(this.categories[index].description == this.category_description){
			// 		this.medicine_category_id = this.categories[index].category_id;
			// 	}
			// } 

			//get id of unit in tbl_unit_category
			// for(var index = 0; index < this.unit_categories.length; index++){
			// 	if(this.unit_categories[index].unit == this.unit_category_unit){
			// 		this.medicine_unit_category_id = this.unit_categories[index].unit_category_id;
			// 	}
			// }

		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "admin/update_medicine.php",
		// 		data : {
		// 			medicine_id : this.medicine_id,
		// 			medicine_name : this.medicine_name,
		// 			quantity : this.quantity,
		// 			price : this.price,
		// 			category_id : this.medicine_category_id,
		// 			unit_category_id : this.medicine_unit_category_id,
		// 			status : this.status,
		// 			barangay_id : this.medicine_barangay_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveMedicine();
		// 		swal("Congrats!", " New medicine added!", "success");	
		// 		vm.clearData();
		// 	});
		// },
		// searchMedicine : function() {
		// 		axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/search_medicine.php?keyword=",
		// 		params : {
		// 			keyword : this.search_medicine
		// 		}
		// 	}).then(function (response){
		// 		vm.medicines = response.data;
		// 		console.log(response);
		// 	});
			
			
		// },
		// searchReceivedMedicine : function() {
		// 	if(this.search_gulod_medicine.trim() == "") {
		// 		swal("Notice!", " Search field is blank!", "error");
		// 		$('#myModal6').modal('hide');
		// 	}
		// 	else {
		// 		$('#myModal6').modal('show');
		// 		axios({
		// 			method : "GET",
		// 			url : this.urlRoot + "gulod/search_received_medicine.php?keyword=",
		// 			params : {
		// 				keyword : this.search_gulod_medicine
		// 			}
		// 		}).then(function (response){
		// 			vm.gulod_all_medicines = response.data;
		// 			console.log(response);
		// 		});
		// 	}
			
		// },
		////// end of medicine method /////////

		////// start of beneficiary method /////////
		// searchActiveBeneficiary : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/search_active_beneficiary.php?keyword=",
		// 		params : {
		// 			keyword : this.search_active_beneficiary.trim()
		// 		}
		// 	}).then(function (response){
		// 		vm.active_beneficiaries = response.data;
		// 		console.log(response);
		// 	});
		// },
		// searchNotActiveBeneficiary : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/search_not_active_beneficiary.php?keyword=",
		// 		params : {
		// 			keyword : this.search_not_active_beneficiary
		// 		}
		// 	}).then(function (response){
		// 		vm.not_active_beneficiaries = response.data;
		// 		console.log(response);
		// 	});
		// },
		// retrieveActiveBeneficiary : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_active_beneficiary.php"
		// 	}).then(function (response){
		// 		vm.active_beneficiaries = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// retrieveNotActiveBeneficiary : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_not_active_beneficiary.php"
		// 	}).then(function (response){
		// 		vm.not_active_beneficiaries = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// countActiveBeneficiary : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.active_beneficiaries.length; index++){
		// 		count++;
		// 	}
		// 	return count;
		// },
		// countNotActiveBeneficiary : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.not_active_beneficiaries.length; index++) {
		// 		count++;
		// 	}
		// 	return count;
		// },
		// addBeneficiary : function() {
		// 	var year = Number(this.beneficiary_birth_date.substr(0, 4));
		// 	var month = Number(this.beneficiary_birth_date.substr(4, 2));
		// 	var day = Number(this.beneficiary_birth_date.substr(6, 2));
		// 	var today = new Date();
		// 	var age = today.getFullYear() - year;

		// 	if(today.getMonth() < month || (today.getMonth() == month && today.getDate() < day)) {
		// 		age--;
		// 	}

		// 	if(age > 60) {
		// 		this.beneficiary_is_senior_citizen = "Yes";
		// 	}
		// 	else {
		// 		this.beneficiary_is_senior_citizen = "No";
		// 	}

		// 	//get id of unit in tbl_barangay
		// 	for(var index = 0; index < this.barangays.length; index++){
		// 		if(this.barangays[index].barangay_name == this.beneficiary_barangay_name){
		// 			this.beneficiary_barangay_id = this.barangays[index].barangay_id;
		// 		}
		// 	}
 
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "registration_staff/add_Beneficiary.php",
		// 		data : {
		// 			first_name : this.beneficiary_first_name,
		// 			last_name : this.beneficiary_last_name,
		// 			middle_name : this.beneficiary_middle_name,
		// 			contact_no : this.beneficiary_contact_no,
		// 			birth_date : this.beneficiary_birth_date,
		// 			email_address : this.beneficiary_email_address,
		// 			sex : this.beneficiary_sex,
		// 			address : this.beneficiary_address,
		// 			civil_status_id : this.beneficiary_civil_status_id,
		// 			is_active : "No",
		// 			is_senior_citizen : this.beneficiary_is_senior_citizen,
		// 			balance : "0.00",
		// 			barangay_id : this.beneficiary_barangay_id
		// 		}
		// 	}).then(function (response){
		// 		console.log(response);
		// 		swal("Congrats!", " beneficiary added successfully!", "success");
		// 		vm.retrieveSingleResident();
		// 		vm.clearData();
		// 	});
		// },
		// updateBeneficiaryButton : function (beneficiary_id,first_name,last_name,middle_name,contact_no,birth_date,email_address,sex,address,is_active,balance,barangay_name) {
		// 	this.beneficiary_id = beneficiary_id;			
		// 	this.beneficiary_first_name = first_name;
		// 	this.beneficiary_last_name = last_name;
		// 	this.beneficiary_middle_name = middle_name;
		// 	this.beneficiary_contact_no = contact_no;
		// 	this.beneficiary_birth_date = birth_date;
		// 	this.beneficiary_email_address = email_address;
		// 	this.beneficiary_sex = sex;
		// 	this.beneficiary_address = address;
		// 	this.beneficiary_is_active = is_active;
		// 	this.beneficiary_balance = balance;
		// 	this.beneficiary_barangay_name = barangay_name;
		// },
		// updateBeneficiary : function() {
		// 	//get id of unit in tbl_barangay
		// 	for(var index = 0; index < this.barangays.length; index++){
		// 		if(this.barangays[index].barangay_name == this.beneficiary_barangay_name){
		// 			this.beneficiary_barangay_id = this.barangays[index].barangay_id;
		// 		}
		// 	}
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "admin/update_beneficiary.php",
		// 		data : {
		// 			beneficiary_id : this.beneficiary_id,
		// 			first_name : this.beneficiary_first_name,
		// 			last_name : this.beneficiary_last_name,
		// 			middle_name : this.beneficiary_middle_name,
		// 			contact_no : this.beneficiary_contact_no,
		// 			birth_date : this.beneficiary_birth_date,
		// 			email_address : this.beneficiary_email_address,
		// 			sex : this.beneficiary_sex,
		// 			address : this.beneficiary_address,
		// 			is_active : this.beneficiary_is_active,
		// 			balance : this.beneficiary_balance,
		// 			barangay_id : this.beneficiary_barangay_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveActiveBeneficiary();
		// 		vm.retrieveNotActiveBeneficiary();
		// 		swal("Congrats!", " Update beneficiary successfully!", "success");	
		// 		vm.clearData();
		// 	});
		// },
		////// end of beneficiary method /////////

		////// start of dependent method /////////
		// retrieveSelectedDependent : function(beneficiary_id) {
		// 	this.beneficiary_id = beneficiary_id;
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_selected_dependent.php?beneficiary_id=",
		// 		params : {
		// 			beneficiary_id : this.beneficiary_id
		// 		}
		// 	}).then(function (response){
		// 		vm.dependents = response.data;
		// 		console.log(response);
		// 	});
		// },
		// retrieveDependent : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_dependent.php"
		// 	}).then(function (response){
		// 		vm.all_dependents = response.data;
		// 	});
		// },
		// countAllDependent : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.all_dependents.length; index++) {
		// 		count++;
		// 	}
		// 	return count;
		// },
		// countDependent : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.dependents.length; index++) {
		// 		count++;
		// 	}
		// 	return count;
		// },
		// dependentToBeneficiary : function(dependent_id,first_name,last_name,middle_name,contact_no,birth_date,email_address,sex,address,status,civil_status_id) {
		// 	this.dependent_id = dependent_id;
		// 	this.dependent_first_name = first_name;
		// 	this.dependent_last_name = last_name;
		// 	this.dependent_middle_name = middle_name;
		// 	this.dependent_contact_no = contact_no;
		// 	this.dependent_birth_date = birth_date;
		// 	this.dependent_email_address = email_address;
		// 	this.dependent_sex = sex;
		// 	this.dependent_address = address;
		// 	this.dependent_status = status;
		// 	this.beneficiary_civil_status_id = civil_status_id;
		// },
		// dependentMoveToBeneficiary : function() {
		// 	this.deactivateDependent();

		// 	this.beneficiary_first_name = this.dependent_first_name;
		// 	this.beneficiary_last_name = this.dependent_last_name;
		// 	this.beneficiary_middle_name = this.dependent_middle_name;
		// 	this.beneficiary_contact_no = this.dependent_contact_no;
		// 	this.beneficiary_birth_date = this.dependent_birth_date;
		// 	this.beneficiary_email_address = this.dependent_email_address;
		// 	this.beneficiary_sex = this.dependent_sex;
		// 	this.beneficiary_address = this.dependent_address;
		// 	this.beneficiary_is_active = "No";
		// 	this.beneficiary_balance = "0.00";
		// 	this.beneficiary_barangay_id = "0";

		// 	var is_senior_citizen = "No";


		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "registration_staff/add_Beneficiary.php",
		// 		data : {
		// 			first_name : this.beneficiary_first_name,
		// 			last_name : this.beneficiary_last_name,
		// 			middle_name : this.beneficiary_middle_name,
		// 			contact_no : this.beneficiary_contact_no,
		// 			birth_date : this.beneficiary_birth_date,
		// 			email_address : this.beneficiary_email_address,
		// 			sex : this.beneficiary_sex,
		// 			address : this.beneficiary_address,
		// 			civil_status_id : this.beneficiary_civil_status_id,
		// 			is_senior_citizen : "No",
		// 			is_active :"Yes",
		// 			balance : "0.00",
		// 			barangay_id : this.beneficiary_barangay_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveActiveBeneficiary();
		// 		console.log(response);
		// 		vm.clearData();
		// 	});


		// },
		// deactivateDependent : function() {
		// 	this.dependent_status = "Not Active";
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "registration_staff/update_dependent.php",
		// 		data : {
		// 			dependent_id : this.dependent_id,
		// 			dependent_first_name : this.dependent_first_name,
		// 			dependent_last_name : this.dependent_last_name,
		// 			dependent_middle_name : this.dependent_middle_name,
		// 			dependent_contact_no : this.dependent_contact_no,
		// 			dependent_birth_date : this.dependent_birth_date,
		// 			dependent_email_address : this.dependent_email_address,
		// 			dependent_sex : this.dependent_sex,
		// 			dependent_address : this.dependent_address,
		// 			dependent_status : this.dependent_status,
		// 			dependent_beneficiary_id : this.dependent_beneficiary_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveDependent();
		// 		console.log(response);
		// 		vm.clearData();
		// 	});
		// },
		// addDependent : function() {
		// 	this.dependent_status = "Active";
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "registration_staff/add_dependent.php",
		// 		data : {
		// 			dependent_id : this.dependent_id,
		// 			dependent_first_name : this.dependent_first_name,
		// 			dependent_last_name : this.dependent_last_name,
		// 			dependent_middle_name : this.dependent_middle_name,
		// 			dependent_contact_no : this.dependent_contact_no,
		// 			dependent_birth_date : this.dependent_birth_date,
		// 			dependent_email_address : this.dependent_email_address,
		// 			dependent_sex : this.dependent_sex,
		// 			dependent_address : this.dependent_address,
		// 			dependent_status : this.dependent_status,
		// 			dependent_beneficiary_id : this.dependent_beneficiary_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveDependent();
		// 		swal("Congrats!", " Add dependent successfully!", "success");
		// 		console.log(response);
		// 		vm.clearData();
		// 	});
		// },
		// insertDependentToBeneficiary : function(id) {
		// 	this.dependent_beneficiary_id = id;
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "registration_staff/update_dependent.php",
		// 		data : {
		// 			dependent_id : this.dependent_id,
		// 			dependent_first_name : this.dependent_first_name,
		// 			dependent_last_name : this.dependent_last_name,
		// 			dependent_middle_name : this.dependent_middle_name,
		// 			dependent_contact_no : this.dependent_contact_no,
		// 			dependent_birth_date : this.dependent_birth_date,
		// 			dependent_email_address : this.dependent_email_address,
		// 			dependent_sex : this.dependent_sex,
		// 			dependent_address : this.dependent_address,
		// 			dependent_status : this.dependent_status,
		// 			civil_status_id : this.dependent_civil_status_id,
		// 			dependent_beneficiary_id : this.dependent_beneficiary_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveDependent();
		// 		// vm.retrieveSelectedDependent(vm.gulod_beneficiary_info_beneficiary_id);
		// 		vm.getDependentBeneficiaryInfo(vm.gulod_beneficiary_info_beneficiary_id);
		// 		swal("Congrats!", " Dependent added successfully!", "success");
		// 		vm.clearData();
		// 		$("#myModal3").modal("hide");
		// 	});
		// },
		// updateDependentButton : function(id,first_name,last_name,middle_name,contact_no,birth_date,email_address,sex,address,status,civil_status_id,beneficiary_id) {
		// 	this.dependent_id = id;
		// 	this.dependent_first_name = first_name;
		// 	this.dependent_last_name = last_name;
		// 	this.dependent_middle_name = middle_name;
		// 	this.dependent_contact_no = contact_no;
		// 	this.dependent_birth_date = birth_date;
		// 	this.dependent_email_address = email_address;
		// 	this.dependent_sex = sex;
		// 	this.dependent_address = address;
		// 	this.dependent_status = status;
		// 	this.dependent_civil_status_id = civil_status_id;
		// 	this.dependent_beneficiary_id = beneficiary_id;
		// },
		// updateDependent : function() {
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "registration_staff/update_dependent.php",
		// 		data : {
		// 			dependent_id : this.dependent_id,
		// 			dependent_first_name : this.dependent_first_name,
		// 			dependent_last_name : this.dependent_last_name,
		// 			dependent_middle_name : this.dependent_middle_name,
		// 			dependent_contact_no : this.dependent_contact_no,
		// 			dependent_birth_date : this.dependent_birth_date,
		// 			dependent_email_address : this.dependent_email_address,
		// 			dependent_sex : this.dependent_sex,
		// 			dependent_address : this.dependent_address,
		// 			dependent_status : this.dependent_status,
		// 			dependent_beneficiary_id : this.dependent_beneficiary_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveDependent();
		// 		swal("Congrats!", " Dependent update successfully!", "success");
		// 		vm.clearData();
		// 	});
		// },
		////// end of dependent method /////////

		////// start of barangay method /////////
		// retrieveInventory : function() {
		// 	for(var index = 0; index < this.barangays.length; index++){
		// 		if(this.barangays[index].barangay_name == this.barangay_name){
		// 			this.barangay_id = this.barangays[index].barangay_id;

		// 		}
		// 	}

		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_inventory.php?barangay_id=",
		// 		params : {
		// 			barangay_id : this.barangay_id
		// 		}
		// 	}).then(function (response){
		// 		vm.barangay_inventories = response.data;
		// 	});

		// },
		// totalMedicinePrice : function() {
		// 	var total = 0;

		// 	for(var index = 0; index < this.barangay_inventories.length; index++) {
		// 		total += parseInt(this.barangay_inventories[index].price) * parseInt(this.barangay_inventories[index].quantity);
		// 	}
		// 	return parseInt(total)  + ".00";
		// },
		// countBarangay : function() {
		// 	var count_user = 0;
		// 	for(var index = 0; index < this.barangay_inventories.length; index++){
		// 		count_user++;
		// 	}
		// 	return count_user;
		// },

		////// end of barangay method /////////

		// gulodtotalInStock : function() {
		// 	var total = 0;

		// 	for(var index = 0; index < this.gulod_medicines.length; index++) {
		// 		total += parseInt(this.gulod_medicines[index].price) * parseInt(this.gulod_medicines[index].quantity);
		// 	}
		// 	return parseInt(total)  + ".00";
		// },

		////// start of gulod method /////////
		// toggleBeneficiaryInfo : function(id,first_name,last_name,address,contact_no,email,birth_date) {
		// 	if(this.gulod_beneficiary_info == false) {
		// 		this.gulod_beneficiary_info = true;
		// 	}
		// 	else {
		// 		this.gulod_beneficiary_info = false;
		// 	}

		// 	this.gulod_beneficiary_info_beneficiary_id = id;
		// 	this.gulod_beneficiary_info_first_name = first_name;
		// 	this.gulod_beneficiary_info_last_name = last_name;
		// 	this.gulod_beneficiary_info_address = address;
		// 	this.gulod_beneficiary_info_contact_no = contact_no;
		// 	this.gulod_beneficiary_info_email = email;
		// 	this.gulod_beneficiary_info_birth_date = birth_date;

		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "gulod/retrieve_transaction_details.php?beneficiary_id=",
		// 		params : {
		// 			beneficiary_id : this.gulod_beneficiary_info_beneficiary_id
		// 		}
		// 	}).then(function (response){
		// 		vm.gulod_transaction_details = response.data;
		// 		console.log(response);
		// 		vm.clearData();
		// 	});		
		// },
		searchGulodMedicine : function() {
			
			axios({
				method : "GET",
				url : this.urlRoot + "gulod/search_medicine.php?keyword=",
				params : {
					keyword : this.search_gulod_medicine
				}
			}).then(function (response){
				vm.gulod_medicines = response.data;
			});
			
		},
		// viewGulodMedicine : function() {
		// 	$('#myModal6').modal('show');
		// },
		// searchCityHallMedicine : function() {

		// 	if(this.search_city_hall_medicine.trim() == "") {
		// 		swal("Notice!", " Search field is blank!", "error");
		// 		$('#myModal6').modal('hide');
		// 	}
		// 	else {
		// 		$('#myModal6').modal('show');
		// 		axios({
		// 			method : "GET",
		// 			url : this.urlRoot + "admin/search_city_hall_medicine.php?keyword=",
		// 			params : {
		// 				keyword : this.search_city_hall_medicine
		// 			}
		// 		}).then(function (response){
		// 			vm.medicines = response.data;
		// 		});
		// 	}
			
		// },
		// searchAllGulodMedicine : function() {
		// 	if(this.search_gulod_medicine.trim() == "") {
		// 		swal("Notice!", " Search field is blank!", "error");
		// 		$('#myModal6').modal('hide');
		// 	}
		// 	else {
		// 		$('#myModal6').modal('show');
		// 		axios({
		// 			method : "GET",
		// 			url : this.urlRoot + "gulod/search_medicine.php?keyword=",
		// 			params : {
		// 				keyword : this.search_gulod_medicine
		// 			}
		// 		}).then(function (response){
		// 			vm.gulod_all_medicines = response.data;
		// 			console.log(response);
		// 		});
		// 	}

			
		// },
		// searchGulodBeneficiary : function() {

			// if(this.search_gulod_beneficiary.trim() == "") {
			// 	s
			// }
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "gulod/search_beneficiary.php?keyword=",
		// 		params : {
		// 			keyword : this.search_gulod_beneficiary
		// 		}
		// 	}).then(function (response){
		// 		vm.gulod_active_beneficiaries = response.data;
		// 		console.log(response);
		// 	});
		// },
		// retrieveGulodMedicine : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "gulod/retrieve_medicine.php",
		// 	}).then(function (response){
		// 		vm.gulod_medicines = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// retrieveGulodInactiveMedicine : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "gulod/retrieve_inactive_medicine.php",
		// 	}).then(function (response){
		// 		vm.gulod_inactive_medicines = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// countGulodInactiveMedicine : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.gulod_inactive_medicines.length; index++) {
		// 		count++;
		// 	}

		// 	return count;
		// },
		// retrieveOutOfStockGulod : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "gulod/retrieve_out_of_stock_gulod.php",
		// 	}).then(function (response){
		// 		vm.gulod_out_of_stock = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// retrieveLowStockGulod : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "gulod/retrieve_low_of_stock_gulod.php",
		// 	}).then(function (response){
		// 		vm.gulod_low_stock = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// retrieveGulodBeneficiary : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "gulod/retrieve_active_beneficiary.php",
		// 	}).then(function (response){
		// 		vm.gulod_active_beneficiaries = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// countGulodBeneficiary : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.gulod_active_beneficiaries.length; index++){
		// 		count++;
		// 	}
		// 	return count;
		// },
		// countGulodMedicine : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.gulod_medicines.length; index++){
		// 		count++;
		// 	}
		// 	return count;
		// },
		// countGulodOutofStock : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.gulod_out_of_stock.length; index++){
		// 		count++;
		// 	}
		// 	return count;
		// },
		// countGulodLowStock : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.gulod_low_stock.length; index++){
		// 		count++;
		// 	}
		// 	return count;
		// },
		// addCityHallMedicine : function() {

		// 	var checkPrice = parseFloat(this.gulod_medicine_price);
		// 	if(!isNaN(checkPrice) && checkPrice.toString().indexOf('.') != -1) {
		// 		this.gulod_medicine_price = checkPrice;
				
		// 	}
		// 	else {
		// 		this.gulod_medicine_price = checkPrice + ".00";
		// 	}
		// 	//get id of description in tbl_category
		// 	for(var index = 0; index < this.categories.length; index++){
		// 		if(this.categories[index].description == this.gulod_medicine_category){
		// 			this.gulod_medicine_category_id = this.categories[index].category_id;
		// 		}
		// 	} 

			//get id of unit in tbl_unit_category
		// 	for(var index = 0; index < this.unit_categories.length; index++){
		// 		if(this.unit_categories[index].unit == this.gulod_medicine_unit_category){
		// 			this.gulod_medicine_unit_category_id = this.unit_categories[index].unit_category_id;
		// 		}
		// 	}

		// 	this.gulod_medicine_barangay_id = 19;


		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "gulod/add_medicine.php",
		// 		data : {
		// 			medicine_name : this.gulod_medicine_name,
		// 			quantity : "0",
		// 			price : this.gulod_medicine_price,
		// 			category_id : this.gulod_medicine_category_id,
		// 			unit_category_id : this.gulod_medicine_unit_category_id,
		// 			status : "Active",
		// 			barangay_id : this.gulod_medicine_barangay_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveGulodMedicine();
		// 		swal("Congrats!", " New medicine added!", "success");
		// 		console.log(response)	
		// 		vm.clearData();
		// 	});
		// },
		// updateGulodMedicineButton : function(medicine_id,medicine_name,medicine_quantity,medicine_price,medicine_category,medicine_unit, medicine_status) {
		// 	this.gulod_medicine_id = medicine_id;
		// 	this.gulod_medicine_name = medicine_name;
		// 	this.gulod_medicine_quantity = medicine_quantity;
		// 	this.gulod_medicine_price = medicine_price;
		// 	this.gulod_medicine_category = medicine_category;
		// 	this.gulod_medicine_unit_category = medicine_unit;
		// 	this.gulod_medicine_status = medicine_status;			

		// },
		// updateGulodMedicine : function() {
		// 	var checkPrice = parseFloat(this.gulod_medicine_price);
		// 	if(!isNaN(checkPrice) && checkPrice.toString().indexOf('.') != -1) {
		// 		this.gulod_medicine_price = checkPrice;
				
		// 	}
		// 	else {
		// 		this.gulod_medicine_price = checkPrice + ".00";
		// 	}

			//get id of description in tbl_category
			// for(var index = 0; index < this.categories.length; index++){
			// 	if(this.categories[index].description == this.gulod_medicine_category){
			// 		this.gulod_medicine_category_id = this.categories[index].category_id;
			// 	}
			// } 

			//get id of unit in tbl_unit_category
			// for(var index = 0; index < this.unit_categories.length; index++){
			// 	if(this.unit_categories[index].unit == this.gulod_medicine_unit_category){
			// 		this.gulod_medicine_unit_category_id = this.unit_categories[index].unit_category_id;
			// 	}
			// }

		// 	this.gulod_medicine_barangay_id = 1;


		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "gulod/update_medicine.php",
		// 		data : {
		// 			medicine_id : this.gulod_medicine_id,
		// 			medicine_name : this.gulod_medicine_name,
		// 			quantity : this.gulod_medicine_quantity,
		// 			price : this.gulod_medicine_price,
		// 			category_id : this.gulod_medicine_category_id,
		// 			unit_category_id : this.gulod_medicine_unit_category_id,
		// 			status : this.gulod_medicine_status,
		// 			barangay_id : this.gulod_medicine_barangay_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveGulodMedicine();
		// 		vm.retrieveGulodInactiveMedicine();
		// 		swal("Congrats!", " Update medicine successfully!", "success");	
		// 		vm.clearData();
		// 	});
		// },
		// updateGulodBeneficiaryButton : function (beneficiary_id,first_name,last_name,middle_name,contact_no,birth_date,email_address,sex,address,is_active,balance,barangay_id) {
		// 	this.gulod_beneficiary_id = beneficiary_id;
		// 	this.gulod_beneficiary_first_name = first_name;
		// 	this.gulod_beneficiary_last_name = last_name;
		// 	this.gulod_beneficiary_middle_name = middle_name;
		// 	this.gulod_beneficiary_contact_no = contact_no;
		// 	this.gulod_beneficiary_birth_date = birth_date;
		// 	this.gulod_beneficiary_email_address = email_address;
		// 	this.gulod_beneficiary_sex = sex;
		// 	this.gulod_beneficiary_address = address;
		// 	this.gulod_beneficiary_is_active = is_active;
		// 	this.gulod_beneficiary_balance = balance;
		// 	this.gulod_beneficiary_barangay_id = barangay_id;

		// 	for(var index = 0; index < this.barangays.length; index++){
		// 		if(this.barangays[index].barangay_id == this.gulod_beneficiary_barangay_id){
		// 			this.gulod_beneficiary_barangay_name = this.barangays[index].barangay_name;
		// 		}
		// 	}
		// },
		// updateGulodBeneficiary : function() {
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "admin/update_beneficiary.php",
		// 		data : {
		// 			beneficiary_id : this.gulod_beneficiary_id,
		// 			first_name : this.gulod_beneficiary_first_name,
		// 			last_name : this.gulod_beneficiary_last_name,
		// 			middle_name : this.gulod_beneficiary_middle_name,
		// 			contact_no : this.gulod_beneficiary_contact_no,
		// 			birth_date : this.gulod_beneficiary_birth_date,
		// 			email_address : this.gulod_beneficiary_email_address,
		// 			sex : this.gulod_beneficiary_sex,
		// 			address : this.gulod_beneficiary_address,
		// 			is_active : this.gulod_beneficiary_is_active,
		// 			balance : this.gulod_beneficiary_balance,
		// 			barangay_id : this.gulod_beneficiary_barangay_id
		// 		}
		// 	}).then(function (response){
		// 		vm.retrieveGulodBeneficiary();
		// 		swal("Congrats!", " Update beneficiary successfully!", "success");	
		// 		vm.clearData();
		// 	});
		// },
		// beneficiaryGulodTransactionButton : function(id, first_name, last_name, middle_name, contact_no, birth_date, email_address, sex, address, is_active, balance, barangay_id){
		// 	this.gulod_beneficiary_id = id;
		// 	this.gulod_beneficiary_first_name = first_name;
		// 	this.gulod_beneficiary_last_name = last_name;
		// 	this.gulod_beneficiary_middle_name = middle_name;
		// 	this.gulod_beneficiary_contact_no = contact_no;
		// 	this.gulod_beneficiary_birth_date = birth_date;
		// 	this.gulod_beneficiary_email_address = email_address;
		// 	this.gulod_beneficiary_sex = sex;
		// 	this.gulod_beneficiary_address = address;
		// 	this.gulod_beneficiary_is_active = is_active;
		// 	this.gulod_beneficiary_balance = balance;
		// 	this.gulod_beneficiary_barangay_id = barangay_id;

		// 	this.gulod_beneficiary_first_name_in_cart = first_name;
		// 	this.gulod_transaction_beneficiary_id = id;

		// 	if(this.gulod_transaction_button == false){
		// 		this.gulod_transaction_button = true;
		// 		this.gulod_beneficiary_info = false;
		// 		this.showReceipt = false;
		// 		this.showBeneficiaryTransaction = true;
		// 	}
		// 	else {
				// this.gulod_transaction_button = false;
				// this.gulod_transactions = [];
		// 		if(this.gulod_transactions.length > 0) {
		// 			this.gulod_beneficiary_first_name_in_cart = first_name;
		// 			swal({
		// 				title : "Are you sure?",
		// 				text : "The item/s in your cart will be discard!",
		// 				icon : "warning",
		// 				buttons : ["Cancel", "Discard"],
		// 				dangerMode: true,
		// 			}).then((willDiscard) => {
						
		// 				if(willDiscard) {
		// 					this.gulod_transaction_button = false;
		// 					this.gulod_transactions = [];
		// 					this.clearData();
		// 				}
		// 				else {
		// 					this.gulod_transaction_button = true;
		// 				}
		// 			});
		// 		}
		// 		else {
		// 			this.gulod_transaction_button = false;
		// 		}
				
		// 	}
		// 	this.gulod_receipts = [];
		// },
		// gulodTransactionButton : function(id,medicine_name,medicine_quantity,medicine_price,medicine_category,medicine_unit) {
		// 	this.gulod_transaction_medicine_id = id;
		// 	this.gulod_transaction_medicine_name = medicine_name;
		// 	this.gulod_transaction_quantity = medicine_quantity;
		// 	this.gulod_transaction_medicine_price = medicine_price;
		// 	this.gulod_transaction_medicine_category = medicine_category;
		// 	this.gulod_transaction_medicine_unit_category = medicine_unit;
		// },
		
		// gulodTransactionAddToCart : function() {
		// 	this.gulod_transaction_medicine_total_price = (parseFloat(this.gulod_transaction_medicine_price) * parseFloat(this.input_quantity));
		// 	this.gulod_transaction_purchase.id = this.gulod_transaction_medicine_id;
		// 	this.gulod_transaction_purchase.name = this.gulod_transaction_medicine_name;
		// 	this.gulod_transaction_purchase.price = this.gulod_transaction_medicine_price;
		// 	this.gulod_transaction_purchase.quantity = this.input_quantity;
		// 	this.gulod_transaction_purchase.description = this.gulod_transaction_medicine_category;
		// 	this.gulod_transaction_purchase.unit = this.gulod_transaction_medicine_unit_category;
		// 	this.gulod_transaction_purchase.total = parseFloat(this.gulod_transaction_medicine_total_price);

		// 	var found = true;
		// 	var found1 = false;
		// 	if (parseInt(this.input_quantity) > this.gulod_transaction_quantity) {
		// 		// this.errors.push('You exceed the maximum quantity.');
		// 		this.input_quantity = 1;
		// 		found = false;
		// 		return;
		// 	}

		// 	for(var index = 0; index < this.gulod_medicines.length; index++) {
		// 		for(var index1 = 0; index1 < this.gulod_transactions.length; index1++) {
		// 			if(this.gulod_transaction_purchase.id == this.gulod_transactions[index1].id) {
		// 				if(this.gulod_transactions[index1].id == this.gulod_medicines[index].medicine_id) {
		// 					var total = parseInt(this.gulod_transaction_purchase.quantity) + parseInt(this.gulod_transactions[index1].quantity);
		// 					if(total > this.gulod_medicines[index].quantity) {
		// 						swal("Error!", " You already exceed the maximun quantity!", "error");
		// 						found = false;
		// 					}
		// 					else {
		// 						if(this.gulod_transaction_purchase.id == this.gulod_transactions[index1].id) {
		// 							found = false;
		// 							found1 = true;

		// 							this.gulod_transactions[index1].quantity = total;
		// 							this.gulod_transactions[index1].total = (parseFloat(total) * parseInt(this.gulod_medicines[index].price));

		// 							var str = this.gulod_transactions[index1].total;
		// 						}
		// 					}
		// 				}
		// 			}
		// 		}
		// 	}

		// 	if(found) {
		// 		this.gulod_transactions.push({...this.gulod_transaction_purchase});
		// 		this.clearData();
				
		// 		this.showBeneficiaryTransaction = true;
		// 		$('#myModal3').modal('hide');
		// 		this.input_quantity = 1;
		// 	}
		// 	if(found1) {
		// 		this.showBeneficiaryTransaction = true;
		// 		$('#myModal3').modal('hide');
		// 		this.clearData();
		// 		this.input_quantity = 1;
		// 	}
		// 	this.updateButtonTransaction = true;
		// 	this.saveButtonTransaction = false;
		// },
		// removeTransactionAddToCart : function(index) {
  //     		this.gulod_transactions.splice(index, 1);
  //   	},
    	// removeReceivedOrder : function(index) {
    	// 	this.received_orders.splice(index, 1);
    	// },
    	// countTransactionCart : function() {
    	// 	var count = 0;
    	// 	for(var index = 0; index < this.gulod_transactions.length; index++) {
    	// 		count++;
    	// 	}
    	// 	return count;
    	// },
   //  	retrieveTransaction : function() {
   //  		axios({
			// 	method : "GET",
			// 	url : this.urlRoot + "gulod/retrieve_transaction.php",
			// }).then(function (response){
			// 	vm.gulod_save_transactions = response.data;
			// });
   //  	},
   //  	gulodSaveTransaction : function() {

   //  		if(this.gulod_transactions.length == 0 ) {
   //  			swal("Error!", " You have 0 item in your cart!", "error");
   //  		}
   //  		else {
   //  			for(var index = 0; index < this.active_beneficiaries.length; index++) {
   //  				if(this.active_beneficiaries[index].beneficiary_id == this.gulod_transaction_beneficiary_id) {
   //  					if(this.active_beneficiaries[index].balance >= 10000) {
   //  						swal("Error", " You used your 10,000 worth of medicine!", "error");
   //  					}
   //  					else {
   //  						vm.gulodAddTransaction();
			// 	    		// vm.gulodTransactionUpdateMedicineQuantity();
			// 	   			// vm.gulodTransactionUpdateBeneficiaryBalance();

   //  					}
   //  				}
   //  			}

   //  			for(var index = 0; index < this.gulod_transactions.length; index++) {
   //  				this.gulod_transaction_receipt.id = this.gulod_transactions[index].id;
   //  				this.gulod_transaction_receipt.medicine_name = this.gulod_transactions[index].name;
   //  				this.gulod_transaction_receipt.price = this.gulod_transactions[index].price;
   //  				this.gulod_transaction_receipt.quantity = this.gulod_transactions[index].quantity;
   //  				this.gulod_transaction_receipt.total = this.gulod_transactions[index].total;

   //  				this.gulod_receipts.push({...this.gulod_transaction_receipt});
   //  			}
   //  			this.gulod_transactions = [];
			// 	this.showBeneficiaryTransaction = false; //hide medicine transaction table
	  //   		this.showReceipt = true; //show transaction receipt
   //  		}
    		
    		
   //  	},
   //  	gulodTransactionUpdateBeneficiaryBalance : function() {
   //  		for(var index = 0; index < this.gulod_transactions.length; index++) {
   //  			this.gulod_beneficiary_balance = parseFloat(this.gulod_beneficiary_balance) + parseFloat(this.gulod_transactions[index].total);
   //  		}
   //  		for(var index = 0; index < this.active_beneficiaries.length; index++) {
    			

   //  			if(this.gulod_transaction_beneficiary_id == this.active_beneficiaries[index].beneficiary_id) {
   //  				this.gulod_receipt_first_name = this.active_beneficiaries[index].first_name;
			// 		this.gulod_receipt_last_name = this.active_beneficiaries[index].last_name;
	  //   			this.gulod_receipt_address = this.active_beneficiaries[index].address;
	  //   			this.gulod_receipt_contact_no = this.active_beneficiaries[index].contact_no;

   //  				axios({
			// 			method : "POST",
			// 			url : this.urlRoot + "gulod/update_beneficiary.php",
			// 			data : {
			// 				beneficiary_id : this.active_beneficiaries[index].beneficiary_id,
			// 				first_name : this.active_beneficiaries[index].first_name,
			// 				last_name : this.active_beneficiaries[index].last_name,
			// 				middle_name : this.active_beneficiaries[index].middle_name,
			// 				contact_no : this.active_beneficiaries[index].contact_no,
			// 				birth_date : this.active_beneficiaries[index].birth_date,
			// 				email_address : this.active_beneficiaries[index].email_address,
			// 				sex : this.active_beneficiaries[index].sex,
			// 				address : this.active_beneficiaries[index].address,
			// 				is_active : this.active_beneficiaries[index].is_active,
			// 				balance : this.gulod_beneficiary_balance,
			// 				is_senior_citizen : "No",
			// 				barangay_id : this.active_beneficiaries[index].barangay_id
			// 			}
			// 		}).then(function (response){
			// 			vm.retrieveGulodBeneficiary();
			// 			swal("Congrats!", " Transaction save successfully!", "success");
			// 			console.log(response);
			// 			vm.clearData();
			// 		});
   //  			}
   //  		}
   //  	},
   //  	gulodAddTransaction : function() {
    		// transaction
    		// var currentDate = new Date();
    		// var currentMonth=('0'+(currentDate.getUTCMonth()+1)).slice(-2);
    		// var currentDay=('0'+(currentDate.getUTCDate())).slice(-2);


    		// for(var index = 0; index < this.active_beneficiaries.length; index++) {
    		// 	if(this.active_beneficiaries[index].beneficiary_id == this.gulod_transaction_beneficiary_id) {
    		// 		this.beneficiary_id = this.active_beneficiaries[index].beneficiary_id;
    		// 		break;
    		// 	}
    		// }

    	// 	axios({
    	// 		method : "POST",
    	// 		url : this.urlRoot + "gulod/add_transaction.php",
    	// 		data : {
    	// 			transaction_id : this.generateTransactionID(),
    	// 			beneficiary_id : this.beneficiary_id,
    	// 			user_id : "",		
    	// 			transaction_date : currentDate.getUTCFullYear() + "-" + currentMonth + "-" + currentDay
    	// 		}

    	// 	}).then(function (response) {
    	// 		console.log(response);
    			
    	// 	});

    	// 	this.gulodAddTransactionDetails();
    		
    	// },
    	// gulodAddTransactionDetails : function() {
    		// // transaction details
    	// 	var total = 0;
    	// 	for(var index = 0; index < this.gulod_transactions.length; index++) {
    	// 		this.medicine_id = this.gulod_transactions[index].id;
    	// 		this.medicine_quantity = this.gulod_transactions[index].quantity;
    	// 		total = this.gulod_transactions[index].total
    	// 		axios({
	    // 			method : "POST",
	    // 			url : this.urlRoot + "gulod/add_transaction_details.php",
	    // 			data : {
	    // 				transaction_id : "",
	    // 				quantity : this.medicine_quantity,		
	    // 				medicine_id : this.medicine_id,
	    // 				total_price : total
	    // 			}

	    // 		}).then(function (response) {
	    // 			console.log(response);
	    			
	    // 		});
    	// 	}

    	// 	this.gulodTransactionUpdateMedicineQuantity();
    	// },
    	// gulodTransactionUpdateMedicineQuantity : function() {
    	// 	for(var index = 0; index < this.gulod_transactions.length; index++) {

    	// 		for(var index1 = 0; index1 < this.gulod_medicines.length; index1++) {

    	// 			if(this.gulod_transactions[index].id == this.gulod_medicines[index1].supplier_medicine_id) {
    	// 				this.medicine_id = this.gulod_medicines[index1].medicine_id;
    	// 				this.gulod_medicine_supplier_id = this.medicines[index1].supplier_medicine_id;
    	// 				this.medicine_quantity = this.gulod_medicines[index1].quantity - this.gulod_transactions[index].quantity;
    	// 				this.medicine_price = this.gulod_transactions[index].price;
					// 	this.gulod_medicine_barangay_id = 1;
					// 	this.gulod_transaction_medicine_status = this.gulod_medicines[index1].status;
    		

					// 	axios({
					// 		method : "POST",
					// 		url : this.urlRoot + "gulod/update_medicine.php",
					// 		data : {
					// 			medicine_id : this.medicine_id,
					// 			supplier_medicine_id : this.gulod_medicine_supplier_id,
					// 			quantity : this.medicine_quantity,
					// 			status : this.gulod_transaction_medicine_status,
					// 			barangay_id : this.gulod_medicine_barangay_id
					// 		}
					// 	}).then(function (response){
					// 		swal("Congrats!", " Transaction save successfully!", "success");
					// 		vm.retrieveGulodMedicine();
							
					// 		vm.clearData();
					// 	});
    	// 			}
    	// 		}	
    	// 	}
    	// 	this.gulodTransactionUpdateBeneficiaryBalance();
    	// },
    	searchEndAndStartDate : function() {
    		axios({
				method : "GET",
				url : this.urlRoot + "gulod/search_date.php?keyword=",
				params : {
					keyword : this.start_date,
					keyword : this.end_date
				}
			}).then(function (response){
				vm.gulod_transaction_details = response.data;
			});
    	},
    	// generateTransactionID : function() {
    	// 	var id = "";
    	// 	var pad = "0000";
    	// 	var date = new Date();


    	// 	if(this.gulod_save_transactions.length <= 0) {
    	// 		id = "TRANS" + "" + date.getFullYear() +  "0001";
    	// 	}
    	// 	else {
    	// 		for(var index = 0; index < this.gulod_save_transactions.length; index++) {

    	// 			id = this.gulod_save_transactions[index].transaction_id;
    	// 		}
	    // 		id = id.slice(9);
	    // 		id = pad.substring(0, pad.length - id.length) + id;
	    // 		id = date.getUTCFullYear() + "" + id;
	    // 		id = parseInt(id) + 1;
	    // 		id = "TRANS" + id;
	    // 	}
	    // 	return id;
	    // },
	    generateReturnMedicineID : function() {
	    	var id = "";

	    	if(this.return_medicines.length == 0) {
	    		alert("test");
	    	}
	    	else {
	    		for(var index = 0; index < this.return_medicines.length; index++) {
	    			id = this.return_medicines[index].return_medicine_id;
	    		}
		    	id = parseInt(id) + 1;
	    	}
	    		
	    	return id;
	    },
	    //start of searching for total transaction of beneficiary
	 //    countTransactionDetail : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.search_transaction_details.length; index++){
		// 		count++;
		// 	}
		// 	return count;
		// },
	 //    toggleSearchTransaction : function() {
		// 	this.search_details = true;
		// 	this.search_pagination = true;
		// 	this.search_no_details = false;
		// },
		// clearSearch : function() {
		// 	this.search_details = false;
		// 	this.search_pagination = false;
		// 	this.search_no_details = true;
		// 	this.search_id_details = "";
		// },
	    // retrieveSearchTransactionDetail : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "search/retrieve_search_transaction_detail.php",
		// 	}).then(function (response){
		// 		vm.search_transaction_details = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// searchForTransactionDetail : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "search/search_transaction_detail.php?keyword=",
		// 		params : {
		// 			keyword : this.search_id_details
		// 		}
		// 	}).then(function (response){
		// 		vm.toggleSearchTransaction();
		// 		vm.search_transaction_details = response.data;
		// 	});
		// },
		//end of searching for total transaction of beneficiary

		// method for return medicine
		// toggleReturnMedicine : function() {
		// 	if(this.toggle_return_medicine == false) {
		// 		this.toggle_return_medicine = true;
		// 	}
		// 	else {
		// 		this.toggle_return_medicine = false;
		// 	}
		// },
		// getTransactionDetails : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "gulod/retrieve_transaction_details.php?beneficiary_id=",
		// 		params : {
		// 			beneficiary_id : this.return_medicine_beneficiary_id
		// 		}
		// 	}).then(function (response){
		// 		vm.gulod_transaction_details = response.data;
		// 		console.log(response);
		// 		vm.clearData();
		// 	});
		// },
		retrieveReturnMedicine : function() {
			axios({
				method : "GET",
				url : this.urlRoot + "gulod/retrieve_return_medicine.php"
			}).then(function (response){
				vm.return_medicines = response.data;
				console.log(response);
			});
		},
		gulodReturnMedicineButton : function(details_id, transaction_id, beneficiary_id, medicine_id, price, medicine_quantity, total_price) {
			this.return_medicine_details_id = details_id;
			this.return_medicine_transaction_id = transaction_id;
			this.return_medicine_beneficiary_id = beneficiary_id;
			this.return_medicine_id = medicine_id;
			this.return_medicine_price = price;
			this.return_medicine_quantity = medicine_quantity;
			this.return_medicine_total_price = total_price;

		},
		gulodReturnMedicine : function() {

			var currentDate = new Date();
    		var currentMonth=('0'+(currentDate.getUTCMonth()+1)).slice(-2);
    		var currentDay=('0'+(currentDate.getUTCDate())).slice(-2);

    		// for tbl_return_medicine
			axios({
    			method : "POST",
    			url : this.urlRoot + "gulod/add_return_medicine.php",
    			data : {
    				return_medicine_id : this.generateReturnMedicineID(),
    				beneficiary_id : this.return_medicine_beneficiary_id,	
    				date_return : currentDate.getUTCFullYear() + "-" + currentMonth + "-" + currentDay
    			}

    		}).then(function (response) {
    		});


    		// for tbl_return_medicine_details
   			axios({
    			method : "POST",
    			url : this.urlRoot + "gulod/add_return_medicine_details.php",
    			data : {
    				return_medicine_id : "",
    				medicine_id : this.return_medicine_id,	
    				quantity : this.return_medicine_quantity,
    				total_price : this.return_medicine_total_price,
    				remarks : this.return_medicine_remarks
    			}

    		}).then(function (response) {
    		});

    		// for updating quantity of tbl_transaction_details
   			this.gulodUpdateTransactionDetails();
		},
		// gulodUpdateTransactionDetails : function() {
		// 	for(var index = 0; index < this.gulod_transaction_details.length; index++) {
		// 		if(this.return_medicine_details_id == this.gulod_transaction_details[index].details_id) {
		// 			this.return_medicine_transaction_price = this.gulod_transaction_details[index].price;
		// 			break;
		// 		}
		// 	}
		// 	axios({
  //   			method : "POST",
  //   			url : this.urlRoot + "gulod/update_transaction_details.php",
  //   			data : {
  //   				details_id : this.return_medicine_details_id,
  //   				transaction_id : this.return_medicine_transaction_id,	
  //   				medicine_id : this.return_medicine_id,
  //   				price : this.return_medicine_price,
  //   				quantity : this.return_medicine_quantity - this.gulod_medicine_quantity,
  //   				total_price : this.return_medicine_total_price - this.return_medicine_transaction_price + ".00"
  //   			}

  //   		}).then(function (response) {
  //   			vm.retrieveTransaction();
  //   		});
		// },
		//start of retrieving data reports as of today
		// getDependentBeneficiaryInfo : function() {
		// 	this.retrieveSelectedDependent(this.gulod_beneficiary_info_beneficiary_id);
		// },
		// toggleRegistrationBeneficiaryInfo : function(id,first_name,middle_name,last_name,contact_no,birth_date,sex,email,address) {
		// 	if(this.gulod_beneficiary_info == false) {
		// 		this.gulod_beneficiary_info = true;
		// 		this.beneficiaryButtonToggle = false;
		// 		this.notActivebeneficiaryButtonToggle = false;
		// 		this
		// 	}
		// 	else {
		// 		this.gulod_beneficiary_info = false;
		// 		this.notActivebeneficiaryButtonToggle = false;
		// 		this.beneficiaryButtonToggle = true;
		// 	}
		// 	this.gulod_beneficiary_info_beneficiary_id = id;
		// 	this.gulod_beneficiary_info_first_name = first_name;
		// 	this.gulod_beneficiary_info_middle_name = middle_name;
		// 	this.gulod_beneficiary_info_last_name = last_name;
		// 	this.gulod_beneficiary_info_contact_no = contact_no;
		// 	this.gulod_beneficiary_info_birth_date = birth_date;
		// 	this.gulod_beneficiary_info_sex = sex;
		// 	this.gulod_beneficiary_info_email = email;
		// 	this.gulod_beneficiary_info_address = address;

			// axios({
			// 	method : "GET",
			// 	url : this.urlRoot + "gulod/retrieve_transaction_details.php?beneficiary_id=",
			// 	params : {
			// 		beneficiary_id : this.gulod_beneficiary_info_beneficiary_id
			// 	}
			// }).then(function (response){
			// 	vm.gulod_transaction_details = response.data;
			// 	vm.retrieveSelectedDependent(vm.gulod_beneficiary_info_beneficiary_id);
			// 	console.log(response);
			// 	vm.clearData();
			// });

		// },
		// registerBeneficiaryToggleInfo : function() {
		// 	if(this.beneficiaryButtonToggle == true){
		// 		this.beneficiaryButtonToggle = false;
		// 		this.notActivebeneficiaryButtonToggle = true;
		// 	}
		// 	else {
		// 		this.beneficiaryButtonToggle = true;
		// 		this.notActivebeneficiaryButtonToggle = false;
		// 	}
		// },
		retrieveReturnMedicine : function() {
			axios({
				method : "GET",
				url : this.urlRoot + "gulod/retrieve_date_today.php"
			}).then(function (response){
				vm.dateToday = response.data;
			});
		},
		countMedicineReports : function() {
	   		var count = 0;
			for(var index = 0; index < this.dateToday.length; index++){
				count++;
			}
			return count;
	   	},
	   	//end of retrieving data reports as of today

	   	// start received order and details 
	  //  	retrieveReceivedOrderDetails : function() {
	  //  		axios({
			// 	method : "GET",
			// 	url : this.urlRoot + "gulod/retrieve_received_order_details.php"
			// }).then(function (response){
			// 	vm.received_order_details = response.data;
			// });
	  //  	},
	   	// end received order

	   	retrieveExpiredMedicine : function() {
	   		axios({
				method : "GET",
				url : this.urlRoot + "gulod/retrieve_expired_medicine.php"
			}).then(function (response){
				vm.gulod_expired_medicines = response.data;
			});
	   	},
	   	countGulodExpiredMedicine : function() {
	   		var count = 0;
	   		for(var index = 0; index < this.gulod_expired_medicines.length; index++) {
	   			count++;
	   		}

	   		return count;
	   	},
  //  		countBeneficiaryTransactionDetail : function() {
	 //   		var count = 0;
		// 	for(var index = 0; index < this.gulod_transaction_details.length; index++){
		// 		count++;
		// 	}
		// 	return count;
	 //   	},
	 //   	toggleMedicineInfo : function(id, name, price, category, unit_category, quantity, supplier) {
		// 	if(this.gulod_medicine_info == false) {
		// 		this.gulod_medicine_info = true;
		// 		this.gulod_available_medicine = false;
		// 	}
		// 	else {
		// 		this.gulod_medicine_info = false;
		// 		this.gulod_available_medicine = true;
		// 	}

		// 	this.gulod_medicine_info_id = id;
		// 	this.gulod_medicine_info_name = name;
		// 	this.gulod_medicine_info_price = price;
		// 	this.gulod_medicine_info_category = category;
		// 	this.gulod_medicine_info_category_unit = unit_category;
		// 	this.gulod_medicine_info_quantity = quantity;
		// 	this.gulod_medicine_info_supplier = supplier;

		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "gulod/retrieve_available_medicine_details.php?medicine_id=",
		// 		params : {
		// 			medicine_id : this.gulod_medicine_info_id
		// 		}
		// 	}).then(function (response){
		// 		vm.gulod_medicine_information = response.data;
		// 		console.log(response);
		// 		vm.clearData();
		// 	});		
		// },
		gulodUpdateMedicineQuantity : function() {
			for(var index = 0; index < this.gulod_medicines.length; index++) {
				for(var index1 = 0; index1 < this.received_order_details.length; index1++) {
					if(this.received_order_details[index1].medicine_id === this.gulod_medicines[index].medicine_id) {
						if(this.received_order_details[index1].is_updated == "No") {
							axios({
								method : "POST",
								url : this.urlRoot + "gulod/update_medicine.php",
								data : {
									medicine_id : this.gulod_medicines[index].medicine_id,
									medicine_name : this.gulod_medicines[index].medicine_name,
									quantity : this.gulod_medicines[index].quantity - this.received_order_details[index1].quantity,
									price : this.gulod_medicines[index].price,
									category_id : this.gulod_medicines[index].category_id,
									unit_category_id : this.gulod_medicines[index].unit_category_id,
									status : this.gulod_medicines[index].status,
									barangay_id : this.gulod_medicines[index].barangay_id
								}
							}).then(function (response){
								vm.retrieveGulodMedicine();
								vm.retrieveExpiredMedicine();
								vm.clearData();
								swal("Congrats!", " Medicine Stock Update!", "success");
							});

							axios({
								method : "POST",
									url : this.urlRoot + "gulod/update_received_order_details.php",
									data : {
										received_order_details_id : this.received_order_details[index1].received_order_details_id,
										received_order_id : this.received_order_details[index1].received_order_id,
										medicine_id : this.received_order_details[index1].medicine_id,
										quantity : this.received_order_details[index1].quantity,
										price : this.received_order_details[index1].price,
										expiration_date : this.received_order_details[index1].expiration_date,
										is_updated : "Yes",
										total_amount : this.received_order_details[index1].total_amount
									}
							}).then(function (response){
								vm.retrieveReceivedOrderDetails();
								vm.retrieveExpiredMedicine();
								vm.clearData();
							});
						}
					}
				}
			}
		},
		// retrieveAllMedicineFromGulod : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "gulod/retrieve_all_medicine.php"
		// 	}).then(function (response){
		// 		vm.gulod_all_medicines = response.data;
		// 	});
		// },
		// countAllMedicineFromGulod : function() {
	 //   		var count = 0;
		// 	for(var index = 0; index < this.gulod_all_medicines.length; index++){
		// 		count++;
		// 	}
		// 	return count;
	 //   	},
	  //  	retrieveGulodReceivedOrder : function() {
	  //  		axios({
			// 	method : "GET",
			// 	url : this.urlRoot + "gulod/retrieve_received_order.php"
			// }).then(function (response){
			// 	vm.gulod_received_orders = response.data;
			// });
	  //  	},
	  //  	generateReceivedOrderID : function() {
	  //  		var id = "";
	  //  		if(this.gulod_received_orders.length < 0) {
	  //  			id = "0001";
	  //  		}
	  //  		else {
	  //  			for(var index = 0; index < this.gulod_received_orders.length; index++) {
	  //  				id = this.gulod_received_orders[index].received_order_id;
	  //  			}
	  //  			id = parseInt(id) + 1;
	  //  		}
	  //  		return id;
	  //  	},
	  //  	countReceivedOrder : function() {
	  //  		var count = 0;
			// for(var index = 0; index < this.received_orders.length; index++){
			// 	count++;
			// }
			// return count;
	  //  	},
	  //  	receivedOrderButton : function(id,name,price) {
	  //  		this.received_order_medicine_id = id;
	  //  		this.received_order_medicine_name = name;
	  //  		this.received_order_price = price;
	  //  	},
	  //  	addReceivedOrderTable : function() {
	  //  		this.add_received_order.medicine_id = this.received_order_medicine_id;
	  //  		this.add_received_order.medicine_name = this.received_order_medicine_name;
	  //  		this.add_received_order.quantity = this.received_order_quantity;
	  //  		this.add_received_order.price = this.received_order_price;
	  //  		this.add_received_order.expiration_date = this.received_order_expiration_date;
	  //  		this.add_received_order.total_amount = parseFloat(this.received_order_quantity) * parseFloat(this.received_order_price);


	  //  		this.received_orders.push({...this.add_received_order});
	  //  		$("#myModal6").modal("hide");
	  //  		$('#myModal').modal("hide");
	  //  		this.clearData();	
	  //  	},
	  //  	saveGulodReceivedOrder : function(){
	  //  		this.addReceivedOrder();
	  //  		this.addReceivedOrderDetails();
	  //  		this.updateReceivedMedicine();
	  //  	}, 
	  //  	addReceivedOrder : function() {
	  //  		var currentDate = new Date();
	  //  		var currentMonth = ('0' + (currentDate.getUTCMonth() + 1)).slice(-2);
	  //  		var currentDay = ('0' + (currentDate.getUTCDate())).slice(-2);

	  //  		axios({
	  //  			method : "POST",
	  //  			url : this.urlRoot + "gulod/add_received_order.php",
	  //  			data : {
	  //  				received_order_id : this.generateReceivedOrderID(),
	  //  				user_id : "",
	  //  				supplier_id : "1",
	  //  				date_received : currentDate.getUTCFullYear() + "-" + currentMonth + "-" + currentDay,
	  //  				barangay_id : "1"
	  //  			}
	  //  		}).then(function (response){
	  //  			console.log(response);
	  //  		});
	  //  	},
	  //  	addReceivedOrderDetails : function() {
	  //  		for(var index = 0; index < this.received_orders.length; index++) {
	  //  			axios({
			// 		method : "POST",
			// 		url : this.urlRoot + "gulod/add_received_order_details.php",
			// 		data : {
			// 			received_order_id : "",
			// 			medicine_id : this.received_orders[index].medicine_id,
			// 			quantity : this.received_orders[index].quantity,
			// 			price : this.received_orders[index].price,
			// 			expiration_date : this.received_orders[index].expiration_date,
			// 			is_updated : "No",
			// 			total_amount : this.received_orders[index].total_amount + ".00",
			// 		}
			// 	}).then(function (response){
			// 		vm.clearData();
			// 		swal("Congrats!", " Received order/s added successfully!", "success");
			// 		console.log(response);
			// 	});
	  //  		}
	   		
	  //  	},
	  //  	updateReceivedMedicine : function() {
	  //  		for(var index = 0; index < this.gulod_all_medicines.length; index++) {
	  //  			for(var index1 = 0; index1 < this.received_orders.length; index1++) {
	  //  				if(this.gulod_all_medicines[index].medicine_id == this.received_orders[index1].medicine_id) {
	  //  					var total_quantity = parseInt(this.received_orders[index1].quantity) + parseInt(this.gulod_all_medicines[index].quantity);
	  //  					axios({
			// 				method : "POST",
			// 				url : this.urlRoot + "gulod/update_medicine.php",
			// 				data : {
			// 					medicine_id : this.gulod_all_medicines[index].medicine_id,
			// 					medicine_name : this.gulod_all_medicines[index].medicine_name,
			// 					quantity : total_quantity,
			// 					price : this.received_orders[index1].price,
			// 					category_id : this.gulod_all_medicines[index].category_id,
			// 					unit_category_id : this.gulod_all_medicines[index].unit_category_id,
			// 					status : this.gulod_all_medicines[index].status,
			// 					barangay_id : this.gulod_all_medicines[index].barangay_id
			// 				}
			// 			}).then(function (response){
			// 				vm.retrieveGulodMedicine();
			// 				vm.retrieveGulodInactiveMedicine();
			// 				swal("Congrats!", " Update medicine successfully!", "success");	
			// 				vm.clearData();
	  //  						vm.received_orders = [];
			// 			});
	  //  				}
	  //  			}
	  //  		}
	  //  	},
	 //   	retrieveSingleResident : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "registration_staff/retrieve_all_single_married_resident.php"
		// 	}).then(function (response){
		// 		vm.single_resident = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// retrieveSeniorCitizenToConfirm : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "registration_staff/retrieve_senior_citizen_to_confirm.php"
		// 	}).then(function (response){
		// 		vm.senior_citizen_to_confirm = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// countSeniorCitizenToConfirm : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.senior_citizen_to_confirm.length; index++) {
		// 		count++;
		// 	}
		// 	return count;
		// },
		// retrieveSeniorCitizen : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "registration_staff/retrieve_all_senior_citizen.php"
		// 	}).then(function (response){
		// 		vm.senior_citizen = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// countSeniorCitizen : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.senior_citizen.length; index++) {
		// 		count++;
		// 	}
		// 	return count;
		// },
		// retrieveIndigent : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "registration_staff/retrieve_all_indigent.php"
		// 	}).then(function (response){
		// 		vm.indigent_people = response.data;
		// 		vm.clearData();
		// 	});
		// },
		// searchDependent : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "registration_staff/search_dependent.php?keyword=",
		// 		params : {
		// 			keyword : this.search_dependent
		// 		}
		// 	}).then(function (response){
		// 		vm.all_dependents = response.data;
		// 	});
		// },
		// searchForPossibleDependent : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "registration_staff/search_for_dependent.php?keyword=",
		// 		params : {
		// 			keyword : this.search_for_possible_dependent
		// 		}
		// 	}).then(function (response){
		// 		vm.single_resident = response.data;
		// 	});
		// },
		// makeBeneficiaryButton : function(id, first_name, index) {
		// 	this.select_dependent = this.select_dependent === null ? this.select_dependent = index : null;
		// 	for(var index = 0; index < this.senior_citizen_to_confirm.length; index++) {
		// 		if(this.beneficiary_id == this.senior_citizen_to_confirm[index].beneficiary_id) {
		// 			this.gulod_beneficiary_id = this.senior_citizen_to_confirm[index].beneficiary_id;
		// 			this.gulod_beneficiary_first_name = this.senior_citizen_to_confirm[index].first_name;
		// 			this.gulod_beneficiary_last_name = this.senior_citizen_to_confirm[index].last_name;
		// 			this.gulod_beneficiary_middle_name = this.senior_citizen_to_confirm[index].middle_name;
		// 			this.gulod_beneficiary_contact_no = this.senior_citizen_to_confirm[index].contact_no;
		// 			this.gulod_beneficiary_birth_date = this.senior_citizen_to_confirm[index].birth_date;
		// 			this.gulod_beneficiary_email_address = this.senior_citizen_to_confirm[index].email_address;
		// 			this.gulod_beneficiary_sex = this.senior_citizen_to_confirm[index].sex;
		// 			this.gulod_beneficiary_address = this.senior_citizen_to_confirm[index].address;
		// 			this.gulod_beneficiary_civil_status_id = this.senior_citizen_to_confirm[index].civil_status_id;
		// 			this.gulod_beneficiary_is_active = this.senior_citizen_to_confirm[index].is_active;
		// 			this.gulod_beneficiary_is_senior_citizen = "Yes";
		// 			this.gulod_beneficiary_balance = this.senior_citizen_to_confirm[index].balance;
		// 			this.gulod_beneficiary_barangay_id = this.senior_citizen_to_confirm[index].barangay_id;
		// 		}
		// 	}
		// },
		// updateBeneficiaryToSeniorCitizen : function() {
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "registration_staff/update_beneficiary.php",
		// 		data : {
		// 			beneficiary_id : this.gulod_beneficiary_id,
		// 			first_name : this.gulod_beneficiary_first_name,
		// 			last_name : this.gulod_beneficiary_last_name,
		// 			middle_name : this.gulod_beneficiary_middle_name,
		// 			contact_no : this.gulod_beneficiary_contact_no,
		// 			birth_date : this.gulod_beneficiary_birth_date,
		// 			email_address : this.gulod_beneficiary_email_address,
		// 			sex : this.gulod_beneficiary_sex,
		// 			address : this.gulod_beneficiary_address,
		// 			is_active : this.gulod_beneficiary_is_active,
		// 			is_senior_citizen : this.gulod_beneficiary_is_senior_citizen,
		// 			balance : this.gulod_beneficiary_balance,
		// 			barangay_id : this.gulod_beneficiary_barangay_id
		// 		}
		// 	}).then(function (response){
		// 		console.log(response);
		// 		vm.retrieveSeniorCitizen();
		// 		vm.retrieveSeniorCitizenToConfirm();
		// 	});
		// },
		// dependentToBeneficiary : function(id,first_name,middle_name,last_name,contact_no,birth_date,email_address,sex,address,status,civil_status_id,beneficiary_id) {
		// 	this.dependent_id = id;
		// 	this.dependent_first_name = first_name;
		// 	this.dependent_middle_name = middle_name;
		// 	this.dependent_last_name = last_name;
		// 	this.dependent_contact_no = contact_no;
		// 	this.dependent_birth_date = birth_date;
		// 	this.dependent_email_address = email_address;
		// 	this.dependent_sex = sex;
		// 	this.dependent_address = address;
		// 	this.dependent_status = status;
		// 	this.dependent_civil_status_id = civil_status_id;
		// 	this.dependent_beneficiary_id = beneficiary_id;
		// },
		// saveDependentToMakeBeneficiary : function() {
		// 	if(this.select_dependent === null) {
		// 		swal("There is no selected dependent", "you need to select dependent in the list!");
		// 	}
		// 	else {
		// 		// this.updateBeneficiaryToSeniorCitizen();
		// 		this.dependentToBeneficiary();
		// 		$('#myModal11').modal('hide');

				
		// 	}
		// },
		// retrieveSupplier : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_supplier.php"
		// 	}).then(function (response){
		// 		vm.suppliers = response.data;
		// 	});
		// },
		// addSupplier : function() {
		// 	if(this.supplier_name == "") {
		// 		this.supplier_name_error = true;
		// 	}
		// 	else {
		// 		this.supplier_name_error = false;
		// 	}

		// 	if(this.supplier_address == "") {
		// 		this.supplier_address_error = true;
		// 	}
		// 	else {
		// 		this.supplier_address_error = false;
		// 	}

		// 	if(this.supplier_contact_no == "") {
		// 		this.supplier_contact_no_error = true;
		// 	}
		// 	else {
		// 		this.supplier_contact_no_error = false;
		// 	}

		// 	if(this.supplier_status == "") {
		// 		this.supplier_status_error = true;
		// 	}
		// 	else {
		// 		this.supplier_status_error = false;
		// 	}

		// 	if(this.supplier_name != "" && this.supplier_address != "" && this.supplier_contact_no != "" && this.supplier_status != "") {
				
		// 		axios({
		// 			method : "POST",
		// 			url : this.urlRoot + "admin/add_supplier.php",
		// 			data : {
		// 				supplier_name : this.supplier_name,
		// 				supplier_address : this.supplier_address,
		// 				supplier_contact_no : this.supplier_contact_no,
		// 				supplier_status : this.supplier_status,

		// 			}
		// 		}).then(function (response){
		// 			console.log(response);
		// 			if(response.status == 200) {
		// 				vm.retrieveSupplier();
		// 				swal("Congrats!", " New supplier added!", "success");	
		// 				vm.clearData();

		// 				vm.supplier_name = false;
		// 				vm.supplier_address = false;
		// 				vm.supplier_contact_no = false;
		// 				vm.supplier_status = false;

		// 				$('#myModal').modal('hide');
		// 			}
		// 			else {
		// 				vm.supplier_name_error = response.data.supplier_name_error;
		// 				vm.supplier_address_error = response.data.supplier_address_error;
		// 				vm.supplier_contact_no_error = response.data.supplier_contact_no_error;
		// 				vm.supplier_status_error = response.data.supplier_status_error;
		// 			}
		// 		});
		// 	}
		// },
		// updateButton : function(id,name,address,contact_no,status) {
		// 	this.supplier_id = id;
		// 	this.supplier_name = name;
		// 	this.supplier_address = address;
		// 	this.supplier_contact_no = contact_no;
		// 	this.supplier_status = status;
		// },
		// updateSupplier : function() {
		// 	if(this.supplier_name == "") {
		// 		this.supplier_name_error = true;
		// 	}
		// 	else {
		// 		this.supplier_name_error = false;
		// 	}

		// 	if(this.supplier_address == "") {
		// 		this.supplier_address_error = true;
		// 	}
		// 	else {
		// 		this.supplier_address_error = false;
		// 	}

		// 	if(this.supplier_contact_no == "") {
		// 		this.supplier_contact_no_error = true;
		// 	}
		// 	else {
		// 		this.supplier_contact_no_error = false;
		// 	}

		// 	if(this.supplier_status == "") {
		// 		this.supplier_status_error = true;
		// 	}
		// 	else {
		// 		this.supplier_status_error = false;
		// 	}

		// 	if(this.supplier_id != "" && this.supplier_name != "" && this.supplier_address != "" && this.supplier_contact_no != "" && this.supplier_status != "") {
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "admin/update_supplier.php",
		// 		data : {
		// 			supplier_id : this.supplier_id,
		// 			supplier_name : this.supplier_name,
		// 			supplier_address : this.supplier_address,
		// 			supplier_contact_no : this.supplier_contact_no,
		// 			supplier_status : this.supplier_status
		// 		}
		// 		}).then(function (response){
		// 			console.log(response);
		// 			if(response.data.status == "OK") {
		// 				vm.retrieveSupplier();
		// 				swal("Congrats!", " Update supplier successfully!", "success");	
		// 				vm.clearData();

		// 				vm.supplier_name = false;
		// 				vm.supplier_address = false;
		// 				vm.supplier_contact_no = false;
		// 				vm.supplier_status = false;

		// 				$('#myModal1').modal('hide');
		// 			}
		// 			else {
		// 				vm.supplier_name_error = response.data.supplier_name_error;
		// 				vm.supplier_address_error = response.data.supplier_address_error;
		// 				vm.supplier_contact_no_error = response.data.supplier_contact_no_error;
		// 				vm.supplier_status_error = response.data.supplier_status_error;
		// 			}

		// 		});
		// 	}
		// },
		// searchSupplier : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/search_supplier.php?keyword=",
		// 		params : {
		// 			keyword : this.search_supplier
		// 		}
		// 	}).then(function (response){
		// 		vm.suppliers = response.data;
		// 	});
		// },
		// toggleSupplierInfo : function(id) {
		// 	if(this.supplier_medicine_info == false) {
		// 		this.supplier_medicine_info = true;
		// 	}
		// 	else {
		// 		this.supplier_medicine_info = false;
		// 	} 

		// 	this.supplier_id = id;

		// 	this.retrieveSupplierMedicine(this.supplier_id);
		// }, 
		// addSupplierMedicine : function() {
			//get id of description in tbl_category
			// for(var index = 0; index < this.categories.length; index++){
			// 	if(this.categories[index].description == this.supplier_medicine_category){
			// 		this.supplier_medicine_category_id = this.categories[index].category_id;
			// 	}
			// } 

			//get id of unit in tbl_unit_category
		// 	for(var index = 0; index < this.unit_categories.length; index++){
		// 		if(this.unit_categories[index].unit == this.supplier_medicine_unit){
		// 			this.supplier_medicine_unit_id = this.unit_categories[index].unit_category_id;
		// 		}
		// 	}
			
		// 	if(this.supplier_medicine_name == "") {
		// 		this.supplier_medicine_name_error = true;
		// 	}
		// 	else {
		// 		this.supplier_medicine_name_error = false;
		// 	}

		// 	if(this.supplier_medicine_category == "") {
		// 		this.supplier_medicine_category_id_error = true;
		// 	}
		// 	else {
		// 		this.supplier_medicine_category_id_error = false;
		// 	}

		// 	if(this.supplier_medicine_unit == "") {
		// 		this.supplier_medicine_unit_id_error = true;
		// 	}
		// 	else {
		// 		this.supplier_medicine_unit_id_error = false;
		// 	}

		// 	if(this.supplier_medicine_price == "") {
		// 		this.supplier_medicine_price_error = true;
		// 	}
		// 	else {
		// 		this.supplier_medicine_price_error = false;
		// 	}

		// 	if(this.supplier_id == "") {
		// 		this.supplier_id_error = true;
		// 	}
		// 	else {
		// 		this.supplier_id_error = false;
		// 	}

		// 	if(this.supplier_medicine_name != "" && this.supplier_medicine_category_id != "" && this.supplier_medicine_unit_id != "" && this.supplier_medicine_price != "" && this.supplier_id != "") {

		// 		axios({
		// 			method : "POST",
		// 			url : this.urlRoot + "admin/add_supplier_medicine.php",
		// 			data : {
		// 				medicine_name : this.supplier_medicine_name,
		// 				category_id : this.supplier_medicine_category_id,
		// 				unit_category_id : this.supplier_medicine_unit_id,
		// 				price : this.supplier_medicine_price,
		// 				supplier_id : this.supplier_id
		// 			}
		// 		}).then(function (response){
		// 			console.log(response);
		// 			if(response.status == 200) {
		// 				vm.retrieveSupplierMedicine(vm.supplier_id);
		// 				swal("Congrats!", " New medicine added!", "success");
		// 				console.log(response);
		// 				vm.clearData();

		// 				vm.supplier_medicine_name = false;
		// 				vm.supplier_medicine_category_id = false;
		// 				vm.supplier_medicine_unit_id = false;
		// 				vm.supplier_medicine_price = false;
		// 				vm.supplier_id = false;

		// 				$('#myModal2').modal('hide');
		// 			} 
		// 			else {
		// 				vm.supplier_medicine_name_error = response.data.supplier_medicine_name_error;
		// 				vm.supplier_medicine_category_id_error = response.data.supplier_medicine_category_id_error;
		// 				vm.supplier_medicine_unit_id_error = response.data.supplier_medicine_unit_id_error;
		// 				vm.supplier_medicine_price_error = response.data.supplier_medicine_price_error;
		// 				vm.supplier_id_error = response.data.supplier_id_error;
		// 			}
		// 		});
		// 	}
		// },
		// updateSupplierMedicineButton : function(supplier_medicine_id,medicine_name,description,unit,price,supplier_id) {
		// 	this.supplier_medicine_id = supplier_medicine_id;
		// 	this.supplier_medicine_name = medicine_name;
		// 	this.supplier_medicine_category = description;
		// 	this.supplier_medicine_unit = unit;
		// 	this.supplier_medicine_price = price;
		// 	this.supplier_id = supplier_id;

		// },
		// updateSupplierMedicine : function() {
		// 	//get id of description in tbl_category
		// 	for(var index = 0; index < this.categories.length; index++){
		// 		if(this.categories[index].description == this.supplier_medicine_category){
		// 			this.supplier_medicine_category_id = this.categories[index].category_id;
		// 		}
		// 	} 

			//get id of unit in tbl_unit_category
		// 	for(var index = 0; index < this.unit_categories.length; index++){
		// 		if(this.unit_categories[index].unit == this.supplier_medicine_unit){
		// 			this.supplier_medicine_unit_id = this.unit_categories[index].unit_category_id;
		// 		}
		// 	}

		// 	if(this.supplier_medicine_name == "") {
		// 		this.supplier_medicine_name_error = true;
		// 	}
		// 	else {
		// 		this.supplier_medicine_name_error = false;
		// 	}

		// 	if(this.supplier_medicine_category == "") {
		// 		this.supplier_medicine_category_id_error = true;
		// 	}
		// 	else {
		// 		this.supplier_medicine_category_id_error = false;
		// 	}

		// 	if(this.supplier_medicine_unit == "") {
		// 		this.supplier_medicine_unit_id_error = true;
		// 	}
		// 	else {
		// 		this.supplier_medicine_unit_id_error = false;
		// 	}

		// 	if(this.supplier_medicine_price == "") {
		// 		this.supplier_medicine_price_error = true;
		// 	}
		// 	else {
		// 		this.supplier_medicine_price_error = false;
		// 	}

		// 	if(this.supplier_id == "") {
		// 		this.supplier_id_error = true;
		// 	}
		// 	else {
		// 		this.supplier_id_error = false;
		// 	}

		// 	if(this.supplier_medicine_name != "" && this.supplier_medicine_category_id != "" && this.supplier_medicine_unit_id != "" && this.supplier_medicine_price != "" && this.supplier_id != "") {

		// 		axios({
		// 			method : "POST",
		// 			url : this.urlRoot + "admin/update_supplier_medicine.php",
		// 			data : {
		// 				supplier_medicine_id : this.supplier_medicine_id,
		// 				medicine_name : this.supplier_medicine_name,
		// 				category_id : this.supplier_medicine_category_id,
		// 				unit_category_id : this.supplier_medicine_unit_id,
		// 				price : this.supplier_medicine_price,
		// 				supplier_id : this.supplier_id
		// 			}
		// 		}).then(function (response){
		// 			console.log(response);
		// 			if(response.data.status == "OK") {
		// 				swal("Congrats!", " Medicine update successfully!", "success");
		// 				vm.retrieveSupplierMedicine(vm.supplier_id);
		// 				vm.clearData();

		// 				vm.supplier_medicine_name = false;
		// 				vm.supplier_medicine_category_id = false;
		// 				vm.supplier_medicine_unit_id = false;
		// 				vm.supplier_medicine_price = false;
		// 				vm.supplier_id = false;

		// 				$('#myModal3').modal('hide');
		// 			} 
		// 			else {
		// 				vm.supplier_medicine_name_error = response.data.supplier_medicine_name_error;
		// 				vm.supplier_medicine_category_id_error = response.data.supplier_medicine_category_id_error;
		// 				vm.supplier_medicine_unit_id_error = response.data.supplier_medicine_unit_id_error;
		// 				vm.supplier_medicine_price_error = response.data.supplier_medicine_price_error;
		// 				vm.supplier_id_error = response.data.supplier_id_error;
		// 			}
		// 		});
		// 	}
		// },
		// retrieveSupplierMedicine : function(supplier_id) {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_supplier_medicine.php?supplier_id=",
		// 		params : {
		// 			supplier_id : this.supplier_id,
		// 		}
		// 	}).then(function (response){
		// 		vm.supplier_medicines = response.data;
		// 	});
		// },
		// countSupplier : function() {
		// 	var count_supplier = 0;
		// 	for(var index = 0; index < this.suppliers.length; index++){
		// 		count_supplier++;
		// 	}
		// 	return count_supplier;
		// },
		// retrievePurchaseOrder : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_purchase_order.php"
		// 	}).then(function (response){
		// 		vm.purchase_order_using_id = response.data;
		// 	});
		// },
		// countPurchaseOrder : function() {
		// 	var count = 0;
		// 	for(var index = 0; index < this.purchase_order_to_carts.length; index++) {
		// 		count++;
		// 	}
		// 	return count;
		// },
		// generatePurchaseOrderID : function() {
		// 	var  id = "";
		// 	var pad = "0000";
		// 	var date = new Date();

		// 	if(this.purchase_order_using_id.length <= 0) {
		// 		id = "PO" +  date.getUTCFullYear() + "0001";
		// 	}
		// 	else {
		// 		for(var index = 0; index < this.purchase_order_using_id.length; index++) {
		// 			id = this.purchase_order_using_id[index].purchase_order_id;

		// 		}

		// 		id = id.slice(6);
		// 		id = pad.substring(0, pad.length - id.length) + id;
		// 		id = date.getUTCFullYear() + "" + id;
		// 		id = parseInt(id) + 1;
		// 		id = "PO" + id;
		// 	}
		// 	return id;
		// },
		// purchaseOrderId : function() {
		// 	var id = "";
		// 	var pad = "0000";
		// 	var date = new Date();

		// 	id = this.generatePurchaseOrderID().slice(6);
		// 	id = pad.substring(0, pad.length - id.length) + id;
		// 	id = date.getUTCFullYear() + "" + id;
		// 	id = parseInt(id) - 1;
		// 	id = "PO" + id;


		// 	return id;
		// },
		// searchPurchaseOrderMedicine : function () {
			
		// 	axios.get(this.urlRoot + "admin/search_purchase_order_medicine.php?purchase_order_id=" + this.purchase_order_id + "&keyword=" + this.)

		// 	axios.get(this.urlRoot + "admin/search_supplier_medicine.php?supplier_id=" + this.supplier_id + "&keyword=" + this.search_supplier_medicine)
		// 	.then(function (response) {
		// 		vm.supplier_medicines = response.data;
		// 	});
		// },
		// purchaseOrderButton : function(id){
		// 	this.purchase_order_medicine_id = id;
		// },
		// purchaseOrderAddToCart : function() {

		// 	var found1 = true;
		// 	var found2 = false;

		// 	for(var index = 0; index < this.supplier_medicines.length; index++) {
		// 		if(this.purchase_order_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
		// 			this.add_purchase_orders.medicine_id = this.supplier_medicines[index].supplier_medicine_id;
		// 			this.add_purchase_orders.medicine_name = this.supplier_medicines[index].medicine_name;
		// 			this.add_purchase_orders.category = this.supplier_medicines[index].description;
		// 			this.add_purchase_orders.unit_category = this.supplier_medicines[index].unit;
		// 			this.add_purchase_orders.price = this.supplier_medicines[index].price;
		// 			this.add_purchase_orders.quantity = this.purchase_order_medicine_quantity;
		// 			this.add_purchase_orders.supplier = this.supplier_medicines[index].supplier_name;
		// 		}
		// 	}

		// 	for(var index1 = 0; index1 < this.purchase_order_to_carts.length; index1++) {
		// 		if (this.add_purchase_orders.medicine_id == this.purchase_order_to_carts[index1].medicine_id) {
		// 			var quantity = parseInt(this.add_purchase_orders.quantity) + parseInt(this.purchase_order_to_carts[index1].quantity);

		// 			found1 = false;
		// 			found2 = true;

		// 			this.purchase_order_to_carts[index1].quantity = quantity;
		// 		}
		// 	}

		// 	if(found1) {
		// 		this.purchase_order_to_carts.push({...this.add_purchase_orders});
		// 		$("#myModal6").modal("show");
		// 		$("#myModal3").modal("hide");
		// 		this.clearData();
		// 	}

		// 	if(found2) {
		// 		$("#myModal6").modal("show");
		// 		$("#myModal3").modal("hide");
		// 		this.clearData();
		// 	}
		// },
		// addPurchaseOrder : function() {
		// 	var date = new Date();
		// 	var year = date.getFullYear();
		// 	var month = date.getMonth() + 1;
		// 	var day = date.getDate();

		// 	if(this.purchase_order_to_carts.length == 0) {
		// 		swal("Error!", " No item/s to purchase", "error");
		// 	}
		// 	else {
		// 		axios({
		// 			method : "POST",
		// 			url : this.urlRoot + "admin/add_purchase_order.php",
		// 			data : {
		// 				purchase_order_id : this.generatePurchaseOrderID(),
		// 				date_ordered : year + "-" + month + "-" + day
		// 			}
		// 		}).then(function (response){
		// 			console.log(response);
		// 			vm.addPurchaseOrderDetails();
		// 		});
		// 	}
		// },
		// retrievePurchaseOrderDetails : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_purchase_order_details.php"
		// 	}).then(function (response){
		// 		console.log(response);
		// 		vm.purchase_order_details = response.data;
		// 	});
		// },
		// addPurchaseOrderDetails : function() {
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "admin/add_purchase_order_details.php",
		// 		data : {
		// 			purchase_order_to_carts : this.purchase_order_to_carts
		// 		}
		// 	}).then(function (response){
		// 		console.log(response);
		// 		vm.showPurchaseReceipt = true;
		// 		vm.showPurchaseOrder = false;

		// 		swal("Success!", " Purchase order successfully!", "success");
		// 		vm.addPurchaseDetails();
		// 	});
		// },
		// searchPurchasedOrdered : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/search_purchased_ordered.php?purchase_order_id=",
		// 		params : {
		// 			purchase_order_id : this.search_purchase_ordered
		// 		}
		// 	}).then(function (response){
		// 		vm.purchase_order_using_id = response.data;
		// 		console.log(response);
		// 	});
		// },
		// retrieveSupplierMedicineInPurchase : function() {

		// 	for(var index = 0; index < this.suppliers.length; index++) {
		// 		if(this.suppliers[index].supplier_name === this.supplier_name) {
		// 			this.supplier_id = this.suppliers[index].supplier_id;
		// 			break;
		// 		}
		// 	}
		// 	this.retrieveSupplierMedicine(this.supplier_id);

		// },
		// showSupplierMedicine : function() {
		// 	if(this.supplier_name == "") {
		// 		swal('Warning', ' Select supplier first!', 'info');
		// 		$('#myModal6').modal('hide');
		// 	}
		// 	else {
		// 		$('#myModal6').modal('show');
		// 	}
		// },
		// searchSupplierMedicine : function() {
		// 	for(var index = 0; index < this.suppliers.length; index++) {
		// 		if(this.supplier_name == this.suppliers[index].supplier_name) {
		// 			this.supplier_id = this.suppliers[index].supplier_id;
		// 		}
		// 	}


		// 	axios.get(this.urlRoot + "admin/search_supplier_medicine.php?supplier_id=" + this.supplier_id + "&keyword=" + this.search_supplier_medicine)
		// 	.then(function (response) {
		// 		vm.supplier_medicines = response.data;
		// 	});
		// },
		// countSupplierMedicine : function() {
		// 	var count = 0;

		// 	for(var index = 0; index < this.supplier_medicines.length; index++) {
		// 		count++;
		// 	}

		// 	return count;
		// },
		// removePurchaseOrder : function(index) {
  //   		this.purchase_order_to_carts.splice(index, 1);
  //   	},
  //   	closePurchasReceivedModal : function() {
  //   		this.purchase_received_quantity = "";
  //   		this.purchase_received_expiration_date = "";
  //   		this.received_quantity_error = false;
		// 	this.expiration_date_error = false;
  //   		$("#myModal3").modal("hide");
  //   	},
  //   	addPurchaseReceivedButton : function(id, order_quantity, supplier_medicine_id, received_quantity) {
  //   		this.purchase_received_purchase_order_id = id;
  //   		this.purchase_received_order_quantity = order_quantity;
  //   		this.purchase_order_received_medicine_id = supplier_medicine_id;

  //   		if(order_quantity == received_quantity) {
  //   			swal("Error!", " Purchase received completed!", "error");
  //   		}
  //   		else {
  //   			$('#myModal3').modal('show');
  //   		}
  //   	},
   //  	toggleReceivedOrderInfo : function(id) {
			// if(this.purchase_received_info == false) {
			// 	this.purchase_received_info = true;
			// }
			// else {
			// 	this.purchase_received_info = false;
			// } 

			// this.purchase_order_id = id;

			// this.retrievePurchaseOrder();

			// this.retrievePurchaseDetails();
			// this.retrievePurchaseMedicine();
		// }, 
		// toggleReceivedOrderMedicineInfo : function(id, medicine_id, medicine_name, price, category, unit, quantity, supplier_name) {

		// 	if(this.purchase_received_info == false) {
		// 		this.purchase_received_info = true;
		// 	}
		// 	else {
		// 		this.purchase_received_info = false;
		// 	}

		// 	if(this.purchase_received_medicine_info == false) {
		// 		this.purchase_received_medicine_info = true;
		// 	}
		// 	else {
		// 		this.purchase_received_medicine_info = false;
		// 	}

		// 	this.purchase_order_id = id;

		// 	this.purchase_order_received_medicine_id = medicine_id;
		// 	this.purchase_order_received_medicine_name = medicine_name;
		// 	this.purchase_order_received_price = price;
		// 	this.purchase_order_received_category = category;
		// 	this.purchase_order_received_unit = unit;
		// 	this.purchase_order_received_quantity = quantity;
		// 	this.purchase_order_received_supplier = supplier_name;

		// 	this.retrievePurchaseDetails();

		// 	this.retrievePurchaseReceivedDetails();
		// },
		// retrievePurchaseReceived : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "admin/retrieve_purchase_received.php"
		// 	}).then(function (response) {
		// 		vm.purchase_received = response.data;
		// 	});
		// },
		// retrievePurchaseReceivedDetails : function() {

		// 	axios.get(this.urlRoot + "admin/retrieve_purchase_received_details.php?purchase_order_id=" + this.purchase_order_id + "&supplier_medicine_id=" + this.purchase_order_received_medicine_id)
		// 	.then(function (response) {
		// 		vm.purchase_received_details = response.data;
		// 		console.log(response);
		// 	});
		// },
		// generatePurchaseReceivedID : function() {
		// 	var id = "";
		// 	var pad = "0000";

		// 	var date = new Date();

		// 	if(this.purchase_received.length == 0) {
		// 		id = "PR" + date.getUTCFullYear() + "0001";
		// 	}
		// 	else {
		// 		for(var index = 0; index < this.purchase_received.length; index++) {
		// 			id = this.purchase_received[index].purchase_received_id;
		// 		}
		// 		id = id.slice(6);
		// 		id = pad.substring(0, pad.length - id.length) + id;
		// 		id = date.getUTCFullYear() + id;
		// 		id = parseInt(id) + 1;
		// 		id = "PR" + id;
		// 	}
		// 	return id;
		// },
		// addPurchaseReceived : function() {
		// 	var date = new Date();
		// 	var year = date.getFullYear();
		// 	var month = date.getMonth() + 1;
		// 	var day = date.getDate();

		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "admin/add_purchase_received.php",
		// 		data : {
		// 			purchase_received_id : this.generatePurchaseReceivedID(),
		// 			user_id : "",
		// 			date_received : year + "-" + month + "-" + day,
		// 			purchase_order_id : this.purchase_order_id
		// 		}
		// 	}).then (function (response) {
		// 		console.log(response);		
		// 	});
		// 	this.addPurchaseReceivedDetails();
		// },
		// addPurchaseReceivedDetails : function() {
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "admin/add_purchase_received_details.php",
		// 		data : {
		// 			supplier_medicine_id : this.purchase_order_received_medicine_id,
		// 			received_quantity : this.purchase_received_quantity,
		// 			expiration_date : this.purchase_received_expiration_date
		// 		}
		// 	}).then(function (response){
		// 		console.log(response);
		// 		vm.retrievePurchaseDetails();
				
		// 	});
		// 	this.updatePurchaseReceivedMedicine();

		// 	this.updatePurchaseDetails();
		// },
		// checkNewMedicine : function() {
		// 	for(var index = 0; index < this.medicines.length; index++) {
		// 		if(this.purchase_order_received_medicine_id == this.medicines[index].supplier_medicine_id) {
		// 			return false;
		// 		}
		// 	}
		// },
		// updatePurchaseReceivedMedicine : function() {
		// 	if(this.checkNewMedicine() == false) {
		// 		for(var index = 0; index < this.medicines.length; index++) {
		// 			if(this.purchase_order_received_medicine_id == this.medicines[index].supplier_medicine_id) {
		// 				this.medicines[index].quantity = parseInt(this.purchase_received_quantity) + parseInt(this.medicines[index].quantity);
		// 				axios({
		// 					method : "POST",
		// 					url : this.urlRoot + "admin/update_medicine.php",
		// 					data : {
		// 						medicine_id : this.medicines[index].medicine_id,
		// 						supplier_medicine_id : this.medicines[index].supplier_medicine_id,
		// 						quantity : this.medicines[index].quantity,
		// 						status : this.medicines[index].status,
		// 						barangay_id : this.medicines[index].barangay_id
		// 					}
		// 				}).then(function (response) {
		// 					console.log(response);
		// 					swal("Success!", " Purchase received successfully!", "success");
		// 				});
		// 			}
		// 		}
		// 	}
		// 	else {
		// 		axios({
		// 			method : "POST",
		// 			url : this.urlRoot + "admin/add_medicine.php",
		// 			data : {
		// 				supplier_medicine_id : this.purchase_order_received_medicine_id,
		// 				quantity : this.purchase_received_quantity,
		// 				status : "Active",
		// 				barangay_id : "19"
		// 			}
		// 		}).then(function (response) {
		// 			console.log(response);
		// 			swal("Success!", " New Medicine added!", "success");
		// 		});
		// 	}
		// },
		// savePurchaseReceived : function() {
		// 	if(this.purchase_received_quantity == '') {
		// 		this.received_quantity_error = true;
		// 	}
		// 	else {
		// 		this.received_quantity_error = false;
		// 	}

		// 	if(this.purchase_received_expiration_date == '') {
		// 		this.expiration_date_error = true;
		// 	}
		// 	else {
		// 		this.expiration_date_error = false;
		// 	}


		// 	if(this.purchase_received_quantity != "" && this.purchase_received_expiration_date != "") {
		// 		for(var index = 0; index < this.purchase_details.length; index++) {
		// 			if(this.purchase_order_id == this.purchase_details[index].purchase_order_id) {
		// 				if(this.purchase_order_received_medicine_id == this.purchase_details[index].supplier_medicine_id) {
		// 					var quantity = parseInt(this.purchase_received_quantity) + parseInt(this.purchase_details[index].received_quantity);
		// 					if(this.purchase_received_order_quantity < quantity) {
		// 						swal("Error!", "Received quantity cannot be more than order quantity!", "error");
		// 					}
		// 					else {
		// 						this.addPurchaseReceived();
		// 						$("#myModal3").modal("hide");
		// 					    this.purchase_received_quantity = "";
		// 						this.purchase_received_expiration_date = "";
		// 					}
		// 				}
		// 			}
		// 		}
		// 	}
		// },
		// showCityHallMedicine : function() {
		// 	$('#myModal6').modal('show');
		// },
		// disabledRequestOrderButton : function(supplier_medicine_id) {
		// 	for(var index = 0; index < this.request_orders.length; index++) {
		// 		if(this.request_orders[index].medicine_id == supplier_medicine_id) {
		// 			return this.request_orders[index].medicine_id;
		// 		}
		// 	}
		// },
		// addRequestOrderButton : function(supplier_medicine_id) {
		// 	var found = true;			

		// 	for(var index = 0; index < this.request_orders.length; index++) {
		// 		if(this.request_orders[index].medicine_id == supplier_medicine_id) {
		// 			found = false;
		// 			swal("Error!", " You already request this medicine!", "error");
		// 		}
		// 	}

		// 	if(found) {
		// 		for(var index = 0; index < this.medicines.length; index++) {
		// 			if(supplier_medicine_id == this.medicines[index].supplier_medicine_id) {
		// 				this.add_request_order.medicine_id = this.medicines[index].supplier_medicine_id;
		// 				this.add_request_order.medicine_name = this.medicines[index].medicine_name;
		// 				this.add_request_order.category = this.medicines[index].description;
		// 				this.add_request_order.unit_category = this.medicines[index].unit;
		// 				this.add_request_order.price = this.medicines[index].price;

		// 				this.request_orders.push({...this.add_request_order});
		// 			}
		// 		}
		// 	}
			
		// },
		// removeRequestOrder : function(index) {
		// 	this.request_orders.splice(index, 1);
		// },
		// retrieveRequestOrder : function() {
		// 	axios({
		// 		method : "GET",
		// 		url : this.urlRoot + "gulod/retrieve_request_order.php"
		// 	}).then(function (response) {
		// 		vm.retrieve_request_orders = response.data;
		// 	});
		// },
		// generateRequestOrderID : function() {
		// 	var  id = "";
		// 	var pad = "0000";
		// 	var date = new Date();

		// 	if(this.retrieve_request_orders.length <= 0) {
		// 		id = "RO" + "" + date.getUTCFullYear() + "0001";
		// 	}
		// 	else {
		// 		for(var index = 0; index < this.retrieve_request_orders.length; index++) {
		// 			id = this.retrieve_request_orders[index].request_order_id;
		// 		}

		// 		id = id.slice(6);
		// 		// id = parseInt(id) + 1;
		// 		id = pad.substring(0, pad.length - id.length) + id;
		// 		id = date.getUTCFullYear() + "" + id;
		// 		id = parseInt(id) + 1;
		// 		id = "RO" + "" + id;
		// 	}
		// 	return id;
		// },
		// addRequestOrder : function() {
		// 	var date = new Date();
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "gulod/add_request_order.php",
		// 		data : {
		// 			request_order_id  : this.generateRequestOrderID(),
		// 			user_id : "",
		// 			date_request : date.getUTCFullYear() + "-" + date.getUTCMonth() + "-" + date.getUTCDate()
		// 		}
		// 	}).then(function (response) {
		// 		console.log(response);
		// 		vm.addRequestOrderDetails();
		// 	});
		// },
		// addRequestOrderDetails : function() {
		// 	axios({
		// 		method : "POST",
		// 		url : this.urlRoot + "gulod/add_request_order_details.php",
		// 		data : {
		// 			request_orders : this.request_orders
		// 		}
		// 	}).then(function (response){
		// 		console.log(response);
		// 	});
		// },
		// saveRequestOrder : function() {
		// 	if(this.request_orders.length == 0) {
		// 		swal("Error!", " There is no medicine to request!", "error")
		// 	}
		// 	else {
		// 		this.addRequestOrder();
		// 		this.show_request_order = false;
		// 		this.show_request_order_receipt = true;

		// 	}
		// },
	// 	retrievePurchaseDetails : function() {
	// 		axios({
	// 			method : "GET",
	// 			url : this.urlRoot + "admin/retrieve_purchase_details.php?purchase_order_id=",
	// 			params : {
	// 				purchase_order_id : this.purchase_order_id
	// 			}
	// 		}).then(function (response) {
	// 			vm.purchase_details = response.data;
	// 			console.log(response);
	// 		});
	// 	},
	// 	addPurchaseDetails : function() {
	// 		axios({
	// 			method : "POST",
	// 			url : this.urlRoot + "admin/add_purchase_details.php",
	// 			data : {
	// 				purchase_order_to_carts : this.purchase_order_to_carts
	// 			}
	// 		}).then(function (response) {
	// 			console.log(response);
	// 		});
	// 	},
	// 	updatePurchaseDetails : function() {
	// 		for(var index  = 0; index < this.purchase_details.length; index++) {
	// 			if(this.purchase_received_purchase_order_id == this.purchase_details[index].purchase_order_id) {
	// 				if(this.purchase_order_received_medicine_id == this.purchase_details[index].supplier_medicine_id) {
	// 					this.purchase_received_quantity = parseInt(this.purchase_received_quantity) + parseInt(this.purchase_details[index].received_quantity);
	// 					axios({
	// 						method : "POST",
	// 						url : this.urlRoot + "admin/update_purchase_details.php",
	// 						data : {
	// 							purchase_details_id : this.purchase_details[index].purchase_details_id,
	// 							purchase_order_id : this.purchase_details[index].purchase_order_id,
	// 							supplier_medicine_id : this.purchase_details[index].supplier_medicine_id,
	// 							quantity : this.purchase_details[index].quantity,
	// 							received_quantity : this.purchase_received_quantity
	// 						}
	// 					}).then(function (response) {
	// 						console.log(response);
	// 					});
	// 				}
	// 			}
	// 		}
	// 	},
	},
	computed: {
		totalExpense : function() {
			return parseFloat(this.gulod_beneficiary_balance) + parseFloat(this.totalAmountInCart);
		},
		totalAmountInCart : function() {
			var total = 0;
			for(var index = 0; index < this.gulod_transactions.length; index++) {
				total += parseFloat(this.gulod_transactions[index].total);
			}
			return total;
		},
		totalPages: function() {
          	return Math.ceil(this.gulod_medicines.length / this.show_entries)
        },
        totalPageActive: function() {
        	return Math.ceil(this.gulod_active_beneficiaries.length / this.show_entries)
        },
        totalPageExpired: function() {
        	return Math.ceil(this.gulod_expired_medicines.length / this.show_entries)
        },
        totalUnavailable: function() {
	    	return Math.ceil(this.gulod_inactive_medicines.length / this.show_entries)
	   	}, 
	   	totalBeneficiaryDetails: function() {
	    	return Math.ceil(this.gulod_transaction_details.length / this.show_entries)
	   	}, 
	   	totalActiveUser: function() {
	    	return Math.ceil(this.active_users.length / this.show_entries)
	   	},
	   	totalNotActiveUser: function() {
	    	return Math.ceil(this.not_active_users.length / this.show_entries)
	   	}, 
	   	totalCategory: function() {
	    	return Math.ceil(this.categories.length / this.show_entries)
	   	}, 
	   	totalUnitCategory: function() {
	    	return Math.ceil(this.unit_categories.length / this.show_entries)
	   	}, 
	   	totaMedicine: function() {
	    	return Math.ceil(this.medicines.length / this.show_entries)
	   	}, 
	   	totalActiveBeneficiary: function() {
	    	return Math.ceil(this.active_beneficiaries.length / this.show_entries)
	   	},
	   	totalSupplier: function() {
	   		return Math.ceil(this.suppliers.length / this.show_entries)
	   	}, 
	   	totalNotActiveBeneficiary: function() {
	    	return Math.ceil(this.not_active_beneficiaries.length / this.show_entries)
	   	},
	   	totalTodayTransact: function() {
	    	return Math.ceil(this.dateToday.length / this.show_entries)
	   	},
	   	totalBarangayInventory: function() {
	   		return Math.ceil(this.barangay_inventories.length / this.show_entries)
	   	},
	   	totalPurchaseOrder: function() {
	   		return Math.ceil(this.purchase_orders.length / this.show_entries)
	   	},
		totalItem: function() {
	    	let totalAmount = 0;
	    	for(let i = 0; i < this.gulod_receipts.length; i++){
	    		totalAmount += (parseFloat(this.gulod_receipts[i].total));
	      	}
	     	return totalAmount;
	   	}, 
	   	remainingBalance: function() {
	   		let total = 10000;
	   		let balance = 0;
	   		let remainingBalance = this.gulod_beneficiary_balance;
	   		for (var i = 0; i < this.gulod_transactions.length; i++) {
				balance += (parseFloat(this.gulod_transactions[i].total));
			}
			return total -= (parseFloat(remainingBalance) + parseFloat(balance));
	   	},
	   	totalTransaction : function() {
	   		let totalAmount = 0;
	    	for(let i = 0; i < this.gulod_transaction_details.length; i++){
	    		totalAmount += (parseFloat(this.gulod_transaction_details[i].total_price));
	      	}
	     	return totalAmount;
	   },
	   totalRemainingBalance : function() {
	   		let balance = 0;
	   		let remainingBalance = 10000;
	   		for (var i = 0; i < this.gulod_transaction_details.length; i++) {
				balance += (parseFloat(this.gulod_transaction_details[i].total_price));
			}
			return remainingBalance - balance;
	   },
	    //start of searching for total transaction of beneficiary
	   totalSearchTransaction : function() {
	   		let totalAmount = 0;
	    	for(let i = 0; i < this.search_transaction_details.length; i++){
	    		totalAmount += (parseFloat(this.search_transaction_details[i].total_price));
	      	}
	     	return totalAmount;
	   },
	   totalSearchRemainingBalance : function() {
	   		let balance = 0;
	   		let remainingBalance = 10000;
	   		for (var i = 0; i < this.search_transaction_details.length; i++) {
				balance += (parseFloat(this.search_transaction_details[i].total_price));
			}
			return remainingBalance - balance;
	   },
	    //end of searching for total transaction of beneficiary

	    //start of report total amount 
	    totalMedicineReports: function() {
	    	let totalAmount = 0;
	    	for(let i = 0; i < this.dateToday.length; i++){
	    		totalAmount += (parseFloat(this.dateToday[i].total_price));
	      	}
	     	return totalAmount;
	   	},
	   	//end of reports total amount 
	   	totalGulodInventory: function() {
	     	let total = 0;

			for(let index = 0; index < this.gulod_medicines.length; index++) {
				total += parseInt(this.gulod_medicines[index].price) * parseInt(this.gulod_medicines[index].quantity);
			}
			return parseInt(total)  + ".00";
	   	},
	   	totalReceivedMedicine: function() {
	     	let total = 0;

			for(let index = 0; index < this.received_orders.length; index++) {
				total += parseFloat(this.received_orders[index].price) * parseFloat(this.received_orders[index].quantity);
			}
			return total;
	   	},
	   	totalPurchaseOrder : function() {
	   		let total = 0;

	   		for(let index = 0; index < this.purchase_order_to_carts.length; index++) {
	   			total += parseFloat(this.purchase_order_to_carts[index].total_amount);
	   		}

	   		return total;
	   	}
	   	
	},
	filters: {
      currency(value) {
        return value.toFixed(2);
      }
    },
	created() {
		// this.retrieveBarangay(); // barangay method
		// this.retrieveActiveUser(); // user method
		// this.retrieveNotActiveUser(); // user method
		// this.retrieveCategory(); // category method
		// this.retrieveUnitCategory(); // unit_category method
		// this.retrieveMedicine(); // medicine method
		// this.retrieveDependent(); // dependent method
		// this.retrieveActiveBeneficiary(); // beneficiary method
		// this.retrieveNotActiveBeneficiary(); // beneficiary method
		// this.retrieveExpiredMedicine();
		// this.retrieveGulodMedicine(); // gulod method
		// this.retrieveGulodInactiveMedicine(); // gulod method
		// this.retrieveGulodBeneficiary(); // gulod method
		// this.retrieveTransaction(); // gulod method
		// this.retrieveOutOfStockGulod(); //gulod out of stock medicine
		// this.retrieveLowStockGulod(); //gulod low stock medicine
		// this.retrieveSearchTransactionDetail();
		// this.retrieveReturnMedicine()
		// this.retrieveReceivedOrderDetails();
		// this.gulodUpdateMedicineQuantity();
		// this.retrieveAllMedicineFromGulod(); // retrieve all medicine in gulod
		// this.retrieveGulodReceivedOrder();
		// this.retrieveSingleResident(); //retreive all single resident of Cabuyao
		// this.retrieveSeniorCitizen(); //retreive all senior citizen of Cabuyao
		// this.retrieveIndigent(); //retreive all indigent of Cabuyao
		// this.retrieveSeniorCitizenToConfirm(); // retrieve senior citizen need to cinfirm
		// this.retrieveSupplier();
		
		// this.retrievePurchaseReceived();
		// this.retrievePurchaseOrderDetails();
		// this.retrieveRequestOrder();

		// setInterval(() => {
		// 	this.retrievePurchaseOrder();
		// }, 300);
	}
});
}