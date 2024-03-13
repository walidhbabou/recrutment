<?php
    $emailx = $_POST['value'];

    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');
 
    $check = $conn->prepare("SELECT COUNT(*) FROM candidat WHERE email_candidat=:email");
    $check->bindParam(':email',$emailx);
    $check->execute();
    $c = $check->fetch(PDO::FETCH_ASSOC);
    $n = $c['COUNT(*)'];

    if($n>0) {
        $s = $conn->prepare("SELECT * FROM Candidat WHERE email_candidat = :email");
        $s->bindParam(':email',$emailx);
        $s->execute();
     
        $row = $s->fetch(PDO::FETCH_ASSOC);
     
        $city = $row['ville'];
        $country = $row['pays'];
        $lastname = $row['prenom']; 
        $firstname = $row['nom']; 
        $a = $row['a'];   $b = $row['b']; $c = $row['c'];

   $languages = $conn->prepare("SELECT * FROM language WHERE email_candidat = :email");
   $languages->bindParam(':email',$emailx);
   $languages->execute();

   $formations = $conn->prepare("SELECT * FROM formation WHERE email_candidat = :email");
   $formations->bindParam(':email',$emailx);
   $formations->execute();

   $experiences = $conn->prepare("SELECT * FROM experience WHERE email_candidat = :email");
   $experiences->bindParam(':email',$emailx);
   $experiences->execute();

   $competences = $conn->prepare("SELECT * FROM competence WHERE email_candidat = :email");
   $competences->bindParam(':email',$emailx);
   $competences->execute();

   echo '
   <div class="head">
       <div class="under-head1">
           <p class="icon" style="background-color: rgb('.$a.','.$b.','.$c.'); width: fit-content;">M</p>
           <p class="detail-title">'.$firstname.' '.$lastname.'</p>
       </div>
   </div>
   <div class="det">Candidat &#8226; '.$city.', '.$country.'</div>
   <hr color="#333">
   <div class="description">
       <p class="title">Compétences</p>
       <div class="ann" style="margin-top: 20px; ">
   ';

   while($l = $competences->fetch(PDO::FETCH_ASSOC)) {
    $l1 = $l['competence'];
    $l2 = $l['niveau'];
    if($l2=='Débutant') { $po = '25%'; $co = '#FFD700'; }
    if($l2=='Intermédiaire') { $po = '50%'; $co = '#00CED1'; }
    if($l2=='Avancé') { $po = '75%'; $co = '#9932CC'; }
    if($l2=='Courant') { $po = '100%'; $co = '#228B22'; }

    echo '
    <div class="ann2">
    <div class="ann3">
        <p class="p1">'.$l1.'</p>
        <p class="p2">'.$l2.'</p>
    </div>
    <div class="d1" style="width: 60vh">
    <div class="d2" style="background-color: '.$co.'; width: '.$po.';"></div>
    </div>
</div>
    ';
}

echo '
</div>
</div>
<hr color="#333">
<div class="description">
    <p class="title">Expérience professionnelle</p>
';


while($l = $experiences->fetch(PDO::FETCH_ASSOC)) {
    $l1 = $l['nom_soc'];  $l5 = $l['pays_soc'];
    $l2 = $l['post']; $l6 = $l['month_start'];
    $l3 = $l['domaine']; $l7 = $l['year_start'];
    $l4 = $l['ville_soc']; $l8 = $l['month_end'];
    $l9 = $l['year_end']; $char = substr($l1,0,1);
    $l10 = $l['status']; $a = $l['a'];
    $b = $l['b'];  $c = $l['c'];
    
    if($l9=="") $M = 'en cours';
    else $M = $l8 . '/' .$l9;
    echo'
    <br><div class="under-important formation">
    <div class="information">
        <div style="align-items: center;"><p class="icon" style="background-color: rgb('.$a.','.$b.','.$c.');">'.$char.'</p><p class="tit">'.$l1.'</p>
            <p class="under-tit">('.$l3.' - '.$l2.')</p></div>
        <div>
            <div class="lil-infos"><i class="fa-regular fa-calendar"></i><p class="in">'.$l6.'/'.$l7.' - '.$M.'</p></div>
            <div class="lil-infos"><i class="fa-solid fa-location-dot"></i><p class="in">'.$l4.', '.$l5.'</p></div>
            <div class="lil-infos"><i class="fa-solid fa-briefcase"></i><p class="in">'.$l10.'</p></div>
        </div>    
    </div>
</div>
    ';



 }

 echo'
 </div>
 <hr color="#333">
 <div class="description">
     <p class="title">Diplômes / Formations</p>
 
 ';


 while($l = $formations->fetch(PDO::FETCH_ASSOC)) {
    $l1 = $l['ecole'];  $l5 = $l['pays_ecole'];
    $l2 = $l['degree']; $l6 = $l['month_start'];
    $l3 = $l['domaine']; $l7 = $l['year_start'];
    $l4 = $l['ville_ecole']; $l8 = $l['month_end'];
    $l9 = $l['year_end']; $char = substr($l1,0,1);
    $a = $l['a']; $b = $l['b']; $c = $l['c'];
    
    if($l9=="") $M = 'en cours';
    else $M = $l8 . '/' .$l9;

    echo '
    <br><div class="under-important formation">
<div class="information">
    <div style="align-items: center;"><p class="icon" style="background-color: rgb('.$a.','.$b.','.$c.');">'.$char.' </p><p class="tit">'.$l1.'</p>
        <p class="under-tit">('.$l3.' - '.$l2.')</p></div>
    <div>
        <div class="lil-infos"><i class="fa-regular fa-calendar"></i><p class="in">'.$l6.'/'.$l7.' - '.$M.'</p></div>
        <div class="lil-infos"><i class="fa-solid fa-location-dot"></i><p class="in">'.$l4.', '.$l5.'</p></div>
    </div>    
</div>
</div>
    
    ';

}

echo '
</div>
<hr color="#333">
<div class="description">
    <p class="title">Compétences</p>

';

while($l = $languages->fetch(PDO::FETCH_ASSOC)) {
    $l1 = $l['language'];
    $l2 = $l['niveau'];
    if($l2=='Langue maternelle') { $po = '100%'; $co = '#FF5733'; }
    if($l2=='Débutant') { $po = '20%'; $co = '#FFD700'; }
    if($l2=='Intermédiaire') { $po = '40%'; $co = '#00BFFF'; }
    if($l2=='Avancé') { $po = '60%'; $co = '#8A2BE2'; }
    if($l2=='Courant') { $po = '80%'; $co = '#00FF00'; }


    echo '<div class="ann2">
    <div class="ann3">
        <p class="p1">'.$l1.'</p>
        <p class="p2">'.$l2.'</p>
    </div>
    <div class="d1" style="width: 60vh">
    <div class="d2" style="background-color: '.$co.'; width: '.$po.';"></div>
    </div>';
 }





        
    }


?>