<?php

include 'co.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:lo.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart1` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart1`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
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

<section class="aboutt">
    <div class="flex">
        <div class="imagee">
            <img src="images/about-img.jpg" alt="">
        </div>
        <div class="contant">
<h3>about us</h3>
<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Delectus nobis ex hic ratione quod doloribus praesentium quasi reiciendis quas? Doloremque inventore pariatur impedit totam, consequuntur iure id rem dolore voluptates?</p>
<a href="contact.php" class="btn">contact us</a>



        </div>
    </div>
        </section>

    <?php include "footer.php"; ?>
    <script src="js/script.js"></script>
</body>
</html>