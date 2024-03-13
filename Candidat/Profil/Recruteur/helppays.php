<?php
    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');
    $id = $_POST['value'];

    $ville = $conn->prepare("SELECT ville FROM ville WHERE id_pays = :id");
    $ville->bindParam(':id',$id);
    $ville->execute();

    while($s = $ville->fetch()) {
        $ss = $s['ville'];
        
        echo'<option value="'.$ss.'">'.$ss.'</option>';
    }
    

?>