<script>
    $(document).ready(function () {
        let myself = JSON.parse(localStorage.getItem("myself"));
        let opponent = JSON.parse(localStorage.getItem("opponent"));

        localStorage.removeItem("myself");
        localStorage.removeItem("opponent");

        $("#myName").append(myself.username);
        $("#opponentName").append(opponent.username);

        if (myself.points > opponent.points)
            $("#winner1").append($("<img alt=''>").attr("src", "<?= base_url("images/winnerCup.png") ?>").css({"width": "100px", "height": "100px"}));
        else
            $("#winner2").append($("<img alt=''>").attr("src", "<?= base_url("images/winnerCup.png") ?>").css({"width": "100px", "height": "100px"}));

    });
</script>

<table class="table">
    <tr>
        <td colspan="2" style="font-size: 30px; font-weight: bolder; text-align: center" class="borderless">
            Result
        </td>
    </tr>
    <tr>
        <td style=" text-align: center; width: 50%" class="borderless">
            <div id="winner1">

            </div>
        </td>
        <td style="text-align: center; width: 50%" class="borderless">
            <div id="winner2">

            </div>
        </td>
    </tr>
    <tr>
        <td style="font-size: 20px; font-weight: bold; text-align: center; width: 50%" class="borderless">
            <div id="myName">

            </div>
        </td>
        <td style="font-size: 20px; font-weight: bold; text-align: center; width: 50%" class="borderless">
            <div id="opponentName">

            </div>
        </td>
    </tr>
    <tr>
        <td id="myPoints">

        </td>
        <td id="opponentPoints">

        </td>
    </tr>
</table>