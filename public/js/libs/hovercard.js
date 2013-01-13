$(document).ready(function () {
   //  $('body').append(
   //  	$('<div/>', {
   //  		id: 'hovercard-container',
   //  		css: {
   //  			display: 'none'
   //  		}
   //  	})
   //  );
   //  $('.hovercard').mouseenter(function() {
   //  	var $t = $(this);
   //  	var id = $(this).attr('data-id');
   //  	var templateRef = $(this).attr('data-template');
   //  	var template = _.template($('#'+templateRef).html());
   //  	$(this).css({
   //  		'position' : 'relative',
   //  	}).addClass('hovercard-hover-'+id);
   //  	var $container = $('#hovercard-container');
   //  	var $cache = $container.find('.hovercardid-'+id);
   //  	if($cache.length === 0) {
   //  		$.ajax({
   //  			url: '/ajax/users/'+id,
   //  			dataType: 'JSON',
   //  			type: 'GET',
   //  			success: function(o) {
   //  				var $c = $(template({name: o.name, id: o.id, img_url: o.img_url}));
   //  				$container.append($c);

			//     	var $v = $('<div/>', {
			//     		id: 'hovercardid-'+id,
			//     	}).append($c.html());
   //  				$('.hovercard-hover-'+id).append($v);
			// 		$('.userTip, .userTip a').mouseenter(function() {
			// 			var time = jQuery.data($t, 'timeout');
			// 			console.log(time);
			// 	    	clearTimeout(time);
			// 	    });
   //  			}
   //  		})
   //  	}else {
	  //   	var $v = $('<div/>', {
	  //   		id: 'hovercardid-'+id,
	  //   	}).append($cache.html());
			// $('.hovercard-hover-'+id).append($v);

			// $('.userTip, .userTip a').mouseenter(function() {
			// 			var time = jQuery.data($t, 'timeout');
			// 	console.log(time)
		 //    	// clearTimeout(time);
		 //    });
   //  	}


   //  }).mouseout(function() {
   //  	var $t = $(this);

   //  	var to = setTimeout(function() {
   //  		// alert($(this));
   //  		var id = $t.attr('data-id');

   //  		$('#hovercardid-'+id).remove();

   //  		$t.css({
   //  			'position': ''
   //  		}).removeClass('hovercard-hover-'+id);

   //  		// clearTimeout(timeout);
   //  	}, 800);

   //  	jQuery.data($t, 'timeout', to);
   //   });
});