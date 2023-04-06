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
    <h1>Qupon management</h1>

  <div>
    <table>
      <tr>
        <th>No</th>
        <th>Details</th>
        <th>Link</th>
      </tr>
      <tr>
        <td>1</td>
        <td>Monthly top sales</td>
        <td><a href="mts_setting.php">Manage</a></td>
      </tr>
      <tr>
        <td>2</td>
        <td>Birthday</td>
        <td><a href="btd_detail.php">Manage</a></td>
      </tr>
      <tr>
        <td>3</td>
        <td>Monthly top sales</td>
        <td><a href="mts_detail.php">Manage</a></td>
      </tr>
      <tr>
        <td>4</td>
        <td>Monthly top sales</td>
        <td><a href="mts_detail.php">Manage</a></td>
      </tr>
      <tr>
        <td>5</td>
        <td>Monthly top sales</td>
        <td><a href="mts_detail.php">Manage</a></td>
      </tr>
      <tr>
        <td>6</td>
        <td>Monthly top sales</td>
        <td><a href="mts_detail.php">Manage</a></td>
      </tr>
    </table>

  </div>


    <footer id="footer">
      <p><small>&copy; お店 All rights reserved.</small></p>
    </footer>
</body>

</html>