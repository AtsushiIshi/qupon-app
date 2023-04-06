<?php
  header('X-FRAME-OPTIONS:DENY');
  session_start();

  if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="okok"){
    header('Location:index.php');
    exit;
  }

  // DB設定要

  if(isset($_POST['submit'])){

    try{
      $pdo=new PDO($dsn, $user, $password);
  
      $sql='
      INSERT INTO customer_list(customer_name,customer_email,customer_password,customer_birthday,notice_email)
      VALUES(:customer_name,:customer_email,:customer_password,:customer_birthday,:notice_email)
      ';

      $stmt=$pdo->prepare($sql);
  
      $stmt->bindValue(':customer_name',$_POST['customer_name'],PDO::PARAM_STR);
      $stmt->bindValue(':customer_email',$_POST['customer_email'],PDO::PARAM_STR);
      $stmt->bindValue(':customer_password',$_POST['customer_password'],PDO::PARAM_STR);
      $stmt->bindValue(':customer_birthday',$_POST['customer_birthday'],PDO::PARAM_STR);
      $stmt->bindValue(':notice_email',$_POST['notice_email'],PDO::PARAM_INT);

      $stmt->execute();
      header("Location: cs_info_regist_complete.php");

    }catch (PDOException $e){
      
      exit($e->getMessage());
  }
}

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
  <main>
    <div class="main-title">
      <h1>確認画面</h1>
    </div>
    <p>内容のご確認をお願い致します</p>
    <table class="table-font">
      <tr>
        <td>お名前:</td>
        <td><?php echo $_SESSION['newcs_name']; ?></td>
      </tr>
      <tr>
        <td>Eメール:</td>
        <td><?php echo $_SESSION['newcs_email']; ?></td>
      </tr>
      <tr>
        <td>誕生日:</td>
        <td><?php  if(isset( $_SESSION['newbirth_year'])&& isset( $_SESSION['newbirth_month']) && isset( $_SESSION['newbirth_day'])){echo $_SESSION['newbirth_year']."年".$_SESSION['newbirth_month']."月". $_SESSION['newbirth_day']."日";} ?></td>
      </tr>
      <tr>
        <td>お知らせを<br>メールに配信:</td>
        <td><?php if($_SESSION['newnotice_email']==="0"){echo "配信可";}else{echo "配信不可";} ?></td>
      </tr>
    </table>
    <form action="cs_info_regist_confirm.php" method="post">
      <input type="hidden" name="customer_name" value="<?php echo $_SESSION['newcs_name'] ?>">
      <input type="hidden" name="customer_email" value="<?php echo $_SESSION['newcs_email']?>">
      <input type="hidden" name="customer_password" value="<?php echo $_SESSION['newcs_password'] ?>">
      <input type="hidden" name="customer_birthday" value="<?php echo $_SESSION['newbirth_year']."-". $_SESSION['newbirth_month']."-". $_SESSION['newbirth_day'];?>">
      <input type="hidden" name="notice_email" value="<?php echo $_SESSION['newnotice_email'] ?>">
      <input class="registaration jpletter-space" type="submit" value="登録" name="submit">
    </form>
    <form action="cs_info_regist.php">
      <input class="jpletter-space back" type="submit" value="内容を編集する">
    </form>
    <footer id="footer">
      <p><small>&copy; お店 All rights reserved.</small></p>
    </footer>
  </main>
</body>