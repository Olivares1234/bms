var vm = new Vue({
	el : "#vue-request-order",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/barangay/admin/",

		//titles
		add_Medicine : "Add Medicine",
		view_Medicine : "View Medicine",
		delete_Row : "Delete Row",
		//////////////////////////

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		// toggle buttons
		request_order_list : true,
		show_request_order : false,
		show_request_order_receipt : false,
		/////////////////////////////

		request_medicines : [],
		add_request_medicine : {
			purchase_received_details_id : null,
			medicine_name : null,
			category : null,
			unit_category : null,
			price : null
		},


		medicines : [],
		search_medicine : "",

		supplier_medicines : [],

		categories : [],

		unit_categories : [],

		request_orders : [],

		request_orders_per_barangays : [],

		users : [],
		barangays : [],

		filter : "",
		search_medicine : "",
	},
	methods : {
		str_pad : function(n) {
 			return String("00" + n).slice(-2);
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
		// toggle buttons
		showCityHallMedicine : function() {
			$('#myModal6').modal('show');
		},
		removeRequestMedicines : function(index) {
			this.request_medicines.splice(index, 1);
		},
		disabledRequestOrderButton : function(purchase_received_details_id) {
			for(var index = 0; index < this.request_medicines.length; index++) {
				if(this.request_medicines[index].purchase_received_details_id == purchase_received_details_id) {
					return this.request_medicines[index].purchase_received_details_id;
				}
			}
		},
		addRequestOrderButton : function(purchase_received_details_id) {
			var found = true;			

			for(var index = 0; index < this.request_medicines.length; index++) {
				if(this.request_medicines[index].purchase_received_details_id == purchase_received_details_id) {
					found = false;
					swal({
						title : "Error!",
						text : "You already request this medicine!",
						icon : "error",
						timer : "1050",
						buttons : false,
						closeOnClickOutside: false
					});
				}
			}

			if(found) {
				this.add_request_medicine.purchase_received_details_id = this.medicines[index].purchase_received_details_id;
				this.add_request_medicine.medicine_name = this.identifyMedicineName(this.medicines[index].purchase_received_details_id);
				this.add_request_medicine.category = this.identifyCategory(this.medicines[index].purchase_received_details_id);
				this.add_request_medicine.unit_category = this.identifyUnitCategory(this.medicines[index].purchase_received_details_id);
				this.add_request_medicine.price = this.identifyMedicinePrice(this.medicines[index].purchase_received_details_id);

				this.request_medicines.push({...this.add_request_medicine});
			}
		},

		// identify methods
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
		identifyCategory : function(purchase_received_details_id) {
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
		identifyUnitCategory : function(purchase_received_details_id) {
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
		identifyUserFirstName : function(user_id) {
			for(var index = 0; index < this.users.length; index++) {
				if(user_id == this.users[index].user_id) {
					return this.users[index].first_name;
				}
			}
		},
		identifyUserLastName : function(user_id) {
			for(var index = 0; index < this.users.length; index++) {
				if(user_id == this.users[index].user_id) {
					return this.users[index].last_name;
				}
			}
		},
		identifyBarangayName : function(barangay_id) {
			for(var index = 0; index < this.barangays.length; index++) {
				if(barangay_id == this.barangays[index].barangay_id) {
					return this.barangays[index].barangay_name;
				}
			}
		},
		///////////////////

		// toggle button
		toggleAddRequestOrder : function() {
			if(this.request_order_list == true) {
				this.request_order_list = false;
				this.show_request_order = true;
			}
			else {
				this.request_order_list = true;
				this.show_request_order = false;
			}
		},
		////////////////

		// search method
		searchCityHallAvaialableMedicine : function() {
			axios.get(this.urlRoot + this.api + "search_city_hall_available_medicine.php?filter=" + this.filter + "&keyword=" + this.search_medicine)
			.then(function (response) {
				vm.medicines = response.data;
				console.log(response);
			});
		},
		////////////////


		// retrieve methods
		retrieveMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_city_hall_medicine.php")
			.then(function (response) {
				vm.medicines = response.data;
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
		retrieveRequestOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_request_order.php")
			.then(function (response) {
				vm.request_orders = response.data;
				console.log(response);
			});
		},
 		retrieveUser : function() {
 			axios.get(this.urlRoot + this.api + "retrieve_user.php")
			.then(function (response) {
				vm.users = response.data;
				console.log(response);
			});
 		},
 		retrieveBarangay : function() {
 			axios.get(this.urlRoot + this.api + "retrieve_barangay.php")
			.then(function (response) {
				vm.barangays = response.data;
				console.log(response);
			});
 		},
 		retrieveRequestPerBarangay : function() {
 			axios.get(this.urlRoot + this.api + "retrieve_request_order_per_barangay.php")
			.then(function (response) {
				vm.request_orders_per_barangays = response.data;
				console.log(response);
			});
 		},

		// generate id
		generateRequestOrderID : function() {
			var  id = "";
			var pad = "0000";
			var date = new Date();

			if(this.request_orders.length <= 0) {
				id = "RO" + "" + date.getUTCFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate())  + "0001";
			}
			else {
				for(var index = 0; index < this.request_orders.length; index++) {
					id = this.request_orders[index].request_order_id;
				}

				id = id.slice(10);
				id = pad.substring(0, pad.length - id.length) + id;
				id = date.getUTCFullYear() + this.str_pad(date.getMonth() + 1) + this.str_pad(date.getDate()) + id;
				id = parseInt(id) + 1;
				id = "RO" + "" + id;
			}
			return id;
		},


		////////////////////////////
		saveRequestOrder : function() {
			if(this.request_medicines.length == 0) {
				swal("Error!", " There is no medicine to request!", "error")
			}
			else {
				this.addRequestOrder();
			}
		},
		addRequestOrder : function() {
			var date = new Date();
			axios.post(this.urlRoot + this.api + "add_request_order.php", {
				request_order_id  : this.generateRequestOrderID(),
				date_request : date.getUTCFullYear() + "-" + this.str_pad(date.getMonth() + 1) + "-" + this.str_pad(date.getDate()),
				request_order_status : "Pending"
			}).then(function (response) {
				vm.addRequestOrderDetails();
				console.log(response);
			});
		},
		addRequestOrderDetails : function() {
			axios.post(this.urlRoot + this.api + "add_request_order_details.php", {
				request_medicines : this.request_medicines
			}).then(function (response) {
				vm.addRequestDetails();
				console.log(response);
			});
		},
		addRequestDetails : function() {
			axios.post(this.urlRoot + this.api + "add_request_details.php", {
				request_medicines : this.request_medicines
			}).then(function (response) {
				console.log(response);
				swal({
					title : "Congrats!",
					text : "Request order successfully!",
					icon : "success",
					timer : 2000,
					buttons : false,
					allowOutsideClick: false
				}).then(() => {
					vm.show_request_order = false;
					vm.show_request_order_receipt = true;
				})
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
	computed : {
		totalPages: function() {
	    	return Math.ceil(this.medicines.length / this.show_entries)
	   	}
	},
	created() {
		this.retrieveMedicine();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrieveRequestOrder();
		this.retrieveUser();
		this.retrieveBarangay();
		this.retrieveRequestPerBarangay();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})