<?php
    $val = $_POST['value'];
    session_start();
    $email = $_SESSION['email'];
 
    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

    $poste = $conn->prepare("SELECT * FROM poste WHERE id_poste = :id");
    $poste->bindParam(':id',$val);
    $poste->execute();

    $l = $poste->fetch();
    
    $id = $l['id_poste'];
    $tit = $l['titre_poste'];
    $dom = $l['domaine'];
    $stat = $l['status'];
    $prof = $l['profile'];
    $date_fin = $l['date_fin'];
    $desc = $l['description'];
    $salaire = $l['salaire'];
    $prise = $l['prise_de_poste'];
    $current_time = new DateTime();
    $time_poste = new DateTime($l['date_poste']);
    $diff = $current_time->diff($time_poste);
    $email_r = $l['email_recruteur'];
    $a = $l['a']; $b = $l['b']; $c = $l['c'];
    $char = substr($tit,0,1);

    if($diff->days == 0) {
        if($diff->h-12 == 0) {
            if($diff->m == 0) {
                $s_or_no = ($diff->s > 1) ? 'secondes' : 'seconde';
                $mytime = $diff->s .' '. $s_or_no;
            }
            else {
                $s_or_no = ($diff->m > 1) ? 'minutes' : 'minute';
                $mytime = $diff->m .' '. $s_or_no;
            }
        } else {
            $s_or_no = ($diff->h-12 > 1) ? 'heures' : 'heure';
                $mytime = $diff->h-12 .' '. $s_or_no;
        }
    } else {
        $s_or_no = ($diff->days > 1) ? 'jours' : 'jour';
                $mytime = $diff->days .' '. $s_or_no;
    }

    $company = $conn->prepare("SELECT recruteur.* FROM recruteur,poste WHERE recruteur.email_recruteur = poste.email_recruteur AND poste.id_poste=:id");
    $company->bindParam(':id',$val);
    $company->execute();
    $line = $company->fetch(PDO::FETCH_ASSOC);
    $coun = $line['pays_soc']; $cit = $line['ville_soc'];
    $nam = $line['nom_societe']; $site = $line['site'];
    $y = $line['year_founded_societe']; $sec = $line['secteur_societe'];
    $taille = $line['taille_societe']; $mail = $line['email_societe'];

    $favcheck = $conn->prepare("SELECT COUNT(*) FROM favourite WHERE email_candidat = :email AND id_poste = :id");
    $favcheck->bindParam(':email',$email);
    $favcheck->bindParam(':id',$val);
    $favcheck->execute();

    $rep = $favcheck->fetchColumn();
    if($rep == 0) $reponse = 'fa-regular';
    else $reponse = 'fa-solid';

    echo'
    
    <div class="head">
        <div class="under-head1">
            <p class="icon" style="background-color: rgb('.$a.','.$b.','.$c.'); width: fit-content;">'.$char.'</p>
            <p class="detail-title">'.$tit.'</p>
        </div>
        <div class="under-head2">
            <i class="'.$reponse.' fa-heart" onclick="fav(this,'.$id.')"></i>
        </div>
    </div>
    <div class="det">'.$nam.' &#8226; '.$cit.', '.$coun.' &#8226; Il y a '.$mytime.'</div>
    <hr color="#333">
    <div class="description">
        <p class="title">Description</p>
        <p>'.$desc.'</p>
    </div>
    <hr color="#333">
    <div class="description">
        <p class="title">Ce que nous vous offrons</p>
        <p>Dans le cadre de notre développement, notre concession recrute un <span style="color: blueviolet; font-weight: 550;">'.$prof.'.</span></p>
        <ul>
            <li>Status : '.$stat.'</li>
            <li>Salaire : '.$salaire.'</li>
            <li>Prise de Poste : '.$prise.'</li>
        </ul>
    </div>
    <hr color="#333">
    <div class="description">
        <p class="title">Faits et chiffres</p>
        <table cellpadding="10" cellspacing="10px" width="100%">
            <tr class="c1">
                <td class="T1">Adresse</td>
                <td class="T2">'.$cit.', '.$coun.'</td>
            </tr>
            <tr>
                <td class="T1">Secteur</td>
                <td class="T2">'.$sec.'</td>
            </tr>
            <tr class="c1">
                <td class="T1">Taille de la société</td>
                <td class="T2">'.$taille.' salariés ou plus</td>
            </tr>
            <tr>
                <td class="T1">Year Founded</td>
                <td class="T2">'.$y.'</td>
            </tr>
            <tr class="c1">
                <td class="T1">Adresse E-mail</td>
                <td class="T2">'.$mail.'</td>
            </tr>            
            <tr>
                <td class="T1">Site Web</td>
                <td class="T2">'.$site.'</td>
            </tr>
        </table>
    </div>
    
    
    ';




?>