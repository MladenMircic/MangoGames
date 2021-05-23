<script>
    $(document).ready(function (){
        $("#update").click(function(){
            $.post("<?=base_url('Moderator/echoView/insertDelete')?>", function(data){
                $(".center").html(data);
            });
        });
    });


</script>

<table class="table modMenu">
    <tr>
        <td>
            <form action="<?= site_url("") ?>">
                <input class="btn btn-dark" type="submit" value="Leaderboards">
            </form>
        </td>
    </tr>
    <tr>
        <td>

                <input class="btn btn-dark" type="button" id="update" value="Update">

        </td>
    </tr>
    <tr>
        <td>
            <form action="<?= site_url("") ?>">
                <input class="btn btn-dark" type="submit" value="Mistakes Log">
            </form>
        </td>
    </tr>
    <tr>
        <td>
            <form action="<?= site_url("") ?>">
                <input class="btn btn-dark" type="submit" value="Quit">
            </form>
        </td>
    </tr>
</table>
