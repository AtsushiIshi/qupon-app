<?php
session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="okokok"){
  header('Location:sf_login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logout completed</title>
  <link rel="stylesheet" href="style.css">
</head>

<body id="page-layout">
  <header>
    <div>
      <p>Logout completed</p>
    </div>
  </header>
  <a href="sf_login.php">Back to login</a>
<body>
</html>