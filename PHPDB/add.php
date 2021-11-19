<?php
  session_start();
  require_once('pdo.php');

  if(! isset($_SESSION['who'])||strlen($_SESSION['who'])<1){
    die('Not logged in');
  }
  if(isset($_POST['cancel'])){
    header('Location: view.php');
    return;
  }

  $success = false;
  $failure = false;

  $ma = false;
  $ye = false;
  $mi = false;

  if(isset($_POST['make'])){
    if(strlen($_POST['make'])<1){
      $_SESSION['fail'] = "Make is required";
      header('Location: add.php');
      return;
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
      $_SESSION['success'] = "Record inserted";
      header('Location: view.php');
      return;
    }else{
      $_SESSION['fail'] = "Mileage and year must be numeric";
      header('Location: add.php');
      return;
      //$failure = "Mileage and year must be numeric";
      //$ma = $_POST['make'];
      //$ye = $_POST['year'];
      //$mi = $_POST['mileage'];
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
    <h1 class="container">Tracking autos for <?= htmlentities($_SESSION['who']); ?></h1>
    <?php
      if(isset($_SESSION['fail'])){
        echo('<p class="container" style="color: red;">'.htmlentities($_SESSION['fail'])."</p>\n");
        unset($_SESSION['fail']);
      }
    ?>
    <form class="container" method="post">
      <label for="mk">Make: </label>
      <input type="text" name="make" id="mk"><br/>
      <label for="yr">Year: </label>
      <input type="text" name="year"  id="yr"><br/>
      <label for="mlg">Mileage: </label>
      <input type="text" name="mileage" id="mlg"><br/>
      <input type="submit" value="Add">
      <input type="submit" name="cancel" value="Cancel">
    </form>
  </body>
</html>
