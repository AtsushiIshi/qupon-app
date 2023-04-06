<?php
session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="ok"){
  header('Location:index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログアウト完了</title>
  <link rel="stylesheet" href="style.css">
</head>

<body id="page-layout">
  <header>
    <div>
      <p>ログアウトが完了しました</p>
    </div>
  </header>
  <a href="index.php">ログイン画面に戻る</a>
<body>
</html>