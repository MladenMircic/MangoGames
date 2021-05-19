<table class="genres-table table">
    <tr>



        <?php
        foreach ($genres as $genre) {
            $path = "http://localhost:8080/images/{$genre->name}.png";
            echo  "<td class='borderless'>
        <div class='dropdown'>
            <img src='{$path}' id='{$genre->name}' class='dropdown-toggle' data-toggle='dropdown'>

            <div class='dropdown-menu ' >
                <div class='dropdown-item'>{$genre->name}</div>
            </div>
        </div>
            </td>";
        }
        ?>

    </tr>
</table>

<div class="offset-2 col-4">
<table class="table table-light table-bordered">
    <tr id="chosen">
    </tr>
</table>
</div>


