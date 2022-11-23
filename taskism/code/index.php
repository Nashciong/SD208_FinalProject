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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SCRIPT -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.0/js.cookie.js"></script> -->

    <style>
        <?php include "style.css" ?>
    </style>



</head>

<body onload="checkCookie()">

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
                <button name="filterbtn" class="sidebtn" onclick="location.href='/taskism/code/filters.php'"><i
                        class='bx bx-grid-alt'></i> filters & labels</button>
            </div>

            <div class="profile">
                <div class="profile-container">
                    <img src="http://localhost/taskism/images/gudetama.png" alt="">
                </div>

                <div class="profile-link">
                    <a><button class="help-link" onclick="" id="helpBtn"><i class='bx bx-help-circle'></i> help</button></a>
                    <button class="logout-link" onclick="" name="logout"><i class='bx bx-exit'></i> logout</button>
                    <?php 
                    // if(isset($_GET['logout'])){
                        //     unset($_COOKIE['user']); 
                        // setCookie("user", "", time()-((365)* 24 * 60 * 60 * 1000)); 
                    //  }?>
                </div>
            </div>

        </form>

    </section>

    <section class="help-modal">
        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h2>welcome, name!</h2>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <h3>user manual</h3>
                    <br />
                    <p>our website is incredibly simple to access and utilize.
                        here are the following things you can do inside our website:</p>
                    

                    <div class="manual-content">
                        <form method="post">
                            <div class="addtask">
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
                                <button class="getStarted">get started!</button>
                            </div>


                        </form>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- HOME BODY -->
    <section class="body-container">

        <?php if (isset($_GET['homebtn']) || !isset($_GET['filterbtn'])) { ?>
        <section class="home-container">
            <h1>My Work</h1>

            <form action="" method="post" class="mywork" id="mywork">
                <div class="work-nav">
                    <button class="todo" name="todo" id="todo">to do</button>
                    <button class="done" name="done" id="done">done</button>
                </div>


                <?php if (!isset($_POST['done']) || isset($_POST['todo'])) { ?>
                <!-- TODO -->
                <div class="todo-body" id="todo-body">

                    <!-- TODAY -->
                    <section class="now">

                        <h1 class="now-head"><i onclick="changeIcon(this, document.getElementById('now-empty'))"
                                class='bx bxs-down-arrow'></i>today</h1>

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

                        <h1 class="overdue-head"><i onclick="changeIcon(this, document.getElementById('overdue-empty'))"
                                class='bx bxs-down-arrow'></i>overdue</h1>

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

                        <h1 class="upcoming-head"><i
                                onclick="changeIcon(this, document.getElementById('upcoming-empty'))"
                                class='bx bxs-down-arrow'></i>upcoming</h1>

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
            } elseif (isset($_POST['done'])) {
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

        <?php

        } elseif (isset($_GET['filterbtn'])) {

        ?>

        <section class="filter-container">
            <h1>Filters & Labels</h1>

            <form action="" method="post">
                <div class="work-nav">
                    <button class="urgent" name="urgentbtn" id="urgent" style="color: #F24E1E;">urgent</button>
                    <button class="high" name="highbtn" id="high" style="color: #E69B00;">high</button>
                    <button class="normal" name="normalbtn" id="normal" style="color: #005B96;">normal</button>
                    <button class="low" name="lowbtn" id="low" style="color: #6C8054;">low</button>
                </div>

                <?php if (isset($_POST['urgentbtn'])) { ?>
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
                <?php } elseif (isset($_POST['highbtn'])) { ?>
                <div class="high-body" id="high-body">

                    <section class="high-section">

                        <div class="high-empty" id="high-empty" name="high-empty">
                            <div class="empty-container">
                                <img src="http://localhost/taskism/images/Enthusiastic-bro.png" alt="">
                            </div>
                            <div class="text">
                                <p class="span">Yay! No high priority tasks!</p>
                                <p class="span-sub">High priority tasks will appear here.</p>
                            </div>
                        </div>

                    </section>

                </div>

                <?php } elseif (isset($_POST['normalbtn'])) { ?>
                <div class="normal-body" id="normal-body">

                    <section class="normal-section">

                        <div class="normal-empty" id="normal-empty" name="normal-empty">
                            <div class="empty-container">
                                <img src="http://localhost/taskism/images/Freelancer-bro.png" alt="">
                            </div>
                            <div class="text">
                                <p class="span">Yay! No normal priority tasks!</p>
                                <p class="span-sub">Normal low tasks will appear here.</p>
                            </div>
                        </div>

                    </section>

                </div>

                <?php } elseif (isset($_POST['lowbtn'])) { ?>

                <div class="low-body" id="low-body">

                    <section class="low-section">

                        <div class="low-empty" id="low-empty" name="low-empty">
                            <div class="empty-container">
                                <img src="http://localhost/taskism/images/Cheer up-rafiki.png" alt="">
                            </div>
                            <div class="text">
                                <p class="span">Yay! No low priority tasks!</p>
                                <p class="span-sub">Low priority tasks will appear here.</p>
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

                        if (isset($m)) {
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

        function changeIcon(x, y) {
            x.classList.toggle("bxs-right-arrow");

            // now.classList.toggle("hidediv");

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

        var myTimeout = setTimeout(showModal, 1000);

        function showModal(){
            modal.style.display = "block";
        }

        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            let name = cname + "=";
            let ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function checkCookie() {
            let user = getCookie("user");
            if (user != "") {
                clearTimeout(myTimeout);
            } else {
                setCookie("user", 1, 365);
                showModal();
            }
        }


        btn.onclick = function () {
            modal.style.display = "block";
        }

        span.onclick = function () {
            modal.style.display = "none";
        }
        start.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }


    </script>
</body>

</html>