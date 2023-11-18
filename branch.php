<?php 
    session_start();
    require_once('connect.php');   

    #query all branch info
    $branchq = $mysqli->prepare("select branch, b_address, b_email, b_tel from branch where branch = (select branch from staff where uname = ?);");
    $branchq->bind_param("s", $unam);
    $unam = $_SESSION['username'];

    if (!$branchq->execute()) {
        echo("Error retrieving branch information (" . $mysqli -> errno . "): " . $mysqli -> error);
    } else {
        $res = $branchq->get_result();
        $row = $res->fetch_assoc();
    }

    $branchq->close();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="signup-style.css">
        <title>Finn & co. parcel company — branch</title>
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
                            echo "<h1>BRANCH</h1>"; 
                            #update staff info
                        ?>
                        <form action="update.php" method="post">
                            <div class="init-form-input">
                                <label for="branch">Branch :</label>
                                <?php echo "<p>".$row['branch']."</p>";?>
                            </div>
                            <div class="init-form-input">
                                <label for="b_address">Address :</label>
                                <input type="text" name="b_address" id="b_address" placeholder="<?php echo $row['b_address'];?>">
                            </div>
                            <div class="init-form-input">
                                <label for="b_email">Email :</label>
                                <input type="email" name="b_email" id="b_email" placeholder="<?php echo $row['b_email'];?>">
                            </div>
                            <div class="init-form-input">
                                <label for="b_tel">Telephone :</label>
                                <input type="text" name="b_tel" id="b_tel" placeholder="<?php echo $row['b_tel'];?>">
                            </div>
                            <div class="init-form-input">
                                <label for="confpass">Confirm change :</label>
                                <input type="password" name="confpass" id="confpass" placeholder="Enter your password" required>
                            </div>
                            <input id="branch-submit" type="submit" name="branch-submit" value="UPDATE"/>
                        </form>
                    </div>
                    <div class="init-form">
                        <h1>STAFF</h1>
                        <div class="table-container">
                            <!-- display all the staff in this branch -->
                            <?php
                                #query all personal info
                                $staffq = $mysqli->prepare("select fname, lname, dateofbirth from staff where branch = ?;");
                                $staffq->bind_param("s", $brch);
                                $brch = $row['branch'];

                                if (!$staffq->execute()) {
                                    echo("Error retrieving branch information (" . $mysqli -> errno . "): " . $mysqli -> error);
                                } else {
                                    $sres = $staffq->get_result();
                                }

                                $staffq->close();
                            ?>
                            
                            <table>
                                <tr>
                                    <td>First name</td>
                                    <td>Last name</td>
                                    <td>Date of birth</td>
                                </tr>
                                <?php
                                    while ($srow = $sres->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$srow['fname']."</td>";
                                        echo "<td>".$srow['lname']."</td>";
                                        echo "<td>".$srow['dateofbirth']."</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="init-logo">
                    <!-- placeholder profile image -->    
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