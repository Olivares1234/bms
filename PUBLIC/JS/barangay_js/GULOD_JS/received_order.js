var vm = new Vue({
	el : "#vue-received-order",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/gulod_api/",

		// titles
		view_Order : "View Order",

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		send_order_info : true,
		search_send_order : "",

		search_send_order_details : "",

		accept_order_details : false,

		send_order_using_id : [],

		received_order_details : [],

		send_details : [],

		received_order_quantity : "",
		received_order_expiration_date : "",

		received_order_quantity_error : false,
		received_order_expiration_date_error : false,

		received_orders : [],

		send_order_id : "",

		medicines : [],
	},
	methods : {
		//received order clear data
		clearReceivedOrder : function() {
			this.received_order_quantity = "";
			this.received_order_expiration_date = "";

			this.received_order_quantity_error = false;
			this.received_order_expiration_date_error = false;
		},

		//received order validation
		addReceivedOrderValidation : function() {
			if(this.received_order_quantity == "") {
				this.received_order_quantity_error = true;
			}
			else {
				this.received_order_quantity_error = false;
			}

			if(this.received_order_expiration_date == "") {
				this.received_order_expiration_date_error = true;
			}
			else {
				this.received_order_expiration_date_error = false;
			}
		},

		// input type
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
		nextSendOrderDetails : function() {
	      if (this.currentPage < this.totalSendOrderDetails) {
	        this.pagination(this.currentPage + 1);
	      }
	    },
	    nextSendOrder : function() {
			if (this.currentPage < this.totalSendOrder) {
	        this.pagination(this.currentPage + 1);
	      }
		},
		previous: function() {
	      if (this.currentPage > 1) {
	        this.pagination(this.currentPage - 1);
	      }

	    },

		// search methods
		searchSendOrder : function() {
    		axios.get(this.urlRoot + this.api + "search_send_order.php?keyword=" + this.search_send_order)
    		.then(function (response) {
    			vm.send_order_using_id = response.data;
				console.log(response);
    		});
    	},
    	searchSendOrderDetails : function() {
    		axios.get(this.urlRoot + this.api + "search_send_order_details.php?keyword=" + this.search_send_order_details)
    		.then(function (response) {
    			vm.send_details = response.data;
				console.log(response);
    		});
    	},

    	// retrieve methods
    	retrieveSendOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_send_order.php")
			.then(function (response) {
				vm.send_order_using_id = response.data;
			});
		},
		retrieveSendDetails : function(send_order_id) {
			axios.get(this.urlRoot + this.api + "retrieve_send_details.php?send_order_id=" + send_order_id)
			.then(function (response) {
				vm.send_details = response.data;
			});
		},
		retrieveReceivedOrderDetails : function(send_order_id, supplier_medicine_id) {
			axios.post(this.urlRoot + this.api + "retrieve_received_order_details.php?send_order_id=" + send_order_id + "&supplier_medicine_id=" + supplier_medicine_id)
			.then(function (response) {
				vm.received_order_details = response.data;
				console.log(response);
			});
		},
		retrieveReceivedOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_received_order.php")
			.then(function (response) {
				vm.received_orders = response.data;
			});
		},
		retrieveMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_medicine.php")
			.then(function (response) {
				vm.medicines = response.data;
				console.log(response);
			});
		},

		// toggle buttons
		toggleRequestOrderDetailsInfo : function(id) {
			if (this.send_order_info == false) {
				this.send_order_info = true;
			} else {
				this.send_order_info = false;
			}

			this.send_order_id = id;

			this.retrieveSendDetails(id);
		},
		closeAddReceivedOrder : function() {
			this.received_order_quantity = "";
			this.received_order_expiration_date = "";
			$('#myModal3').modal('hide');
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

		// generate id
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

		/////
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

			this.addReceivedOrderValidation();

			if(this.received_order_quantity != "" && this.received_order_expiration_date != "") {
				axios.post(this.urlRoot + this.api + "add_received_order_details.php", {
					supplier_medicine_id : this.received_order_supplier_medicine_id,
					quantity : this.received_order_quantity,
					expiration_date : this.received_order_expiration_date
				}).then(function (response) {
					console.log(response);
					if(response.status == 200) {
						vm.updateSendDetails();
						vm.clearReceivedOrder();

						vm.received_order_quantity_error = false;
						vm.received_order_expiration_date_error = false;

						$('#myModal3').modal('hide');
					}
					else {
						vm.received_order_quantity_error = response.data.received_order_quantity_error;
						vm.received_order_expiration_date_error = response.data.received_order_expiration_date_error;
					}
				});
			}
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
	},
	created() {
		this.retrieveSendOrder();
		this.retrieveReceivedOrder();
		this.retrieveMedicine();
	}
})