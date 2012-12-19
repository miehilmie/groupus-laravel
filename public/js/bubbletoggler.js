(function(){
    $.fn.leftToggler = function(option){
        return this.each(function(i,el) {
            var base = el, $base = $(el);
            var a = {
                isItemClick: function(e) {
                    return (a.active && a.active.has(e.target).length > 0);
                },
                isFlyoutClick: function(e) {
                    return (a.active && $('#'+a.active.attr('data-target')).has(e.target).length > 0);
                },
                toggleDisplay: function(e) {
                    if(a.isFlyoutClick(e))
                        return;

                    if(a.isItemClick(e)) {
                        a.closeDropdown();
                    }
                    else {
                        a.closeDropdown();
                        a.active = $base, a.active.parent().addClass("open")
                    }
                },
                closeDropdown: function() {
                    $base.parent().removeClass("open"), a.active = false;
                }
                ,
                close: function(e) {
                    if(a.isFlyoutClick(e) || $base.has(e.target).length > 0)
                        return;

                    a.closeDropdown();
                },
                init: function() {
                    $("html").live("keydown", function(c) {
                        c.which == 27 && a.close(c);
                    }),            
                    $base.click(a.toggleDisplay),
                    $(document).click(a.close);
                }
            }
            a.init();
        });
        
    }
    
    $(document).ready(function() {
        $('.bubbleToggler').leftToggler();
    });
})();
