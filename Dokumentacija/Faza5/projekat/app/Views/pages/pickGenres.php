<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>
<br>
<h4>Choose two genres</h4>
<table class="genres-table table">
    <tr>
        <?php
            foreach ($genres as $genre) {
                $id = strtolower($genre->name);
                $path = base_url("images/{$genre->name}.png");
                echo  "<td class='borderless'>
                    <img src='{$path}' id='{$id}' class='toMove' data-container='body' data-toggle='popover' data-trigger='hover' data-placement='bottom' data-content='{$genre->name}'>
                </td>";
            }
        ?>
    </tr>
</table>

<form method="post" action=" <?= base_url("Register/confirmGenres") ?>">
    <input type="submit" id="confirmGenres" class="btn btn-dark" value="Choose" disabled>
    <input type="hidden" id="g1" name="g1" value="">
    <input type="hidden" id="g2" name="g2" value="">
</form>




