// refresh chat
function refreshChat() {
	// $.ajax({
	// 	url: 'php-include/refresh-chat.php',
	// 	success: function(data){
	// 		$response = JSON.parse(data);
	//
	//     },
	// 	error: function(error) {
	//
	// 	},
	// 	complete: function() {
	//
	// 	}
	// })
	$('#chat-contents-container').load(location.href + " #chat-contents-container>*", "");
	setTimeout('refreshChat()', 1000);
}

$('.chat-input-container').on('submit', function(event) {
	event.preventDefault();

	var serializedData = $(this).serialize();
	$.ajax({
		url: 'php-include/send-chat.php',
		type: 'POST',
		data: serializedData,
		success: function(data) {
			var response = JSON.parse(data);
			if (response['error']) {
				alert(response['error']);
			}
			$('#chat-contents-container').load(location.href + " #chat-contents-container>*", "");
			document.getElementById('chat').scrollTo(document.getElementById('chat').scrollHeight);
			$('.chat-text-input').val('');
			$('.chat-text-input').focus();
		},
		error: function(error) {

		}
	})

});

$(document).ready(function() {
	refreshChat();
});
