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

                    <h1>LIST</h1>
                    <div class="table-container">
                        <!-- display all the inventory in this branch -->
                        <?php
                            #select shipment
                            $shipq = $mysqli->prepare("select ship_id, uname, branch, lot_id, ware_id, ship_mthd from shipment where branch = ?");
                            $shipq->bind_param("s", $brch);

                            $brch = $_SESSION['branch'];

                            if (!$shipq->execute()) {
                                echo("Unable to access shipment list (" . $mysqli -> errno . "): " . $mysqli -> error);
                            } else {
                                $res = $shipq->get_result();
                            }

                            $shipq->close();
                        ?>
                        
                        <!-- display shipment of this branch -->
                        <table>
                            <tr>
                                <td>ID</td>
                                <td>Staff</td>
                                <td>Lot ID</td>
                                <td>Warehouse ID</td>
                                <td>Method</td>
                            </tr>
                            <?php
                                foreach ($res as $row) {
                                    echo "<tr>";
                                    echo "<td>".$row['ship_id']."</td>";
                                    echo "<td>".$row['uname']."</td>";
                                    echo "<td>".$row['lot_id']."</td>";
                                    echo "<td>".$row['ware_id']."</td>";
                                    echo "<td>".$row['ship_mthd']."</td>";
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
                131 หมู่ 5 ถ. ติวานนท์<br>ตำบลบางกะดี อำเภอเมืองปทุมธานี<br>ปทุมธานี 12000
            </address>
        </footer>
    </body>
</html>