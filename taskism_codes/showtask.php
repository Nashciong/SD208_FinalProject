<?php
ob_start();
session_start();
require_once 'config.php';

?>
<?php
// $connection = mysql_connect("localhost", "root", ""); // Establishing Connection with Server
// $db = mysql_select_db("taskism", $connection); // Selecting Database
// //MySQL Query to read data
// $query = mysql_query("select * from tasks", $connection);
// while ($row = mysql_fetch_array($query)) {
// echo "<b><a href="readphp.php?id={$row['employee_id']}">{$row['employee_name']}</a></b>";
// echo "<br />";
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Task</title>
    <link rel="stylesheet" href="showtask.css">
    <link href='https://fonts.googleapis.com/css?family=Fredoka One' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Fredoka' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<?php


function showTitle(){
    require_once 'config.php';
    $conn = mysqli_connect($server_name, $db_user, $db_pass);
    $db_select = mysqli_select_db($conn, $db_name);
    $sql = "SELECT * FROM task";
    $res = mysqli_query($conn, $sql);
if($res==true){
    $count_rows = mysqli_num_rows($res);
    
    if ($count_rows>0) {
        while ($row=mysqli_fetch_assoc($res)) {
            # code...
                $title = $row['title'];
        }
    }
}else{

}

}

function showDate(){
    
}

function showStatus(){
    
}


function showDescription(){
    
}


?>
     <div class="container">
        <button type="submit" class="btn" onclick="openPopup()"> Show tasks</button>
        <div class="popup" id="popup">
          
            <h3>task</h3>
           
            <hr class="line">
            
            <p class="react">Oops! This task is overdue!</p>
           
            <div class="tasktitle">
                    Web dev 3 Final Project
            </div>
            <div>
                <p class="duedate"> Due Date</p>
                <div class="date">
                    <h1>wala pa ni</h1>
                    <i class='bx bx-calendar-event bx-sm'  ></i>
                </div>
                <p class="status">Status</p>
                <div class="stat">
                    <div>
                  <p><i class='bx bxs-flag-alt bx-sm'></i>
                wala pa ni
                </p></div>
                    <i class='bx bx-caret-down bx-sm' ></i>
                  
                </div>
            </div>
            <div class="description">
                <p class="descrip">Final Project for web Dev 3 by Sir John Rey Hernani. Assigned for project mockup</p>
            </div>
            <br>
            <button type="submit" onclick="closePopup()" class="done"> mark as done</button>
        </div>
     </div>

   <script>
    let popup = document.getElementById("popup");

    function openPopup(){
        popup.classList.add("open-popup");
    }

    
    function closePopup(){
        popup.classList.remove("open-popup");
    }
    
   </script>  
</body>
</html>