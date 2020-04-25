            // getting all form data
			var email     =   $("#email").val();


			// sending ajax request
			$.ajax({

				url: '../classes/User.php',
				type: 'post',
				data: {
					     'email': email,

                    },
                    // on success response
				success:function(response) {
					$("#result").html(response);

					// reset form fields
					$("#form-detail")[0].reset();
				},

				// error response
				error:function(e) {
					$("#result").html("Email already in use.");
				}

                })



