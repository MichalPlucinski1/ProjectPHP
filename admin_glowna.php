<?php

session_start();
if (!isset($_SESSION['code']) || $_SESSION['type']!=3) {
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
        background-color: #00008B;
      }
    </style>
    <title>panel Admina</title>
  </head>
  <body>
    <div class="main">
      <div class="clientpanel">



          <div class="table">
          <table class = "padding">
            <form class="" action="admin_glowna.php" method="post">
            <?php
                require_once './connect.php';
                $sql = "SELECT name, surname
                FROM `users` WHERE code='$_SESSION[code]'; ";
                $result = $connect->query($sql);
                $row = $result->fetch_assoc();
                  echo <<< TABLE

                    <tr>
                      <td colspan="2"><h2>Administrator $row[name] $row[surname]</h2></td>
                    </tr>
                  TABLE;
             ?>



            <td style="padding: 0px 6px;">
              <h3>Operacje na klientach </h3>
            </td>
            <td style="padding: 0px 6px;"><h3> Operacje na menegerach</h3> </td>
            <tr>
              <td>
                <button type="button" name="podgladklientow"
                onclick='location.href="admin_glowna.php?cl=podgladklientow"'>Wyświetl klientów</button>

              </td>
              <td>
                <button type="button" name="podgladmenegerow"
                onclick='location.href="admin_glowna.php?cl=podgladmenegerow"'>Wyświetl menegerow</button>

              </td>

            </tr>
            <tr>

                <td>
                  <button type="button" name="DodajKlienta"
                  onclick='location.href="admin_glowna.php?cl=DodajKlienta"'>Dodaj nowego klienta</button>
                </td>
                <td>
                  <button type="button" name="DodajMenegera"
                onclick='location.href="admin_glowna.php?cl=DodajMenegera"'>Dodaj nowego menedżera</button>
              </td>
            </tr>

            <tr>
              <td colspan="2"><a href="logowanie.php"> <input class = "clientButtons" type="button" name="logout" value="wyloguj"></a></td>
            </tr>
            </form>
            <?php
            if (isset($_GET['error'])) {
              echo "<tr><td colspan = 2>$_GET[error]</td></tr>";
            }
             ?>
          </table>
          <br>
        </div>

          <?php
          if (isset($_GET['cl'])) {
            switch ($_GET['cl']) {
              case 'DodajKlienta':
              echo <<< DODAJKLIENTA
              <div class="table">
              <table>
              <tr>
                <td><h1>Dodaj klienta</h1></td>
              </tr>
              <form class=addClient action=admin_add_client.php method=post>
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
                  ID menedżera<select name="id_accountant">


  DODAJKLIENTA;
                  $sql = "SELECT id FROM `users` WHERE type=2;";
                  $result = $connect->query($sql);
                  while($row = $result->fetch_assoc())
                  {
                    echo "<option value=$row[id]>$row[id]</option>";
                  }
                    echo <<< DODAJKLIENTA
                    </select>
                  </td>
              </tr>
              <tr>
              <td>
                <p style="margin:5px;">Kod do logowania, numer konta i hasło są generowane automatycznie,<br> zostaną przesłane na podanego maila</p>
                <input type="submit" name="submit" value="wyślij">

              </td></tr>

              </form>
DODAJKLIENTA;

              if (isset($_GET['error'])) {
                echo "<tr><td><p style='color:red;'>$_GET[error]</p></td></tr>";
              }
              echo "</table></div>";


                break;

              case 'DodajMenegera':
              echo <<< DODAJMENEGERA
              <div class="table">
              <table>
              <tr>
                <td><h1>Dodaj menegera</h1></td>
              </tr>
              <form class=addClient action=admin_add_meneger.php method=post>
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


DODAJMENEGERA;
                $sql = "SELECT id, Name FROM `cities` WHERE 1";
                $result = $connect->query($sql);
                while($row = $result->fetch_assoc())
                {
                  echo "<option value=$row[id]>$row[Name]</option>";
                }
                  // Miejscowosc:<input type="text" name="miejscowosc"> <br>
                  echo <<< DODAJMENEGERA
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

DODAJMENEGERA;
                break;


              case 'podgladklientow':
              echo <<< PODGLADKLIENTOW
              <div class="showclientsdiv">

              <table class="showclients">
                <tr>
                  <td colspan="11"> <h1>
                     Klienci</td></h1>
                </tr>
                <tr class="withborder">
                  <td>kod</td> <td>numer konta</td> <td>Imie</td><td>Nazwisko</td><td>mail</td><td>data ur</td><td>Data dołączenia</td><td>miasto</td><td>id menedżera</td><td>zobacz historie</td> <td>Edytuj </td> <td>Usuń</td>
                </tr>
PODGLADKLIENTOW;
                $sql = "SELECT account_number, balance, birthdate, joindate, users.name as fname, email, surname, code, cities.Name as city, id_accountant FROM `users` join cities on cities.ID = users.city WHERE type=1;";
                $result = $connect->query($sql);
                while($row=$result->fetch_assoc())
                {
                  echo <<< PODGLADKLIENTOW
                  <tr class=withborder>
                    <td>$row[code]</td><td>$row[account_number]</td><td>$row[fname]</td><td>$row[surname]</td><td>$row[email]</td><td>$row[birthdate]</td><td>$row[joindate]</td><td>$row[city]</td><td>$row[id_accountant]</td><td><a href=admin_glowna.php?cl=Historia&user=$row[account_number]>historia</a> </td> <td><a href=admin_glowna.php?cl=edytujmenedzer&user=$row[account_number]>Edytuj</a> </td><td><a href=admin_delete.php?user=$row[account_number]>Usuń</a> </td>
                  </tr>

PODGLADKLIENTOW;
}
              break;


              case 'podgladmenegerow':
              echo <<< PODGLADMENEGEROW
              <div class="showclientsdiv">

              <table class="showclients">
                <tr class="withborder">
                  <td colspan="12"> <h1>
                     Menegerowie:</td></h1>
                </tr>
                <tr class="withborder">
                  <td>id</td><td>kod</td> <td>Imie</td><td>Nazwisko</td><td>mail</td><td>Data ur</td><td>Data dołączenia</td><td>miasto</td><td>Edytuj</td><td>Usuń</td>
                </tr>
PODGLADMENEGEROW;
                                $sql = "SELECT users.id as id, code, birthdate, joindate, users.name as 'fname', email, surname, account_number, cities.Name as 'city' FROM `users` join cities on cities.ID = users.city WHERE type = 2;";
                                $result = $connect->query($sql);
                                while($data=$result->fetch_assoc())
                                {
                                  echo <<< PODGLADMENEGEROW
                                  <tr class=withborder>
                                    <td>$data[id]</td><td>$data[code]</td><td>$data[fname]</td><td>$data[surname]</td><td>$data[email]</td><td>$data[birthdate]</td><td>$data[joindate]</td><td>$data[city]</td><td><a href=admin_glowna.php?cl=edytujmenedzer&user=$data[account_number]>Edytuj</a> </td><td><a href=admin_delete.php?user=$data[account_number]>Usuń</a> </td>
                                  </tr>
PODGLADMENEGEROW;
              }

              echo "</table>
              </div>";
                break;

                case 'Historia':
                if (!empty($_GET['user'])) {
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
                      onclick='location.href="admin_glowna.php?cl=podgladklientow"'>Powrót</button>
                      </td>
                      </tr>

                      </table>
                  </div>
                  HISTORY;
                }
                break;


                case 'edytujmenedzer':
                if (!empty($_GET['user'])) {
                  echo <<< MENEGEREDIT
                  <div class="showclientsdiv">

                  <table class="showclients">
                  <tr class=withborder>
                    <td>kod</td> <td>numer konta</td> <td>Imie</td><td>Nazwisko</td><td>mail</td><td>data ur</td><td>Data dołączenia</td><td>miasto</td>
                  </tr>
    MENEGEREDIT;
                  $id=$_GET['user'];
                  $sql = "SELECT account_number, balance, birthdate, joindate, users.name as fname, email, surname, code, cities.Name as city FROM `users` join cities on cities.ID = users.city WHERE account_number = '$id';";
                  $result = $connect->query($sql);
                  $data=$result->fetch_assoc();

                    echo <<< MENEGEREDIT
                    <tr class=withborder>
                      <td>$data[code]</td><td>$data[account_number]</td><td>$data[fname]</td><td>$data[surname]</td><td>$data[email]</td><td>$data[birthdate]</td><td>$data[joindate]</td><td>$data[city]</td>
                    </tr>
    MENEGEREDIT;
                  echo <<< MENEGEREDIT
                  <form action="admin_edit_meneger.php" method="post">

                  <tr class=withborder>
                    <td>$data[code]</td><td>$data[account_number]</td><td><input type="text" name="fname" value="$data[fname]"></td><td><input type="text" name="surname" value="$data[surname]"></td><td><input type="text" name="email" value="$data[email]"></td><td><input type="date" name="birthdate" value="$data[birthdate]"></td><td>$data[joindate]</td>
                    <td><select name="miejscowosc">
    MENEGEREDIT;

                    $sql = "SELECT id, Name FROM `cities` WHERE 1";
                    $result = $connect->query($sql);
                    while($row = $result->fetch_assoc())
                    {
                      echo "<option value=$row[id]>$row[Name]</option>";
                    }
                    echo <<< MENEGEREDIT
                    </select>
                     </td>
                  </tr>
                  <tr>
                  <input type="hidden" name="account_number" value="$data[account_number]">

                    <td colspan=9><input type="submit" name="submit" value="zatwierdz">
                    <button type="button" name="historia"
                    onclick='location.href="admin_glowna.php?cl=podgladmenegerow"'>Powrót</button></td>

                  </tr>
                  </form>
                  <tr>
                  <td colspan=9 style="color:red">
                  </td>
                  </tr>

                  </table>
                  </div>
MENEGEREDIT;

                }
                  break;

              default:
                break;
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
