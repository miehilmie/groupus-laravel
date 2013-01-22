(function($) {
	$('#newPost').guPopup({
        width: 700,
        height: 350,
        callback: function(options) {
            var o = options[0];
            var $base = options[1];

            o.body.html($('#newPostSubjectTmpl').html());
		}
	});

    $('#newAnnounce').guPopup({
        width: 700,
        height: 350,
        callback: function(options) {
            var o = options[0];
            var $base = options[1];

            o.body.html($('#newPostAnnounceTmpl').html());
        }
    });

    $('.subjectSetting').guPopup({
        width: 500,
        height: 450,
        callback: function(options) {
            var o = options[0];
            var $base = options[1];

            var template = _.template($('#subjectSettingTmpl').html());
            var id = $(this).attr('data-id');

            $.ajax({
                url: '/ajax/subjects/'+ id +'/rule',
                dataType: 'JSON',
                type: 'GET',
                success: function(m) {
                    var v = m.has_group;
                    var maxgroups = '';
                    var i;
                    for (i = 0; i <= 17; ++i) {
                        maxgroups += '<option '+ ((i == m.maxgroups) ? 'selected' : '') +' value="'+i+'">'+i+'</option>';
                    }

                    var maxstudents = '';
                    for (i = 0; i <= 17; ++i) {
                        maxstudents += '<option '+ ((i == m.maxstudents) ? 'selected' : '') +' value="'+i+'">'+i+'</option>';
                    }
                    o.body.html(template({
                        maxgroups: maxgroups,
                        maxstudents: maxstudents,
                        mode: m.mode,
                        enable: m.enable,
                        n_students: m.n_students
                    }));
                    o.body.find('input[name=mode]').change(function() {
                        o.body.find('.auto-extras').toggleClass('hidden');
                    });
                    o.body.find('.ajaxGenerate').click(function(e) {
                        if($(this).parents('form').find('input[name="prefix"]').val().length === 0) {
                            alert("Group prefix name is required");
                            return false;
                        }
                        var c = true;
                        if(v === true) {
                            c = confirm('Group is already found in this subject. Proceed with the settings will destroy all existing groups. Are sure you want to continue?');
                        }
                        return c;
                    });

                }
            });
        }
    });
    $('#viewGroup').guPopup({
        width: 700,
        height: 580,
        callback: function(options) {
            var o = options[0];
            var $base = options[1];

            var id = $(this).attr('data-id');


            $.ajax({
                url: '/ajax/subjects/'+ id +'/groups',
                dataType: 'JSON',
                type: 'GET',
                success: function(m) {

                    var join_group = _.template($('#viewGroupTmpl').html());
                    var group = _.template($('#groupTmpl').html());
                    var user = _.template($('#userGroupTmpl').html());

                    var group_html = '';

                    $.each(m.groups, function(i, v) {
                        var user_html = '';
                        if(v.users.length === 0) {
                            user_html = 'No student';
                        } else {
                            $.each(v.users, function(i, vo) {
                                user_html += user({id: vo.id, img_url: vo.img_url, name: vo.name });
                            });
                        }

                        group_html += group({group_name: v.name, group_userlist: user_html, group_id: v.id, enable: v.enable});
                    });

                    o.body.html(join_group({ ngroup: m.ngroup, maxstudents: m.maxstudents, group_list: group_html }));
                    o.body.find('.hovercard').guHovercard();

                    var allPanels = $('.accordion > dd').hide();

                    $('.accordion > dt > a').click(function() {
                        allPanels.slideUp();
                        $(this).parent().next().slideDown();
                        return false;
                    });
                }
            });
        }
    });

    $("#joinGroup").guPopup({
        width: 700,
        height: 530,
        callback: function(options) {
            var o = options[0];
            var $base = options[1];

            var id = $(this).attr('data-id');


            $.ajax({
                url: '/ajax/subjects/'+ id +'/groups',
                dataType: 'JSON',
                type: 'GET',
                success: function(m) {

                    var join_group = _.template($('#joinGroupTmpl').html());
                    var group = _.template($('#groupTmpl').html());
                    var user = _.template($('#userGroupTmpl').html());

                    var group_html = '';

                    $.each(m.groups, function(i, v) {
                        var user_html = '';
                        if(v.users.length === 0) {
                            user_html = 'No student';
                        } else {
                            $.each(v.users, function(i, vo) {
                                user_html += user({id: vo.id, img_url: vo.img_url, name: vo.name });
                            });
                        }
                        group_html += group({group_name: v.name, group_userlist: user_html, group_id: v.id, enable: v.enable});
                    });

                    o.body.html(join_group({ ngroup: m.ngroup, maxstudents: m.maxstudents, group_list: group_html }));
                    var allPanels = $('.accordion > dd').hide();

                    $('.accordion > dt > a').click(function() {
                        allPanels.slideUp();
                        $(this).parent().next().slideDown();
                        return false;
                    });
                }
            });
        }
    });





    var $aside = $('.rSide'),
        asideOffset = $aside.offset(),
        $window = $('.hasRight');

    $aside.css({'height': $window.innerHeight() });
})(jQuery);
