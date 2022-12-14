<?php
ob_start();
session_start();
require_once('includes/connect.inc');

$dateToday = date("Y-m-d");
$checkbox = "";

$id = $_SESSION['userID'];
$user = $_SESSION['username'];

if (isset($_GET['id'])) {
    $taskid = $_GET['id'];
        
    $query = "UPDATE `tasks` SET `completed`=1 WHERE userID=$id and taskID=$taskid";  
    $run = mysqli_query($conn,$query); 

    if ($run == 1) {  
     echo "<script>alert('Task is marked as done! Good job, $user!')</script>";
     header('location:home.php');  
   }else{  
        echo "Error: ".mysqli_error($conn);  
   }  
}

?>