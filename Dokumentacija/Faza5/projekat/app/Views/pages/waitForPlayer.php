<script>
    $(document).ready(function () {
        $("#toUserMenu").click(function () {
            $.get("<?= base_url("User/echoView/userInterface") ?>", function (data) {
                $(".center").html(data);
            })
        });
    });
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