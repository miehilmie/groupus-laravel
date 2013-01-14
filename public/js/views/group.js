(function($) {
    $('#newPost').guPopup({
        width: 700,
        height: 350,
        callback: function(o, $base) {
            o.body.html($('#newPostGroupTmpl').html());
        }
    });
    var $aside = $('.rSide'),
        asideOffset = $aside.offset(),
        $window = $('.hasRight');

    $aside.css({'height': $window.innerHeight() });
})(jQuery);
