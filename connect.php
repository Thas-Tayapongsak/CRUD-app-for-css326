<?php
#change to staff user
$mysqli = new mysqli('localhost','root','root','ivms'); 
   if($mysqli->connect_errno){
      echo $mysqli->connect_errno.": ".$mysqli->connect_error;
   }
?>