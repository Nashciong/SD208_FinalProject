<?php
$conn = mysqli_connect("localhost","root","") or die ("Cannot connect to mysql server");
mysqli_select_db($conn, "taskism"  ) or die ("Cannot connect to database");
