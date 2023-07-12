<?php
session_start();
session_unset();
session_destroy();

if(isset($_SESSION['username'])){
    unset($_SESSION['username']);
}

// var_dump($_SESSION);

header('Location: ../index.php');
exit();


?>