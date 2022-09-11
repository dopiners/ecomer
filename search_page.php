<?php

include 'co.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:lo.php');
};
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
  
};




?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user.css">

</head>
<body>
   
<?php include 'header.php'; ?>
<div class="heading">
    <h3>search page</h3>
   <p><a href="home.php">home /</a> search</p> 
</div>
<section class="search-form">
    <form action="" method="post">
        <input type="text" class="box" placeholder="search product" name="search">
        <input type="submit" name="submit" value="search" class="btn">
    </form>
</section>
<section class="products">
    <div class="box-container">
       <?php
       if(isset($_POST['submit'])){
$search=$_POST['search'];
$select_search = mysqli_query($conn, "SELECT * FROM `product` WHERE name LIKE '%{$search}%'") or die('query failed');
if(mysqli_num_rows($select_search) > 0){
    while($fetch_search=mysqli_fetch_assoc($select_search)){
        ?>
  
  
   
<form action="" method="POST" class="box">
<img src="uploaded_img/<?php echo $fetch_search['image']; ?>" alt="" class="image">
<div class="name"><?php echo $fetch_search['name']; ?></div>
<div class="price"><?php echo $fetch_search['price']; ?></div>
<input type="number"  class="qty" name="product_quantity" min="1" value="1">

<input type="hidden" name="product_name" value="<?php echo $fetch_search['name']; ?>">
<input type="hidden" name="product_price" value="<?php echo $fetch_search['price']; ?>">
<input type="hidden" name="product_image" value="<?php echo $fetch_search['image']; ?>">
<input type="submit" value="add product to cart" class="btn" name="add_to_cart">
</form>
<?php
            }
         }
        }
   ?>
    </div>
</section>
<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>