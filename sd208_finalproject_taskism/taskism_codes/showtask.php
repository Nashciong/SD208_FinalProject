<?php
ob_start();
session_start();
require_once('includes/connect.inc');

include 'display_search.php';

$dateToday = date("Y-m-d");

function build_calendar($month, $year)
{
    $daysOfWeek = array('Sn', 'M', 'T', 'W', 'Th', 'F', 'S');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);

    // What is the name of the month in question?
    $monthName = $dateComponents['month'];

    // What is the index value (0-6) of the first day of the
    // month in question.
    $dayOfWeek = $dateComponents['wday'];

    // Create the table tag opener and day headers

    $calendar = "<table class='calendar'>";
    $calendar .= "<h3>";
    $calendar .= build_previousMonth($month, $year);
    $calendar .= $monthName . " " . $year;
    $calendar .= build_nextMonth($month, $year);
    $calendar .= "</h3>";
    $calendar .= "<tr>";

    //calendar headers

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }

    // Create the rest of the calendar

    // Initiate the day counter, starting with the 1st.

    $currentDay = 1;

    $calendar .= "</tr><tr>";

    // The variable $dayOfWeek is used to
    // ensure that the calendar
    // display consists of exactly 7 columns.

    if ($dayOfWeek > 0) {
        $calendar .= "<td colspan='$dayOfWeek' class='not-month'>&nbsp;</td>";
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {

        // Seventh column (Saturday) reached. Start a new row.

        if ($dayOfWeek == 7) {

            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";

        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);

        $date = "$year-$month-$currentDayRel";

        if ($date == date("Y-m-d")) {
            $calendar .= "<td class='day today' rel='$date'><span class='today-date'>$currentDay</span></td>";
        } else {
            $calendar .= "<td class='day' rel='$date'><span class='day-date'>$currentDay</span></td>";
        }


        // Increment counters

        $currentDay++;
        $dayOfWeek++;

    }



    // Complete the row of the last week in month, if necessary

    if ($dayOfWeek != 7) {

        $remainingDays = 7 - $dayOfWeek;
        $calendar .= "<td colspan='$remainingDays' class='not-month'>&nbsp;</td>";

    }

    $calendar .= "</tr>";

    $calendar .= "</table>";

    return $calendar;
}

function build_previousMonth($month, $year)
{

    $prevMonth = $month - 1;

    if ($prevMonth == 0) {
        $prevMonth = 12;
    }

    if ($prevMonth == 12) {
        $prevYear = $year - 1;
    } else {
        $prevYear = $year;
    }

    $dateObj = DateTime::createFromFormat('!m', $prevMonth);
    $monthName = $dateObj->format('F');

    return "<span class='prev-icon' style='color: #DC9C74;'><a style='color: #DC9C74;font-weight:bold;' href='?m=" . $prevMonth . "&y=" . $prevYear . "'> <i class='bx bx-left-arrow-circle' style='color: #DC9C74; font-size: 24px;'></i></a></span>";
}

function build_nextMonth($month, $year)
{

    $nextMonth = $month + 1;

    if ($nextMonth == 13) {
        $nextMonth = 1;
    }

    if ($nextMonth == 1) {
        $nextYear = $year + 1;
    } else {
        $nextYear = $year;
    }

    $dateObj = DateTime::createFromFormat('!m', $nextMonth);
    $monthName = $dateObj->format('F');

    return "<span class='next-icon'  style='color: #DC9C74;'><a style='color: #DC9C74;font-weight:bold;' href='?m=" . $nextMonth . "&y=" . $nextYear . "'> <i class='bx bx-right-arrow-circle' style='color: #DC9C74; font-size: 24px;'></i></a></span>";
}

