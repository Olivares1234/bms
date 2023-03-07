var vm = new Vue({
	el : "#vue-return-medicine",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/pharmacist/",

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
		create_Return : "Return Medicine",
		////////

		referral_list : true,
		referral_details_list : false,
		return_referral_medicine_details_list : false,

		referrals : [],
		referral_details : [],
		return_referrals : [],
		return_referral_details : [],
		supplier_medicines : [],
		categories : [],
		unit_categories : [],
		medicines : [],
		beneficiaries : [],

		return_medicine_quantity : 1,
		return_medicine_remarks : "",

		return_medicine_quantity_error : false,
		return_medicine_remarks_error : false,

		return_medicine_quantity_description : "",

		referral_transaction_details_id : "",
		quantity : "",

		beneficiary_id : "",
		referral_transaction_id : "",

		filter : "",
		search_return_details : "",
		search_referral_transaction : "",

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
		returnValidation : function() {
			if(this.return_medicine_quantity == '') {
				this.return_medicine_quantity_error = true;
				this.return_medicine_quantity_description = "This field is required!";
			}
			else if(this.return_medicine_quantity == 0) {
				this.return_medicine_quantity_error = true;
				this.return_medicine_quantity_description = "Invalid quantity!";
			}
			else if(parseInt(this.return_medicine_quantity) > parseInt(this.quantity)) {
				this.return_medicine_quantity_error = true;
				this.return_medicine_quantity_description = "Return medicine quantity cannot be more than transact quantity!";
			}
			else {
				this.return_medicine_quantity_error = false;
				this.return_medicine_quantity_description = "";
			}

			if(this.return_medicine_remarks == "") {
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
			this.return_medicine_quantity = 1;
			this.return_medicine_remarks = "";

			this.return_medicine_quantity_error = false;
			this.return_medicine_remarks_error = false;
		},
		/////////////

		// toggle button
		toggleReturn : function(referral_transaction_id, beneficiary_id) {
			if(this.referral_list == true) {
				this.referral_list = false;
				this.referral_details_list = true;
				this.referral_transaction_id = referral_transaction_id;
				this.beneficiary_id = beneficiary_id;
				this.retrieveReferralDetails(referral_transaction_id);
			}
			else {
				this.referral_list = true;
				this.referral_details_list = false;
			}
		},
		toggleAddReturn : function(referral_transaction_details_id, quantity) {

			if(quantity == 0) {
				swal({
					title : "Error!",
					text : " No medicine to return!",
					icon : "error",
					timer : "1050",
					buttons : false,
					closeOnClickOutside: false
				})
			}
			else {
				$('#myModal').modal('show');
				this.referral_transaction_details_id = referral_transaction_details_id;
				this.quantity = quantity;
			}
		},
		toggleViewReturnReferral : function(referral_transaction_id) {
			if(this.referral_list == true) {
				this.referral_list = false;
				this.return_referral_medicine_details_list = true;
				this.retrieveReturnReferralDetails(referral_transaction_id);
			}
			else {
				this.referral_list = true;
				this.return_referral_medicine_details_list = false;
			}
		},
		////////////////

		// identify method
		identifyMedicineName : function(purchase_received_details_id) {
			for(var index = 0; index < this.medicines.length; index++) {
				for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
					if(purchase_received_details_id == this.medicines[index].purchase_received_details_id) {
						if(this.medicines[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
							return this.supplier_medicines[index].medicine_name;
						}
					}
				}
			}
		},
		identifyCategoryName : function(purchase_received_details_id) {
			for(var index = 0; index < this.medicines.length; index++) {
				for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
					for(var index2 = 0; index2 < this.categories.length; index2++) {
						if(purchase_received_details_id == this.medicines[index].purchase_received_details_id) {
							if(this.medicines[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
								if(this.supplier_medicines[index1].category_id == this.categories[index2].category_id) {
									return this.categories[index2].description;
								}
							}
						}
					}
					
				}
			}
		},
		identifyUnitCategoryName : function(purchase_received_details_id) {
			for(var index = 0; index < this.medicines.length; index++) {
				for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
					for(var index2 = 0; index2 < this.unit_categories.length; index2++) {
						if(purchase_received_details_id == this.medicines[index].purchase_received_details_id) {
							if(this.medicines[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
								if(this.supplier_medicines[index1].unit_category_id == this.unit_categories[index2].unit_category_id) {
									return this.unit_categories[index2].unit;
								}
							}
						}
					}
					
				}
			}
		},
		//////////////////
		// generate id
		generateReturnReferralMedicineId : function() {
			var id = "";
    		var pad = "0000";
    		var date = new Date();

    		if(this.return_referrals.length <= 0) {
    			id = "RRM" + date.getFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + "0001";
    		}
    		else {
    			for(var index = 0; index < this.return_referrals.length; index++) {

    				id = this.return_referrals[index].return_referral_medicine_id;
    			}
	    		id = id.slice(11);
	    		id = pad.substring(0, pad.length - id.length) + id;
	    		id = date.getFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + id;
	    		id = parseInt(id) + 1;
	    		id = "RRM" + id;
	    	}

	    	return id;
		},
		//////////////

		// retrieve method
		retrieveReferral : function() {
			axios.get(this.urlRoot + this.api + "retrieve_referral_transaction.php")
			.then(function (response) {
				console.log(response);
				vm.referrals = response.data;
			});
		},
		retrieveReferralDetails : function(referral_transaction_id) {
			axios.get(this.urlRoot + this.api + "retrieve_referral_transaction_details.php?referral_transaction_id=" + referral_transaction_id)
			.then(function (response) {
				console.log(response);
				vm.referral_details = response.data;
			})
		},
		retrieveSupplierMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_supplier_medicine.php")
			.then(function (response) {
				console.log(response);
				vm.supplier_medicines = response.data;
			})
		},
		retrieveCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_category.php")
			.then(function (response) {
				console.log(response);
				vm.categories = response.data;
			})
		},
		retrieveUnitCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_unit_category.php")
			.then(function (response) {
				console.log(response);
				vm.unit_categories = response.data;
			})
		},
		retrieveMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_all_city_hall_medicine.php")
			.then(function (response) {
				console.log(response);
				vm.medicines = response.data;
			})
		},
		retrieveReturnReferral : function() {
			axios.get(this.urlRoot + this.api + "retrieve_return_referral_medicine.php")
			.then(function (response) {
				console.log(response);
				vm.return_referrals = response.data;
			})
		},
		retrieveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_all_beneficiary.php")
			.then(function (response) {
				console.log(response);
				vm.beneficiaries = response.data;
			})
		},
		retrieveReturnReferralDetails : function(referral_transaction_id) {
			axios.get(this.urlRoot + this.api + "retrieve_return_referral_medicine_details.php?referral_transaction_id=" + referral_transaction_id)
			.then(function (response) {
				console.log(response);
				vm.return_referral_details = response.data;
			})
			
		},
		//////////////////

		saveReturn : function() {
			this.returnValidation();

			if(this.return_medicine_quantity_error == false && this.return_medicine_remarks_error == false) {
				this.addReturn();
			}
		},
		addReturn : function() {
			var date = new Date();
			axios.post(this.urlRoot + this.api + "add_return_referral_medicine.php", {
				return_referral_medicine_id : this.generateReturnReferralMedicineId(),
				beneficiary_id : this.beneficiary_id,
				referral_transaction_id : this.referral_transaction_id,
				return_referral_date : date.getFullYear() + "-" + this.str_pad(date.getMonth() + 1) + "-" + this.str_pad(date.getDate())
			}).then(function (response) {
				console.log(response);
				vm.addReturnDetails();
			})
		},
		addReturnDetails : function() {
			axios.post(this.urlRoot + this.api + "add_return_referral_medicine_details.php", {
				quantity : this.return_medicine_quantity,
				remarks : this.return_medicine_remarks,
				referral_details : this.referral_details,
				referral_transaction_details_id : this.referral_transaction_details_id
			}).then(function (response) {
				console.log(response);
				vm.updateReferralTransactionDetails();
			})
		},
		updateReferralTransactionDetails : function() {
			axios.post(this.urlRoot + this.api + "update_referral_transaction_details.php", {
				referral_transaction_details_id : this.referral_transaction_details_id,
				quantity : this.return_medicine_quantity,
				referral_details : this.referral_details
			}).then(function (response) {
				console.log(response);
				vm.updateBeneficiaryBalance();
			})
		},
		updateBeneficiaryBalance : function() {
			axios.post(this.urlRoot + this.api + "update_beneficiary_balance_for_return.php", {
				referral_details : this.referral_details,
				referral_transaction_details_id : this.referral_transaction_details_id,
				quantity : this.return_medicine_quantity,
				beneficiary_id : this.beneficiary_id,
				beneficiaries : this.beneficiaries
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
					vm.retrieveReferralDetails(vm.referral_transaction_id);
					vm.clearReturnMedicineData();
					$('#myModal').modal('hide');
				});
			})
		},
		searcReferralTransaction : function(keyword) {
			axios.get(this.urlRoot + this.api + "search_referral_transaction.php?keyword=" + this.search_referral_transaction)
			.then(function (response) {
				vm.referrals = response.data;
				console.log(response);
			});
		}, 
		searcReferralTransactionDetails : function(referral_transaction_id, filter, keyword) {
			axios.get(this.urlRoot + this.api + "search_referral_transaction_details.php?referral_transaction_id=" + this.referral_transaction_id + "&filter=" + this.filter + "&keyword=" + this.search_return_details)
			.then(function (response) {
				vm.referral_details = response.data;
				console.log(response);
			});
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
    computed: {
    	totalAmountInCart : function() {
			var total = 0;
			for(var index = 0; index < this.return_referral_details.length; index++) {
				total += parseFloat(this.return_referral_details[index].total_amount);
			}
			return total;
		},
    },
	created() {
		this.retrieveReferral();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrieveMedicine();
		this.retrieveReturnReferral();
		this.retrieveBeneficiary();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})