<?php session_start();
    require_once('connect.php');   

    #query all personal info
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="signup-style.css">
        <title>Finn & co. parcel company — profile</title>
    </head>
    <body>
        <header>
            <div class="init-nav">
                <div class="init-nav-logo">
                    <figure>
                        <img alt="Internet Explorer unofficial icon" src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/Internet_Explorer_unofficial_icon.svg/256px-Internet_Explorer_unofficial_icon.svg.png">
                        <figcaption>Finn & co. inventory management system</figcaption>
                    </figure>
                </div>
                <div class="init-nav-tab">
                    <!-- link to other pages goes here vvv -->
                    <a href="logout.php">LOG OUT</a>
                    <a href="home.php">HOME</a>
                </div>
            </div>
        </header>
        <main>
            <div class="init-page">
                <div class="init-form">
                    <?php
                        echo "<h1>WELCOME ".$_SESSION['username']."</h1>"; 

                        #form to display & edit all the personal info

                        #resign button, delete from staff
                    ?>
                </div>
                <div class="init-logo">
                    <!-- placeholder profile image -->    
                </div>
            </div>
        </main>
        <footer>
            <address>
                Lorem ipsum<br>
                dolor sit amet,<br>
                consectetur<br>
                adipiscing elit.
            </address>
        </footer>
    </body>
</html>