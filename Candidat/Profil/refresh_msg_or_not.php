<?php
   session_start();
   $email = $_SESSION['email'];

   $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

   $to = $_POST['to'];

   $query = $conn->prepare("SELECT COUNT(*) FROM messages WHERE (from_msg = :email AND to_msg = :too) OR (from_msg = :too AND to_msg = :email)");
   $query->bindParam(':email',$email);
   $query->bindParam(':too',$to);
   $query->execute();

   $x = $query->fetchColumn();

   echo $x;

?>