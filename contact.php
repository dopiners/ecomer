<?php

include 'co.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:lo.php');
}
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = $_POST['number'];
    $msg = mysqli_real_escape_string($conn, $_POST['msg']);
    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

    if(mysqli_num_rows($select_message) > 0){
       $message[] = 'message sent already!';
    }else{
       mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
       $message[] = 'message sent successfully!';
    }
 
 }
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>home</title>
    
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- custom admin css file link  -->
<link rel="stylesheet" href="css/user.css">

</head>
<body>
    <?php include "header.php"; ?>
<section class="hi">
    <h3 class="title">contact us</h3>
    <div class="box-container">
        <form action="" method="post">
<input type="text" name="name" required placeholder="enter your name">
<input type="email" name="email" required placeholder="enter your email">
<input type="number" name="number" required placeholder="enter your number">
<input type="text" name="msg"  class="msg" required placeholder="enter your message">
<input type="submit" value="submit" name="submit" class="white-btn">
  </form>  
</div>

</section>
    <?php include "footer.php"; ?>
    <script src="js/script.js"></script>
</body>
</html>