<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['id']) && isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['name'])) {
    if ($db->dbConnect()) 
    {
        if ($db->signUp("user_info", $_POST['id'], $_POST['user_name'], $_POST['password'], $_POST['name'])) 
       {
            echo "Sign Up Success";
        } else echo "Sign up Failed";
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>
