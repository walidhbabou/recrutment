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
        <h1>S'inscrire</h1><br>
        <p class="error"></p>
        <form id="myForm" action="" method="post">
        <div>
            <label class="label">Adresse E-mail</label><br>
            <input class="input" type="text" name="email">
        </div><br>
        <div>
            <label class="label">Mot de passe (plus de 6 caracteres)</label><br>
            <input class="input" type="password" name="password" maxlength="15">
        </div><br>
        <div>
            <label class="label">Confirmer votre nouveau mot de passe</label><br>
            <input class="input" type="text" name="copy_password" maxlength="15">
        </div><br>
        <div>
            <label class="label">Vous Etes Un : </label><br>
            <select class="input" type="text" name="what" maxlength="15">
                <option value="candidat">Candidat</option>
                <option value="recruteur">Recruteur</option>
            </select>
        </div><br><br>
        <button class="button-shaped" type="submit" style="border-radius: 4px; outline: none;" name="sub">S'inscrire</button><br><br>
        </form>
        <p class="end">Vous avez un compte ? <a href="../LoginPage/login.php">S'identifier</a></p><br><br>
    </div>
</body>
    <script>
        const myForm = document.getElementById('myForm');
        const error = document.getElementsByClassName('error')[0];

        myForm.addEventListener('submit',function(e){
            let email = document.getElementsByName('email')[0].value;
            const password = document.getElementsByName('password')[0].value;
            const copy_password = document.getElementsByName('copy_password')[0].value;
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

            if(!emailRegex.test(email)) {
                error.innerHTML = "Adresse e-mail invalide.";
                e.preventDefault();
                return;
            } 

            if(password.length<=6) {
                error.innerHTML = "Le mot de passe doit contenir plus de 6 caractères.";
                e.preventDefault();
                return;
            }

            if(password!=copy_password) {
                error.innerHTML = "Les mots de passe ne correspondent pas.";
                e.preventDefault();
                return;
            }


        });
    </script>
</html>

<?php
    session_start();
    if(isset($_POST['sub'])) {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = $_POST['password'];
        if($_POST['what']=='candidat') header("location: fullname.php");
        else header("location: ../Candidat/Profil/Recruteur/signuprec1.php");
    }
?>
