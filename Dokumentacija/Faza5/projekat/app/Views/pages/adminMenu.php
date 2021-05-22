<script>
    $(document).ready(function (){
        $("#mistakeLog").click(function(){
            $.get("<?= base_url("Administrator/echoView/mistakeLog") ?>", function (data) {
                $("#insertable").html(data);
                $.get("<?= base_url("Administrator/getMistakes") ?>", function (data1){

                    let mistakes = [];
                    mistakes = data1.split(',');
                    for (let i=0; i<mistakes.length -1 ;i++)
                    {
                        let mistake = [];
                        mistake = mistakes[i].split('/');
                        let idM = mistake[0];
                        let idS = mistake[1];
                        let row = $("<tr></tr>");
                        let col1 = $("<td></td>").append(idS).attr("style", "color : white");
                        let col2 = $("<td></td>").append($("<input>").attr("type", "button").attr("value", "delete")
                            .addClass("btn").addClass("btn-sm").addClass("btn-light"));
                        row.append(col1);
                        row.append(col2);

                        $(".mistakeLogTable").append(row);
                    }

                });
            });
        });
    });
</script>

<div id="insertable">
    <table class="table tableAdminMenu">
        <tr >
            <td class="borderless">
                <form method="post" action= "<?= site_url("Administrator/Leaderboards")?>">
                    <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Leaderboards">
                </form>
            </td>
        </tr>
        <tr>
            <td class="borderless">
                <form method="post" action= "<?= site_url("Administrator/update")?>">
                    <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Update">
                </form>
            </td>
        </tr>
        <tr>
            <td class="borderless">
                <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Mistake Log" id="mistakeLog">
            </td>
        </tr>
        <tr>
            <td class="borderless">
                <form method="post" action= "<?= site_url("Administrator/changeLog")?>">
                    <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Change Log">
                </form>
            </td>
        </tr>
        <tr>
            <td class="borderless">
                <form method="post" action= "<?= site_url("Administrator/showView/deleteAccount")?>">
                    <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Delete Account">
                </form>
            </td>
        </tr>
        <tr>
            <td class="borderless">
                <form method="post" action= "<?= site_url("Administrator/registerModerator")?>">
                    <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Register Moderator">
                </form>
            </td>
        </tr>
        <tr>
            <td class="borderless">
                <form method="post" action= "<?= site_url("")?>">
                    <input type="submit" class="btn btnMenu btn-dark" name="submit" value="Quit">
                </form>
            </td>
        </tr>
    </table>
</div>
