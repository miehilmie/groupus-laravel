(function($){
    $('.add-new').click(function(e) {
        e.preventDefault();
        var i = $(this).attr('data-target');
        popup(i);
    });
    
    $('.bubbleTrigger').bubbleToggle();
})(jQuery);
