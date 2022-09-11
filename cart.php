
<?php

include 'co.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:lo.php');
}
if(isset($_GET['delete'])){
    $delete_id=$_GET['delete'];
    mysqli_query($conn,"DELETE FROM `cart1` WHERE id='$delete_id'")or die('query faild');
    header('location:cart.php');
}
if(isset($_POST['update_cart'])){
$cart_id=$_POST['cart_id'];
$cart_quantity=$_POST['cart_quantity'];
mysqli_query($conn, "UPDATE `cart1` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    header('location:cart.php');
    
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
<section class="cart">
    <h1 class="title">cart products</h1>
    <div class="flexf">
<div class="box-containerf">
<?php
    $grand_total = 0;
$select_cart=mysqli_query($conn,"SELECT * FROM `cart1` WHERE user_id ='$user_id'") or die('query faild');
if(mysqli_num_rows($select_cart) > 0){
    while($fetch_cart=mysqli_fetch_assoc($select_cart)){
      $price = $fetch_cart['price'];  
?>   

<div class="box">
<a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" id="del" class="fas fa-times" name="del" onclick="return confirm('delete this product?');"></a>
<img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" class="image">
<div class="name"><?php echo $fetch_cart['name']; ?></div>
<div class="price">$<?php echo $fetch_cart['price']; ?>/-</div>
<form action="" method="post">
<input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
<input type="number" min="1" name="cart_quantity" class="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
<input type="submit" name="update_cart" value="update" class="option-btn">
</form>
<div class="sub-total"> <p> sub total : <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>/-</span> </p></div>
</div> 
<?php
    $grand_total += $sub_total;
 }
}else{
    
}

?>
</div>
    </div> 
   
    <div class="cart-total">
   
      <p>grand total : <span>$<?php echo $grand_total; ?>/-</span></p>
      <div class="flex">
         <a href="shop.php" class="option-btn">continue shopping</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
      </div>
</section>
    <script src="js/script.js"></script>
</body>
</html>