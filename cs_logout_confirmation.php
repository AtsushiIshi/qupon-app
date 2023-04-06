<?php
session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="ok"){
  header('Location:index.php');
  exit;
}

if(isset($_POST['logout'])){
  header("Location: cs_logout.php");
}elseif(isset($_POST['maintain'])){
  header("Location: cs_home.php");
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
  <p>ログアウトしてよろしいですか？</p>
  <form action="cs_logout_confirmation.php" method="post">
    <input type="submit" name="logout" value="はい">
    <input type="submit" name="maintain" value="いいえ">
  </form>
</body>
</html>