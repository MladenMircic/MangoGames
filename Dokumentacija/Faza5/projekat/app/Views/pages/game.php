<script>
    let songDuration;
    let currentGenreImage = 9;
    let guessed = false;
    let songToBePlayed;

    function getSongsFromDatabase() {
        $.get("<?= base_url('Gameplay/pickSongs/true'); ?>", function (data) {
            let songData = JSON.parse(data);
            songToBePlayed = songData.songToBePlayed;
            let options = $(".userInterfaceForm").find(".guess");
            for (let i = 0; i < 4; i++) {
                options[i] = $(options[i]);
                options[i].attr("value", songData.songs[i]);
            }
            playAudio();
        });
    }

    function colorButtons() {
        let options = $(".userInterfaceForm").find(".guess");
        for (let i = 0; i < 4; i++) {
            options[i] = $(options[i]);
            options[i].toggleClass("btn-dark").prop("disabled", true);
            if (options[i].val() === songToBePlayed.name)
                options[i].toggleClass("btn-success");
            else
                options[i].toggleClass("btn-danger");
        }
    }

    function utilizeButtons() {
        let options = $(".userInterfaceForm").find(".guess");
        for (let i = 0; i < 4; i++) {
            options[i] = $(options[i]);
            options[i].toggleClass("btn-dark").prop("disabled", false);
            if (options[i].val() === songToBePlayed.name)
                options[i].toggleClass("btn-success");
            else
                options[i].toggleClass("btn-danger");
            options[i].css("border", "none");
        }
    }

    function playAudio() {
        let request = new XMLHttpRequest();
        request.open("GET", "<?= base_url("/") ?>" + "/" + songToBePlayed.path, true);
        request.responseType = "blob";
        let audio;
        request.onload = function() {
            if (this.status === 200) {
                audio = new Audio(URL.createObjectURL(this.response));
                audio.load();
                audio.onloadedmetadata = function () {
                    songDuration = audio.duration;
                    audio.currentTime = Math.random() * (songDuration - 5);
                    audio.play();
                    $("#" + currentGenreImage).addClass("hiddenGenreImageForGame");
                    currentGenreImage--;
                    setTimeout(function () {
                        let vol = 1;
                        let fadeOutInterval = setInterval(function () {
                            if (vol > 0) {
                                vol -= 0.1;
                                audio.volume = vol.toFixed(2);
                            } else
                                clearInterval(fadeOutInterval);
                        }, 200);
                        if (guessed === false)
                            colorButtons();
                        setTimeout(function () {
                            $(".guess").toggle(1000);
                            setTimeout(function () {
                                if (currentGenreImage >= 0) {
                                    guessed = false;
                                    utilizeButtons();
                                    $(".guess").toggle(1000);
                                    getSongsFromDatabase();
                                }
                            }, 2000);
                        }, 2000);
                    }, 5000, audio)
                }
            }
        }
        request.send();
    }

    $(document).ready(function () {
        getSongsFromDatabase();


        $(".guess").click(function () {
            $(this).css("border", "5px solid black");
            guessed = true;
            colorButtons();
        });
    });
</script>

<div class="imagesForGame">
    <?php
    for ($i = 0; $i < 10; $i++) {
        $path = base_url("images/" . session()->get("chosenGenre") . ".png");
        echo "<img id='$i' class='genreImageForGame' src='$path' alt=''>";
    }
    ?>
</div>

<table class="table userInterfaceForm">
    <tr>
        <td>
            <input class='btn btn-dark guess' type='button' value=''>
        </td>
    </tr>
    <tr>
        <td>
            <input class='btn btn-dark guess' type='button' value=''>
        </td>
    </tr>
    <tr>
        <td>
            <input class='btn btn-dark guess' type='button' value=''>
        </td>
    </tr>
    <tr>
        <td>
            <input class='btn btn-dark guess' type='button' value=''>
        </td>
    </tr>
</table>
