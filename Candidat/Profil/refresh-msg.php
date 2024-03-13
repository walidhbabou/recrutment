<?php
   session_start();
   $email = $_SESSION['email'];

   $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

   $to = $_POST['to'];

   $query = $conn->prepare("SELECT * FROM messages WHERE (from_msg = :email AND to_msg = :too) OR (from_msg = :too AND to_msg = :email)");
   $query->bindParam(':email',$email);
   $query->bindParam(':too',$to);
   $query->execute();

   while($M = $query->fetch(PDO::FETCH_ASSOC)) {
      if($M['from_msg']==$email) {
        echo '<div class="my target">'.$M['msg'].'</div>
        <div class="clear"></div>';
      } else {
        echo '<div class="you target">'.$M['msg'].'</div>
        <div class="clear"></div>';
      }
   }
?>