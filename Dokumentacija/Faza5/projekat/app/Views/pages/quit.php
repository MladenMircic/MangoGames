<script>
    $(document).ready(function () {
        $("#no").click(function () {
            let user = "<?= session()->get('type'); ?>";
            if(user === "mod"){
                $.post("<?= base_url("Moderator/echoView/modMenu") ?>", function (data) {
                    $(".center").html(data);
                });
            }
            else if(user === "admin"){
                $.post("<?= base_url("Administrator/echoView/adminMenu") ?>", function (data) {
                    $(".center").html(data);
                });
            }
            else{
                $.post("<?= base_url("User/echoView/userInterface") ?>", function (data) {
                    $(".center").html(data);
                });
            }
        });
    });
</script>
<table class="table tableQuit">
    <tr>
        <td colspan="2" style="font-weight: bold; border: none">
            Are you sure you want to quit the game?
        </td>
    </tr>
    <tr>
        <td style="border: none">
            <form method="post" action="
            <?php
                if (session()->get("type") == 'user')
                    echo base_url("User/logout");
                else if (session()->get("type") == 'mod')
                    echo base_url("Moderator/logout");
                else if (session()->get("type") == 'admin')
                    echo base_url("Administrator/logout");
            ?>">
                <input class="btn btn-dark" type="submit" value="YES" id="yes">
            </form>
        </td>
        <td style="border: none">
            <input class="btn btn-dark" type="submit" value="NO" id="no">
        </td>
    </tr>
</table>