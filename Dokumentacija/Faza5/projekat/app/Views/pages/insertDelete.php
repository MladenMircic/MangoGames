<script>
    function insertSong(){
        $.get("<?= site_url('Moderator/getPlaylists')?>", function(data){
            let playlists=data.split(",");
            let arr=[];

            for(let i=0;i<playlists.length-1;i++){
                let pl=playlists[i].split("/");

                let s=pl[1].toString();
                if(!s.localeCompare("easy")) pl.push(1);
                if(!s.localeCompare("medium")) pl.push(2);
                if(!s.localeCompare("hard")) pl.push(3);
                arr.push(pl);

            }
            arr.sort(function (a,b){
                if(a[0]>b[0])return -1;
                if(b[0]>a[0]) return 1;
                if(a[3]>b[3])return 1;
                if(a[3]<b[3]) return -1;
                return a[2]-b[2];
            })
            for(let i=0;i<arr.length;i++){
                let option= $("<option></option");
                let genre=arr[i][0].toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });
                let diff=arr[i][1].toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });
                option.attr("id", arr[i][0]+"/"+ arr[i][1] + "/"+ arr[i][2]);
                option.addClass("opt");
                option.append(genre+" "+ diff + " "+ arr[i][2]);
                $("#playlists").append(option);
            }

        });


    }
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




