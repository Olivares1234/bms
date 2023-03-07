var vm = new Vue({
	el : "#vue-pharmacist",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/pharmacist_api/",

		// errors //
		category_description_error : false,

		unit_category_unit_error : false,
		///////////

		// titles ///
		add_Category : "Add Category",
		update_Category : "Update Category",

		add_Unit : "Add Unit Category",
		update_Unit : "Update Unit Category",

		view_Medicine : "View Medicine",

		view_Order : "View Order",
		/////////////

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		////// end of pagination /////////

		medicines : [],

		categories : [],
		search_category : "",
		category_id : "",
		category_description : "",

		unit_categories : [],
		search_unit_category : "",
		unit_category_id : "",
		unit_category_unit : "",

		gulod_available_medicine : true,
		gulod_medicine_info : false,

		search_medicine : "",

		purchase_received_info : false,

		purchase_received_medicine_info : false,

		search_purchase_ordered : "",

		purchase_order_using_id : [],

		purchase_order_id : "",

		purchase_details : [],
		search_purchase_details : "",

		purchase_received_details : [],
		purchase_received_quantity : "",
		purchase_received_expiration_date : "",

		received_quantity_error : false,
		expiration_date_error : false,

		purchase_received : [],

	},
	methods : {
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
		nextPurchaseOrder: function() {
	    	if (this.currentPage < this.totalPurchaseOrder) {
	        	this.pagination(this.currentPage + 1);
	      }
	    },
		nextUnitCategory: function() {
	      if (this.currentPage < this.totalUnitCategory) {
	        this.pagination(this.currentPage + 1);
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
		showEntries : function(value) {
         	this.endIndex = value;
         	this.pagination(1);
		},
		nextCategory: function() {
	      if (this.currentPage < this.totalCategory) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
		isLetter(event) {
          	if (!(event.key.toLowerCase() >= 'a' && event.key.toLowerCase() <= 'z' || event.key == ' '))
                event.preventDefault();
        },
		retrieveMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_medicine.php")
			.then(function (response) {
				vm.medicines = response.data;
			})
		},
		countMedicine : function() {
			var count = 0;
			for(var index = 0; index < this.medicines.length; index++){
				count++;
			}
			return count;
		},
		retrieveCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_category.php")
			.then(function (response) {
				vm.categories = response.data;
			});
		},
		countCategory : function() {
			var count_category = 0
			for(var index = 0; index < this.categories.length; index++){
				count_category++;
			}

			return count_category;
		},
		searchCategory : function() {
			axios.get(this.urlRoot + this.api + "search_category.php?keyword=" + this.search_category)
			.then(function (response) {
				vm.categories = response.data;
			})
		},
		addCategory : function() {
			if(this.category_description == "") {
				this.category_description_error = true;
			}
			else {
				this.category_description_error = false;
			}

			if(this.category_description != '') {
				axios.post(this.urlRoot + this.api + "add_category.php", {
					description : this.category_description
				}).then(function (response) {
					if(response.status == 200) {
						vm.retrieveCategory();
						swal("Congrats!", " New category added!", "success");	

						vm.category_description = false;

						$('#myModal').modal('hide');
					} else {
						vm.category_description_error = response.data.category_description_error;
					}
				});
			}
		},
		updateCategoryButton : function(category_id,category_description) {
			this.category_id = category_id;
			this.category_description = category_description;
		},
		updateCategory : function() {
			if(this.category_id == "") {
				this.category_id_error = true;
			}
			else {
				this.category_id_error = false;
			}

			if(this.category_description == "") {
				this.category_description_error = true;
			}
			else {
				this.category_description_error = false;
			}

			if(this.category_id != '' && this.category_description != '') {
				axios.post(this.urlRoot + this.api + "update_category.php", {
					category_id : this.category_id,
					description : this.category_description
				}).then(function (response) {
					if(response.data.status == "OK") {
						vm.retrieveCategory();
						swal("Congrats!", " Update category successfully!", "success");	

						vm.category_description_error = false;

						$('#myModal1').modal('hide');
					} else {
						vm.category_description_error = response.data.category_description_error;
					}
				});
			}
		},
		retrieveUnitCategory : function() {
			axios.get(this.urlRoot + this.api + "retrieve_unit_category.php")
			.then(function (response) {
				vm.unit_categories = response.data;
			})
		},
		countUnitCategory : function() {
			var count = 0;
			for(var index = 0; index < this.unit_categories.length; index++) {
				count++;
			}
			return count;
		},
		searchUnitCategory : function() {
			axios.get(this.urlRoot + this.api + "search_unit_category.php?keyword=" + this.search_unit_category)
			.then(function (response) {
				vm.unit_categories = response.data;
			});
		},
		addUnitCategory : function() {
			if(this.unit_category_unit == "") {
				this.unit_category_unit_error = true;
			}
			else {
				this.unit_category_unit_error = false;
			}

			if(this.unit_category_unit != '') {
				axios.post(this.urlRoot + this.api + "add_unit_category.php", {
					unit : this.unit_category_unit
				}).then(function (response) {
					if(response.status == 200) {
						vm.retrieveUnitCategory();
						swal("Congrats!", " New unit category added!", "success");	
						vm.unit_category_unit = false;
						$('#myModal').modal('hide');
					} else {
						vm.unit_category_unit_error = response.data.unit_category_unit_error;
					}
				});
			}
		},
		updateUnitCategoryButton : function(unit_category_id,unit_category_unit) {
			this.unit_category_id = unit_category_id;
			this.unit_category_unit = unit_category_unit;
		},
		updateUnitCategory : function() {
			if(this.unit_category_id == "") {
				this.unit_category_id_error = true;
			}
			else {
				this.unit_category_id_error = false;
			}
			if(this.unit_category_unit == "") {
				this.unit_category_unit_error = true;
			}
			else {
				this.unit_category_unit_error = false;
			}

			if(this.unit_category_id != '' && this.unit_category_unit != '') {
				axios.post(this.urlRoot + this.api + "update_unit_category.php", {
					unit_category_id : this.unit_category_id,
					unit : this.unit_category_unit
				}).then(function (response) {
					if (response.data.status == "OK") {
						vm.retrieveUnitCategory();
						swal("Congrats!", " Update category successfully!", "success");	

						vm.unit_category_id = false;
						vm.unit_category_unit = false;

						$('#myModal1').modal('hide');
					} else {
						vm.unit_category_id_error = response.data.unit_category_id_error;
						vm.unit_category_unit_error = response.data.unit_category_unit_error;
					}
				});
			}
		},
		searchMedicine : function() {
			axios.get(this.urlRoot + this.api + "search_medicine.php?keyword=" + this.search_medicine)
			.then(function (response) {
				vm.medicines = response.data;
			});
		},
		toggleMedicineInfo : function(id, name, price, category, unit_category, quantity, supplier) {
			if(this.gulod_medicine_info == false) {
				this.gulod_medicine_info = true;
				this.gulod_available_medicine = false;
			}
			else {
				this.gulod_medicine_info = false;
				this.gulod_available_medicine = true;
			}

			this.gulod_medicine_info_id = id;
			this.gulod_medicine_info_name = name;
			this.gulod_medicine_info_price = price;
			this.gulod_medicine_info_category = category;
			this.gulod_medicine_info_category_unit = unit_category;
			this.gulod_medicine_info_quantity = quantity;
			this.gulod_medicine_info_supplier = supplier;
		},
		retrievePurchaseOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_purchase_order.php")
			.then(function (response) {
				vm.purchase_order_using_id = response.data;
			});
		},
		searchPurchasedOrdered : function() {
			axios.get(this.urlRoot + this.api + "search_purchased_ordered.php?purchase_order_id=" + this.search_purchased_ordered)
			.then(function (response) {
				vm.purchase_order_using_id = response.data;
			});
		},
		toggleReceivedOrderInfo : function(id) {
			if(this.purchase_received_info == false) {
				this.purchase_received_info = true;
			}
			else {
				this.purchase_received_info = false;
			} 

			this.purchase_order_id = id;


			this.retrievePurchaseDetails(this.purchase_order_id);


			// this.retrievePurchaseMedicine();
		},
		retrievePurchaseDetails : function(purchase_order_id) {
			axios.get(this.urlRoot + this.api + "retrieve_purchase_details.php?purchase_order_id=" + purchase_order_id)
			.then(function (response) {
				vm.purchase_details = response.data;
			});
		},
		searchPurchaseDetails : function() {
			axios.get(this.urlRoot + this.api + "search_purchase_details.php?purchase_order_id=" + this.purchase_order_id + "&search_purchase_details=" + this.search_purchase_details)
			.then(function (response) {
				vm.purchase_details = response.data;
			});
		},
		toggleReceivedOrderMedicineInfo : function(id, medicine_id, medicine_name, price, category, unit, quantity, supplier_name) {

			if(this.purchase_received_info == false) {
				this.purchase_received_info = true;
			}
			else {
				this.purchase_received_info = false;
			}

			if(this.purchase_received_medicine_info == false) {
				this.purchase_received_medicine_info = true;
			}
			else {
				this.purchase_received_medicine_info = false;
			}

			this.purchase_order_id = id;

			this.purchase_order_received_medicine_id = medicine_id;
			this.purchase_order_received_medicine_name = medicine_name;
			this.purchase_order_received_price = price;
			this.purchase_order_received_category = category;
			this.purchase_order_received_unit = unit;
			this.purchase_order_received_quantity = quantity;
			this.purchase_order_received_supplier = supplier_name;

			this.retrievePurchaseDetails(this.purchase_order_id);

			this.retrievePurchaseReceivedDetails(id, medicine_id);
		},
		retrievePurchaseReceivedDetails : function(purchase_order_id, supplier_medicine_id) {

			axios.get(this.urlRoot + this.api + "retrieve_purchase_received_details.php?purchase_order_id=" + purchase_order_id + "&supplier_medicine_id=" + supplier_medicine_id)
			.then(function (response) {
				vm.purchase_received_details = response.data;
			});
		},
		addPurchaseReceivedButton : function(id, order_quantity, supplier_medicine_id, received_quantity) {
    		this.purchase_received_purchase_order_id = id;
    		this.purchase_received_order_quantity = order_quantity;
    		this.purchase_order_received_medicine_id = supplier_medicine_id;

    		if(order_quantity == received_quantity) {
    			swal("Error!", " Purchase received completed!", "error");
    		}
    		else {
    			$('#myModal3').modal('show');
    		}
    	},
    	// clear data //
    	closePurchasReceivedModal : function() {
    		this.purchase_received_quantity = "";
    		this.purchase_received_expiration_date = "";
    		this.received_quantity_error = false;
			this.expiration_date_error = false;
    		$("#myModal3").modal("hide");
    	},
    	////////////////////
    	retrievePurchaseReceived : function() {
    		axios.get(this.urlRoot + this.api + "retrieve_purchase_received.php")
    		.then(function (response) {
    			vm.purchase_received = response.data;
    		});
		},
    	generatePurchaseReceivedID : function() {
			var id = "";
			var pad = "0000";

			var date = new Date();

			if(this.purchase_received.length == 0) {
				id = "PR" + date.getUTCFullYear() + "0001";
			}
			else {
				for(var index = 0; index < this.purchase_received.length; index++) {
					id = this.purchase_received[index].purchase_received_id;
				}
				id = id.slice(6);
				id = pad.substring(0, pad.length - id.length) + id;
				id = date.getUTCFullYear() + id;
				id = parseInt(id) + 1;
				id = "PR" + id;
			}
			return id;
		},
    	addPurchaseReceived : function() {
			var date = new Date();
			var year = date.getFullYear();
			var month = date.getMonth() + 1;
			var day = date.getDate();

			axios.post(this.urlRoot + this.api + "add_purchase_received.php", {
				purchase_received_id : this.generatePurchaseReceivedID(),
				user_id : "",
				date_received : year + "-" + month + "-" + day,
				purchase_order_id : this.purchase_order_id
			}).then(function (response) {
				vm.addPurchaseReceivedDetails();
			});		
		},
		addPurchaseReceivedDetails : function() {
			axios.post(this.urlRoot + this.api + "add_purchase_received_details.php", {
				supplier_medicine_id : this.purchase_order_received_medicine_id,
				received_quantity : this.purchase_received_quantity,
				expiration_date : this.purchase_received_expiration_date
			}).then( function (response) {
				vm.updatePurchaseReceivedMedicine();
			})
		},
		updatePurchaseDetails : function() {
			for(var index  = 0; index < this.purchase_details.length; index++) {
				if(this.purchase_received_purchase_order_id == this.purchase_details[index].purchase_order_id) {
					if(this.purchase_order_received_medicine_id == this.purchase_details[index].supplier_medicine_id) {
						this.purchase_received_quantity = parseInt(this.purchase_received_quantity) + parseInt(this.purchase_details[index].received_quantity);
						
 
						axios.post(this.urlRoot + this.api + "update_purchase_details.php", {
							purchase_details_id : this.purchase_details[index].purchase_details_id,
							purchase_order_id : this.purchase_details[index].purchase_order_id,
							supplier_medicine_id : this.purchase_details[index].supplier_medicine_id,
							quantity : this.purchase_details[index].quantity,
							received_quantity : this.purchase_received_quantity
						}).then(function (response) {
							vm.retrievePurchaseDetails(vm.purchase_order_id);
							vm.purchase_received_quantity = "";
							vm.purchase_received_expiration_date = "";
						});
					}
				}
			}
		},
		checkNewMedicine : function() {
			for(var index = 0; index < this.medicines.length; index++) {
				if(this.purchase_order_received_medicine_id == this.medicines[index].supplier_medicine_id) {
					return false;
				}
			}
		},
		updatePurchaseReceivedMedicine : function() {
			if(this.checkNewMedicine() == false) {
				for(var index = 0; index < this.medicines.length; index++) {
					if(this.purchase_order_received_medicine_id == this.medicines[index].supplier_medicine_id) {
						this.medicines[index].quantity = parseInt(this.purchase_received_quantity) + parseInt(this.medicines[index].quantity);
						
						axios.post(this.urlRoot + this.api + "update_medicine.php", {
							medicine_id : this.medicines[index].medicine_id,
							supplier_medicine_id : this.medicines[index].supplier_medicine_id,
							quantity : this.medicines[index].quantity,
							status : this.medicines[index].status,
							barangay_id : this.medicines[index].barangay_id
						}).then(function (response) {
							vm.updatePurchaseDetails();
							swal("Success!", " Purchase received successfully!", "success");
						});
					}
				}
			}
			else {

				axios.post(this.urlRoot + this.api + "add_medicine.php", {
					supplier_medicine_id : this.purchase_order_received_medicine_id,
					quantity : this.purchase_received_quantity,
					status : "Active",
					barangay_id : "19"
				}).then(function (response) {
					vm.updatePurchaseDetails();
					swal("Success!", " New Medicine added!", "success");
				});
			}
		},
    	savePurchaseReceived : function() {
			if(this.purchase_received_quantity == '') {
				this.received_quantity_error = true;
			}
			else {
				this.received_quantity_error = false;
			}

			if(this.purchase_received_expiration_date == '') {
				this.expiration_date_error = true;
			}
			else {
				this.expiration_date_error = false;
			}


			if(this.purchase_received_quantity != "" && this.purchase_received_expiration_date != "") {
				for(var index = 0; index < this.purchase_details.length; index++) {
					if(this.purchase_order_id == this.purchase_details[index].purchase_order_id) {
						if(this.purchase_order_received_medicine_id == this.purchase_details[index].supplier_medicine_id) {
							var quantity = parseInt(this.purchase_received_quantity) + parseInt(this.purchase_details[index].received_quantity);
							if(this.purchase_received_order_quantity < quantity) {
								swal("Error!", "Received quantity cannot be more than order quantity!", "error");
							}
							else {
								this.addPurchaseReceived();
								$("#myModal3").modal("hide");
							}
						}
					}
				}
			}
		},
	},
	created() {
		this.retrieveMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrievePurchaseOrder();
		this.retrievePurchaseReceived();
	}
})