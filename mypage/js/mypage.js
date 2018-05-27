$(document).ready(function() {
	$(".priv-t").bind('click', function(event) {
		$parent = $(this).parent();
		if ($parent.hasClass("toggled")) {
			$parent.removeClass("toggled");
		} else {
			$parent.addClass("toggled");
		}
	});
});
