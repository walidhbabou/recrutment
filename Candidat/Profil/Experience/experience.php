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
        <h1>Ajouter Une Experience</h1><br>
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
            <label class="label">Nom de l’entreprise *</label><br>
            <input class="input" type="text" name="competence">
        </div><br>
        <div>
            <label class="label">Intitulé du poste *</label><br>
            <input class="input" type="text" name="competence">
        </div><br>
        <div>
            <label class="label">Pays *</label><br>
            <input class="input" type="text" name="competence">
        </div><br>
        <div>
            <label class="label">Ville *</label><br>
            <input class="input" type="text" name="competence">
        </div><br>
        <div>
            <label class="label">Temps de travail *</label><br>
            <select name="" id="" class="input">   
            <option hidden selected value="">---</option>
            <option value="">Full-time</option>
            <option value="">Part-time</option>
            <option value="">Pier-diem</option>
            <option value="">Other</option>
            </select>
        </div><br>
        <div class="checkbox">
            <input type="checkbox" name="competence" id="actual">
            <label class="label" for="actual">Poste actuel</label>
        </div><br>
        <div>
            <label class="label">Mois Début *</label><br>
            <select name="" id="start_month" class="input">   
                <option hidden selected value="">---</option>
                <option value="janvier">janvier</option>
                <option value="février">février</option>
                <option value="mars">mars</option>
                <option value="avril">avril</option>
                <option value="mai">mai</option>
                <option value="juin">juin</option>
                <option value="juillet">juillet</option>
                <option value="août">août</option>
                <option value="septembre">septembre</option>
                <option value="octobre">octobre</option>
                <option value="novembre">novembre</option>
                <option value="décembre">décembre</option>                
            </select>
        </div><br>
        <div>
            <label class="label">Année Début *</label><br>
            <select name="" id="start_year" class="input">
                <option hidden selected value="">---</option>
                <option value="1998">1998</option>
                <option value="1999">1999</option>
                <option value="2000">2000</option>
                <option value="2001">2001</option>
                <option value="2002">2002</option>
                <option value="2003">2003</option>
                <option value="2004">2004</option>
                <option value="2005">2005</option>
                <option value="2006">2006</option>
                <option value="2007">2007</option>
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>                
            </select>
        </div><br>
        <div>
            <label class="label">Mois Fin</label><br>
            <select name="" id="end_month" class="input">   
                <option hidden selected value="">---</option>
                <option value="janvier">janvier</option>
                <option value="février">février</option>
                <option value="mars">mars</option>
                <option value="avril">avril</option>
                <option value="mai">mai</option>
                <option value="juin">juin</option>
                <option value="juillet">juillet</option>
                <option value="août">août</option>
                <option value="septembre">septembre</option>
                <option value="octobre">octobre</option>
                <option value="novembre">novembre</option>
                <option value="décembre">décembre</option>                
            </select>
        </div><br>
        <div>
            <label class="label">Année Fin</label><br>
            <select name="" id="end_year" class="input">  
                <option hidden selected value="">---</option> 
                <option value="1998">1998</option>
                <option value="1999">1999</option>
                <option value="2000">2000</option>
                <option value="2001">2001</option>
                <option value="2002">2002</option>
                <option value="2003">2003</option>
                <option value="2004">2004</option>
                <option value="2005">2005</option>
                <option value="2006">2006</option>
                <option value="2007">2007</option>
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>                
            </select>
        </div><br>
        <button type="submit" name="sub" class="button-shaped" style="border-radius: 4px; outline: none;">Ajouter</button><br><br>
        <p class="end"><a href="../profile.php">Retourner</a></p><br><br>
        </form>
    </div>
    <script>
        var actual = document.getElementById('actual');
        var end_month = document.getElementById('end_month');
        var end_year = document.getElementById('end_year');
        actual.addEventListener('change',function(){
            end_month.disabled = actual.checked;
            end_year.disabled = actual.checked;
        });
    </script>
</body>
</html>