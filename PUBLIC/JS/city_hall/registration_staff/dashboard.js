var vm = new Vue({
	el : "#vue-dashboard",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/city_hall/registration_staff/",

		fourPs_beneficiaries : [],

		pwd_beneficiaries : [],

		age_brackets : [],

		added_beneficiaries : [],

		gender : [],

		myChart : "",
		myChart2 : "",
		myChart3 : "",
		myChart4 : ""

	},
	methods : {
		retrieve4ps : function() {
			axios.get(this.urlRoot + this.api + "4P's/" + "retrieve_4ps_beneficiary.php")
			.then(function (response) {
				console.log(response);
				vm.fourPs_beneficiaries = response.data;
			});
		},
		retrievePwd : function() {
			axios.get(this.urlRoot + this.api + "pwd/" + "retrieve_pwd_beneficiary.php")
			.then(function (response) {
				console.log(response);
				vm.pwd_beneficiaries = response.data;
			});
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
		retrieveAddedBeneficiary : function() {
		    var self = this;
		    var sum = 0;
		   
		    axios.post(this.urlRoot + this.api + "retrieve_added_beneficiary.php")
		   	.then(response => {
		   		console.log(response);
		    	vm.added_beneficiaries = response.data
				    var ctxChart = self.$refs.myChart.getContext('2d');

				    if (this.myChart) this.myChart.destroy();
				    this.myChart = new Chart(ctxChart, {
				        type: 'bar',
				        data: {
				          	labels: vm.added_beneficiaries.map(item => item.Month),
				          	datasets: [{
				            label: 'Total Beneficiary',
				            data: vm.added_beneficiaries.map(item => item.Total),
				            backgroundColor: this.poolColors(vm.added_beneficiaries.length),
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
							text : "Monthly Added Beneficiary",
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
		retrieveAge : function() {
		    var self = this;
		    var sum = 0;
		   
		    axios.post(this.urlRoot + this.api + "retrieve_ages_reports.php")
		   	.then(response => {
		   		console.log(response);
		    	vm.age_brackets = response.data
				    var ctxChart = self.$refs.myChart2.getContext('2d');

				    for(var i = 0; i < this.age_brackets.length; i++) {
				    	sum += parseFloat(this.age_brackets[i].Total);
				    }

				    if (this.myChart2) this.myChart2.destroy();
				    this.myChart2 = new Chart(ctxChart, {
				        type: 'horizontalBar',
				        data: {
				          	labels: vm.age_brackets.map(item => item.Bracket),
				          	datasets: [{
				            label: 'Total',
				            data: vm.age_brackets.map(item => (item.Total / sum * 100).toFixed(2)),
				            backgroundColor: this.poolColors(vm.age_brackets.length),
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
							text : "Age",
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
		retrieveGender : function() {
		    var self = this;
		    var sum = 0;
		   
		    axios.post(this.urlRoot + this.api + "retrieve_sex_reports.php")
		   	.then(response => {
		   		console.log(response);
		    	vm.gender = response.data
				    var ctxChart = self.$refs.myChart4.getContext('2d');

				    for(var i = 0; i < this.gender.length; i++) {
				    	sum += parseFloat(this.gender[i].Total);
				    }

				    if (this.myChart4) this.myChart4.destroy();
				    this.myChart4 = new Chart(ctxChart, {
				        type: 'bar',
				        data: {
				          	labels: vm.gender.map(item => item.Sex),
				          	datasets: [{
				            label: 'Total',
				            data: vm.gender.map(item => (item.Total / sum * 100).toFixed(2)),
				            backgroundColor: this.poolColors(vm.gender.length),
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
							text : "Gender",
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
	created() {
		this.retrieve4ps();
		this.retrievePwd();
		this.retrieveAge();
		this.retrieveGender();
		this.retrieveAddedBeneficiary();

		setInterval(() => {
			this.getSession();
		}, 3000)
	}
})