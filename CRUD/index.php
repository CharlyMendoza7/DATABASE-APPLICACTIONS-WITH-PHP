<?php
require_once('pdo.php');
session_start();
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
      <h1>Welcome to Autos Database</h1>
      <?php
      if ( isset($_SESSION['error']) ) {
          echo ('<p style="color:red">'.$_SESSION['error']."</p>\n");
          unset($_SESSION['error']);
      }
      if (isset($_SESSION['msg'])){
        echo('<p style="color:red">'.$_SESSION['msg']."</p>\n");
        unset($_SESSION['msg']);
      }
      if ( isset($_SESSION['success']) ) {
          echo ('<p style="color:green">'.$_SESSION['success']."</p>\n");
          unset($_SESSION['success']);
      }

      if(isset($_SESSION['who'])&&strlen($_SESSION['who'])>1){
        $stmt = $pdo->query("SELECT COUNT(*) FROM autos;");
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
          if($row['COUNT(*)']==0){
            echo("<p>No rows found</p>");
          }
          else{
            echo('<table border="1">'."\n");
            echo("<thead><tr>");
            echo("<th>Make</th>");
            echo("<th>Model</th>");
            echo("<th>Year</th>");
            echo("<th>Mileage</th>");
            echo("<th>Action</th>");
            echo("</tr></thead>");
          }
        }
        $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            echo("<tr><td>");
            echo(htmlentities($row['make']));
            echo("</td><td>");
            echo(htmlentities($row['model']));
            echo("</td><td>");
            echo(htmlentities($row['year']));
            echo("</td><td>");
            echo(htmlentities($row['mileage']));
            echo("</td><td>");
            echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
            echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
            echo("</td></tr>\n");
          }?>
        </table>
        <?php
          echo("<p><a href='add.php'>Add New Entry</a></p>");
          echo("<p><a href='logout.php'>Logout</a></p>");
        }
        else{
            echo("<p>");
            echo("<a href='login.php'>Please log in</a>");
            echo("</p>");
            echo("<p>");
            echo("Attempt to go to <a href='add.php'>add.php</a> without logging in");
            echo("</p>");
        }
      ?>
    </div>
  </body>
</html>
