function openQuizModal(type) {
	var rootDir = $('html').data('root-dir');
	if (type == 'quiz-correct-first') {
		// $('#dm-quiz-container').append(content);
		$('.dm-quiz-char-c').css('display', 'block');
		$('.dm-quiz-alert-header').html("이 문제의 첫번째 정답자입니다!");
		$('.dm-quiz-get-cp-alert').find('.content').html("40CP를 획득했습니다.");
	} else if (type == 'quiz-correct') {
		$('.dm-quiz-char-c').css('display', 'block');
		$('.dm-quiz-alert-header').html("정답입니다!");
		$('.dm-quiz-get-cp-alert').find('.content').html("20CP를 획득했습니다.");
	} else if (type == 'quiz-wrong') {
		$('.dm-quiz-char-w').css('display', 'block');
		$('.dm-quiz-alert-header').html("오답입니다.");
		$('.dm-quiz-get-cp-alert').find('.content').html("1CP를 잃었습니다.");
	}
	$('#dcp-modal-quiz').removeClass('hidden');
	setTimeout(function(){
		$('#dcp-modal-quiz').addClass('popup');
	}, 50);
}

$(document).ready(function() {
	// Variable to hold request
	var request;

	// Bind to the submit event of our form
	$("#show-answer-form").submit(function(event){

		// Prevent default posting of form - put here to work in case of errors
		event.preventDefault();

		// Abort any pending request
		if (request) {
			request.abort();
		}

		// setup some local variables
		var $form = $(this);

		// Let's select and cache all the fields
		var $inputs = $form.find("input, select, button, textarea");

		// Serialize the data in the form
		var serializedData = $form.serialize();


		// Let's disable the inputs for the duration of the Ajax request.
	    // Note: we disable elements AFTER the form data has been serialized.
	    // Disabled form elements will not be serialized.
		$inputs.prop("disabled", true);


		// Fire off the request to /form.php
		request = $.ajax({
			url: "php-include/checkanswer.php",
			type: "post",
			data: serializedData,
		});

		var result = new Array();

		// Callback handler that will be called on success
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
					$('#show-answer-field').load(location.href + " #show-answer-field>*", "");
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

	// like quiz
	$("#like").submit(function(event){
		event.preventDefault();
		if (request) {
			request.abort();
		}
		var $form = $(this);
		var $inputs = $form.find("input, select, button, textarea");
		var serializedData = $form.serialize();
		$inputs.prop("disabled", true);

		request = $.ajax({
			url: "php-include/like.php",
			type: "post",
			data: serializedData,
		});

		var result = new Array();

		request.done(function (response, textStatus, jqXHR) {
			console.log("AJAX POST Successed");

			result = JSON.parse(response);

			// alert(result['recommend']);

			do {
				if (!result['issuccess']) {
					// alert(result['error_msg']);
					openModal(result['error_msg']);
					if (result['error_code'] == 0) {
						location.replace("index.php");
					}
					break;
				}

				$('#like').load(location.href + " #like>*", "");
				// alert("퀴즈를 추천했습니다.");
				openModal('퀴즈를 추천했습니다.');
			} while (0);
		});

		request.fail(function (jqXHR, textStatus, errorThrown){
	        console.error(
	            "The following error occurred: " +
	            textStatus, errorThrown
	        );
	    });

		request.always(function () {
	        $inputs.prop("disabled", false);
	    });
	})

	// add comment
	$("#sc-form").submit(function(event){
		event.preventDefault();
		if (request) {
			request.abort();
		}
		var $form = $(this);
		var $inputs = $form.find("input, select, button, textarea");
		var serializedData = $form.serialize();
		$inputs.prop("disabled", true);

		request = $.ajax({
			url: "php-include/add-comment.php",
			type: "post",
			data: serializedData,
		});

		var result = new Array();

		request.done(function (response, textStatus, jqXHR) {
			console.log("AJAX POST Successed");

			result = response;
			if (result) {
				// alert(result);
				openModal(result);
			} else {
				$('#sc-item-container').load(location.href + " #sc-item-container>*", "");
				$('#comment-content').val("");
				$('#sc-header-wrapper').load(location.href + " #sc-header-wrapper>*", "");
			}
			$inputs.prop("disabled", false);

		});

		request.fail(function (jqXHR, textStatus, errorThrown){
	        console.error(
	            "The following error occurred: " +
	            textStatus, errorThrown
	        );
			$inputs.prop("disabled", false);
	    });

		request.always(function () {

	    });
	})
});

// add reply
function addReply($form) {
	event.preventDefault();

	// convert DOM object to jQuery object
	$form = jQuery($form);

	var request;
	if (request) {
		request.abort();
	}
	var $inputs = $form.find("input, select, button, textarea");
	var serializedData = $form.serialize();
	$inputs.prop("disabled", true);

	request = $.ajax({
		url: "php-include/add-reply.php",
		type: "post",
		data: serializedData,
	});

	var result = new Array();

	request.done(function (response, textStatus, jqXHR) {
		console.log("AJAX POST Successed");

		result = response;
		if (result) {
			// alert(result);
			openModal(result);
		} else {
			$('#sc-item-container').load(location.href + " #sc-item-container>*", "");
			$('#sc-header-wrapper').load(location.href + " #sc-header-wrapper>*", "");
		}
		$inputs.prop("disabled", false);

	});

	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occurred: " +
			textStatus, errorThrown
		);
		$inputs.prop("disabled", false);
	});

	request.always(function () {

	});
}

