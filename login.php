<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['user_name']) && isset($_POST['password'])) {
    if ($db->dbConnect()) {
        if ($db->logIn("users", $_POST['user_name'], $_POST['password'])) 
       {
            echo "Login Success";
        } else echo "Username or Password wrong";
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>
