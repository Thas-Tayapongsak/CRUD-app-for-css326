<?php 
    session_start();
    require_once('connect.php');   

    #query all personal info
    $profq = $mysqli->prepare("select fname, lname, dateofbirth from staff where uname = ?;");
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
                    <?php
                        echo "<h1>UPDATE PROFILE</h1>"; 
                        #update staff info
                    ?>
                    <form action="update.php" method="post">
                        <div class="init-form-input">
                            <label for="firstname">First name :</label>
                            <input type="text" name="firstname" id="firstname" placeholder="<?php echo $row['fname'];?>">
                        </div>
                        <div class="init-form-input">
                            <label for="lastname">Last name :</label>
                            <input type="text" name="lastname" id="lastname" placeholder="<?php echo $row['lname'];?>">
                        </div>
                        <div class="init-form-input">
                            <label for="dateofbirth">Last name :</label>
                            <input type="date" name="dateofbirth" id="dateofbirth" value="<?php echo $row['dateofbirth'];?>">
                        </div>
                        <div class="init-form-input">
                            <label for="username">Username :</label>
                            <?php echo "<p>".$unam."</p>"?>
                        </div>
                        <div class="init-form-input">
                            <label for="password">Password :</label>
                            <P>****</p>
                        </div>
                        <div class="init-form-input">
                            <label for="branch">Branch :</label>
                            <?php echo "<p>".$_SESSION['branch']."</p>";?>
                        </div>
                        <div class="init-form-input">
                            <label for="confpass">Confirm change :</label>
                            <input type="password" name="confpass" id="confpass" placeholder="Enter your password" required>
                        </div>
                        <input id="prof-submit" type="submit" name="prof-submit" value="UPDATE"/>
                    </form>

                    <!--resign button, delete from staff-->
                    <h1>RESIGNATION</h1>
                    <form action="resign.php" method="post">
                        <div class="init-form-input">
                            <label for="confpass">Confirm change :</label>
                            <input type="password" name="confpass" id="confpass" placeholder="Enter your password" required>
                        </div>
                        <input id="resign-submit" type="submit" name="resign-submit" value="RESIGN"/>
                    </form>
                </div>
                <div class="init-logo">
                    <!-- placeholder profile image -->    
                    <img alt="Default profile picture" src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg">
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