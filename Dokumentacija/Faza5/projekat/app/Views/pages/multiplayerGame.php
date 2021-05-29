<script>
    let songDuration;
    let currentGenreImage = 9;
    let guessed = false;
    let songToBePlayed;
    let tokensAcquired = 0;
    let usedSongs = [];
    let logo;
    let myTime;
    let myTimer;

    let gameId = localStorage.getItem("gameId");
    let opponentUsername = localStorage.getItem("opponent");

    function getSongsFromDatabase() {
        $.get("<?= base_url('Training/pickSongs/true'); ?>", function (data) {
            let songData = JSON.parse(data);
            songToBePlayed = songData.songToBePlayed;
            usedSongs.push(songToBePlayed.artist + ":" + songToBePlayed.name);
            let options = $(".userInterfaceForm").find(".guess");
            for (let i = 0; i < 4; i++) {
                options[i] = $(options[i]);
                options[i].attr("value", songData.songs[i]);
            }
            playAudio();
            myTime = 0;
            myTimer = setInterval(function () {
                myTime += 0.01;
            }, 10)
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
                        clearInterval(myTimer);
                        let vol = 1;
                        let fadeOutInterval = setInterval(function () {
                            if (vol > 0) {
                                vol -= 0.1;
                                audio.volume = vol.toFixed(1);
                            } else {
                                clearInterval(fadeOutInterval);
                                audio.pause();
                            }
                        }, 100);

                        if (guessed === false)
                            colorButtons();
                        setTimeout(function () {
                            $(".guess").toggle(1000);
                            setTimeout(function () {
                                if (currentGenreImage >= 0) {
                                    guessed = false;
                                    utilizeButtons();
                                    window.myself.toggleClass("selectedGenre").html("<?= session()->get("username") ?>");
                                    window.opponent.html(opponentUsername);
                                    $(".guess").toggle(1000);
                                    getSongsFromDatabase();
                                }
                                else {
                                    logo.toggleClass("logo logoForGame");
                                    $(".header-content")
                                        .empty()
                                        .append(logo)
                                        .css("justify-content", "center");
                                    localStorage.setItem("usedSongs", usedSongs);
                                    $.post("<?= base_url('Training/saveUserTokens') ?>", {
                                        tokens: tokensAcquired
                                    });
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
        window.myself = $("<div></div>").addClass("nesto").append("<?= session()->get('username') ?>").css("margin-right", "30px");
        window.opponent = $("<div></div>").append(opponentUsername).css("margin-right", "30px");
        logo = $($(".header-content").children(".logo")).toggleClass("logo logoForGame");
        $(".userWelcome").html(logo);


        //let tokenSection = $("<div></div>").addClass("token-section")
        //    .append($("<div></div>").append("0").attr("id", "tokens"))
        //    .append($("<img>").attr("src", "<?//= base_url('images/token.png') ?>//").css({"width": "15%", "height": "25%"}));
        $(".header-content")
            .prepend(window.myself)
            .append(window.opponent)
            .css({"font-size": "20px", "font-weight": "bold", "justify-content": "space-between"});

        localStorage.clear();
        getSongsFromDatabase();

        $(".guess").click(function () {
            clearInterval(myTimer);
            window.myself.toggleClass("selectedGenre");
            window.conn.send("answered:" + gameId + ":" + myTime.toFixed(2));
            if ($(this).val() === songToBePlayed.name) {
                tokensAcquired += 10;
                $("#tokens").html(tokensAcquired);
            }
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
