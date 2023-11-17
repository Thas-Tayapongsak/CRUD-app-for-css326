<?php 
    session_start();
    require_once('connect.php');   
    #update personal info
    if(isset($_POST['prof-submit'])) { 
        $pswd_in = $_POST['confpass'];

        $confq = $mysqli->prepare("select passwd from staff where uname = ?;");
        $confq->bind_param("s", $unam);

        $unam = $_SESSION['username'];
        #check confirm password
        if ($_POST['confpass'] != "" AND $_POST['firstname'] != "" AND $_POST['lastname'] != "") {
            if (!$confq->execute()) {
                header('Refresh: 3; URL = profile.php');
                echo("Wrong password (" . $mysqli -> errno . "): " . $mysqli -> error);
                echo "<br>Please try again or sign up for a new account.";
                echo "<br>You will be redirected. Or click <a href=\"profile.php\">here</a>.</p>";
            } else {
                $confq->bind_result($pswd_comp);
                while ($confq->fetch()) {
                    if (password_verify($pswd_in,$pswd_comp)) {
                        $confq->close();
                        #update query
                        $updateq = $mysqli->prepare("update staff set fname = ?, lname = ? where uname = ?;");
                        $updateq->bind_param("sss", $fnam, $lnam, $unam);

                        $unam = $_SESSION['username'];
                        $fnam = $_POST['firstname'];
                        $lnam = $_POST['lastname'];

                        if (!$updateq->execute()) {
                            header('Refresh: 3; URL = profile.php');
                            echo("Unsuccessful change (" . $mysqli -> errno . "): " . $mysqli -> error);
                            echo "<br>Please try again or sign up for a new account.";
                            echo "<br>You will be redirected. Or click <a href=\"profile.php\">here</a>.</p>";
                        } else {
                            header('Refresh: 3; URL = profile.php');
                            echo "<p>Successfully changed ".$unam."'s personal information."; 
                            echo "<br>You will be redirected. Or click <a href=\"profile.php\">here</a>.</p>";
                        }

                        $updateq->close();
                    } else {
                        header('Refresh: 3; URL = profile.php');
                        echo "Incorrect password for '".$unam."'."; 
                        echo "<br>You will be redirected. Or click <a href=\"profile.php\">here</a>.</p>";
                    }
                }
            }
        } else {
            header('Refresh: 3; URL = profile.php');
            echo "Enter all the information and password to confirm changes.";
            echo "<br>You will be redirected. Or click <a href=\"profile.php\">here</a>.</p>";
        }
    }

?>