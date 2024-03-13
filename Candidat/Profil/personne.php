<?php
    session_start();
    $email = $_SESSION['email'];
   
    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

    $query = $conn->prepare("SELECT email FROM personne WHERE email!=:email");
    $query->bindParam(':email',$email);
    $query->execute();
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
            <a href="#"><i class="fa-regular fa-user"></i> <span>Mon profil</span></span></a>
            <a href="#"><i class="fa-regular fa-circle-check"></i> <span>Mes Candidatures</span></span></a>
            <a href="#"><i class="fa-regular fa-message"></i> <span>Messages</span></a>
            <a href="#"><i class="fa-regular fa-heart"></i> <span>Mes offres</span></a>
            <a href="#"><i class="fa-solid fa-gear"></i> <span>Paramètres</span></a>
        </div>
    </div>
    <h3 class="result-search">Résultats de recherche pour <span style="color: blue;">Développeur PHP</span></h3>
    <div class="row">
        <div class="A col-md-3" style="height: 970px; overflow-y: scroll" >
        <?php
            while($l = $query->fetch(PDO::FETCH_ASSOC)) {
                $emailx = $l['email'];
                
                $check = $conn->prepare("SELECT COUNT(*) FROM candidat WHERE email_candidat=:email");
                $check->bindParam(':email',$emailx);
                $check->execute();
                $c = $check->fetch(PDO::FETCH_ASSOC);
                $n = $c['COUNT(*)'];

                if($n>0) {
                    $infos = $conn->prepare("SELECT * FROM candidat WHERE email_candidat=:email");
                    $infos->bindParam(':email',$emailx);
                    $infos->execute();
                    $info = $infos->fetch();
                    $nom = $info['nom']; $city =$info['ville']; $country=$info['pays'];
                    $prenom = $info['prenom'];
                    $domaine = $info['domaine'];

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
                    <div class="lilpost myobjectives" id="'.$emailx.'"onclick="handleclick(this)">
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
                    ';

                }


            }
        ?>                 
        </div>
        <div class="B col-md-9">
            <div class="detail-job" id="thisDiv">
                    
                </div>
                </div>
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
                url: "personne2.php",
                data: {value: element.id},
                success:function(data) {
                    thisDiv.innerHTML = data;
                }               
            });


        }
        //this

        function addtomsg(element) {
            var value = element.getAttribute('name');
            console.log(value);


            if(element.innerHTML=='<i class="fa-solid fa-user-plus"></i>Ajouter au Messages') {
                element.innerHTML = '<i class="fa-solid fa-user-check"></i>Ajouté';
                element.style.backgroundColor = 'rgb(133, 183, 58)';
                var decision = 'add';
                $.ajax({
                type: "POST",
                url: "add_remove_message.php",
                data: {value: value,
                      decision: decision    
                }             
            });
            }
            else {
                element.innerHTML= '<i class="fa-solid fa-user-plus"></i>Ajouter au Messages';
                element.style.backgroundColor = 'blue';
                var decision = 'remove';
                $.ajax({
                type: "POST",
                url: "add_remove_message.php",
                data: {value: value,
                      decision: decision    
                }              
            });
            }
            
        }
    </script>
</html>
