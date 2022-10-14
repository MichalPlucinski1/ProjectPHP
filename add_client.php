<?php
session_start();
if (!isset($_SESSION['code']) || $_SESSION['type']!=2) {
  session_destroy();
  header("location:logowanie.php?error=Najpierw zaloguj się!");
  exit();
}

if (empty($_POST['name']) || !isset($_POST['name'])) {
  header("location: ./menedzer_glowna.php?cl=DodajKlienta&error=Podaj imie");
  exit();
}elseif (empty($_POST['surname']) || !isset($_POST['surname'])) {
  header("location: ./menedzer_glowna.php?cl=DodajKlienta&error=Podaj nazwisko");
  exit();
}elseif (empty($_POST['email']) || !isset($_POST['email'])) {
  header("location: ./menedzer_glowna.php?cl=DodajKlienta&error=Podaj email");
  exit();
}elseif (empty($_POST['dataur']) || !isset($_POST['dataur'])) {
  header("location: ./menedzer_glowna.php?cl=DodajKlienta&error=Podaj date urodzenia");
  exit();
}elseif (empty($_POST['miejscowosc']) || !isset($_POST['miejscowosc'])) {
  header("location: ./menedzer_glowna.php?cl=DodajKlienta&error=Podaj miejscowosc");
  exit();
}
require_once './connect.php';
require_once 'password_generator.php';
$name =strip_tags($_POST['name']);
$surname = strip_tags($_POST['surname']);
$email = strtolower($_POST['email']);
$birthdate = strip_tags($_POST['dataur']);
$city = strip_tags($_POST['miejscowosc']);
$code = 0;
$account_number = 0;
$id_menegera = strip_tags($_POST['id_accountant']);
$password = passwordGenerator1(4);
$hashedpassword = password_hash($password, PASSWORD_ARGON2ID);



do{
$sql ="select code from users where code in (select code from users where code =$code)";
$result = $connect->query($sql);
$row = $result->fetch_assoc();
$code = rand(1,99999);
}
while(!empty($row['code']));

do{
$sql ="select account_number from users where account_number in (select account_number from users where account_number =$account_number)";
$result = $connect->query($sql);
$row = $result->fetch_assoc();
$account_number = rand(1,99999);
}
while(!empty($row['account_number']));

$sql = "INSERT INTO `users`(
    `code`,
    `account_number`,
    `balance`,
    `name`,
    `surname`,
    `type`,
    `birthdate`,
    `password`,
    `city`,
    `email`,
    `id_accountant`
)
VALUES(
    '$code',
    '$account_number',
    0,
    '$name',
    '$surname',
    '1',
    '$birthdate',
    '$hashedpassword',
    '$city',
    '$email',
    '$id_menegera'
  )
";
if ($connect->query($sql)) {
  require_once 'mail.php';
  try {
    $mail->addAddress($email, $name);
    $mail->isHTML(true);
    $mail->Subject = 'ABank, dane do logowania';
    $mail->Body = "<b>Witaj $name<br>Twoje dane do logowania: nr konta:$account_number, login:$code, haslo: $password</b>";
    $mail->send();
    $connect->close();
    header("location: ./menedzer_glowna.php?cl=DodajKlienta&error=Poprawnie dodano usera");
    exit();
  } catch (Exception $e) {
    header("location: ./menedzer_glowna.php?cl=DodajKlienta&error=Błąd wysyłania maila, brak połączenia z internetem, dodano usera");
  }


}
else {
  header("location: ./menedzer_glowna.php?cl=DodajKlienta&error=Nie dodano usera");
  $connect->close();
}

 ?>
