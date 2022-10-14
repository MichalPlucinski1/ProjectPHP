<?php

session_start();
if (!isset($_SESSION['code']) || $_SESSION['type']!=2 &&  $_SESSION['type']!=3) {
  session_destroy();
  header("location:logowanie.php?error=Najpierw zaloguj się!");
  exit();
}

$account_number = $_POST['account_number'];
if (empty($_POST['fname']) || !isset($_POST['fname'])) {
  header("location: ./admin_glowna.php?cl=edytujmenedzer&error=Podaj imie&user=$account_number");
  exit();
}elseif (empty($_POST['surname']) || !isset($_POST['surname'])) {
  header("location: ./admin_glowna.php?cl=edytujmenedzer&error=Podaj nazwisko&user=$account_number");
  exit();
}elseif (empty($_POST['email']) || !isset($_POST['email'])) {
  header("location: ./admin_glowna.php?cl=edytujmenedzer&error=Podaj email&user=$account_number");
  exit();
}elseif (empty($_POST['birthdate']) || !isset($_POST['birthdate'])) {
  header("location: ./admin_glowna.php?cl=edytujmenedzer&error=Podaj date urodzenia&user=$account_number");
  exit();
}elseif (empty($_POST['miejscowosc']) || !isset($_POST['miejscowosc'])) {
  header("location: ./admin_glowna.php?cl=edytujmenedzer&error=Podaj miejscowosc&user=$account_number");
  exit();
}
require_once './connect.php';
$name =$_POST['fname'];
$surname = $_POST['surname'];
$email = strtolower($_POST['email']);
$birthdate = $_POST['birthdate'];
$city = $_POST['miejscowosc'];
$account_number = $_POST['account_number'];

$sql = "UPDATE
    `users`
SET
    `name` = '$name',
    `surname` = '$surname',
    `birthdate` = '$birthdate',
    `city` = '$city',
    `email` = '$email'
WHERE
    `users`.`account_number` = $account_number";


if ($connect->query($sql)) {
    $connect->close();
    header("location: ./admin_glowna.php?cl=PodgladKlientow&error=Poprawnie edytowano usera&user=");
    exit();
  }
  else {
    $connect->close();
    header("location: ./admin_glowna.php?cl=edytuj&error=Nie wyedytowano usera&user=$account_number");
    exit();
  }
 ?>