// get quiz_id from html which inserted by PHP
var $quiz_id = $('#quiz_id').val();

// expand reply form
function expandCommentInputForm($button, $mode) {

	$button = jQuery($button); // convert DOM object to jQuery object
	$parent = $button.parents('.sc-item');

	// get comment_id from html
	if ($mode == 'add-reply') {
		var $comment_id = $parent.children('.comment_id').val();
		// html snippets for reply form
		var $form = '<form class="expanded-form sc-reply-form" style="height:0;overflow:hidden;" onsubmit="addReply(this)">'+
			'<div class="expanded-form-wrapper">'+
			'<input type="hidden" name="quiz_id" value="' + $quiz_id + '" />' +
			'<input type="hidden" name="comment_id" value="' + $comment_id + '" />'+
			'<input class="reply-content dcp-input" type="text" name="content" value="" placeholder="답글을 입력하세요." autocomplete="off" />'+
			'<button class="reply-submit dcp-button white sc-submit" type="submit">답글 달기</button>'+
			'</div>'+
		'</form>';
	} else if ($mode == 'edit-reply') {
		var $reply_id = $parent.children('.reply_id').val();
		var $content = $parent.find(".sc-item-content").find("p").text();
		var $form = '<form class="expanded-form sc-reply-form" style="height:0;overflow:hidden;" onsubmit="editCommentReply(this)">'+
			'<div class="expanded-form-wrapper">'+
			'<input type="hidden" name="mode" value="reply" />'+
			'<input type="hidden" name="comment_reply_id" value="' + $reply_id + '" />'+
			'<input class="reply-content dcp-input" type="text" name="content" value="'+$content+'" placeholder="새로운 답글을 입력하세요." autocomplete="off" />'+
			'<button class="reply-submit dcp-button white sc-submit" type="submit">수정 완료</button>'+
			'</div>'+
		'</form>';
	} else if ($mode == 'edit-comment') {
		var $comment_id = $parent.children('.comment_id').val();
		var $content = $parent.find(".sc-item-content").find("p").text();
		var $form = '<form class="expanded-form sc-form" style="height:0;overflow:hidden;" onsubmit="editCommentReply(this)">'+
			'<div class="expanded-form-wrapper">'+
			'<input type="hidden" name="mode" value="comment" />'+
			'<input type="hidden" name="comment_reply_id" value="' + $comment_id + '" />' +
			'<input class="comment-content dcp-input" type="text" name="content" value="'+$content+'" placeholder="새로운 댓글을 입력하세요." autocomplete="off" />'+
			'<button class="comment-submit dcp-button white sc-submit" type="submit" name="mode" value="comment">수정 완료</button>'+
			'</div>'+
		'</form>';
	}


	if ($parent.hasClass('toggled')) {
		$parent.next().css("height", "0");
		setTimeout(function(){
			$parent.next('.expanded-form').remove();
			$parent.removeClass('toggled');
		}, 200);
	} else {
		$parent.addClass('toggled');
		$($form).insertAfter($parent);
		$parent.next('.expanded-form').css("height", $parent.next('.expanded-form').children('.expanded-form-wrapper').height() + 20);
	}
}

// delete comment
function deleteComment($form) {
	event.preventDefault();

	var r = confirm("정말 삭제하시겠습니까?");

	if (r) {

		// convert DOM object to jQuery object
		$form = jQuery($form);

		$form.parents('.sc-item').addClass('fadeout');

		var request;
		if (request) {
			request.abort();
		}
		var $inputs = $form.find("input, select, button, textarea");
		var serializedData = $form.serialize();
		$inputs.prop("disabled", true);

		request = $.ajax({
			url: "php-include/delete-comment.php",
			type: "post",
			data: serializedData,
		});

		var result = new Array();

		request.done(function (response, textStatus, jqXHR) {
			console.log("AJAX POST Successed");

			result = response;
			if (result) {
				// alert(result);
				openModal(result);
			} else {
				$('#sc-item-container').load(location.href + " #sc-item-container>*", "");
				$('#sc-header-wrapper').load(location.href + " #sc-header-wrapper>*", "");
			}

		});

		request.fail(function (jqXHR, textStatus, errorThrown){
			console.error(
				"The following error occurred: " +
				textStatus, errorThrown
			);
		});

		request.always(function () {
			$inputs.prop("disabled", false);
		});
	}

}

