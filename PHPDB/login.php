<?php
  if(isset($_POST['cancel'])){
    header("Location: index.php");
    return;
  }

  $salt = 'XyZzy12*_';
  $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

  $failure = false;

  $p = false;
  $u = false;

  if(isset($_POST['who'])&&isset($_POST['pass'])){
    if(strlen($_POST['who'])<1 || strlen($_POST['pass'])<1){
      $failure = "Email and password are required";
    }else{
      $p = $_POST['pass'];
      $u = $_POST['who'];
      $check = hash('md5', $salt.$_POST['pass']);
      if(strpos($u, '@') !== false){
        if($check == $stored_hash){
          error_log("Login success ".$_POST['who']);
          header("Location: autos.php?name=".urlencode($_POST['who']));
        }else{
          error_log("Login fail ".$_POST['who']." $check");
          $failure = "Incorrect Password";
        }
      }else{
          $failure = "Email must have an at-sign (@)";
      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Carlos David Mendoza Robles 8450c878</title>
  </head>
  <body>
    <h1>Please Log In</h1>
    <?php
      if($failure!==false){
        echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
      }
    ?>
    <form method="POST">
      <label for="un">User Name</label>
      <input type="text" name="who" value="<?= htmlentities($u); ?>" id="un"><br/>
      <label for="psw">Password</label>
      <input type="text" name="pass" value="<?= htmlentities($p); ?>" id="psw"><br/>
      <input type="submit" value="Log In">
      <input type="submit" name="cancel" value="Cancel">
    </form>
  </body>
</html>
