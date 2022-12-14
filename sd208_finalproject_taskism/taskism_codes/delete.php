<?php

ob_start();
session_start();
require_once('includes/connect.inc');

if (isset($_GET['id'])) {
    $taskid = $_GET['id'];
        
    $query = "DELETE FROM `tasks` where `taskID`=$taskid";  
    $run = mysqli_query($conn,$query); 
    if ($run == 1) {
          echo "<script>alert('Task successfully deleted!')</script>";
          header("refresh: .3; url=home.php");
   }else{  
        echo "Error: ".mysqli_error($conn);  
   }  
}

?>