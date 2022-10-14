<?php
session_start();
session_destroy();
 ?>

<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <title>logowanie</title>
  </head>
  <body>
    <div class="main">
      <div class="logbox">
        <div class="form">
          <h1>Witaj! Wprowadz login i haslo:</h1> <br>
          <form action="log.php" method="post">
            wprowadz identyfikator: <br><input type="text" name="login" onkeypress="return /[0-9]/i.test(event.key)"> <br>
            wprowadz hasło:<br><input type="password" name="haslo" > <br> <br>
            <input type="submit" name="submit" value="zaloguj">
          </form>
          <br>
          <?php
          
            if (isset($_GET['error'])) {
              echo "<p style='color:red;'>$_GET[error]</p>";
            }
            
           ?>

      </div>
        </div>
    </div>



  </body>
</html>
