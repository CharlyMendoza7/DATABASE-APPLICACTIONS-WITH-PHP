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

$stmt = $pdo->query("SELECT make FROM autos WHERE autos_id=$_GET[autos_id]");
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['dlt'])){
  $stmt = $pdo->query("DELETE FROM autos WHERE autos.autos_id = $_GET[autos_id]");
  $_SESSION['success'] = "Record deleted";
  header('Location: index.php');
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
    <div class="container">
      <p>
    Confirm: Deleting <?= htmlentities($row['make']); ?>
  </p>
  <form method="POST">
      <input type="submit" name="dlt" value="Delete">
      <a href="index.php">Cancel</a>
    </form>
  </div>
  </body>
</html>
