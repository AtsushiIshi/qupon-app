<?php
session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="okokok"){
  header('Location:sf_login.php');
  exit;
}

if(isset($_POST['logout'])){
  header("Location: sf_logout.php");
}elseif(isset($_POST['maintain'])){
  header("Location: sf_home.php");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログアウト</title>
  <link rel="stylesheet" href="style.css">
</head>
<body id="page-layout">
  <header>
    <div>
      <h4>ヘッダーデザイン</h4>
    </div>
  </header>
  <p>Logout？</p>
  <form action="sf_logout_confirmation.php" method="post">
    <input type="submit" name="logout" value="YES">
    <input type="submit" name="maintain" value="No">
  </form>
</body>
</html>