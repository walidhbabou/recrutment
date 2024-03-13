<?php
    session_start();
    $email = "mohamedelkhanfaf0@gmail.com";
    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

    
        $val = $_POST['value'];
        $decision = $_POST['decision'];

        echo 'id : ' . $val;
        echo 'decision : ' . $decision;
        echo 'email : ' . $email;
        
        if ($decision == 'add') {
            $sql = $conn->prepare("INSERT INTO favourite (email_candidat,id_poste) VALUES (:email,:val)");
            $sql->bindParam(':email',$email);
            $sql->bindParam(':val',$val);
            $sql->execute();
        } else {
            $sql = $conn->prepare("DELETE FROM favourite WHERE email_candidat=:email AND id_poste=:val");
            $sql->bindParam(':email',$email);
            $sql->bindParam(':val',$val);
            $sql->execute();
        }
     
?>