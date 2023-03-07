var vm = new Vue({
	el : "#vue-beneficiary",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/barangay/health_worker/",

		// titles
		view_beneficiary_details : "View beneficiary details",
		add_transaction : "Add transaction",

		add_to_cart : "Add Medicine To Cart",
		update_quantity : "Update Quantity",
		save_quantity : "Save Quantity",
		delete_row : "Delete Row",
		/////////

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		////// end of pagination /////////

		// for toggle button
		transaction_button : false,
		beneficiary_info : false,
		show_transaction : false,

		edit_disabled : false,

		show_receipt : false,

		edit_user : null,
		///////////////////////

		beneficiaries : [],

		filter : "",
		search_beneficiary : "",
		status : "Active",

		beneficiary_first_name_in_cart : "",
		beneficiary_id : "",

		search_transaction_medicine : "",

		transactions : [],

		transaction_receipt: {
			id : null,
			medicine_name : null,
			category : null,
			unit_category : null,
			price : null,
			quantity : null,
			total_amount : null
		},

		available_medicines : [],
		search_available_medicine : "",

		save_transactions : [],

		transaction_details : [],

		receipt_first_name : "",
		receipt_last_name : "",
		receipt_address : "",
		receipt_contact_no : "",

		receipts : [],

		input_quantity : 1,
		input_quantity_error : false,
		input_quantity_error_description : "",

		transaction_quantity : 1,

		beneficiary_info_address : "",
		beneficiary_info_first_name : "",
		beneficiary_info_last_name : "",
		beneficiary_info_middle_name : "",
		beneficiary_info_sex : "",
		beneficiary_info_email_address : "",
		beneficiary_info_birth_date : "",
		beneficiary_info_contact_no : "",
		beneficiary_info_religion : "",
		beneficiary_educational_attainment : "",
		beneficiary_occupation : "",
		beneficiary_civil_status : "",
		beneficiary_street : "",
		beneficiary_house_no : "",
		beneficiary_subdivision : "",
		beneficiary_beneficiary_type : "",
		beneficiary_status : "",
		beneficiary_balance : "",
		beneficiary_barangay : "",

		beneficiary_id : "",

		supplier_medicines : [],
		categories : [],
		unit_categories : [],
		barangays : [],

		transaction_medicine_id : "",
		transaction_medicine_name : "",
		transaction_medicine_quantity : "",
		transaction_medicine_price : "",
		transaction_medicine_category : "",
		transaction_medicine_unit_category : "",


		purchase_transaction : {
			id : null,
			name : null,
			price : null,
			quantity : null,
			category : null,
			unit_category : null,
			total : null
		},

		beneficiary_balance : "",

		purchase_received_details : [],

		civil_status : [],

		beneficiary_type : []
	},
	methods : {
		clearData : function() {
			this.input_quantity = 1;
			this.input_quantity_error = false;
			this.input_quantity_error_description = "";
		},
		////////////////////
		str_pad : function(n) {
 			return String("00" + n).slice(-2);
		},
		// input type methods
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
		// for pagination
		showEntries : function(value) {
         	this.endIndex = value;
         	this.pagination(1);
		},
		pagination : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries) - this.show_entries;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries);
		},

		// for pagination
		showEntries_two : function(value) {
         	this.endIndex = value;
         	this.pagination(1);
		},
		pagination_two : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries_two) - this.show_entries_two;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries_two);
		},
		next: function() {
	      if (this.currentPage < this.totalPages) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    next_two: function() {
	      if (this.currentPage < this.totalPages_two) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    previous: function() {
	      if (this.currentPage > 1) {
	        this.pagination(this.currentPage - 1);
	      }

	    },


		// identify methods
		identifyBeneficiaryFirstName : function(beneficiary_id) {
	    	for(var index = 0; index < this.beneficiaries.length; index++) {
	    		if(this.beneficiaries[index].beneficiary_id == beneficiary_id) {
	    			return this.beneficiaries[index].first_name;
	    		}
	    	}
	    },
	    identifyMedicineId : function(id) {
	    	for(var index = 0; index < this.supplier_medicines.length; index++) {
	    		if(id == this.supplier_medicines[index].supplier_medicine_id) {
	    			return this.supplier_medicines[index].supplier_medicine_id;
	    		}
	    	}
	    },
	    identifyMedicineName : function(purchase_received_details_id) {
			for(var index = 0; index < this.purchase_received_details.length; index++) {
				for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
					if(purchase_received_details_id == this.purchase_received_details[index].purchase_received_details_id) {
						if(this.purchase_received_details[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
							return this.supplier_medicines[index1].medicine_name;
						}
						
					}
				}
				 
			}
		},
	    identifyMedicinePrice : function(purchase_received_details_id) {
			for(var index = 0; index < this.purchase_received_details.length; index++) {
				for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
					if(purchase_received_details_id == this.purchase_received_details[index].purchase_received_details_id) {
						if(this.purchase_received_details[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
							return this.supplier_medicines[index1].price;
						}
						
					}
				}
				
			}
		},
	    identifyCategoryId : function(supplier_medicine_id) {
	    	for(var index = 0; index < this.supplier_medicines.length; index++) {
	    		if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
	    			return this.supplier_medicines[index].category_id;
	    		}
	    	}
	    },
	    identifyCategoryName : function(purchase_received_details_id) {
			for(var index = 0; index < this.purchase_received_details.length; index++) {
				for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
					for(var index2 = 0; index2 < this.categories.length; index2++) {
						if(purchase_received_details_id == this.purchase_received_details[index].purchase_received_details_id) {
							if(this.purchase_received_details[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
								if(this.supplier_medicines[index1].category_id == this.categories[index2].category_id)
								return this.categories[index2].description;
							}
							
						}
					}
					
				}
				
			}
		},

	    identifyUnitCategoryId : function(supplier_medicine_id) {
	    	for(var index = 0; index < this.supplier_medicines.length; index++) {
	    		if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
	    			return this.supplier_medicines[index].unit_category_id;
	    		}
	    	}
	    },
	    identifyUnitCategoryName : function(purchase_received_details_id) {
			for(var index = 0; index < this.purchase_received_details.length; index++) {
				for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
					for(var index2 = 0; index2 < this.unit_categories.length; index2++) {
						if(purchase_received_details_id == this.purchase_received_details[index].purchase_received_details_id) {
							if(this.purchase_received_details[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
								if(this.supplier_medicines[index1].unit_category_id == this.unit_categories[index2].unit_category_id)
								return this.unit_categories[index2].unit;
							}
						}
					}
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
	    identifyBeneficiaryDetails : function(beneficiary_id) {
	    	for(var index = 0; index < this.beneficiaries.length; index++) {
	    		if(beneficiary_id == this.beneficiaries[index].beneficiary_id) {
	    			this.beneficiary_info_first_name = this.beneficiaries[index].first_name;
	    			this.beneficiary_info_last_name = this.beneficiaries[index].last_name;
	    			this.beneficiary_info_middle_name = this.beneficiaries[index].middle_name;
	    			this.beneficiary_info_sex = this.beneficiaries[index].sex;
	    			this.beneficiary_info_contact_no = this.beneficiaries[index].contact_no;
	    			this.beneficiary_info_religion = this.beneficiaries[index].religion;
	    			this.beneficiary_educational_attainment = this.beneficiaries[index].educational_attainment;
	    			this.beneficiary_occupation = this.beneficiaries[index].occupation;
	    			this.beneficiary_civil_status = this.identifyCivilStatus(this.beneficiaries[index].civil_status_id);
	    			this.beneficiary_street = this.beneficiaries[index].street;
	    			this.beneficiary_info_email_address = this.beneficiaries[index].email_address;
	    			this.beneficiary_info_contact_no = this.beneficiaries[index].contact_no;
	    			this.beneficiary_info_birth_date = this.beneficiaries[index].birth_date;
	    			this.beneficiary_info_address = this.beneficiaries[index].address;
	    			this.beneficiary_house_no = this.beneficiaries[index].house_no;
					this.beneficiary_subdivision = this.beneficiaries[index].subdivision;
					this.beneficiary_beneficiary_type = this.identifyBeneficiaryType(this.beneficiaries[index].beneficiary_type_id);
					this.beneficiary_status = this.beneficiaries[index].status
					this.beneficiary_balance = this.beneficiaries[index].balance
					this.beneficiary_barangay = this.beneficiaries[index].barangay_id
	    		}
	    	}
	    },
	    identifyBarangayAddress : function(barangay_id) {
	    	for(var index = 0; index < this.barangays.length; index++) {
	    		if(barangay_id == this.barangays[index].barangay_id) {
	    			return this.barangays[index].address;
	    		}
	    	}
	    },
	    identifyBarangayContactNo : function(barangay_id) {
	    	for(var index = 0; index < this.barangays.length; index++) {
	    		if(barangay_id == this.barangays[index].barangay_id) {
	    			return this.barangays[index].contact_no;
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
	    identifyBeneficiaryType : function(beneficiary_type_id) {
	    	for(var index = 0; index < this.beneficiary_type.length; index++) {
	    		if(beneficiary_type_id == this.beneficiary_type[index].beneficiary_type_id) {
	    			return this.beneficiary_type[index].description;
	    		}
	    	}
	    },
	    /////////////
	    
		// toggle button methods
		toggleTransaction : function(id) {
			this.beneficiary_id = id;
			if(this.transaction_button == false){
				this.transaction_button = true;
				this.beneficiary_info = false;
				this.show_receipt = false;
				this.show_transaction = true;

				this.beneficiary_balance = this.identifyBeneficiaryBalance(id);
				this.beneficiary_first_name_in_cart = this.identifyBeneficiaryFirstName(id);

			}
			else {
				if(this.transactions.length > 0) {
					this.beneficiary_first_name_in_cart = this.identifyBeneficiaryFirstName(id);
					swal({
						title : "Are you sure?",
						text : "The item/s in your cart will be discard!",
						icon : "warning",
						buttons : ["Cancel", "Discard"],
						dangerMode: true,
						closeOnClickOutside : false,
					}).then((willDiscard) => {
						if(willDiscard) {
							this.transaction_button = false;
							this.transactions = [];
						}
						else {
							this.transaction_button = true;
						}
					});
				}
				else {
					this.transaction_button = false;
				}
			}
		},
		viewGulodMedicine : function() {
			$('#myModal6').modal('show');
		},
		beneficiaryDetailsButton : function(beneficiary_id) {
			if(this.beneficiary_info == false) {
				this.beneficiary_info = true;
				this.identifyBeneficiaryDetails(beneficiary_id);
				this.retrieveTransactionDetails(beneficiary_id);

			}
			else {
				this.beneficiary_info = false;
			}
		},
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
									timer : "3000",
									buttons : false,
									closeOnClickOutside: false
								});
   							}
   							else if(this.transactions[index1].quantity== '') {
   								swal({
									title : "Error!",
									text : "Quantity cannot be blank!",
									icon : "error",
									timer : "3000",
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
										timer : "3000",
										buttons : false,
										closeOnClickOutside: false
									});
   								}
   								else {
   									swal({
										title : "Good Job!",
										text : "Quantity change Successfully!",
										icon : "success",
										timer : "3000",
										buttons : false,
										closeOnClickOutside: false
									}).then(() => {
	    								vm.edit_disabled = false;
										vm.editUser = null;
										vm.beforEditCache = null;
										vm.edit_user = null;
									});
	   								vm.transactions[index1].total = parseFloat(vm.transactions[index1].quantity) * parseFloat(vm.transactions[index1].price);
   								}
   							}
   						}
   					}
   				}
   			}
    	},

		// search methods
		searchBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "search_beneficiary.php?filter=" + this.filter + "&keyword=" + this.search_beneficiary)
			.then(function (response) {
				console.log(response);
				vm.beneficiaries = response.data;
			})
		},
		searchAvailableMedicine : function() {
			axios.get(this.urlRoot + this.api + "search_available_medicine_for_transaction.php?barcode=" + this.search_available_medicine)
			.then(function (response) {
				console.log(response);
				vm.available_medicines = response.data;
			});
		},
		////////////////

		// retrieve methods
		retrieveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary.php")
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
			});
		},
		retrieveCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_category.php")
			.then(function (response) {
				console.log(response);
				vm.categories = response.data;
			})
		},
		retrieveUnitCategory : function(response) {
			axios.get(this.urlRoot + this.api + "retrieve_unit_category.php")
			.then(function (response) {
				console.log(response);
				vm.unit_categories = response.data;
			});
		},
		retrieveTransaction : function() {
			axios.get(this.urlRoot + this.api + "retrieve_transaction.php")
			.then(function (response) {
				console.log(response);
				vm.save_transactions = response.data;
			});
		},
		retrieveBarangay : function() {
			axios.get(this.urlRoot + this.api + "retrieve_barangay.php")
			.then(function (response) {
				console.log(response);
				vm.barangays = response.data;
			});
		},
		retrieveTransactionDetails : function(beneficiary_id) {
			axios.get(this.urlRoot + this.api + "retrieve_transaction_details.php?beneficiary_id=" + beneficiary_id)
			.then(function (response) {
				console.log(response);
				vm.transaction_details = response.data;
			})
		},
		retrievePurchaseReceivedDetails : function() {
			axios.get(this.urlRoot + this.api + "retrieve_purchase_received_details.php")
			.then(function (response) {
				console.log(response);
				vm.purchase_received_details = response.data;
			});
		},
		retrieveCivilStatus : function() {
			axios.get(this.urlRoot + this.api + "retrieve_civil_status.php")
			.then(function (response) {
				console.log(response);
				vm.civil_status = response.data;
			});
		},
		retrieveBeneficiaryType : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary_type.php")
			.then(function (response) {
				console.log(response);
				vm.beneficiary_type = response.data;
			});
		},
		// generate id's
		generateTransactionID : function() {
    		var id = "";
    		var pad = "0000";
    		var date = new Date();


    		if(this.save_transactions.length <= 0) {
    			id = "TRANS" + date.getFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + "0001";
    		}
    		else {
    			for(var index = 0; index < this.save_transactions.length; index++) {

    				id = this.save_transactions[index].transaction_id;
    			}
	    		id = id.slice(13);
	    		id = pad.substring(0, pad.length - id.length) + id;
	    		id = date.getFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + id;
	    		id = parseInt(id) + 1;
	    		id = "TRANS" + id;
	    	}
	    	return id;
	    },

	    // validation methods
	    firstInputQuantityValidation : function() {
	    	if(this.checkUniqueMedicineId() == true) {
	    		if(parseInt(this.transaction_quantity) < parseInt(this.purchase_transaction.quantity)) {
	    			
	    			this.input_quantity_error = true;
	    			this.input_quantity_error_description = "Purchase quantity cannot be more than stock!";
	    		}
	    		else {
	    			this.transactions.push({...this.purchase_transaction});
					$('#myModal3').modal('hide');
					this.clearData();
	    		}
	    	}
	    	else {
	    		this.checkUniqueTransaction();
	    	}
	    },
	    checkUniqueMedicineId : function() {
	    	var found = true;
	    	for(var index = 0; index < this.transactions.length; index++) {
	    		if(this.purchase_transaction.id == this.transactions[index].id) {
	    			found = false;
	    		}
	    	}
	    	return found;
	    },
	    checkUniqueTransaction : function() {
	    	for(var index = 0; index < this.transactions.length; index++) {
    			if(this.purchase_transaction.id == this.transactions[index].id) {
    				var total_quantity = parseInt(this.purchase_transaction.quantity) + parseInt(this.transactions[index].quantity);

    				if(parseInt(this.transaction_quantity) < parseInt(total_quantity)) {
    					this.input_quantity_error = true;
	    				this.input_quantity_error_description = "Purchase quantity cannot be more than stock!";
    				}
    				else {
    					var total_amount = parseFloat(total_quantity) * parseFloat(this.transactions[index].price);
    					this.transactions[index].quantity = total_quantity;
    					this.transactions[index].total = total_amount;

    					$('#myModal3').modal('hide');

    					this.clearData();
    				}
    			}
    		}
	    },


	    // receipt method
	    createReceipt : function() {
	    	for(var index = 0; index < this.transactions.length; index++) {
	    		this.transaction_receipt.id = this.transactions[index].id;
	    		this.transaction_receipt.medicine_name = this.transactions[index].name;
	    		this.transaction_receipt.category = this.transactions[index].category;
	    		this.transaction_receipt.unit_category = this.transactions[index].unit_category;
	    		this.transaction_receipt.price = this.transactions[index].price;
	    		this.transaction_receipt.quantity = this.transactions[index].quantity;
	    		this.transaction_receipt.total_amount = this.transactions[index].total;

	    		this.receipts.push({...this.transaction_receipt});
	    		console.log(this.receipts)
	    	}
	    },
	    beneficiaryInfoToReceipt : function(beneficiary_id) {
	    	for(var index = 0; index < this.beneficiaries.length; index++) {
	    		if(beneficiary_id == this.beneficiaries[index].beneficiary_id) {
	    			this.receipt_first_name = this.beneficiaries[index].first_name;
	    			this.receipt_last_name = this.beneficiaries[index].last_name;
	    			this.receipt_address = this.beneficiaries[index].address;
	    			this.receipt_contact_no = this.beneficiaries[index].contact_no;
	    		}
	    	}
	    },
	    


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
				if(this.identifyBeneficiaryBalance(this.beneficiary_id) >= 10000) {
					swal({
						title : "Error!",
						text : "You used your 10,000 worth of medicine!",
						icon : "error",
						timer : "3000",
						buttons : false,
						closeOnClickOutside: false
					});
				}
				else {
					this.addTransaction();
				}
			}
		},
		addTransactionButton : function(received_order_details_id, purchase_received_details_id, quantity) {
			this.transaction_medicine_id = received_order_details_id;
			this.transaction_medicine_name = this.identifyMedicineName(purchase_received_details_id);
			this.transaction_quantity = quantity;
			this.transaction_medicine_price = this.identifyMedicinePrice(purchase_received_details_id);
			this.transaction_medicine_category = this.identifyCategoryName(purchase_received_details_id);
			this.transaction_medicine_unit_category = this.identifyUnitCategoryName(purchase_received_details_id);
		},
		addTransactionToCart : function() {
			if(this.input_quantity == '') {
				this.input_quantity_error = true;
				this.input_quantity_error_description = "This field is required!";
			}
			else if(this.input_quantity <= 0) {
				this.input_quantity_error = true;
				this.input_quantity_error_description = "Invalid input!";
			}
			else {
				var total_amount = parseFloat(this.transaction_medicine_price) * parseFloat(this.input_quantity);

				this.purchase_transaction.id = this.transaction_medicine_id;
				this.purchase_transaction.name = this.transaction_medicine_name;
				this.purchase_transaction.quantity = this.input_quantity;
				this.purchase_transaction.price = this.transaction_medicine_price;
				this.purchase_transaction.category = this.transaction_medicine_category;
				this.purchase_transaction.unit_category = this.transaction_medicine_unit_category;
				this.purchase_transaction.total = total_amount;

				this.firstInputQuantityValidation();
			}

		},
		removeTransactionToCart : function(index) {
      		this.transactions.splice(index, 1);
    	},
    	addTransaction : function() {
    		var date = new Date();
    		axios.post(this.urlRoot + this.api + "add_transaction.php", {
    			transaction_id : this.generateTransactionID(),
    			beneficiary_id : this.beneficiary_id,
    			transaction_date : date.getUTCFullYear() + "-" + this.str_pad(date.getMonth() + 1) + "-" + this.str_pad(date.getDate())
    		}).then(function (response) {
    			vm.addTransactionDetails();
    			console.log(response);
    		});
    	},
    	addTransactionDetails : function() {
    		axios.post(this.urlRoot + this.api + "add_transaction_details.php", {
    			transactions : this.transactions
    		}).then(function (response) {
    			console.log(response);
    			vm.updateBeneficiary();
    		});
    	},
    	updateBeneficiary : function() {
    		axios.post(this.urlRoot + this.api + "update_beneficiary.php", {
    			beneficiary_id : this.beneficiary_id,
    			beneficiary_balance : this.beneficiary_balance,
    			beneficiaries : this.beneficiaries,
    			transactions : this.transactions
    		}).then(function (response) {
    			console.log(response);
    			vm.updateReceivedOrder();
    			
    		});
    	},
    	updateReceivedOrder : function() {
    		axios.post(this.urlRoot + this.api + "update_received_order_details.php", {
    			transactions : this.transactions,
    			available_medicines : this.available_medicines
    		}).then(function (response) {
    			console.log(response);

    			swal({
					title : "Good Job!",
					text : "Transaction save successfully!",
					icon : "success",
					timer : "3000",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveBeneficiary();
	    			vm.retrieveAvailableMedicine();
	    			vm.createReceipt();
					vm.beneficiaryInfoToReceipt(vm.beneficiary_id);
					vm.show_transaction = false;
					vm.show_receipt = true;
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
    	totalPages: function() {
	    	return Math.ceil(this.beneficiaries.length / this.show_entries)
	   	},
	   	totalPages_two: function() {
	    	return Math.ceil(this.available_medicines.length / this.show_entries)
	   	},
    	totalAmountInCart : function() {
			var total = 0;
			for(var index = 0; index < this.transactions.length; index++) {
				total += parseFloat(this.transactions[index].total);
			}
			return total;
		},
		remainingBalance: function() {
	   		let total = 10000;
	   		let balance = 0;
	   		let remainingBalance = this.beneficiary_balance;
	   		for (var i = 0; i < this.transactions.length; i++) {
				balance += (parseFloat(this.transactions[i].total));
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
	   	totalBeneficiaryTransaction : function() { //sa beneficiary.php nakalagay
			var total = 0;
			for(var index = 0; index < this.transaction_details.length; index++) {
				total += parseFloat(this.transaction_details[index].total_price);
			}
			return total;
		},
		totalBeneficiaryRemainingBalance : function() {
			let total = 10000;
	   		let balance = 0;
	   		for (var i = 0; i < this.transaction_details.length; i++) {
				balance += (parseFloat(this.transaction_details[i].total_price));
			}
			return total = (parseFloat(total) - parseFloat(balance));
		},
    },
	created() {
		this.retrieveBeneficiary();
		this.retrieveAvailableMedicine();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrieveTransaction();
		this.retrieveBarangay();
		this.retrievePurchaseReceivedDetails();
		this.retrieveTransactionDetails();
		this.retrieveCivilStatus();
		this.retrieveBeneficiaryType();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})