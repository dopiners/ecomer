<?php

include 'co.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `ecomer` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin.css">

</head>
<body>

<?php include 'admin_header.php'; ?> 
  <h1 class="title">users accounts</h1>
<section class="users">
   <div class="box-container"> 
    
 <?php
 
$select_users = mysqli_query($conn,"SELECT * FROM `ecomer`") or die('query faild');
while($fetch_users=mysqli_fetch_assoc($select_users)){


 ?>
  
   <div class="box">
<p>username: <span><?php echo $fetch_users['name']; ?></span></p>
<p>email: <span><?php echo $fetch_users['email']; ?></span></p>
<p>user_type: <span style="color:<?php if($fetch_users['user_type'] === 'admin'){echo'gold' ;}else{echo 'red';} ?>"><?php echo $fetch_users['user_type']; ?></span></p>
<a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?')" class="delete-btn">delete</a>
   </div>
   <?php
};
   ?>
    </div>
</section>
<script src="js/admin_script.js"></script>
</body>
</html>