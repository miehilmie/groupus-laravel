(function($){
    $('.bubbleTrigger').bubbleToggle();
    $('#composeNewMsg').guPopup({
    	callback: function(o, $base) {
    		var users = {};
            var template = _.template($('#newMessageTmpl').html());

    		$.ajax({
    			url: '/ajax/users/',
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
    $('#addNewSubject').guPopup({
    	callback: function(o, $base) {
    		var users = {};
            var template = _.template($('#newSubjectTmpl').html());

    		$.ajax({
    			url: '/ajax/faculties/',
    			dataType: 'JSON',
    			type: 'GET',
    			success: function(m) {
    				var select = '<option value="0">---- NONE ----</option>';
    				$.each(m, function(i,v) {
    					select += '<option value="'+v.id+'">'+v.name+'</option>';
    				});
    				o.body.html(template({users: select}));
    				o.body.find('select[name=faculty]').change(function() {
    					$.ajax({
    						url: '/ajax/faculties/'+ $(this).val() +'/subjects/',
    						dataType: 'JSON',
    						type: 'GET',
    						success: function(mm) {
    							var select = '<option value="0">---- NONE ----</option>';
			    				$.each(mm, function(i,v) {
			    					select += '<option value="'+v.id+'">'+v.name+'</option>';
			    				});
    							o.body.find('.subjectSelect').html(select);

    						}
    					});
    				});
    			}
    		});
    	}
    });
})(jQuery);
