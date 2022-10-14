<?php
session_start();
if (!isset($_SESSION['code']) || $_SESSION['type']!=2 &&  $_SESSION['type']!=3) {
  session_destroy();
  header("location:logowanie.php?error=Najpierw zaloguj się!");
  exit();
}
 if (isset($_GET['user']) && !empty($_GET['user'])) {
   require_once './connect.php';
   $sql = "DELETE FROM `users` WHERE `users`.`account_number` = '$_GET[user]'";
   if ($connect->query($sql)) {
     $connect->close();
     header("location: ./menedzer_glowna.php?cl=PodgladKlientow&error=Poprawnie usunięto użytkownika $_GET[user]");
     exit();
   }
   else{
     $connect->close();
     header("location: ./menedzer_glowna.php?cl=PodgladKlientow&error= Nie usunieto użytkownika $_GET[user]");
     exit();
   }

 }
 header("location: ./menedzer_glowna.php");
 exit();
 ?>
