var vm = new Vue({
	el : "#vue-supplier",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/admin/",

		// titles
		deactivate_supplier : "Deactivate Supplier",
		activate_supplier : "Activate Supplier",
		add_Supplier : "Add Supplier",

		add_Medicine : "Add Medicine",
		view_Medicine : "View Medicine",

		add_Supplier : "Add Supplier",
		update_Supplier : "Update Supplier",

		update_Medicine : "Update Medicine",
		/////////

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		supplier_list : true,
		add_supplier : false,
		update_supplier : false,
		supplier_medicine_list : false,

		suppliers : [],
		supplier_medicines : [],
		supplier_all_medicines : [],
		unit_categories : [],
		categories : [],

		add_medicine : {
			medicine_name : null,
			category : null,
			unit_category : null,
			price : null,
		},

		supplier_medicine_id : "",
		supplier_id : "",

		supplier_name : "",
		supplier_address : "",
		supplier_contact_no : "",
		supplier_status : "",

		supplier_medicine_name : "",
		supplier_medicine_category : "",
		supplier_medicine_unit_category : "",
		supplier_medicine_price : "",


		supplier_name_error : false,
		supplier_address_error : false,
		supplier_contact_no_error : false,
		supplier_status_error : false,

		supplier_medicine_name_error : false,
		supplier_medicine_category_error : false,
		supplier_medicine_unit_category_error : false,
		supplier_medicine_price_error : false,

		filter : "",
		search_supplier : ""
	},
	methods : {
		str_pad : function(n) {
 			return String("00" + n).slice(-2);
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
		// validation method
		onlyForCurrency($event) {
	       let keyCode = ($event.keyCode ? $event.keyCode : $event.which);

	       if ((keyCode < 48 || keyCode > 57) && (keyCode !== 46 || this.supplier_medicine_price.indexOf('.') != -1)) { // 46 is dot
	        	$event.preventDefault();
	       }

	       if(this.supplier_medicine_price!=null && this.supplier_medicine_price.indexOf(".") > -1 && (this.supplier_medicine_price.split('.')[1].length > 1)){
	       		$event.preventDefault();
	   		}
     	},
     	supplierValidation : function() {
     		if(this.supplier_name.trim() == "") {
     			this.supplier_name_error = true;
     		}
     		else {
     			this.supplier_name_error = false;
     		}

     		if(this.supplier_address.trim() == "") {
     			this.supplier_address_error = true;
     		}
     		else {
     			this.supplier_address_error = false;
     		}

     		if(this.supplier_contact_no.trim() == "") {
     			this.supplier_contact_no_error = true;
     		}
     		else {
     			this.supplier_contact_no_error = false;
     		}
     	},
     	supplierContactNoValidation : function() {
     		if(this.supplier_contact_no.length != 11) {
     			this.supplier_contact_no_error = true;
     		}
     	},
     	supplierMedicineValidation : function() {
     		if(this.supplier_medicine_name.trim() == "") {
     			this.supplier_medicine_name_error = true;
     		}
     		else {
     			this.supplier_medicine_name_error = false;
     		}

     		if(this.supplier_medicine_category.trim() == "") {
     			this.supplier_medicine_category_error = true;
     		}
     		else {
     			this.supplier_medicine_category_error = false;
     		}

     		if(this.supplier_medicine_unit_category.trim() == "") {
     			this.supplier_medicine_unit_category_error = true;
     		}
     		else {
     			this.supplier_medicine_unit_category_error = false;
     		}

     		if(this.supplier_medicine_price.trim() == "") {
     			this.supplier_medicine_price_error = true;
     		}
     		else {
     			this.supplier_medicine_price_error = false;
     		}
     	},
     	checkSupplierInput : function() {
     		if(this.supplier_name.trim() != "" && this.supplier_address.trim() != "" && this.supplier_contact_no != "") {
     			return true;
     		}
     	},
     	checkSupplierMedicineInput : function() {
     		if(this.supplier_medicine_name != "" && this.supplier_medicine_category != "" && this.supplier_medicine_unit_category != "" && this.supplier_medicine_price != "") {
     			return true;
     		}
     	},
     	checkSupplierIfExist : function() {
     		for(var index = 0; index < this.suppliers.length; index++) {
     			if(this.supplier_name.toLowerCase() == this.suppliers[index].supplier_name.toLowerCase() || this.supplier_address.toLowerCase() == this.suppliers[index].supplier_address.toLowerCase() || this.supplier_contact_no == this.suppliers[index].supplier_contact_no) {
     				return true;
     			}
     		}
     	},
     	checkUpdateSupplierIfExist : function(supplier_id) {
     		for(var index = 0; index < this.suppliers.length; index++) {
     			if(supplier_id != this.suppliers[index].supplier_id) {
     				if(this.supplier_name.toLowerCase() == this.suppliers[index].supplier_name.toLowerCase() || this.supplier_address.toLowerCase() == this.suppliers[index].supplier_address.toLowerCase() || this.supplier_contact_no == this.suppliers[index].supplier_contact_no) {
     					return true;
     				}
     			}		
     		}
     	},
     	checkSupplierMedicineIfExist : function() {
     		for(var index = 0; index < this.supplier_medicines.length; index++) {
     			if(this.supplier_medicine_name.toLowerCase() == this.supplier_medicines[index].medicine_name.toLowerCase() && this.supplier_medicine_category.toLowerCase() == this.identifyMedicineCategory(this.supplier_medicines[index].category_id).toLowerCase() && this.supplier_medicine_unit_category.toLowerCase() == this.identifyMedicineUnitCategory(this.supplier_medicines[index].unit_category_id).toLowerCase() && this.supplier_medicine_price == this.supplier_medicines[index].price) {
     				return true;
     			}
     		}
     	},
     	checkUpdateSupplierMedicineIfExist : function(supplier_medicine_id) {
     		for(var index = 0; index < this.supplier_medicines.length; index++) {
     			if(supplier_medicine_id != this.supplier_medicines[index].supplier_medicine_id) {
     				if(this.supplier_medicine_name.toLowerCase() == this.supplier_medicines[index].medicine_name.toLowerCase() && this.supplier_medicine_category.toLowerCase() == this.identifyMedicineCategory(this.supplier_medicines[index].category_id).toLowerCase() && this.supplier_medicine_unit_category.toLowerCase() == this.identifyMedicineUnitCategory(this.supplier_medicines[index].unit_category_id).toLowerCase() && this.supplier_medicine_price == this.supplier_medicines[index].price) {
     					return true;
     				}
     			}
     		}
     	},
		//////////////////

		// default
		supplierDefault : function() {
			this.supplier_name = "";
			this.supplier_address = "";
			this.supplier_contact_no = "";
		},
		supplierErrorDefault : function() {
			this.supplier_name_error = false;
			this.supplier_address_error = false;
			this.supplier_contact_no_error = false;
		},
		supplierMedicineDefault : function() {
			this.supplier_medicine_name = "";
			this.supplier_medicine_category = "";
			this.supplier_medicine_unit_category = "";
			this.supplier_medicine_price = "";
		},
		supplierMedicineErrorDefault : function() {
			this.supplier_medicine_name_error = false;
			this.supplier_medicine_category_error = false;
			this.supplier_medicine_unit_category_error = false;
			this.supplier_medicine_price_error = false;
		},
		//////////

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
	    nextSupplier: function() {
	      if (this.currentPage < this.totalSupplier) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    ///////////////////////

	    // identify method
	    identifySupplier : function(supplier_id) {
	    	for(var index = 0; index < this.suppliers.length; index++) {
	    		if(supplier_id == this.suppliers[index].supplier_id) {
	    			this.supplier_name = this.suppliers[index].supplier_name;
	    			this.supplier_address = this.suppliers[index].supplier_address;
	    			this.supplier_contact_no = this.suppliers[index].supplier_contact_no
	    			this.supplier_status = this.suppliers[index].supplier_status;
	    		}
	    	}
	    },
	    identifyMedicineCategory : function(category_id) {
			for(var index = 0; index < this.categories.length; index++) {
				if(category_id == this.categories[index].category_id) {
					return this.categories[index].description;
				}
			}
		},
		identifyMedicineUnitCategory : function(unit_category_id) {
			for(var index = 0; index < this.unit_categories.length; index++) {
				if(unit_category_id == this.unit_categories[index].unit_category_id) {
					return this.unit_categories[index].unit;
				}
			}
		},
		identifyCategoryId : function(category_name) {
			for(var index = 0; index < this.categories.length; index++) {
				if(category_name == this.categories[index].description) {
					return this.categories[index].category_id;
				}
			}
		},
		identifyUnitCategoryId : function(unit_category) {
			for(var index = 0; index < this.unit_categories.length; index++) {
				if(unit_category == this.unit_categories[index].unit) {
					return this.unit_categories[index].unit_category_id;
				}
			}
		},
		identifySupplierMedicine : function(supplier_medicine_id) {
			for(var index = 0; index < this.supplier_medicines.length; index++) {
				if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
					this.supplier_medicine_name = this.supplier_medicines[index].medicine_name;
					this.supplier_medicine_category = this.identifyMedicineCategory(this.supplier_medicines[index].category_id);
					this.supplier_medicine_unit_category = this.identifyMedicineUnitCategory(this.supplier_medicines[index].unit_category_id);
					this.supplier_medicine_price = this.supplier_medicines[index].price;
				}
			}
		},
	    //////////////////
 
	    // toggle button
	    toggleAddSupplier : function() {
	    	if(this.supplier_list == true) {
	    		this.supplier_list = false;
	    		this.add_supplier = true;
	    	}
	    	else {
	    		this.supplier_list = true;
	    		this.add_supplier = false;

	    		this.supplierDefault();
	    		this.supplierErrorDefault();
	    	}
	    },
	    toggleUpdateSupplier : function(supplier_id) {
	    	if(this.supplier_list == true) {
	    		this.supplier_list = false;
	    		this.update_supplier = true;

	    		this.identifySupplier(supplier_id);
	    		this.supplier_id = supplier_id;
	    	}
	    	else {
	    		this.supplier_list = true;
	    		this.update_supplier = false;

	    		this.supplierDefault();
	    		this.supplierErrorDefault();
	    	}
	    },
	    toggleSupplierInfo : function(supplier_id) {
	    	if(this.supplier_list == true) {
	    		this.supplier_list = false;
	    		this.supplier_medicine_list = true;

	    		this.retrieveSupplierMedicine(supplier_id);
	    		this.supplier_id = supplier_id;
	    	}
	    	else {
	    		this.supplier_list = true;
	    		this.supplier_medicine_list = false;
	    	}
	    },
	    toggleAddSupplierMedicine : function() {
	    	this.supplierMedicineDefault();
	    	this.supplierMedicineErrorDefault();
	    	$('#myModal2').modal('show');
	    },
	    toggleUpdateSupplierMedicine : function(supplier_medicine_id) {
	    	$('#myModal1').modal('show');
	    	this.identifySupplierMedicine(supplier_medicine_id);
	    	this.supplier_medicine_id = supplier_medicine_id;
	    },
	    toggleDeactivateSupplier : function(supplier_id) {
	    	$('#myModal3').modal('show');
	    	this.supplier_id = supplier_id;
	    },
	    toggleActivateSupplier : function(supplier_id) {
	    	$('#myModal4').modal('show');
	    	this.supplier_id = supplier_id;
	    },
	    toggleCloseAddSupplierMedicine : function() {
	    	this.supplierMedicineDefault();
	    	this.supplierMedicineErrorDefault();
	    	$('#myModal2').modal('hide');
	    },
	    ////////////////

	    // retrieve method
	    retrieveSupplier : function() {
			axios.get(this.urlRoot + this.api + "retrieve_supplier.php")
			.then(function (response) {
				console.log(response);
				vm.suppliers = response.data;
			});
		},
		retrieveSupplierMedicine : function(supplier_id) {
			axios.get(this.urlRoot + this.api + "retrieve_supplier_medicine.php?supplier_id=" + supplier_id)
			.then(function (response) {
				vm.supplier_medicines = response.data;
				console.log(response);
			});
		},
		retrieveAllSupplierMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_all_supplier_medicine.php")
			.then(function (response) {
				vm.supplier_all_medicines = response.data;
				console.log(response);
			});
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
	    //////////////////
	    addSupplier : function() {
	    	this.supplierValidation();
	    	this.supplierContactNoValidation();

	    	if(this.checkSupplierInput() == true) {
	    		if(this.checkSupplierIfExist() == true) {
	    			swal({
	    				title : "Error!",
	    				text : "Supplier already exist!",
	    				icon : "error",
	    				buttons : false,
	    				closeOnClickOutside : false,
	    				timer : 1050
	    			});
	    		}
	    		else {
	    			axios.post(this.urlRoot + this.api + "add_supplier.php", {
		    			supplier_name : this.supplier_name,
		    			supplier_address : this.supplier_address,
		    			supplier_contact_no : this.supplier_contact_no,
		    			supplier_status : "Active"

		    		}).then(function(response) {
		    			console.log(response);
		    			if(response.status == 200) {
		    				swal({
			    				title : "Good Job!",
			    				text : "Add supplier successfully!",
			    				icon : "success",
			    				buttons : false,
			    				closeOnClickOutside : false,
			    				timer : 2000
			    			}).then(() => {
			    				vm.supplierDefault();
					    		vm.supplierErrorDefault();
					    		vm.retrieveSupplier();
			    			});
		    			}
		    			else {
		    				vm.supplier_name_error = response.data.supplier_name_error;
		    				vm.supplier_address_error = response.data.supplier_address_error;
		    				vm.supplier_contact_no_error = response.data.supplier_contact_no_error;
		    			}
		    		});
	    		}
	    	}
	    },
	    updateSupplier : function() {
	    	this.supplierValidation();
	    	this.supplierContactNoValidation();

	    	if(this.checkSupplierInput() == true) {
	    		if(this.checkUpdateSupplierIfExist(this.supplier_id) == true) {
	    			swal({
	    				title : "Error!",
	    				text : "Supplier already exist!",
	    				icon : "error",
	    				buttons : false,
	    				closeOnClickOutside : false,
	    				timer : 1050
	    			});
	    		}
	    		else {
	    			axios.post(this.urlRoot + this.api + "update_supplier.php", {
		    			supplier_id : this.supplier_id,
		    			supplier_name : this.supplier_name,
		    			supplier_address : this.supplier_address,
		    			supplier_contact_no : this.supplier_contact_no,
		    			supplier_status : "Active"

		    		}).then(function(response) {
		    			console.log(response);
		    			if(response.status == 200) {
		    				swal({
			    				title : "Good Job!",
			    				text : "Update supplier successfully!",
			    				icon : "success",
			    				buttons : false,
			    				closeOnClickOutside : false,
			    				timer : 2000
			    			}).then(() => {
			    				vm.supplierDefault();
					    		vm.supplierErrorDefault();
					    		vm.retrieveSupplier();
			    			});
		    			}
		    			else {
		    				vm.supplier_name_error = response.data.supplier_name_error;
		    				vm.supplier_address_error = response.data.supplier_address_error;
		    				vm.supplier_contact_no_error = response.data.supplier_contact_no_error;
		    			}
		    		});
	    		}
	    	}
	    },
	    addSupplierMedicine : function() {
	    	this.supplierMedicineValidation();

	    	if(this.checkSupplierMedicineInput() == true) {
	    		if(this.checkSupplierMedicineIfExist() == true) {
	    			swal({
	    				title : "Error!",
	    				text : "Medicine already exist!",
	    				icon : "error",
	    				buttons : false,
	    				closeOnClickOutside : false,
	    				timer : 1050
	    			});
	    		}
	    		else {
	    			axios.post(this.urlRoot + this.api + "add_supplier_medicine.php", {
			    		medicine_name : this.supplier_medicine_name,
			    		category_id : this.identifyCategoryId(this.supplier_medicine_category),
			    		unit_category_id : this.identifyUnitCategoryId(this.supplier_medicine_unit_category),
			    		price : this.supplier_medicine_price,
			    		supplier_id : this.supplier_id
			    	}).then(function (response) {
			    		console.log(response);
			    		if(response.status == 200) {
			    			swal({
			    				title : "Good Job!",
			    				text : "Add medicine successfully!",
			    				icon : "success",
			    				buttons : false,
			    				closeOnClickOutside : false,
			    				timer : 2000
			    			}).then(() => {
			    				vm.retrieveSupplierMedicine(vm.supplier_id);
					    		vm.supplierMedicineDefault();
					    		vm.supplierMedicineErrorDefault();
					    		$('#myModal2').modal('hide');
			    			});
			    		}
			    		else {
			    			vm.supplier_medicine_name_error = response.data.supplier_medicine_name_error;
			    			vm.supplier_medicine_category_error = response.data.supplier_medicine_category_error;
			    			vm.supplier_medicine_unit_category_error = response.data.supplier_medicine_unit_category_error;
			    			vm.supplier_medicine_price_error = response.data.supplier_medicine_price_error;
			    		}
			    	});
	    		}
	    	}	
	    },
	    updateSupplierMedicine : function() {
	    	this.supplierMedicineValidation();

	    	if(this.checkSupplierMedicineInput() == true) {
	    		if(this.checkUpdateSupplierMedicineIfExist() == true) {
	    			swal({
	    				title : "Error!",
	    				text : "Medicine already exist!",
	    				icon : "error",
	    				buttons : false,
	    				closeOnClickOutside : false,
	    				timer : 1050
	    			});
	    		}
	    		else {
	    			axios.post(this.urlRoot + this.api + "update_supplier_medicine.php", {
			    		supplier_medicine_id : this.supplier_medicine_id,
			    		medicine_name : this.supplier_medicine_name,
			    		category_id : this.identifyCategoryId(this.supplier_medicine_category),
			    		unit_category_id : this.identifyUnitCategoryId(this.supplier_medicine_unit_category),
			    		price : this.supplier_medicine_price,
			    		supplier_id : this.supplier_id
			    	}).then(function (response) {
			    		console.log(response);
			    		if(response.status == 200) {
			    			swal({
			    				title : "Good Job!",
			    				text : "Update medicine successfully!",
			    				icon : "success",
			    				buttons : false,
			    				closeOnClickOutside : false,
			    				timer : 2000
			    			}).then(() => {
			    				vm.retrieveSupplierMedicine(vm.supplier_id);
					    		vm.supplierMedicineDefault();
					    		vm.supplierMedicineErrorDefault();
					    		$('#myModal1').modal('hide');
			    			});
			    		}
			    		else {
			    			vm.supplier_medicine_name_error = response.data.supplier_medicine_name_error;
			    			vm.supplier_medicine_category_error = response.data.supplier_medicine_category_error;
			    			vm.supplier_medicine_unit_category_error = response.data.supplier_medicine_unit_category_error;
			    			vm.supplier_medicine_price_error = response.data.supplier_medicine_price_error;
			    		}
			    	});
	    		}
	    	}
	    },
	    deactivateSupplier : function() {
	    	axios.post(this.urlRoot + this.api + "deactivate_supplier.php",{
	    		supplier_id : this.supplier_id
	    	}).then(function (response) {
	    		console.log(response);
	    		swal({
					title : "Success!",
					text : "User deactivate successfully!",
					icon : "success",
					timer : "1000",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveSupplier();
	 				vm.supplierDefault();
	 				vm.supplierErrorDefault();
	 				$('#myModal3').modal('hide');
				});
	    	});
	    },
	    activateSupplier : function() {
	    	axios.post(this.urlRoot + this.api + "activate_supplier.php",{
	    		supplier_id : this.supplier_id
	    	}).then(function (response) {
	    		console.log(response);
	    		swal({
					title : "Success!",
					text : "User activate successfully!",
					icon : "success",
					timer : "1000",
					buttons : false,
					closeOnClickOutside: false
				}).then(() => {
					vm.retrieveSupplier();
	 				vm.supplierDefault();
	 				vm.supplierErrorDefault();
	 				$('#myModal4').modal('hide');
				});
	    	});
	    },
		searchSupplier : function() {
				axios.get(this.urlRoot + this.api + "search_supplier.php?filter=" + this.filter + "&keyword=" + this.search_supplier)
				.then(function (response) {
					console.log(response);
					vm.suppliers = response.data;
				})
			},
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
	created() {
		this.retrieveSupplier();
		this.retrieveUnitCategory();
		this.retrieveCategory();
		this.retrieveAllSupplierMedicine();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})