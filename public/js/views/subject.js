(function($) {
	$('#newPost').guPopup({
        width: 700,
        height: 300,
		callback: function(o, $base) {
    		o.body.html($('#newPostSubjectTmpl').html());
		}
	});
    $('#subjectSetting').guPopup({
        width: 500,
        height: 450,
        callback: function(o, $base) {
            var template = _.template($('#subjectSettingTmpl').html());
            var id = $('#subjectSetting').attr('data-id');

            $.ajax({
                url: '/ajax/subjects/'+ id +'/rule',
                dataType: 'JSON',
                type: 'GET',
                success: function(m) {
                    var maxgroups = '';
                    for (var i = 0; i <= 17; ++i) {
                        maxgroups += '<option '+ ((i == m.maxgroups) ? 'selected' : '') +' value="'+i+'">'+i+'</option>';
                    };

                    var maxstudents = '';
                    for (var i = 0; i <= 17; ++i) {
                        maxstudents += '<option '+ ((i == m.maxstudents) ? 'selected' : '') +' value="'+i+'">'+i+'</option>';
                    };
                    console.log(m.enable);
                    o.body.html(template({
                        maxgroups: maxgroups, 
                        maxstudents: maxstudents,
                        mode: m.mode,
                        enable: m.enable
                    }));
                }
            });
        }
    });

    $("#joinGroup").guPopup({
        width: 700,
        height: 300,
        callback: function(o, $base) {
            $.ajax({
                url: '/ajax/users',
                dataType: 'JSON',
                type: 'GET',
                success: function(m) {
                    o.body.html($('#newPostSubjectTmpl').html());

                }
            });
        }
    });

    var $aside = $('.rSide'),
        asideOffset = $aside.offset(),
        $window = $('.hasRight');

    $aside.css({'height': $window.innerHeight() });
        
})(jQuery);