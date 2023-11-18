<?php 
    session_start();
    require_once('connect.php');   
    #update personal info
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
                    #check confirm password

                    #update staff
                    if(isset($_POST['prof-submit'])) {
                        $updateq = $mysqli->prepare("update staff set fname = ?, lname = ? where uname = ?;");
                        $updateq->bind_param("sss", $fnam, $lnam, $unam);

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

                    } else if(isset($_POST['branch-submit'])) {
                        $updateq = $mysqli->prepare("update branch set b_address = ?, b_email = ?, b_tel = ? where branch = (select branch from staff where uname = ?);");
                        $updateq->bind_param("ssss", $baddress, $bemail, $btel, $unam);

                        $baddress = $_POST['b_address'];
                        $bemail = $_POST['b_email'];
                        $btel = $_POST['b_tel'];

                        if (!$updateq->execute()) {
                            header('Refresh: 3; URL = branch.php');
                            echo("Unsuccessful change (" . $mysqli -> errno . "): " . $mysqli -> error);
                            echo "<br>Please try again or sign up for a new account.";
                            echo "<br>You will be redirected. Or click <a href=\"branch.php\">here</a>.</p>";
                        } else {
                            header('Refresh: 3; URL = branch.php');
                            echo "<p>Successfully changed ".$unam."'s branch information."; 
                            echo "<br>You will be redirected. Or click <a href=\"branch.php\">here</a>.</p>";
                        }

                        $updateq->close();

                    } else {
                        header('Refresh: 3; URL = home.php');
                        echo "Enter all the information";
                        echo "<br>You will be redirected. Or click <a href=\"home.php\">here</a>.</p>";
                    }
                    #update branch

                } else {
                    header('Refresh: 3; URL = home.php');
                    echo "Incorrect password for '".$unam."'."; 
                    echo "<br>You will be redirected. Or click <a href=\"home.php\">here</a>.</p>";
                }
            }
        }
    } else {
        header('Refresh: 3; URL = home.php');
        echo "Enter the password";
        echo "<br>You will be redirected. Or click <a href=\"home.php\">here</a>.</p>";
    }

?>