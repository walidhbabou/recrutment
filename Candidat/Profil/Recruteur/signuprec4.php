<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'identifier sur SkillSift</title>
    <link rel="stylesheet" href="../../../LoginPage/stylelogin.css">
    <link rel="stylesheet" href="../../../bootstrap-4.0.0-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="topbar">
        <h2 class="logo">SkillSift</h2>
    </div> 
    
    <div class="body">  
        <h1>Confirmer votre Adresse E-mail</h1><br>
        <p style="font-weight: 550;" id="getcode">Entrer le code 6 chiffres Envoyé, <a href="signuppage.php">Changer.</a></p>
        <p class="error">
            <?php
                session_start();
                if(isset($_POST['sub'])) {
                    if($_SESSION['code'] != $_POST['code_given']) echo"Code incorrect.";
                    else header("location: profile.php");

                    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

                    $statement = $conn->prepare("INSERT INTO recruteur (email_recruteur, mdps, nom, prenom, nom_societe, num_tel_recruteur, site, email_societe, year_founded_societe, secteur_societe, taille_societe, pays_soc,ville_soc)
                    VALUES (:email_recruteur, :mdps, :nom, :prenom, :nom_societe, :num_tel_recruteur, :site, :email_societe, :year_founded_societe, :secteur_societe, :taille_societe, :pays_soc,:ville_soc)");

                    $num = 0;
                    $domaine = 'Informatique';
                    $photo = 'photo';
                    $cv = 'cv';

                    $statement->bindParam(':email_recruteur',$_SESSION['email']);
                    $statement->bindParam(':mdps',$_SESSION['password']);
                    $statement->bindParam(':nom',$_SESSION['firstname']);
                    $statement->bindParam(':prenom',$_SESSION['lastname']);
                    $statement->bindParam(':nom_societe',$_SESSION['nameE']);
                    $statement->bindParam(':num_tel_recruteur',$_SESSION['phone']);
                    $statement->bindParam(':site',$_SESSION['siteE']);
                    $statement->bindParam(':email_societe',$_SESSION['emailE']);
                    $statement->bindParam(':year_founded_societe',$_SESSION['yE']);
                    $statement->bindParam(':secteur_societe',$_SESSION['secteurE']);
                    $statement->bindParam(':taille_societe',$_SESSION['tailleE']);
                    $statement->bindParam(':ville_soc',$_SESSION['cityE']);
                    $statement->bindParam(':pays_soc',$_SESSION['countryE']);

                    $statement->execute();
                }
            ?>
        </p>
        <form action="" method="post">
        <div>
            <label class="label">Code 6 chiffres</label><br>
            <input class="input" type="text" name="code_given" placeholder="_ _ _  _ _ _" style="text-align: center; " maxlength="6">
        </div><br><br>
        <button class="button-shaped" style="border-radius: 4px; outline: none;" name="sub">S'identifier</button><br><br>
    </div>
    </form>
</body>
</html>