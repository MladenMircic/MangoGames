<script>
    $(document).ready(function (){

        $("#mistakeLog").click(function() {
            $.get("<?= base_url("Administrator/echoView/mistakeLog") ?>", function (data) {
                $(".center").html(data);
                $.get("<?= base_url("Administrator/getMistakes") ?>", function (data1) {

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

        $("#leaderboards").click(function () {
            $.post("<?= base_url("Administrator/echoView/leaderboardsPrivileged") ?>", function (data) {
                $(".center").html(data);
            });
        });

        $("#update").click(function () {
            $.post("<?= base_url("Administrator/echoView/insertDelete") ?>", function (data) {
                $(".center").html(data);
            });
        });

        $("#registerMod").click(function () {
            $.post("<?= base_url("Administrator/echoView/registerModerator") ?>", function (data) {
                $(".center").html(data);
            });
        });

        $("#delete").click(function () {
            $.post("<?= base_url("Administrator/echoView/deleteAccount") ?>", function (data) {
                $(".center").html(data);
            })
        });

        $("#quit").click(function () {
            $.post("<?= base_url("Administrator/echoView/quit") ?>", function (data) {
                $(".center").html(data);
            });
        });
        $("#changeLog").click(function () {
            $.post("<?= base_url("Administrator/echoView/changeLog") ?>", function (data) {
                $(".center").html(data);
            });
        });
    });
</script>

    <table class="table tableAdminMenu">
        <tr >
            <td class="borderless">
                <input type="submit" class="btn btnMenu btn-dark btnTransition" name="submit" value="Leaderboards" id="leaderboards">
            </td>
        </tr>
        <tr>
            <td class="borderless">
                <input type="submit" class="btn btnMenu btn-dark btnTransition" name="submit" value="Update" id="update">
            </td>
        </tr>
        <tr>
            <td class="borderless">
                <input type="submit" class="btn btnMenu btn-dark btnTransition" name="submit" value="Mistake Log" id="mistakeLog">
            </td>
        </tr>
        <tr>
            <td class="borderless">
                <input type="submit" class="btn btnMenu btn-dark btnTransition" name="submit" value="Change Log" id="changeLog">
            </td>
        </tr>
        <tr>
            <td class="borderless">
                <input type="submit" class="btn btnMenu btn-dark btnTransition" name="submit" value="Delete Account" id="delete">
            </td>
        </tr>
        <tr>
            <td class="borderless">
                <input type="submit" class="btn btnMenu btn-dark btnTransition" name="submit" value="Register Moderator" id = "registerMod">
            </td>
        </tr>
        <tr>
            <td class="borderless">
                <input type="submit" class="btn btnMenu btn-dark btnTransition" name="submit" value="Quit" id="quit">
            </td>
        </tr>
    </table>

