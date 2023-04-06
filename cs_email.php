<?php
session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="okokok"){
  header('Location:index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>会員様サイト</title>
  <link rel="stylesheet" href="style.css">
</head>
<body id="page-layout">
  <header>
    <div id="home-top">
      <h4>ヘッダーデザイン</h4>
    </div>
  </header>
    <main>
        <div id="main-top">
          <h1><?php echo $_SESSION['customer_name'].'様のメールアドレスは' ?></h1>
        </div>
        <div>
          <h1><?php echo $_SESSION['cs_email'] ?></h1>
        </div>
        <div>
          <h1>です</h1>
        </div>
        <a class="backtologin" href="index.php">ログイン画面に戻る</a>
    </main>
  <footer>
    <p class="copyright">&copy; お店 All rights reserved.</p>
  </footer>
</body>

</html>