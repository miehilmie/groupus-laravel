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
                    o.body.html(template({
                        maxgroups: maxgroups, 
                        maxstudents: maxstudents,
                        mode: m.mode,
                        enable: m.enable
                    }));

                    $('.ajaxGenerate').click(function(e) {
                        if($(this).hasClass('disabled')) {
                        } else {

                        }
                        return false;
                    })


                }
            });
        }
    });

    $("#joinGroup").guPopup({
        width: 700,
        height: 730,
        callback: function(o, $base) {
            var id = $('#joinGroup').attr('data-id');


            $.ajax({
                url: '/ajax/subjects/'+ id +'/groups',
                dataType: 'JSON',
                type: 'GET',
                success: function(m) {

                    var join_group = _.template($('#joinGroupTmpl').html());
                    var group = _.template($('#groupTmpl').html());
                    var user = _.template($('#userGroupTmpl').html());

                    var group_html = '';

                    $.each(m, function(i, v) {
                        var user_html = '';

                        $.each(v.users, function(i, vo) {
                            user_html += user({id: vo.id, img_url: vo.img_url, name: vo.name })
                        });
                        group_html += group({group_name: v.name, group_userlist: user_html, group_id: v.id});
                    });




                    var allPanels = $('.accordion > dd').hide();

                    $('.accordion > dt > a').click(function() {
                        allPanels.slideUp();
                        $(this).parent().next().slideDown();
                        return false;
                    });



                    o.body.html(join_group({ group_list: group_html }));

                }
            });
        }
    });

    
  


    var $aside = $('.rSide'),
        asideOffset = $aside.offset(),
        $window = $('.hasRight');

    $aside.css({'height': $window.innerHeight() });
        
})(jQuery);