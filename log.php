<?php
  session_start();
  if(empty($_POST["code"]) ){
    header("location: ./logowanie.php?error='Podaj login'");
  }
  else {
    if (empty($_POST["haslo"])) {
      header("location: ./logowanie.php?error='Podaj haslo'");
    }
  }
  require_once './connect.php';


$login = strip_tags($_POST["login"]);
$password = $_POST["haslo"];
if (!preg_match('/^[0-9]{0,11}/', $login)) {
header("location:logowanie.php?error=błędny login");
exit();
}

$sql = "SELECT password, code, type FROM `users` WHERE code='$login'; ";

$result = $connect->query($sql);
$row=$result->fetch_assoc();
$connect->close();

$_SESSION['code']=$row['code'];
$_SESSION['type']=$row['type'];
if(password_verify($password, $row['password']))
{
  switch ($row['type']) {
    case '1':
    header("location: ./klient_glowna.php");
      break;
    case '2':
    header("location: ./menedzer_glowna.php");
      break;
    case '3':
      header("location: ./admin_glowna.php");
      break;

    default:
      header("location: ./logowanie.php?error=bląd konta");
      break;
  }


}
else{
  header("location: ./logowanie.php?error='Nieprawidlowe dane'");
}
  echo "<h1 color:'red'> nie dziala </h1>";




 ?>
