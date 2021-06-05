<script>
    $(document).ready(function(){
        insertPlaylist();
        function insertPlaylist(){
            $.post("<?= site_url('PrivilegedUser/getGenres')?>", function(data) {
                let genres = data.split(",");
                genres.pop();
                for(let i=0;i<genres.length;i++){
                    let option=$("<option></option>");
                    option.addClass("optGenre");
                    option.attr("id", genres[i]);
                    let genre=genres[i].toLowerCase().replace(/\b[a-z]/g, function(letter) {
                        return letter.toUpperCase();
                    });
                    option.append(genre);
                    $("#genres").append(option);
                }

            });
        }
    $("#insertPlaylist").click(function(){
            $("#error").empty();
            if($("#genreDefault").prop("selected")==true){
                $("#error").append("You must choose genre");
            }
            else if($("#levelDefault").prop("selected")==true){
                $("#error").append("You must choose level");
            }
            else {
                let genres = document.getElementsByClassName("optGenre");
                let genre = "";
                for (let i = 0; i < genres.length; i++) {
                    if (genres[i].selected) {
                        genre = genres[i].id;
                        break;
                    }
                }
                let levels = document.getElementsByClassName("optLevel");
                let level = "";
                for (let i = 0; i < levels.length; i++) {
                    if (levels[i].selected) {
                        level = levels[i].id;
                        break;
                    }
                }

                $.post("<?= base_url('PrivilegedUser/insertPlaylist')?>", {
                    "genre": genre,
                    "level": level
                }, function () {
                    $("#change").empty().append("<br><br><h3>Playlist inserted successfully</h3>");
                });
            }
        });
    });
</script>
<div id="error" class="red">

</div>
<table class="table " >
    <tr>
        <td>Genre:</td>
        <td>
            <select id="genres" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                <option id="genreDefault" selected>Genre &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Level:</td>
        <td>
            <select id="levels" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                <option id="levelDefault" selected>Level&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                <option class="optLevel" id="easy">Easy</option>
                <option class="optLevel" id="medium">Medium</option>
                <option class="optLevel" id="hard" >Hard</option>
            </select>
        </td>
    </tr>
</table>
<input type="button" id="insertPlaylist" class="btn btn-dark" value="Insert playlist">
