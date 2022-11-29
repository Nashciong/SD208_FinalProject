<?php
ob_start();
session_start();
require_once('includes/connect.inc');

$image='Digital tools-pana (1).png';
    include('config.php');

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = "select password from register where email='$username'";
        $result_query = mysqli_query($conn,$user) or die ("Cannot connect to table");
        if(mysqli_num_rows($result_query) == 1) {
            $dbpassword = mysqli_fetch_row($result_query);
            print_r ($dbpassword);
            
        }
    
        }    else{
$message = "";

          }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href='https://fonts.googleapis.com/css?family=Fredoka One' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        * {

            background: #EBC6A9;
            font-family: 'Fredoka One';
            font-size: 22px;
        }

        input[type=username] {
            position: absolute;
            width: 365px;
            height: 50px;
            left: 38px;
            top: 100px;
            background: #D0F3A5;
            border: 1px solid #6C8054;
            border-radius: 20px;
        }

        input[type=password] {
            position: absolute;
            width: 365px;
            height: 50px;
            left: 38px;
            top: 180px;
            background: #D0F3A5;
            border: 1px solid #6C8054;
            border-radius: 20px;

        }

        button {
            position: absolute;
            width: 147px;
            height: 48.78px;
            left: 165px;
            top: 270px;
            background: #6C8054;
            color: white;
            border-radius: 20px;
        }

        button:hover {
            color:#EBC6A9;;
           
        }

        img {
            position: absolute;
            width: 500px;
            height: 450px;
            left: 140px;
            top: 170px;

        }

        .container {
            padding: 100px;
            margin-left: 23px;
            display: flex;
            flex: wrap;
            float: left;

        }

        h1 {
            padding-left: 230px;
            margin-top: 100px;
            font-size: 70px;
        }
        h2{
            padding-left: 3px;
            margin-top: 50px;
            font-size: 25px;
        }

        .login {
            box-sizing: border-box;
            position: absolute;
            width: 450px;
            height: 480px;
            left: 690px;
            top: 95px;
            background: #DC9C74;
            border: 1px solid #6C8054;
            border-radius: 25px;

        }

        .login h2 {
            letter-spacing: 0.1em;
            color: #6C8054;
            background: #DC9C74;


        }

        span.psw {
            font-size: medium;
            position: absolute;
            height: 54px;
            left: 75px;
            top: 353px;
           background: #DC9C74; 

        }
        a {
            background: #DC9C74;
             font-size: large;
        }

        .reg {
            font-size: medium;
            position: absolute;
            height: 54px;
            left: 172px;
            top: 385px;
            background: #DC9C74;
        }

        .social {
            position: absolute;
            height: 54px;
            left: 190px;
            top: 420px;
            background: #DC9C74;

        }
    </style>
</head>

<body>

    <?php echo $message ?>
        <form action="login.php" method="post" name= "login"></form>
    <h1>TASKISM</h1>
    <form class="container">
        <img src="<?php echo $image;?>">
        <form class="container1">
            <div style="padding-left:20px;" class="login">
                <center>
                    <h2> Log in here</h2>
                </center>
                <input type="username" placeholder="Enter Username" name="username" id="username" required>
                <input type="password" placeholder="Enter Password" name="password" id="password" required>
                <button type="submit">Login</button>
                <span class="psw">Don't have an account? <a href="register.php">register here</a></span>
                <span class="reg">or register with</span>
                <div class="social">
                    <i class="bi bi-facebook"><a href="https://www.facebook.com/"></a></i>
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-google"></i>
                </div>
            </div>
        </form>
    </form>
</body>

</html>