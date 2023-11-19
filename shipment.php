<?php 
    session_start();
    require_once('connect.php');   

    #query branch info
    $branchq = $mysqli->prepare("select branch from staff where uname = ?;");
    $branchq->bind_param("s", $unam);
    $unam = $_SESSION['username'];

    if (!$branchq->execute()) {
        echo("Error retrieving branch information (" . $mysqli -> errno . "): " . $mysqli -> error);
    } else {
        $branchq->bind_result($brch);
            while ($branchq->fetch()) {
            }
    }

    $branchq->close();

    #insert into shipment and inventory
    if(isset($_POST['inv-submit'])){ 

        $pswd_in = $_POST['confpass'];

        $confq = $mysqli->prepare("select passwd from staff where uname = ?;");
        $confq->bind_param("s", $unam);

    #prevent empty string input
    #check password
        if ($_POST['confpass'] != "") {
            if (!$confq->execute()) {
                echo("Unsuccessful shipment request (" . $mysqli -> errno . "): " . $mysqli -> error);
            } else {
                $confq->bind_result($pswd_comp);
                while ($confq->fetch()) {
                    if (password_verify($pswd_in,$pswd_comp)) {
                        $confq->close();
                        
                    #insert into inventory
                        $iname = $_POST['i_name'];
                        $itype = $_POST['i_type'];
                        $quant = intval($_POST['quantity']);
                        $price = intval($_POST['price']);

                        $invq = $mysqli->prepare("insert into inventory (i_name, i_type, quantity, price, branch) values (?,?,?,?,?);");
                        $invq->bind_param("ssiis", $iname, $itype, $quant, $price, $brch);

                        if (!$invq->execute()) {
                            echo("Error adding into inventory (" . $mysqli -> errno . "): " . $mysqli -> error);
                        } else {
                            header('Refresh: 3;');
                            echo "Successfully added into inventory";
                            echo "<br>You will be redirected. Or click <a href=\"shipment.php\">here</a>.</p>"; #refresh
                        }

                        $invq->close();

                    #insert into shipment 


                    } else {
                        echo "Incorrect password for '".$unam."'."; 
                    }
                }
            }

        } else {
            echo "Please enter password.";
        }
    }

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
                    <!--enter lot information in form-->                    
                    <h1>SHIPMENT</h1> 
                    <form action="shipment.php" method="post">
                        <div class="init-form-input">
                            <label for="branch">Branch :</label>
                            <?php echo "<p>".$brch."</p>";?>
                        </div>
                        <div class="init-form-input">
                            <label for="i_name">Name :</label>
                            <input type="text" name="i_name" id="i_name" placeholder="product name" required>
                        </div>
                        <div class="init-form-input">
                            <label for="i_type">Type :</label>
                            <input type="text" name="i_type" id="i_type" placeholder="product type" required>
                        </div>
                        <div class="init-form-input">
                            <label for="quantity">Quantity :</label>
                            <input type="text" name="quantity" id="quantity" placeholder="quantity" required>
                        </div>
                        <div class="init-form-input">
                            <label for="price">Price :</label>
                            <input type="text" name="price" id="price" placeholder="price" required>
                        </div>
                        <div class="init-form-input">
                            <label for="confpass">Confirm change :</label>
                            <input type="password" name="confpass" id="confpass" placeholder="Enter your password" required>
                        </div>
                        <input id="inv-submit" type="submit" name="inv-submit" value="UPDATE"/>
                    </form>

                    <h1>INVENTORY</h1>
                    <div class="table-container">
                        <!-- display all the inventory in this branch -->
                        <?php
                            $invq = $mysqli->prepare("select lot_id, i_name, i_type from inventory where branch = ?;");
                            $invq->bind_param("s", $brch);

                            if (!$invq->execute()) {
                                echo("Error retrieving inventory information (" . $mysqli -> errno . "): " . $mysqli -> error);
                            } else {
                                $ires = $invq->get_result();
                            }

                            $invq->close();
                        ?>
                        
                        <table>
                            <tr>
                                <td>ID</td>
                                <td>Product</td>
                                <td>Type</td>
                            </tr>
                            <?php
                                while ($irow = $ires->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$irow['lot_id']."</td>";
                                    echo "<td>".$irow['i_name']."</td>";
                                    echo "<td>".$irow['i_type']."</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
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