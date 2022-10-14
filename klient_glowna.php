<?php
session_start();
if (!isset($_SESSION['code']) || $_SESSION['type']!=1) {
  session_destroy();
  header("location:logowanie.php?error=Najpierw zaloguj się!");
}
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Panel Klienta</title>
    <link rel="stylesheet" href="./style.css">
  </head>
  <body>
    <div class="main">
      <div class="clientpanel">
        <div class="table">
          <?php
              require_once './connect.php';
              $sql = "SELECT name, surname, balance, account_number, id_accountant
              FROM `users` WHERE code='$_SESSION[code]'; ";
              $result = $connect->query($sql);
              $row = $result->fetch_assoc();
                echo <<< TABLE
                <table>
                  <tr>
                    <td><h1>Witaj</h1></td>
                    <td><h1>$row[name] $row[surname]</h1></td>
                  </tr>

                  <tr>
                    <td>
                      <h3>Twoje saldo wynosi:</h3>
                    </td>
                    <td> <h3>$row[balance] zł</h3> </td>
                  </tr>
                  <tr>
                    <tr>
                      <td>
                        <h3>Twój numer rachunku:</h3>
                      </td>
                      <td> <h3>$row[account_number]</h3> </td>
                      <tr>
                        <td>
                          <h3>Id twojego menegera:</h3>
                        </td>
                        <td> <h3>$row[id_accountant]</h3> </td>


                TABLE;
           ?>


            </tr>
            <tr>
              <td colspan="2" class = "tableform">
                <button type="button" name="przelew"
                onclick='location.href="klient_glowna.php?cl=wykonajprzelew"'>Wykonaj przelew</button>
                <button type="button" name="historia"
                onclick='location.href="klient_glowna.php?cl=historia"'>Wyświetl historię</button>

                <a href="session_destroy.php"> <input class = "clientButtons" type="button" name="logout" value="wyloguj"></a>
              </td>
          </form>

          </tr>
        </table>
      </div>
      <?php
if (isset($_GET['cl'])) {
  $cl = $_GET['cl'];
  if ($cl == 'wykonajprzelew') {

    echo <<< TRANSFER
    <div class="transfer">
      <table>
        <tr>
          <td><h1>Wykonaj przelew</h1></td>
        </tr>
        <form class="klientTrasfer" action="przelew.php" method="post">
        <tr>
          <td>
            Numer konta odbiorcy<input type="text" name="accountNumber"  onkeypress="return /[0-9]/i.test(event.key)">
          </td>
        </tr>
        <tr>
          <td>
            Tytuł przelewu<input type="text" name="transferTitle">
          </td>
          </tr>
          <tr>
          <td>
            Imie i nazwisko odbiorcy<input type="text" name="accountName" >
          </td>
          </tr>
          <tr>
          <td>
            Kwota<input type="text" name="transferValue" >
          </td>
        </tr>
        <tr>
        <td>
          <input type="submit" name="submit" value="wyślij">
        </td>
      </tr>
      <input type="hidden" name="code" value="$_SESSION[code]">
        </form>
        <tr>
        <td>
TRANSFER;
if (isset($_GET['error'])) {
  echo "<p style='color:red;'>$_GET[error]</p>";
}
    echo "</div> </td>
    </tr>
  </table>";
  }
  elseif ($cl == 'historia') {
    echo <<< HISTORIA
    <div class="history">
        <table class="historytable">
          <tr class="historytable">
            <td colspan="6"><h2>Historia przelewow</h2></td>
          </tr>
                <tr class="historytable">
                  <td>nadawca</td><td>odbiorca</td><td>receiver_name</td><td>tytuł</td><td>kwota</td><td>data</td>
                </tr>
    HISTORIA;

    $sql =
    "SELECT DISTINCT
    IFNULL(receiver_account,'usunięty użytkownik') as receiver_account,
      IFNULL(sender_account,'usunięty użytkownik') as sender_account,
    title,
    date,
	  value,
    receiver_name
FROM
    `transactions`
WHERE
    sender_account = $row[account_number] OR receiver_account = $row[account_number];";
    $result = $connect->query($sql);
    while($row=$result->fetch_assoc())
    {
      echo <<< HISTORY
      <tr class="historytable">
        <td>$row[sender_account]</td><td>$row[receiver_account]</td><td>$row[receiver_name]</td><td>$row[title]</td><td>$row[value]</td><td>$row[date]</td>
      </tr>
HISTORY;
    }


    echo <<< HISTORY
        </table>
    </div>
    HISTORY;
  }
}
       ?>
      </div>
    </div>
    <?php
    $connect->close();
 ?>
  </body>
</html>
