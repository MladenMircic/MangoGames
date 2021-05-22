<script>
    $("#insertSong").click(function(){
        $("#error").empty();
        let name=$("#name").val();
        let performer=$("#performer").val();
        let location=$("#location").val();
        if(name==""){
            $("#error").append("You must enter name");
        }
        else if(performer==""){
            $("#error").append("You must enter performer");
        }
        else if($("#genreDefault").prop("selected")==true){
            $("#error").append("You must select playlist");
        }
        else if(location==""){
            $("#error").append("You must enter location");
        }
        else if(/^[a-zA-Z]+.[a-z]{3,4}$/.test(location)==false){
            $("#error").append("Invalid location format");
        }
        else{

            let playlists = document.getElementsByClassName("opt");
            let pl="";
            for(let i=0;i<playlists.length;i++) {
                if (playlists[i].selected) {
                    pl = playlists[i].id;
                    break;
                }
            }
            let plArr=pl.split("/");

            $.post("<?=base_url('Moderator/insertSong')?>",{
                'name': name,
                'performer': performer,
                'genre': plArr[0],
                'difficulty': plArr[1],
                'number': plArr[2],
                'location': location
            });
            $("#change").empty().append("<br><br><h3>Song inserted successfully</h3>");

        }

    });
</script>
<div id="error" class="red">

</div>
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
                <option id="genreDefault" selected>Genre</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Audio location:</td>
        <td><input type="text" id="location"></td>
    </tr>
</table>
<input type="button" id="insertSong" class="btn btn-dark" value="Insert song">