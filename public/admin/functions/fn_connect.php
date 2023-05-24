<?php
//database connection
$error = "Problem connecting";
$con = mysqli_connect('localhost','root','') or die($error);
$database_name = 'legarda_db';
mysqli_select_db($con, $database_name) or die(mysqli_error($error));
?>