<?php require_once('connect.php');   

    if(isset($_POST['login-submit'])){ 
        #if (!$mysqli -> query("")) {
            #echo("Unsuccessful account login (" . $mysqli -> errno . "): " . $mysqli -> error);
            echo "<br>Please try again or sign up for a new account.";
        #}
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="signup-style.css">
        <title>Finn & co. parcel company — log in</title>
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
                    <a href="#">LOG IN</a>
                    <a href="signup.php">SIGN UP</a>
                </div>
            </div>
        </header>
        <main>
            <div class="init-page">
                <div class="init-form">
                    <h1>LOG IN</h1>
                    <form action="login.php" method="post">
                        <div class="init-form-input">
                            <label for="username">Username </label>
                            <input type="text" name="username" id="username" placeholder="please enter your username">
                        </div>
                        <div class="init-form-input">
                            <label for="password">Password </label>
                            <input type="password" name="password" id="password" placeholder="please enter your password">
                        </div>
                        <input id="login-submit" type="submit" name="login-submit" value="LOG IN"/>
                    </form>
                </div>
                <div class="init-logo">
                    <img alt="Internet Explorer unofficial icon" src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/Internet_Explorer_unofficial_icon.svg/256px-Internet_Explorer_unofficial_icon.svg.png">
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