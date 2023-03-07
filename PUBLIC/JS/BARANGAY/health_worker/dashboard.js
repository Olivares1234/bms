var vm = new Vue({
	el : "#vue-dashboard",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/barangay/health_worker/",

		available_medicines : [],

		unavailable_medicines : [],

		expired_medicines : [],

		supplier_medicines : [],

		categories : [],

		unit_categories : [],

		beneficiaries : [],

		reports : [],

		transaction_per_month: [],

		transaction_per_day: [],

		out_of_stocks : [],

		start_date : "",
		end_date : "",

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		month : "",
		total : 0


	},
	mounted: function() { 
	   var args = {

	        format: 'YYYY-MM-DD'
		};
	    this.$nextTick(function() {
	        $('.datepicker').datetimepicker(args)
            $('.datepicker2').datetimepicker(args)
	    });

	    this.$nextTick(function() {
	      $('.time-picker').datetimepicker({
	        format: 'LT'
	       })
	    });
	    
	},
	methods : {
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
	    showEntries : function(value) {
         	this.endIndex = value;
         	this.pagination(1);
		},
		pagination : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries) - this.show_entries;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries);
		},
		// identify methods
		ideitifyMedicineName : function(supplier_medicine_id) {
			for(var index = 0; index < this.supplier_medicines.length; index++) {
				if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
					return this.supplier_medicines[index].medicine_name;
				}
			}
		},
		idetifyCategory : function(supplier_medicine_id) {
			for(var index = 0; index < this.supplier_medicines.length; index++) {
				for(var index1 = 0; index1 < this.categories.length; index1++) {
					if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
						if(this.supplier_medicines[index].category_id == this.categories[index1].category_id) {
							return this.categories[index1].description;
						}
					}
				}
			}
		},
		identifyUnitCategory : function(supplier_medicine_id) {
			for(var index = 0; index < this.supplier_medicines.length; index++) {
				for(var index1 = 0; index1 < this.unit_categories.length; index1++) {
					if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
						if(this.supplier_medicines[index].unit_category_id == this.unit_categories[index1].unit_category_id) {
							return this.unit_categories[index1].unit;
						}
					}
				}
			}
		},
		identifyMedicinePrice : function(supplier_medicine_id) {
			for(var index = 0; index < this.supplier_medicines.length; index++) {
				if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
					return this.supplier_medicines[index].price;
				}
			}
		},

	    // retrieve methods
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
		retrieveAvailableMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_available_medicine_for_display.php")
			.then(function (response) {
				vm.available_medicines = response.data;
				console.log(response);
			});
		},
		 retrieveUnavailableMedicine : function() {
	    	axios.get(this.urlRoot + this.api + "retrieve_unavailable_medicine_for_display.php")
	    	.then(function (response) {
	    		vm.unavailable_medicines = response.data;
	    		console.log(response);
	    	});
	    },
		retrieveExpiredMedicine : function() {
	    	axios.get(this.urlRoot + this.api + "retrieve_expired_medicine.php")
	    	.then(function (response) {
	    		vm.expired_medicines = response.data;
	    		console.log(response);
	    	});
	    },
		retrieveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary.php")
			.then(function (response) {
				console.log(response);
				vm.beneficiaries = response.data;

			});
		},
		retrieveTransactionReportsToday : function() {
			axios.get(this.urlRoot + this.api + "retrieve_transaction_today.php")
			.then(function (response) {
				vm.reports = response.data;
				console.log(response);

			});
		},
		retrieveOutOfStock : function() {
			axios.get(this.urlRoot + this.api + "retrieve_out_of_stock_medicine.php")
			.then(function (response) {
				vm.out_of_stocks = response.data;
				console.log(response);

			});
		},
		searchByDate : function() {
			if(this.start_date && this.end_date) {
				axios.get(this.urlRoot + this.api + "search_start_end_date_transaction.php?start_date=" + this.start_date + "&end_date=" + this.end_date)
				.then(function (response) {
					vm.reports = response.data;
					console.log(response);
				});
			}
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
		totalTransactionReportsToday: function() {
	    	let totalAmount = 0;
	    	for(let i = 0; i < this.reports.length; i++){
	    		totalAmount += (parseFloat(this.reports[i].total_price));
	      	}
	     	return totalAmount;
	   	},
	   	totalPages: function() {
	    	return Math.ceil(this.reports.length / this.show_entries)
	   	},
	   	totalInventory: function() {
	     	let total = 0;

			for(let index = 0; index < this.unavailable_medicines.length; index++) {
				total += parseInt(this.identifyMedicinePrice(this.unavailable_medicines[index].supplier_medicine_id)) * parseInt(this.unavailable_medicines[index].quantity);
			}
			return parseInt(total)  + ".00";
	   	}
	},
	filters: {
      currency(value) {
        return value.toFixed(2);
      }
    },
	created() {
		this.retrieveAvailableMedicine();
		this.retrieveUnavailableMedicine();
		this.retrieveBeneficiary();
		this.retrieveTransactionReportsToday();
		this.retrieveSupplierMedicine();
		this.retrieveCategory();
		this.retrieveUnitCategory();
		this.retrieveExpiredMedicine();
		this.retrieveOutOfStock();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
});
$('.datepicker').on('dp.change', function(event) {
  if (event.date) {
    var date = event.date.format('YYYY-MM-DD');
    console.log(date);
    Vue.set(vm, 'start_date', date);
  }
});

$('.datepicker2').on('dp.change', function(event) {
  if (event.date) {
    var date = event.date.format('YYYY-MM-DD');
    console.log(date);
    Vue.set(vm, 'end_date', date);
  }
});
