<?php

function showTop($title){
    ?>
    <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <script
                    src="https://code.jquery.com/jquery-3.3.1.js"
                    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
                    crossorigin="anonymous"></script>
            <link href="jquery.js">
            <link href="css/list.css" type="text/css" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
            <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
            <link rel="icon" href="img/favicon.ico" type="image/x-icon">
            <title><?= $title ?></title>
        </head>
        <body>
            <header>
                <nav class="bar">
                    <img src="favicon.ico" class="favicon">
                    <a href="index.php" class="titre-en-tete">KINO</a>
                    <a href="index.php" class="text-en-tete">List</a>
                    <?php
                        if(empty($_SESSION["user"])) {
                            ?>
                            <a href="inscription.php" class="text-en-tete">Register</a>
                            <a href="login.php" class="text-en-tete">Login</a>
                            <?php
                        }
                        else {
                            ?>
                            <a href="watchlist.php" class="text-en-tete">Watchlist</a>
                            <a href="logout.php" class="text-en-tete">Logout</a>
                            <?php
                        }
                    ?>

                </nav>
            </header>

    <?php
        if(!empty($_SESSION['flash'])){
            echo '<div class="alert">';
            echo $_SESSION["flash"];
            echo '</div>';

            unset($_SESSION['flash']);
        }
    ?>

            <main>
    <?php
}

function showBottom(){
    ?>
                </main>
                <footer>
                    <div class="footer">
                        <div>
                            <p><a href="faq.php">FAQ</a></p>
                        </div>
                        <div>
                            <p><a href="contact.php">Contact us</a></p>
                        </div>
                        <div>
                            <p><a href="Legal.php">Legal Stuff</a></p>
                        </div>
                    </div>
                </footer>
            </body>
        </html>
    <?php
}