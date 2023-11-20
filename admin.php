<?php
global $mysqli;
session_start();
    require_once('connect.php');   

    if(isset($_POST['admin-submit'])){ 

        $pswd_in = $_POST['password'];
        $unam = $_POST['username'];

        $loginq = $mysqli->prepare("select passwd, managerflag from staff where uname = ?;");
        $loginq->bind_param("s", $unam);

    #prevent empty string input
    #check password
        if ($unam != "" AND $_POST['password'] != "") {
            if (!$loginq->execute()) {
                echo("Unsuccessful account login (" . $mysqli -> errno . "): " . $mysqli -> error);
                echo "<br>Please try again or sign up for a new account.";
            } else {
                $res = $loginq->get_result();
                while ($row = $res->fetch_assoc()) {
                    $pswd_comp = $row['passwd'];
                    $mflag = $row['managerflag'];
                    if (password_verify($pswd_in,$pswd_comp) AND $mflag == "1") {
                        $_SESSION['username'] = $unam;
                        header('Refresh: 3; URL = manager.php');
                        echo "<p>Logged in as '".$unam."'.";
                        echo "<br>You will be redirected. Or click <a href=\"manager.php\">here</a>.</p>"; #redirect to home page
                    } else {
                        echo "Incorrect password for '".$unam."' or user is not manager."; 
                    }
                }
            }

            $loginq->close();

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
        <title>Finn & co. parcel company — admin log in</title>
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
                    <a href="logout.php">LOG OUT</a>
                    <a href="home.php">HOME</a>
                </div>
            </div>
        </header>
        <main>
            <div class="init-page">
                <div class="init-form">
                    <h1>MANAGER LOG IN</h1>
                    <form action="admin.php" method="post">
                        <div class="init-form-input">
                            <label for="username">Username </label>
                            <input type="text" name="username" id="username" placeholder="please enter your username">
                        </div>
                        <div class="init-form-input">
                            <label for="password">Password </label>
                            <input type="password" name="password" id="password" placeholder="please enter your password">
                        </div>
                        <input id="admin-submit" type="submit" name="admin-submit" value="LOG IN"/>
                    </form>
                </div>
                <div class="init-logo">
                    <img alt="Internet Explorer unofficial icon" src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/Internet_Explorer_unofficial_icon.svg/256px-Internet_Explorer_unofficial_icon.svg.png">
                </div>
            </div>
        </main>
        <footer>
            <address>
                131 หมู่ 5 ถ. ติวานนท์<br>ตำบลบางกะดี อำเภอเมืองปทุมธานี<br>ปทุมธานี 12000
            </address>
        </footer>
    </body>
</html>