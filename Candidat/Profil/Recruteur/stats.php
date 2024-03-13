<?php
    session_start();
    $email = $_SESSION['email'];
 
    $conn = new PDO('mysql:host=localhost;dbname=skillsift;charset=utf8','root','');

    $poste = $conn->prepare("SELECT * FROM poste WHERE email_recruteur=:email ORDER BY date_poste DESC");
    $poste->bindParam(':email',$email);
    $poste->execute();
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
            <div class="searchbar" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                <input type="text" id="search" placeholder="Rechercher emplois, mots clés, entreprises">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <form action="" method="post">
            <button class="btn" id="logout" name="logout" type="submit">déconnecter</button></form>
            <!-- <span id="search_help">
            <div>
                <p>option 1</p>
            </div>
            <div>
                <p>option 2</p>
            </div>
            <div>
                <p>option 3</p>
            </div>
            </span> -->
        </div>
    </div> 

    <div class="nav2">
        <div>
            <a href="profile.php"><i class="fa-regular fa-user"></i> <span>Mon profil</span></span></a>
            <a href="poster.php"><i class="fa-solid fa-scroll"></i> <span>Poster une Annonce</span></span></a>
            <a  href="../messages.php"><i class="fa-regular fa-message"></i> <span>Messages</span></a>
            <a href="mesannonces.php"><i class="fa-solid fa-code-branch"></i> <span>Mes Annonces</span></a>
            <a id="theone"><i class="fa-solid fa-chart-simple"></i> <span>Statistiques</span></a>
        </div>
    </div>
    <div class="choose">
        <?php
            while($l = $poste->fetch(PDO::FETCH_ASSOC)) {
                $tit = $l['titre_poste'];
                $I = $l['id_poste'];
                echo '<button class="bu" style="outline: none;" id="'.$I.'" onclick="stats2(this)">'.$tit.'</button>';
            }
        ?>
    </div>
    <h3 class="result-search">Mes Annonces</h3>
    <div class="row" id="row">
    </div>
        <div class="B col-md-9">
            <div id="thisDiv"  class="detail-job">
                
            </div>
        </div>
    </div>
</body>
    <script>
        let last = null;
        function stats2(element){
            if(last) {
                last.style.backgroundColor = 'rgb(218, 218, 209)';
                last.style.color = "black";
            }
            element.style.backgroundColor = 'rgb(25, 33, 107)';
            element.style.color = 'white';

            var thisDiv = document.getElementById('row');
            last = element;

            $.ajax({
                type: "POST",
                url: "stats2.php",
                data: {value: element.id},
                success:function(data) {
                    thisDiv.innerHTML = data;
                }               
            });
        }

        function addtomsg(element) {
            var value = element.getAttribute('name');
            console.log(value);


            if(element.innerHTML=='<i class="fa-solid fa-user-plus"></i>Ajouter au Messages') {
                element.innerHTML = '<i class="fa-solid fa-user-check"></i>Ajouté';
                element.style.backgroundColor = 'rgb(133, 183, 58)';
                var decision = 'add';
                $.ajax({
                type: "POST",
                url: "../add_remove_message.php",
                data: {value: value,
                      decision: decision    
                }             
            });
            }
            else {
                element.innerHTML= '<i class="fa-solid fa-user-plus"></i>Ajouter au Messages';
                element.style.backgroundColor = 'blue';
                var decision = 'remove';
                $.ajax({
                type: "POST",
                url: "../add_remove_message.php",
                data: {value: value,
                      decision: decision    
                }              
            });
            }
            
        }


        let last2 = null;
        function handleclick(element){
            if(last2) {
                last2.style.borderColor = "white";
            }
            element.style.borderColor = 'blue';
            var Div = document.getElementById('thisDiv');

            $.ajax({
                type: "POST",
                url: "../personne2.php",
                data: {value: element.id},
                success:function(data) {
                    Div.innerHTML = data;
                }               
            });


        }


    </script>
    <style>
        .bu {
            outline: none;
            border: none;
            padding: 12px 24px;
            font-weight: 550;
            border-radius: 28px;
            margin: 5px 10px;
            background-color: rgb(218, 218, 209);
            cursor: pointer;
        }

        .bu:hover + .bu:focus {
            outline: none;
        }
    </style>
</html>
