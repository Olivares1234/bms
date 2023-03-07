var vm = new Vue({
	el : "#vue-gulod",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/gulod_api/",

		// edit button //
		editDisabled : false,
		editedUser : null,
		/////////////////

		// receipt//
		gulod_receipts : [],
		showReceipt : false,
		gulod_receipt_first_name : "",
		gulod_receipt_last_name : "",
		gulod_receipt_contact_no : "",
		gulod_receipt_address : "",
		///////////////

		// title //
		view_Medicine : "View Medicine",
		view_Beneficiary : "View Beneficiary",
		beneficiary_Transaction : "Go To Transaction",
		add_to_cart : "Add Medicine To Cart",
		update_Quantity : "Update Quantity",
		save_Quantity : "Save Quantity",
		delete_Row : "Delete Row",
		add_Medicine : "Add Medicine",
		view_Order : "View Order",


		add_return : "Add Return Medicine",
		view_return : "View Return Details",

		create_Return : "Create Return Medicine",


		// city hall medicine //
		medicines  : [],
		search_medicine : "",

		/// request order ////
		show_request_order : true,
		show_request_order_receipt : false,

		request_orders : [],
		add_request_order : {
			medicine_id : null,
			medicine_name : null,
			category : null,
			unit_category : null,
			price : null
		},
		retrieve_request_orders : [],

		// beneficiary //
		gulod_active_beneficiaries : [],
		search_gulod_beneficiary : "",

		gulod_transaction_button : false,
		gulod_beneficiary_info : false,
		showBeneficiaryTransaction : false,

		gulod_beneficiary_id : "",
		gulod_beneficiary_first_name : "",
		gulod_beneficiary_last_name : "",
		gulod_beneficiary_middle_name : "",
		gulod_beneficiary_contact_no : "",
		gulod_beneficiary_birth_date : "",
		gulod_beneficiary_email_address : "",
		gulod_beneficiary_sex : "",
		gulod_beneficiary_address : "",
		gulod_beneficiary_is_active : "",
		gulod_beneficiary_balance : "",
		gulod_beneficiary_barangay_id : "",

		gulod_beneficiary_first_name_in_cart : "",
		gulod_transaction_beneficiary_id : "",

		// beneficiary transaction //
		search_transaction_medicine : "",
		gulod_transactions : [],
		gulod_save_transactions : [],

		input_quantity : 1,
		gulod_transaction_quantity : 1,

		gulod_transaction_purchase: {
			id : null,
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


		// available medicine data //
		gulod_medicines : [],
		gulod_available_medicine : true,
		search_gulod_medicine : "",
		gulod_medicine_info_name : "",
		gulod_medicine_info_price : "",
		gulod_medicine_info_category : "",
		gulod_medicine_info_category_unit : "",
		gulod_medicine_info_quantity : "",
		gulod_medicine_info_supplier : "",
		////////////////////////////////

		// inactive medicine data //
		gulod_inactive_medicines : [],
		gulod_inactive_medicine : true,

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////


		// received order details//
		received_order_details : [],
		received_order_details_supplier_medicine_id : "",

		transaction_details_info : true,
		return_details : false,
		search_transaction : "",
		gulod_transaction : [],
		gulod_transaction_details : [],
		gulod_medicine_quantity : 1,
		return_medicine_remarks : "",
		search_transaction_details : "",

		gulod_beneficiary_info : false,

		send_order_using_id : [],
		send_request_details : [],
		search_send_order : "",
		search_send_order_details : "",

		send_order_info : true,
		send_order_details_info : false,
		accept_order_details : false,

		reports : [],
		start_date : "",
		end_date : "",

		received_orders : [],
		received_order_supplier_medicine_id : "",
		received_order_expiration_date : "",
		received_order_quantity : "",
		received_order_received_quantity : "",

		received_orders_quantity : "",

		send_details : [],
		send_details_id : "",

		supplier_medicines : [],

		return_medicines : [],
		return_medicine_beneficiary_id : "",
		return_medicine_supplier_medicine_id : "",
		return_medicine_quantity : "",
		return_medicine_received_quantity : "",

		return_medicine_details : [],


	},
	methods : {
		previous: function() {
	      if (this.currentPage > 1) {
	        this.pagination(this.currentPage - 1);
	      }

	    },
		nextSendOrder : function() {
			if (this.currentPage < this.totalSendOrder) {
	        this.pagination(this.currentPage + 1);
	      }
		},
		nextSendOrderDetails : function() {
	      if (this.currentPage < this.totalSendOrderDetails) {
	        this.pagination(this.currentPage + 1);
	      }
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
		editData : function (transaction) {
		    this.editDisabled = true;
		    this.beforEditCache = transaction;
		    this.editedUser = transaction;
   		},
   		saveData : function (transaction_id) {

    		for(var index1 = 0; index1 < this.gulod_medicines.length; index1++) {
    			for(var index = 0; index < this.gulod_transactions.length; index++) {
    				if(transaction_id == this.gulod_transactions[index].id) {
    					if(this.gulod_transactions[index].id == this.gulod_medicines[index1].supplier_medicine_id) {
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
		},
		pagination_two : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries_two) - this.show_entries_two;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries_two);
		},
		retrieveGulodMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_active_medicine.php")
			.then(function (response) {
				vm.gulod_medicines = response.data;
			});
		},
		countGulodMedicine : function() {
			var count = 0;

			for(var index  = 0; index < this.gulod_medicines.length; index++) {
				count++;
			}

			return count;
		},
		searchGulodMedicine : function() {
			axios.get(this.urlRoot + this.api + "search_medicine.php?keyword=" + this.search_gulod_medicine)
			.then(function (response) {
				vm.gulod_medicines = response.data;
			});
		},
		toggleAvailableMedicineInfo : function(medicine_id) {
			if(this.gulod_available_medicine == true) {
				this.gulod_available_medicine = false;
			}
			else {
				this.gulod_available_medicine = true;
			}

			this.received_order_details_supplier_medicine_id = medicine_id;
		},
		toggleInactiveMedicineInfo : function(medicine_id) {
			if(this.gulod_inactive_medicine == true) {
				this.gulod_inactive_medicine = false;
			}
			else {
				this.gulod_inactive_medicine = true;
			}

			this.received_order_details_supplier_medicine_id = medicine_id;
		},
		retrieveGulodInactiveMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_inactive_medicine.php")
			.then(function (response) {
				vm.gulod_inactive_medicines = response.data;
			});
		},
		countGulodInactiveMedicine : function() {
			var count = 0;

			for(var index = 0; index < this.gulod_inactive_medicines.length; index++) {
				count++;
			}
			return count;
		},
		retrieveGulodActiveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_active_beneficiary.php")
			.then(function (response) {
				vm.gulod_active_beneficiaries = response.data;
				console.log(response);
			});
		},
		countGulodActiveBeneficiary : function() {
			var count = 0;

			for(var index = 0; index < this.gulod_active_beneficiaries.length; index++) {
				count++;
			}
			return count;
		},
		searchGulodBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "search_beneficiary.php?keyword=" + this.search_gulod_beneficiary)
			.then(function (response) {
				vm.gulod_active_beneficiaries = response.data;
			});
		},
		toggleBeneficiaryInfo : function(id,first_name,last_name,address,contact_no,email,birth_date) {
			if(this.gulod_beneficiary_info == false) {
				this.gulod_beneficiary_info = true;
			}
			else {
				this.gulod_beneficiary_info = false;
			}

			this.gulod_beneficiary_info_beneficiary_id = id;
			this.gulod_beneficiary_info_first_name = first_name;
			this.gulod_beneficiary_info_last_name = last_name;
			this.gulod_beneficiary_info_address = address;
			this.gulod_beneficiary_info_contact_no = contact_no;
			this.gulod_beneficiary_info_email = email;
			this.gulod_beneficiary_info_birth_date = birth_date;

			axios.get(this.urlRoot + this.api + "retrieve_beneficiary_transaction_details.php?beneficiary_id=" + this.gulod_beneficiary_info_beneficiary_id)
			.then(function (response) {
				console.log(response)
				vm.gulod_transaction_details = response.data;
			});	
		},
		beneficiaryGulodTransactionButton : function(id, first_name, last_name, middle_name, contact_no, birth_date, email_address, sex, address, is_active, balance, barangay_id){
			this.gulod_beneficiary_id = id;
			this.gulod_beneficiary_first_name = first_name;
			this.gulod_beneficiary_last_name = last_name;
			this.gulod_beneficiary_middle_name = middle_name;
			this.gulod_beneficiary_contact_no = contact_no;
			this.gulod_beneficiary_birth_date = birth_date;
			this.gulod_beneficiary_email_address = email_address;
			this.gulod_beneficiary_sex = sex;
			this.gulod_beneficiary_address = address;
			this.gulod_beneficiary_is_active = is_active;
			this.gulod_beneficiary_balance = balance;
			this.gulod_beneficiary_barangay_id = barangay_id;

			this.gulod_beneficiary_first_name_in_cart = first_name;
			this.gulod_transaction_beneficiary_id = id;

			if(this.gulod_transaction_button == false){
				this.gulod_transaction_button = true;
				this.gulod_beneficiary_info = false;
				this.showReceipt = false;
				this.showBeneficiaryTransaction = true;
			}
			else {
				// this.gulod_transaction_button = false;
				// this.gulod_transactions = [];
				if(this.gulod_transactions.length > 0) {
					this.gulod_beneficiary_first_name_in_cart = first_name;
					swal({
						title : "Are you sure?",
						text : "The item/s in your cart will be discard!",
						icon : "warning",
						buttons : ["Cancel", "Discard"],
						dangerMode: true,
					}).then((willDiscard) => {
						
						if(willDiscard) {
							this.gulod_transaction_button = false;
							this.gulod_transactions = [];
							this.clearData();
						}
						else {
							this.gulod_transaction_button = true;
						}
					});
				}
				else {
					this.gulod_transaction_button = false;
				}
				
			}
			this.gulod_receipts = [];
		},
		viewGulodMedicine : function() {
			$('#myModal6').modal('show');
		},
		generateTransactionID : function() {
    		var id = "";
    		var pad = "0000";
    		var date = new Date();


    		if(this.gulod_save_transactions.length <= 0) {
    			id = "TRANS" + "" + date.getFullYear() +  "0001";
    		}
    		else {
    			for(var index = 0; index < this.gulod_save_transactions.length; index++) {

    				id = this.gulod_save_transactions[index].transaction_id;
    			}
	    		id = id.slice(9);
	    		id = pad.substring(0, pad.length - id.length) + id;
	    		id = date.getUTCFullYear() + "" + id;
	    		id = parseInt(id) + 1;
	    		id = "TRANS" + id;
	    	}
	    	return id;
	    },
		countTransactionCart : function() {
    		var count = 0;
    		for(var index = 0; index < this.gulod_transactions.length; index++) {
    			count++;
    		}
    		return count;
    	},
    	retrieveTransaction : function() {
    		axios.get(this.urlRoot + this.api + "retrieve_transaction.php")
    		.then(function (response) {
    			vm.gulod_save_transactions = response.data;
    		});
    	},
    	gulodTransactionButton : function(id,medicine_name,medicine_quantity,medicine_price,medicine_category,medicine_unit) {
			this.gulod_transaction_medicine_id = id;
			this.gulod_transaction_medicine_name = medicine_name;
			this.gulod_transaction_quantity = medicine_quantity;
			this.gulod_transaction_medicine_price = medicine_price;
			this.gulod_transaction_medicine_category = medicine_category;
			this.gulod_transaction_medicine_unit_category = medicine_unit;
		},
		gulodTransactionAddToCart : function() {
			this.gulod_transaction_medicine_total_price = (parseFloat(this.gulod_transaction_medicine_price) * parseFloat(this.input_quantity));
			this.gulod_transaction_purchase.id = this.gulod_transaction_medicine_id;
			this.gulod_transaction_purchase.name = this.gulod_transaction_medicine_name;
			this.gulod_transaction_purchase.price = this.gulod_transaction_medicine_price;
			this.gulod_transaction_purchase.quantity = this.input_quantity;
			this.gulod_transaction_purchase.description = this.gulod_transaction_medicine_category;
			this.gulod_transaction_purchase.unit = this.gulod_transaction_medicine_unit_category;
			this.gulod_transaction_purchase.total = parseFloat(this.gulod_transaction_medicine_total_price);

			var found = true;
			var found1 = false;

			for(var index = 0; index < this.gulod_medicines.length; index++) {
				for(var index1 = 0; index1 < this.gulod_transactions.length; index1++) {
					if(this.gulod_transaction_purchase.id == this.gulod_transactions[index1].id) {
						if(this.gulod_transactions[index1].id == this.gulod_medicines[index].supplier_medicine_id) {
							var total = parseInt(this.gulod_transaction_purchase.quantity) + parseInt(this.gulod_transactions[index1].quantity);
							if(total > this.gulod_medicines[index].quantity) {
								swal("Error!", " You already exceed the maximun quantity!", "error");
								found = false;
							}
							else {
								if(this.gulod_transaction_purchase.id == this.gulod_transactions[index1].id) {
									found = false;
									found1 = true;

									this.gulod_transactions[index1].quantity = total;
									this.gulod_transactions[index1].total = (parseFloat(total) * parseInt(this.gulod_medicines[index].price));

									var str = this.gulod_transactions[index1].total;
								}
							}
						}
					}
				}
			}

			if(found) {
				this.gulod_transactions.push({...this.gulod_transaction_purchase});
				
				this.showBeneficiaryTransaction = true;
				$('#myModal3').modal('hide');
				this.input_quantity = 1;
			}
			if(found1) {
				this.showBeneficiaryTransaction = true;
				$('#myModal3').modal('hide');
				this.input_quantity = 1;
			}
			this.updateButtonTransaction = true;
			this.saveButtonTransaction = false;
		},
    	gulodSaveTransaction : function() {

    		if(this.gulod_transactions.length == 0 ) {
    			swal("Error!", " You have 0 item in your cart!", "error");
    		}
    		else {
    			for(var index = 0; index < this.gulod_active_beneficiaries.length; index++) {
    				if(this.gulod_active_beneficiaries[index].beneficiary_id == this.gulod_transaction_beneficiary_id) {
    					if(this.gulod_active_beneficiaries[index].balance >= 10000) {
    						swal("Error", " You used your 10,000 worth of medicine!", "error");
    					}
    					else {
    						this.gulodAddTransaction();
    						for(var index = 0; index < this.gulod_transactions.length; index++) {
			    				this.gulod_transaction_receipt.id = this.gulod_transactions[index].id;
			    				this.gulod_transaction_receipt.medicine_name = this.gulod_transactions[index].name;
			    				this.gulod_transaction_receipt.price = this.gulod_transactions[index].price;
			    				this.gulod_transaction_receipt.quantity = this.gulod_transactions[index].quantity;
			    				this.gulod_transaction_receipt.total = this.gulod_transactions[index].total;

			    				this.gulod_receipts.push({...this.gulod_transaction_receipt});
    						}

    						this.showBeneficiaryTransaction = false; //hide medicine transaction table
	    					this.showReceipt = true; //show transaction receipt
    					}
    				}
    			}
    		}
    	},
    	gulodAddTransaction : function() {
    		// transaction
    		var date = new Date();


    		for(var index = 0; index < this.gulod_active_beneficiaries.length; index++) {
    			if(this.gulod_active_beneficiaries[index].beneficiary_id == this.gulod_transaction_beneficiary_id) {
    				this.beneficiary_id = this.gulod_active_beneficiaries[index].beneficiary_id;
    				break;
    			}
    		}


    		axios.post(this.urlRoot + this.api + "add_transaction.php", {
    			transaction_id : this.generateTransactionID(),
    			beneficiary_id : this.beneficiary_id,
    			user_id : "",		
    			transaction_date : date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate()
    		}).then(function (response) {
    			console.log(response);
    			vm.gulodAddTransactionDetails();
    		});
    	},
    	gulodAddTransactionDetails : function() {
    		// // transaction details

    		axios.post(this.urlRoot + this.api + "add_transaction_details.php", {
				gulod_transactions : this.gulod_transactions
			}).then(function (response) {
				console.log(response);
				vm.gulodTransactionUpdateMedicineQuantity();
			});
    	},
    	gulodTransactionUpdateMedicineQuantity : function() {

    		axios.post(this.urlRoot + this.api + "update_medicine.php", {
    			gulod_medicines : this.gulod_medicines,
    			gulod_transactions : this.gulod_transactions
    		}).then(function (response) {
    			console.log(response);
    			vm.retrieveGulodMedicine();
				vm.gulodTransactionUpdateBeneficiaryBalance();
    		});
    	},

    	gulodTransactionUpdateBeneficiaryBalance : function() {

    		axios.post(this.urlRoot + this.api + "update_beneficiary.php", {
    			beneficiary_id : this.gulod_transaction_beneficiary_id,
    			gulod_active_beneficiaries : this.gulod_active_beneficiaries,
    			gulod_beneficiary_balance : this.gulod_beneficiary_balance,
    			gulod_transactions : this.gulod_transactions 
    		}).then(function (response) {
    			console.log(response);
    			vm.retrieveGulodActiveBeneficiary();
				swal("Congrats!", " Transaction save successfully!", "success");
				console.log(response);

    			for(var index = 0; index < vm.gulod_active_beneficiaries.length; index++) {
    				if(vm.gulod_transaction_beneficiary_id == vm.gulod_active_beneficiaries[index].beneficiary_id) {
    					vm.gulod_receipt_first_name = vm.gulod_active_beneficiaries[index].first_name;
						vm.gulod_receipt_last_name = vm.gulod_active_beneficiaries[index].last_name;
	    				vm.gulod_receipt_address = vm.gulod_active_beneficiaries[index].address;
	    				vm.gulod_receipt_contact_no = vm.gulod_active_beneficiaries[index].contact_no;
    				}
    			}
    		});
    	},
    	removeTransactionAddToCart : function(index) {
      		this.gulod_transactions.splice(index, 1);
    	},
		showCityHallMedicine : function() {
			$('#myModal6').modal('show');
		},
		saveRequestOrder : function() {
			if(this.request_orders.length == 0) {
				swal("Error!", " There is no medicine to request!", "error")
			}
			else {
				this.addRequestOrder();
				this.show_request_order = false;
				this.show_request_order_receipt = true;

			}
		},
		retrieveMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_medicine.php")
			.then(function (response) {
				vm.medicines = response.data;
				console.log(response);
			});
		},
		countMedicine : function() {
			var count = 0;
			for(var index = 0; index < this.medicines.length; index++){
				count++;
			}
			return count;
		},
		searchMedicine : function() {
			axios.get(this.urlRoot + this.api + "search_medicine.php?keyword=" + this.search_medicine)
			.then(function (response) {
				vm.medicines = response.data;
				console.log(response);
			});
		},
		disabledRequestOrderButton : function(supplier_medicine_id) {
			for(var index = 0; index < this.request_orders.length; index++) {
				if(this.request_orders[index].medicine_id == supplier_medicine_id) {
					return this.request_orders[index].medicine_id;
				}
			}
		},
		addRequestOrderButton : function(supplier_medicine_id) {
			var found = true;			

			for(var index = 0; index < this.request_orders.length; index++) {
				if(this.request_orders[index].medicine_id == supplier_medicine_id) {
					found = false;
					swal("Error!", " You already request this medicine!", "error");
				}
			}

			if(found) {
				for(var index = 0; index < this.medicines.length; index++) {
					if(supplier_medicine_id == this.medicines[index].supplier_medicine_id) {
						this.add_request_order.medicine_id = this.medicines[index].supplier_medicine_id;
						this.add_request_order.medicine_name = this.medicines[index].medicine_name;
						this.add_request_order.category = this.medicines[index].description;
						this.add_request_order.unit_category = this.medicines[index].unit;
						this.add_request_order.price = this.medicines[index].price;

						this.request_orders.push({...this.add_request_order});
					}
				}
			}
		},
		removeRequestOrder : function(index) {
			this.request_orders.splice(index, 1);
		},
		retrieveRequestOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_request_order.php")
			.then(function (response) {
				vm.retrieve_request_orders = response.data;
			});
		},
		generateRequestOrderID : function() {
			var  id = "";
			var pad = "0000";
			var date = new Date();

			if(this.retrieve_request_orders.length <= 0) {
				id = "RO" + "" + date.getUTCFullYear() + "0001";
			}
			else {
				for(var index = 0; index < this.retrieve_request_orders.length; index++) {
					id = this.retrieve_request_orders[index].request_order_id;
				}

				id = id.slice(6);
				// id = parseInt(id) + 1;
				id = pad.substring(0, pad.length - id.length) + id;
				id = date.getUTCFullYear() + "" + id;
				id = parseInt(id) + 1;
				id = "RO" + "" + id;
			}
			return id;
		},
		addRequestOrder : function() {
			var date = new Date();
			axios.post(this.urlRoot + this.api + "add_request_order.php", {
				request_order_id  : this.generateRequestOrderID(),
				user_id : "",
				date_request : date.getUTCFullYear() + "-" + date.getUTCMonth() + "-" + date.getUTCDate(),
				barangay_id : "1",
				request_order_status : "Pending"
			}).then(function (response) {
				console.log(response);
				vm.addRequestOrderDetails();
			});
		},
		addRequestOrderDetails : function() {
			axios.post(this.urlRoot + this.api + "add_request_order_details.php", {
				request_orders : this.request_orders
			}).then(function (response) {
				vm.addRequestDetails();
				console.log(response);
			});
		},
		addRequestDetails : function() {
			axios.post(this.urlRoot + this.api + "add_request_details.php", {
				request_orders : this.request_orders
			}).then(function (response) {
				console.log(response);
				swal("Congrats!", " Request order successfully!", "success");
			});
		},
		saveRequestOrder : function() {
			if(this.request_orders.length == 0) {
				swal("Error!", " There is no medicine to request!", "error")
			}
			else {
				this.addRequestOrder();
				this.show_request_order = false;
				this.show_request_order_receipt = true;

			}
		},
		retrieveGulodTransactionUsingID : function() {
			axios.get(this.urlRoot + this.api + "retrieve_transaction_using_id.php")
			.then(function (response) {
				vm.gulod_transaction = response.data;
			});
		},
		searchTransaction : function() {
			axios.get(this.urlRoot + this.api + "search_transaction.php?keyword=" + this.search_transaction)
			.then(function (response) {
				vm.gulod_transaction = response.data;
				console.log(response);
			});
		},
		toggleTransactionDetailsInfo : function(id, beneficiary_id) {
			if(this.transaction_details_info == false) {
				this.transaction_details_info = true;
			}
			else {
				this.transaction_details_info = false;
			}

			this.transaction_id = id;
			this.return_medicine_beneficiary_id = beneficiary_id;

			this.retrieveGulodTransactionDetails(id);
		},
		toggleReturnDetails : function(transaction_id) {
			if(this.return_details == false) {
				this.return_details = true;
				this.transaction_details_info = false;
			}
			else {
				this.return_details = false;
				this.transaction_details_info = true;
			}

			this.retrieveReturnMedicineDetails(transaction_id);
		},
		retrieveGulodTransactionDetails : function(transaction_id) {
			axios.get(this.urlRoot + this.api + "retrieve_transaction_details_using_id.php?transaction_id=" + transaction_id)
			.then(function (response) {
				vm.gulod_transaction_details = response.data;
				console.log(response);
			});
		},
		searchTransactionDetails : function() {
			axios.get(this.urlRoot + this.api + "search_transaction_details.php?transaction_id=" + this.transaction_id + "&keyword=" + this.search_transaction_details)
			.then(function (response) {
				vm.gulod_transaction_details = response.data
				console.log(response);
			});
		},
		retrieveSendOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_send_order.php")
			.then(function (response) {
				vm.send_order_using_id = response.data;
			});
		},
		searchSendOrder : function() {
    		axios.get(this.urlRoot + this.api + "search_send_order.php?keyword=" + this.search_send_order)
    		.then(function (response) {
    			vm.send_order_using_id = response.data;
				console.log(response);
    		});
    	},
		toggleRequestOrderDetailsInfo : function(id) {
			if (this.send_order_info == false) {
				this.send_order_info = true;
			} else {
				this.send_order_info = false;
			}

			this.send_order_id = id;

			this.retrieveSendDetails(id);
		},
		retrieveSendOrderDetails : function(send_order_id) {
			axios.get(this.urlRoot + this.api + "retrieve_send_order_details.php?send_order_id=" + send_order_id)
			.then(function (response) {
				vm.send_request_details = response.data;
				console.log(response);
			});
		},
		searchSendOrderDetails : function() {
    		axios.get(this.urlRoot + this.api + "search_send_order_details.php?keyword=" + this.search_send_order_details)
    		.then(function (response) {
    			vm.send_request_details = response.data;
				console.log(response);
    		});
    	},
    	retrieveTransactionReportsToday : function() {
			axios.get(this.urlRoot + this.api + "retrieve_transaction_today.php")
			.then(function (response) {
				vm.reports = response.data;
			});
		},
		searchByDate : function() {
			if(this.start_date && this.end_date) {
				axios.get(this.urlRoot + this.api + "search_start_end_date_transaction.php?start_date=" + this.start_date + "&end_date=" + this.end_date)
				.then(function (response) {
					vm.reports = response.data;
					console.log(response);
				});
			}
		},
		toggleReceivedOrderDetails : function (send_order_id, supplier_medicine_id) {
			if (this.accept_order_details == false) {
				this.send_order_info = false;
				this.accept_order_details = true;
			}
			else {
				this.accept_order_details = false;
			}

			this.retrieveReceivedOrderDetails(send_order_id, supplier_medicine_id);
		},
		toggleReceivedOrder : function(supplier_medicine_id, quantity, send_details_id, received_quantity) {
			this.received_order_supplier_medicine_id = supplier_medicine_id;
			this.received_orders_quantity = quantity;
			this.send_details_id = send_details_id;
			this.received_order_received_quantity = received_quantity;
			if(quantity == "No stock") {
				swal("Cannot add", " Nothing to add!", "warning"); // paayos ng message
			}
			else {
				$('#myModal3').modal('show');
			}
		},
		closeAddReceivedOrder : function() {
			this.received_order_quantity = "";
			this.received_order_expiration_date = "";
			$('#myModal3').modal('hide');
		},
		retrieveSendDetails : function(send_order_id) {
			axios.get(this.urlRoot + this.api + "retrieve_send_details.php?send_order_id=" + send_order_id)
			.then(function (response) {
				vm.send_details = response.data;
			});
		},
		retrieveReceivedOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_received_order.php")
			.then(function (response) {
				vm.received_orders = response.data;
			});
		},
		retrieveReceivedOrderDetails : function(send_order_id, supplier_medicine_id) {
			axios.post(this.urlRoot + this.api + "retrieve_received_order_details.php?send_order_id=" + send_order_id + "&supplier_medicine_id=" + supplier_medicine_id)
			.then(function (response) {
				vm.received_order_details = response.data;
				console.log(response);
			});
		},
		generateReceivedOrderId : function() {
			var id = "";
    		var pad = "00000000";
    		var date = new Date();

    		if(this.received_orders.length <= 0) {
    			id = "RCO" + "" + date.getFullYear() + "-" + "00000001";
    		}
    		else {
    			for(var index = 0; index < this.received_orders.length; index++) {

    				id = this.received_orders[index].received_order_id;
    			}
	    		id = id.slice(8);
	    		id = pad.substring(0, pad.length - id.length) + id;
	    		id = date.getUTCFullYear() + "" + id;
	    		id = parseInt(id) + 1;
	    		id = "RCO" + id;
	    		id = id.substr(0, 7) + "-" + id.substr(7);
	    	}

	    	return id;

		},
		saveReceivedOrder : function() {
			if((parseInt(this.received_order_received_quantity) + parseInt(this.received_order_quantity)) > this.received_orders_quantity) {
				swal("Error!", " Received quantity cannot be more than quantity!", "error");
			}
			else {
				this.addReceivedOrder();
			}
		},
		addReceivedOrder : function() {
			var date = new Date();
			axios.post(this.urlRoot + this.api + "add_received_order.php", {
				received_order_id : this.generateReceivedOrderId(),
				send_order_id : this.send_order_id,
				date_received : date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate(),
				barangay_id : "1"
			}).then(function (response) {
				console.log(response);
				vm.addReceivedOrderDetails();
			});
		},
		addReceivedOrderDetails : function() {
			axios.post(this.urlRoot + this.api + "add_received_order_details.php", {
				supplier_medicine_id : this.received_order_supplier_medicine_id,
				quantity : this.received_order_quantity,
				expiration_date : this.received_order_expiration_date
			}).then(function (response) {
				console.log(response);
				vm.updateSendDetails();
			});
		},
		updateSendDetails : function() {
			axios.post(this.urlRoot + this.api + "update_send_details.php", {
				send_details : this.send_details,
				send_details_id : this.send_details_id,
				send_order_id : this.send_order_id,
				supplier_medicine_id : this.received_order_supplier_medicine_id,
				quantity : this.received_orders_quantity,
				received_quantity : this.received_order_quantity
			}).then(function (response) {
				vm.updateMedicine();
				console.log(response);
			});
		},
		updateMedicine : function() {
			axios.post(this.urlRoot + this.api + "update_medicine_received.php", {
				medicines : this.medicines,
				supplier_medicine_id : this.received_order_supplier_medicine_id,
				quantity : this.received_order_quantity,
				barangay_id : "1"
			}).then(function (response) {
				vm.retrieveSendDetails(vm.send_order_id);
				console.log(response);
				swal("Success!", " Received order successfully!", "success");
				$('#myModal3').modal('hide');
			});
		},
		toggleAddReturnMedicine : function(supplier_medicine_id, quantity) {

			if(quantity == 0) {
				swal("Error!", " No medicine to return!", "error");
			}
			else {
				this.return_medicine_supplier_medicine_id = supplier_medicine_id;
				this.return_medicine_received_quantity = quantity;
				$('#myModal').modal('show');
			}
		},
		retrieveReturnMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_return_medicine.php")
			.then(function (response) {
				vm.return_medicines = response.data;
				console.log(response);
			});
		},
		retrieveReturnMedicineDetails : function(transaction_id) {
			axios.get(this.urlRoot + this.api + "retrieve_return_medicine_details.php?transaction_id=" + transaction_id)
			.then(function (response) {
				vm.return_medicine_details = response.data
				console.log(response);
			});
		},
		generateReturnMedicineId : function() {
			var id = "";
    		var pad = "00000000";
    		var date = new Date();

    		if(this.return_medicines.length <= 0) {
    			id = "RM" + "" + date.getFullYear() + "-" + "00000001";
    		}
    		else {
    			for(var index = 0; index < this.return_medicines.length; index++) {

    				id = this.return_medicines[index].return_medicine_id;
    			}
	    		id = id.slice(7);
	    		id = pad.substring(0, pad.length - id.length) + id;
	    		id = date.getUTCFullYear() + "" + id;
	    		id = parseInt(id) + 1;
	    		id = "RM" + id;
	    		id = id.substr(0, 6) + "-" + id.substr(6);
	    	}

	    	return id;
		},
		addReturnMedicine : function() {
			var date = new Date();
			axios.post(this.urlRoot + this.api + "add_return_medicine.php", {
				return_medicine_id : this.generateReturnMedicineId(),
				beneficiary_id : this.return_medicine_beneficiary_id,
				transaction_id : this.transaction_id,
				date_return : date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate()
			}).then(function (response) {
				vm.addReturnMedicineDetails();
				console.log(response);
			})
		},
		addReturnMedicineDetails : function() {
			axios.post(this.urlRoot + this.api + "add_return_medicine_details.php", {
				supplier_medicine_id : this.return_medicine_supplier_medicine_id,
				supplier_medicines : this.supplier_medicines,
				quantity : this.return_medicine_quantity,
				remarks : this.return_medicine_remarks
			}).then(function (response) {
				vm.updateTransaction();
				console.log(response);
			});
		},
		retrieveSupplierMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_supplier_medicine.php")
			.then(function (response) {
				vm.supplier_medicines = response.data;
				console.log(response);
			})
		},
		updateTransaction : function() {
			axios.post(this.urlRoot + this.api + "update_transaction_details.php", {
				gulod_transaction_details : this.gulod_transaction_details,
				supplier_medicine_id : this.return_medicine_supplier_medicine_id,
				transaction_id : this.transaction_id,
				quantity : this.return_medicine_quantity
			}).then(function (response) {
				console.log(response);
				vm.updateBenficiaryBalance();
			});
		},
		updateBenficiaryBalance : function() {
			axios.post(this.urlRoot + this.api + "update_beneficiary_balance.php", {
				gulod_transaction_details : this.gulod_transaction_details,
				gulod_active_beneficiaries : this.gulod_active_beneficiaries,
				quantity : this.return_medicine_quantity,
				supplier_medicine_id : this.return_medicine_supplier_medicine_id
			}).then(function (response) {
				console.log(response);
				vm.retrieveGulodTransactionDetails(vm.transaction_id);
				swal("Success!", " Return medicine successfully!", "success");
			})
		},
		saveReturnMedicine : function() {
			if(this.return_medicine_received_quantity < this.return_medicine_quantity) {
				swal("Error!", " Return medicine cannot be more than transact medicine!", "error");
			}
			else {
				this.addReturnMedicine();
				$('#myModal').modal('hide');
			}
		},
		

	},
	filters: {
      currency(value) {
        return value.toFixed(2);
      }
    },
	computed : {
		totalSendOrderDetails : function() {
			return Math.ceil(this.send_request_details.length / this.show_entries)
		},
		totalSendOrder : function() {
			return Math.ceil(this.send_order_using_id.length / this.show_entries)
		},
		totalGulodInventory: function() {
	     	let total = 0;

			for(let index = 0; index < this.gulod_medicines.length; index++) {
				total += parseInt(this.gulod_medicines[index].price) * parseInt(this.gulod_medicines[index].quantity);
			}
			return parseInt(total)  + ".00";
	   	},
	   	totalAmountInCart : function() {
			var total = 0;
			for(var index = 0; index < this.gulod_transactions.length; index++) {
				total += parseFloat(this.gulod_transactions[index].total);
			}
			return total;
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
	   	totalItem: function() {
	    	let totalAmount = 0;
	    	for(let i = 0; i < this.gulod_receipts.length; i++){
	    		totalAmount += (parseFloat(this.gulod_receipts[i].total));
	      	}
	     	return totalAmount;
	   	},
	   	totalBeneficiaryTransaction : function() { //sa beneficiary.php nakalagay
			var total = 0;
			for(var index = 0; index < this.gulod_transaction_details.length; index++) {
				total += parseFloat(this.gulod_transaction_details[index].total_price);
			}
			return total;
		},
		totalBeneficiaryRemainingBalance : function() {
			let total = 10000;
	   		let balance = 0;
	   		for (var i = 0; i < this.gulod_transaction_details.length; i++) {
				balance += (parseFloat(this.gulod_transaction_details[i].total_price));
			}
			return total = (parseFloat(total) - parseFloat(balance));
		},
		totalTransactionReportsToday: function() {
	    	let totalAmount = 0;
	    	for(let i = 0; i < this.reports.length; i++){
	    		totalAmount += (parseFloat(this.reports[i].total_price));
	      	}
	     	return totalAmount;
	   	}
	},
	created : function() {
		this.retrieveGulodMedicine();
		this.retrieveGulodActiveBeneficiary();
		this.retrieveGulodInactiveMedicine();
		this.retrieveTransaction();
		this.retrieveMedicine();
		this.retrieveRequestOrder();
		this.retrieveGulodTransactionUsingID();
		this.retrieveTransactionReportsToday();

		this.retrieveSendOrder();

		this.retrieveReceivedOrder();

		this.retrieveReturnMedicine();

		this.retrieveSupplierMedicine();


		// var count = 0;
		// // setInterval(() => {
		// // 	alert(count++);
		// // }, 1000);
	}
})