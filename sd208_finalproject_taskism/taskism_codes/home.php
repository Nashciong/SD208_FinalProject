<?php
ob_start();
session_start();
require_once('includes/connect.inc');

include 'display_search.php';

$dateToday = date("Y-m-d");

function build_calendar($month, $year)
{
    $daysOfWeek = array('Sn', 'M', 'T', 'W', 'Th', 'F', 'S');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);   //mktime(hour, minute, second, month, day, year, is_dst)-Return the Unix timestamp for a date. Then use it to find the day of that date.
    $numberDays = date('t', $firstDayOfMonth); //date(format, timestamp) - Format a local date and time and return the formatted date strings // t - The number of days in the given month
    $dateComponents = getdate($firstDayOfMonth); //getdate(timestamp) - Return date/time information of the current local date/time

    $monthName = $dateComponents['month']; //get the month name

    // What is the index value (0-6) of the first day of the month in question.
    $dayOfWeek = $dateComponents['wday']; //w - numeric representation of the day, d - day of the month, a -Lowercase am or pm, y - two digit representation of a year

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

    // The variable $dayOfWeek is used to ensure that the calendar display consists of exactly 7 columns. (the 7 days of the week)

    if ($dayOfWeek > 0) {
        $calendar .= "<td colspan='$dayOfWeek' class='not-month'>&nbsp;</td>";
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT); //str_pad(string,length,pad_string,pad_type) - function pads a string to a new length.

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

    $dateObj = DateTime::createFromFormat('!m', $prevMonth); //public static DateTime::createFromFormat(string $format, string $datetime, ?DateTimeZone $timezone = null): DateTime|false = Returns a new DateTime object representing the date and time specified by the datetime string, which was formatted in the given format.
    $monthName = $dateObj->format('F'); // F - full textual representation of a month (January through December)

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

    $tasks = "SELECT * FROM `tasks` where tasks.dueDate = '$dateToday' and userID=$id and completed=0";   
    $task_query_today = mysqli_query($conn, $tasks) or die ("Cannot connect to table"); 

    $tasks_overdue = "SELECT * FROM `tasks` where tasks.dueDate < '$dateToday' and userID=$id and completed=0";   
    $task_query_overdue = mysqli_query($conn, $tasks_overdue) or die ("Cannot connect to table"); 

    $tasks_upcoming = "SELECT * FROM `tasks` where tasks.dueDate > '$dateToday' and userID=$id and completed=0";   
    $task_query_upcoming = mysqli_query($conn, $tasks_upcoming) or die ("Cannot connect to table"); 

    $taks_done = "SELECT * FROM `tasks` where userID=$id and completed=1";   
    $task_query_done = mysqli_query($conn, $taks_done) or die ("Cannot connect to table"); 

    $userManual = "SELECT `userManual` FROM `register` WHERE username='$username'";
    $result_query = mysqli_query($conn, $userManual) or die("Cannot connect to table");

    $rows_today = mysqli_num_rows($task_query_today);
    $rows_overdue = mysqli_num_rows($task_query_overdue);
    $rows_upcoming = mysqli_num_rows($task_query_upcoming);
    $done = mysqli_num_rows($task_query_done);

    $todo = $rows_today + $rows_overdue + $rows_upcoming;

    $all_task = "SELECT * FROM `tasks` where userID=$id and completed=0";
    $all_task_query = mysqli_query($conn, $all_task) or die ("Cannot connect to table"); 

    $all_task_urgent = "SELECT * FROM `tasks` where userID=$id and completed=0 and status='urgent'";
    $all_task_query_urgent = mysqli_query($conn, $all_task_urgent) or die ("Cannot connect to table"); 

    $all_task_high = "SELECT * FROM `tasks` where userID=$id and completed=0 and status='high'";
    $all_task_query_high = mysqli_query($conn, $all_task_high) or die ("Cannot connect to table"); 

    $all_task_normal = "SELECT * FROM `tasks` where userID=$id and completed=0 and status='normal'";
    $all_task_query_normal = mysqli_query($conn, $all_task_normal) or die ("Cannot connect to table"); 

    $all_task_low = "SELECT * FROM `tasks` where userID=$id and completed=0 and status='low'";
    $all_task_query_low = mysqli_query($conn, $all_task_low) or die ("Cannot connect to table"); 

    $rows_urgent = mysqli_num_rows($all_task_query_urgent);
    $rows_high = mysqli_num_rows($all_task_query_high);
    $rows_normal = mysqli_num_rows($all_task_query_normal);
    $rows_low = mysqli_num_rows($all_task_query_low);
    

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
                <button name="homebtn" class="sidebtn"><i class='bx bx-home-alt'></i> home</button>
                <button name="filterbtn" class="sidebtn"><i
                        class='bx bx-grid-alt'></i> filters & labels</button>
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
    
    <?php 
        if(mysqli_num_rows($result_query) == 1){
            $manual = mysqli_fetch_row($result_query)[0];


            if($manual == 0){
    ?>
    <section class="help-modal">
        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h2>welcome, <?php echo $username; ?>!</h2>
                    <span class="close" onclick="closeEx();">&times;</span>
                </div>
                <div class="modal-body">
                    <h3>user manual</h3>
                    <br />
                    <p>our website is incredibly simple to access and utilize.
                        here are the following things you can do inside our website:</p>
                    

                    <div class="manual-content">
                        <form method="post">
                            <div class="addtask_icon">
                                <i class='bx bx-plus'></i>
                            </div>
                            <div class="description">click/tap this if you want to add new task.</div>
                            <button><i class='bx bx-home-alt'></i> home</button>
                            <div class="description">this will navigate you to the homepage of the website where you can see your to-do tasks instantly.</div>
                            <button><i class='bx bx-grid-alt'></i> filters & labels</button>
                            <div class="description">this will navigate you to the filters page of the website where you can see your tasks organized according to its priority level.</div>
                            <button class="todo" name="todo" id="todo">to do</button>
                            <div class="description">this is under the homepage where you can see your todo tasks organized according to its due date.</div>
                            <h1 class="now-head"><i class='bx bxs-down-arrow'></i>&nbsp;&nbsp;today</h1>
                            <div class="description">this is under the to do tab where you can see your todo tasks scheduled today.</div>
                            <h1 class="now-head"><i class='bx bxs-down-arrow'></i>&nbsp;&nbsp;overdue</h1>
                            <div class="description">this is under the to do tab where you can see your todo tasks scheduled before today.</div>
                            <h1 class="now-head"><i class='bx bxs-down-arrow'></i>&nbsp;&nbsp;upcoming</h1>
                            <div class="description">this is under the to do tab where you can see your todo tasks scheduled onwards.</div>
                            <button class="done" name="done" id="done">done</button>
                            <div class="description">this is under the homepage where you can see your achieved tasks.</div>
                            <button class="urgent" name="urgentbtn" id="urgent" style="color: #F24E1E;">urgent</button>
                            <div class="description">this is under the filters & labels tab where you can see your urgent tasks.</div>
                            <button class="high" name="highbtn" id="high" style="color: #E69B00;">high</button>
                            <div class="description">this is under the filters & labels tab where you can see your high priority tasks.</div>
                            <button class="normal" name="normalbtn" id="normal" style="color: #005B96;">normal</button>
                            <div class="description">this is under the filters & labels tab where you can see your normal priority tasks.</div>
                            <button class="low" name="lowbtn" id="low" style="color: #6C8054;">low</button>
                            <div class="description">this is under the filters & labels tab where you can see your low priority tasks.</div>

                            <h1>Calendar</h1>
                            <div class="description">this is displayed in every page to make you keep track of the date. this calendar is a non-event calendar so you can only see the next and previous months but you cannot add events to it.</div>


                            <div>
                                <br>
                                <br>
                                note: you can still see this by clicking the help button.
                                <button type="button" onclick="getStarted()" class="getStarted">get started!</button>
                            </div>


                        </form>

                    </div>
                </div>

            </div>

        </div>
    </section>
    <?php $update = "UPDATE `register` SET `userManual` = '1' WHERE `register`.`username` = '$username'";
            mysqli_query($conn, $update) or die ("Cannot connect to table");

        }
    }?>


    <!-- HOME BODY -->  
    <section class="body-container">

        <?php if (isset($_GET['homebtn']) || !isset($_GET['filterbtn'])) { 
               

            ?>

        <section class="home-container">
            <h1>My Work</h1>

            <form action="" method="post" class="mywork" id="mywork">
                <div class="work-nav">
                    <button class="todo" name="todo" id="todo">to do (<?php echo $todo ?>)</button>
                    <button class="done" name="done" id="done">done (<?php echo $done ?>)</button>
                </div>


                <?php if (!isset($_POST['done']) || isset($_POST['todo'])) { ?>
                <!-- TODO -->
                <div class="todo-body" id="todo-body">

                    <!-- TODAY -->
                    <section class="now" id="now">

                        <h1 class="now-head"><i onclick="changeIcon(this, document.getElementById('now-empty'))"
                                class='bx bxs-down-arrow'></i>today (<?php echo($rows_today); ?>)</h1>

                        <div class="now-empty" id="now-empty" name="now">
                            <?php if(mysqli_num_rows($task_query_today) > 0){ ?>
                                <div id="">
                                    <script>
                                        $(document).ready(function() {
                                            var d = new Date();

                                            var month = d.getMonth() + 1;
                                            var day = d.getDate();

                                            var output = d.getFullYear() + '-' +
                                                (('' + month).length < 2 ? '0' : '') + month + '-' +
                                                (('' + day).length < 2 ? '0' : '') + day;
                                            jQuery.ajax({
                                                url: "displayQueryToday.php",
                                                method: "POST",
                                                data: {
                                                    today: output,
                                                },
                                                success: function(data) {
                                                    $(".now-empty").fadeIn(1000).html(data);
                                                    $(".now-empty").css({
                                                        "display": " block",
                                                    });
                                                }
                                            })
                                        })
                                    </script>
                                </div> 
                            <?php } else {
                                ?>

                            <div class="empty-container">
                                <img src="../taskism_images/Enthusiastic-pana.png" alt="">
                            </div>
                            <div class="text">
                                <p class="span">Yay! No tasks for today!</p>
                                <p class="span-sub">Tasks scheduled today will appear here.</p>
                            </div>
                            <?php }?>

                        </div>

                    </section>

                    <!-- OVERDUE -->

                    <section class="overdue" id="overdue">

                        <h1 class="overdue-head"><i onclick="changeIcon(this, document.getElementById('overdue-empty'))" 
                        class='bx bxs-down-arrow'></i>overdue (<?php echo($rows_overdue); ?>)</h1>

                        <div class="overdue-empty" id="overdue-empty" name="overdue">
                            <?php if(mysqli_num_rows($task_query_overdue) > 0){ ?>
                                <div id="">
                                    <script>
                                        $(document).ready(function() {
                                            var d = new Date();

                                            var month = d.getMonth() + 1;
                                            var day = d.getDate();

                                            var output = d.getFullYear() + '-' +
                                                (('' + month).length < 2 ? '0' : '') + month + '-' +
                                                (('' + day).length < 2 ? '0' : '') + day;
                                            jQuery.ajax({
                                                url: "displayQueryOverdue.php",
                                                method: "POST",
                                                data: {
                                                    overdue: output,
                                                },
                                                success: function(data) {

                                                    $(".overdue-empty").fadeIn(1000).html(data);
                                                    $(".overdue-empty").css({
                                                        "display": " block",
                                                    });
                                                }
                                            })
                                        })
                                    </script>
                                </div>
                            <?php } else { ?>
                                <div class="empty-container">
                                    <img src="../taskism_images/Honesty-amico.png" alt="">
                                </div>
                                <div class="text">
                                    <p class="span">Yay! No overdue tasks!</p>
                                    <p class="span-sub">Overdue tasks will appear here.</p>
                                </div>
                            <?php }?>
                        

                        </div>

                    </section>

                    <!-- UPCOMING -->
                    <section class="upcoming" id="upcoming">

                        <h1 class="upcoming-head"><i
                                onclick="changeIcon(this, document.getElementById('upcomingEmpty'))"
                                class='bx bxs-down-arrow'></i>upcoming (<?php echo($rows_upcoming); ?>)</h1></h1>

                        <div class="upcoming-empty" id="upcoming-empty" name="upcoming">
                            <?php if(mysqli_num_rows($task_query_upcoming) > 0){ ?>
                                <div id="">
                                    <script>
                                        $(document).ready(function() {

                                            var d = new Date();

                                            var month = d.getMonth() + 1;
                                            var day = d.getDate();

                                            var output = d.getFullYear() + '-' +
                                                (('' + month).length < 2 ? '0' : '') + month + '-' +
                                                (('' + day).length < 2 ? '0' : '') + day;
                                            jQuery.ajax({
                                                url: "displayQueryUpcoming.php",
                                                method: "POST",
                                                data: {
                                                    upcoming: output,
                                                },
                                                success: function(data) {

                                                    $(".upcoming-empty").fadeIn(1000).html(data);
                                                    $(".upcoming-empty").css({
                                                        "display": " block",
                                                    });
                                                }
                                            })
                                        })
                                    </script>
                                </div>
                            <?php } else { ?>
                                    <div class="empty-container">
                                        <img src="../taskism_images/Product quality-rafiki.png" alt="">
                                    </div>
                                    <div class="text">
                                        <p class="span">Yay! No upcoming taks!</p>
                                        <p class="span-sub">Upcoming tasks will appear here.</p>
                                    </div>
                            <?php }?>

                        </div>

                    </section>

                </div>


                <?php
            } elseif (isset($_POST['done'])) {
                ?>
                <!-- DONE -->
                <div class="done-body" id="done-body">

                    <section class="done-section">
                        <div class="done-empty" id="done-empty" name="done-empty">
                        <?php if(mysqli_num_rows($task_query_done) > 0){ ?>
                                <div id="">
                                    <script>
                                        $(document).ready(function() {
                                            var d = new Date();

                                            var month = d.getMonth() + 1;
                                            var day = d.getDate();

                                            var output = d.getFullYear() + '-' +
                                                (('' + month).length < 2 ? '0' : '') + month + '-' +
                                                (('' + day).length < 2 ? '0' : '') + day;
                                            jQuery.ajax({
                                                url: "displayQueryDone.php",
                                                method: "POST",
                                                data: {
                                                    done: output,
                                                },
                                                success: function(data) {
                                                    $(".done-empty").fadeIn(1000).html(data);
                                                    $(".done-empty").css({
                                                        "display": " block",
                                                    });
                                                }
                                            })
                                        })
                                    </script>
                                </div> 
                            <?php } else { ?>

                            <div class="empty-container">
                                <img src="../taskism_images/Feeling Blue-bro.png" alt="">
                            </div>
                            <div class="text">
                                <p class="span">Oops! You haven't done any tasks yet.</p>
                                <p class="span-sub">Checked tasks will appear here.</p>
                            </div>
                            <?php }?>

                        </div>

                    </section>

                </div>

                <?php } ?>
            </form>

        </section>

        <?php

        } elseif (isset($_GET['filterbtn'])) {

        ?>

        <section class="filter-container">
            <h1>Filters & Labels</h1>

            <form action="" method="post">
                <div class="work-nav">
                    <button class="urgent" name="urgentbtn" id="urgent" style="color: #F24E1E;">urgent (<?php echo $rows_urgent;?>)</button>
                    <button class="high" name="highbtn" id="high" style="color: #E69B00;">high (<?php echo $rows_high;?>)</button>
                    <button class="normal" name="normalbtn" id="normal" style="color: #005B96;">normal (<?php echo $rows_normal;?>)</button>
                    <button class="low" name="lowbtn" id="low" style="color: #6C8054;">low (<?php echo $rows_low;?>)</button>
                </div>

                <?php if (isset($_POST['urgentbtn'])) { ?>
                <div class="urgent-body" id="urgent-body">

                    <section class="urgent-section">

                        <div class="urgent-empty" id="urgent-empty" name="urgent-empty">
                        <?php if(mysqli_num_rows($all_task_query) > 0){ ?>
                            <div id="">
                                <script>
                                    $(document).ready(function() {

                                        var d = new Date();

                                        var month = d.getMonth() + 1;
                                        var day = d.getDate();

                                        var output = d.getFullYear() + '-' +
                                            (('' + month).length < 2 ? '0' : '') + month + '-' +
                                            (('' + day).length < 2 ? '0' : '') + day;
                                        jQuery.ajax({
                                            url: "displayQueryUrgent.php",
                                            method: "POST",
                                            data: {
                                                urgent: output,
                                            },
                                            success: function(data) {

                                                $(".urgent-empty").fadeIn(1000).html(data);
                                                $(".urgent-empty").css({
                                                    "display": " block",
                                                });
                                            }
                                        })
                                    })
                                </script>
                            </div>
                        <?php } else { ?>
                            <div class="empty-container">
                                <img src="../taskism_images/urgent.png" alt="urgent">
                            </div>
                            <div class="text">
                                <p class="span">Yay! No urgent tasks!</p>
                                <p class="span-sub">Urgent tasks will appear here.</p>
                            </div>
                        <?php }?>

                        </div>

                    </section>

                </div>
                <?php } elseif (isset($_POST['highbtn'])) { ?>
                <div class="high-body" id="high-body">

                    <section class="high-section">

                        <div class="high-empty" id="high-empty" name="high-empty">
                        <?php if(mysqli_num_rows($all_task_query) > 0){ ?>
                            <div id="">
                                <script>
                                    $(document).ready(function() {

                                        var d = new Date();

                                        var month = d.getMonth() + 1;
                                        var day = d.getDate();

                                        var output = d.getFullYear() + '-' +
                                            (('' + month).length < 2 ? '0' : '') + month + '-' +
                                            (('' + day).length < 2 ? '0' : '') + day;
                                        jQuery.ajax({
                                            url: "displayQueryHigh.php",
                                            method: "POST",
                                            data: {
                                                high: output,
                                            },
                                            success: function(data) {

                                                $(".high-empty").fadeIn(1000).html(data);
                                                $(".high-empty").css({
                                                    "display": " block",
                                                });
                                            }
                                        })
                                    })
                                </script>
                            </div>
                        <?php } else { ?>
                            <div class="empty-container">
                                <img src="../taskism_images/Enthusiastic-bro.png" alt="">
                            </div>
                            <div class="text">
                                <p class="span">Yay! No high priority tasks!</p>
                                <p class="span-sub">High priority tasks will appear here.</p>
                            </div>
                        <?php }?>
                        </div>

                    </section>

                </div>

                <?php } elseif (isset($_POST['normalbtn'])) { ?>
                <div class="normal-body" id="normal-body">

                    <section class="normal-section">

                        <div class="normal-empty" id="normal-empty" name="normal-empty">
                        <?php if(mysqli_num_rows($all_task_query) > 0){ ?>
                            <div id="">
                                <script>
                                    $(document).ready(function() {

                                        var d = new Date();

                                        var month = d.getMonth() + 1;
                                        var day = d.getDate();

                                        var output = d.getFullYear() + '-' +
                                            (('' + month).length < 2 ? '0' : '') + month + '-' +
                                            (('' + day).length < 2 ? '0' : '') + day;
                                        jQuery.ajax({
                                            url: "displayQueryNormal.php",
                                            method: "POST",
                                            data: {
                                                normal: output,
                                            },
                                            success: function(data) {

                                                $(".normal-empty").fadeIn(1000).html(data);
                                                $(".normal-empty").css({
                                                    "display": " block",
                                                });
                                            }
                                        })
                                    })
                                </script>
                            </div>
                        <?php } else { ?>
                            <div class="empty-container">
                                <img src="../taskism_images/Freelancer-bro.png" alt="">
                            </div>
                            <div class="text">
                                <p class="span">Yay! No normal priority tasks!</p>
                                <p class="span-sub">Normal low tasks will appear here.</p>
                            </div>
                        <?php }?>
                        </div>

                    </section>

                </div>

                <?php } elseif (isset($_POST['lowbtn'])) { ?>

                <div class="low-body" id="low-body">

                    <section class="low-section">

                        <div class="low-empty" id="low-empty" name="low-empty">
                        <?php if(mysqli_num_rows($all_task_query) > 0){ ?>
                            <div id="">
                                <script>
                                    $(document).ready(function() {

                                        var d = new Date();

                                        var month = d.getMonth() + 1;
                                        var day = d.getDate();

                                        var output = d.getFullYear() + '-' +
                                            (('' + month).length < 2 ? '0' : '') + month + '-' +
                                            (('' + day).length < 2 ? '0' : '') + day;
                                        jQuery.ajax({
                                            url: "displayQueryLow.php",
                                            method: "POST",
                                            data: {
                                                low: output,
                                            },
                                            success: function(data) {

                                                $(".low-empty").fadeIn(1000).html(data);
                                                $(".low-empty").css({
                                                    "display": " block",
                                                });
                                            }
                                        })
                                    })
                                </script>
                            </div>
                        <?php } else { ?>
                            <div class="empty-container">
                                <img src="../taskism_images/Cheer up-rafiki.png" alt="">
                            </div>
                            <div class="text">
                                <p class="span">Yay! No low priority tasks!</p>
                                <p class="span-sub">Low priority tasks will appear here.</p>
                            </div>
                        <?php }?>
                        </div>

                    </section>

                </div>

                <?php } ?>



            </form>

        </section>

        <?php } ?>
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
                                    <input type="text" placeholder="title" name="title" id="title" maxlength="25" required>
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
    
    <section>
        <?php
            if(isset($_GET['id'])){
                $taskID = $_GET['id'];

                // echo "<script>alert($taskID)</script>";
                $tasks = "SELECT * FROM `tasks` where taskID = $taskID";   
                $viewed_task = mysqli_query($conn, $tasks) or die ("Cannot connect to table"); 

                $row = mysqli_fetch_assoc($viewed_task);
                
                $title = $row['title'];
                $date = $row['dueDate'];
                $status = $row['status'];
                $desc = $row['description'];
                
        ?>

            <div id="showTask" class="addtask_modal" style="display:block;">

            <!-- Modal content -->
                <div class="modal-content">

                    <div class="modal-header">
                        <h1>  </h1>
                        <span class="close" onclick="closeView(document.getElementById('showTask'))">&times;</span>
                    </div>
                        <h2>task</h2>

                    <div class="modal-body">
                        <div class="addtask-content">
                            <div class="inputs">
                                <label>Title</label>
                                <div class="field">
                                    <?= $title?>
                                </div>
                            </div>

                            <div class="date_status">
                                <div class="inputs date1">
                                    <label>Due Date</label>
                                    <div class="field" style="color: #6C8054">
                                        <?= date_format(date_create($date), "M d, Y")?>
                                    </div>
                                </div>
                                <div class="inputs status1">
                                    <label>Status</label>
                                    <div class="field">
                                        <div class="task_status" style="color: 
                                            <?php if (strcasecmp($status, "urgent") == 0) {
                                                echo "#F24E1E";
                                            } elseif (strcasecmp($status, "high") == 0) {
                                                echo "#E69B00";
                                            } elseif (strcasecmp($status, "normal") == 0) {
                                                echo "#005B96";
                                            } elseif (strcasecmp($status, "low") == 0) {
                                                echo "#6C8054";
                                            } ?>">
                                            <i class='bx bxs-f  lag-alt'></i> <?= ucfirst($status)?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label style="margin:20px">Description</label>

                            <div class="task_description inputs" >
                                <?=$desc?>
                            </div>
                            <div class="text_area task_input">
                                <a href="javascript:openupdate('donetask.php?id=<?php echo $taskID ?>')" class="mark">mark as done</a>
                            </div>
                            
                        </div>

                        
                    </div>

                </div>

            </div>

            <?php } ?>

    </section>

    <script>
        function openupdate(newurl) {
            if (confirm("Are you sure you want to mark task/s done?")) {
                document.location = newurl;
            }
        }
            
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

        function closeView(x){
            x.style.display = 'none';
            location.href = 'home.php';
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
        if(mysqli_num_rows($all_task_query) <= 0){?>
        
        <script>
            setInterval("alert('You have no tasks for today! <?php echo $_SESSION['username'] ?>, it is better to do something than to do nothing while waiting to do everything! Add task now :>');", 60*1000);
            setTimeout("alert('You have no tasks for today! <?php echo $_SESSION['username'] ?>, it is better to do something than to do nothing while waiting to do everything! Add task now :>');", 1000);

        </script>
        <?php

        }

    }else{
    session_unset();
    session_destroy();
    header("Refresh:.0;url=login.php"); } 
?>  