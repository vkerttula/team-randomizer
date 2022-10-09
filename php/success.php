<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <script src="https://kit.fontawesome.com/27bb130eca.js" crossorigin="anonymous"></script>    
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <title>RJS2000 - Home</title>
        <link rel="icon" type="image/png" href="../assets/img/dice_icon_white.png">
    </head>
    <body>
        <div class="content">
            <div class="app">

                <h1>✅ Success</h1>
                <p>Closing page in <span id="counter"></span> ...</p>

            </div>
        </div>
    </body>
    <footer>
        <p>2022 © Kerttula</p>
    </footer>
    <script>
        function countdown() {
            var seconds = 5;
            function tick() {
            var counter = document.getElementById("counter");
            seconds--;
            counter.innerHTML =
                "0:" + (seconds < 10 ? "0" : "") + String(seconds);
            if (seconds > 0) {
                setTimeout(tick, 1000);
            } else {
                window.location = "http://www.vamk.fi";
            }
            }
            tick();
        } 
        countdown();
    </script>
</html>