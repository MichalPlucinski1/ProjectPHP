<?php
session_start();
if (!isset($_SESSION['code']) || $_SESSION['type']!=2) {
  session_destroy();
  header("location:logowanie.php?error=Najpierw zaloguj się!");
}
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <style media="screen">
      body{
        background-color: #008B09;
      }
    </style>
    <title>panel Menedżera</title>
  </head>
  <body>
    <div class="main">
      <div class="clientpanel">



          <div class="table">
          <table class="padding">
            <?php
                require_once './connect.php';
                $sql = "SELECT name, surname, id

                FROM `users` WHERE code='$_SESSION[code]'; ";
                $result = $connect->query($sql);
                $row = $result->fetch_assoc();
                $id = $row['id'];
                  echo <<< TABLE

                    <tr>
                      <td colspan="2"><h2>Menedżer $row[name] $row[surname]</h2></td>
                    </tr>
                  TABLE;

             ?>
            <tr class="padding">
              <td>
                <button style="margin-left:6px;" type="button" name="Dodaj"
                onclick='location.href="menedzer_glowna.php?cl=DodajKlienta"'>Dodaj nowego klienta</button>
                <button  style="margin-right:6px;" type="button" name="podgladklientow"
                onclick='location.href="menedzer_glowna.php?cl=PodgladKlientow"'>Wyświetl klientów</button>


              </td>
            </tr>
            <tr>
              <td> <button class = "clientButtons" onclick='location.href="logowanie.php"' type="button" name="logout" value="wyloguj">wyloguj</button></td>
            </tr>
            <?php
