<?php
   session_start();
   $email = 'mohamedelkhanfaf0@gmail.com';

   $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

   $s = $conn->prepare("SELECT * FROM Candidat WHERE email_candidat = :email");
   $s->bindParam(':email',$email);
   $s->execute();

   $row = $s->fetch(PDO::FETCH_ASSOC);

   $phone = $row['num_tel'];
   $city = $row['ville'];
   $country = $row['pays'];
   $lastname = $row['prenom'];

   //Completez votre profil
   $formation = $conn->prepare("SELECT COUNT(*) FROM formation WHERE email_candidat = :email");
   $language = $conn->prepare("SELECT COUNT(*) FROM language WHERE email_candidat = :email");
   $experience = $conn->prepare("SELECT COUNT(*) FROM experience WHERE email_candidat = :email");
   $competence = $conn->prepare("SELECT COUNT(*) FROM competence WHERE email_candidat = :email");

   
   $formation->bindParam(':email',$email);
   $language->bindParam(':email',$email);
   $experience->bindParam(':email',$email);
   $competence->bindParam(':email',$email);


   $formation->execute();
   $language->execute();
   $experience->execute();
   $competence->execute();


   $formation = $formation->fetch(PDO::FETCH_ASSOC);
   $language = $language->fetch(PDO::FETCH_ASSOC);
   $experience = $experience->fetch(PDO::FETCH_ASSOC);
   $competence = $competence->fetch(PDO::FETCH_ASSOC);


   $formation = $formation['COUNT(*)'];
   $language = $language['COUNT(*)'];
   $experience = $experience['COUNT(*)'];
   $competence = $competence['COUNT(*)'];


   $languages = $conn->prepare("SELECT * FROM language WHERE email_candidat = :email");
   $languages->bindParam(':email',$email);
   $languages->execute();

   $formations = $conn->prepare("SELECT * FROM formation WHERE email_candidat = :email");
   $formations->bindParam(':email',$email);
   $formations->execute();

   $experiences = $conn->prepare("SELECT * FROM experience WHERE email_candidat = :email");
   $experiences->bindParam(':email',$email);
   $experiences->execute();

   $competences = $conn->prepare("SELECT * FROM competence WHERE email_candidat = :email");
   $competences->bindParam(':email',$email);
   $competences->execute();

   $poste = $conn->prepare("SELECT * FROM poste ORDER BY RAND() LIMIT 2");
   $poste->execute();




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Candidat.css">
    <link rel="stylesheet" href="../../bootstrap-4.0.0-dist/css/bootstrap.min.css">
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
            <div class="select-container"></div>
            <select class="select-box" id="chooser">
                <option>Rechercher pour : </option>
                <option value="poste">Un Offre d'emploi</option>
                <option value="recruteur">Un Recruteur</option>
                <option value="candidat">Un Candidat</option>
            </select>
            </div>
            <div class="searchbar">
                <input type="text" id="search" placeholder="Veuillez choisir ce que vous recherchez">
                <i class="fa-solid fa-magnifying-glass" style="display: none;" id="sticker"></i>
            </div>
            <form action="" method="post">
            <button class="btn" id="logout" name="logout" type="submit">déconnecter</button></form>
        </div>
    </div> 

    <div class="nav2">
        <div>
            <a href="#" id="theone"><i class="fa-regular fa-user"></i> <span>Mon profil</span></span></a>
            <a href="#"><i class="fa-regular fa-circle-check"></i> <span>Mes Candidatures</span></span></a>
            <a href="#"><i class="fa-regular fa-message"></i> <span>Messages</span></a>
            <a href="#"><i class="fa-regular fa-heart"></i> <span>Mes offres</span></a>
            <a href="#"><i class="fa-solid fa-gear"></i> <span>Paramètres</span></a>
        </div>
    </div>
    <div class="row">
        <div class="A col-md-3">
            <h3>Mon Profile</h3>
            <div class="profile">
                <img src="messi.jpg">
                <div class="infos">
                    <p id="name"><?php echo $lastname ?><a href="Infos/infos.php" class="edit"><i class="fa-solid fa-user-pen"></i></a></p>
                    <p id="location"><?php echo $city ?>,  <?php echo $country ?></p>
                </div>
            </div>
            <br>
            <div class="myobjectives">
                <p class="s-tit">Complétez votre profil<p>
                <p>Optimisez votre expérience en complétant votre profil dès maintenant </p>
                <div class="obj">
                    <div class="check"><i class="fa-solid fa-check"></i></div>
                    <p class="obj-p">Télécharger un CV</p>
                </div>
                <div class="obj">
                    <div class="check" style="<?php if($experience>0) echo"background-color: blue;" ?>"><i class="fa-solid fa-check"></i></div>
                    <p class="obj-p" style="<?php if($experience>0) echo"text-decoration: line-through;" ?>">Ajouter une expérience</p>
                </div>
                <div class="obj">
                    <div class="check" style="<?php if($formation>0) echo"background-color: blue;" ?>"><i class="fa-solid fa-check"></i></div>
                    <p class="obj-p" style="<?php if($formation>0) echo"text-decoration: line-through;" ?>">Ajouter une formation</p>
                </div>
                <div class="obj">
                    <div class="check" style="<?php if($competence>0) echo"background-color: blue;" ?>"><i class="fa-solid fa-check"></i></div>
                    <p class="obj-p" style="<?php if($competence>0) echo"text-decoration: line-through;" ?>">Ajouter une compétence</p>
                </div>
                <div class="obj">
                    <div class="check" style="<?php if($language>0) echo"background-color: blue;" ?>"><i class="fa-solid fa-check"></i></div>
                    <p class="obj-p" style="<?php if($language>0) echo"text-decoration: line-through;" ?>">Ajouter des Langues</p>
                </div><br>
            </div><br>
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

                    if($decision==0)  $decision = '<button class="ok" onclick="postuler(this,'.$id.')"><i class="fa-solid fa-bolt-lightning"></i>Candidature Rapide</button>';
                    else $decision = '<button class="ok" onclick="postuler(this,'.$id.')" style="background-color: red;"><i class="fa-solid fa-user-check" ></i>Candidature Validée</button>';

                    if($date_fin<$current_time) { $oui = '<div class="bdy-infos" style="background-color: rgba(0, 0, 0, 0.144);">
                        <i class="fa-solid fa-fire" style="color: red;"></i><p class="ps" style="color: red;">Recrutement actif</p>
                    </div>'; } else {
                        $oui = '';
                    }
                    
                    echo '
                    <div class="lilpost myobjectives">
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
                        '.$decision.'
                        </div>
                    </div>
                </div>     
                    ';

                }
            ?>            
        </div>
        <div class="B col-md-9">
            <div class="options">
                <div class="text">
                    <h3>Téléchargez votre CV</h3>
                    <p>Téléchargez votre CV pour permettre aux recruteurs de vous trouver facilement</p>
                </div>
                <button class="butt btn">
                    Télécharger un CV
                </button>
            </div>
            <div class="options" id="container">
                <div class="liloptions" id="left-liloption">
                    <div class="text">
                        <h3>Adresse E-mail</h3>
                        <p><?php echo $email ?></p>
                    </div>
                    <button class="butt btn">
                        Editer
                    </button>
                </div>
                <div class="liloptions" id="right-liloption">
                    <div class="text">
                        <h3>Numéro de téléphone</h3>
                        <p><?php echo $phone ?></p>
                    </div>
                    <button class="butt btn">
                        Editer
                    </button>
                </div>
            </div>
            <div class="options important">
                <div class="under-important">
                    <div class="text">
                        <h3>Compétences</h3>
                    </div>
                    <a href="Competence/add.php"><button class="butt btn">
                        Ajouter
                    </button></a>
                </div> 
                <br><div class="ann">
                    <?php
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
                    ?>
                </div>
            </div>
            <div class="options important">
                <div class="under-important">
                    <div class="text">
                        <h3>Expérience professionnelle</h3>
                    </div>
                    <a href="Experience/experience.php"><button class="butt btn">
                        Ajouter
                    </button></a>
                </div>
                <?php
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
                ?>
            </div>
            <div class="options important">
                <div class="under-important">
                    <div class="text">
                        <h3>Diplômes / Formations</h3>
                    </div>
                    <a href="Formation/formation.php"><button class="butt btn">
                        Ajouter
                    </button></a>
                </div>
                <?php
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
                ?>
            </div>
            <div class="options important">
                <div class="under-important">
                    <div class="text">
                        <h3>Langues</h3>
                    </div>
                    <a href="Langue/langue.php"><button class="butt btn">
                        Ajouter
                    </button></a>
                </div>
                <br><div class="ann">
                    <?php
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
                            </div>
                        </div>';
                         }
                    ?>         
                </div>
            </div>
        </div>
    </div>
