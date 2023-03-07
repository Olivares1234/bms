var vm = new Vue({
	el : "#vue-return-medicine",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/gulod_api/",

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

		transaction_details_info : true,
		return_details : false,

		search_transaction : "",

		gulod_transaction : [],

		search_transaction_details : "",

		gulod_transaction_details : [],

		return_medicine_details : [],

		return_medicines : [],
		return_medicine_beneficiary_id : "",
		return_medicine_supplier_medicine_id : "",

		return_medicine_quantity : "",
		return_medicine_received_quantity : "",

		return_medicine_quantity_error : false,
		return_medicine_remarks_error : false,

		return_medicine_remarks : "",

		supplier_medicines : [],

		beneficiaries : [],
	},
	methods : {
		//return clear data
		clearReturnMedicine : function() {
			this.return_medicine_quantity = "";
			this.return_medicine_remarks = "";

			this.return_medicine_quantity_error = false;
			this.return_medicine_remarks_error = false;
		},

		//return validation
		addReturnMedicineValidation : function() {
			if(this.return_medicine_quantity == "") {
				this.return_medicine_quantity_error = true;
			}
			else {
				this.return_medicine_quantity_error = false;
			}

			if(this.return_medicine_remarks == "") {
				this.return_medicine_remarks_error = true;
			}
			else {
				this.return_medicine_remarks_error = false;
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
		showEntries_two : function(value) {
         	this.endIndex = value;
         	this.pagination_two(1);
		},
		pagination_two : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries_two) - this.show_entries_two;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries_two);
		},
		// search methods
		searchTransaction : function() {
			axios.get(this.urlRoot + this.api + "search_transaction.php?keyword=" + this.search_transaction)
			.then(function (response) {
				vm.gulod_transaction = response.data;
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

		// retrieve methods
		retrieveGulodTransactionUsingID : function() {
			axios.get(this.urlRoot + this.api + "retrieve_transaction_using_id.php")
			.then(function (response) {
				vm.gulod_transaction = response.data;
			});
		},
		retrieveGulodTransactionDetails : function(transaction_id) {
			axios.get(this.urlRoot + this.api + "retrieve_transaction_details_using_id.php?transaction_id=" + transaction_id)
			.then(function (response) {
				vm.gulod_transaction_details = response.data;
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
		retrieveSupplierMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_supplier_medicine.php")
			.then(function (response) {
				vm.supplier_medicines = response.data;
				console.log(response);
			})
		},
		retrieveReturnMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_return_medicine.php")
			.then(function (response) {
				vm.return_medicines = response.data;
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

		// toggle button
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

		//generate id
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

		////
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

			this.addReturnMedicineValidation();

			if(this.return_medicine_quantity != "" && this.return_medicine_remarks != "") {
				axios.post(this.urlRoot + this.api + "add_return_medicine_details.php", {
					supplier_medicine_id : this.return_medicine_supplier_medicine_id,
					supplier_medicines : this.supplier_medicines,
					quantity : this.return_medicine_quantity,
					remarks : this.return_medicine_remarks
				}).then(function (response) {
					console.log(response);
					if(response.status == 200) {
						vm.updateTransaction();
						vm.clearReturnMedicine();

						vm.return_medicine_quantity_error = false;
						vm.return_medicine_remarks_error = false;

						$('#myModal').modal('hide');
					}
					else {
						vm.return_medicine_quantity_error = response.data.return_medicine_quantity_error;
						vm.return_medicine_remarks_error = response.data.return_medicine_remarks_error;
					}
				});
			}
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
				beneficiaries : this.beneficiaries,
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
			}
		},
	},
	created() {
		this.retrieveGulodTransactionUsingID();
		this.retrieveReturnMedicine();
		this.retrieveSupplierMedicine();
		this.retrieveBeneficiary();
	}
})