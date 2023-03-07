var vm = new Vue({
	el : "#vue-reports",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/gulod_api/",
		
		////// start of pagination /////////
		currentPage : 1,
		startIndex : 0,
		endIndex : 10,
		perPage: 10,
		show_entries : 10,
		show_entries_two : 10,
		show_entries_three : 10,
		////// end of pagination /////////

		reports : [],
		start_date : "",
		end_date : "",
	},
	methods : {
		retrieveTransactionReportsToday : function() {
			axios.get(this.urlRoot + this.api + "retrieve_transaction_today.php")
			.then(function (response) {
				vm.reports = response.data;
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
	},
	computed : {
		totalTransactionReportsToday: function() {
	    	let totalAmount = 0;
	    	for(let i = 0; i < this.reports.length; i++){
	    		totalAmount += (parseFloat(this.reports[i].total_price));
	      	}
	     	return totalAmount;
	   	},
	},
	filters: {
      currency(value) {
        return value.toFixed(2);
      }
    },
	created() {
		this.retrieveTransactionReportsToday();
	}
})