<?php 
    session_start();
    require_once('connect.php');   

    #query branch info
    $brch = $_SESSION['branch'];
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
                    <form action="update.php" method="post">
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
                        <!-- ADD WAREHOUSE -->
                        <div class="init-form-input">
                            <?php
                                #get ware_id and warehouse address
                                $wareq = $mysqli->prepare("select ware_id, w_address from warehouse;");

                                if (!$wareq->execute()) {
                                    echo("Error retrieving branch information (" . $mysqli -> errno . "): " . $mysqli -> error);
                                } else {
                                    $wres = $wareq->get_result();
                                }

                                $wareq->close();
                            ?>
                            <label for="warehouse">Warehouse :</label>
                            <select name="warehouse" id="warehouse">
                                <?php
                                    while ($wrow = $wres->fetch_assoc()) {
                                        echo "<option value='".$wrow['ware_id']."'>".$wrow['w_address']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- ADD SHIPMENT METHOD select input type-->
                        <div class="init-form-input">
                            <label for="method">Shipment method :</label>
                            <select name="method" id="method">
                                <option value="scheduled">Scheduled</option>
                                <option value="express">Express</option>
                                <option value="request">Request</option>
                            </select>
                        </div>
                        <div class="init-form-input">
                            <label for="confpass">Confirm change :</label>
                            <input type="password" name="confpass" id="confpass" placeholder="Enter your password" required>
                        </div>
                        <input id="inv-submit" type="submit" name="inv-submit" value="SEND"/>
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