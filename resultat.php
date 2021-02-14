<?php 
session_start();

include("dbConnection.php");
$destArray1=$_SESSION['myarray'];
$points = mysqli_query($con, 'SELECT * FROM quiz WHERE eid = "'.$_GET['eid'].'"') or die('Error');
$intitule = mysqli_query($con, 'SELECT * FROM questions WHERE eid = "'.$_GET['eid'].'"') or die('Error');
$bonneReponses = mysqli_query($con, 'SELECT option FROM answer, options, questions, quiz WHERE questions.eid = quiz.eid AND answer.ansid = options.optionid AND answer.qid = questions.qid AND quiz.eid = "'.$_GET['eid'].'"') or die('Error');
$noteFinale = 0;
$noteJoueur = 0;


      $points_data = mysqli_fetch_array($points);
?><!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Réponse au quizz</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
</head>
<body>
  <header>
    <p> BigBrain - LE jeu de Quizz </p>
  </header>
  <p>Intitulé du quizz : <?php echo $points_data['title']; ?></p>
  <br>

  <?php
  
        $i=0;
        while ($i < count($destArray1))
        {
          $intitule_data = mysqli_fetch_array($intitule);
          $bonneReponses_data = mysqli_fetch_array($bonneReponses);
          
          echo '<h2>'; echo $intitule_data['qns']; echo' </h2>';
          echo 'votre réponse à la question : '.$destArray1[$i] ."<br />";
          echo 'bonne réponse : '.$bonneReponses_data['option'] ."<br />";
          if($destArray1[$i] == $bonneReponses_data['option']) {
            echo 'votre réponse est correcte !';
            $noteJoueur = $noteJoueur + $points_data['correct'];
          }
          else {
            echo 'votre réponse est incorrecte !';
            $noteJoueur = $noteJoueur - $points_data['wrong'];
          }
            $i++;
        }
        echo '<br>Votre score est de '.$noteJoueur ;

  ?>
  <footer>
  </footer>
</body>
</html>