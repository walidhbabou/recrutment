<?php
    session_start();
    $email = $_SESSION['email'];
    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

    
        $val = $_POST['value'];
        $decision = $_POST['decision'];

        echo 'id : ' . $val;
        echo 'decision : ' . $decision;
        echo 'email : ' . $email;
        
        if ($decision == 'add') {
            $sql = $conn->prepare("INSERT INTO friends (email1,email2) VALUES (:email,:val)");
            $sql->bindParam(':email',$email);
            $sql->bindParam(':val',$val);
            $sql->execute();
        } else {
            $sql = $conn->prepare("DELETE FROM friends WHERE email1=:email AND email2=:val");
            $sql->bindParam(':email',$email);
            $sql->bindParam(':val',$val);
            $sql->execute();
        }
     
?>