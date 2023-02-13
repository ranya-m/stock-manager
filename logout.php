<?php 
session_start();
unset($fetchUser);
session_destroy();
header("location:./login.php")
?>