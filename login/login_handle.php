<?php
    include_once '../db/Database.php';
    session_start();

    $database = new Database();
    $db = $database->getConnection();

    // check passwd
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];

    $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $row = $stmt->fetch();
    if ($row){
        $db_passwd = $row['pass'];

        //check passwd
        if ($passwd === $db_passwd){
            // get user data
            $_SESSION['is_loged'] = true;
            $_SESSION['user_id'] = $row['id_u'];
            $_SESSION['nume'] = $row['nume'];
            $_SESSION['pren'] = $row['pren'];
            $_SESSION['rol'] = $row['rol'];
            $_SESSION['email'] = $row['email'];

            header("Location: ../index.php");
        } else {
            // wrong passwd
            header("Location: login.php?error_pas=1");
        }
    } else {
        // inexistent email
        header("Location: login.php?error_email=1");
    }


?>