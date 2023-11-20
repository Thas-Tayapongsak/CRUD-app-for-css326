<?php
    session_start();
    require_once('connect.php'); 
    $mysqli->change_user("manager", "manager", "ivms");
    
    $confq = $mysqli->prepare("select passwd from staff where uname = ?");
    $confq->bind_param("s", $unam);

    $unam = $_SESSION['username'];
    $pswd_in = $_POST['confpass'];
    $mthd = $_POST['method'];
    $sid = intval($_POST['shipment']);
   
    #check confirm password
    if (!$confq->execute()) {
        header('Refresh: 3; URL = manager.php');
        echo("Wrong password (" . $mysqli -> errno . "): " . $mysqli -> error);
        echo "<br>Please try again or sign up for a new account.";
        echo "<br>You will be redirected. Or click <a href=\"manager.php\">here</a>.</p>";
    } else {
        $confq->bind_result($pswd_comp);
        while ($confq->fetch()) {
            if (password_verify($pswd_in,$pswd_comp)) {
                $confq->close();

                $shipq = $mysqli->prepare("update shipment set ship_mthd = ? where ship_id = ?");
                
                $shipq->bind_param("si", $mthd, $sid);

                if (!$shipq->execute()) {
                    header('Refresh: 3; URL = manager.php');
                    echo("Could not update shipment method (" . $mysqli -> errno . "): " . $mysqli -> error);
                    echo "<br>Please try again or sign up for a new account.";
                    echo "<br>You will be redirected. Or click <a href=\"manager.php\">here</a>.</p>";
                } else {
                    header('Refresh: 3; URL = manager.php');
                    echo "<br>Successfully updated shipment method";
                     echo "<br>You will be redirected. Or click <a href=\"manager.php\">here</a>.</p>";
                }
            }
        }
    }
?>