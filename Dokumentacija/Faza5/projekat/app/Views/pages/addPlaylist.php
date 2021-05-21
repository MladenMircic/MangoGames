<script>
    function operationAndType(operation, type) {
        if (operation == "insert" && type == "song") {
            $("#change").load("<?=site_url('Moderator/echoView/insertSong')?>");
            insertSong();

        }
    }

</script>

<table class="center table">
    <tr>
        <td class=" borderless">
            <select class="form-select formWidth form-select-lg mb-3" aria-label=".form-select-lg example">
                <option selected>Choose operation</option>
                <option class="operation" value="insert">Insert</option>
                <option class="operation" value="delete">Delete</option>
            </select>
        </td>

        <td class=" borderless">
            <select class="form-select formWidth form-select-lg mb-3" aria-label=".form-select-lg example">
                <option selected>Choose type</option>
                <option class="type" value="playlist">Playlist</option>
                <option class="type" value="song">Song</option>
            </select>
        </td>
    </tr>
</table>


<input type="button" id="confirmOperation" class="btn btn-dark ok" value="OK">
<br>
<br>

<div id="change">

</div>




