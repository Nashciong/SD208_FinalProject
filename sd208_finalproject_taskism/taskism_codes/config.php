<?php 
$server_name = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "taskism";

// $db = new PDO('mysql:host=localhost;dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
// $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try{
    
    $db = new PDO("mysql:host=$server_name;dbname=" . $db_name . ";charset=utf8", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "";
    }
    catch (PDOException $e){
     echo "Error in Connection! " . $e->getMessage();
    }





?>