// delete reply
function deleteReply($form) {
	event.preventDefault();

	var r = confirm("정말 삭제하시겠습니까?");

	if (r) {
		// convert DOM object to jQuery object
		$form = jQuery($form);

		$form.parents('.sc-item').addClass('fadeout');

		var request;
		if (request) {
			request.abort();
		}
		var $inputs = $form.find("input, select, button, textarea");
		var serializedData = $form.serialize();
		$inputs.prop("disabled", true);

		request = $.ajax({
			url: "php-include/delete-reply.php",
			type: "post",
			data: serializedData,
		});

		var result = new Array();

		request.done(function (response, textStatus, jqXHR) {
			console.log("AJAX POST Successed");

			result = response;
			if (result) {
				// alert(result);
				openModal(result);
			} else {
				$('#sc-item-container').load(location.href + " #sc-item-container>*", "");
				$('#sc-header-wrapper').load(location.href + " #sc-header-wrapper>*", "");
			}

		});

		request.fail(function (jqXHR, textStatus, errorThrown){
			console.error(
				"The following error occurred: " +
				textStatus, errorThrown
			);
		});

		request.always(function () {
			$inputs.prop("disabled", false);
		});
	}
}

// edit comment & reply
function editCommentReply($form) {
	event.preventDefault();

	// convert DOM object to jQuery object
	$form = jQuery($form);

	var request;
	if (request) {
		request.abort();
	}
	var $inputs = $form.find("input, select, button, textarea");
	var serializedData = $form.serialize();
	$inputs.prop("disabled", true);

	request = $.ajax({
		url: "php-include/edit-comment-reply.php",
		type: "post",
		data: serializedData,
	});

	var result = new Array();

	request.done(function (response, textStatus, jqXHR) {
		console.log("AJAX POST Successed");

		result = response;
		if (result) {
			// alert(result);
			openModal(result);
		} else {
			$('#sc-item-container').load(location.href + " #sc-item-container>*", "");
			$('#sc-header-wrapper').load(location.href + " #sc-header-wrapper>*", "");
		}

	});

	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occurred: " +
			textStatus, errorThrown
		);
	});

	request.always(function () {
		$inputs.prop("disabled", false);
	});

}

$('#title-as-article').change(function() {
	if ($(this).is(":checked")) {
		$('#bake-article').html($('#bake-title').val());
	} else {
		$('#bake-article').html("");
	}
});

$(window).on('load', function() {
	$('.auto-width-select').each(function(index) {
		$("#tmp-option").html($('option:selected', this).text());
		$(this).width($("#tmp-select").width());
	});

	$('.auto-width-select').change(function(){
		$("#tmp-option").html($('option:selected', this).text());
		$(this).width($("#tmp-select").width());
	});
});

// image upload when baking a quiz
$('#bake-img').on('change', function(event) {
	event.preventDefault();
	// alert("a file has been selected");

	toggleLoading();

	var data = new FormData();
	$.each(jQuery('#bake-img')[0].files, function(i, file) {
	    data.append('file-' + i, file);
	});

	$.ajax({
	    url: '../php-include/upload-image.php',
	    data: data,
	    cache: false,
	    contentType: false,
	    processData: false,
	    type: 'POST',
	    success: function(data){
			if (data.indexOf('https') != -1) {
				var path = '<img src="' + data + '" alt="image" />'
				$('#bake-article').append(path);
				$('#bake-article').focus();
				var ba = document.getElementById('bake-article');
				placeCaretAtEnd(ba);
				ba.scrollTop = ba.scrollHeight;
				toggleLoading();
			} else {
				openModal(data);
				toggleLoading();
			}
	    },
		error: function(error) {
			openModal('일시적인 오류가 발생했습니다. 계속 오류가 발생할 경우 백스테이지에 문의해주세요.');
		},
		complete: function() {

		}
	});
});

// submit bake with button
$('.bake-submit').on('click', function(event) {
	event.preventDefault();
	var s = $('#bake-article').html().replace(/(\r\n|\n|\r)/gm,"");
	// alert(s);
	$('#bake-hidden-article').val(s);
	$('.bake-form').submit();
});
