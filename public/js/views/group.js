(function($) {
    $('#newPost').guPopup({
        width: 700,
        height: 350,
        callback: function(options) {
            var o = options[0];
            var $base = options[1];

            o.body.html($('#newPostGroupTmpl').html());
        }
    });
    var $aside = $('.rSide'),
        asideOffset = $aside.offset(),
        $window = $('.hasRight');

    $aside.css({'height': $window.innerHeight() });
})(jQuery);
