<?php

include('mongodb.php');
include('mysql.php');

ini_set('session.save_handler', "redis");
ini_set('session.save_path', "tcp://localhost:6379");

session_start();

$users = new Users();
$profiles = new MySql_DB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['user']) && isset($_POST['profile'])) {
        $res = $users->new_user($_POST['user']);
        if ($res[0]) {
            if ($profiles->new_profile($_POST['profile'])) {
                echo null;
            } else {
                echo "Error occurred while adding profile to mysql";
            }
        } else {
            echo $res[1];
        }

    } else {
        echo json_encode([
            "error" => "No data to update!"
        ]);
    }

}

?>