if (isset($_GET['error'])) {
  echo "<tr><td colspan = 2>$_GET[error]</td></tr>";
}
             ?>
          </form>
          </table>




          </div>
          <?php
          if (isset($_GET['cl'])) {
            if($_GET['cl'] == "DodajKlienta") {
              echo <<< DODAJKLIENTA
              <div class="table">
              <table>
              <tr>
                <td><h1>Dodaj klienta</h1></td>
              </tr>
              <form class=addClient action=add_client.php method=post>
              <tr>
                <td>
                  Imie:<input type="text" name="name">
                </td>
              </tr>
              <tr>
                <td>
                  Nazwisko:<input type="text" name="surname">
                </td>
                </tr>
                <tr>
                <td>
                  Email:<input type="email" name="email">
                </td>
                </tr>
                <tr>
                <td>
                  Data urodzenia:<input type="date" name="dataur">
                </td>
                </tr>
                <tr>
                <td>
                Miejscowość: <select name="miejscowosc">


DODAJKLIENTA;
                $sql = "SELECT id, Name FROM `cities` WHERE 1";
                $result = $connect->query($sql);
                while($row = $result->fetch_assoc())
                {
                  echo "<option value=$row[id]>$row[Name]</option>";
                }
                  // Miejscowosc:<input type="text" name="miejscowosc"> <br>
                  echo <<< DODAJKLIENTA
                  </select>
                  </td>
              </tr>
              <tr>
              <td>
                <p style="margin:5px;">Kod do logowania, numer konta i hasło są generowane automatycznie,<br> zostaną przesłane na podanego maila</p>
                <input type="hidden" name="id_accountant" value="$id">
                <input type="submit" name="submit" value="wyślij">

              </td></tr>

              </form>
              </table></div>

DODAJKLIENTA;

            }


            if ($_GET["cl"] == "PodgladKlientow") {

              echo <<< PODGLADKLIENTOW
              <div class="showclientsdiv">

              <table class="showclients">
                <tr>
                  <td colspan="12"> <h1>
                     Klienci:</td></h1>
                </tr>
                <tr class="withborder">
                  <td>kod</td> <td>numer konta</td> <td>Imie</td><td>Nazwisko</td><td>mail</td><td>data ur</td><td>Data dołączenia</td><td>miasto</td><td>zobacz historie</td> <td>Edytuj </td> <td>Usuń</td>
                </tr>
PODGLADKLIENTOW;
                $sql = "SELECT account_number, balance, birthdate, joindate, users.name as fname, email, surname, code, cities.Name as city FROM `users` join cities on cities.ID = users.city WHERE id_accountant = '$id';";
                $result = $connect->query($sql);
                while($row=$result->fetch_assoc())
                {
                  echo <<< PODGLADKLIENTOW
                  <tr class=withborder>
                    <td>$row[code]</td><td>$row[account_number]</td><td>$row[fname]</td><td>$row[surname]</td><td>$row[email]</td><td>$row[birthdate]</td><td>$row[joindate]</td><td>$row[city]</td><td><a href=menedzer_glowna.php?cl=Historia&user=$row[account_number]>historia</a> </td> <td><a href=menedzer_glowna.php?cl=edytuj&user=$row[account_number]>Edytuj</a> </td><td><a href=client_delete.php?user=$row[account_number]>Usuń</a> </td>
                  </tr>
PODGLADKLIENTOW;
                }
              echo "</table>
              </div>";


            }
            if ($_GET['cl'] == 'Historia' && !empty($_GET['user'])) {
              echo <<< HISTORY

              <div class="history">
                  <table class="historytable">
                    <tr class="historytable">
                      <td colspan="5"><h2>Historia przelewow</h2></td>

                    </tr>
                    <tr class="historytable">
                      <td>nadawca</td><td>odbiorca</td><td>tytuł</td><td>kwota</td><td>data</td>
                    </tr>
HISTORY;
                      $sql =
                      "SELECT DISTINCT
                      IFNULL(receiver_account,'usunięty użytkownik') as receiver_account,
                      IFNULL(sender_account,'usunięty użytkownik') as sender_account,
                      title,
                      date,
                      value
                      FROM
                      `transactions`
                      WHERE
                      sender_account = $_GET[user] OR
                       receiver_account = $_GET[user];";
                      $result = $connect->query($sql);
                      while($row=$result->fetch_assoc())
                      {
                        echo <<< HISTORY
                        <tr class="historytable">
                          <td>$row[sender_account]</td><td>$row[receiver_account]</td><td>$row[title]</td><td>$row[value]</td><td>$row[date]</td>
                        </tr>
                      HISTORY;
                      }

                    echo <<< HISTORY

                  <tr>
                  <td colspan = 5>
                  <button type="button" name="historia"
                  onclick='location.href="menedzer_glowna.php?cl=PodgladKlientow"'>Powrót</button>
                  </td>
                  </tr>
                  </table>
              </div>
              HISTORY;
            }
            if ($_GET['cl'] == 'edytuj' && !empty($_GET['user'])) {
              echo <<< EDIT
              <div class="showclientsdiv">

              <table class="showclients">
              <tr class=withborder>
                <td>kod</td> <td>numer konta</td> <td>Imie</td><td>Nazwisko</td><td>mail</td><td>data ur</td><td>Data dołączenia</td><td>miasto</td>
              </tr>
EDIT;
              $id=$_GET['user'];
              $sql = "SELECT account_number, balance, birthdate, joindate, users.name as fname, email, surname, code, cities.Name as city FROM `users` join cities on cities.ID = users.city WHERE account_number = '$id';";
              $result = $connect->query($sql);
              $data=$result->fetch_assoc();

                echo <<< EDIT
                <tr class=withborder>
                  <td>$data[code]</td><td>$data[account_number]</td><td>$data[fname]</td><td>$data[surname]</td><td>$data[email]</td><td>$data[birthdate]</td><td>$data[joindate]</td><td>$data[city]</td>
                </tr>
EDIT;
              echo <<< EDIT
              <form action="edit.php" method="post">

              <tr class=withborder>
                <td>$data[code]</td><td>$data[account_number]</td><td><input type="text" name="fname" value="$data[fname]"></td><td><input type="text" name="surname" value="$data[surname]"></td><td><input type="text" name="email" value="$data[email]"></td><td><input type="date" name="birthdate" value="$data[birthdate]"></td><td>$data[joindate]</td>
                <td><select name="miejscowosc">
EDIT;

                $sql = "SELECT id, Name FROM `cities` WHERE 1";
                $result = $connect->query($sql);
                while($row = $result->fetch_assoc())
                {
                  echo "<option value=$row[id]>$row[Name]</option>";
                }
                echo <<< EDIT
                </select>
                 </td>
              </tr>
              <tr>
              <input type="hidden" name="account_number" value="$data[account_number]">

                <td colspan=9><input type="submit" name="submit" value="zatwierdz"><button type="button" name="historia"
                onclick='location.href="menedzer_glowna.php?cl=PodgladKlientow"'>Powrót</button></td>

              </tr>
              </form>
              <tr>
              <td colspan=9 style="color:red">
              </td>
              </tr>
              </table>
              </div>
EDIT;
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
