<?php

include("mysql.php");

ini_set('session.save_handler', "redis");
ini_set('session.save_path', "tcp://localhost:6379");

session_start();

$profiles = new MySql_DB();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['logout'])) {
        $_SESSION['user'] = null;
    } else {
        echo $profiles->read_profile($_SESSION['user']);
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST)) {
        if ($profiles->edit_profile($_POST)[0]) {
            print_r($_POST['age']);
            echo null;
        } else {
            echo json_encode([
                "error" => "Some error occurred while updating!"
            ]);
        }
    } else {
        echo json_encode([
            "error" => "No data to update!"
        ]);
    }

}

?>