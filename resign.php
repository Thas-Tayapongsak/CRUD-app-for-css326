<?php 
    session_start();
    require_once('connect.php');   
    #update personal info
    if(isset($_POST['resign-submit'])) { 
        $pswd_in = $_POST['confpass'];

        $confq = $mysqli->prepare("select passwd from staff where uname = ?;");
        $confq->bind_param("s", $unam);

        $unam = $_SESSION['username'];
        #check confirm password
        if ($_POST['confpass'] != "") {
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
                        #send delete query
                        $resignq = $mysqli->prepare("delete from staff where uname = ?");
                        $resignq->bind_param("s", $unam);

                        $unam = $_SESSION['username'];
                        if (!$resignq->execute()) {
                            header('Refresh: 3; URL = profile.php');
                            echo("Unsuccessful resignation (" . $mysqli -> errno . "): " . $mysqli -> error);
                            echo "<br>Please try again or sign up for a new account.";
                            echo "<br>You will be redirected. Or click <a href=\"profile.php\">here</a>.</p>";
                        } else {
                            header('Refresh: 3; URL = logout.php');
                            echo "<p>Successfully resigned ".$unam; 
                            echo "<br>You will be redirected. Or click <a href=\"logout.php\">here</a>.</p>";
                        }

                        $resignq->close();
                    } else {
                        header('Refresh: 3; URL = profile.php');
                        echo "Incorrect password for '".$unam."'."; 
                        echo "<br>You will be redirected. Or click <a href=\"profile.php\">here</a>.</p>";
                    }
                }
            }
        } else {
            header('Refresh: 3; URL = profile.php');
            echo "Enter password to confirm changes.";
            echo "<br>You will be redirected. Or click <a href=\"profile.php\">here</a>.</p>";
        }
    }

?>