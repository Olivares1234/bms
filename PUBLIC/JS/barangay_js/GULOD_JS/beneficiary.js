var vm = new Vue({ 
	el : "#vue-beneficiary",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/gulod_api/",

		// titles
		view_Order : "View Order",
		beneficiary_Transaction : "Go To Transaction",
		view_Beneficiary : "View Beneficiary",

		add_to_cart : "Add Medicine To Cart",
		update_Quantity : "Update Quantity",
		save_Quantity : "Save Quantity",
		delete_Row : "Delete Row",
		//////////////////

		// buttons
		gulod_transaction_button : false,
		gulod_beneficiary_info : false,
		showBeneficiaryTransaction : false,
		editDisabled : false,

		editedUser : null,
		////////////////

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		gulod_active_beneficiaries : [],
		search_gulod_beneficiary : "",

		beneficiaries : [],

		gulod_beneficiary_first_name_in_cart : "",
		gulod_transaction_beneficiary_id : "",

		gulod_beneficiary_balance : "",

		search_transaction_medicine : "",
		gulod_transactions : [],

		gulod_medicines : [],
		search_gulod_medicine : "",

		// receipt//
		gulod_receipts : [],
		showReceipt : false,
		gulod_receipt_first_name : "",
		gulod_receipt_last_name : "",
		gulod_receipt_contact_no : "",
		gulod_receipt_address : "",
		///////////////

		gulod_save_transactions : [],

		input_quantity : 1,
		gulod_transaction_quantity : 1,

		gulod_transaction_details : [],

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

		gulod_beneficiary_id : "",
		gulod_beneficiary_first_name : "",
		gulod_beneficiary_last_name : "",
		gulod_beneficiary_middle_name : "",
		gulod_beneficiary_contact_no : "",
		gulod_beneficiary_birth_date : "",
		gulod_beneficiary_email_address : "",
		gulod_beneficiary_sex : "",
		gulod_beneficiary_address : "",
		gulod_beneficiary_educational_attainment : "",
		gulod_beneficiary_occupation : "",
		gulod_beneficiary_religion : "",
		gulod_beneficiary_civil_status_id : "",
		gulod_beneficiary_status : "",
		gulod_beneficiary_beneficiary_type_id : "",
		gulod_beneficiary_balance : "",
		gulod_beneficiary_barangay_id : "",
	},
	methods : {
		// input type methods
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
	    nextActiveBeneficiary: function() {
	      if (this.currentPage < this.totalPageActive) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    nextBeneficiaryDetails: function() {
	      if (this.currentPage < this.totalBeneficiaryDetails) {
	        this.pagination(this.currentPage + 1);
	      }
	    },

	    // toggle buttons
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
    	removeTransactionToCart : function(index) {
      		this.gulod_transactions.splice(index, 1);
    	},
	    viewGulodMedicine : function() {
			$('#myModal6').modal('show');
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
		beneficiaryGulodTransactionButton : function(id){
			this.gulod_beneficiary_id = id;
			// this.gulod_beneficiary_first_name = first_name;
			// this.gulod_beneficiary_last_name = last_name;
			// this.gulod_beneficiary_middle_name = middle_name;
			// this.gulod_beneficiary_contact_no = contact_no;
			// this.gulod_beneficiary_birth_date = birth_date;
			// this.gulod_beneficiary_email_address = email_address;
			// this.gulod_beneficiary_sex = sex;
			// this.gulod_beneficiary_address = address;
			// this.gulod_beneficiary_is_active = is_active;
			this.gulod_beneficiary_balance = this.identifyBeneficiaryBalance(id);
			// this.gulod_beneficiary_barangay_id = barangay_id;

			this.gulod_beneficiary_first_name_in_cart = this.identifyBeneficiaryFirstName(id);
			this.gulod_transaction_beneficiary_id = id;

			if(this.gulod_transaction_button == false){
				this.gulod_transaction_button = true;
				this.gulod_beneficiary_info = false;
				this.showReceipt = false;
				this.showBeneficiaryTransaction = true;
			}
			else {
				if(this.gulod_transactions.length > 0) {
					this.gulod_beneficiary_first_name_in_cart = this.identifyBeneficiaryFirstName(id);
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
		gulodSaveTransaction : function() {

    		if(this.gulod_transactions.length == 0 ) {
    			swal("Error!", " You have 0 item in your cart!", "error");
    		}
    		else {
    			for(var index = 0; index < this.beneficiaries.length; index++) {
    				if(this.beneficiaries[index].beneficiary_id == this.gulod_transaction_beneficiary_id) {
    					if(this.beneficiaries[index].balance >= 10000) {
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
		gulodAddTransaction : function() {
    		// transaction
    		var date = new Date();

    		axios.post(this.urlRoot + this.api + "add_transaction.php", {
    			transaction_id : this.generateTransactionID(),
    			beneficiary_id : this.identifyBeneficiaryId(this.gulod_transaction_beneficiary_id),		
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
				// console.log(response);
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
    			beneficiary_id : this.identifyBeneficiaryId(this.gulod_transaction_beneficiary_id),
    			beneficiaries : this.beneficiaries,
    			gulod_beneficiary_balance : this.gulod_beneficiary_balance,
    			gulod_transactions : this.gulod_transactions 
    		}).then(function (response) {
    			console.log(response);
    			vm.retrieveBeneficiary();
				swal("Congrats!", " Transaction save successfully!", "success");
				vm.retrieveTransactionReceipt();
    		});
    	},

		// count methods
		countGulodActiveBeneficiary : function() {
			var count = 0;

			for(var index = 0; index < this.beneficiaries.length; index++) {
				count++;
			}
			return count;
		},
		countTransactionCart : function() {
    		var count = 0;
    		for(var index = 0; index < this.gulod_transactions.length; index++) {
    			count++;
    		}
    		return count;
    	},
    	countGulodMedicine : function() {
			var count = 0;

			for(var index  = 0; index < this.gulod_medicines.length; index++) {
				count++;
			}

			return count;
		},

		// retrieve methods
		retrieveGulodActiveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_active_beneficiary.php")
			.then(function (response) {
				vm.gulod_active_beneficiaries = response.data;
				console.log(response);
			});
		},
		retrieveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary.php")
			.then(function (response) {
				vm.beneficiaries = response.data;
				console.log(response);
			});
		},
		retrieveGulodMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_active_medicine.php")
			.then(function (response) {
				vm.gulod_medicines = response.data;
			});
		},
		retrieveTransaction : function() {
    		axios.get(this.urlRoot + this.api + "retrieve_transaction.php")
    		.then(function (response) {
    			vm.gulod_save_transactions = response.data;
    		});
    	},
    	retrieveTransactionReceipt : function() {
			for(var index = 0; index < vm.beneficiaries.length; index++) {
				if(vm.gulod_transaction_beneficiary_id == vm.beneficiaries[index].beneficiary_id) {
					vm.gulod_receipt_first_name = vm.beneficiaries[index].first_name;
					vm.gulod_receipt_last_name = vm.beneficiaries[index].last_name;
    				vm.gulod_receipt_address = vm.beneficiaries[index].address;
    				vm.gulod_receipt_contact_no = vm.beneficiaries[index].contact_no;
				}
			}
    	},

		// search methods
		searchGulodBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "search_beneficiary.php?keyword=" + this.search_gulod_beneficiary)
			.then(function (response) {
				vm.beneficiaries = response.data;
				console.log(response);
			});
		},
		searchGulodMedicine : function() {
			axios.get(this.urlRoot + this.api + "search_medicine.php?keyword=" + this.search_gulod_medicine)
			.then(function (response) {
				vm.gulod_medicines = response.data;
			});
		},

		// generate id's
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

	    // identify methods
	    identifyBeneficiaryId : function(beneficiary_id) {
	    	for(var index = 0; index < this.beneficiaries.length; index++) {
    			if(this.beneficiaries[index].beneficiary_id == beneficiary_id ) {
    				return this.beneficiaries[index].beneficiary_id;
    			}
    		}
	    },
	    identifyBeneficiaryFirstName : function(beneficiary_id) {
	    	for(var index = 0; index < this.beneficiaries.length; index++) {
	    		if(this.beneficiaries[index].beneficiary_id == beneficiary_id) {
	    			return this.beneficiaries[index].first_name;
	    		}
	    	}
	    },
	    identifyBeneficiaryBalance : function(beneficiary_id) {
	    	for(var index = 0; index < this.beneficiaries.length; index++) {
	    		if(this.beneficiaries[index].beneficiary_id == beneficiary_id) {
	    			return this.beneficiaries[index].balance;
	    		}
	    	}
	    }

	},
	filters: {
      currency(value) {
        return value.toFixed(2);
      }
    },
    computed : {
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
    },
	created() {
		this.retrieveBeneficiary();

		this.retrieveGulodMedicine()
		this.retrieveTransaction();
	}
});