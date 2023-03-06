<?php
class MySql_DB
{


    private $con;

    function __construct()
    {
        $host = "localhost:3306";
        $user = "root";
        $pass = "";
        $db = "user-profiles";

        $this->con = new mysqli($host, $user, $pass, $db);


        if (!$this->con) {
            echo "RIP DB";
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function read_profile($uname)
    {
        try {
            // $con = new mysqli($this->host, $this->user, $this->pass, $this->db);
            $st = $this->con->prepare("select * from profiles where username = ?");
            $st->bind_param("s", $uname);
            $st->execute();
            $result = $st->get_result();
            $profile = $result->fetch_all(MYSQLI_ASSOC);

            if (count($profile) > 0) {
                // echo $profile;
                header('Content-Type: application/json');
                return json_encode($profile[0]);
            } else {
                return false;
            }

        } catch (\Throwable $th) {
            echo $th;
            return ["ERROR", $th];

        }

    }

    public function new_profile(iterable $profile)
    {
        try {
            $st = $this->con->prepare("INSERT INTO `profiles` (`username`, `name`, `dob`, `phone`, `email`, `bio`) VALUES (?, ?, ?, ?, ?, ?)");

            $st->bind_param("sssiss", $profile['username'], $profile['name'], $profile['dob'], $profile['phone'], $profile['email'], $profile['bio']);
            $st->execute();
            return [true];
        } catch (\Throwable $th) {
            echo $th;
            return [false, $th];
        }
    }

    public function edit_profile(iterable $profile)
    {
        try {
            $st = $this->con->prepare("UPDATE `profiles` SET `name` = ?, `dob` = ?, `phone` = ?, `email` = ?, `bio` = ? WHERE `profiles`.`username` = ?");

            $phone = (int) $profile['phone'];
            $st->bind_param("ssisss", $profile['name'], $profile['dob'], $phone, $profile['email'], $profile['bio'], $profile['username']);
            $st->execute();
            return [true];
        } catch (\Throwable $th) {
            echo $th;
            return [false, $th];
        }
    }
}

?>