<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "clients";
    $conn = "";
    $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);
    session_start();
    $email = $_SESSION['email'];
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
        <h1>Ajouter Un Intéret</h1><br>
        <p id="error_code" class="error">
            <?php
                if(isset($_POST['sub'])) {
                    if(empty($_POST['competence'])) {
                        echo "Veuillez Entrer Un Competence";
                    } else {
                        $comp = $_POST['competence'];
                        $sql = "INSERT INTO skills (email,skill) VALUES ('$email','$comp')";
                        mysqli_query($conn,$sql);
                        header("location: ../profile.php");
                    }
                }
            ?>
        </p>
        <form action="add.php" method="post">
        <div>
            <label class="label">Saisir un Intéret</label><br>
            <input class="input" type="text" name="competence">
        </div><br><br>
        <button type="submit" name="sub" class="button-shaped" style="border-radius: 4px; outline: none;">Ajouter</button><br><br>
        <p class="end"><a href="../profile.php">Retourner</a></p>
        </form>
    </div>
</body>
</html>