Vue.directive('focus', {
  // When the bound element is inserted into the DOM...
  inserted: function (el) {
    // Focus the element
    el.focus()
  }
});

var vm = new Vue({
	el : "#vue-login",
	data : {
		urlRoot : "/bms/public",
		api : "/api's/login/",

		username : "",
		password : "",

		username_error : false,
		password_error : false,

		username_error_text : "",
		password_error_text : ""
	},
	methods : {
		loginUser : function() {
			if(this.username == "") {
				this.username_error = true
				this.username_error_text = "Username cannot be blank!";
			}
			else {
				this.username_error = false;
			}

			if(this.password == "") {
				this.password_error = true;
				this.password_error_text = "Password cannot be blank!";
			}
			else {
				this.password_error = false;
			}

			if(this.username != '' && this.password != '') {
				axios.post(this.urlRoot + this.api + "login.php", {
					username : this.username,
					password : this.password
				}).then(function (response) {
					console.log(response);
					if(response.data.message == "incorrect password") {
						vm.password_error_text = "Invalid Password!";
						vm.username_error = false;
						vm.password_error = true;
					}
					else if(response.data == "") {
						vm.username_error_text = "Invalid Username!";
						vm.username_error = true;
						vm.password_error = false;
					}
					else {
						for(var index = 0; index < response.data.length; index++) {
							if(response.data[index].is_employed == 0) {
								swal({
									title : "Warning!",
									text : "You're account has been deactivated!",
									icon : "warning",
									timer : 2000,
									buttons : false,
									closeOnClickOutside : false
								});
							}
							else if(response.data[index].user_type_id == 5) {
								swal({
									title : "Warning!",
									text : "You're account not assign yet!",
									icon : "warning",
									timer : 2000,
									buttons : false,
									closeOnClickOutside : false
								});
							}
							else {
								if(response.data[index].user_type_id == 4) {
									window.location = '../../../bms/public/pages/barangay/health_worker/dashboard.php';
								}
								else if(response.data[index].user_type_id == 1 && response.data[index].barangay_id != 19) {
									window.location = '../../../bms/public/pages/barangay/admin/dashboard.php';
								}
								else if(response.data[index].user_type_id == 1 && response.data[index].barangay_id == 19) {
									window.location = '../../../bms/public/pages/city_hall/admin/dashboard.php';
								}
								else if(response.data[index].user_type_id == 2 && response.data[index].barangay_id == 19) {
									window.location = '../../../bms/public/pages/city_hall/pharmacist/dashboard.php';
								}
								else if(response.data[index].user_type_id == 3 && response.data[index].barangay_id == 19) {
									window.location = '../../../bms/public/pages/city_hall/registration_staff/dashboard.php';
								}
							}
						}
					}
				})
			}
		},
	}
})