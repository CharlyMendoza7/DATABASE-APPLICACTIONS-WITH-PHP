<?php
  session_start();
  require_once('pdo.php');
  if(! isset($_SESSION['who'])||strlen($_SESSION['who'])<1){
    die('Not logged in');
  }
  if(isset($_POST['logout'])){
    header('Location: logout.php');
    return;
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Carlos David Mendoza Robles 8450c878</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

  </head>
  <body>
    <h1 class="container">Tracking autos for <?= htmlentities($_SESSION['who']); ?></h1>

    <div class="container">
      <?php
        if(isset($_SESSION['success'])){
          echo('<p class="container" style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
          unset($_SESSION['success']);
        }
      ?>
    <h2>Automobiles</h2>
    <p class="container">
    <?php
      $stmt = $pdo->query("SELECT make, year, mileage FROM autos");
      echo "<ul>\n";
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo "<li>";
        echo htmlentities($row['year'])." ".htmlentities($row['make'])." / ".htmlentities($row['mileage']);
        echo "</li>";
       }
       echo "</ul>\n";
     ?>
   </p>
 </div>
    <p class="container">
      <a href="add.php">Add New</a> |
      <a href="logout.php">Logout</a>
   </p>
  </body>
</html>
