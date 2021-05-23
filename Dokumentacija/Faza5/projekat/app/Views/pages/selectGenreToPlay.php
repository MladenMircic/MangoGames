<script>
    $(document).ready(function () {
        let selected = null;

       $(".genreChoices img").on({
           click: function () {
               if (selected == null) {
                   $("#confirmGenre").prop("disabled", false);
                   selected = $(this).attr("id");
                   $(this).addClass("selectedGenre");
               }
               else if (selected === $(this).attr("id")) {
                   $("#confirmGenre").prop("disabled", true);
                   $(this).removeClass("selectedGenre");
                   selected = null;
               }
           },
           mouseenter: function () {
               if (selected == null)
                   $(this).addClass("selectedGenre");
           },
           mouseleave: function() {
               if (selected == null)
                   $(this).removeClass("selectedGenre");
           }
       });

        $("#confirmGenre").click(function () {
            if ($(this).parent().hasClass("center")) {
                let myself = $(this);
                $.get("<?= base_url("User/echoView/waitForPlayer") ?>", function (data) {
                    $("#insertable").html(data);
                    myself.remove();
                });
            }
            if ($(this).parent().attr("id") === "confirmGenreForm")
                $(this).parent().children("#chosenGenre").attr("value", selected);
        });
    });
</script>

<br>
<h4>Choose a genre to compete in</h4>
<br>
<div class="genreChoices">
    <?php
    foreach ($userInfo as $oneInfo) {
        $path = base_url("images/{$oneInfo->genre}.png");
        echo  "
               <picture>
                    <img src='{$path}' id='{$oneInfo->genre}'>
               </picture>
                ";
    }
    ?>
</div>
<br>
<br>