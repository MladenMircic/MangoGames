
<html>
    <head>
        <title>SongClicker</title>
        <link rel="stylesheet" href="http://localhost:8080/css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src= "https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.1/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="http://localhost:8080/js/pickGenres.js"></script>
        <script src="http://localhost:8080/js/Modifications.js"></script>
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
        </script>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-6 offset-3 header">
                    <img src="http://localhost:8080/images/SongClickerLogo.png" class="logo">
                </div>
            </div>
            <div class="row">
                <div class="col-6 offset-3 center">
                    <?php echo $middlePart ?>
                </div>
            </div>
            <div class="row">
                <div class="col-2 offset-3 footer teamLogo">
                    <img src="http://localhost:8080/images/MangoGamesLogo.png">
                </div>
                <div class="col-2 footer optional">
                    <?php if(isset($footerPart)) echo $footerPart ?>
                </div>
                <div class="col-2 footer userWelcome">
                    <?php
                        if (isset($welcomeMessage))
                            echo $welcomeMessage
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>