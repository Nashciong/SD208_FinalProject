<?php
ob_start();
session_start();
require_once 'config.php';

?>

<?php
define('CSS_PATH', 'template/css/');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="register.css" />
    <link href='https://fonts.googleapis.com/css?family=Fredoka One' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>register.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Register</title>
</head>

<body>

 <?php
if (isset($_POST['create'])) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = ($_POST['password']);
    $confirmpassword = ($_POST['confirmpassword']);
    

    $sql = "INSERT INTO register (firstname, lastname, birthday, phone, email, password, confirmpassword) VALUES(?,?,?,?,?,?,?)";
    $stmtinsert = $db->prepare($sql);

    if ($password == $confirmpassword) {
        $result = $stmtinsert->execute([$firstname, $lastname, $email, $phone, $email, $password, $confirmpassword]);
        
    } else {
        echo ' password did not match';
    }

    // if ($result) {

    //     echo 'succesfully added.';
    // } else {
    //     echo 'unable to add';
    // }

}?>




    <div class="all">
        <div class="logoimage">
            <p class="text">taskism</p>
            <p class="text2">makes your day more productive</p>
            <img src="/taskism_images/Digital tools-pana.png" alt="" class="reglogo">
        </div>


        <div>
            <p class="qoute1">
                “Productivity is being able to do things that <br> you were never able to do before.”
            </p>
            <p class="qoute2">
                - Franz Kafka
            </p>
        </div>

        <div class="register-form">


            <form action="register.php" method="post">
                <div class="container">
                    <p class="here">register here</p>

                    <input type="text" placeholder="enter first name" name="firstname" id="firstname" required>
                    <input type="text" placeholder="enter last name" name="lastname" id="lastname" required>
                    <input type="text" placeholder="date of birth" name="birthday" id="bday" required>
                    <input type="text" placeholder="Enter Email" name="email" id="email" required>
                    <input type="text" placeholder="phone number (optional)" name="phone" id="phone" required>
                    <input type="password" placeholder="password" name="password" id="password" required>
                    <input type="password" placeholder="confirm password" name="confirmpassword" id="confirmpassword"
                        required>
                    <p class="Poptional">profile photo (optional)</p>
                    <div class="choose">
                        <input type="file" id="myFile" name="filename">
                    </div>

                    <!-- onclick should be removed -->
                
                    <input type="submit"name="create" onclick="openPopup()" class="registerbtn" value="register">
                </div>
                

                <div class="container signin">
                    <p>already have an account? <a style="text-decoration:none" href="#"><span id="lgnhere">Log in here
                            </span></a>. </p>
                    <p class="or">or login with</p> <br> <br><br>

                </div>



            </form>

            <div class="icons">
                <a href="#" class="icon1"> <i class='bx bxl-facebook bx-sm'></i></a>
                <a href="#" class="icon2"> <i class='bx bxl-google bx-sm'></i></a>
                <a href="#" class="icon3"> <i class='bx bxl-instagram bx-sm'></i></a>
            </div>


        </div>


    </div>

    <div class="footer">
        <p>privacy policy | terms & condition  © <span class="bold"> 2022 | taskism </span></p>
        <p></p>
    </div>
<!-- this should be removed -->
<div class="popup" id="popup">
<h3>You are now registered! </h3>
<button type="submit" onclick="closePopup()" class="done"> back to login</button>
</div>


<!-- script should be removed -->
    <script>
    let popup = document.getElementById("popup");

    function openPopup(){
    
        popup.classList.add("open-popup");
        
    }

    
    function closePopup(){
        popup.classList.remove("open-popup");
    }

   

    
    
   </script>  
</body>

</html>