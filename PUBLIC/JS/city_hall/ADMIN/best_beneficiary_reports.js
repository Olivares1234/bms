var vm = new Vue({
	el : "#vue-best-beneficiary-reports",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/admin/",

		best_beneficiaries : [],

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
		myChart2 : ""
	},
	methods : {
		download: function() {
			var vm = this;
			var columns = [
				{title: "Beneficiary ID", dataKey: "Beneficiary"},
				{title: "Received Qty", dataKey: "Quantity"},
				{title: "Grand Total", dataKey: "Total"}
			];
			var doc = new jsPDF('p', 'pt');
			doc.text('\n\tTop Beneficiary Reports\n', 10, 12)
			doc.autoTable(columns, vm.best_beneficiaries);
			doc.save('top-beneficiary-reports.pdf');

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
		retrieveBestBeneficiarys : function(barangay_id, search) {
		    var self = this;
		    var sum = 0;
		    var myChart2;
		    var text = "";

		    if (this.select_reports == "") {
				text = "No data to show";
		    } else if(this.select_reports == "lifetime") {
		    	text = "Lifetime Best Beneficiary"
		    } else if (this.select_reports == "last_week") {
		    	text = "Last Week Best Beneficiary"
		    } else if (this.select_reports == "this_week") {
		    	text = "This Week Best Beneficiary"
		    } else if (this.select_reports == "last_month") {
		    	text = "Last Month Best Beneficiary"
		    } else if (this.select_reports == "this_month") {
		    	text = "This Month Best Beneficiary"
		    } else if (this.select_reports == "last_year") {
		    	text = "Last Year Best Beneficiary"
		    } else if (this.select_reports == "this_year") {
		    	text = "This Year Best Beneficiary"
		    } 
		   
		    axios.post(this.urlRoot + this.api + "best_beneficiary_reports.php?barangay_id=" + this.filter_search + "&search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		    	vm.best_beneficiaries = response.data
				    var ctxChart = self.$refs.myChart.getContext('2d');

				    if (this.myChart) this.myChart.destroy();
				    this.myChart = new Chart(ctxChart, {
				        type: 'bar',
				        data: {
				          	labels: vm.best_beneficiaries.map(item => item.Beneficiary),
				          	datasets: [{
				            label: 'Total Amount',
				            data: vm.best_beneficiaries.map(item => item.Total),
				            backgroundColor: this.poolColors(vm.best_beneficiaries.length),
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

			axios.post(this.urlRoot + this.api + "best_beneficiary_reports.php?barangay_id=" + this.filter_search + "&search=" + this.select_reports)
		   	.then(response => {
		   		console.log(response);
		    	vm.best_beneficiaries = response.data
				    var ctxChart = self.$refs.myChart2.getContext('2d');

				    for(var i = 0; i < this.best_beneficiaries.length; i++) {
				    	sum += parseFloat(this.best_beneficiaries[i].Total);
				    }

				    if (this.myChart2) this.myChart2.destroy();

				    this.myChart2 = new Chart(ctxChart, {
				        type: 'pie',
				        data: {
				        	labels: vm.best_beneficiaries.map(item => item.Beneficiary),
				          	datasets: [{
				            label: 'Total Amount',
				            data: vm.best_beneficiaries.map(item => (item.Total / sum * 100).toFixed(2)),
				            backgroundColor: this.poolColors(vm.best_beneficiaries.length),
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
	    	return Math.ceil(this.best_beneficiaries.length / this.show_entries)
	   	},
	   	totalAmount: function() {
	   		var total = 0;
	   		for(var i = 0; i < this.best_beneficiaries.length; i++) {
	   			total += parseFloat(this.best_beneficiaries[i].Total);
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
		this.retrieveBarangays();
		this.retrieveBestBeneficiarys();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
});