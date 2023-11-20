<?php 
    session_start();
    require_once('connect.php');   

    #select lot and enter new price
    $lotq = $mysqli->prepare("select lot_id, i_name, i_type, quantity, price from inventory where branch = ?");
    $lotq->bind_param("s", $brch);

    $brch = $_SESSION['branch'];

    if (!$lotq->execute()) {
        echo("Unable to access inventory (" . $mysqli -> errno . "): " . $mysqli -> error);
    } else {
        $res = $lotq->get_result();
    }

    $lotq->close();
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
                    <!--update staff info-->                    
                    <h1>EDIT PRICE</h1> 
                    <form action="update.php" method="post">
                        <div class="init-form-input">
                            <label for="branch">Branch :</label>
                            <?php echo "<p>".$brch."</p>";?>
                        </div>
                        <div class="init-form-input">
                            <label for="lot">Lot :</label>
                            <select name="lot" id="lot">
                                <?php
                                    foreach ($res as $row) {
                                        echo "<option value='".$row['lot_id']."'>".$row['i_name']." (".$row['lot_id'].")</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="init-form-input">
                            <label for="price">New price :</label>
                            <input type="text" name="price" id="price" placeholder="price" required>
                        </div>
                        <div class="init-form-input">
                            <label for="confpass">Confirm change :</label>
                            <input type="password" name="confpass" id="confpass" placeholder="Enter your password" required>
                        </div>
                        <input id="lot-submit" type="submit" name="lot-submit" value="UPDATE"/>
                    </form>

                    <h1>INVENTORY</h1>
                    <div class="table-container">
                        <!-- display inventory of this branch -->
                        <table>
                            <tr>
                                <td>ID</td>
                                <td>Product</td>
                                <td>Type</td>
                                <td>Quantity</td>
                                <td>Price</td>
                            </tr>
                            <?php
                                foreach ($res as $row) {
                                    echo "<tr>";
                                    echo "<td>".$row['lot_id']."</td>";
                                    echo "<td>".$row['i_name']."</td>";
                                    echo "<td>".$row['i_type']."</td>";
                                    echo "<td>".$row['quantity']."</td>";
                                    echo "<td>".$row['price']."</td>";
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