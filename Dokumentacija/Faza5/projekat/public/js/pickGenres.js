$(document).ready(function(){
    let cnt=0;
    let isHovering=false;
    let chosen=[];
    $(".dropdown-toggle").click(function(){
        if(isHovering==false) {
            // if(chosen.includes($(this).attr("id"))){
            //    chosen.splice(chosen.findIndex(element => element == $(this).attr("id")),1);
            // }
            // else if (chosen.length<2){
            //     chosen.push($(this).attr("id"));
            // }
            // $("#chosen").empty();
            // for(let i=0;i<chosen.length;i++){
            //     let path="http://localhost:8080/images/"+chosen[i]+".png";
            //     $("#chosen").append($("<td></td>").append($("<img>").attr("src",path )));
            // }


            if($(this).hasClass("chosen")==false && $(this).hasClass("unchosen")==false ){
                $(this).toggleClass("chosen");
                cnt++;

            }
            else if(cnt<2){

                if($(this).hasClass("chosen")==true) cnt--;
                else if($(this).hasClass("unchosen")==true) cnt++;

                $(this).toggleClass("chosen");
                $(this).toggleClass("unchosen");
            }


        }
        });


    // $(".dropdown-toggle").hover(function(){
    // $(this).addClass("show-genre-name");
    //
    // });

    $(".dropdown-toggle").hover(function(){
        if(!$(this).hasClass("chosen")) {
            isHovering = true;
            $(this).trigger('click');
            isHovering = false;
        }


    });


});