if(isset($_SESSION['logged_in']) && isset($_SESSION['username'])){

    $prof = $_SESSION['profile'];

    $username = $_SESSION['username'];
    $id = $_SESSION['userID'];

    ?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LOGO -->
    <title>taskism</title>
    <link rel="icon" type="image/x-icon" href="../taskism_images/logo.png">

    <!-- CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    
    <style>
        <?php include "home.css" ?>
    </style>

</head>

<body>

    <!-- NAVIGATION -->
    <section class="navigation-container" id="navigation-container">

        <!-- logo -->
        <div class="logo" id="logo">
            <h1>taskism</h1>
        </div>
        <!-- search bar -->
        <div class="searchbar">
            <i class='bx bx-search-alt'></i>
            <input type="text" name="search" class="search" id="search" placeholder="search here">
        </div>
        <!-- navigation -->

        <form action="" method="get">

            <div class="nav-link" id="nav-link">
                <a href="home.php"><button class="sidebtn"><i class='bx bx-home-alt'></i> home</button></a>
                <button name="filterbtn" class="sidebtn"><i class='bx bx-grid-alt'></i> filters & labels</button>
            </div>

            <div class="profile">
                <div class="profile-container">
                    <img src="../taskism_codes/uploads/<?php echo($prof)?>" alt="">
                </div>

                <div class="profile-link">
                    <a name="helpbtn" onclick="showTask(document.getElementById('myModal'))" class="helpbtn"> <button type="button" class="help-link" id="helpBtn"><i class='bx bx-help-circle'></i> help</button> </a>
                    <a href="logout.php"><button class="logout-link" type="button"><i class='bx bx-exit'></i> logout</button></a>
                </div>
            </div>

        </form>

    </section>

    <!-- HOME BODY -->  
    <section class="body-container">


        <section class="home-container">
            <h1>Show Task</h1>

            <form action="" method="post" class="mywork" id="mywork">
                <?php
                
                
                    if(isset($_GET['id'])){
                        $taskID = $_GET['id'];

                        $tasks = "SELECT * FROM `tasks` where taskID = $taskID";   
                        $task_query_today = mysqli_query($conn, $tasks) or die ("Cannot connect to table"); 

                        
                    }

                ?>
            </form>

        </section>

        
    </section>


    <!-- CALENDAR -->
    <section class="calendar-container">

        <?php
            parse_str($_SERVER['QUERY_STRING'], $query);

            if (empty($query['m'])) {

                $dateComponents = getdate();
                $month = $dateComponents['mon'];
                $year = $dateComponents['year'];
            } else {
                $month = $query['m'];
                $year = $query['y'];
            }


            ?>
        <div class="fixed-calendar">
            <h1>Calendar</h1>

            <div class="container">

                <div class="calendarHead">
                    <?php

                        parse_str($_SERVER['QUERY_STRING'], $query);

                        if (empty($query['m'])) {

                            $dateComponents = getdate();
                            $month = $dateComponents['mon'];
                            $year = $dateComponents['year'];
                        } else {

                            $month = $query['m'];
                            $year = $query['y'];


                        }
                        echo build_calendar($month, $year);

                        ?>
                </div>
            </div>

        </div>

    </section>

    <section class="addTask_big">
        <div>
            <a onclick="showTask(document.getElementById('taskModal'));" style="text-decoration: none;"><button class="adding" style="border:none;"><i class='bx bx-plus'></i></button></a>
        </div>
            <section class="help-modal">
                <!-- The Modal -->
                <div id="taskModal" class="addtask_modal">

                    <!-- Modal content -->
                    <div class="modal-content">

                        <div class="modal-header">
                            <h1>  </h1>
                            <span class="close" onclick="closeTask(document.getElementById('taskModal'))">&times;</span>
                        </div>
                            <h2>start a task</h2>

                        <div class="modal-body">

                            <div class="addtask-content">
                            <form action="addtask.php" method="post">
                                <div class="inputs task_input">
                                    <input type="text" placeholder="title" name="title" id="title" required>
                                </div>

                                <div class="date_status">
                                    <div class="inputs task_input date1">
                                        <label for="duedate">Due Date</label>
                                        <input type="date" id="duedate" name="duedate" min="<?php echo $dateToday;?>" required="required">
                                    </div>

                                    <div class="inputs task_input status1">
                                        <label for="status">Status</label>
                                        
                                        <div class="custom-select">
                                            <select name="status" id="status">
                                                <option value="urgent" style="color: #F24E1E">Urgent</option>
                                                <option value="high" style="color:#E69B00">High</option>
                                                <option value="normal" style="color:#005B96">Normal</option>
                                                <option value="low" style="color:#6C8054">Low</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="text_area task_input">
                                    <textarea placeholder="description here..." name="desc" id="desc"></textarea>
                                </div>   
                                <div class="text_area task_input">
                                    <input type="submit" name="addtask" value="save task" class="save">
                                </div>
                            </form>

                            </div>
                        </div>

                    </div>

                </div>
            </section>
    </section>

    <script>
        
        var now = document.getElementById("now-empty");
        var overdue = document.getElementById("overdue-empty");
        var upcoming = document.getElementById("upcoming-empty");

        function changeIcon(x, y) {
            x.classList.toggle("bxs-right-arrow");

            if (y.style.display === "none") {
                y.style.display = "block";
            }
            else {
                y.style.display = "none";
            }
        }


        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];
        var start = document.getElementsByClassName("getStarted")[0];
        var btn = document.getElementById("helpBtn");

        function showModal(){
            modal.style.display = "block";
        }

        btn.onclick = function () {
            modal.style.display = "block";
        }

        function closEx() {
            location.reload()
        }
        function getStarted() {
            location.reload()
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        } 
        
        function showTask(x){
            x.style.display = "block";
        }

        function closeTask(x){
            x.style.display = 'none';
        }

        const optionMenu = document.querySelector(".select-menu"),
          selectBtn = optionMenu.querySelector(".select-btn"),
          options = optionMenu.querySelectorAll(".option"),
          sBtn_text = optionMenu.querySelector(".sBtn-text");

        selectBtn.addEventListener("click", () => optionMenu.classList.toggle("active"));

        options.forEach(option =>{
                option.addEventListener("click", () =>{
                            let selectedOption = option.querySelector(".option-text").innerText;
                            sBtn_text.innerText = selectedOption;
                            optionMenu.classList.remove("active")
                })
                
        })


    </script>
</body>

</html>

<?php

    }else{
    session_unset();
    session_destroy();
    header("Refresh:.0;url=login.php"); } 
?>  