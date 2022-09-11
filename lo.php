<?php

include 'co.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['pass']));

$sql = mysqli_query($conn, "SELECT * FROM `ecomer` WHERE email = '$email' AND password = '$pass'") ;

   if(mysqli_num_rows($sql) > 0){

      $row = mysqli_fetch_assoc($sql);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header("location:admin_page.php");

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header("location:home.php");

      }

   }else{
  echo    " <script>alert('incorrect email or password!')</script>";
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
    <form action="lo.php" method="post">
       
        <div class="container">
            <div class="inputs">
                <h1>sign up now</h1>
        <input type="email" name="email" id="email" placeholder="enter your email" required>
        <input type="password" name="pass" id="pass" placeholder="enter your password" required>
        <br>
        <input type="submit" id="submit" name="submit">
        <p>you dont have account<a href="si.php">signup now</a></p>
        </div>
        </div>
     
    </form>
</body>
</html>