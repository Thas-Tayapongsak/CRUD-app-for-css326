<?php require_once('connect.php');   

    if(isset($_POST['signup-submit'])){ 

    #prepare sql statement
        $unam = strtolower($_POST['username']);
        $pswd = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $fnam = strtolower($_POST['firstname']);
        $lnam = strtolower($_POST['lastname']);
        $dob  = $_POST['dateofbirth'];
        $mflag = $_POST['usertype'];
        $brch = strtolower($_POST['branch']);

    #insert branch first   
        $branchq = $mysqli->prepare("insert into branch (branch, b_address, b_email, b_tel) values (?, '', '', '0000000000')");
        $branchq->bind_param("s", $brch);

        if (!$branchq->execute()) {
            echo("Branch already exists.<br>");
        } else {
            echo "New branch '".$brch."' has been added.<br>";
        }

        $branchq->close();

#insert staff
        $signupq = $mysqli->prepare("insert into staff (uname, passwd, fname, lname, dateofbirth, branch, managerflag) values (?, ?, ?, ?, ?, ?, ?);");
        $signupq->bind_param("sssssss", $unam, $pswd, $fnam, $lnam, $dob, $brch, $mflag);

#prevent empty string input

        if (!$signupq->execute()) {
            echo("Unsuccessful account signup (" . $mysqli -> errno . "): " . $mysqli -> error);
            echo "<br>Please try again with a new username or login with an existing account.";
        } else {
            echo "New account '".$unam."' has been added.";
        }

        $signupq->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="signup-style.css">
        <title>Finn & co. parcel company — sign up</title>
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
                    <a href="login.php">LOG IN</a>
                    <a href="#">SIGN UP</a>
                </div>
            </div>
        </header>
        <main>
            <div class="init-page">
                <div class="init-form">
                    <h1>SIGN UP</h1>
                    <form action="signup.php" method="post">
                        <div class="init-form-input">
                            <label for="firstname">First name :</label>
                            <input type="text" name="firstname" id="firstname" placeholder="please enter your first name" required>
                        </div>
                        <div class="init-form-input">
                            <label for="lastname">Last name :</label>
                            <input type="text" name="lastname" id="lastname" placeholder="please enter your last name" required>
                        </div>
                        <div class="init-form-input">
                            <label for="dateofbirth">Date of birth :</label>
                            <input type="date" name="dateofbirth" id="dateofbirth">
                        </div>
                        <div class="init-form-input">
                            <label for="username">Username :</label>
                            <input type="text" name="username" id="username" placeholder="please enter your username" required>
                        </div>
                        <div class="init-form-input">
                            <label for="password">Password :</label>
                            <input type="password" name="password" id="password" placeholder="please enter your password" required>
                        </div>
                        <div class="init-form-input">
                            <label for="branch">Branch :</label>
                            <input type="text" name="branch" id="branch" placeholder="please enter your branch ID" required>
                        </div>
                        <div class="init-form-input">
                            <label for="staff"> Staff</label>
                            <input type="radio" id="staff" name="usertype" value="0" checked>
                            <label for="manager"> Manager</label>
                            <input type="radio" id="manager" name="usertype" value="1">
                        </div>
                        <input id="signup-submit" type="submit" name="signup-submit" value="SIGN UP"/>
                    </form>
                </div>
                <div class="init-logo">
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
