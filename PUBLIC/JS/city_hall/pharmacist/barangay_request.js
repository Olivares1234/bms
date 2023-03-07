var vm = new Vue({
	el : "#vue-barangay-request",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/pharmacist/",



		request_order_info  : true,
		request_order_medicine_info : false,
		request_order_receipt : false,
		request_receipt_history : false,

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		suplier_medicines : [],
		categories : [],
		unit_categories : [],

		request_orders : [],
		request_order_id : "",
		purchase_received_details_id : "",

		send_order_details : [],

		request_details : [],

		send_orders : [],

		request_order_barangay_name : "",
		request_order_contact_number : "",

		send_quantity : "",
		send_quantity_error : false,

		medicines : [],
		available_medicines : [],

		filter : "",
		search_request_order : "",
		search_status : "",

		filter : "",
		search_request_order : "",

		search_request_order_status : "",

		filter_two : "",
		search_request_order_details : ""
	},
	methods : {
		str_pad : function(n) {
			return String("00" + n).slice(-2);
		},
		////////////////////
		showEntries : function(value) {
         	this.endIndex = value;
         	this.pagination(1);
		},
		pagination : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries) - this.show_entries;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries);
		},

		// clear data 
		clearRequestQuantity : function() {
			this.send_quantity = "";

			this.send_quantity_error = false;

			$('#myModal').modal('hide');
			$('#myModal1').modal('hide');
		},
		///////////////

		// toggle button
		toggleRequestOrderDetailsInfo : function(id) {
			if(this.request_order_medicine_info == false) {
				this.request_order_medicine_info = true;
				this.request_order_receipt = false;
				this.request_order_info = false;
				this.request_receipt_history = false;
			}
			else {
				this.request_order_medicine_info = false;
				this.request_order_info = true;
			}

			this.request_order_id = id;

			this.retrieveSendOrderDetails(id);

		},
		toggleRequestOrderReceeipt : function() {
			if(this.request_order_receipt == false) {
				this.request_order_receipt = true;
				this.request_order_medicine_info = false;
				this.request_order_info = false;
				this.request_receipt_history = false;
			} 
			else {
				this.request_order_receipt = false;

			}
		},
		toggleRequestOrderInfo : function(id, barangay_name, contact_no, status) {
			if(status == "Completed") {
				swal({
					title: "Error!",
					text : "This request already completed!",
					icon: "error",
					buttons : false,
					timer : 1000,
					closeOnClickOutside: false
				});
			}
			else {
				if(this.request_order_info == true) {
					this.request_order_info = false;
					this.request_order_receipt = false;
					this.request_order_medicine_info = false;
					this.request_receipt_history = false;
				}
				else {
					this.request_order_info = true;
					this.request_order_receipt = false;
					this.request_order_medicine_info = false;
					this.request_receipt_history = false;
				}

				this.request_order_id = id;
				this.request_order_barangay_name = barangay_name;
				this.request_order_contact_number = contact_no;
				this.retrieveRequestDetails(id);
			}
		},
		deliverModal : function(purchase_received_details_id, delivered_quantity) {
    		if (delivered_quantity != 0) {
    			swal("Error", "This field is already sent!", "error");
    		}
    		else {

    			if(this.checkSupplierMedicine(purchase_received_details_id) == false) {
    				this.purchase_received_details_id = purchase_received_details_id;
    				$('#myModal').modal('show');
    			}
    			else {
					swal({
						title: "Out of stock",
						icon: "warning",
						buttons : "Ok",
						dangerMode : true,
						closeOnClickOutside: false
					})
					.then((setStatus) => {
						if (setStatus) {
							for(var index = 0; index < this.request_details.length; index++) {
									if(!this.request_details[index].no_stock) {
										Vue.set(this.request_details[index], 'no_stock', false);
									}
							}

							for(var index = 0; index < this.request_details.length; index++) {
								if(purchase_received_details_id == this.request_details[index].purchase_received_details_id) {
									this.request_details[index].no_stock = true;
									//Vue.set(this.request_details[index]);
								}
							}
						}
					});
    			}    			
    		}
    	},
    	updateDeliverModal : function(purchase_received_details_id, delivered_quantity) {
    		this.purchase_received_details_id = purchase_received_details_id;
    		this.send_quantity = delivered_quantity;

    		$('#myModal1').modal('show');
    	},
    	toggleReceiptHistory : function(id, barangay_name, contact_no) {
			if(this.request_receipt_history == false) {
				this.request_receipt_history = true;
				this.request_order_medicine_info = false;
				this.request_order_info = false;
				this.request_order_receipt = false;
			} 
			else {
				this.request_receipt_history = false;
				this.request_order_info = true;
				this.request_order_medicine_info = false;
			}
			this.request_order_id = id;
			this.request_order_barangay_name = barangay_name;
			this.request_order_contact_number = contact_no;
			this.retrieveRequestDetails(id);
		},
		////////////////

		// identify methods
		identifySendOrderID : function(request_order_id) {
			for(var index = 0; index < this.send_orders.length; index++) {
				if (request_order_id == this.send_orders[index].request_order_id) {
					return this.send_orders[index].send_order_id;
				}
			}
		},
		identifyRequestOrdersBarangayId : function(request_order_id) {
			for(var index = 0; index < this.request_orders.length; index++) {
				if(request_order_id == this.request_orders[index].request_order_id) {
					return this.request_orders[index].barangay_id;
				}
			}
		},
		identifySendOrderID : function(request_order_id) {
			for(var index=0; index < this.send_orders.length; index++) {
				if (request_order_id == this.send_orders[index].request_order_id) {
					return this.send_orders[index].send_order_id;
				}
			}
		},
		identifyMedicineName : function(purchase_received_details_id) {
			for(var index = 0; index < this.medicines.length; index++) {
				for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
					if(purchase_received_details_id == this.medicines[index].purchase_received_details_id) {
						if(this.medicines[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
							return this.supplier_medicines[index1].medicine_name;
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
								if(this.supplier_medicines[index1].category_id == this.categories[index2].category_id)
								return this.categories[index2].description;
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
								if(this.supplier_medicines[index1].unit_category_id == this.unit_categories[index2].unit_category_id)
								return this.unit_categories[index2].unit;
							}
						}
					}
				}
			}
		},
		identifyMedicinePrice : function(purchase_received_details_id) {
			for(var index = 0; index < this.medicines.length; index++) {
				for(var index1 = 0; index1 < this.supplier_medicines.length; index1++) {
					if(purchase_received_details_id == this.medicines[index].purchase_received_details_id) {
						if(this.medicines[index].supplier_medicine_id == this.supplier_medicines[index1].supplier_medicine_id) {
							return this.supplier_medicines[index1].price;
						}
					}
				}
			}
		},
		////////////////////

		// validation method
		checkSupplierMedicine : function(purchase_received_details_id) {
    		for(var index = 0; index < this.available_medicines.length; index++){
    			if(purchase_received_details_id == this.available_medicines[index].purchase_received_details_id) {
    				return false;
    				
    			}
    		}
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
    	/////////////////////

		// retrieve methods
		retrieveRequestOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_request_order.php")
			.then(function (response) {
				vm.request_orders = response.data;
			})

		},
		retrieveSendOrderDetails : function(request_order_id) {
			axios.get(this.urlRoot + this.api + "retrieve_send_order_details.php?request_order_id=" + request_order_id)
			.then(function (response) {
				vm.send_order_details = response.data;
				console.log(response);
			});
		},
		retrieveRequestDetails : function(request_order_id) {
    		axios.get(this.urlRoot + this.api + "retrieve_request_details.php?request_order_id=" + request_order_id)
    		.then(function (response) {
    			console.log(response);
    			vm.request_details = response.data;
    		});
    	},
    	retrieveSendOrder : function() {
    		axios.get(this.urlRoot + this.api + "retrieve_send_order.php")
    		.then(function (response) {
    			vm.send_orders = response.data;
    			console.log(response);
    		});
    	},
    	retrieveAvailableMedicine : function() {
    		axios.get(this.urlRoot + this.api + "retrieve_available_medicine.php")
    		.then(function (response) {
    			console.log(response);
    			vm.available_medicines = response.data;
    		})
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
		retrieveMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_all_city_hall_medicine.php")
			.then(function (response) {
				console.log(response);
				vm.medicines = response.data;
			});
		},
		///////////////////


		generateSendOrderId : function() {
    		var  id = "";
			var pad = "0000";
			var date = new Date();

			if(this.send_orders.length == 0) {
				id = "SO" +  date.getUTCFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + "0001";
			}
			else {
				for(var index = 0; index < this.send_orders.length; index++) {
					id = this.send_orders[index].send_order_id;
				}

				id = id.slice(10);
				id = pad.substring(0, pad.length - id.length) + id;
				id = date.getUTCFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + id;
				id = parseInt(id) + 1;
				id = "SO" + id;
			}
			return id;
    	},
    	//////////////////////////
    	addSendOrder : function() {
    		var date = new Date();

    		axios.post(this.urlRoot + this.api + "add_send_order.php", {
    			send_order_id : this.generateSendOrderId(),
    			date_send : date.getFullYear() + "-" + this.str_pad(date.getMonth() + 1) + "-" + this.str_pad(date.getDate()),
    			request_order_id : this.request_order_id,
    			barangay_id : this.identifyRequestOrdersBarangayId(this.request_order_id)
    		}).then(function (response) {
    			console.log(response);
    			vm.addSendOrderDetails();
    		});
    	},
    	addSendOrderDetails : function() {
    		axios.post(this.urlRoot + this.api + "add_send_order_details.php", {
    			request_details : this.request_details
    		}).then(function (response) {
    			console.log(response);
    			vm.updateRequestDetails();
    		})
    	},
    	updateRequestDetails : function() {
    		axios.post(this.urlRoot + this.api + "update_request_details.php", {
    			request_details : this.request_details
    		}).then(function (response) {
    			console.log(response);
    			vm.updateRequestOrder();
    		});
		},
		updateRequestOrder : function() {
			axios.post(this.urlRoot + this.api + "update_request_order.php", {
				request_order_id : this.request_order_id
			}).then(function (response) {
				console.log(response);
				vm.addSendDetails();
				
			});
		},
		addSendDetails : function() {
			axios.post(this.urlRoot + this.api + "add_send_details.php", {
				request_details : this.request_details
			}).then(function (response) {
				console.log(response);
				vm.updatePurchaseReceivedDetails();
			});
		},
		updatePurchaseReceivedDetails : function() {
			axios.post(this.urlRoot + this.api + "update_purchase_received_details.php", {
				request_details : this.request_details,
				available_medicines : this.available_medicines
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Success!",
					text : "Send order successfully!",
					icon : "success",
					buttons : false,
					timer : 1000,
					closeOnClickOutside : false
				}).then(() => {
					vm.toggleRequestOrderReceeipt();
				});
			})
		},
		addApproveQuantity : function() {
			if(this.send_quantity.trim() == "") {
				this.send_quantity_error = true;
			}
			else {
				this.send_quantity_error = true;
				for(var index = 0; index < this.available_medicines.length; index++) {
					for(var index1 = 0; index1 < this.request_details.length; index1++) {
						if(this.purchase_received_details_id == this.available_medicines[index].purchase_received_details_id) {
							if(this.available_medicines[index].purchase_received_details_id == this.request_details[index1].purchase_received_details_id){
								if(parseInt(this.send_quantity) > parseInt(this.available_medicines[index].received_quantity)) {
									swal("Error!", " Approved quantity cannot be more than the stock quantity!", "error");
									$('#myModal').modal('show');
								}
								else {
									this.request_details[index1].delivered_quantity = this.send_quantity;
									$('#myModal').modal('hide');
									this.clearRequestQuantity();
								}
							}
						}
					}
				}
			}
			
		},
		updateApprovedQuantity : function() {
			if(this.send_quantity.trim() == "") {
				this.send_quantity_error = true;
			}
			else {
				this.send_quantity_error = true;
				for(var index = 0; index < this.available_medicines.length; index++) {
					for(var index1 = 0; index1 < this.request_details.length; index1++) {
						if(this.purchase_received_details_id == this.available_medicines[index].purchase_received_details_id) {
							if(this.available_medicines[index].purchase_received_details_id == this.request_details[index1].purchase_received_details_id){
								if(parseInt(this.send_quantity) > parseInt(this.available_medicines[index].received_quantity)) {
									swal("Error!", " Approved quantity cannot be more than the stock quantity!", "error");
									$('#myModal1').modal('show');
								}
								else {
									this.request_details[index1].delivered_quantity = this.send_quantity;
									$('#myModal1').modal('hide');
									this.clearRequestQuantity();
								}
							}
						}
					}
				}
			}
		},
		searchRequestOrder : function(filter, keyword) {
			axios.get(this.urlRoot + this.api + "search_request_order.php?filter=" + this.filter + "&keyword=" + this.search_request_order)
			.then(function (response) {
				console.log(response);
				vm.request_orders = response.data;
			})
		},
		searchRequestOrderStatus : function(filter, keyword) {
			axios.get(this.urlRoot + this.api + "search_request_order.php?filter=" + this.filter + "&keyword=" + this.search_request_order_status)
			.then(function (response) {
				console.log(response);
				vm.request_orders = response.data;
			})
			this.search_request_order = ""
		},
		searchRequestOrderDetails : function(request_order_id, filter, keyword) {
			axios.get(this.urlRoot + this.api + "search_request_order_details.php?request_order_id=" + this.request_order_id + "&filter=" + this.filter_two + "&keyword=" + this.search_request_order_details)
			.then(function (response) {
				console.log(response);
				vm.request_details = response.data;
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
      },
      stock(value) {
      	if(value == 0) {
      		return "No Stock";
      	} else {
      		return value;
      	}
      }
    },
    computed : {
    	totalAmount: function() {
	    	let totalAmount = 0;
	    	for(let i = 0; i < this.request_details.length; i++){
	    		if(this.request_details[i].delivered_quantity == "Out of stock") {
	    			this.request_details[i].delivered_quantity = 0;
	    		}
	    		totalAmount += (parseFloat(this.identifyMedicinePrice(this.request_details[i].purchase_received_details_id)) * (parseFloat(this.request_details[i].delivered_quantity)));
	      	}
	      	return totalAmount;
	    }
    },
	created() {
		this.retrieveSendOrder();
		this.retrieveRequestOrder();
		this.retrieveAvailableMedicine();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrieveMedicine();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
});