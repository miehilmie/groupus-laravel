/*
Author : Muhammad Hilmi
*/
(function($){
	$('#messageContent .messageItem').mouseover(function() {
		$(this).find('.rightMenu').show();
	}).mouseout(function() {
		$(this).find('.rightMenu').hide();
	});
})(jQuery);
