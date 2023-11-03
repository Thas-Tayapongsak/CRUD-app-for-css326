<?php
$setup = new mysqli('localhost','root','root');
   if($setup->connect_errno){
      echo $setup->connect_errno.": ".$setup->connect_error;
   }

#Other tables and stuffs that need to be pre-made can be added below
$q = "create database if not exists ivms;";

if ($setup->query($q)) {
    echo "Database created successfully with the name IVMS";
} else {
    echo "Error creating database: " . $setup->error;
}
#Other tables and stuffs that need to be pre-made can be added above

// closing connection
$setup->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="signup-style.css">
        <title>Finn & co. parcel company — set up</title>
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
                    <a>LOG IN</a>
                    <a href="signup.php">SIGN UP</a>
                    <a href="#">SET UP</a>
                </div>
            </div>
        </header>
        <main>
            <div class="init-page">
                <div class="init-form">
                    <h1>SET UP</h1>
                    <form action="signup.php" method="post">
                        <input id="setup-submit" type="submit" name="setup-submit" value="GO BACK"/>
                    </form>
                </div>
                <div class="init-logo">
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