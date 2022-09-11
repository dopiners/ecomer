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
<section class="home">
    <div class="container1">
        <div class="about">
            <h2>Lorem ipsum dolor sit amet.</h2>
   
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, quisquam.</p>
     
            <a href="about.php" class="white-btn">discovery more</a>
          
        </div>
    </div>
</section>
<section class="products">
    <h1 class="title">LAST PRODUCTS</h1>
    <div class="box-container">
    
    <?php
        $select_product=mysqli_query($conn,"SELECT * FROM `product`")or die('query faild');
        if(mysqli_num_rows($select_product)>0){
            while($fetch_product=mysqli_fetch_assoc($select_product)){
                ?>
               
               <form action="" method="post" class="box">  
                <img class="image" src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
                <div class="name"><?php echo $fetch_product['name']; ?></div>
                <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
                <input type="number" value="1" min="1" class="qty" name="product_quantity">
                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                <input type="submit" class="btn" name="add_to_cart" value="add to cart">
                </form>
           
      <?php  
      }
        }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>
    </div>
</section>
<section class="aboutt">
    <div class="flex">
        <div class="imagee">
            <img src="images/about-img.jpg" alt="">
        </div>
        <div class="contant">
<h3>about us</h3>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat ut deleniti sunt quod nesciunt obcaecati veritatis debitis rem quae exercitationem?</p>
<a href="about.php" class="btn">read more</a>



        </div>
    </div>
        </section>
<section class="contact_us">
    <div class="good">
        <h3>have any qustions</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum eveniet quidem dolorem, eos non quae!</p>
        <a href="contact.php" class="white-btn">contact us</a>
    </div>
</section>
    <?php include "footer.php"; ?>
    <script src="js/script.js"></script>
</body>
</html>