(function() {
   $.subscribe('form.submitted', function(){
       $('.flash').fadeIn(500).delay(1000).fadeOut(500);
   }); 
})();