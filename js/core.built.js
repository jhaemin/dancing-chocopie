// get root dir from html attribute
var rd = $('html').data('root-dir');

// change editor display to inline-block on editing
// $('.dcp-editor').on('keyup', function(event) {
// 	if ($(this).html() != "") {
// 		$(this).css('display', 'inline-block');
// 	} else {
// 		$(this).css('display', 'block');
// 	}
// });

// place Caret at end for dcp-editor
function placeCaretAtEnd(el) {
    el.focus();
    if (typeof window.getSelection != "undefined"
            && typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(false);
        textRange.select();
    }
}

// toggle navigation bar
function toggleNav() {
	var $more = $('#gn-item-more-container');
	if ($more.hasClass('shown')) {
		$more.removeClass('shown');
	} else {
		$more.addClass('shown');
	}
}

// toggle notification box
function toggleNoti() {
	var $notiBox = $('#gn-user-noti');
	if ($notiBox.hasClass('shown')) {
		$notiBox.removeClass('shown');
		$('.gn-user-info').removeClass('toggled');
	} else {
		$notiBox.addClass('shown');
		$('.gn-user-info').addClass('toggled');
		// reload notification when notification box is shown
		$('#gn-user-noti').load(location.href + " #gn-user-noti>*", "");
		$.ajax({
			url: rd + '/php-include/update-noti-stat.php',
			success: function(data) {
			},
			error: function(error) {
			}
		})

	}
}

// delete all quiz notification
function deleteAllQuizNoti() {
	$.ajax({
		url: rd + '/php-include/delete-noti.php?type=quiz',
		success: function(data) {
			if (data) {
				// mysqli query error
				alert(data);
			}
			$('#gn-user-noti').load(location.href + " #gn-user-noti>*", "");
		},
		error: function(error) {
		}
	})
}

// popup modal
function openModal(type, event) {
	if (event != null) {
		event.preventDefault();
	}
	$dmg = $('#dcp-modal-global');
	if (type == 'login' && !$dmg.hasClass('popup')) {
		$dmg.find('h1').html("로그인해야 이용 가능한 기능입니다.");
		$dmg.find('.login-container').addClass('selected');
		$dmg.removeClass('hidden');
		setTimeout(function(){
			$dmg.addClass('popup');
		}, 50);
	} else {
		$('#dmg-content').find('h1').html(type);
		$dmg.removeClass('hidden');
		setTimeout(function(){
			$dmg.addClass('popup');
		}, 50);
	}

	return false;
}

// popup loading display
function toggleLoading() {
	if ($('#dcp-modal-loading').hasClass('hidden')) {
		$('#dcp-modal-loading').removeClass('hidden');
	} else {
		$('#dcp-modal-loading').addClass('hidden');
	}
}

// close modal
$('.dcp-modal').on('click', function(event) {
	var $modal = $(this);
	if ($modal.hasClass('popup')) {
		$modal.removeClass('popup');
		setTimeout(function(){
			$modal.find('.family').removeClass('selected');
			$modal.addClass('hidden');
			$('.dm-quiz-char').css('display', 'none');
		}, 200);
	}
});

// auto width input select
$('.auto-width-select').each(function() {
	$("#tmp-option").html($('option:selected', this).text());
	$(this).width($("#tmp-select").width());
});

$('.auto-width-select').change(function(){
	$("#tmp-option").html($('option:selected', this).text());
	$(this).width($("#tmp-select").width());
});

// blur input when press enter on all input field
$('.dcp-input').on('keyup', function(event) {
	if (event.keyCode == 13) {
		$(this).blur();
	}
});

// auto hiding nav
var lastScrollTop = 0;
var threshold = $(window).scrollTop();
var $nav = $('#globalnav');
$(window).scroll(function(event){
	var st = $(this).scrollTop();
	// alert(st);
	if (st > threshold + 50 && st > 0){
		// downscroll code
		if (!$nav.hasClass('hidden')) {
			$nav.addClass('hidden');
			if ($('#gn-item-more-container').hasClass('shown')) {
				$('#gn-item-more-container').removeClass('shown');
			}
			if ($('#gn-user-noti').hasClass('shown')) {
				$('#gn-user-noti').removeClass('shown');
			}
			if ($('.gn-user-info').hasClass('toggled')) {
				$('.gn-user-info').removeClass('toggled');
			}
		}
	}
	if (st < lastScrollTop){
		// upscroll code
		threshold = st;
		if ($nav.hasClass('hidden')) {
			$nav.removeClass('hidden');
		}
	}
	lastScrollTop = st;
});

// fetch notification
function fetchNotification() {
	$.ajax({
		url: rd + '/php-include/fetch-noti.php',
		success: function(data){
			var $response = JSON.parse(data);
			if ($response['count'] > 0) {
				$('#gn-noti-count').html($response['count']);
				$('#gn-noti-count').css('display', 'block');
			} else {
				$('#gn-noti-count').css('display', 'none');
			}
			setTimeout('fetchNotification()', 1500);
	    },
		error: function(error) {

		},
		complete: function() {

		}
	})

}

$(document).ready(function() {
	if ($('html').data('loggedin')) {
		fetchNotification();
	}
});

// go back button inside bake page
function goBack(path) {
	window.location.replace(path);
}
