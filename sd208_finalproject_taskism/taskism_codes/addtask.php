<?php
ob_start();
session_start();
require_once 'config.php';

$date = date("Y-m-d");
$id = $_SESSION['userID'];

if(isset($_POST['addtask'])){
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $duedate = $_POST['duedate'];
    $status = $_POST['status'];


    $sql = "INSERT INTO tasks (userID, title, description, taskStart, dueDate, status, completed) VALUES(?,?,?,?,?,?,?)";
    $stmtinsert = $db->prepare($sql);
    $result = $stmtinsert->execute([$id , $title, $desc, $date, $duedate, $status, 0]);
    
    if($result == 1){
        echo "<script>alert('Task is added successfully!')</script>";
        header("refresh: .3; url=home.php");
    }else{
        echo "<script>alert('error')</script>";
    }
    
}
?>