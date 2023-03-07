var vm = new Vue({
	el : "#vue-dashboard",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/barangay/admin/",

		available_medicines : [],

		unavailable_medicines : [],

		expired_medicines : [],

		received_orders : [],

		receive_orders_per_year : [],

		beneficiaries : [],

		reports : [],

		transaction_per_month: [],

		expired_medicines : [],

		users : [],

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
		total : 0,

		myChart : "",
		myChart2 : "",
		myChart3 : "",
		myChart4 : "",

		select_reports : "this_year"

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
		dynamicColor : function() {
			var r = Math.floor(Math.random() * 255);
		    var g = Math.floor(Math.random() * 255);
		    var b = Math.floor(Math.random() * 255);
		    return "rgba(" + r + "," + g + "," + b + ", 0.5)";
		},
		poolColors : function(a) {
		    var pool = [];
		    for(var i = 0; i < a; i++) {
		        pool.push(this.dynamicColor());
		    }
		    return pool;
		},
		retrieveTransactionPerMonth : function(search) {
		    var self = this

		    axios.post(this.urlRoot + this.api + "retrieve_transaction_this_year.php?search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		    	vm.transaction_per_month = response.data
		    
				    var ctxChart = self.$refs.myChart.getContext('2d')

				    if (this.myChart) this.myChart.destroy();
				    this.myChart = new Chart(ctxChart, {
				        type: 'bar',
				        data: {
				          	labels: vm.transaction_per_month.map(item => item.Day),
				          	datasets: [{
				            label: 'Total Amount',
				            data: vm.transaction_per_month.map(item => item.Quantity),
				            backgroundColor: this.poolColors(vm.transaction_per_month.length),
				            borderColor: [
				               '#eee'
				            ],
				            borderWidth: 1
				        }]
				    },
				    options: {
				       	title : {
							display : true,
							text : "Monthly Distribution Medicine",
							fontFamily: "sans-serif",
							fontSize: 18
						},
						legend: {
				            display: false
				        },
				        tooltips: {
					        enabled: true,
	        				mode: "single",
				            callbacks: {
				            	title: function (tooltipItem, data) { return 'Month: ' + data.labels[tooltipItem[0].index]; },
			                    label: function (tooltipItems, data) {
			                       	return 'Total: ' + data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index];      
			                    } 
				            }
				        }
				    }
				});
			}).catch(e => {
				console.log(e)
			});
		},
		retrieveReceivedOrder : function() {
		    var self = this;
		    var sum = 0;
		   
		    axios.post(this.urlRoot + this.api + "retrieve_total_received_order.php")
		   	.then(response => {
		   		console.log(response);
		    	vm.received_orders = response.data
				    var ctxChart = self.$refs.myChart3.getContext('2d');

				    if (this.myChart3) this.myChart2.destroy();
				    this.myChart3 = new Chart(ctxChart, {
				        type: 'bar',
				        data: {
				          	labels: vm.received_orders.map(item => item.Date_Received),
				          	datasets: [{
				            label: 'Total Items',
				            data: vm.received_orders.map(item => item.Quantity),
				            backgroundColor: this.poolColors(vm.received_orders.length),
				            borderColor: "#eee",
				            borderWidth: 2
				        }]
				    },
				    reponsive: true,

				    options: {
				    	maintainAspectRatio: false,
				       	title : {
							display : true,
							text : "Monthly Received Order",
							fontFamily: "sans-serif",
							fontSize: 18
						},
						legend: {
				            display: false
				        },
				        tooltips: {
					        enabled: true,
	        				mode: "single",
				            callbacks: {
				            	title: function (tooltipItem, data) { return 'Month: ' + data.labels[tooltipItem[0].index]; },
			                    label: function (tooltipItems, data) {
			                       	return 'Total: ' + data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index];      
			                    } 
				            }
				        }
				    }
				});
			}).catch(e => {
				console.log(e)
			});
		},
		retrieveBestMedicine : function(search) {
		    var self = this;
		    var sum = 0;
		   
		    axios.post(this.urlRoot + this.api + "retrieve_best_medicine.php?search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		    	vm.best_medicines = response.data
				    var ctxChart = self.$refs.myChart2.getContext('2d');

				    for(var i = 0; i < this.best_medicines.length; i++) {
				    	sum += parseFloat(this.best_medicines[i].Quantity);
				    }

				    if (this.myChart2) this.myChart2.destroy();
				    this.myChart2 = new Chart(ctxChart, {
				        type: 'horizontalBar',
				        data: {
				          	labels: vm.best_medicines.map(item => item.MedicineName),
				          	datasets: [{
				            label: 'Total Items',
				            data: vm.best_medicines.map(item => (item.Quantity / sum * 100).toFixed(2)),
				            backgroundColor: this.poolColors(vm.best_medicines.length),
				            borderColor: "#eee",
				            borderWidth: 2
				        }]
				    },
				    reponsive: true,

				    options: {
				    	maintainAspectRatio: false,
				       	title : {
							display : true,
							text : "This Month Top Medicine",
							fontFamily: "sans-serif",
							fontSize: 18
						},
						legend: {
				            display: false
				        },
				        tooltips: {
					        enabled: true,
	        				mode: "single",
				            callbacks: {
				            	title: function (tooltipItem, data) { return 'Date: ' + data.labels[tooltipItem[0].index]; },
			                    label: function (tooltipItems, data) {
			                       	return 'Avg: ' + data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] + "%";      
			                    } 
				            }
				        }
				    }
				});
			}).catch(e => {
				console.log(e)
			});
		},
		retrieveBestBeneficiary : function() {
			var self = this;
			var sum = 0;

			axios.post(this.urlRoot + this.api + "retrieve_best_beneficiary.php?search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		    	vm.best_beneficiaries = response.data
				    var ctxChart = self.$refs.myChart4.getContext('2d');

				    for(var i = 0; i < this.best_beneficiaries.length; i++) {
				    	sum += parseFloat(this.best_beneficiaries[i].Total);
				    }

				    if (this.myChart4) this.myChart4.destroy();
				    this.myChart4 = new Chart(ctxChart, {
				        type: 'horizontalBar',
				        data: {
				          	labels: vm.best_beneficiaries.map(item => item.Beneficiary),
				          	datasets: [{
				            label: 'Total Amount',
				            data: vm.best_beneficiaries.map(item => (item.Total / sum * 100).toFixed(2)),
				            backgroundColor: this.poolColors(vm.best_beneficiaries.length),
				            borderColor: "#eee",
				            borderWidth: 2
				        }]
				    },
				    reponsive: true,
				    options: {
				       	title : {
							display : true,
							text : 'This Month Top Beneficiary ',
							fontFamily: "sans-serif",
							fontSize: 18
						},
						legend: {
				            display: false
				        },
				        tooltips: {
					        enabled: true,
	        				mode: "single",
				            callbacks: {
				            	title: function (tooltipItem, data) { return 'Date: ' + data.labels[tooltipItem[0].index]; },
			                    label: function (tooltipItems, data) {
			                       	return 'Avg: ' + data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] + "%";      
			                    } 
				            }
				        }
				    }
				});
			}).catch(e => {
				console.log(e)
			});

		},
		retrieveAvailableMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_available_medicine.php")
			.then(function (response) {
				vm.available_medicines = response.data;
				console.log(response);
			});
		},
		retrieveUnavailableMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_unavailable_medicine.php")
			.then(function (response) {
				console.log(response);
				vm.unavailable_medicines = response.data;
			});
		},
		retrieveExpiredMedicine : function() {
	    	axios.get(this.urlRoot + "api's/barangay/health_worker/" + "retrieve_expired_medicine.php")
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
		retrieveTransactionReportsToday : function() {
			axios.get(this.urlRoot + this.api + "retrieve_transaction_today.php")
			.then(function (response) {
				vm.reports = response.data;
				console.log(response);

			});
		},
		retrieveReceivedOrderYear : function(search) {
			axios.get(this.urlRoot + this.api + "retrieve_received_order_reports.php?search=" + this.select_reports)
			.then(function (response) {
				vm.receive_orders_per_year = response.data;
				console.log(response);

			});
		},
		retrieveUser : function(response) {
	 		axios.get(this.urlRoot + this.api + "retrieve_user.php")
	 		.then(function (response) {
	 			console.log(response);
	 			vm.users = response.data;
	 		})
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
	    	let total = 0;
	    	for(let i = 0; i < this.reports.length; i++){
	    		total += (parseFloat(this.reports[i].total_price));
	      	}
	     	return total;
	   	},
	   	totalPages: function() {
	    	return Math.ceil(this.reports.length / this.show_entries)
	   	},
	   	totalDistribute: function() {
	   		var total = 0;
	   		for(var i = 0; i < this.transaction_per_month.length; i++){
	   			total += parseFloat(this.transaction_per_month[i].Amount);
	   		}
	   		return total;
	   	},
	   	totalQuantity: function() {
	   		var total = 0;
	   		for(var i = 0; i < this.available_medicines.length; i++) {
	   			total += parseFloat(this.available_medicines[i].quantity);
	   		}
	   		return total;
	   	},
	   	totalReceivedOrder: function() {
	   		var total = 0
	   		for (var i = 0; i < this.receive_orders_per_year.length; i++) {
	   			total += parseFloat(this.receive_orders_per_year[i].Total);
	   		}
	   		return total;
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
		this.retrieveTransactionPerMonth();
		this.retrieveBestMedicine();
		this.retrieveReceivedOrder();
		this.retrieveBestBeneficiary();
		this.retrieveExpiredMedicine();
		this.retrieveReceivedOrderYear();
		this.retrieveUser();

		setInterval(() => {
			this.getSession();
		}, 3000)
	},
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
