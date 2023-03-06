<?php

require '../vendor/autoload.php';

use MongoDB\Client;

class Users
{

    private $client;

    private $users;

    function __construct()
    {
        try {
            $this->client = new Client("mongodb://127.0.0.1:27017");
            $this->users = $this->client->selectCollection("accounts", "users");
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    function read_user($uname)
    {
        $result = $this->users->findOne(['username' => $uname]);
        if ($result) {
            return $result;
        } else {
            return false;
        }

    }

    public function new_user(iterable $user)
    {
        if (isset($user['username']) && isset($user['password'])) {
            if ($this->read_user($user['username'])) {
                return [false, "Username already exists"];
            } else {
                $result = $this->users->insertOne($user);

                if ($result->getInsertedCount() > 0) {
                    return [true, "Success"];
                } else {
                    return [false, "Some error occurred while adding user to mongoDB"];
                }
            }
        } else {
            return [false, "Inadequate data to add user to mongoDB"];
        }
    }
}

?>