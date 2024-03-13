<?php
   if(isset($_POST['msg'])) {
    $msg = $_POST['msg'];
    session_start();
   $email = $_SESSION['email'];

   $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

   $to = $_POST['to'];

   $query = $conn->prepare("INSERT INTO messages (from_msg,to_msg,msg) values (:email,:too,:msg)");
   $query->bindParam(':email',$email);
   $query->bindParam(':too',$to);
   $query->bindParam(':msg',$msg);
   $query->execute();
   }
?>