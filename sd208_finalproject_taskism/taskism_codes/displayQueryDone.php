<?php
ob_start();
session_start();
require_once('includes/connect.inc');

$dateToday = date("Y-m-d");


if (isset($_POST['done'])) {

    $today = $_POST['done'];

    $id = $_SESSION['userID'];

    $myQuery = "SELECT * FROM `tasks` WHERE userID=$id and completed=1";

    $result = mysqli_query($conn, $myQuery) or die ("Cannot connect to table");

    $counter = 1;

    if (mysqli_num_rows($result) > 0) { ?>
        <h1>Done Tasks:</h1>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $title = $row['title'];
            $dueDate = date_create($row['dueDate']);
            $status = $row['status']; 
            $taskID = $row['taskID'];
            $completed = $row['completed'];
            
            ?>  
        <form action="updatetask.php" method="post">
            <div class="done_task task-container">
                <div class="task-left">
                <p><?php echo $counter++."."; ?></p>
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
        <?php   }  ?>  
    
         <style>
            <?php include('display_css.css')?>
         </style>

<?php
    } else {
        ?>
            <div class="empty-container">
                <img src="../taskism_images/Feeling Blue-bro.png" alt="">
            </div>
            <div class="text">
                <p class="span">Oops! You haven't done any tasks yet.</p>
                <p class="span-sub">Checked tasks will appear here.</p>
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
    function showtask(url){
        document.location = url;
    }
</script>