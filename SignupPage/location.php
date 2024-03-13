<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

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
    <link rel="stylesheet" href="../LoginPage/stylelogin.css">
    <link rel="stylesheet" href="../bootstrap-4.0.0-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="topbar">
        <h2 class="logo">SkillSift</h2>
    </div> 
    
    <div class="body">
        <h1>Où habitez-vous ?</h1><br>
        <p class="error"></p>
        <form action="" method="post" id="myForm">
        <div>
            <label class="label">Pays *</label><br>
            <input class="input" type="text" name="country" maxlength="25">
        </div><br>
        <div>
            <label class="label">Ville/Province *</label><br>
            <input class="input" type="text" name="city" maxlength="25">
        </div><br><br>
        <button class="button-shaped" style="border-radius: 4px; outline: none;" type="submit" name="sub">S'inscrire</button><br><br>
        <br><br>
        </form>
    </div>
    <script>
        const myForm = document.getElementById('myForm');
        const error = document.getElementsByClassName('error')[0];

        myForm.addEventListener('submit',function(e){
            const country = document.getElementsByName('country')[0].value;
            const city = document.getElementsByName('city')[0].value;
            var nameRegex = /^[a-zA-ZÀ-ÖØ-öø-ÿ']+$/;

            if(!nameRegex.test(country) || !nameRegex.test(city)) {
                error.innerHTML = "Pays/Ville invalide.";
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
        $_SESSION['city'] = ucfirst(strtolower($_POST['city']));
        $_SESSION['country'] = ucfirst(strtolower($_POST['country']));

        $code = mt_rand(111111,999999);
        $_SESSION['code'] = $code;

        $email = $_SESSION['email'];
        $lastname = $_SESSION['lastname'];

        sendMail($email,$code,$lastname);
        
        header("location: checkemail.php");
    }
?>