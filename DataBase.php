<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    protected $servername;
    protected $user_name;
    protected $password;
    protected $databasename;

    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->user_name = $dbc->user_name;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->user_name, $this->password, $this->databasename);
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    function logIn($table, $user_name, $password)
    {
        $user_name = $this->prepareData($user_name);
        $password = $this->prepareData($password);
        $this->sql = "select * from " . $table . " where user_name = '" . $user_name . "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            $dbuser_name = $row['user_name'];
            $dbpassword = $row['password'];
            if ($dbuser_name == $user_name && password_verify($password, $dbpassword)) {
                $login = true;
            } else $login = false;
        } else $login = false;

        return $login;
    }

    function signUp($table, $id, $user_name, $password, $name)
    {
        $id = $this->prepareData($id);
        $user_name = $this->prepareData($user_name);
        $password = $this->prepareData($password);
        $name = $this->prepareData($name);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->sql =
            "INSERT INTO " . $table . " (id, user_name, password, name) VALUES ('" . $id . "','" . $user_name . "','" . $password . "','" . $name . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }

}

?>
