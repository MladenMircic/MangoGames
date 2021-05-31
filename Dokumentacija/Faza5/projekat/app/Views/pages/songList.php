<script>
    $(document).ready(function () {


        listOutSongs();

        function listOutSongs(){
            let mode = "<?php echo session()->get("mode"); ?>";
            if(mode == "unlock")
                {
                    $(".tableSongList").hide();
                    let correctGuesses = localStorage.getItem("numberOfGuesses");
                    let genre = "<?php echo session()->get("chosenGenre"); ?>";
                    if(correctGuesses >= 6){
                        $(".guessed").append("Congratulations you successfully unlocked " + genre + " genre!").css({"font-size" : "20px" , "font-weight" : "bold"});
                    }
                    else{
                        $(".guessed").append("You failed to unlock " + genre + " genre! Better luck next time!").css({"font-size" : "20px" , "font-weight" : "bold"});
                    }
                    $(".guessed").append($("<h3></h3>").append(correctGuesses + "/" + "10"));
                }
            else
                {
                    let usedSongs = localStorage.getItem("usedSongs").split(",");
                    let songArtist;
                    let song;

                    for(let i=0; i<usedSongs.length; i++){
                        let artistAndSong = usedSongs[i].split(":");
                        songArtist = artistAndSong[0];
                        song = artistAndSong[1];

                        let tr = $("<tr></tr>");
                        let td1 = $("<td></td>").append(song);
                        let td2 = $("<td></td>").append(songArtist);

                        tr.append(td1);
                        tr.append(td2);

                        $(".tableSongList").append(tr);
                }
            }
        }
    });
</script>


<div class = "listOfSongs">
    <div class="guessed">

    </div>
    <table class = "table table-striped table-dark tableSongList">
        <tr>
            <thead>
                <th style="border-bottom: 5px solid #9c1616">
                    Song
                </th>
                <th style="border-bottom: 5px solid #9c1616">
                    Artist
                </th>
            </thead>
        </tr>
    </table>
</div>
