<script>
    $(document).ready(function () {
        window.conn = new WebSocket('ws://localhost:8081?username=<?= session()->get('username') ?>&chosenGenre=<?= session()->get('chosenGenre') ?>');

        window.conn.onopen = function(e) {
        };

        window.conn.onmessage = function(e) {
            let messageReceived = e.data.split(":");
            switch (messageReceived[0]) {
                case "startGame": {
                    localStorage.setItem("opponent", messageReceived[1]);
                    localStorage.setItem("gameId", messageReceived[2]);
                    $.post("<?= base_url("User/echoView/multiplayerGame") ?>", function (data) {
                        $("#insertable").html(data);
                    });
                    break;
                }
                case "answered": {
                    window.opponent.append("<br>answered " + messageReceived[1]);
                    break;
                }
            }
        }

        $("#toUserMenu").click(function () {
            window.conn.close();
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