</body>
    <script>
        function check() {
            var Ch = document.getElementsByClassName('check');
            var P = documen.getElementsByClassName('obj-p');

            if(number(<?php echo "$formation"?>)>0) {
                Ch[2].style.backgroundColor = 'blue';
                P[2].style.textDecoration = 'line-through';
            }

            if(number(<?php echo "$experience"?>)>0) {
                Ch[1].style.backgroundColor = 'blue';
                P[1].style.textDecoration = 'line-through';
            }

            if(1>0) {
                Ch[4].style.backgroundColor = 'blue';
                P[4].style.textDecoration = 'line-through';
            }
        }

        document.getElementById('chooser').addEventListener('change',function(){
            if(document.getElementById('chooser').value == '') {
                document.getElementById('search').disabled = true;
                document.getElementById('search').placeholder = 'Veuillezz choisir ce que vous recherchez';
                document.getElementById('sticker').style.display = 'none'; 
            } else {
                document.getElementById('search').disabled = false;
                document.getElementById('sticker').style.display = 'block';
            }
        });

        function postuler(element,fa) {
            if(element.innerHTML=='<i class="fa-solid fa-bolt-lightning"></i>Candidature Rapide') {
                element.innerHTML = '<i class="fa-solid fa-user-check"></i>Candidature Validée';
                element.style.backgroundColor = 'red';
                var decision = 'add';
                $.ajax({
                type: "POST",
                url: "add_remove_postuler.php",
                data: {value: fa,
                      decision: decision    
                }             
            });
            }
            else {
                element.innerHTML = '<i class="fa-solid fa-bolt-lightning"></i>Candidature Rapide';
                element.style.backgroundColor = 'blue';
                var decision = 'remove';
                $.ajax({
                type: "POST",
                url: "add_remove_postuler.php",
                data: {value: fa,
                      decision: decision    
                }              
            });
            }
        }


    </script>
</html>


