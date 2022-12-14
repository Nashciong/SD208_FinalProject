<?php   
ob_start();
session_start();
require_once('includes/connect.inc');


if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    if(empty($username) && empty($password)){
        echo "<script>alert('Please fill all fields!')</script>";
    }else{
        $user = "SELECT `username` FROM `register` WHERE username='$username' or email='$username'";
        $userpass = "SELECT `password` FROM `register` WHERE username='$username' or email='$username'";



        $profile = "SELECT `img_url` FROM `register` WHERE username='$username' or email='$username'";
        $profile_query = mysqli_query($conn,$profile) or die ("Cannot connect to table");

        $userID = "SELECT `userID` from `register` where username='$username' or email='$username'";
        $userid_query = mysqli_query($conn,$userID) or die ("Cannot connect to table");

        $result_query = mysqli_query($conn,$user) or die ("Cannot connect to table");
        $result_querypass = mysqli_query($conn,$userpass) or die ("Cannot connect to table");

        if(mysqli_num_rows($result_query) == 1){
            if(mysqli_num_rows($result_querypass) == 1) {
                $dbpassword = mysqli_fetch_row($result_querypass)[0];
            
                if($dbpassword == $password){

                    if(mysqli_num_rows($profile_query) == 1){

                        if (mysqli_num_rows($userid_query) == 1) {
                            $pp = mysqli_fetch_row($profile_query)[0];
                            $id = mysqli_fetch_row($userid_query)[0];
                        
                            $_SESSION['username'] = $username;
                            $_SESSION['timeout'] = time();
                            $_SESSION['logged_in'] = true;
                            $_SESSION['profile'] = $pp;
                            $_SESSION['userID'] = $id;

                            // through session, mastore ang information gamit ang variables sa lain na pages. 
                            // just like the id which is needed para masave and identify nato kinsa ang user na nag addtask.

                            header("Location: home.php");

                        }
            
                    }
                
                

                }else{
                    echo "<script>alert('Wrong password!')</script>";
                }
            }else{
                echo "<script>alert('Wrong password!')</script>";
            }
        }else{
            echo "<script>alert('Account does not exist!')</script>";
        }
    }
}else{
    $message = "";
}

?>




<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>login</title>
    <link rel="icon" type="image/x-icon" href="../taskism_images/logo.png">

</head>

<body>


    <section class="logo">

        <div class="logoimage">
            <p class="text">taskism</p>
            <p class="text2">makes your day more productive</p>
            <img src="../taskism_images/Digital tools-rafiki.png" alt="" class="reglogo">
        </div>

        <div class="quote">
            <p class="quote1">
            “Goals are good for setting a direction, but systems are best for making progress.”
            </p>
            <p class="quote2">
                - James Clear
            </p>
        </div>

    </section>

    <section class="login-form">

        <form action="login.php" method="post" class="login-form" name="loginform">
            <div class="container">
                <p class="here">login here</p>

                <div class="inputs">
                    <input type="text" placeholder="enter username or email" name="username" id="username" required>
                </div>
                <div class="inputs">
                    <input type="password" placeholder="enter password" name="password" id="password" required>
                </div>

                <div class="submitLogin">
                    <input type="submit" name="submit" class="loginbtn" value="login">
                </div>

                <div class="signup">
                    <p>don't have an account? <a style="text-decoration:none" href="../taskism_codes/register.php"><span id="rghere">register here.
                            </span></a></p>
                    <p class="or">or register with</p>
                </div>
                <div style="display:flex">
                    <div class="icons">
                        <a href="#" class="icon1"> <i class='bx bxl-facebook bx-sm'></i></a>
                        <a href="#" class="icon2"> <i class='bx bxl-google bx-sm'></i></a>
                        <a href="#" class="icon3"> <i class='bx bxl-instagram bx-sm'></i></a>
                    </div>
                </div>
            </div>
        </form>

    </section>
    <section class="footer">
        <p>privacy policy | terms & condition  © <span class="bold"> 2022 | taskism </span></p>
    </section>


</body>

</html>