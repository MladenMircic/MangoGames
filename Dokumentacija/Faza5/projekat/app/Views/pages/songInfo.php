<script>
    $("#playAudio").click(function () {
        window.audio.play();
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
    <input type="button" class="btn btn-sm btn-light" value="Play" id="playAudio">
</div>