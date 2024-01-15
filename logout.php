<?php 
session_destroy();
session_unset();     
unset($_SESSION['user']);
header('location:index.php');