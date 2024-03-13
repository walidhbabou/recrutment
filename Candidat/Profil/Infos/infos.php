<?php
     $db_server = "localhost";
     $db_user = "root";
     $db_pass = "";
     $db_name = "clients";
     $conn = "";
     $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);
     session_start();
     $email = $_SESSION['email'];
     $result = mysqli_query($conn,"SELECT * FROM candidat WHERE email='$email'");
     $row = mysqli_fetch_assoc($result);
     $lastname = $row['lastname'];
     $firstname = $row['firstname'];
     $city = $row['city'];
     $country = $row['country'];
     ?>

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
        <h1>Modifier votre Informations Personnelles</h1><br>
        <p class="error">
            <?php
                if(isset($_POST['sub'])) {
                    $country = $_POST['country'];
                    $city = $_POST['city'];
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];

                    if(empty($firstname)|| empty($lastname) || strlen($firstname)<3|| strlen($lastname)<3 ) {
                        echo "Veuillez saisir un nom/prenom valide.";
                    } else if(empty($country)|| empty($city) || strlen($country)<3|| strlen($city)<3 ) {
                        echo "Veuillez saisir un nom de ville/pays valide.";
                    } else {
                        mysqli_query($conn,"UPDATE candidat SET lastname='$lastname', firstname='$firstname', country='$country', city='$city' WHERE email='$email'");
                        header("location: ../profile.php");
                    }
                }
            ?>
        </p>
        <form action="" method="post">
        <div>
            <label class="label">Prenom</label><br>
            <input class="input" type="text" name="firstname" maxlength="25" value="<?php echo "$firstname" ?>">
        </div><br>
        <div>
            <label class="label">Nom</label><br>
            <input class="input" type="text" name="lastname" maxlength="25" value="<?php echo "$lastname" ?>">
        </div><br>    
        <div>
            <label class="label">Pays</label><br>
            <input class="input" type="text" name="country" maxlength="25" value="<?php echo "$country" ?>">
        </div><br>
        <div>
            <label class="label">Ville/Province</label><br>
            <input class="input" type="text" name="city" maxlength="25" value="<?php echo "$city" ?>">
        </div><br><br>
        <button class="button-shaped" style="border-radius: 4px; outline: none;" type="submit" name="sub">Enregistrer</button><br><br>
        </form>
        <p class="end"><a href="../profile.php">Retourner</a></p>
    </div><br><br>
</body>
</html>