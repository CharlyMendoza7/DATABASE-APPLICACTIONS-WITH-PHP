<?php
  session_start();
  require_once('pdo.php');

  if(is_numeric($_GET['autos_id'])){
    $stmt = $pdo->query("SELECT COUNT(*) FROM autos WHERE autos_id=$_GET[autos_id]");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  }else{
    $_SESSION['msg'] = "Bad value for id";
    header('Location: index.php');
    return;
  }

  if(! isset($_SESSION['who'])||strlen($_SESSION['who'])<1){
    die('ACCESS DENIED');
  }
  if(isset($_POST['cancel'])){
    header('Location: index.php');
    return;
  }
  if(!isset($_GET['autos_id'])||strlen($_GET['autos_id'])<1||$row['COUNT(*)']==0){
    $_SESSION['msg'] = "Bad value for id";
    header('Location: index.php');
    return;
  }


  if(isset($_POST['make'])||isset($_POST['model'])||isset($_POST['year'])||isset($_POST['mileage'])){
    if(strlen($_POST['make'])<1||strlen($_POST['model'])<1||strlen($_POST['year'])<1||strlen($_POST['mileage'])<1){
      $_SESSION['fail'] = "All fields are required";
      header('Location: add.php');
      return;
    }elseif(is_numeric($_POST['mileage'])&&is_numeric($_POST['year'])){
      //$failure = "Mileage and year are numerics and all is in order";
//PDATE `autos` SET `make` = 'toyota', `model` = 'camric', `year` = '2011', `mileage` = '50000' WHERE `autos`.`autos_id` = 3;
      $sql = "UPDATE autos SET make = :mk, model = :md, year = :yr, mileage = :mg WHERE autos.autos_id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mg' => $_POST['mileage'],
        ':id' => $_GET['autos_id'])
    );
      $_SESSION['success'] = "Record edited";
      header('Location: index.php');
      return;
    }else{
      $_SESSION['fail'] = "Mileage and year must be numeric";
    //  edit.php?autos_id='.$row['autos_id']
      header('Location: edit.php?autos_id='.$_GET['autos_id']);
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
    <h1 class="container">Editin Automobile</h1>
    <?php
      if(isset($_SESSION['fail'])){
        echo('<p class="container" style="color: red;">'.htmlentities($_SESSION['fail'])."</p>\n");
        unset($_SESSION['fail']);
      }
    ?>
    <form class="container" method="post">
      <?php
      $stmt = $pdo->query('SELECT make, model, year, mileage, autos_id FROM autos WHERE autos_id ='.$_GET['autos_id']);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

       ?>
      <label for="mk">Make: </label>
      <input type="text" name="make" value="<?= htmlentities($row['make']);?>" id="mk"><br/>
      <label for="md">Model: </label>
      <input type="text" name="model" value="<?= htmlentities($row['model']);?>"  id="md"><br/>
      <label for="yr">Year: </label>
      <input type="text" name="year" value="<?= htmlentities($row['year']);?>"  id="yr"><br/>
      <label for="mlg">Mileage: </label>
      <input type="text" name="mileage" value="<?= htmlentities($row['mileage']);?>" id="mlg"><br/>
      <input type="submit" value="Save">
      <input type="submit" name="cancel" value="Cancel">
    </form>
  </body>
</html>
