<!--
    Kosta Dimitrijević 0467/2018
-->

<script>
    $("#playAudio").click(function () {
        window.audio.play();
    });

    $("#stopAudio").click(function () {
        window.audio.pause();
    });

    $("#backToMenu").click(function(){
        $(".center").load("<?php
            if (session()->get("type") == "mod") echo base_url('Moderator/echoView/modMenu');
            else echo base_url("Administrator/echoView/adminMenu") ?>");
    });
</script>
<div class="offset-sm-3 col-sm-6 infoPart">
    <table class="table table-striped table-dark songInfoTable">
        <tr>
            <thead style="text-align: center">
                <th colspan="2" style="border-bottom: 5px solid #9c1616">
                    Song info
                </th>
            </thead>
        </tr>
    </table>
    <input type="button" class="btn btn-sm btn-dark" value="Play" id="playAudio">
    <input type="button" class="btn btn-sm btn-dark" value="Stop" id="stopAudio">
    <br>
    <br>
    <input type="button" class="btn btn-dark" value="Return to menu" id="backToMenu">
</div>