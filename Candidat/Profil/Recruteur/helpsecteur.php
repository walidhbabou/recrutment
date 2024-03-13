<?php
    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');
    $xx = $_POST['value'].'%';

    $secteur = $conn->prepare("SELECT nom_secteur FROM secteur WHERE nom_secteur LIKE :xx");
    $secteur->bindParam(':xx',$xx);
    $secteur->execute();

    while($s = $secteur->fetch()) {
        $ss = $s['nom_secteur'];
        echo'<input value="'.$ss.'" readonly class="helpp"><br>';
    }

?>