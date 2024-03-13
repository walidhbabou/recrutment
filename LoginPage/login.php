<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'identifier sur SkillSift</title>
    <link rel="stylesheet" href="stylelogin.css">
    <link rel="stylesheet" href="../bootstrap-4.0.0-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="topbar">
        <h2 class="logo">SkillSift</h2>
    </div> 
    
    <form action="login.php" method="post">
    <div class="body">
        <h1>S'identifier</h1><br>
        <p id="error_login" class="error">
        <?php 
    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');
    
    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        session_start();
        $_SESSION['email'] = $email;
        $search1 = $conn->prepare("SELECT COUNT(*) FROM candidat WHERE email_candidat = :email AND mdps = :password");
        $search2 = $conn->prepare("SELECT COUNT(*) FROM recruteur WHERE email_recruteur = :email AND mdps = :password");
        $search1->bindParam(':email',$email);
        $search1->bindParam(':password',$password);
        $search2->bindParam(':email',$email);
        $search2->bindParam(':password',$password);
        $search1->execute();
        $search2->execute();
        $can = $search1->fetch();
        $rec = $search2->fetch();
        $cann = $can['COUNT(*)'];
        $recc = $rec['COUNT(*)'];

        if($cann>0) {
            header("location: ../Candidat/Profil/profile.php");
        } else if ($recc>0) {
            header("location: ../Candidat/Profil/Recruteur/profile.php");
        } else {
            echo "Password or e-mail false";
        }
    }
?>
        </p>
        <div>
            <label class="label">E-mail ou téléphone</label><br>
            <input class="input" type="text" id="email" name="email">
        </div><br>
        <div>
            <label class="label">Mot de passe</label><br>
            <input class="input" type="password" id="password" name="password">
        </div><br>
        <div><a href="forgotpassword.html" id="link">Mot de passe oublié ?</a></div><br>
        <button class="button-shaped" id="login" name="submit" type="submit">S'identifier</button><br><br>
        <p class="end">Vous débutez sur SkillSift ? <a href="#">S'inscrire</a></p>
    </div>
    </form>
    <script src="../MainPage/scriptmainpage.js"></script>
</body>
</html>

