<?php
    session_start();

    // Destroy the session
    session_unset();
    session_destroy();
    // set logout
    $_SESSION['is_loged'] = false;

    // go to login
    header('Location: login.php');
    exit;
?>