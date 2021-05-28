<script>
    let songDuration;
    function playAudio() {
        let request = new XMLHttpRequest();
        request.open("GET", "<?= base_url("{$songToBePlayed->path}") ?>", true);
        request.responseType = "blob";
        let audio;
        request.onload = function() {
            if (this.status == 200) {
                audio = new Audio(URL.createObjectURL(this.response));
                audio.load();
                audio.onloadedmetadata = function () {
                    songDuration = audio.duration;
                    audio.currentTime = Math.random() * songDuration;
                    audio.play();
                }
            }
        }
        request.send();
    }

    $(document).ready(function () {
        playAudio();

        $(".guess").click(function () {
           if ($(this).attr("value") === "<?= $songToBePlayed->name ?>")
               alert("Pogodak!");
           else
               alert("Promasaj!!!!!!");
        });
    });
</script>

<table class="table userInterfaceForm">
    <?php
        shuffle($songs);
        foreach($songs as $song) {
            $song = str_replace('\'', '&apos;', $song);
            echo "<tr>
        <td>
            <input class='btn btn-dark guess' type='button' value='$song'>
        </td>
    </tr>";
        }
    ?>
</table>
