<script>
    $(document).ready(function () {
        $("#selectGenre").click(function () {
            $.get("<?= base_url("User/echoView/selectGenreToPlay/selectGenreToPlay") ?>", function (data) {
                $("#insertable").html(data);
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
                <form method="post" action="#">
                    <input class="btn btn-dark" type="submit" value="Genres & playlists">
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <form method="post" action="#">
                    <input class="btn btn-dark" type="submit" value="Training">
                </form>
            </td>
        </tr>
        <tr>
            <td>

                    <input class="btn btn-dark" type="submit" id="leaderboards" value="Leaderboards">
                
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
