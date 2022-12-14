<?php
ob_start();
session_start();
require_once('includes/connect.inc');


$dateToday = date("Y-m-d");

if (isset($_POST['overdue'])) {

    $overdue = $_POST['overdue'];

    $id = $_SESSION['userID'];

    $myQuery = "SELECT * FROM `tasks` WHERE tasks.dueDate<'$dateToday' and userID=$id and completed=0";

    $result = mysqli_query($conn, $myQuery);

    $rows = mysqli_num_rows($result);

    if (mysqli_num_rows($result) > 0) { 
        ?>

        <?php if (!isset($_SESSION['alert_overdue'])) { ?>
        <script>
            setTimeout("alert('Attention: Please attend to your <?php echo $rows ?> overdue task/s! Start doing it now, better now than never!');", 4000);
            setInterval("alert('Attention: Please attend to your <?php echo $rows ?> overdue task/s! Start doing it now, better now than never!');", 60*1000);
        </script>
        <?php $_SESSION['alert_overdue'] = 'overdue'; }?>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $title = $row['title'];
            $dueDate = date_create($row['dueDate']);
            $status = $row['status'];
            $taskID = $row['taskID']; ?>   
        
        <form action="updatetask.php" method="post">
            <div class="task-container">
                <div class="task-left">
                <a href="javascript:openupdate('donetask.php?id=<?php echo $taskID?>')" name="submit"><i id="checkbox" class='bx bx-checkbox' onclick="changeIcon(this)"></i></a>
                <p><?= $title?></p>
                </div>
                <div class="task-right">
                    <p><?= date_format($dueDate, "m.d.y") ?></p>

                    <a href="#" name="status" class="status" style="color: 
                    <?php if(strcasecmp($status, "urgent") == 0){
                        echo "#F24E1E";
                    }elseif(strcasecmp($status, "high") == 0){
                        echo "#E69B00";
                    }elseif(strcasecmp($status, "normal") == 0){
                        echo "#005B96";
                    }elseif(strcasecmp($status, "low") == 0){
                        echo "#6C8054";
                    } ?>">
                    <i class='bx bxs-flag-alt'></i></a>

                    <a href="javascript:openulr('delete.php?id=<?php echo $taskID?>')" name="delete"><i class='bx bxs-trash' ></i></a>
                    <a href="javascript:showtask('home.php?id=<?php echo $taskID?>')" name="view" class="view">(view)</a>

                </div>
            </div>   
            
        </form>     
            
         <?php } ?>

         <style>
            <?php include('display_css.css') ?>
         </style>
<?php
    } else {
        ?>
            <div class="empty-container">
                <img src="../taskism_images/Honesty-amico.png" alt="">
            </div>
            <div class="text">
                <p class="span">Yay! No overdue tasks!</p>
                <p class="span-sub">Overdue tasks will appear here.</p>
            </div>
        
        <?php
    }
}
?>

<script type="text/javascript">
    function openulr(newurl) { 
        if(confirm("Are you sure you want to delete this task?")) {
            document.location = newurl;  
        } else{
            return false;
        }
    }
    function openupdate(newurl) { 
        if(confirm("Are you sure you want to mark task/s done?")) {
            document.location = newurl;  
        } else{
            location.reload();
        }
    }
    function changeIcon(x) {
        x.classList.toggle("bx-checkbox-checked");
    }
    function showtask(url){
        document.location = url;
    }
</>