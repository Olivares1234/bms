var vm = new Vue({
	el : "#vue-request-order",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/gulod_api/",

		// button
		editDisabled : false,

		//titles
		add_Medicine : "Add Medicine",
		view_Medicine : "View Medicine",
		delete_Row : "Delete Row",

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		/// request order ////
		show_request_order : true,
		show_request_order_receipt : false,

		request_orders : [],
		add_request_order : {
			medicine_id : null,
			medicine_name : null,
			category : null,
			unit_category : null,
			price : null
		},
		retrieve_request_orders : [],

		medicines : [],
		search_medicine : "",
	},
	methods : {
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

		// toggle buttons
		showCityHallMedicine : function() {
			$('#myModal6').modal('show');
		},
		disabledRequestOrderButton : function(supplier_medicine_id) {
			for(var index = 0; index < this.request_orders.length; index++) {
				if(this.request_orders[index].medicine_id == supplier_medicine_id) {
					return this.request_orders[index].medicine_id;
				}
			}
		},
		addRequestOrderButton : function(supplier_medicine_id) {
			var found = true;			

			for(var index = 0; index < this.request_orders.length; index++) {
				if(this.request_orders[index].medicine_id == supplier_medicine_id) {
					found = false;
					swal("Error!", " You already request this medicine!", "error");
				}
			}

			if(found) {
				for(var index = 0; index < this.medicines.length; index++) {
					if(supplier_medicine_id == this.medicines[index].supplier_medicine_id) {
						this.add_request_order.medicine_id = this.medicines[index].supplier_medicine_id;
						this.add_request_order.medicine_name = this.medicines[index].medicine_name;
						this.add_request_order.category = this.medicines[index].description;
						this.add_request_order.unit_category = this.medicines[index].unit;
						this.add_request_order.price = this.medicines[index].price;

						this.request_orders.push({...this.add_request_order});
					}
				}
			}
		},
		removeRequestOrder : function(index) {
			this.request_orders.splice(index, 1);
		},

		// count methods
		countMedicine : function() {
			var count = 0;
			for(var index = 0; index < this.medicines.length; index++){
				count++;
			}
			return count;
		},

		// retrieve methods
		retrieveMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_medicine.php")
			.then(function (response) {
				vm.medicines = response.data;
				console.log(response);
			});
		},
		retrieveRequestOrder : function() {
			axios.get(this.urlRoot + this.api + "retrieve_request_order.php")
			.then(function (response) {
				vm.retrieve_request_orders = response.data;
			});
		},

		// search methods
		searchMedicine : function() {
			axios.get(this.urlRoot + this.api + "search_medicine.php?keyword=" + this.search_medicine)
			.then(function (response) {
				vm.medicines = response.data;
				console.log(response);
			});
		},


		// generate id
		generateRequestOrderID : function() {
			var  id = "";
			var pad = "0000";
			var date = new Date();

			if(this.retrieve_request_orders.length <= 0) {
				id = "RO" + "" + date.getUTCFullYear() + "0001";
			}
			else {
				for(var index = 0; index < this.retrieve_request_orders.length; index++) {
					id = this.retrieve_request_orders[index].request_order_id;
				}

				id = id.slice(6);
				// id = parseInt(id) + 1;
				id = pad.substring(0, pad.length - id.length) + id;
				id = date.getUTCFullYear() + "" + id;
				id = parseInt(id) + 1;
				id = "RO" + "" + id;
			}
			return id;
		},
		addRequestOrder : function() {
			var date = new Date();
			axios.post(this.urlRoot + this.api + "add_request_order.php", {
				request_order_id  : this.generateRequestOrderID(),
				user_id : "",
				date_request : date.getUTCFullYear() + "-" + date.getUTCMonth() + "-" + date.getUTCDate(),
				barangay_id : "1",
				request_order_status : "Pending"
			}).then(function (response) {
				vm.addRequestOrderDetails();
			});
		},
		addRequestOrderDetails : function() {
			axios.post(this.urlRoot + this.api + "add_request_order_details.php", {
				request_orders : this.request_orders
			}).then(function (response) {
				vm.addRequestDetails();
			});
		},
		addRequestDetails : function() {
			axios.post(this.urlRoot + this.api + "add_request_details.php", {
				request_orders : this.request_orders
			}).then(function (response) {
				swal({
					title : "Congrats!",
					text : "Request order successfully!",
					icon : "success",
					timer : 2000,
					buttons : false,
					allowOutsideClick: false
				});
				// this.sweetAlert("Congrats!", " Request order successfully!", "success", 3000, false);
				vm.show_request_order = false;
				vm.show_request_order_receipt = true;
			});
		},
		saveRequestOrder : function() {
			if(this.request_orders.length == 0) {
				swal("Error!", " There is no medicine to request!", "error")
			}
			else {
				this.addRequestOrder();
			}
		},
	},   
	created() {
		this.retrieveMedicine();
		this.retrieveRequestOrder();
	}
})