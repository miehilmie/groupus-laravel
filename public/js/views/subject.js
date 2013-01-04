(function($) {
	$('#newPostSubject').guPopup({
        width: 700,
        height: 250,
		callback: function(o, $base) {
            var template = _.template($('#newPostSubjectTmpl').html());
    		$.ajax({
    			url: '/ajax/users',
    			dataType: 'JSON',
    			type: 'GET',
    			success: function(m) {
    				var select = '';
    				$.each(m, function(i,v) {
    					select += '<option value="'+v.id+'">'+v.name+'</option>';
    				});
    				o.body.html(template({users: select}));
    			}
    		});
		}
	});

    var $aside = $('.rSide'),
        asideOffset = $aside.offset(),
        $window = $('.hasRight');

    $aside.css({'height': $window.innerHeight() });
        
})(jQuery);