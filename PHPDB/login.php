<?php
session_start();
  if(isset($_POST['cancel'])){
    header("Location: index.php");
    return;
  }

  $salt = 'XyZzy12*_';
  $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

  //$failure = false;

  //$who = false;
  //$pass = false;

  if(isset($_POST['email'])&&isset($_POST['pass'])){
    unset($_SESSION['who']);
    if(strlen($_POST['email'])<1 || strlen($_POST['pass'])<1){
      $_SESSION['message'] = "Email and password are required";
      //$failure = "Email and password are required";
    }else{
      $who = $_POST['email'];
      $pass = $_POST['pass'];
      //$p = $_POST['pass'];
      //$u = $_POST['who'];
      $check = hash('md5', $salt.$pass);
      if(strpos($who, '@') !== false){
        if($check == $stored_hash){
          $_SESSION['who'] = $who;
          $_SESSION['pass'] = $pass;
          error_log("Login success ".$_SESSION['who']);
        header("Location: view.php"/*?name=".urlencode($_SESSION['who'])*/);
          return;
        }else{
          error_log("Login fail ".$_POST['who']." $check");
          $_SESSION['fail'] = "Incorrect password";
          header("Location: login.php");
          return;
          //$failure = "Incorrect Password";
        }
      }else{
          $_SESSION['atsign'] = "Email must have an at-sign (@)";
          header("Location: login.php");
          return;
          //$failure = "Email must have an at-sign (@)";
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
      if(isset($_SESSION['atsign'])){
        echo('<p style="color:red">'.$_SESSION['atsign'].'</p>');
        unset($_SESSION['atsign']);
      }
      if(isset($_SESSION['fail'])){
        echo('<p style="color:red">'.$_SESSION['fail'].'</p>');
        unset($_SESSION['fail']);
      }
    ?>
    <form method="POST">
      <label for="un">User Name</label>
      <input type="text" name="email" id="un"><br/>
      <label for="psw">Password</label>
      <input type="text" name="pass" id="psw"><br/>
      <input type="submit" value="Log In">
      <input type="submit" name="cancel" value="Cancel">
    </form>
  </body>
</html>
