// Basic events publish/subscribe API
(function($) {
    var o = $({});
    
    // subscribe for listening for an event
    $.subscribe = function() {
        o.on.apply(o, arguments);
    };
    
    // unsubscribe from listening for an event
    $.unsubscribe = function() {
        o.off.apply(o, arguments);
    };
    
    // trigger an event
    $.publish = function() {
        o.trigger.apply(o, arguments);
    };
}(jQuery));
