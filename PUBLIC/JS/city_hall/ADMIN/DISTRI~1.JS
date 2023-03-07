var vm = new Vue({
	el : "#vue-distributed-medicine-reports",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/admin/",

		distributed_reports : [],

		distributed_reports_per_year : [],

		barangays : [],

		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		select_reports : "this_week",
		filter_search : 1,
		myChart : "",
		myChart2 : "",
		myChart3 : "",
		myChart4 : "",

		first : true,
		second : false,
	},
	methods : {
		download: function() {
			var vm = this;
			var columns = [
				{title: "Date", dataKey: "Day"},
				{title: "Order Qty", dataKey: "Quantity"},
				{title: "Total Order", dataKey: "Beneficiary"},
				{title: "Grand Total", dataKey: "Amount"},
				{title: "Avg. Qty", dataKey: "Quantity_Average"},
				{title: "Avg. Order", dataKey: "Beneficiary_Average"},
				{title: "Avg. Grand Total", dataKey: "Amount_Average"}
			];
			var doc = new jsPDF('p', 'pt');
			doc.text('\n\tDistributed Reports\n', 10, 12)
			doc.autoTable(columns, vm.distributed_reports);
			doc.save('distributed-reports.pdf');

		},
		download_two: function() {
			var vm = this;
			var columns = [
				{title: "Date", dataKey: "Day"},
				{title: "Order Qty", dataKey: "Quantity"},
				{title: "Total Order", dataKey: "Beneficiary"},
				{title: "Grand Total", dataKey: "Amount"},
				{title: "Avg. Qty", dataKey: "Quantity_Average"},
				{title: "Avg. Order", dataKey: "Beneficiary_Average"},
				{title: "Avg. Grand Total", dataKey: "Amount_Average"}
			];
			var doc = new jsPDF('p', 'pt');
			doc.text('\n\tDistributed Reports\n', 10, 12)
			doc.autoTable(columns, vm.distributed_reports_per_year);
			doc.save('distributed-reports.pdf');

		},
		selectReports : function() {
			if (this.select_reports == 'lifetime') {
				this.first = true;
				this.second = false;
				
			}
			else if (this.select_reports == 'this_week'){
				this.first = true;
				this.second = false;
				
			}
			else if (this.select_reports == 'last_week'){
				this.first = true;
				this.second = false;
				
			}
			else if (this.select_reports == 'last_month') {
				this.first = true;
				this.second = false;
				
			}
			else if (this.select_reports == 'this_month') {
				this.first = true;
				this.second = false;
				
			}
			else if (this.select_reports == 'last_year'){
				this.first = false;
				this.second = true;
				
			}
			else if (this.select_reports == 'this_year'){
				this.first = false;
				this.second = true;
				
			}
			this.retrieveDistributedReports(this.filter_search, this.select_reports);
			this.retrieveDistributedMedicinePerYear(this.filter_search, this.select_reports);
			this.pagination(1);
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
	    showEntries : function(value) {
         	this.endIndex = value;
         	this.pagination(1);
		},
		pagination : function(activePage) {
			this.currentPage = activePage;
        	this.startIndex = (this.currentPage * this.show_entries) - this.show_entries;
        	this.endIndex = parseInt(this.startIndex) + parseInt(this.show_entries);
		},
		next_two: function() {
	      if (this.currentPage < this.totalPages_two) {
	        this.pagination_two(this.currentPage + 1);
	      }
	    },
	    previous_two: function() {
	      if (this.currentPage > 1) {
	        this.pagination_two(this.currentPage - 1);
	      }

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
		retrieveBarangays : function() {
	 		axios.get(this.urlRoot + this.api + "retrieve_barangay.php")
	 		.then(response => { 
	 			console.log(response);
	 			vm.barangays = response.data;
	 		});
	 	},
		retrieveDistributedReports : function(barangay_id, search) {
		    var self = this;
		    var sum = 0;
		    var text = "";

		    if (this.select_reports == "") {
				text = "No data to show";
		    } else if(this.select_reports == "lifetime") {
		    	text = "Distributed Reports Lifetime"
		    } else if (this.select_reports == "last_week") {
		    	text = "Distributed Reports Last Week"
		    } else if (this.select_reports == "this_week") {
		    	text = "Distributed Reports This Week"
		    } else if (this.select_reports == "last_month") {
		    	text = "Distributed Reports Last Month"
		    } else if (this.select_reports == "this_month") {
		    	text = "Distributed Reports This Month"
		    } 
		   
		    axios.post(this.urlRoot + this.api + "distributed_medicine_reports.php?barangay_id=" + this.filter_search + "&search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		    	vm.distributed_reports = response.data
				    var ctxChart = self.$refs.myChart.getContext('2d');

				    if (this.myChart) this.myChart.destroy();
				    this.myChart = new Chart(ctxChart, {
				        type: 'bar',
				        data: {
				          	labels: vm.distributed_reports.map(item => item.Day),
				          	datasets: [{
				            label: 'Total Items',
				            data: vm.distributed_reports.map(item => item.Amount),
				            backgroundColor: this.poolColors(vm.distributed_reports.length),
				            borderColor: "#eee",
				            borderWidth: 2
				        }]
				    },
				    reponsive: true,
				    options: {
				       	title : {
							display : true,
							text : text,
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

			 axios.post(this.urlRoot + this.api + "distributed_medicine_reports.php?barangay_id=" + this.filter_search + "&search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		    	vm.distributed_reports = response.data
				    var ctxChart = self.$refs.myChart2.getContext('2d');

				    for(var i = 0; i < this.distributed_reports.length; i++) {
				    	sum += parseFloat(this.distributed_reports[i].Amount);
				    }
				    if (this.myChart2) this.myChart2.destroy();
				    this.myChart2 = new Chart(ctxChart, {
				        type: 'pie',
				        data: {
				        	labels: vm.distributed_reports.map(item => item.Day),
				          	datasets: [{
				            label: 'Total Items',
				            data: vm.distributed_reports.map(item => (item.Amount / sum * 100).toFixed(2)),
				            backgroundColor: this.poolColors(vm.distributed_reports.length),
				            borderColor: '#eee',
				            borderWidth: 2
				        }]
				    },
				    reponsive : true,
				    options: {
				       	title : {
							display : true,
							text : text,
							fontFamily: "sans-serif",
							fontSize: 18,
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
		retrieveDistributedMedicinePerYear : function() {
			var self = this;
		    var sum = 0;
		    var text = "";

			if (this.select_reports == "last_year") {
		    	text = "Distributed Reports Last Year"
		    } else if (this.select_reports == "this_year") {
		    	text = "Distributed Reports This Year"
		    } 
			axios.post(this.urlRoot + this.api + "distributed_medicine_reports_per_year.php?barangay_id=" + this.filter_search + "&search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		    	vm.distributed_reports_per_year = response.data
				    var ctxChart = self.$refs.myChart3.getContext('2d');

				    if (this.myChart3) this.myChart3.destroy();
				    this.myChart3 = new Chart(ctxChart, {
				        type: 'bar',
				        data: {
				          	labels: vm.distributed_reports_per_year.map(item => item.Day),
				          	datasets: [{
				            label: 'Total Items',
				            data: vm.distributed_reports_per_year.map(item => item.Amount),
				            backgroundColor: this.poolColors(vm.distributed_reports_per_year.length),
				            borderColor: "#eee",
				            borderWidth: 2
				        }]
				    },
				    reponsive: true,
				    options: {
				       	title : {
							display : true,
							text : text,
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

			 axios.post(this.urlRoot + this.api + "distributed_medicine_reports_per_year.php?barangay_id=" + this.filter_search + "&search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		    	vm.distributed_reports_per_year = response.data
				    var ctxChart = self.$refs.myChart4.getContext('2d');

				    for(var i = 0; i < this.distributed_reports_per_year.length; i++) {
				    	sum += parseFloat(this.distributed_reports_per_year[i].Amount);
				    }
				    if (this.myChart4) this.myChart4.destroy();
				    this.myChart4 = new Chart(ctxChart, {
				        type: 'pie',
				        data: {
				        	labels: vm.distributed_reports_per_year.map(item => item.Day),
				          	datasets: [{
				            label: 'Total Items',
				            data: vm.distributed_reports_per_year.map(item => (item.Amount / sum * 100).toFixed(2)),
				            backgroundColor: this.poolColors(vm.distributed_reports_per_year.length),
				            borderColor: '#eee',
				            borderWidth: 2
				        }]
				    },
				    reponsive : true,
				    options: {
				       	title : {
							display : true,
							text : text,
							fontFamily: "sans-serif",
							fontSize: 18,
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
	    	return Math.ceil(this.distributed_reports.length / this.show_entries)
	   	},
	   	totalPages_two: function() {
	    	return Math.ceil(this.distributed_reports_per_year.length / this.show_entries_two)
	   	},
	   	totalQuantity() {
			return this.distributed_reports.reduce((acc,val)=> acc + parseInt(val.Quantity),0)
		},
		totalBeneficiary() {
			return this.distributed_reports.reduce((acc,val)=> acc + parseInt(val.Beneficiary),0)
		},
		totalAmount() {
			return this.distributed_reports.reduce((acc,val)=> acc + parseInt(val.Amount),0)
		},
		totalThisYearQuantity() {
			return this.distributed_reports_per_year.reduce((acc,val)=> acc + parseInt(val.Quantity),0)
		},
		totalThisYearBeneficiary() {
			return this.distributed_reports_per_year.reduce((acc,val)=> acc + parseInt(val.Beneficiary),0)
		},
		totalThisYearAmount() {
			return this.distributed_reports_per_year.reduce((acc,val)=> acc + parseInt(val.Amount),0)
		},
		sumAllQuantity() {
			return this.distributed_reports.reduce((acc,val)=> acc + parseInt(val.Quantity) / this.totalQuantity * 100,0)
		},
		sumAllBeneficiary() {
			return this.distributed_reports.reduce((acc,val)=> acc + parseInt(val.Beneficiary) / this.totalBeneficiary * 100,0)
		},
		sumAllAmount() {
			return this.distributed_reports.reduce((acc,val)=> acc + parseInt(val.Amount) / this.totalAmount * 100,0)
		},
		sumAllYearQuantity() {
			return this.distributed_reports_per_year.reduce((acc,val)=> acc + parseInt(val.Quantity) / this.totalThisYearQuantity * 100,0)
		},
		sumAllYearBeneficiary() {
			return this.distributed_reports_per_year.reduce((acc,val)=> acc + parseInt(val.Beneficiary) / this.totalThisYearBeneficiary * 100,0)
		},
		sumAllYearAmount() {
			return this.distributed_reports_per_year.reduce((acc,val)=> acc + parseInt(val.Amount) / this.totalThisYearAmount * 100,0)
		}

	},
	filters: {
      currency(value) {
        return value.toFixed(2);
      }
    },
	created() {
		this.retrieveBarangays();
		this.retrieveDistributedReports();
		this.retrieveDistributedMedicinePerYear();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
});