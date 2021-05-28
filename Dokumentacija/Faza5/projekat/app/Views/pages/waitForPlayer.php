<script>
    $(document).ready(function () {
        let conn = new WebSocket('ws://localhost:8081?username=<?= session()->get('username') ?>&chosenGenre=<?= session()->get('chosenGenre') ?>');
        conn.onopen = function(e) {
        };
        conn.onmessage = function(e) {
            if (e.data === "pali") {
                $.post("<?= base_url("User/echoView/game") ?>", function (data) {
                    $("#insertable").html(data);
                })
            }
            else if (e.data === "nema drugih igraca") {
                alert(e.data);
            }
        }

        $("#toUserMenu").click(function () {
            conn.close();
            $.get("<?= base_url("User/echoView/userInterface") ?>", function (data) {
                $(".center").html(data);
            })
        });
    })
</script>

<h4>Please wait while we find you a mate to compete with</h4>
<br>
<br>
<div class="spinner-border text-secondary" style="width: 5rem; height: 5rem;" role="status">
</div>
<br>
<br>
<br>
<input id="toUserMenu" class="btn btn-dark btnTransition btnRegister" type="button" value="Back">