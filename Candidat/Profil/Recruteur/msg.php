<?php
   session_start();
   $email = $_SESSION['email'];

   $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

   $query = $conn->prepare("SELECT result
   FROM (
       SELECT DISTINCT
           CASE 
               WHEN from_msg = :email THEN to_msg
               WHEN to_msg = :email THEN from_msg
               ELSE NULL
           END AS result
       FROM messages
       WHERE from_msg = :email OR to_msg = :email
   ) AS subquery
   HAVING result IS NOT NULL
   

    UNION
    SELECT email2 AS result
    FROM friends
    WHERE email1 = :email

    UNION

    SELECT email1 AS result
    FROM friends
    WHERE email2 = :email;

   ");
   $query->bindParam(':email',$email);
   $query->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Candidat.css">
    <link rel="stylesheet" href="../../../bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <div id="nav">
        <div>
            <h2 class="logo">
                SkillSift
            </h2>
        </div>
        <div class="sblo">
            <div class="select-container"></div>
            <select class="select-box" id="chooser">
                <option>Rechercher pour : </option>
                <option value="poste">Un Offre d'emploi</option>
                <option value="recruteur">Un Recruteur</option>
                <option value="candidat">Un Candidat</option>
            </select>
            </div>
            <div class="searchbar">
                <input type="text" id="search" placeholder="Veuillez choisir ce que vous recherchez" disabled>
                <i class="fa-solid fa-magnifying-glass" style="display: none;" id="sticker"></i>
            </div>
            <form action="" method="post">
            <button class="btn" id="logout" name="logout" type="submit">déconnecter</button></form>
        </div>
    </div> 

    <div class="nav2">
        <div>
        <a href="profile.php"><i class="fa-regular fa-user"></i> <span>Mon profil</span></span></a>
            <a href="poster.php"><i class="fa-solid fa-scroll"></i> <span>Poster une Annonce</span></span></a>
            <a id="theone"><i class="fa-solid fa-message"></i> <span>Messages</span></a>
            <a href="mesannonces.php"><i class="fa-solid fa-code-branch"></i> <span>Mes Annonces</span></a>
            <a href="stats.php"><i class="fa-solid fa-chart-simple"></i> <span>Statistiques</span></a>
        </div>
    </div>
    <div class="row">
        <div class="A col-md-4">
            <?php
                while($l1 = $query->fetch(PDO::FETCH_ASSOC)) {
                    $email2 = $l1['result'];
                    $name = $conn->prepare("SELECT nom,prenom FROM candidat WHERE email_candidat = :email2 UNION SELECT nom,prenom FROM recruteur WHERE email_recruteur = :email2");
                    $last = $conn->prepare("SELECT msg,from_msg FROM messages WHERE (from_msg=:email AND to_msg=:email2) OR (from_msg=:email2 AND to_msg=:email) ORDER BY id_msg DESC LIMIT 1");
                    $name->bindParam(':email2',$email2);
                    $last->bindParam(':email',$email);
                    $last->bindParam(':email2',$email2);
                    $name->execute();
                    $last->execute();
                    $l2 = $name->fetch(PDO::FETCH_ASSOC);
                    $nom = $l2['nom']; $prenom = $l2['prenom'];
                    $msg = $last->fetch(PDO::FETCH_ASSOC);
                    if(isset($msg['msg'])) { 
                        $msge = $msg['msg']; 
                        $vous = $msg['from_msg'];
                        if($vous==$email) $vous = 'Vous : ';
                        else $vous = '';
                    }
                    else {$msge = 'Vous avez ajouté '.$nom.' à vos messages';
                        $vous = ''; }
                    echo '
                    <div class="'.$nom.' outside-convo" id='.$email2.' onclick="switchconv(this);">
                    <p class="head">'.$nom.' '.$prenom.'</p>
                    <p class="label">'.$vous.''.$msge.'</p>
                     </div>
                    ';
                }
            ?>
        </div>
        <div class="B col-md-8" id="conversation" style="display:none;"> 
            <div class="dis-name"></div>
            <div class="conversation" id="conv">
            </div>
            <div class="write">
                <input id="msg" placeholder="type a message here..."></input>
                <button class="button" onclick="send(this);">Envoyer</button>
            </div>
        </div>
    </div>
</body>
    <script>
        function checkmsg (){
            if(!document.getElementById('msg').value.trim()) {
                document.getElementById('send').disabled = true;
            } else {
                document.getElementById('send').disabled = false;
            }
        };

        setInterval(checkmsg,500);

        function scroll(){
            var D = document.getElementById('conv');
            var T = document.getElementsByClassName('target')[document.getElementsByClassName('target').length-1];

            if(T) {
                D.scrollTop = T.offsetTop;
            }
        }

        function switchconv(para) {

        document.getElementById('conversation').style.display = 'block';
        document.getElementsByClassName('button')[0].id = para.id;
        document.getElementsByClassName('dis-name')[0].innerHTML = para.className.split(' ')[0];
        para = para.id;
        var original;

        $.ajax({
                type: "POST",
                url: "../refresh_msg_or_not.php",
                data: {to: para }             
            });

            refresh();


        function refresh_msg() {

            $.ajax({
                type: "POST",
                url: "../refresh_msg_or_not.php",
                data: {to: para },
                success:function(data) {
                    if(original!=Number(data)) {
                        original=Number(data);
                        refresh();
                        
                    }
                }               
            });
        }

            function refresh() {
                $.ajax({
                type: "POST",
                url: "../refresh-msg.php",
                data: {to: para },
                success:function(data) {
                    document.getElementById('conv').innerHTML = data;
                    scroll();
                }               
            });

            }

        
        setInterval(refresh_msg,500);
    }

    function send(para) {
            var msg = document.getElementById('msg');
            var Vmsg = msg.value;
            $.ajax({
                type: "POST",
                url: "../sendmessage.php",
                data: {msg: Vmsg,
                to: para.id }              
            });

            msg.focused = false;
            msg.value = '';

        }
    </script>
</html>


