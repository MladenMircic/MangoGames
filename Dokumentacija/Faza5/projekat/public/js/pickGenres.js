$(document).ready(function(){
    let cnt=0;
    let isHovering=false;

    $(".toMove").click(function() {
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
               $("#confirmGenres").prop("disabled", false);
           }
           else $("#confirmGenres").prop("disabled", true);
        }
    });

    $("#confirmGenres").click(function (){
        let chosen=document.getElementsByClassName("chosen");
        $("#g1").attr("value", chosen[0].id);
        $("#g2").attr("value", chosen[1].id);
    });

    $(".toMove").hover(function(){
        if(!$(this).hasClass("chosen")) {
            isHovering = true;
            $(this).trigger('click');
            isHovering = false;
        }
    });
});
