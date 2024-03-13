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
        <h1>Quel est votre nom ?</h1><br>
        <p class="error"></p>
        <form action="" method="post" id="myForm">
        <div>
            <label class="label">Nom *</label><br>
            <input class="input" type="text" name="firstname" maxlength="25">
        </div><br>
        <div>
            <label class="label">Prenom *</label><br>
            <input class="input" type="text" name="lastname" maxlength="25">
        </div><br>
        <div>
            <label class="label">Numéro de téléphone *</label><br>
            <input class="input" type="text" name="phone" maxlength="25">
        </div><br><br>
        <button class="button-shaped" style="border-radius: 4px; outline: none;" name="sub">S'inscrire</button><br><br>
        <br><br>
    </div>
    </form>
    <script>
        const myForm = document.getElementById('myForm');
        const error = document.getElementsByClassName('error')[0];

        myForm.addEventListener('submit',function(e){
            const firstname = document.getElementsByName('firstname')[0].value;
            const lastname = document.getElementsByName('lastname')[0].value;
            const phone = document.getElementsByName('phone')[0].value;
            var phoneRegex = /^-?\d+$/;
            var nameRegex = /^[a-zA-ZÀ-ÖØ-öø-ÿ']+$/;

            if(!nameRegex.test(firstname) || !nameRegex.test(lastname)) {
                error.innerHTML = "Prenom/Nom invalide.";
                e.preventDefault();
                return;
            } 

            if(!phoneRegex.test(phone) || phone.strlen >= 11) {
                error.innerHTML = "Numéro de téléphone invalide.";
                e.preventDefault();
                return;
            }

        });
    </script>
</body>
</html>

<?php
    session_start();
    if(isset($_POST['sub'])) {
        $_SESSION['firstname'] = ucfirst(strtolower($_POST['firstname']));
        $_SESSION['lastname'] = ucfirst(strtolower($_POST['lastname']));
        $_SESSION['phone'] = ucfirst(strtolower($_POST['phone']));
        header("location: location.php");
    }
?>