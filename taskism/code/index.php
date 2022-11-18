<?php
error_reporting(~E_NOTICE);

function build_calendar($month, $year)
{

    // Create array containing abbreviations of days of week.
    $daysOfWeek = array('Sn', 'M', 'T', 'W', 'Th', 'F', 'S');

    // What is the first day of the month in question?
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

    // How many days does this month contain?
    $numberDays = date('t', $firstDayOfMonth);

    // Retrieve some information about the first day of the
    // month in question.
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

    // Create the calendar headers

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


?> 



<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LOGO -->
    <title>taskism</title>
    <link rel="icon" type="image/x-icon" href="http://localhost/taskism/images/logo.png">

    <!-- CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        <?php include "style.css" ?>
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

        <form action="" method="post">

            <div class="nav-link" id="nav-link">
                <button name="homebtn" class="sidebtn"><i class='bx bx-home-alt'></i> home</button>
                <button name="filterbtn" class="sidebtn"><i class='bx bx-grid-alt'></i> filters & labels</button>
            </div>

            <div class="profile">
                <div class="profile-container">
                    <img src="http://localhost/taskism/images/gudetama.png" alt="">
                </div>

                <div class="profile-link">
                    <a><button class="help-link"><i class='bx bx-help-circle'></i> help</button></a>
                    <a href="#"><button class="logout-link"><i class='bx bx-exit'></i>  logout</button></a>
                </div>
            </div>

        </form>

    </section>

    <!-- HOME BODY -->
    <section class="body-container">
        
        <?php if(isset($_POST['homebtn']) || !isset($_POST['filterbtn'])){ ?>
        <section class="home-container">
            <h1>My Work</h1>

            <form action="" method="post" class="mywork" id="mywork">
                <div class="work-nav">
                    <button class="todo" name="todo" id="todo">to do</button>
                    <button class="done" name="done" id="done">done</button>
                </div>
            

            <?php if(!isset($_POST['done']) || isset($_POST['todo'])){ ?>
            <!-- TODO -->
            <div class="todo-body" id="todo-body">
                
                <!-- TODAY -->
                <section class="now">
                
                    <h1 class="now-head"><i onclick="changeIcon(this, document.getElementById('now-empty'))" class='bx bxs-down-arrow'></i>today</h1>

                    <div class="now-empty" id="now-empty" name="now">
                        <div class="empty-container">
                            <img src="http://localhost/taskism/images/Enthusiastic-pana.png" alt="">
                        </div>
                            <div class="text">
                                <p class="span">Yay! No tasks for today!</p>
                                <p class="span-sub">Tasks scheduled today will appear here.</p>
                            </div>

                    </div>

                </section>

                            <!-- OVERDUE -->
 
                <section class="overdue">
 
                    <h1 class="overdue-head"><i onclick="changeIcon(this, document.getElementById('overdue-empty'))" class='bx bxs-down-arrow'></i>overdue</h1>

                    <div class="overdue-empty" id="overdue-empty" name="overdue">
                        <div class="empty-container">
                            <img src="http://localhost/taskism/images/Honesty-amico.png" alt="">
                        </div>
                            <div class="text">
                                <p class="span">Yay! No overdue tasks!</p>
                                <p class="span-sub">Overdue tasks will appear here.</p>
                            </div>

                    </div>

                </section>

                <!-- UPCOMING -->
                <section class="upcoming">
 
                    <h1 class="upcoming-head"><i onclick="changeIcon(this, document.getElementById('upcoming-empty'))" class='bx bxs-down-arrow'></i>upcoming</h1>

                    <div class="upcoming-empty" id="upcoming-empty" name="upcoming">
                        <div class="empty-container">
                            <img src="http://localhost/taskism/images/Product quality-rafiki.png" alt="">
                        </div>
                            <div class="text">
                                <p class="span">Yay! No upcoming taks!</p>
                                <p class="span-sub">Upcoming tasks will appear here.</p>
                            </div>

                    </div>

                </section>

            </div>


            <?php 
            } elseif(isset($_POST['done'])){
             ?>
            <!-- DONE -->
            <div class="done-body" id="done-body">

            <section class="done-section">
 
                <div class="done-empty" id="done-empty" name="done-empty">
                    <div class="empty-container">
                        <img src="http://localhost/taskism/images/Feeling Blue-bro.png" alt="">
                    </div>
                    <div class="text">
                        <p class="span">Oops! You haven't done any tasks yet.</p>
                        <p class="span-sub">Checked tasks will appear here.</p>
                    </div>

                </div>

            </section>

            </div>

            <?php } ?>
            </form>

        </section>

        <?php } elseif(isset($_POST['filterbtn'])){ ?>
        <section class="filter-container">
            <h1>Filters & Labels</h1>

            <form action="" method="post" class="filter-labels" id="filter-labels">

                <div class="work-nav">
                    <button class="urgent" name="urgentbtn" id="urgent" style="color: #F24E1E;">urgent</button>
                    <button class="high" name="highbtn" id="high" style="color: #E69B00;">high</button>
                    <button class="normal" name="normalbtn" id="normal" style="color: #005B96;">normal</button>
                    <button class="low" name="lowbtn" id="low" style="color: #6C8054;">low</button>
                </div>


                <?php if(isset($_POST['urgentbtn']) ||
                    !isset($_POST['highbtn']) || 
                    !isset($_POST['normalbtn']) || !isset($_POST['lowbtn'])){ ?>

                <!-- URGENT -->
                <div class="urgent-body" id="urgent-body">
 
                    <section class="urgent-section">
    
                        <div class="urgent-empty" id="urgent-empty" name="urgent-empty">
                            <div class="empty-container">
                                <img src="http://localhost/taskism/images/urgent.png" alt="urgent">
                            </div>
                            <div class="text">
                                <p class="span">Yay! No urgent tasks!</p>
                                <p class="span-sub">Urgent tasks will appear here.</p>
                            </div>
                        </div>
    
                    </section>
 
                </div>

                <?php } elseif(isset($_POST['high'])){ ?>

                <!-- HIGH -->
                <div class="high-body" id="high-body">

                    <section class="high-section">

                        <div class="high-empty" id="high-empty" name="high-empty">
                            <div class="empty-container">
                                <img src="http://localhost/taskism/images/Enthusiastic-bro.png" alt="high">
                            </div>
                            <div class="text">
                                <p class="span">Yay! No high priority tasks!</p>
                                <p class="span-sub">High priority tasks will appear here.</p>
                            </div>
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
        parse_str($_SERVER['QUERY_STRING']);

        if ($m == "") {

            $dateComponents = getdate();
            $month = $dateComponents['mon'];
            $year = $dateComponents['year'];
        } else {

            $month = $m;
            $year = $y;

        }
        


    ?>
        <div class="fixed-calendar">
            <h1>Calendar</h1>

            <div class="container">

                <div class="calendarHead">
                    <?php

                    parse_str($_SERVER['QUERY_STRING']);

                    if(isset($m)){
                        if ($m == "") {

                            $dateComponents = getdate();
                            $month = $dateComponents['mon'];
                            $year = $dateComponents['year'];
                        } else {

                            $month = $m;
                            $year = $y;

                        }
                        
                    }
                    echo build_calendar($month, $year);

                    ?>
                </div>
            </div>

        </div>
        
    </section>

    <section class="addTask">
        <div>
            <i class='bx bx-plus'></i>
        </div>
    </section>
    <script>

        var now = document.getElementById("now-empty");
        var overdue = document.getElementById("overdue-empty");
        var upcoming = document.getElementById("upcoming-empty");

        function changeIcon(x, y){
            x.classList.toggle("bxs-right-arrow");
            
            // now.classList.toggle("hidediv");

            if(y.style.display === "none"){
                y.style.display = "block";
            }
            else {
                y.style.display = "none";
            }
        }

        var header = document.getElementsById('nav-link');
        var btns = header.getElementsByClassName('sidebtn');

        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
        });
        }


    </script>
</body>
</html>