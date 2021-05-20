$(document).ready(function(){
    let cnt=0;
    let isHovering=false;
    let chosen=[];
    $(".dropdown-toggle").click(function() {
        if (isHovering == false) {


            if ($(this).hasClass("chosen") == false && $(this).hasClass("unchosen") == false && cnt<2) {
                //this is chosen first time - both classes are false
                cnt++;
                $(this).toggleClass("chosen");

            } else if ($(this).hasClass("chosen") == true) {
                //this is unchosen
                cnt--;
                $(this).toggleClass("chosen");
                $(this).toggleClass("unchosen");
            } else if (cnt < 2) {
                //this is chosen
                $(this).toggleClass("chosen");
                $(this).toggleClass("unchosen");
                cnt++;
            }
           if(cnt==2){
               $("#chooseGenres").prop("disabled", false);
           }
           else $("#chooseGenres").prop("disabled", true);


        }




        });




    $(".dropdown-toggle").hover(function(){
        if(!$(this).hasClass("chosen")) {
            isHovering = true;
            $(this).trigger('click');
            isHovering = false;
        }


    });


});