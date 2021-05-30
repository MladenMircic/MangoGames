<script>
    $(document).ready(function () {
        listOutSongs();

        function listOutSongs(){
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
    });
</script>


<div class = "listOfSongs">
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
