var vm = new Vue({
	el : "#vue-reports",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/barangay/admin/",

		transaction_per_day : [],

		transaction_per_year : [],

		first : true,
		second : false,

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

		myChart : "",
		myChart2 : "",
		myChart3 : "",
		myChart4 : ""
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
			doc.autoTable(columns, vm.transaction_per_day);
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
			doc.autoTable(columns, vm.transaction_per_year);
			doc.save('distributed-reports.pdf');

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
			this.retrieveDistributedReports();
			this.retrieveDistributedReportsYear();
			this.pagination(1);
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
		retrieveDistributedReports : function(search) {
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
		   
		    axios.post(this.urlRoot + this.api + "retrieve_transaction_per_day.php?search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		    	vm.transaction_per_day = response.data
				    var ctxChart = self.$refs.myChart.getContext('2d');

				    if (this.myChart) this.myChart.destroy();
				    this.myChart = new Chart(ctxChart, {
				        type: 'bar',
				        data: {
				          	labels: vm.transaction_per_day.map(item => item.Day),
				          	datasets: [{
				            label: 'Total',
				            data: vm.transaction_per_day.map(item => item.Amount),
				            backgroundColor: this.poolColors(vm.transaction_per_day.length),
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

			axios.post(this.urlRoot + this.api + "retrieve_transaction_per_day.php?search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		    	vm.transaction_per_day = response.data
				    var ctxChart = self.$refs.myChart2.getContext('2d');

				    for(var i = 0; i < this.transaction_per_day.length; i++) {
				    	sum += parseFloat(this.transaction_per_day[i].Amount);
				    }
				    if (this.myChart2) this.myChart2.destroy();
				    this.myChart2 = new Chart(ctxChart, {
				        type: 'pie',
				        data: {
				        	labels: vm.transaction_per_day.map(item => item.Day),
				          	datasets: [{
				            label: 'Total',
				            data: vm.transaction_per_day.map(item => (item.Amount / sum * 100).toFixed(2)),
				            backgroundColor: this.poolColors(vm.transaction_per_day.length),
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
	
		retrieveDistributedReportsYear : function() {
			var self = this;
		    var sum = 0;
		    var text = "";

			if (this.select_reports == "last_year") {
		    	text = "Distributed Reports Last Year"
		    } else if (this.select_reports == "this_year") {
		    	text = "Distributed Reports This Year"
		    } 

		    axios.post(this.urlRoot + this.api + "retrieve_transaction_this_year.php?search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		   		vm.transaction_per_year = response.data
		    
				    var ctxChart = self.$refs.myChart3.getContext('2d')

				    if (this.myChart3) this.myChart3.destroy();
				    this.myChart3 = new Chart(ctxChart, {
				        type: 'bar',
				        data: {
				          	labels: vm.transaction_per_year.map(item => item.Day),
				          	datasets: [{
				            label: 'Total Amount',
				            data: vm.transaction_per_year.map(item => item.Amount),
				            backgroundColor: this.poolColors(vm.transaction_per_year.length),
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

			axios.post(this.urlRoot + this.api + "retrieve_transaction_this_year.php?search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		    	vm.transaction_per_year = response.data
		    
				    var ctxChart = self.$refs.myChart4.getContext('2d');

				    for(var i = 0; i < this.transaction_per_year.length; i++) {
				    	sum += parseFloat(this.transaction_per_year[i].Amount);
				    }

				    if (this.myChart4) this.myChart4.destroy();
				    this.myChart4 = new Chart(ctxChart, {
				        type: 'pie',
				        data: {
				          	labels: vm.transaction_per_year.map(item => item.Day),
				          	datasets: [{
				            label: 'Total Amount',
				            data: vm.transaction_per_year.map(item => (item.Amount / sum * 100).toFixed(2)),
				            backgroundColor: this.poolColors(vm.transaction_per_year.length),
				            borderColor: '#eee',
				            borderWidth: 1
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
		totalQuantity() {
			return this.transaction_per_day.reduce((acc,val)=> acc + parseInt(val.Quantity),0)
		},
		totalBeneficiary() {
			return this.transaction_per_day.reduce((acc,val)=> acc + parseInt(val.Beneficiary),0)
		},
		totalAmount() {
			return this.transaction_per_day.reduce((acc,val)=> acc + parseInt(val.Amount),0)
		},
		totalThisYearQuantity() {
			return this.transaction_per_year.reduce((acc,val)=> acc + parseInt(val.Quantity),0)
		},
		totalThisYearBeneficiary() {
			return this.transaction_per_year.reduce((acc,val)=> acc + parseInt(val.Beneficiary),0)
		},
		totalThisYearAmount() {
			return this.transaction_per_year.reduce((acc,val)=> acc + parseInt(val.Amount),0)
		}
	},
	filters: {
      currency(value) {
        return value.toFixed(2);
      }
    },
	created() {
		this.retrieveDistributedReports();
		this.retrieveDistributedReportsYear();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
});