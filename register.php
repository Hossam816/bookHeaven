<?php

include 'config.php';
include "validate.php";

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);
   $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
            //validate name and password
            if(!validateName($name)){
               $message[] = 'Invalid Name! Only letters are allowed';
            }
            if(!validatePassword($pass)){
               $message[] = 'Password must contain at least one uppercase letter, one symbol, one number, and be between 8 and 16 characters.';
            }
            if(empty($message)){
               mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
               $message[] = 'registered successfully!';
               header('location:login.php');
            }
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
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
<style>
   .pass_resgister{
      width: 100%;
      display: flex;
      justify-content:flex-start
   }
   .pass_resgister ul{
      list-style-type:none;
      display: flex;
      flex-direction:column;
      align-items:flex-start;
      gap: 1rem
   }
   .pass_resgister ul li{
      font-size: 15px;
      color:<?php echo (empty($message)) ? 'green' : 'red'; ?>;
   }
</style>
<div class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" placeholder="enter your name" required class="box">
      <input type="email" name="email" placeholder="enter your email" required class="box">
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="confirm your password" required class="box">
      <select name="user_type" class="box">
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select>
      <div class="pass_resgister">
         <ul>
            <li>Contain 1 uppercase letter</li>
            <li>Contain 1 symbol</li>
            <li>Contain 1 number</li>
            <li>Must not be less than 16 char</li>
         </ul>
      </div>
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</div>

</body>
</html>