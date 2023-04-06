<?php
  header('X-FRAME-OPTIONS:DENY');

  session_start();

  if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="ok"){
    header('Location:index.php');
    exit;
  }

  
  // DB設定要
  $err_msg="";

  if(isset($_POST['cs_withdrawal'])){
    $customer_password=$_POST['customer_password'];

  try{
    $pdo=new PDO($dsn, $user, $password);

    $stmt=$pdo->prepare("SELECT * FROM customer_list WHERE customer_id =?");    
    $stmt->execute(array($_SESSION['cs_id']));
    $result=$stmt->fetch();

    if($result['customer_password'] === $customer_password){
      $stmt = $pdo->prepare('DELETE FROM customer_list WHERE customer_password = ?');
      $stmt->bindValue(1, $customer_password);
      $stmt->execute();

      session_destroy();

      header('Location:cs_withdrawal_completion.php');
      exit;
      }else{
        $err_msg="パスワードが間違えています";
      }
   }catch (PDOException $e){
     exit($e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <title>会員様サイト</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css?ver=1.0.1">
</head>
<body id="page-layout">
  <header>
      <h4>ヘッダーデザイン</h4>
  </header>
    <main>
      <h2>パスワードの入力をお願い致します</h2>
      <form action="cs_withdrawal_confirmation.php" method="post">
        <label for="password" class="margin-right">パスワード</label>
        <input id="password" class="box" type="password" name="customer_password">
        <input class="registaration jpletter-space" type="submit" name="cs_withdrawal" value="退会">
      </form>
      <span><?php if($err_msg!==null && $err_msg!==""){echo $err_msg;} ?></span>
    </main>
  <footer id="footer">
    <p><small>&copy; お店 All rights reserved.</small></p>
  </footer>
</body>

</html>