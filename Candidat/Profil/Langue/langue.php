<?php session_start(); ?>
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
        <h1>Ajouter Une Langue</h1><br>
        <p class="error"></p>
        <form action="" method="post" id="myForm">
        <div>
            <label class="label">Choisir une Langue *</label><br>
            <select name="langue" class="input" id="langue">
                <option value="" selected hidden>---</option>
                <option value="arabic">Arabe (العربية)</option>
                <option value="bengali">Bengali (বাংলা)</option>
                <option value="chinese_simplified">Chinois (Simplifié) (简体中文)</option>
                <option value="dutch">Néerlandais (Nederlands)</option>
                <option value="english">Anglais</option>
                <option value="french">Français</option>
                <option value="german">Allemand (Deutsch)</option>
                <option value="greek">Grec (Ελληνικά)</option>
                <option value="hindi">Hindi (हिन्दी)</option>
                <option value="indonesian">Indonésien (Bahasa Indonesia)</option>
                <option value="italian">Italien (Italiano)</option>
                <option value="japanese">Japonais (日本語)</option>
                <option value="korean">Coréen (한국어)</option>
                <option value="malay">Malais (Bahasa Melayu)</option>
                <option value="portuguese">Portugais (Português)</option>
                <option value="russian">Russe (Русский)</option>
                <option value="spanish">Espagnol (Español)</option>
                <option value="swahili">Swahili</option>
                <option value="swedish">Suédois (Svenska)</option>
                <option value="tagalog">Tagalog</option>
                <option value="thai">Thaï (ไทย)</option>
                <option value="turkish">Turc (Türkçe)</option>
                <option value="urdu">Ourdou (اردو)</option>
                <option value="vietnamese">Vietnamien (Tiếng Việt)</option>
                <option value="yoruba">Yoruba</option>
                <option value="zulu">Zoulou (isiZulu)</option>   
            </select>
        </div><br>    
            <div>
                <label class="label">Niveau</label><br>
                <select name="niveau" class="input" id="level" disabled>
                    <option value="" selected hidden>---</option>
                    <option value="maternel">Langue maternelle</option>
                    <option value="beginner">Débutant</option>
                    <option value="intermediate">Intermédiaire</option>      
                    <option value="advanced">Avancé</option>              
                    <option value="fluent">Courant</option>
                </select>
        </div><br><br>
        <button type="submit" name="submit" class="button-shaped" style="border-radius: 4px; outline: none;">Ajouter</button><br><br>
        <p class="end"><a href="../profile.php">Retourner</a></p>
        </form>
    </div>
    <script>
        var langue = document.getElementById('langue');
        var level = document.getElementById('level');
        var myForm = document.getElementById('myForm');
        var error = document.getElementsByClassName('error')[0];

        langue.addEventListener('change',function(){
            if(langue.value == "") level.disabled = true;
            else level.disabled = false;
        });

        myForm.addEventListener('submit',function(e){
            if(langue.value=="" || level.value=="") {
                error.innerHTML = "Langue/Niveau sont des champs obligatoires.";
                e.preventDefault();
                return;
            } 
        });

    </script>
</body>
</html>
<?php 
    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');
    $email = $_SESSION['email'];

    if(isset($_POST['sub'])) {
        $st = $conn->prepare("INSERT INTO Language (email_candidat,language,niveau) VALUES (:email,:language,:niveau)");
        $st->bindParam(':email',$email);
        $st->bindParam(':language',$_POST['langue']);
        $st->bindParam(':niveau',$_POST['niveau']);
        header("location: ../profile.php");
        $st->execute();
    }
?> 
