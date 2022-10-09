<?php
    require_once('php/classes.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/styles.css">
        <script src="https://kit.fontawesome.com/27bb130eca.js" crossorigin="anonymous"></script>        
        <title>RJS2000 - Randomizer</title>
        <link rel="icon" type="image/png" href="assets/img/dice_icon_white.png">
    </head>
    <body>
        <div class="content">
            <div class="app">

                <div class="controls">
                    <div class="musicOn">
                        <img class="play" src="assets/img/sound-png-3.png"></img>
                        <input type="range" id="volume-control">
                        <audio id="player" loop>
                            <source src="assets/music/tuplapotti_musa.mp3" type="audio/mp3">
                        </audio>
                    </div>
                    <div class="teacher-mode">
                        <a href="php/teacher_mode.php"><img src="assets/img/teacher.png"></img></a>
                    </div>
                </div>
                
                <div class="heading">
                    <h1><a href=".">RJS2000</a></h1>
                    <p class="rating">"Perhaps the world's best randomization machine." - Elin Mosk</p>
                </div>

                <div class="input-area">
                    <form action="php/add_player.php" method="POST">
                        <input required autofocus type="text" name="name" placeholder="Player name"><br>
                        <input class="button-30" type="submit" value="Add">
                    </form>
                </div>

                <div class="name-bucket">
                    <?php Logic::GetPlayers() ?>
                </div>

                <div class="button-container">
                    <label>Team size</label>
                    <input id="team-size" type=number 
                        value="<?php
                            if(isset($_GET["randomize"])){
                                echo $_GET["randomize"];
                            } else {
                                echo 2;
                            }
                        ?>">
                        <br>
                    <!-- Gets team size value with JS and put it to url parameter -->
                    <button id="randomize-btn" 
                        onclick="location.href='index.php?randomize=' + document.getElementById('team-size').value;"
                        class="button-30 big-button">
                        Randomize
                    </button>
                </div>

                <div id="randomized-bucket">
                    <?php 
                        // If randomize parameter exist in url, get randomized players 
                        if(isset($_GET["randomize"])) {
                            Logic::GetRandomizedPlayers($_GET["randomize"]);
                        }
                    ?>
                    <div class="button-container">
                        <button onclick="location.href='php/download_teams.php?type=csv';" class="button-30"><i class="fa-solid fa-download"></i>CSV</button>
                    </div>
                </div>

            </div>
        </div>
    </body>
    <footer>
        <p>2022 © Kerttula</p>
    </footer>
    <script type="text/javascript">
        if (window.location.href.indexOf("randomize") > -1) {
            document.getElementById("randomized-bucket").style.display = "block";
        }
        // Audio magic
        let on_off = document.querySelector('.play');
        let audio = document.querySelector('.musicOn audio');
        on_off.addEventListener('click', function (e) {
            audio.paused ? audio.play() : audio.pause();
        });
        let volume = document.querySelector("#volume-control");
        volume.addEventListener("change", function(e) {
            audio.volume = e.currentTarget.value / 100;
        })

        // Disable 'randomize' if no players added
        let no_players = document.getElementById("no-players");
        if(no_players){
            document.getElementById("randomize-btn").disabled = true;
        }
    </script>
</html>