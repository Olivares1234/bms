var vm = new Vue({ 
	el : "#vue-return-medicine",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/barangay/health_worker/",

		// titles
		add_return : "Add Return Medicine",
		view_return : "View Return Details",
		create_Return : "Create Return Medicine",

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		transaction_list : true,
		transaction_details_list : false,
		return_medicine_details_list : false,

		transactions : [],
		transaction_details : [],
		received_order_details : [],
		supplier_medicines : [],
		categories : [],
		unit_categories : [],
		purchase_received_details : [],
		return_medicines : [],
		beneficiaries : [],
		return_medicine_details : [],


		filter : "",
		search_transaction : "",
		search_transaction_details : "",

		received_order_details_id : "",
		quantity : "",

		return_medicine_quantity : "",
		return_medicine_quantity_error : false,
		return_medicine_quantity_description : "",

		return_medicine_remarks : "",
		return_medicine_remarks_error : false,

		beneficiary_id : "",
		transaction_id : "",

		search_user : "",
		filter : ""

	},
	methods : {
		str_pad : function(n) {
 			return String("00" + n).slice(-2);
		},
		// validation method
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
		returnMedicineValidation : function() {
			if(this.return_medicine_quantity.trim() == '') {
				this.return_medicine_quantity_error = true;
				this.return_medicine_quantity_description = "This field is required!";
			}
			else {
				this.return_medicine_quantity_error = false;
				this.return_medicine_quantity_description = "";
			}

			if(this.return_medicine_remarks.trim() == "") {
				this.return_medicine_remarks_error = true;
			}
			else {
				this.return_medicine_remarks_error = false;
			}
		},
		////////////////////
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
		showEntries_two : function(value) {
         	this.endIndex = value;
         	this.pagination_two(1);
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
	    previous: function() {
	      if (this.currentPage > 1) {
	        this.pagination(this.currentPage - 1);
	      }

	    },
	    next_two: function() {
	      if (this.currentPage < this.totalPages_twp) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
		//////////////

		// clear data
		clearReturnMedicineData : function() {
			this.return_medicine_quantity = "";
			this.return_medicine_remarks = "";

			this.return_medicine_quantity_error = false;
			this.return_medicine_remarks_error = false;
		},
		//////////////

		// toggle button
		toggleTransactionDetails : function(transaction_id, beneficiary_id) {
			if(this.transaction_list == true) {
				this.transaction_list = false;
				this.transaction_details_list = true;


				this.beneficiary_id = beneficiary_id;
				this.transaction_id = transaction_id;
				this.retrieveTransactionDetails(transaction_id);
			}
			else {
				this.transaction_list = true;
				this.transaction_details_list = false;
			}
		},
		toggleAddReturnMedicine : function(received_order_details_id, quantity) {
			if(quantity == 0) {
				swal("Error!", " No medicine to return!", "error");
			}
			else {
				this.received_order_details_id = received_order_details_id;
				this.quantity = quantity;
				$('#myModal').modal('show');
			}
		},
		toggleReturnDetails : function(transaction_id) {
			if(this.transaction_list == true) {
				this.transaction_list = false;
				this.return_medicine_details_list = true;

				this.retrieveReturnMedicineDetails(transaction_id);
			}
			else {
				this.transaction_list = true;
				this.return_medicine_details_list = false;
			}
		},
		////////////////

		// search methods
		searchTransaction : function() {
			axios.get(this.urlRoot + this.api + "search_transaction_for_return.php?transaction_id=" + this.search_transaction)
			.then(function (response) {
				vm.transactions = response.data;
				console.log(response);
			});
		},
		searchTransactionDetails : function() {
			axios.get(this.urlRoot + this.api + "search_transaction_details_for_return.php?transaction_id=" + this.transaction_id + "&filter=" + this.filter + "&keyword=" + this.search_transaction_details)
			.then(function (response) {
				vm.transaction_details = response.data;
				console.log(response);
			});
		},
		/////////////////

		// identify method
		identifyMedicineName : function(received_order_details_id) {
			for(var index = 0; index < this.received_order_details.length; index++) {
				for(var index1 = 0; index1 < this.purchase_received_details.length; index1++) {
					for(var index2 = 0; index2 < this.supplier_medicines.length; index2++) {
						if(received_order_details_id == this.received_order_details[index].received_order_details_id) {
							if(this.received_order_details[index].purchase_received_details_id == this.purchase_received_details[index1].purchase_received_details_id) {
								if(this.purchase_received_details[index1].supplier_medicine_id == this.supplier_medicines[index2].supplier_medicine_id) {
									return this.supplier_medicines[index2].medicine_name;
								}
							}
						}
					}
				}
			}
		},
		identifyCategoryName : function(received_order_details_id) {
			for(var index = 0; index < this.received_order_details.length; index++) {
				for(var index1 = 0; index1 < this.purchase_received_details.length; index1++) {
					for(var index2 = 0; index2 < this.supplier_medicines.length; index2++) {
						for(var index3 = 0; index3 < this.categories.length; index3++) {
							if(received_order_details_id == this.received_order_details[index].received_order_details_id) {
								if(this.received_order_details[index].purchase_received_details_id == this.purchase_received_details[index1].purchase_received_details_id) {
									if(this.purchase_received_details[index1].supplier_medicine_id == this.supplier_medicines[index2].supplier_medicine_id) {
										if(this.supplier_medicines[index2].category_id == this.categories[index3].category_id) {
											return this.categories[index3].description;
										}
									}
								}
							}
						}
						
					}
				}
			}
		},
		identifyUnitCategoryName : function(received_order_details_id) {
			for(var index = 0; index < this.received_order_details.length; index++) {
				for(var index1 = 0; index1 < this.purchase_received_details.length; index1++) {
					for(var index2 = 0; index2 < this.supplier_medicines.length; index2++) {
						for(var index3 = 0; index3 < this.unit_categories.length; index3++) {
							if(received_order_details_id == this.received_order_details[index].received_order_details_id) {
								if(this.received_order_details[index].purchase_received_details_id == this.purchase_received_details[index1].purchase_received_details_id) {
									if(this.purchase_received_details[index1].supplier_medicine_id == this.supplier_medicines[index2].supplier_medicine_id) {
										if(this.supplier_medicines[index2].unit_category_id == this.unit_categories[index3].unit_category_id) {
											return this.unit_categories[index3].unit;
										}
									}
								}
							}
						}
						
					}
				}
			}
		},
		identifyMedicinePrice : function(received_order_details_id) {
			for(var index = 0; index < this.received_order_details.length; index++) {
				for(var index1 = 0; index1 < this.purchase_received_details.length; index1++) {
					for(var index2 = 0; index2 < this.supplier_medicines.length; index2++) {
						if(received_order_details_id == this.received_order_details[index].received_order_details_id) {
							if(this.received_order_details[index].purchase_received_details_id == this.purchase_received_details[index1].purchase_received_details_id) {
								if(this.purchase_received_details[index1].supplier_medicine_id == this.supplier_medicines[index2].supplier_medicine_id) {
									return this.supplier_medicines[index2].price;
								}
							}
						}
					}
				}
			}
		},
		//////////////////

		// retrieve method
		retrieveTransaction : function() {
			axios.get(this.urlRoot + this.api + "retrieve_transaction_for_return_medicine.php")
			.then(function (response) {
				vm.transactions = response.data;
				console.log(response);
			});
		},
		retrieveTransactionDetails : function(transaction_id) {
			axios.get(this.urlRoot + this.api + "retrieve_transaction_details_for_return_medicine.php?transaction_id=" + transaction_id)
			.then(function (response) {
				vm.transaction_details = response.data;
				console.log(response);
			});
		},
		retrieveReceivedOrderDetails : function() {
			axios.get(this.urlRoot + this.api + "retrieve_barangay_received_order_details.php")
			.then(function (response) {
				vm.received_order_details = response.data;
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
		retrievePurchaseReceivedDetails : function() {
			axios.get(this.urlRoot + this.api + "retrieve_purchase_received_details.php")
			.then(function (response) {
				console.log(response);
				vm.purchase_received_details = response.data;
			});
		},
		retrieveReturnMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_return_medicine.php")
			.then(function (response) {
				console.log(response);
				vm.return_medicines = response.data;
			});
		},
		retrieveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary.php")
			.then(function (response) {
				vm.beneficiaries = response.data;
				console.log(response);
			});
		},
		retrieveReturnMedicineDetails : function(transaction_id) {
			axios.get(this.urlRoot + this.api + "retrieve_return_medicine_details.php?transaction_id=" + transaction_id)
			.then(function (response) {
				vm.return_medicine_details = response.data;
				console.log(response);
			});
		},
		///////////////////

		// generate id
		generateReturnMedicineId : function() {
			var id = "";
    		var pad = "0000";
    		var date = new Date();

    		if(this.return_medicines.length <= 0) {
    			id = "RM" + date.getFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + "0001";
    		}
    		else {
    			for(var index = 0; index < this.return_medicines.length; index++) {

    				id = this.return_medicines[index].return_medicine_id;
    			}
	    		id = id.slice(10);
	    		id = pad.substring(0, pad.length - id.length) + id;
	    		id = date.getFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + id;
	    		id = parseInt(id) + 1;
	    		id = "RM" + id;
	    	}

	    	return id;
		},
		//////////////
		saveReturnMedicine : function() {
			this.returnMedicineValidation();

			if(this.return_medicine_quantity_error == false && this.return_medicine_remarks_error == false) {
				if(parseInt(this.return_medicine_quantity) > parseInt(this.quantity)) {
					this.return_medicine_quantity_error = true;
					this.return_medicine_quantity_description = "Return medicine quantity cannot be more than transact quantity!";
				}
				else {
					this.return_medicine_quantity_error = false;
					this.return_medicine_quantity_description = "";

					this.addReturnMedicine();
				}
			}
		},

		///////////////
		addReturnMedicine : function() {
			var date = new Date();
			axios.post(this.urlRoot + this.api + "add_return_medicine.php", {
				return_medicine_id : this.generateReturnMedicineId(),
				beneficiary_id : this.beneficiary_id,
				transaction_id : this.transaction_id,
				date_return : date.getFullYear() + "-" + this.str_pad(date.getMonth() + 1) + "-" + this.str_pad(date.getDate())
			}).then(function (response) {
				console.log(response);
				vm.addReturnMedicineDetails();
			});
		},
		addReturnMedicineDetails : function() {
			axios.post(this.urlRoot + this.api + "add_return_medicine_details.php",{
				received_order_details_id : this.received_order_details_id,
				quantity : this.return_medicine_quantity,
				total_amount : parseFloat(this.identifyMedicinePrice(this.received_order_details_id)) * this.return_medicine_quantity,
				remarks : this.return_medicine_remarks
			}).then(function (response) {
				console.log(response);
				if(response.status == 200) {
					vm.return_medicine_quantity_error = false;
					vm.return_medicine_remarks_error = false;
					vm.updateTransactionDetails();
				}
				else {
					vm.return_medicine_quantity_error = response.data.return_medicine_quantity_error;
					vm.return_medicine_remarks_error = response.data.return_medicine_remarks_error;
				}
			});
		},
		updateTransactionDetails : function() {
			axios.post(this.urlRoot + this.api + "update_transaction_details.php", {
				transaction_details : this.transaction_details,
				transaction_id : this.transaction_id,
				received_order_details_id : this.received_order_details_id,
				quantity : this.return_medicine_quantity
			}).then(function (response) {
				console.log(response);
				vm.updateBeneficiaryBalance();
			})
		},
		updateBeneficiaryBalance : function() {
			axios.post(this.urlRoot + this.api + "update_beneficiary_balance.php", {
				price : this.identifyMedicinePrice(this.received_order_details_id),
				beneficiaries : this.beneficiaries,
				beneficiary_id : this.beneficiary_id,
				quantity : this.return_medicine_quantity
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Good Job!",
					text : " Return medicine successfully!",
					icon : "success",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveTransactionDetails(vm.transaction_id);
					vm.clearReturnMedicineData();
					$('#myModal').modal('hide');
				});
			})
		},
		searchReturnMedicine : function(filter, keyword, transaction_id) {
			axios.get(this.urlRoot + this.api + "search_transaction_details_for_return.php?filter=" + this.filter + "&keyword=" + this.search_user + "&transaction_id=" + this.transaction_id)
			.then(function (response) {
				console.log(response);
				vm.transaction_details = response.data;
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
	    	return Math.ceil(this.transactions.length / this.show_entries)
	   	},
	   	totalPages_two: function() {
	    	return Math.ceil(this.transaction_details.length / this.show_entries)
	   	},
	   	totalAmountInCart : function() {
			var total = 0;
			for(var index = 0; index < this.return_medicine_details.length; index++) {
				total += parseFloat(this.return_medicine_details[index].total_amount);
			}
			return total;
		},
	},
	created() {
		this.retrieveTransaction();
		this.retrieveReceivedOrderDetails();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrievePurchaseReceivedDetails();
		this.retrieveReturnMedicine();
		this.retrieveBeneficiary();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})