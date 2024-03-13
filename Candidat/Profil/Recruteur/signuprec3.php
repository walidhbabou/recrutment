<?php
    ob_start();
    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

    $pays = $conn->prepare("SELECT * FROM pays");
    $pays->execute();


    use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../../PHPMailer/src/Exception.php';
require '../../../PHPMailer/src/PHPMailer.php';
require '../../../PHPMailer/src/SMTP.php';

session_start();

function sendMail($email,$code,$lastname) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "skillsiftcompany@gmail.com";
    $mail->Password = "ofkf imwg sgxe aama";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom("skillsiftcompany@gmail.com","Skill Sift");
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Votre Verification code est $code";
    $mail->Body = '<p>Hey '.$lastname.',<br> Bienvenue sur SkillSift ! Nous sommes ravis de vous avoir parmi nous. Votre code de vérification est : '.$code.'</p>';
    $mail->send();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'identifier sur SkillSift</title>
    <link rel="stylesheet" href="../../../LoginPage/stylelogin.css">
    <link rel="stylesheet" href="../../../bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <div class="topbar">
        <h2 class="logo">SkillSift</h2>
    </div> 
    
    <div class="body">
        <h1>Remplissez les informations de votre Entreprise</h1><br>
        <p id="error_code" class="error"></p>
        <form action="" method="post" id="myForm">
        <div>
            <label class="label">Nom de l’entreprise *</label><br>
            <input class="input" type="text" name="nameE">
        </div><br>
        <div>
            <label class="label">Email de l’entreprise *</label><br>
            <input class="input" type="text" name="emailE">
        </div><br>
        <div>
            <label class="label">Site de l’entreprise *</label><br>
            <input class="input" type="text" name="siteE">
        </div><br>
        <div>
            <label class="label">Secteur de l’entreprise *</label><br>
            <input list="cc" class="input" type="text" id="sec" name="secteurE">
            <div class="help" id="help" style="overflow-y:scroll; max-height: 200px;" >
            </div>
        </div><br>
        <div>
            <label class="label">Pays *</label><br>
            <select class="input" id="pays" onchange="ch(this)" name="countryE">
                <?php
                    while($s = $pays->fetch()) {
                        $sss = $s['id'];
                        $ss = $s['pays'];
                        
                        echo'<option value="'.$ss.'" id="'.$sss.'">'.$ss.'</option>';
                    }
                ?>
            </select>
        </div><br>
        <div>
            <label class="label" >Ville *</label><br>
            <select class="input" id="ville" name="cityE">
                <option value="v">v</option>
            </select>
        </div><br>
        <div>
            <label class="label">Taille de l’entreprise *</label><br>
            <input class="input" type="text" name="tailleE">
        </div><br>
        <div>
            <label class="label">Year Founded *</label><br>
            <input class="input" type="text" name="yE">
        </div><br>
        <button type="submit" name="subb" class="button-shaped" style="border-radius: 4px; outline: none;">Ajouter</button><br><br>
        <p class="end"><a href="../profile.php">Retourner</a></p><br><br>
        </form>
    </div>
    <script>
        var myInput = document.getElementById('myform');

        myInput.addEventListener('submit', function (e) {
        var ch = document.getElementsByClassName('input');
        var error = document.getElementById('error_code');
        var hasEmptyField = false;

    for (var i = 0; i < ch.length - 1; i++) {
        if (ch[i].value.trim() === '') {
            hasEmptyField = true;
            break;
        }
    }

    if (hasEmptyField) {
        error.innerHTML = 'Tous les champs sont Obligatoires';
        e.preventDefault();
    }
});
        var pays = document.getElementById('pays');
        var ville = document.getElementById('ville');

        pays.addEventListener('change',function(){
            id = pays.options[pays.selectedIndex].id;
            $.ajax({
                type: "POST",
                url: "helppays.php",
                data: {value: id},
                success:function(data) {
                    ville.innerHTML = data;
                }               
            });
        });

        // function snd(div,value) {
        //     $.ajax({
        //         type: "POST",
        //         url: "helpsecteur.php",
        //         data: {value: value},
        //         success:function(data) {
        //             div.innerHTML = data;
        //         }               
        //     });
        // }

        // function helpsecteur(element) {
        //     var div = document.getElementById('help');
        //     console.log(div);

        //     snd(div,document.getElementById('sec').value);
        // }



    </script>
</body>
    <?php
        if(isset($_POST['subb'])) {
            $_SESSION['nameE'] = $_POST['nameE'];
            $_SESSION['emailE'] = $_POST['emailE'];
            $_SESSION['siteE'] = $_POST['siteE'];
            $_SESSION['secteurE'] = $_POST['secteurE'];
            $_SESSION['countryE'] = $_POST['countryE'];
            $_SESSION['cityE'] = $_POST['cityE'];
            $_SESSION['tailleE'] = $_POST['tailleE'];
            $_SESSION['yE'] = $_POST['yE'];  

            $code = mt_rand(111111,999999);
            $_SESSION['code'] = $code;

            $email = $_SESSION['email'];
            $lastname = $_SESSION['lastname'];

            sendMail($email,$code,$lastname);

            header("location: signuprec4.php");
            ob_end_flush();
        }
    ?>
</html>