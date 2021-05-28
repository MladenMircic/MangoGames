<script>
    $(document).ready(function (){
        $("#back").click(function(){
            let user = "<?= session()->get('type'); ?>";
            if(user == "mod"){
                $.post("<?= base_url("Moderator/echoView/modMenu") ?>", function (data) {
                    $(".center").html(data);
                });
            }
            else if(user == "admin"){
                $.post("<?= base_url("Administrator/echoView/adminMenu") ?>", function (data) {
                    $(".center").html(data);
                });
            }
        });

        $("#info").click(function () {
            let ids = $("#ids").val();
            $.post("<?= base_url("Administrator/echoView/songInfo") ?>", function (data) {
                $(".center").html(data);
                $.post("<?= base_url("Administrator/getSongInfo") ?>",{
                    "idS" : ids
                }, function (data1) {
                    let songInfo = [];
                    songInfo = data1.split(",");
                    let row1 = $("<tr></tr>");
                    let col1 = $("<td></td>");
                    col1.append("Song ID:");
                    let col2 = $("<td></td>");
                    col2.append(songInfo[0]);
                    row1.append(col1);
                    row1.append(col2);

                    let row2 = $("<tr></tr>");
                    let col21 = $("<td></td>");
                    col21.append("Name:");
                    let col22 = $("<td></td>");
                    col22.append(songInfo[1]);
                    row2.append(col21);
                    row2.append(col22);

                    let row3 = $("<tr></tr>");
                    let col31 = $("<td></td>");
                    col31.append("Artist:");
                    let col32 = $("<td></td>");
                    col32.append(songInfo[2]);
                    row3.append(col31);
                    row3.append(col32);

                    $(".songInfoTable").append(row1);
                    $(".songInfoTable").append(row2);
                    $(".songInfoTable").append(row3);
                });
            });
        });
    });
</script>

<br>
<br>
<div class="scroll offset-sm-3 col-sm-6">
    <table class="table mistakeLogTable" style="text-align: right">

    </table>
</div>
<div class="songInfo">
    <br>
    Song ID:
    <input type="text" style="margin-left: 10px" id="ids">
    <input class="btn btn-dark btn-sm" type="button" style="margin-left: 10px" value="Get song info" id="info">
    <br>
    <br>
    <input type="button" class="btn btn-sm btn-dark" value="Back" id="back">
</div>
