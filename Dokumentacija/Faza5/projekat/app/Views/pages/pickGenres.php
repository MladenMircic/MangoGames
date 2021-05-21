<table class="genres-table table">
    <tr>



        <?php
        foreach ($genres as $genre) {
            $path = "http://localhost:8080/images/{$genre->name}.png";
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
<form method="post" action=" <?= site_url("User") ?>">
<input type="submit" id="chooseGenres" class="btn btn-dark" value="Choose"disabled>
</form>


