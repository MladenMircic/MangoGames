<script>
    $(document).ready(function () {
        $.post("<?= base_url("User/echoView/printGenreImages/getGenres") ?>", function (data) {
            let row = $("<tr></tr>").html(data);
            $(".genres-table").append(row);
            $('[data-toggle="popover"]').popover();

            let cnt=0;
            let isHovering=false;
            let allreadyUnlocked = false;

            $(".toMove").click(function() {
                if (isHovering == false) {
                    if ($(this).hasClass("chosen") == false && $(this).hasClass("unchosen") == false && cnt<1) {
                        //this is chosen first time - both classes are false
                        cnt++;
                        $(this).toggleClass("chosen");
                        let data = $(this).attr("data-content").split(" ");
                        if(data[2] == "unlocked"){
                            $("#train").attr("disabled", false);
                            allreadyUnlocked = true;
                        }
                        else {
                            $("#unlock").attr("disabled", false);
                            allreadyUnlocked = false;
                            $(this).attr("data-content", data[0] + " - " + "unlock");
                        }

                    } else if ($(this).hasClass("chosen") == true) {
                        //this is unchosen
                        cnt--;
                        let data = $(this).attr("data-content").split(" ");
                        if (!allreadyUnlocked) {
                            $(this).attr("data-content", data[0] + " - " + "locked");
                            $("#unlock").attr("disabled", true);
                        }
                        $("#train").attr("disabled", true);
                        $(this).toggleClass("chosen");
                        $(this).toggleClass("unchosen");
                    }
                    else if ($(this).hasClass("unchosen") == true) {
                        //this is chosen
                        let data = $(this).attr("data-content").split(" ");

                        if (!allreadyUnlocked) {
                            $("#unlock").attr("disabled", false);
                            $(this).attr("data-content", data[0] + " - " + "unlock");
                        }
                        $("#train").attr("disabled", false);
                        $(this).toggleClass("chosen");
                        $(this).toggleClass("unchosen");
                        cnt++;
                    }
                    if(cnt==1){
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
        })
    })
</script>


<br>
<h4>Training mode</h4>
<br>
<br>
<div class = "genreChoices">
    <table class="genres-table table">

    </table>
</div>
<br>
<input type="button" value = "Unlock" id="unlock" class="btn btn-dark btnRegister btnTransition" disabled = true>
<br>
<br>
<input type="button" value = "Train" id="train" class="btn btn-dark btnRegister btnTransition" disabled = true>