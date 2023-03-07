var vm = new Vue({
	el : "#vue-referral",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/pharmacist/",

		referral_beneficiary_list : true,

		transaction_list : false,

		receipt_list : false,

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		// title
		add_transaction : "Add transaction",
		update_quantity : "Update quantity",
		save_quantity : "Save quantity",
		delete_row : "Delete row",
		add_to_cart : "Add to cart",
		////////
		edit_disabled : false,
		edit_user : null,

		beneficiaries : [],
		barangays : [],
		transactions : [],
		available_medicines : [],
		supplier_medicines : [],
		categories : [],
		unit_categories : [],
		referral_transactions : [],
		receipts : [],

		add_receipt : {
			medicine_name : null,
			category_name : null,
			unit_category_name : null,
			quantity : null,
			price : null,
			total_amount : null,
		},

		add_transaction : {
			id : null,
			medicine_name : null,
			category_name : null,
			unit_category_name : null,
			quantity : null,
			price : null,
			total_amount : null,
		},


		search_beneficiary : "",
		barangay_id : "",

		beneficiary_id : "",

		search_available_medicine : "",

		quantity : 1,
		quantity_error : false,
		quantity_error_description : "",

		transaction_medicine_id : "",
		transaction_medicine_name : "",
		transaction_category_name : "",
		transaction_unit_category_name : "",
		transaction_medicine_price : "",
		transaction_quantity : "",
	},
	methods : {
		clearData : function() {
			this.quantity = 1;
			this.quantity_error = false;
			this.quantity_error_description = "";
		},
		////////////////
		editData : function (transaction) {
		    this.edit_disabled = true;
		    this.beforEditCache = transaction;
		    this.edit_user = transaction;
   		},
   		saveData : function (transaction_id) {
   			for(var index = 0; index < this.available_medicines.length; index++) {
   				for(var index1 = 0; index1 < this.transactions.length; index1++) {
   					if(transaction_id == this.transactions[index1].id) {
   						if(this.transactions[index1].id == this.available_medicines[index].purchase_received_details_id) {
   							if(this.transactions[index1].quantity <= 0) {
   								swal({
									title : "Error!",
									text : "Invalid quantity!",
									icon : "error",
									timer : "2000",
									buttons : false,
									closeOnClickOutside: false
								});
   							}
   							else if(this.transactions[index1].quantity== '') {
   								swal({
									title : "Error!",
									text : "Quantity cannot be blank!",
									icon : "error",
									timer : "2000",
									buttons : false,
									closeOnClickOutside: false
								});
   							}
   							else {
   								if(this.transactions[index1].quantity > this.transaction_quantity) {
   									swal({
										title : "Error!",
										text : "Purchase quantity cannot be more than stock!",
										icon : "error",
										timer : "2000",
										buttons : false,
										closeOnClickOutside: false
									});
   								}
   								else {
   									swal({
										title : "Good Job!",
										text : "Quantity change Successfully!",
										icon : "success",
										timer : "2000",
										buttons : false,
										closeOnClickOutside: false
									}).then(() => {
	    								vm.edit_disabled = false;
										vm.editUser = null;
										vm.beforEditCache = null;
										vm.edit_user = null;
									});
	   								vm.transactions[index1].total_amount = parseFloat(vm.transactions[index1].quantity) * parseFloat(vm.transactions[index1].price);
   								}
   							}
   						}
   					}
   				}
   			}
    	},
		removeTransactionToCart : function(index) {
			this.transactions.splice(index, 1);
		},
		////////////
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
		str_pad : function(n) {
 			return String("00" + n).slice(-2);
		},
		//////////////
		next: function() {
	      if (this.currentPage < this.totalUnavailable) {
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
		previous: function() {
	      if (this.currentPage > 1) {
	        this.pagination(this.currentPage - 1);
	      }
	    },
	    ////////////////

	    // validation method
	    checkUniqueMedicine : function() {
	    	var found = true;
	    	for(var index = 0; index < this.transactions.length; index++) {
	    		if(this.add_transaction.id == this.transactions[index].id) {
	    			found = false;
	    		}
	    	}
	    	return found;
	    },
	    checkUniqueTransaction : function() {
	    	for(var index = 0; index < this.transactions.length; index++) {
	    		if(this.add_transaction.id == this.transactions[index].id) {
	    			var total_quantity = parseInt(this.add_transaction.quantity) + parseInt(this.transactions[index].quantity);
	    			if(parseInt(this.transaction_quantity) < parseInt(total_quantity)) {
	    				this.quantity_error = true;
	    				this.quantity_error_description = "Purchase quantity cannot be more than stock!";
	    			}
	    			else {
	    				this.transactions[index].quantity = total_quantity;
	    				this.transactions[index].total_amount = parseFloat(this.transactions[index].quantity) * parseFloat(this.transactions[index].price);

	    				$('#myModal1').modal('hide');
	    				this.clearData();
	    			}
	    		}
	    	}
	    },
	    transactionValidation : function() {
	    	// alert(this.checkUniqueMedicine());
	    	if(this.checkUniqueMedicine() == true) {
	    		if(parseInt(this.transaction_quantity) < parseInt(this.add_transaction.quantity)) {
	    			this.quantity_error = true;
    				this.quantity_error_description = "Purchase quantity cannot be more than stock!";
	    		}
	    		else {
	    			this.transactions.push({...this.add_transaction});
					$('#myModal1').modal('hide');
					this.clearData();
					// console.log(this.transactions);
	    		}
	    	}
	    	else {
	    		this.checkUniqueTransaction();
	    	}
	    },
	    ////////////////////

	    // identify method
	    identifyBeneficiaryFirstName : function(beneficiary_id) {
	    	for(var index = 0; index < this.beneficiaries.length; index++) {
	    		if(beneficiary_id == this.beneficiaries[index].beneficiary_id) {
	    			return this.beneficiaries[index].first_name;
	    		}
	    	}
	    },
	    identifyBeneficiaryLastName : function(beneficiary_id) {
	    	for(var index = 0; index < this.beneficiaries.length; index++) {
	    		if(beneficiary_id == this.beneficiaries[index].beneficiary_id) {
	    			return this.beneficiaries[index].last_name;
	    		}
	    	}
	    },
	    identifyBeneficiaryAddress: function(beneficiary_id) {
	    	for(var index = 0; index < this.beneficiaries.length; index++) {
	    		if(beneficiary_id == this.beneficiaries[index].beneficiary_id) {
	    			return this.beneficiaries[index].address;
	    		}
	    	}
	    },
	    identifyBeneficiaryContactNo : function(beneficiary_id) {
	    	for(var index = 0; index < this.beneficiaries.length; index++) {
	    		if(beneficiary_id == this.beneficiaries[index].beneficiary_id) {
	    			return this.beneficiaries[index].contact_no;
	    		}
	    	}
	    },
	    identifyBeneficiaryBalance : function(beneficiary_id) {
	    	for(var index = 0; index < this.beneficiaries.length; index++) {
	    		if(beneficiary_id == this.beneficiaries[index].beneficiary_id) {
	    			return this.beneficiaries[index].balance;
	    		}
	    	}
	    },
	    identifyMedicineName : function(supplier_medicine_id) {
	    	for(var index = 0; index < this.supplier_medicines.length; index++) {
	    		if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
	    			return this.supplier_medicines[index].medicine_name;	
	    		}
	    	}
	    },
	    identifyCategoryName : function(supplier_medicine_id) {
	    	for(var index = 0; index < this.supplier_medicines.length; index++) {
	    		for(var index1 = 0; index1 < this.categories.length; index1++) {
	    			if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
		    			if(this.supplier_medicines[index].category_id == this.categories[index1].category_id) {
		    				return this.categories[index1].description;	
		    			}
		    		}
	    		}
	    		
	    	}
	    },
	    identifyUnitCategoryName : function(supplier_medicine_id) {
	    	for(var index = 0; index < this.supplier_medicines.length; index++) {
	    		for(var index1 = 0; index1 < this.unit_categories.length; index1++) {
	    			if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
		    			if(this.supplier_medicines[index].unit_category_id == this.unit_categories[index1].unit_category_id) {
		    				return this.unit_categories[index1].unit;	
		    			}
		    		}
	    		}
	    		
	    	}
	    },
	    identifyMedicinePrice : function(supplier_medicine_id) {
	    	for(var index = 0; index < this.supplier_medicines.length; index++) {
	    		if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
	    			return this.supplier_medicines[index].price;	
	    		}
	    	}
	    },
	    identifyTransactionTotalAmount : function() {
	    	var total = 0;
	    	for(var index = 0; index < this.transactions.length; index++) {
	    		total += parseFloat(this.transactions[index].total_amount);
	    	}
	    	return total;
	    },
	    identifyBarangayAddress : function(barangay_id) {
	    	for(var index = 0; index  < this.barangays.length; index++) {
	    		if(barangay_id == this.barangays[index].barangay_id) {
	    			return this.barangays[index].address;
	    		}
	    	}
	    },
	    identifyBarangayContactNo : function(barangay_id) {
	    	for(var index = 0; index  < this.barangays.length; index++) {
	    		if(barangay_id == this.barangays[index].barangay_id) {
	    			return this.barangays[index].contact_no;
	    		}
	    	}
	    },
	    //////////////////

	    // toggle button
	    toggleTransaction : function(beneficiary_id, balance) {
	    	if(parseInt(balance) >= 10000) {
	    		swal({
	    			title : "Invalid!",
	    			text : "This beneficiary got 10000 already!",
	    			icon : "warning",
	    			buttons : false,
	    			closeOnClickOutside : false,
	    			timer : 2050
	    		})
	    	}
	    	else {
	    		if(this.referral_beneficiary_list == true) {
		    		this.referral_beneficiary_list = false;
		    		this.transaction_list = true;

		    		this.beneficiary_id = beneficiary_id;
		    	}
		    	else {

		    		if(this.transactions.length > 0) {
		    			swal({
							title : "Are you sure?",
							text : "The item/s in your cart will be discard!",
							icon : "warning",
							buttons : ["Cancel", "Discard"],
							dangerMode: true,
							closeOnClickOutside : false,
						}).then((willDiscard) => {
							if(willDiscard) {
								this.referral_beneficiary_list = true;
								this.transaction_list = false;
								this.transactions = [];
							}
						});
		    		}
		    		else {
		    			this.referral_beneficiary_list = true;
		    			this.transaction_list = false;
		    		} 
		    		
		    	}
	    	}
	    	
	    },
	    ////////////////

	    // search method
	    searchBeneficiary : function() {
	    	axios.get(this.urlRoot + this.api + "search_beneficiary.php?beneficiary_id=" + this.search_beneficiary + "&barangay_id=" + this.barangay_id)
	    	.then(function (response) {
	    		console.log(response);
	    		vm.beneficiaries = response.data;
	    	})
	    },
	   	searchAvailableMedicine : function() {
	    	axios.get(this.urlRoot + this.api + "search_available_medicine_for_referral.php?barcode=" + this.search_available_medicine)
	    	.then(function (response) {
	    		console.log(response);
	    		vm.available_medicines = response.data;
	    	})
	    },
	    ////////////////

	    // retrieve method
	    retrieveBarangay : function() {
	    	axios.get(this.urlRoot + this.api + "retrieve_barangay.php")
	    	.then(function (response) {
	    		console.log(response);
	    		vm.barangays = response.data;
	    	})
	    },
	    retrieveBeneficiary : function(barangay_id) {
	    	axios.get(this.urlRoot + this.api + "retrieve_beneficiary.php?barangay_id=" + barangay_id)
	    	.then(function (response) {
	    		console.log(response);
	    		vm.beneficiaries = response.data;
	    	});
	    },
	    retrieveAvailableMedicine : function() {
	    	axios.get(this.urlRoot + this.api + "retrieve_available_medicine.php")
	    	.then(function (response) {
	    		console.log(response);
	    		vm.available_medicines = response.data;
	    	});
	    },
	    retrieveSupplierMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_supplier_medicine.php")
			.then(function (response) {
				vm.supplier_medicines = response.data;
				console.log(response);
			})
		},
		retrieveCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_category.php")
			.then(function (response) {
				console.log(response);
				vm.categories = response.data;
			});
		},
		retrieveUnitCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_unit_category.php")
			.then(function (response) {
				console.log(response);
				vm.unit_categories = response.data;
			});
		},
		retrieveReferralTransaction : function() {
			axios.get(this.urlRoot + this.api + "retrieve_referral_transaction.php")
			.then(function (response) {
				console.log(response);
				vm.referral_transactions = response.data;
			});
		},
	    //////////////////

	    // generate id
	    generateReferralTransactionId : function() {
	    	var id = "";
    		var pad = "0000";
    		var date = new Date();

    		if(this.referral_transactions.length == 0) {
    			id = "RT" + date.getFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + "0001";
    		}
    		else {
    			for(var index = 0; index < this.referral_transactions.length; index++) {
    				id = this.referral_transactions[index].referral_transaction_id;
    			}

    			id = id.slice(10);
    			id = pad.substring(0, pad.length - id.length) + id;
	    		id = date.getFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + id;
	    		id = parseInt(id) + 1;
	    		id = "RT" + id;
    		}
    		return id;
	    },
	    //////////////

		addTransactionButton : function(purchase_received_details_id, supplier_medicine_id, received_quantity) {
			this.transaction_medicine_id = purchase_received_details_id;
			this.transaction_medicine_name = this.identifyMedicineName(supplier_medicine_id);
			this.transaction_category_name = this.identifyCategoryName(supplier_medicine_id);
			this.transaction_unit_category_name = this.identifyUnitCategoryName(supplier_medicine_id);
			this.transaction_quantity = received_quantity;
			this.transaction_medicine_price = this.identifyMedicinePrice(supplier_medicine_id);
		},
		addTransactionToCart : function() {
			if(this.quantity == '') {
				this.quantity_error = true;
				this.quantity_error_description = "This field is required!";
			}
			else if(this.quantity <= 0) {
				this.quantity_error = true;
				this.quantity_error_description = "Invalid input!";
			}
			else {
				this.add_transaction.id = this.transaction_medicine_id;
				this.add_transaction.medicine_name = this.transaction_medicine_name;
				this.add_transaction.category_name = this.transaction_category_name;
				this.add_transaction.unit_category_name = this.transaction_unit_category_name;
				this.add_transaction.quantity = this.quantity;
				this.add_transaction.price = this.transaction_medicine_price;
				this.add_transaction.total_amount = parseFloat(this.transaction_medicine_price) * parseFloat(this.add_transaction.quantity);

				this.transactionValidation();
			}
		},

		createReceipt : function() {
			for(var index = 0; index < this.transactions.length; index++) {
				this.add_receipt.medicine_name = this.transactions[index].medicine_name;
				this.add_receipt.category_name = this.transactions[index].category_name;
				this.add_receipt.unit_category_name = this.transactions[index].unit_category_name;
				this.add_receipt.price = this.transactions[index].price;
				this.add_receipt.quantity = this.transactions[index].quantity;
				this.add_receipt.total_amount = this.transactions[index].total_amount;

				this.receipts.push({...this.add_receipt});
			}
		},
		//////////////

		saveTransaction : function() {
			if(this.transactions.length == 0) {
				swal({
					title : "Error!",
					text : "No transaction to save!",
					icon : "error",
					buttons : false,
					closeOnClickOutside : false,
					timer : 1050
				})
			}
			else {
				this.addReferralTransaction();
			}
		},
		addReferralTransaction : function() {
			var date = new Date();
			axios.post(this.urlRoot + this.api + "add_referral_transaction.php", {
				referral_transaction_id : this.generateReferralTransactionId(),
				beneficiary_id : this.beneficiary_id,
				referral_transaction_date : date.getFullYear() + "-" + this.str_pad(date.getMonth() + 1) + "-" + this.str_pad(date.getDate()),
				barangay_id : this.barangay_id
			}).then(function (response) {
				console.log(response);
				vm.addReferralTransactionDetails();
			})
		},
		addReferralTransactionDetails : function() {
			axios.post(this.urlRoot + this.api + "add_referral_transaction_details.php", {
				transactions : this.transactions
			}).then(function (response) {
				console.log(response);
				vm.updatePurchaseReceivedDetails();
			})
		},
		updatePurchaseReceivedDetails : function() {
			axios.post(this.urlRoot + this.api + "update_purchase_received_details_for_referral.php", {
				transactions : this.transactions,
				available_medicines : this.available_medicines
			}).then(function (response) {
				console.log(response);
				vm.updateBeneficiaryBalance();
			})
		},
		updateBeneficiaryBalance : function() {
			axios.post(this.urlRoot + this.api + "update_beneficiary_balance_for_referral.php", {
				total_amount : this.identifyTransactionTotalAmount(),
				balance : this.identifyBeneficiaryBalance(this.beneficiary_id),
				beneficiary_id : this.beneficiary_id
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Greate Job!",
					text : "Save transaction Successfully!",
					icon : "success",
					buttons : false,
					closeOnClickOutside : false,
					timer : 2000
				}).then(() => {
					vm.createReceipt();
					vm.transaction_list = false;
					vm.referral_beneficiary_list = false;
					vm.receipt_list = true;
				})
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
	filters: {
      currency(value) {
        return value.toFixed(2);
      }
    },
	computed : {
		totalAmountInCart : function() {
			var total = 0;
			for(var index = 0; index < this.transactions.length; index++) {
				total += parseFloat(this.transactions[index].total_amount);
			}
			return total;
		},
		remainingBalance: function() {
	   		let total = 10000;
	   		let balance = 0;
	   		let remainingBalance = this.identifyBeneficiaryBalance(this.beneficiary_id);
	   		for (var i = 0; i < this.transactions.length; i++) {
				balance += (parseFloat(this.transactions[i].total_amount));
			}
			return total -= (parseFloat(remainingBalance) + parseFloat(balance));
	   	},
	   	totalItem: function() {
	    	let totalAmount = 0;
	    	for(let i = 0; i < this.receipts.length; i++){
	    		totalAmount += (parseFloat(this.receipts[i].total_amount));
	      	}
	     	return totalAmount;
	   	},
	},
	created() {
		this.retrieveBarangay();
		this.retrieveAvailableMedicine();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrieveReferralTransaction();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
});