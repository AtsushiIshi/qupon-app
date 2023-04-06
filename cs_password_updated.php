<?php
header('X-FRAME-OPTIONS:DENY');

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
    <div>
      <h4>ヘッダーデザイン</h4>
    </div>
  </header>
    <div class="main-title">
      <h1>パスワードを変更しました</h1>
    </div>
    <form class="backtologin" action="index.php">
      <input type="submit" value="ログイン画面に戻る">
    </form>
    <footer id="footer">
      <p><small>&copy; お店 All rights reserved.</small></p>
    </footer>
  </main>
</body>