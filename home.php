<?php session_start();
    require_once('connect.php');   
    #query all branch info
    $branchq = $mysqli->prepare("select branch from staff where uname = ?;");
    $branchq->bind_param("s", $unam);
    $unam = $_SESSION['username'];

    if (!$branchq->execute()) {
        echo("Error retrieving branch information (" . $mysqli -> errno . "): " . $mysqli -> error);
    } else {
        $branchq->bind_result($brch);
            while ($branchq->fetch()) {
                $_SESSION['branch'] = $brch;
            }
    }

    $branchq->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="signup-style.css">
        <title>Finn & co. parcel company — home</title>
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
                    <a href="profile.php">PROFILE</a>
                    <a href="branch.php">BRANCH</a>
                    <a href="shipment.php">SHIPMENT</a>
                    <a href="inventory.php">INVENTORY</a>
                    <a href="admin.php">ADMIN</a>
                </div>
            </div>
        </header>
        <main>
            <div class="init-page">
                <div class="init-form">
                    <?php
                        echo "<h1>WELCOME ".$_SESSION['username']."</h1>"; #maybe change to first and last name?
                    ?>
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