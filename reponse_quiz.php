<?php
  session_start();
  include("dbConnection.php");
 
  $points = mysqli_query($con, 'SELECT * FROM quiz WHERE eid = "'.$_GET['eid'].'"') or die('Error');
  $points_data = mysqli_fetch_array($points);

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {		 
    $eid = @$_GET['eid'];
    $n   = @$_GET['n'];
    $array=array();
    
        

    for ($i=0; $i <$n ; $i++) { 
       if (isset($_POST['submit'])) {
if(isset($_POST['radio'.$i]))
{
$var=addslashes($_POST['radio'.$i]);
$array[]=$var;
}
else{ echo "<span>Please choose any radio button.</span>";}
}
    }




   $_SESSION['myarray']= $array; 



header("Location: resultat.php?eid=$eid&n=$n");
     	 die;
    }



 ?>
<!doctype html>
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
 
   $intitule = mysqli_query($con, 'SELECT * FROM questions WHERE eid = "'.$_GET['eid'].'"') or die('Error');
   $options = mysqli_query($con, 'SELECT option FROM options, questions WHERE options.qid = questions.qid AND questions.eid = "'.$_GET['eid'].'"');


   $j=0;


   
      while ($intitule_data = $intitule -> fetch_assoc()) {
        
      echo '
      <form name="resultat" method="POST">
      ';
      
  
  echo '
  <h2>'; echo $intitule_data['qns']; echo' </h2>
  ';
        echo'
  <div>  
  ';
  for($i = 1; $i<= 4; $i++) {
    $options_data = mysqli_fetch_array($options);
    echo '

    <input type="radio" name="radio'.$j.'" value='.$options_data['option'].'>'; echo $options_data['option']; 
    
  }

      $j++;
    }




      echo '
  <input type="submit" name="submit" value="Voir reponse">
  </form>
    </div>
  ';

  ?>





    
    
  


  <footer>
  </footer>
</body>
</html>