<?php
    session_start();
    $email = $_SESSION['email'];
 
    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

    $poste = $conn->prepare("SELECT * FROM poste WHERE email_recruteur=:email ORDER BY date_poste DESC");
    $poste->bindParam(':email',$email);
    $poste->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Candidat.css">
    <link rel="stylesheet" href="../../../bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>
    <div id="nav">
        <div>
            <h2 class="logo">
                SkillSift
            </h2>
        </div>
        <div class="sblo">
            <div class="searchbar" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                <input type="text" id="search" placeholder="Rechercher emplois, mots clés, entreprises">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <form action="" method="post">
            <button class="btn" id="logout" name="logout" type="submit">déconnecter</button></form>
            <!-- <span id="search_help">
            <div>
                <p>option 1</p>
            </div>
            <div>
                <p>option 2</p>
            </div>
            <div>
                <p>option 3</p>
            </div>
            </span> -->
        </div>
    </div> 

    <div class="nav2">
        <div>
            <a href="profile.php"><i class="fa-regular fa-user"></i> <span>Mon profil</span></span></a>
            <a href="poster.php"><i class="fa-solid fa-scroll"></i> <span>Poster une Annonce</span></span></a>
            <a  href="../messages.php"><i class="fa-regular fa-message"></i> <span>Messages</span></a>
            <a id="theone"><i class="fa-solid fa-code-branch"></i> <span>Mes Annonces</span></a>
            <a href="stats.php"><i class="fa-solid fa-chart-simple"></i> <span>Statistiques</span></a>
        </div>
    </div>
    <h3 class="result-search">Mes Annonces</h3>
    <div class="row">
        <div class="A col-md-3" style="height: 700px; overflow: scroll" >
            <?php
                while($l = $poste->fetch(PDO::FETCH_ASSOC)) {
                    $id = $l['id_poste'];
                    $tit = $l['titre_poste'];
                    $dom = $l['domaine'];
                    $stat = $l['status'];
                    $date_fin = $l['date_fin'];
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

                    $company = $conn->prepare("SELECT * FROM recruteur WHERE email_recruteur = :email");
                    $company->bindParam(':email',$email_r);
                    $company->execute();
                    $line = $company->fetch(PDO::FETCH_ASSOC);
                    $coun = $line['pays_soc']; $cit = $line['ville_soc'];
                    $nam = $line['nom_societe'];

                    $check_postuler = $conn->prepare("SELECT COUNT(*) FROM postule WHERE id_poste=:id AND email_candidat=:email_candidat");
                    $check_postuler->bindParam(':id',$id);
                    $check_postuler->bindParam('email_candidat',$email);
                    $check_postuler->execute();

                    $decision = $check_postuler->fetchColumn();

                    if($date_fin<$current_time) { $oui = '<div class="bdy-infos" style="background-color: rgba(0, 0, 0, 0.144);">
                        <i class="fa-solid fa-fire" style="color: red;"></i><p class="ps" style="color: red;">Recrutement actif</p>
                    </div>'; } else {
                        $oui = '';
                    }
                    
                    echo '
                    <div class="lilpost myobjectives" id="'.$id.'" onclick="handleclick(this);">
                    <div class="top"><div style="display: flex; align-items: center;"><p class="icon" style="background-color: rgb('.$a.','.$b.','.$c.');">'.$char.'</p><p class="nv">NOUVEAU!</p></div></div>
                    <div class="bdy">
                        <p class="bdy-title">'.$tit.'</p>
                        <p class="bdy-company">'.$nam.'</p>
                        <p class="bdy-det1">'.$cit.', '.$coun.' &#8226; il y a '.$mytime.'</p>
                        <div class="forbdy">
                        <div class="bdy-infos">
                            <i class="fa-solid fa-briefcase" id="bag"></i><p class="ps">'.$dom.'</p>
                        </div>
                        <div class="bdy-infos">
                            <i class="fa-solid fa-briefcase" id="bag"></i><p class="ps">'.$stat.'</p>
                        </div>
                        '.$oui.'
                        </div>
                    </div>
                </div>     
                    ';

                }
            ?>               
        </div>
        <div class="B col-md-9">
            <div class="detail-job" id="thisDiv">
                </div>
            </div>
        </div>
    </div>
</body>
    <script>
        let last = null;
        function handleclick(element){
            if(last) {
                last.style.borderColor = "white";
            }
            element.style.borderColor = 'blue';
            var thisDiv = document.getElementById('thisDiv');
            last = element;

            $.ajax({
                type: "POST",
                url: "../job-results2.php",
                data: {value: element.id},
                success:function(data) {
                    thisDiv.innerHTML = data;
                }               
            });
        }
    </script>
</html>
