<?php 
  $cn = mysqli_connect("localhost", "root", "", "destov") or die("Connection Failed");
  mysqli_select_db($cn, 'destov');  
?>