<?php
    include_once '../db/Database.php';
    session_start();

    $database = new Database();
    $db = $database->getConnection();

    // check if email already exists
    if(isset($_POST['email'])){
        $email = $_POST['email'];
        $passwd = $_POST['passwd'];
        $conf_passwd = $_POST['confirm-passwd'];

        $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row){
            // the email already exists
            header("Location: register.php?error_email=1");
        }
        // check if pass and conf_pass are equal
        if (!($passwd === $conf_passwd)){
        // conf_pass differs
            header("Location: register.php?error_pas=1");
        } else {
            // if ok, create
            // get last id from db
                $stmt = $db->query("SELECT id_u FROM user ORDER BY id_u DESC LIMIT 1");
                $last_id_u = $stmt->fetchColumn();
                if (!($last_id_u !== false)) {
                    // if there is no user then this will be the first
                    $last_id_u = 1;
                } else $last_id_u++;
                // normalize data
                $fname = ucfirst(strtolower($_POST['name']));
                $lname = ucfirst(strtolower($_POST['pren']));
                $gen = 'O';
                switch ($_POST['sex']){
                    case 'male':    $gen = 'M'; break;
                    case 'female':  $gen = 'F'; break;
                    case 'other':   $gen = 'O'; break;
                    case 'prefer_not_to_say': $gen = 'P'; break;
                }

                // insert user
                $stmt = $db->prepare("INSERT INTO user (id_u, pass, nume, pren, rol, datan, gen, email) VALUES
                        (:id_u, :pass, :nume, :pren, 'user', :datan, :gen, :email)");
                $stmt->bindParam(':id_u', $last_id_u);
                $stmt->bindParam(':pass', $passwd);
                $stmt->bindParam(':nume', $fname);
                $stmt->bindParam(':pren', $lname);
                $stmt->bindParam(':datan', $_POST['birthdate']);
                $stmt->bindParam(':gen', $gen);
                $stmt->bindParam(':email', $email);

                if ($stmt->execute()){
                    // go to login
                    header("Location: login.php");
                } else {
                    // try again
                    header("Location: register.php?eror_reg=1");
                }
        }
    }
?>