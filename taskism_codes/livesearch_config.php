<?php
$con=mysqli_connect("localhost","root","","live-search");

if(!$con){
    echo "Connection Failed!" . mysqli_connect_error();
}
?>