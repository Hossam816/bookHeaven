<?php

include 'config.php';
include 'validate.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = $_POST['number'];
   $msg = mysqli_real_escape_string($conn, $_POST['message']);


   if(!validatePhoneNumber($number)){
      $message[] = 'Invalid phone number! Phone number should start with "01" and contain exactly 11 digits.';
   }else if(!validateName($name)){
      $message[] = "Invalid name.";
   }
   else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $message[] = "Invalid email format!";
   }else{
      $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');
      if(mysqli_num_rows($select_message) > 0){
         $message[] = 'message sent already!';
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
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<style>
   .alert{
      width:100%;
      height: 50px;
      background-color:#B7F587;
      border-radius:8px;
      margin-bottom:10px;
      display: flex;
      flex-direction:column;
      align-items:center;
      justify-content: center;
   }
   .alert h2{
      text-transform:uppercase;
      letter-spacing: 0.15rem;
      font-weight: 400;

   }
   .success{
      width:100%;
      height: 50px;
      background-color:#FF7D7D;
      border-radius:8px;
      margin-bottom:10px;
      display: flex;
      flex-direction:column;
      align-items:center;
      justify-content: center;
   }
   .success h2{
      text-transform:uppercase;
      letter-spacing: 0.15rem;
      font-weight: 400;

   }
</style>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>contact us</h3>
   <p> <a href="home.php">home</a> / contact </p>
</div>

<section class="contact">
   <form action="" method="post">
      <?php if(isset($_POST['send'])&&empty($message)){?>
         <div class="success">
            <h2>your message has been sent successfully !</h2>
         </div>
      <?php }elseif(!empty($message)){?>
         <div class="alert">
            <h2>your message has not been sent!</h2>
         </div>
      <?php }?>         

      <h3>say something!</h3>
      <input type="text" name="name" required placeholder="enter your name" class="box">
      <label for="" style="color:red;font-size:1.7rem; text-align:left; display:<?php echo (empty($message)) ? 'none' : 'block'; ?>;">Invalid name format</label>
      <input type="email" name="email" required placeholder="enter your email" class="box">
      <label for="" style="color:red;font-size:1.7rem; text-align:left; display:<?php echo (empty($message)) ? 'none' : 'block'; ?>;">Invalid email format</label>
      <input type="number" name="number" required placeholder="enter your number" class="box">
      <label for="" style="color:red;font-size:1.7rem; text-align:left; display:<?php echo (empty($message)) ? 'none' : 'block'; ?>;">Phone is Invalid must start with '01' and contain 11 digits</label>
      <textarea name="message" class="box" placeholder="enter your message" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn">
   </form>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>