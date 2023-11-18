<?php 
    session_start();
    require_once('connect.php');   

    #query all personal info
    $profq = $mysqli->prepare("select fname, lname, branch from staff where uname = ?;");
    $profq->bind_param("s", $unam);
    $unam = $_SESSION['username'];

    if (!$profq->execute()) {
        echo("Error retrieving personal information (" . $mysqli -> errno . "): " . $mysqli -> error);
    } else {
        $res = $profq->get_result();
        $row = $res->fetch_assoc();
    }

    $profq->close();
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
                    <div class="init-form">
                        <?php
                            echo "<h1>UPDATE ".$_SESSION['username']."'s PROFILE</h1>"; 
                            #update staff info
                        ?>
                        <form action="profileupdate.php" method="post">
                            <div class="init-form-input">
                                <label for="firstname">First name :</label>
                                <input type="text" name="firstname" id="firstname" placeholder="<?php echo $row['fname'];?>">
                            </div>
                            <div class="init-form-input">
                                <label for="lastname">Last name :</label>
                                <input type="text" name="lastname" id="lastname" placeholder="<?php echo $row['lname'];?>">
                            </div>
                            <div class="init-form-input">
                                <label for="username">Username :</label>
                                <?php echo "<p>".$_SESSION['username']."</p>"?>
                            </div>
                            <div class="init-form-input">
                                <label for="password">Password :</label>
                                <P>****</p>
                            </div>
                            <div class="init-form-input">
                                <label for="branch">Branch :</label>
                                <?php echo "<p>".$row['branch']."</p>";?>
                            </div>
                            <div class="init-form-input">
                                <label for="confpass">Confirm change :</label>
                                <input type="password" name="confpass" id="confpass" placeholder="Enter your password">
                            </div>
                            <input id="prof-submit" type="submit" name="prof-submit" value="UPDATE"/>
                        </form>
                    </div>
                    <div class="init-form">
                        <?php
                            echo "<h1>RESIGNATION</h1>"; 
                            #resign button, delete from staff
                        ?>
                        <form action="resign.php" method="post">
                            <div class="init-form-input">
                                <label for="confpass">Confirm change :</label>
                                <input type="password" name="confpass" id="confpass" placeholder="Enter your password">
                            </div>
                            <input id="resign-submit" type="submit" name="resign-submit" value="RESIGN"/>
                        </form>
                    </div>
                </div>
                <div class="init-logo">
                    <!-- placeholder profile image -->    
                    <img alt="Default profile picture" src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg">
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