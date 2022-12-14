<?php

ob_start();
session_start();
require_once('includes/connect.inc');

session_unset();
session_destroy();

echo "<script>alert('Logging out!')</script>";

header("Refresh: .3; url=login.php");

?>