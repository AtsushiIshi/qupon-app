<?php
session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="ok"){
  header('Location:index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>会員様ページ</title>
  <link rel="stylesheet" href="style.css">
</head>
<body id="page-layout">
  <header>
    <div id="home-top">
      <h4>ヘッダーデザイン</h4>
    </div>
  </header>
  <h2><?php echo $_SESSION['cs_name'].'様会員画面' ?></h2>
  <div>
    <a class="cmainmenu fontxl" href="">お知らせ</a>
  </div>
  <div>
  <a class="cmainmenu fontxl" href="cs_id.php">お客様のID</a>
  </div>
  <div>
    <a class="cmainmenu fontxl" href="cs_qupon.php">クーポン確認・使用</a>
  </div>
  <div>
    <a class="cmainmenu fontl" href="">マイルストーン</a>
  </div>
  <div>
    <a class="cmainmenu fontl" href="cs_info.php">会員情報</a>
  </div>
  <div>
    <a class="cmainmenu fontl" href="cs_logout_confirmation.php">ログアウト</a>
  </div>
  <footer>
    <p class="copyright">&copy; お店 All rights reserved.</p>
  </footer>
</body>
</html>