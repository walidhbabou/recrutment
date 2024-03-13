<?php
    session_start();
    $email = $_SESSION['email'];
    $id = $_POST['value'];
 
    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

    $poste = $conn->prepare("SELECT * FROM candidat,postule WHERE candidat.email_candidat=postule.email_candidat AND postule.id_poste=:id");
    $poste->bindParam(':id',$id);
    $poste->execute();

    echo '<div class="A col-md-3" style="height: 970px; overflow-y: scroll" >';

    while($l = $poste->fetch(PDO::FETCH_ASSOC)) {

            $emailx = $l['email_candidat'];
            $nom = $l['nom']; $city =$l['ville']; $country=$l['pays'];
            $prenom = $l['prenom'];
            $domaine = $l['domaine'];

            $comp = $conn->prepare("SELECT COUNT(*) FROM competence WHERE email_candidat=:email");
            $lan = $conn->prepare("SELECT COUNT(*) FROM language WHERE email_candidat=:email");
            $for = $conn->prepare("SELECT COUNT(*) FROM formation WHERE email_candidat=:email");
            $comp->bindParam(':email',$emailx);
            $lan->bindParam(':email',$emailx);
            $for->bindParam(':email',$emailx);
            $comp->execute();
            $lan->execute();
            $for->execute();
            $compp = $comp->fetch(); $co = $compp['COUNT(*)'];
            $lann = $lan->fetch(); $la = $lann['COUNT(*)'];
            $forr = $for->fetch(); $fo = $forr['COUNT(*)'];

            $ok = $conn->prepare("SELECT COUNT(*) FROM friends WHERE email1=:email AND email2=:email2");
            $ok->bindParam(':email',$email);
            $ok->bindParam(':email2',$emailx);
            $ok->execute();
            $okk = $ok->fetch();
            if($okk['COUNT(*)']==0) $okkk = '<button class="ok" id="msg" name="'.$emailx.'" onclick="addtomsg(this);"><i class="fa-solid fa-user-plus"></i>Ajouter au Messages</button>';
            else $okkk = '<button class="ok" id="msg" name="'.$emailx.'" onclick="addtomsg(this);" style="background-color:rgb(133, 183, 58);"><i class="fa-solid fa-user-check"></i>Ajouté</button>';

            if($co>1) $co = '<div class="bdy-infos" style="background-color: rgb(239, 177, 191);">
            <i class="fa-solid fa-star" id="bag"></i><p class="ps">'.$co.' Competences</p>
        </div>';
            else $co = '';

            if($la>1) $la = '<div class="bdy-infos" style="background-color: rgb(99, 226, 184);">
            <i class="fa-solid fa-language" id="bag"></i><p class="ps">'.$la.' languages</p>
        </div> ';
            else $la = '';

            if($fo>1) $fo = '<div class="bdy-infos" style="background-color: rgb(239, 201, 177);">
            <i class="fa-solid fa-book" id="bag"></i></i><p class="ps">'.$fo.' formations</p>
        </div>';
            else $fo = '';

            echo '
            <div class="lilpost myobjectives" id="'.$emailx.' "onclick="handleclick(this)">
            <div class="top"><div style="display: flex; align-items: center;"><p class="icon" style="background-color: blue">Candidat</p></div></div>
            <div class="bdy">
                <p class="bdy-title">'.$prenom.' '.$nom.'</p>
                <p class="bdy-company">Candidat</p>
                <p class="bdy-det1"><i class="fa-solid fa-location-dot" style="color: blue; margin-right: 5px;"></i>'.$city.', '.$country.'</p>
                <div class="forbdy">
                <div class="bdy-infos">
                    <i class="fa-solid fa-briefcase" id="bag"></i><p class="ps">'.$domaine.'</p>
                </div> 
                '.$co.'   
                '.$la.'
                '.$fo.'
                '.$okkk.'
                </div>
            </div>
        </div>
        </div>'; }

    
?>