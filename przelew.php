<?php
session_start();
if (!isset($_SESSION['code']) || $_SESSION['type']!=1) {
  session_destroy();
  header("location:logowanie.php?error=Najpierw zaloguj się!");
}
if (!isset($_POST['transferTitle']) || empty($_POST['transferTitle'])) {
  header("location:klient_glowna.php?cl=wykonajprzelew&error=Podaj tytul przelewu");
}elseif (!isset($_POST['accountName']) || empty($_POST['accountName'])) {
  header("location:klient_glowna.php?cl=wykonajprzelew&error=Podaj imie i nazwisko odbiorcy");
}elseif (!isset($_POST['accountNumber']) || empty($_POST['accountNumber'])) {
  header("location:klient_glowna.php?cl=wykonajprzelew&error=Podaj numer konta");
}elseif (!isset($_POST['transferValue']) || empty($_POST['transferValue'])) {
  header("location:klient_glowna.php?cl=wykonajprzelew&error=Podaj kwotę");
}elseif (!isset($_POST['code']) || empty($_POST['code'])) {
  header("location:klient_glowna.php?cl=wykonajprzelew&error=Błąd konta");
}
else{

$title=strip_tags($_POST['transferTitle']);
$name = strip_tags($_POST['accountName']);
$receiverNr = strip_tags($_POST['accountNumber']);
$senderCode = strip_tags($_POST['code']);
$value = strip_tags($_POST['transferValue']);

  if (!preg_match('/^[0-9]{0,11}[\.]?[0-9]{0,2}/', $_POST['transferValue'])) {
header("location:klient_glowna.php?cl=wykonajprzelew&error=Podaj poprawną kwotę");
exit();
}
if (!preg_match('/^[0-9]{0,11}/', $receiverNr)) {
header("location:klient_glowna.php?cl=wykonajprzelew&error=Podaj poprawny numer konta odbiorcy");
exit();
}
// sprawdzanie kwoty
  require_once './connect.php';
  $sql = "SELECT balance, account_number
  FROM `users` WHERE code='$senderCode'";
  $result = $connect->query($sql);
  $row = $result->fetch_assoc();
  $senderNr = $row['account_number'];
  if ($value <=0) {
    header("location: klient_glowna.php?cl=wykonajprzelew&error=Nieprawidlowa kwota \: \n");
     $connect->close();
    exit();
  }
  if ($row['balance'] - $value <0) {
     $connect->close();
    header("location: klient_glowna.php?cl=wykonajprzelew&error=Nieprawidlowa kwota, za mało pieniędzy na koncie \:");
    exit();
  }
  // Dodawanie do konta recivera (numer rachunku)
  $sql =
"UPDATE `users` SET `balance` = (
    SELECT balance FROM users
    WHERE `users`.`account_number` = $receiverNr) + $value
WHERE `users`.`account_number` = $receiverNr;";

$connect->query($sql);
if($connect->affected_rows){
  // odejmowanie od konta sendera (nr rachunku)
    $sql =
      "UPDATE `users` SET `balance` = (
          SELECT balance FROM users
          WHERE `users`.`account_number` = $senderNr) - $value
      WHERE `users`.`account_number` = $senderNr;";
      $connect->query($sql);
      if($connect->affected_rows){
        // tabela historia przelewow
//     $sql="INSERT INTO `users` (`id`, `ID_city`, `name`, `surname`, `birthdate`) VALUES (NULL, '$_POST[cityid]', '$_POST[name]', '$_POST[surname]','$_POST[birthdate]') ";

          $sql =
          "INSERT INTO `transactions`(
    `id_transaction`,
    `sender_account`,
    `receiver_account`,
    `title`,
    `receiver_name`,
    `date`,
    `value`
)
VALUES(
    NULL,
    '$senderNr',
    '$receiverNr',
    '$title',
    '$name',
    NULL,
    '$value'
);";
          $connect->query($sql);
          if($connect->affected_rows){
          $connect->close();
          header("location: ./klient_glowna.php?cl=wykonajprzelew&error=Operacja przebiegla pomyslnie");
          exit();
      }}else{
        echo "Operacja nieudana, ściągnięto pieniądze z konta, skontaktuj się z menegerem";
        exit();
      }
      echo "Operacja nieudana, nie ściągnięto pieniędzy z konta";
      exit();
}
}

header("location: ./klient_glowna.php?cl=wykonajprzelew&error=Wprowadzono nieprawidłowe dane");
 ?>
