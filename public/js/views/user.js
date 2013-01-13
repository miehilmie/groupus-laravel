/*
Author : Muhammad Hilmi
*/
(function($){
	$('.star.clickable').mouseover(function() {
		var index = $(this).attr('data-value');
		$(this).parent().find('.star.clickable').each(function(i,v) {
			if(i < index) {
				$(this).addClass('hover');
			}
		});

	}).mouseout(function() {
		$(this).parent().find('.star.clickable').each(function(i,v) {
			$(this).removeClass('hover');
		});

	}).click(function() {
		var value = $(this).attr('data-value');
		var input = $("<input>").attr("type", "hidden").attr("name", "votes").val(value);
		$(this).parents('form').append($(input)).submit();

	});
})(jQuery);
