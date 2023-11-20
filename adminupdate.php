<?php
    session_start();
    require_once('connect.php'); 

    $pswd_in = $_POST['confpass'];

    $confq = $mysqli->prepare("select passwd from staff where uname = ?;");
    $confq->bind_param("s", $unam);

    $unam = $_SESSION['username'];
   
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

                $shipq = $mysqli->prepare("update set ship_mthd = ? where ship_id = ?");
                $shipq->bind_param("si", $mthd, $sid);

                $mthd = $_POST['method'];
                $sid = $_POST['shipment'];

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