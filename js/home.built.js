$(document).ready(function() {
	var request;
	$("#main-quiz-form").submit(function(event){

		event.preventDefault();

		if (request) {
			request.abort();
		}

		var $form = $(this);

		var $inputs = $form.find("input, select, button, textarea");

		var serializedData = $form.serialize();


		$inputs.prop("disabled", true);


		request = $.ajax({
			url: "quizstage/php-include/checkanswer.php",
			async: false,
			type: "post",
			data: serializedData,
		});

		var result = new Array();

		request.done(function (response, textStatus, jqXHR) {
			console.log("AJAX POST Successed");

			result = JSON.parse(response);

			do {
				// Error
				if (result['error']) {
					console.log(result['error']);
					// not logged in
					if (!result['loggedin']) {
						$inputs.blur();
						openModal('login');
					} else {
						openModal(result['error']);
					}

					break;
				}
				if (result['issolved']) {
					if (result['isfirst']) { // first
						// alert("이 퀴즈의 첫번재 정답자입니다!");
						openQuizModal('quiz-correct-first');
					} else { // not first
						// alert("정답입니다!");
						openQuizModal('quiz-correct');
					}
					// $('#show-answer-field').load(location.href + " #show-answer-field>*", "");
				} else {
					// alert("오답입니다.");
					openQuizModal('quiz-wrong');
				}
				$('#globalnav').load(location.href + " #globalnav>*", "");
				$('#show-quiz-counter').load(location.href + " #show-quiz-counter>*", "");

			} while (0);
		});


		// Callback handler that will be called on failure
		request.fail(function (jqXHR, textStatus, errorThrown){
	        console.error(
	            "The following error occurred: " +
	            textStatus, errorThrown
	        );
	    });

		// Callback handler that will be called regardless
	    // if the request failed or succeeded
		request.always(function () {
	        // Reenable the inputs
	        $inputs.prop("disabled", false);
	    });
	})

});
