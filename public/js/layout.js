$('document').ready(function(){

    $('#menu_icon').click(function(ev){
        ev.preventDefault();
        if(!$('#mobile-nav-body').hasClass('expanded')){
            $('#mobile-nav-body').animate({
                left:0
            },200);
            $('#mobile-nav-body').toggleClass("expanded")
            
        }else{
            $('#mobile-nav-body').animate({
                left:'-50vw'
            },200);
            $('#mobile-nav-body').toggleClass("expanded")
            
        }
    });

    $(document).click(function(ev){

        if(!$(event.target).is('#menu_icon')) {
            if($('#mobile-nav-body').hasClass('expanded')){
                $('#mobile-nav-body').animate({
                    left:'-50vw'
                },200);
                $('#mobile-nav-body').toggleClass("expanded")
            }

        }
    });

    
    

 

});