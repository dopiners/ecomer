<?php
include "co.php";

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $pass = mysqli_real_escape_string($conn,md5($_POST['pass']));
    $cpass = mysqli_real_escape_string($conn,md5($_POST['cpass']));
$user_type =$_POST['user_type'];
    $sql= mysqli_query($conn,"SELECT * FROM `ecomer` WHERE email = '$email'AND password = '$pass'");
    if(mysqli_num_rows($sql) > 0){
        echo " <script>alert('you alredy have account')</script>";
    }elseif($pass != $cpass){
        echo    " <script>alert('password not match')</script>";
    }else{
        mysqli_query($conn, "INSERT INTO `ecomer`(name,email,password,user_type) VALUES('$name','$email','$pass','$user_type')" );
        echo    " <script>alert('register sussess')</script>";
        header("location:lo.php");
    }
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign up</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<img src="" alt="">
    <form action="si.php" method="post">
       
        <div class="container">
            <div class="inputs">
                <h1>sign up now</h1>
        <input type="name" name="name" id="name" placeholder="enter your name" required>
        <input type="email" name="email" id="email" placeholder="enter your email" required>
        <input type="password" name="pass" id="pass" placeholder="enter your password" required>
        <input type="password" name="cpass" id="cpass" placeholder="confirm your password" required>
        <br>
        <input type="submit" id="submit" name="submit">
      
        <p>alredy have account <a href="lo.php">login now</a></p>
        </div>
        </div>
     
    </form>
</body>
</html>
