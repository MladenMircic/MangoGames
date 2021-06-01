<script>
    $(document).ready(function () {
        $("#selectGenre").click(function () {
            $.get("<?= base_url("User/echoView/selectGenreToPlay/selectAvailableGenresForUser") ?>", function (data) {
                $("#insertable").html(data);
                $(".center").append("<input type='submit' id='confirmGenre' class='btn btn-dark btnRegister btnTransition' value='Choose' disabled>");
            });
        });

        $("#training").click(function () {
            $.get("<?= base_url("User/echoView/training") ?>", function (data) {
                $(".center").html(data);
            })
        });

        $("#leaderboards").click(function (){
            $.post("<?=base_url('User/echoView/leaderboards')?>", function(data){
                $(".center").html(data);
            });
        });

        $("#quit").click(function () {
            $.post("<?= base_url("User/echoView/quit") ?>", function (data) {
                $(".center").html(data);
            });
        });

        $("#playlists").click(function () {
            $.post("<?= base_url("User/echoView/genresAndPlaylists") ?>", function (data) {
                $(".center").html(data);
            })
        });
    });
</script>

<div id="insertable">
    <table class="table userInterfaceForm">
        <tr>
            <td>
                <input class="btn btn-dark btnTransition" type="button" value="Search for opponents" id="selectGenre">
            </td>
        </tr>
        <tr>
            <td>
                <input class="btn btn-dark btnTransition" type="submit" value="Genres & playlists" id="playlists">
            </td>
        </tr>
        <tr>
            <td>
                <input class="btn btn-dark btnTransition" type="submit" value="Training" id="training">
            </td>
        </tr>
        <tr>
            <td>
                <input class="btn btn-dark btnTransition" type="submit" id="leaderboards" value="Leaderboards">
            </td>
        </tr>
        <tr>
            <td>
                <input class="btn btn-dark btnTransition" type="submit" value="Quit" id="quit">
            </td>
        </tr>
    </table>
</div>
