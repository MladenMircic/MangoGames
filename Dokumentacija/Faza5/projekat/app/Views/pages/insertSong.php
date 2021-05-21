<script>
    $("#insertSong").click(function(){
        let name=$("#name").value;
        let performer=$("#performer").value;
        let playlists = document.getElementsByClassName("opt");
        let pl="";
        for(let i=0;i<playlists.length;i++) {
            if (playlists[i].selected) {
                pl = playlists[i].id;
                break;
            }
        }
        let plArr=pl.split("/");
        alert("succ");
        $("#change").get("<?=site_url('Moderator/insertSong/')?>", function(data){
            alert(data);
        });
    });
</script>

<table class="table " >
    <tr>
        <td>Name:</td>
        <td><input type="text" id="name"></td>
    </tr>
    <tr>
        <td>Performer:</td>
        <td><input type="text" id="performer"></td>
    </tr>
    <tr>
        <td>Playlist:</td>
        <td>
            <select id="playlists" class="form-select  form-select-lg mb-3" aria-label=".form-select-lg example">
                <option selected>Genre</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Audio location:</td>
        <td><input type="text" id="location"></td>
    </tr>
</table>
<input type="button" id="insertSong" class="btn btn-dark" value="Insert song">