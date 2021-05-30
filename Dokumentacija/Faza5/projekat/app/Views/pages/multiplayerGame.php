<script>
    const timerFill = "       ";

    let songDuration;
    let currentGenreImage = 9;
    let guessed = false;
    let songToBePlayed;
    let tokensAcquired = 0;
    let usedSongs = [];
    let logo;
    let myTime;
    let myTimer;
    let songData;
    let selected = false;
    let opponentTime = -1;

    let gameId = localStorage.getItem("gameId");
    let opponentUsername = localStorage.getItem("opponent");

    function LoadSongsAndPlayAudio() {
        songData = JSON.parse(window.songs);
        songToBePlayed = songData.songToBePlayed;
        usedSongs.push(songToBePlayed.artist + ":" + songToBePlayed.name);
        let options = $(".userInterfaceForm").find(".guess");
        for (let i = 0; i < 4; i++) {
            options[i] = $(options[i]);
            options[i].attr("value", songData.songs[i]);
        }
        myTime = 0;
        myTimer = setInterval(function () {
            myTime += 0.01;
        }, 10)
        playAudio();
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

    function borderAndTimeBothAnswers() {
        let options = $(".userInterfaceForm").find(".guess");
        for (let i = 0; i < 4; i++) {
            options[i] = $(options[i]);
            if (options[i].hasClass("myAnswer") && options[i].hasClass("opponentAnswer")) {
                options[i].css(
                    {
                        "border-left": "5px solid blue",
                        "border-bottom": "5px solid blue",
                        "border-top": "5px solid red",
                        "border-right": "5px solid red"
                    });
            }
            else if (options[i].hasClass("opponentAnswer"))
                options[i].css("border", "5px solid red");
        }

        if (opponentTime !== -1) {
            if ($(".myAnswerParent").hasClass("opponentAnswerParent"))
                $(".myAnswerParent").attr("time-after", opponentTime.toFixed(2));
            else {
                $(".opponentAnswerParent").attr("time-before", timerFill);
                $(".opponentAnswerParent").attr("time-after", opponentTime.toFixed(2));
            }
        }
    }

    function utilizeButtons() {
        let options = $(".userInterfaceForm").find(".guess");
        for (let i = 0; i < 4; i++) {
            options[i] = $(options[i]);
            options[i].removeClass("opponentAnswer myAnswer");
            options[i].toggleClass("btn-dark").prop("disabled", false);
            if (options[i].val() === songToBePlayed.name)
                options[i].toggleClass("btn-success");
            else
                options[i].toggleClass("btn-danger");
            options[i].css("border", "none");
        }
    }

    function viewOpponentTime() {

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
                    audio.currentTime = songData.randomTime * (songDuration - 5);
                    audio.play();
                    $("#" + currentGenreImage).addClass("hiddenGenreImageForGame");
                    currentGenreImage--;
                    setTimeout(function () {
                        clearInterval(myTimer);

                        let vol = 1;
                        let fadeOutInterval = setInterval(function () {
                            if (vol > 0.1) {
                                vol -= 0.1;
                                audio.volume = vol.toFixed(1);
                            } else {
                                clearInterval(fadeOutInterval);
                                audio.pause();
                            }
                        }, 10);

                        colorButtons();
                        borderAndTimeBothAnswers();
                        setTimeout(function () {
                            $(".myAnswerParent")
                                                .attr("time-before", "")
                                                .attr("time-after", "")
                                                .removeClass("myAnswerParent");
                            $(".opponentAnswerParent")
                                                .attr("time-before", "")
                                                .attr("time-after", "")
                                                .removeClass("opponentAnswerParent");

                            $(".guess").toggle(1000);
                            setTimeout(function () {
                                if (currentGenreImage >= 0) {
                                    guessed = false;
                                    utilizeButtons();
                                    window.myself.removeClass("selectedGenre");
                                    window.opponent.removeClass("selectedGenre");
                                    window.conn.send("endOfRound|" + gameId);
                                    $(".guess").toggle(1000);
                                    selected = false;
                                    opponentTime = -1;
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

        window.conn.onmessage = function (e) {
            let messageReceived = e.data.split("|");
            switch (messageReceived[0]) {
                case "answered": {
                    opponentTime = parseFloat(messageReceived[1]);
                    $("#" + messageReceived[2]).addClass("opponentAnswer");
                    $($("#" + messageReceived[2]).parent()).addClass("opponentAnswerParent");
                    opponent.addClass("selectedGenre");
                    break;
                }
                case "newRound": {
                    window.songs = messageReceived[1];
                    LoadSongsAndPlayAudio();
                    break;
                }
            }
        }

        window.myself = $("<div></div>").addClass("nesto").append("<?= session()->get('username') ?>").css({"margin-right": "30px", "color": "blue"});
        window.opponent = $("<div></div>").append(opponentUsername).css({"margin-right": "30px", "color": "red"});
        logo = $($(".header-content").children(".logo")).toggleClass("logo logoForGame");
        $(".userWelcome").html(logo);

        $(".header-content")
            .prepend(window.myself)
            .append(window.opponent)
            .css({"font-size": "20px", "font-weight": "bold", "justify-content": "space-between"});

        localStorage.clear();
        LoadSongsAndPlayAudio();

        $(".guess").click(function () {
            if (selected === false) {
                selected = true
                clearInterval(myTimer);

                $($(this).parent()).addClass("myAnswerParent");
                $(".myAnswerParent")
                    .attr("time-before", myTime.toFixed(2))
                    .attr("time-after", timerFill);

                window.myself.addClass("selectedGenre");
                window.conn.send("answered|" + gameId + "|" + myTime.toFixed(2) + "|" + $(this).attr("id"));
                if ($(this).val() === songToBePlayed.name) {
                    tokensAcquired += 10;
                    $("#tokens").html(tokensAcquired);
                }
                $(this).addClass("myAnswer").css("border", "5px solid blue");
            }
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
            <input id="answer1" class='btn btn-dark guess' type='button' value=''>
        </td>
    </tr>
    <tr>
        <td>
            <input id="answer2" class='btn btn-dark guess' type='button' value=''>
        </td>
    </tr>
    <tr>
        <td>
            <input id="answer3" class='btn btn-dark guess' type='button' value=''>
        </td>
    </tr>
    <tr>
        <td>
            <input id="answer4" class='btn btn-dark guess' type='button' value=''>
        </td>
    </tr>
</table>