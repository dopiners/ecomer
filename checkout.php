
<?php

include 'co.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:lo.php');
}

  if(isset($_POST['order-btn'])){
$name=mysqli_real_escape_string($conn,$_POST['check_name']);
$number=$_POST['check_number'];
$email=mysqli_real_escape_string($conn,$_POST['check_email']);
$method = mysqli_real_escape_string($conn, $_POST['check_methode']);
$address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['check_flat'].', '. $_POST['check_street'].', '. $_POST['check_city'].', '. $_POST['check_country'].' - '. $_POST['check_pin']);
$placed_on=date('Y-M-D');

$cart_total=0;
$cart_products[]='';
$cart_query=mysqli_query($conn,"SELECT * FROM `cart1` WHERE user_id = '$user_id'") or die('query faild');
if(mysqli_num_rows($cart_query)> 0){
    while($cart_fetch =mysqli_fetch_assoc($cart_query)){
        $cart_products[] = $cart_fetch['name'].' ('.$cart_fetch['quantity'].') ';
        $sub_total=($cart_fetch['price'] * $cart_fetch['quantity']);
        $cart_total += $sub_total;
    }
}
$total_products = implode(', ',$cart_products);
$order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

if($cart_total == 0){
    $message[] = 'your cart is empty';
 }else{
    if(mysqli_num_rows($order_query) > 0){
       $message[] = 'order already placed!'; 
    }else{
        mysqli_query($conn, "INSERT INTO `orders`(user_Id, name, number, email, method, address, total_products, total_price, placed_on ) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
       $message[] = 'order placed successfully!';
       mysqli_query($conn, "DELETE FROM `cart1` WHERE user_id = '$user_id'") or die('query failed');
    }
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

<div class="heading">
    <h3 class="title">check out</h3>
    <p><a href="home.php">home /</a>check out</p>
</div>
<section class="display-order">

<?php  
   $grand_total = 0;
   $select_cart = mysqli_query($conn, "SELECT * FROM `cart1` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($select_cart) > 0){
      while($fetch_cart = mysqli_fetch_assoc($select_cart)){
         $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
         $grand_total += $total_price;
?>

<?php
   }
}else{
   echo '<p class="empty">your cart is empty</p>';
}
?>


</section>
    <section class="boxes">
   
<form action="" method="post">    
     <h3 class="title2">place your order</h3>   
<div class="flex">
         
         <div class="inputbox">
            <span>your name:</span>
            <input type="text" name="check_name" class="inpt" required placeholder="enter your name">
         </div>
         <div class="inputbox">
            <span>your number:</span>
            <input type="number" name="check_number" class="inpt" required placeholder="enter your number">
         </div>
         <div class="inputbox">
            <span>your email:</span>
            <input type="email" name="check_email" class="inpt" required placeholder="enter your email">
         </div>
         <div class="inputbox">
            <span>methode:</span>
           <select name="check_methode" class="methode">
            <option value="cash on deleviry">cash on deleviry</option>
            <option value="creidet card">creidet card</option>
            <option value="paypal">paypal</option>
            <option value="paymnt">paymnt</option>
           </select>
         </div>
         <div class="inputbox">
            <span>address line 01:</span>
            <input type="number" name="check_flat" placeholder="e.g. flat no." min="0">
         </div>
         <div class="inputbox">
            <span>address line 01:</span>
            <input type="text" name="check_street" placeholder="e.g. street name" min="0">
         </div>
         <div class="inputbox">
            <span>city :</span>
            <input type="text" name="check_city" required placeholder="e.g. mumbai">
         </div>
         <div class="inputbox">
            <span>state :</span>
            <input type="text" name="check_state" required placeholder="e.g. maharashtra">
         </div>
         <div class="inputbox">
            <span>country :</span>
            <input type="text" name="check_country" required placeholder="e.g. india">
         </div>
         <div class="inputbox">
            <span>pin code :</span>
            <input type="number" min="0" name="check_pin" required placeholder="e.g. 123456">
         </div>
     
         <div class="grand-total"> <p> grand total : <span>$<?php echo $grand_total; ?>/-</span> </p></div>
            <input type="submit"  name="order-btn" class="btn">
      
</form>
        </div>
    </section>

    <script src="js/script.js"></script>
</body>
</html>