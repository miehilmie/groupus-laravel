(function($){
    $('.bubbleTrigger').bubbleToggle(),
    
    $('.composeNewMsg').guPopup({
        height: 400,
        width: 800,
    	callback: function(o, $base) {
    		var users = {};
            var template = _.template($('#newMessageTmpl').html());

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
    }),
    $('#addNewSubject').guPopup({
    	callback: function(o, $base) {
    		var users = {};
            var template = _.template($('#newSubjectTmpl').html());

    		$.ajax({
    			url: '/ajax/subjects/available',
    			dataType: 'JSON',
    			type: 'GET',
    			success: function(m) {
    				var select = '<option value="0">---- NONE ----</option>';
    				$.each(m, function(i,v) {
    					select += '<option value="'+v.id+'">'+v.name+'</option>';
    				});
    				o.body.html(template({subjects: select}));
    			}
    		});
    	}
    });
})(jQuery);
