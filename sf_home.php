<?php
session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']=="okokok"){
  header('Location:sf_login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>会員様ページ</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div id="home-top">
      <h4>ヘッダーデザイン</h4>
    </div>
  </header>
  <main>
    <h2><?php echo $_SESSION['staff_name'].'' ?></h2>
    <div>
      <a class="cmainmenu fontxl" href="payment.php">Payment</a>
    </div>
    <div>
      <a class="cmainmenu fontxl" href="qupon_manage.php">Qupon</a>
    </div>
    <div>
      <a class="cmainmenu fontl" href="#">Sales</a>
    </div>
    <div>
      <a class="cmainmenu fontl" href="#">Milestone</a>
    </div>
    <div>
      <a class="cmainmenu fontl" href="sf_info.php">account info</a>
    </div>
    <div>
      <a class="cmainmenu fontl" href="sf_logout_confirmation.php">logout</a>
    </div>
    <footer id="footer">
      <p><small>&copy; お店 All rights reserved.</small></p>
    </footer>
</body>

</html>