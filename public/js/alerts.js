$('document').ready(function(){

    $('#closeBtn').click(function(ev){
        ev.preventDefault();

        $(this).parent().animate({
            opacity:0
        },450,function(){
            this.remove();
        })
        
        
    });

});