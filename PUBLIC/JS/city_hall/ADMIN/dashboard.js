var vm = new Vue({
	el : "#vue-dashboard",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/admin/",

		suppliers : [],

		active_users : [],

		send_medicines: [],

		purchase_received : [],

		available_medicines : [],

		supplier_medicines : [],

		unavailable_medicines: [],

		best_medicines : [],

		best_barangay : [],

		beneficiaries : [],

		expired_medicines : [],

		start_date: "",
		end_date: "",

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////
		myChart: "",
		myChart2: "",
		myChart3: "",
		myChart4: ""
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
		retrieveActiveUser : function() {
			axios.get(this.urlRoot + this.api + "retrieve_user.php")
			.then(function (response) {
				vm.active_users = response.data;
				console.log(response);
			});
		},	

		retrieveSupplier : function() {
			axios.get(this.urlRoot + this.api + "retrieve_supplier.php")
			.then(function (response) {
				console.log(response);
				vm.suppliers = response.data;
			});
		},
		retrieveAvailableMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_available_medicine.php")
			.then(function (response) {
				console.log(response);
				vm.available_medicines = response.data;
			});
		},
		retrieveUnavailableMedicine : function() {
			axios.get(this.urlRoot + "api's/city_hall/pharmacist/" + "retrieve_unavailable_medicine.php")
			.then(function (response) {
				console.log(response);
				vm.unavailable_medicines = response.data;
			});
		},
		retrieveExpiredMedicine : function() {
	    	axios.get(this.urlRoot + "api's/city_hall/pharmacist/" + "retrieve_expired_medicine.php")
	    	.then(function (response) {
	    		vm.expired_medicines = response.data;
	    		console.log(response);
	    	});
	    },
		retrieveSupplierMedicine : function() {
			axios.get(this.urlRoot + "api's/city_hall/pharmacist/" + "retrieve_supplier_medicine.php")
			.then(function (response) {
				vm.supplier_medicines = response.data;
				console.log(response);
			})
		},
		retrieveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary.php")
			.then(function (response) {
				console.log(response);
				vm.beneficiaries = response.data;
			});
		},
		retrieveTotalSendOrder : function() {
		    var self = this;
		    var sum = 0;
		   
		    axios.post(this.urlRoot + this.api + "retrieve_total_send_order.php")
		   	.then(response => {
		   		console.log(response);
		    	vm.send_medicines = response.data
				    var ctxChart = self.$refs.myChart.getContext('2d');

				    if (this.myChart) this.myChart.destroy();
				    this.myChart = new Chart(ctxChart, {
				        type: 'bar',
				        data: {
				          	labels: vm.send_medicines.map(item => item.Month),
				          	datasets: [{
				            label: 'Total Items',
				            data: vm.send_medicines.map(item => item.Quantity),
				            backgroundColor: this.poolColors(vm.send_medicines.length),
				            borderColor: "#eee",
				            borderWidth: 2
				        }]
				    },
				    reponsive: true,

				    options: {
				    	maintainAspectRatio: false,
				    	scales: {
					        xAxes: [{ticks: {mirror: true}}]
					    },
				       	title : {
							display : true,
							text : "Month Send Medicine",
							fontFamily: "sans-serif",
							fontSize: 18
						},
						legend: {
				            display: false
				        },
				        tooltips: {
				            enabled: true
				        }
				    }
				});
			}).catch(e => {
				console.log(e)
			});
		},
		retrieveTotalPurchaseReceived : function() {
		    var self = this;
		    var sum = 0;
		   
		    axios.post(this.urlRoot + this.api + "retrieve_total_purchase_received.php")
		   	.then(response => {
		   		console.log(response);
		    	vm.purchase_received = response.data
				    var ctxChart = self.$refs.myChart2.getContext('2d');

				    if (this.myChart2) this.myChart2.destroy();
				    this.myChart2 = new Chart(ctxChart, {
				        type: 'bar',
				        data: {
				          	labels: vm.purchase_received.map(item => item.Month),
				          	datasets: [{
				            label: 'Total Items',
				            data: vm.purchase_received.map(item => item.Quantity),
				            backgroundColor: this.poolColors(vm.purchase_received.length),
				            borderColor: "#eee",
				            borderWidth: 2
				        }]
				    },
				    reponsive: true,

				    options: {
				    	maintainAspectRatio: false,
				    	scales: {
					        xAxes: [{ticks: {mirror: true}}]
					    },
				       	title : {
							display : true,
							text : "Month Purchased Received",
							fontFamily: "sans-serif",
							fontSize: 18
						},
						legend: {
				            display: false
				        },
				        tooltips: {
				            enabled: true
				        }
				    }
				});
			}).catch(e => {
				console.log(e)
			});
		},
		retrieveBestMedicine : function() {
		    var self = this;
		    var sum = 0;
		   
		    axios.post(this.urlRoot + this.api + "overall_best_medicine.php")
		   	.then(response => {
		   		console.log(response);
		    	vm.best_medicines = response.data
				    var ctxChart = self.$refs.myChart3.getContext('2d');

				    for(var i = 0; i < this.best_medicines.length; i++) {
				    	sum += parseFloat(this.best_medicines[i].Quantity);
				    }

				    if (this.myChart3) this.myChart3.destroy();
				    this.myChart3 = new Chart(ctxChart, {
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
							text : "Overall Month Top Medicine",
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
		retrieveBestBarangay : function() {
		    var self = this;
		    var sum = 0;
		   
		    axios.post(this.urlRoot + this.api + "retrieve_top_barangay.php")
		   	.then(response => {
		   		console.log(response);
		    	vm.best_barangay = response.data
				    var ctxChart = self.$refs.myChart4.getContext('2d');

				    for(var i = 0; i < this.best_barangay.length; i++) {
				    	sum += parseFloat(this.best_barangay[i].Quantity);
				    }

				    if (this.myChart4) this.myChart4.destroy();
				    this.myChart4 = new Chart(ctxChart, {
				        type: 'horizontalBar',
				        data: {
				          	labels: vm.best_barangay.map(item => item.Barangay),
				          	datasets: [{
				            label: 'Total Items',
				            data: vm.best_barangay.map(item => (item.Quantity / sum * 100).toFixed(2)),
				            backgroundColor: this.poolColors(vm.best_barangay.length),
				            borderColor: "#eee",
				            borderWidth: 2
				        }]
				    },
				    reponsive: true,

				    options: {
				    	maintainAspectRatio: false,
				       	title : {
							display : true,
							text : "Month Top Barangay",
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
		identifyMedicinePrice : function(supplier_medicine_id) {
			for(var index = 0; index < this.supplier_medicines.length; index++) {
				if(supplier_medicine_id == this.supplier_medicines[index].supplier_medicine_id) {
					return this.supplier_medicines[index].price;
				}
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
	computed: {
		totalDistribute() {
			return this.send_medicines.reduce((acc,val)=> acc + parseInt(val.Total_Amount),0)
		},
		totalStockQuantity() {
			var total = 0;
			for(var i = 0; i < this.available_medicines.length; i++) {
				total += parseFloat(this.available_medicines[i].received_quantity);
			}
			return total;
		},
		totalPurchaseReceivedQuantity() {
			let total = 0;
			for(let index = 0; index < this.purchase_received.length; index++) {
				total += parseFloat(this.purchase_received[index].Total_Amount);
			}
		    return parseFloat(total);
		}
	},
	created() {
		this.retrieveActiveUser();
		this.retrieveSupplier();
		this.retrieveTotalSendOrder();
		this.retrieveAvailableMedicine();
		this.retrieveUnavailableMedicine();
		this.retrieveTotalPurchaseReceived();
		this.retrieveSupplierMedicine();
		this.retrieveBestMedicine();
		this.retrieveBestBarangay();
		this.retrieveBeneficiary();
		this.retrieveExpiredMedicine();

		setInterval(() => {
			this.getSession();
		}, 3000)

	}
});