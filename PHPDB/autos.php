<?php

  require_once('pdo.php');

  if(! isset($_GET['name'])||strlen($_GET['name'])<1){
    die('Name parameter missing');
  }
  if(isset($_POST['logout'])){
    header('Location: index.php');
    return;
  }

  $success = false;
  $failure = false;

  $ma = false;
  $ye = false;
  $mi = false;

  if(isset($_POST['make'])){
    if(strlen($_POST['make'])<1){
      $failure = "Make is required";
    }elseif(is_numeric($_POST['mileage'])&&is_numeric($_POST['year'])){
      //$failure = "Mileage and year are numerics and all is in order";

      $sql = "INSERT INTO autos (make, year, mileage)
                  VALUES (:mk, :yr, :mg)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mg' => $_POST['mileage'])
    );
      $success = "Record inserted";
    }else{
      $failure = "Mileage and year must be numeric";
      $ma = $_POST['make'];
      $ye = $_POST['year'];
      $mi = $_POST['mileage'];
    }
  }?>
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
    <h1 class="container">Tracking autos for <?= htmlentities($_REQUEST['name']); ?></h1>
    <?php
      if($failure!==false){
        echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
      }
      if($success!==false){
        echo('<p style="color: green;">'.htmlentities($success)."</p>\n");
      }
    ?>
    <form method="post">
      <label for="mk">Make: </label>
      <input type="text" name="make" value="<?= htmlentities($ma); ?>" id="mk"><br/>
      <label for="yr">Year: </label>
      <input type="text" name="year" value="<?= htmlentities($ye); ?>" id="yr"><br/>
      <label for="mlg">Mileage: </label>
      <input type="text" name="mileage" value="<?= htmlentities($mi); ?>" id="mlg"><br/>
      <input type="submit" value="Add">
      <input type="submit" name="logout" value="Logout">
    </form>
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
  </body>
</html>
