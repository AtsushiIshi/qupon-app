<?php
session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="ok"){
  header('Location:index.php');
  exit;
}

$birthday=$_SESSION['cs_birthday'];
?>
<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>確認画面</title>
  <link rel="stylesheet" href="style.css">
</head>

<body id="page-layout">
  <header>
    <div >
      <h4>ヘッダーデザイン</h4>
    </div>
  </header>
  <main>
    <div>
      <h1><?php echo $_SESSION['cs_name'].' 様会員情報' ?></h1>
    </div>
    <table class="table-font">
      <tr>
        <td>お名前:</td>
        <td><?php echo $_SESSION['cs_name']; ?></td>
      </tr>
      <tr>
        <td>Eメール:</td>
        <td><?php echo $_SESSION['cs_email']; ?></td>
      </tr>
      <tr>
        <td>誕生日:</td>
        <td><?php if($birthday!=="0000-00-00"){echo date('Y', strtotime($birthday))."年".date('m', strtotime($birthday))."月".date('d', strtotime($birthday))."日";} ?></td>
      </tr>
      <tr>
        <td>お知らせを<br>メールに配信:</td>
        <td><?php if($_SESSION['notice_email']===1){echo "配信可";}else{echo "配信不可";} ?></td>
      </tr>
    </table>
    <a href="cs_info_update.php">会員情報を変更する</a>
    <a class="backtologin" href="cs_home.php">会員画面に戻る</a>
    <a class="backtologin" href="cs_withdrawal_confirmation.php">退会する</a>
    <footer>
      <p class="copyright">&copy; お店 All rights reserved.</p>
    </footer>
  </main>
</body>