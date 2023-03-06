<?php

include('mongodb.php');

ini_set('session.save_handler', "redis");
ini_set('session.save_path', "tcp://localhost:6379");

session_start();

$usersDB = new Users();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uname = null;
    $pass = null;

    if (isset($_POST['uname']) && isset($_POST['pass'])) {
        $uname = $_POST['uname'];
        $pass = $_POST['pass'];

        $user = $usersDB->read_user($uname);
        if ($user) {
            if ($pass == $user['password']) {
                echo json_encode([
                    "user" => $user['username']
                ]);
                $_SESSION['user'] = $user['username'];
            } else {
                echo json_encode([
                    "error" => "Wrong password"
                ]);
                $_SESSION['user'] = null;
            }
        } else {
            echo json_encode([
                "error" => "Username doesn't exist"
            ]);
            $_SESSION['user'] = null;
        }

    }
}

?>