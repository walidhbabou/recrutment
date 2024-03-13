<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'identifier sur SkillSift</title>
    <link rel="stylesheet" href="../LoginPage/stylelogin.css">
    <link rel="stylesheet" href="../bootstrap-4.0.0-dist/css/bootstrap.min.css">
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
                    else header("location: ../Candidat/Profil/profile.php");

                    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

                    $statement = $conn->prepare("INSERT INTO Candidat (email_candidat, mdps, nom, prenom, score, num_tel, domaine, cv, photo, ville, pays)
                    VALUES (:email_candidat, :mdps, :nom, :prenom, :score, :num_tel, :domaine, :cv, :photo, :ville, :pays)");

                    $num = 0;
                    $domaine = 'Informatique';
                    $photo = 'photo';
                    $cv = 'cv';

                    $statement->bindParam(':email_candidat',$_SESSION['email']);
                    $statement->bindParam(':mdps',$_SESSION['password']);
                    $statement->bindParam(':nom',$_SESSION['firstname']);
                    $statement->bindParam(':prenom',$_SESSION['lastname']);
                    $statement->bindParam(':score',$num);
                    $statement->bindParam(':num_tel',$_SESSION['phone']);
                    $statement->bindParam(':domaine',$domaine);
                    $statement->bindParam(':cv',$cv);
                    $statement->bindParam(':photo',$photo);
                    $statement->bindParam(':ville',$_SESSION['city']);
                    $statement->bindParam(':pays',$_SESSION['country']);

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