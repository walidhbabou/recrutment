<?php
   ob_start();
   session_start();
   $email = $_SESSION['email'];

   $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

   $s = $conn->prepare("SELECT * FROM recruteur WHERE email_recruteur = :email");
   $s->bindParam(':email',$email);
   $s->execute();

   $row = $s->fetch(PDO::FETCH_ASSOC);

   $phone = $row['num_tel_recruteur'];
   $name_soc = $row['nom_societe'];
   $lastname = $row['prenom'];
   $site_soc = $row['site'];
   $email_soc = $row['email_societe'];
   $loca = $row['ville_soc'].', '.$row['pays_soc'];
   $y = $row['year_founded_societe'];
   $sec = $row['secteur_societe'];
   $taille = $row['taille_societe'];

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
            <form style="width: 80%;" action="" method="post">
            <div class="searchbar" style="padding: 0 2%;">
                <input type="text" id="search" name="search" style="font-weight: 500;" placeholder="Cherchez... ">
                <button  type="submit" name="s" style="display: none;"><i class="fa-solid fa-magnifying-glass" name="sticker" id="sticker" style="cursor: pointer;"></i></button>
            </div>
            </form>
            <form action="" method="post">
            <button class="btn" id="logout" name="logout" type="submit" >déconnecter</button></form>
        </div>
    </div> 

    <div class="nav2">
        <div>
            <a id="theone"><i class="fa-regular fa-user"></i> <span>Mon profil</span></span></a>
            <a href="poster.php"><i class="fa-solid fa-scroll"></i> <span>Poster une Annonce</span></span></a>
            <a href="msg.php"><i class="fa-regular fa-message"></i> <span>Messages</span></a>
            <a href="mesannonces.php"><i class="fa-solid fa-code-branch"></i> <span>Mes Annonces</span></a>
            <a href="stats.php"><i class="fa-solid fa-chart-simple"></i> <span>Statistiques</span></a>
        </div>
    </div>
    <div class="row">
        <div class="A col-md-3">
            <h3>Mon Profile</h3>
            <div class="profile">
                <img src="../messi.jpg">
                <div class="infos">
                    <p id="name"><?php echo $lastname ?></p>
                    <p id="location"><?php echo $name_soc ?></p>
                </div>
            </div>
            <br>        
        </div>
        <div class="B col-md-9">
            <div class="options" id="container">
                <div class="liloptions" id="left-liloption">
                    <div class="text">
                        <h3>Adresse E-mail</h3>
                        <p><?php echo $email ?></p>
                    </div>
                </div>
                <div class="liloptions" id="right-liloption">
                    <div class="text">
                        <h3>Numéro de téléphone</h3>
                        <p><?php echo $phone ?></p>
                    </div>
                </div>
            </div>
            <div class="options" id="container">
                <div class="liloptions" id="left-liloption">
                    <div class="text">
                        <h3>Site de société</h3>
                        <p><?php echo $site_soc ?></p>
                    </div>
                </div>
                <div class="liloptions" id="right-liloption">
                    <div class="text">
                        <h3>E-mail de société</h3>
                        <p><?php echo $email_soc ?></p>
                    </div>
                </div>
            </div>     
            <div class="options" id="container">
                <div class="liloptions" id="left-liloption">
                    <div class="text">
                        <h3>Secteur</h3>
                        <p><?php echo $sec ?></p>
                    </div>
                </div>
                <div class="liloptions" id="right-liloption">
                    <div class="text">
                        <h3>Location de société</h3>
                        <p><?php echo $loca ?></p>
                    </div>
                </div>
            </div>   
            <div class="options" id="container">
                <div class="liloptions" id="left-liloption">
                    <div class="text">
                        <h3>Taille de société</h3>
                        <p><?php echo $taille ?> salariés ou plus</p>
                    </div>
                </div>
                <div class="liloptions" id="right-liloption">
                    <div class="text">
                        <h3>Year Founded</h3>
                        <p><?php echo $y ?></p>
                    </div>
                </div>
            </div>          
        </div>
    </div>
</body>
</html>
<?php
    if(isset($_POST['s'])) {
        if(!empty($_POST['search'])) {
            $_SESSION['search'] = $_POST['search'];
            header("location: prsn.php");
        }
        ob_end_flush();
    }
?>