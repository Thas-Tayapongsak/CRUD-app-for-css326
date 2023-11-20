<?php
#change to staff user
$mysqli = new mysqli('localhost','staff','staff','ivms'); 
   if($mysqli->connect_errno){
      echo $mysqli->connect_errno.": ".$mysqli->connect_error;
   }
?>