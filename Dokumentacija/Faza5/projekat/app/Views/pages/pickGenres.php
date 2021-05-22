
<br>
<h4>Choose two genres</h4>

<table class="genres-table table">
    <tr>
        <?php
            foreach ($genres as $genre) {
                $path = base_url("images/{$genre->name}.png");
                echo  "<td class='borderless'>
            <div class='dropdown'>
                <img src='{$path}' id='{$genre->name}' class=' dropdown-toggle' data-toggle='dropdown'>
    
                <div class='dropdown-menu ' >
                    <div class='dropdown-item'>{$genre->name}</div>
                </div>
            </div>
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




