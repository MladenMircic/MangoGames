<script>
    $(document).ready(function () {
        $("#selectGenre").click(function () {
            $.get("<?= base_url("User/echoView/selectGenreToPlay/selectAvailableGenresForUser") ?>", function (data) {
                $("#insertable").html(data);
                $(".center").append("<input type='submit' id='confirmGenre' class='btn btn-dark btnRegister btnTransition' value='Choose' disabled>");
            });
        });

        $("#training").click(function () {
            $.get("<?= base_url("User/echoView/selectGenreToPlay/selectAvailableGenresForUser") ?>", function (data) {
                $("#insertable").html(data);
                let trainingForm = $("<form></form>").attr("id", "confirmGenreForm").attr("method", "post").attr("action", "<?= base_url("User/goToTraining") ?>");
                trainingForm.append("<input type='submit' id='confirmGenre' class='btn btn-dark btnRegister btnTransition' value='Choose' disabled>");
                trainingForm.append("<input type='hidden' name='chosenGenre' id='chosenGenre' value=''>");
                $(".center").append(trainingForm);
            });
        });

        $("#leaderboards").click(function (){
            $.post("<?=base_url('Moderator/echoView/leaderboards')?>", function(data){
                $(".center").html(data);
            });
        });

    });
</script>

<div id="insertable">
    <table class="table userInterfaceForm">
        <tr>
            <td>
                <input class="btn btn-dark" type="button" value="Search for opponents" id="selectGenre">
            </td>
        </tr>
        <tr>
            <td>
                <input class="btn btn-dark" type="submit" value="Genres & playlists">
            </td>
        </tr>
        <tr>
            <td>
                <input class="btn btn-dark" type="submit" value="Training" id="training">
            </td>
        </tr>
        <tr>
            <td>
                <input class="btn btn-dark" type="submit" id="leaderboards" value="Leaderboards">
            </td>
        </tr>
        <tr>
            <td>
                <input class="btn btn-dark" type="submit" value="Quit" id="quit">
            </td>
        </tr>
    </table>
</div>
