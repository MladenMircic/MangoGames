
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