<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <script src="https://kit.fontawesome.com/27bb130eca.js" crossorigin="anonymous"></script>        
        <title>RJS2000 - Home</title>
        <link rel="icon" type="image/png" href="../assets/img/dice_icon_white.png">
    </head>
    <body>
        <div class="content">
            <div class="app">

                <div class="controls">
                    <div class="musicOn">
                        <img class="play" src="../assets/img/sound-png-3.png"></img>
                        <input type="range" id="volume-control">
                        <audio id="player" loop>
                            <source src="../assets/music/tuplapotti_musa.mp3" type="audio/mp3">
                        </audio>
                    </div>
                    <div class="teacher-mode">
                        <a href="../php/teacher_mode.php"><img src="../assets/img/teacher.png"></img></a>
                    </div>
                </div>
                
                <div class="heading">
                    <h1><a href="..">RJS2000</a></h1>
                    <p class="rating">"Perhaps the world's best randomization machine." - Elin Mosk</p>
                </div>

                <div id="qr-code"></div>

                <div class="timer">
                    <span id="counter"></span>
                </div>

            </div>
        </div>
    </body>
    <footer>
        <p>2022 © Kerttula</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
    <script>
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

        // QR magic
        const qrcode = new QRCode(document.getElementById('qr-code'), {
            text: 'https://hmlsolutions.com/cloud11/RJS2000/php/enter_game.php',
            width: 400,
            height: 400,
            colorDark : '#000',
            colorLight : '#fff',
            correctLevel : QRCode.CorrectLevel.H
        });

        // Countdown magic
        function countdown() {
            var seconds = 60;
            function tick() {
            var counter = document.getElementById("counter");
            seconds--;
            counter.innerHTML =
                "0:" + (seconds < 10 ? "0" : "") + String(seconds);
            if (seconds > 0) {
                setTimeout(tick, 1000);
            } else {
                window.location = "..";
            }
            }
            tick();
        } 
        countdown();
    </script>
</html>