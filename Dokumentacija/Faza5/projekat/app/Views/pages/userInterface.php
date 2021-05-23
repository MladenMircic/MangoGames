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
                <form method="post" action="#">
                    <input class="btn btn-dark" type="submit" value="Genres & playlists">
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <input class="btn btn-dark" type="submit" value="Training" id="training">
            </td>
        </tr>
        <tr>
            <td>
                <form method="post" action="#">
                    <input class="btn btn-dark" type="submit" value="Leaderboards">
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <form method="post" action="#">
                    <input class="btn btn-dark" type="submit" value="Quit">
                </form>
            </td>
        </tr>
    </table>
</div>
