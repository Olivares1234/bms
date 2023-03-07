var vm = new Vue({
	el : "#vue-search",
	data : {
		urlRoot : "/bms/public/",
		api : "/api's/search/",

		beneficiary_transactions: [],

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

		search_beneficiary : "",
		start_date : "", 
		end_date : "" 
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
		// pagination methods
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
		searchBeneficiaryId : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary_transaction.php")
			.then(function (response) {
				vm.beneficiary_transactions = response.data;
				console.log(response);

				// window.location = '../../../bms/public/search/index.php';

			});
		},
		saveBeneficiaryId : function() {
			axios.get(this.urlRoot + this.api + "save_beneficiary_id.php?beneficiary_id=" + this.search_beneficiary)
			.then(function (response) {
				console.log(response);

				window.location = '../../../bms/public/search/index.php';

			});
		},
		searchByDate : function() {
			if(this.start_date && this.end_date) {
				axios.get(this.urlRoot + this.api + "search_start_end_date_transaction.php?beneficiary_id=" + this.beneficiary_id + "&start_date=" + this.start_date + "&end_date=" + this.end_date)
				.then(function (response) {
					vm.beneficiary_transactions = response.data;
					console.log(response);
				});
			}
		},
		formatPrice(value) {
	        let val = (value/1).toFixed(2)
	        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
	    },
	    backToHomepage : function() {
	    	window.location = '../../../bms/public/index.php';
	    }
	},
	computed : {
		totalPages: function() {
	    	return Math.ceil(this.beneficiary_transactions.length / this.show_entries)
	   	},
	   	totalAmount: function() {
	   		var total = 0;
	   		for(var i = 0; i < this.beneficiary_transactions.length; i++) {
	   			total += parseFloat(this.beneficiary_transactions[i].total_price);
	   		}
	   		return total;
	   	},
	   	totalBeneficiaryRemainingBalance : function() {
			let total = 10000;
	   		let balance = 0;
	   		for (var i = 0; i < this.beneficiary_transactions.length; i++) {
				balance += (parseFloat(this.beneficiary_transactions[i].total_price));
			}
			return total = (parseFloat(total) - parseFloat(balance));
		}
	},
	filters : {
		currency(value) {
	       	return value.toFixed(2);
	    }
	},
	created() {
		this.searchByDate();
		this.searchBeneficiaryId();

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