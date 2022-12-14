<?php
ob_start();
session_start();
require_once 'config.php';
require_once('includes/connect.inc');   

$date = date("Y-m-d");

?>




<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="register.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>register</title>
    <link rel="icon" type="image/x-icon" href="../taskism_images/logo.png">

</head>

<body>


<?php
if (isset($_POST['create']) && isset($_FILES['profile'])) {

    $username = $_POST['username'];
    $firstname = ucfirst($_POST['firstname']);
    $lastname = ucfirst($_POST['lastname']);
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    $exists = "SELECT `username` FROM `register` WHERE username='$username' or email='$email'";
    $result_query = mysqli_query($conn,$exists) or die ("Cannot connect to table");

    $sql = "INSERT INTO register (username,firstname, lastname, birthday, phone, email, password, userManual) VALUES(?,?,?,?,?,?,?,?)";
    $stmtinsert = $db->prepare($sql);

    $img_name = $_FILES['profile']['name'];
    $img_size = $_FILES['profile']['size'];
    $tmp_name = $_FILES['profile']['tmp_name'];
    $error = $_FILES['profile']['error'];

    if(mysqli_num_rows($result_query) == 1){
        echo "<script>alert('Username or email already exists!')</script>";
    } else {

        if ($error === 0) {
            
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array('jpg', 'jpeg', 'png');

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid($username, true) . '.' . $img_ex_lc;
                $img_upload_path = 'uploads/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // INSERTING TO DATABASE    
                $sql = "INSERT INTO register (username,firstname, lastname, birthday, phone, email, password, userManual,img_url) VALUES(?,?,?,?,?,?,?,?,?)";
                $stmtinsert = $db->prepare($sql);
                $result = $stmtinsert->execute([$username, $firstname, $lastname, $birthday, $phone, $email, md5($password), 0, $new_img_name]);

                echo "<script>alert('You have been registered!')</script>";
                header("refresh: .1; url=login.php");

            } else {
                echo "<script>alert('You can't upload file of this type!')</script>";
            }

        } else {
            $result = $stmtinsert->execute([$username, $firstname, $lastname, $birthday, $phone, $email, md5($password), 0]);
            echo "<script>alert('You have been registered!')</script>";
            header("refresh: .1; url=login.php");
        }
    }
}?>

    <section class="logo">

        <div class="logoimage">
            <p class="text">taskism</p>
            <p class="text2">makes your day more productive</p>
            <img src="../taskism_images/Digital tools-pana.png" alt="" class="reglogo">
        </div>

        <div class="quote">
            <p class="quote1">
                “Productivity is being able to do things that you were never able to do before.”
            </p>
            <p class="quote2">
                - Franz Kafka
            </p>
        </div>

    </section>

    <section class="register-form">

        <form action="register.php" name="Form" onsubmit="return openPopup()" method="post" enctype="multipart/form-data">
            <div class="container">
                <p class="here">register here</p>

                <div class="inputs">
                    <input type="text" placeholder="enter username" name="username" id="username" >
                </div>

                <div class="inputs">
                    <input type="text" placeholder="enter first name" name="firstname" id="firstname" >
                </div>
                <div class="inputs">
                    <input type="text" placeholder="enter last name" name="lastname" id="lastname" >
                </div>
                <div class="inputs">
                    <input type="date" id="bday" name="birthday" min="1900-01-01" max="<?php echo $date;?>" required="required">
                </div>
                <div class="inputs">
                    <input type="email" placeholder="enter email" name="email" id="email" >
                </div>
                <div class="inputs">
                    <input type="number" placeholder="phone number (optional)" name="phone" id="phone" >
                </div>
                <div class="inputs">
                    <input type="password" placeholder="password" name="password" id="password" >
                </div>
                <div class="inputs">
                    <input type="password" placeholder="confirm password" name="confirmpassword" id="confirmpassword">
                </div>
                
                <p class="Poptional">profile photo (optional)</p>
                
                <div class="inputs">
                    <input type="file" id="myFile" name="profile">
                </div>
                
                <div class="submitRegister">
                    <input type="submit"name="create" class="registerbtn" value="register">
                </div>

                <div class="signin">
                    <p>already have an account? <a style="text-decoration:none" href="../taskism_codes/login.php"><span id="lgnhere">log in here.
                            </span></a></p>
                    <p class="or">or login with</p>
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
    <section class="footer" style="margin-top: 55%;">
        <p>privacy policy | terms & condition  © <span class="bold"> 2022 | taskism </span></p>
    </section>



    <!-- this should be removed -->
<div class="popup" id="popup">
    <h3>All fields are required!</h3>
<button type="submit" onclick="closePopup1()" class="done"> OK</button>
</div>

<div class="valid" id="valid">
    <h2 class="match">Password did not match!</h2>
    <button type="submit" onclick="closePopup2()" class="done"> OK</button>
</div>

<!-- <div class="registered" id="registered">
    <h2 class="match">You are now registered!</h2>
    <button type="submit" onclick="closePopup3()" class="done"> OK</button>
</div> -->

<div class="must" id="must">
    <h2 class="match">Password must contain 8 characters!</h2>
    <button type="submit" onclick="closePopup4()" class="done"> OK</button>
</div>

<!-- script should be removed -->
    <script  type="text/javascript">
    let popup = document.getElementById("popup");
    let val = document.getElementById("valid");
    let reg = document.getElementById("registered");
    let mu = document.getElementById("must");

    
  function openPopup() {
    var g = document.forms["Form"]["username"].value;
    var a = document.forms["Form"]["firstname"].value;
    var b = document.forms["Form"]["lastname"].value;
    var c = document.forms["Form"]["birthday"].value;
    var d = document.forms["Form"]["email"].value;
    var d = document.forms["Form"]["phone"].value;
    var e = document.forms["Form"]["password"].value;
    var f = document.forms["Form"]["confirmpassword"].value;
    if (g == null || g == "", a == null || a == "", b == null || b == "", c == null || c == "", d == null || d == "", e == null || e == "" , f == null || f == "") {
        popup.classList.add("open-popup");
        return false;
    } else if (e !== f){
        val.classList.add("open-popupvalid");
        return false;
    }
    else{
        return true;
    }
  }
    
    function closePopup1(){
        popup.classList.remove("open-popup");
    }
    function closePopup2(){
        val.classList.remove("open-popupvalid");
    }
    // function closePopup3(){
    //     reg.classList.remove("open-popupregistered");

    // }
    function closePopup4(){
        reg.classList.remove("open-popupmust");
    }
   </script>  

</body>

</html>