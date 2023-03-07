var vm = new Vue({
	el : "#vue-dashboard",
	data : {
		urlRoot : "/bms/public/",
		api : "api's/gulod_api/",

		available_medicines : [],
		gulod_inactive_medicines : [],

		beneficiaries : [],
	},
	methods : {
		retrieveGulodActiveMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_active_medicine.php")
			.then(function (response) {
				vm.available_medicines = response.data;
			});
		},
		retrieveBeneficiary : function() {
			axios.get(this.urlRoot + this.api + "retrieve_beneficiary.php")
			.then(function (response) {
				vm.beneficiaries = response.data;
				console.log(response);
			});
		},
		retrieveGulodInactiveMedicine : function() {
			axios.get(this.urlRoot + this.api + "retrieve_inactive_medicine.php")
			.then(function (response) {
				vm.gulod_inactive_medicines = response.data;
			});
		},


		countGulodAvailableMedicine : function() {
			var count = 0;

			for(var index  = 0; index < this.available_medicines.length; index++) {
				count++;
			}

			return count;
		},
		countBeneficiary : function() {
			var count = 0;

			for(var index  = 0; index < this.beneficiaries.length; index++) {
				count++;
			}

			return count;
		},
		countGulodUnavailableMedicine : function() {
			var count = 0;

			for(var index = 0; index < this.gulod_inactive_medicines.length; index++) {
				count++;
			}
			return count;
		},
	},
	created() {
		this.retrieveGulodActiveMedicine();
		this.retrieveBeneficiary();
		this.retrieveGulodInactiveMedicine();
	}
})