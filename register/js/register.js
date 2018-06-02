$(document).ready(function(){
	document.getElementById('input-id').addEventListener("focusout", function() {
		var values = $('#register-form').serialize();
		$.ajax({
			url: "php-include/register-verify.php",
			type: "POST",
			data: values,

			success: function(data) {
				var result = new Array();
				result = JSON.parse(data);
				if (result['id_err']) {
					document.getElementById('id-err').innerHTML = result['id_err'];
				} else {
					document.getElementById('id-err').innerHTML = "";
				}
			},
			error: function(error) {

			}
		});
	});

	document.getElementById('input-pw').addEventListener("focusout", function() {
		var values = $('#register-form').serialize();
		$.ajax({
			url: "php-include/register-verify.php",
			type: "POST",
			data: values,

			success: function(data) {
				var result = new Array();
				result = JSON.parse(data);
				if (result['pw_err']) {
					document.getElementById('pw-err').innerHTML = result['pw_err'];
				} else {
					document.getElementById('pw-err').innerHTML = "";
				}
			},
			error: function(error) {

			}
		});
	});

	document.getElementById('input-pw-cf').addEventListener("focusout", function() {
		var values = $('#register-form').serialize();
		$.ajax({
			url: "php-include/register-verify.php",
			type: "POST",
			data: values,

			success: function(data) {
				var result = new Array();
				result = JSON.parse(data);
				if (result['pw_cf_err']) {
					document.getElementById('pw-cf-err').innerHTML = result['pw_cf_err'];
				} else {
					document.getElementById('pw-cf-err').innerHTML = "";
				}
			},
			error: function(error) {

			}
		});
	});

	document.getElementById('input-nn').addEventListener("focusout", function() {
		var values = $('#register-form').serialize();
		$.ajax({
			url: "php-include/register-verify.php",
			type: "POST",
			data: values,

			success: function(data) {
				var result = new Array();
				result = JSON.parse(data);
				if (result['nn_err']) {
					document.getElementById('nn-err').innerHTML = result['nn_err'];
				} else {
					document.getElementById('nn-err').innerHTML = "";
				}
			},
			error: function(error) {

			}
		});
	});

	$("#register-form").submit(function(event){
		// prevent html form action
		event.preventDefault();

		// get all inputs inside form field
		$inputs = $(this).find("input, select, button, textarea");

		// $("#register-submit").addClass("loading");
		// $("#register-submit").val('확인중...');
		toggleLoading();

		var values = $('#register-form').serialize() + "&send=1";

		// disable input after serialize data inside
		$inputs.prop("disabled", true);
		$.ajax({
			url: "php-include/register-verify.php",
			type: "POST",
			data: values,

			success: function(data) {
				//alert(data); // debugging
				var result = new Array();
				result = JSON.parse(data);
				if (result['issuccess']) {
					// alert("인증 이메일을 발송했습니다. 이메일을 확인하세요.");
					// window.location.replace("welcome.php");
					$.redirectPost("welcome.php", {email: result['email']});
				} else {
					// $("#register-submit").removeClass("loading");
					// $("#register-submit").val('가입하기');
					if (result['id_err']) {
						document.getElementById('id-err').innerHTML = result['id_err'];
					} else {
						document.getElementById('id-err').innerHTML = "";
					}
					if (result['pw_err']) {
						document.getElementById('pw-err').innerHTML = result['pw_err'];
					} else {
						document.getElementById('pw-err').innerHTML = "";
					}
					if (result['pw_cf_err']) {
						document.getElementById('pw-cf-err').innerHTML = result['pw_cf_err'];
					} else {
						document.getElementById('pw-cf-err').innerHTML = "";
					}
					if (result['nn_err']) {
						document.getElementById('nn-err').innerHTML = result['nn_err'];
					} else {
						document.getElementById('nn-err').innerHTML = "";
					}
				}
			},
			error: function(request,status,error) {
				// alert(request + status + error);
				alert("알 수 없는 문제가 발생했습니다. 백스테이지에 문의하세요.");
			},
			complete: function() {
				// $("#register-submit").removeClass("loading");
				// $("#register-submit").val('가입하기');
				toggleLoading();
				$inputs.prop("disabled", false);
			}
		})
	})
});

// redirect page with POST variable function
$.extend(
{
    redirectPost: function(location, args)
    {
        var form = $('<form></form>');
        form.attr("method", "post");
        form.attr("action", location);

        $.each( args, function( key, value ) {
            var field = $('<input></input>');

            field.attr("type", "hidden");
            field.attr("name", key);
            field.attr("value", value);

            form.append(field);
        });
        $(form).appendTo('body').submit();
    }
});
