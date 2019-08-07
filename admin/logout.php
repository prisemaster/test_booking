<?php
    session_start();
    $_SESSION = array();
    session_destroy();

    setcookie('hash', '', strtotime('-2 days'));
    setcookie('id', '', strtotime('-2 days'));

    header('Location: login.php');
    exit();
?>