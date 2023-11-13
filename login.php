<?php 
    session_start();
    require_once('connect.php');   

    if(isset($_POST['login-submit'])){ 

        $pswd_in = $_POST['password'];

        $loginq = $mysqli->prepare("select passwd from staff where uname = ?;");
        $loginq->bind_param("s", $unam);

        $unam = $_POST['username'];

        if ($unam != "" AND $_POST['password'] != "") {#prevent empty string input
            if (!$loginq->execute()) {
                echo("Unsuccessful account login (" . $mysqli -> errno . "): " . $mysqli -> error);
                echo "<br>Please try again or sign up for a new account.";
            } else {
                $loginq->bind_result($pswd_comp);
                while ($loginq->fetch()) {
                    if (password_verify($pswd_in,$pswd_comp)) {
                        $_SESSION['username'] = $unam;
                        header('Refresh: 3; URL = home.php');
                        echo "<p>Logged in as '".$unam."'.";
                        echo "<br>You will be redirected. Or click <a href=\"home.php\">here</a>.</p>"; #redirect to home page
                    } else {
                        echo "Incorrect password for '".$unam."'."; 
                    }
                }
            }
        } else {
            echo "Please enter username and password.";
        }
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