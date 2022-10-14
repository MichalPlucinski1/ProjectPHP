<?php
session_start();
if (!isset($_SESSION['code']) ||  $_SESSION['type']!=3) {
  session_destroy();
  header("location:logowanie.php?error=Najpierw zaloguj się!");
  exit();
}

if (empty($_POST['name']) || !isset($_POST['name'])) {
  header("location: ./admin_glowna.php?cl=dodajklienta&error=Podaj imie");
  exit();
}elseif (empty($_POST['surname']) || !isset($_POST['surname'])) {
  header("location: ./admin_glowna.php?cl=dodajklienta&error=Podaj nazwisko");
  exit();
}elseif (empty($_POST['email']) || !isset($_POST['email'])) {
  header("location: ./admin_glowna.php?cl=dodajklienta&error=Podaj email");
  exit();
}elseif (empty($_POST['dataur']) || !isset($_POST['dataur'])) {
  header("location: ./admin_glowna.php?cl=dodajklienta&error=Podaj date urodzenia");
  exit();
}elseif (empty($_POST['miejscowosc']) || !isset($_POST['miejscowosc'])) {
  header("location: ./admin_glowna.php?cl=dodajklienta&error=Podaj miejscowosc");
  exit();
}
require_once './connect.php';
require_once 'password_generator.php';
$name =$_POST['name'];
$surname = $_POST['surname'];
$email = strtolower($_POST['email']);
$birthdate = $_POST['dataur'];
$city = $_POST['miejscowosc'];
$code = 0;
$account_number = 0;
$id_menegera = $_POST['id_accountant'];
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
    $mail->Body = "<b>Witaj $name<br>Twoje dane do logowania: nr konta:$account_number, login:$code, haslo:$password</b>";
    $mail->send();
    $connect->close();
    header("location: ./admin_glowna.php?cl=dodajklienta&error=Poprawnie dodano usera");
    exit();
  } catch (Exception $e) {
    header("location: ./admin_glowna.php?cl=dodajklienta&error=Błąd wysyłania maila, dodano usera");
  }


}
else {
  header("location: ./admin_glowna.php?cl=dodajklienta&error=Nie dodano usera");
  $connect->close();
}

 ?>
