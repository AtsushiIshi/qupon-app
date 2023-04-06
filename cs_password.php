<?php
header('X-FRAME-OPTIONS:DENY');

session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="okokokok"){
  header('Location:index.php');
  exit;
}

// DB設定要

$err_msg="";
$cs_id = $_SESSION['cs_id'];

if(isset($_POST['check'])){

try{
  $pdo=new PDO($dsn, $user, $password);

  $stmt=$pdo->prepare("SELECT * FROM customer_list WHERE customer_id =?");    
  $stmt->execute(array($cs_id));
  $result=$stmt->fetch();
  
    if($_POST['password1']===$_POST['password2']){

      $sql_update='
            UPDATE customer_list
            SET customer_password = :customer_password
            WHERE customer_id = :customer_id
          ';
      
      $stmtu = $pdo->prepare($sql_update);

      $stmtu->bindValue(':customer_password',$_POST['password1'],PDO::PARAM_STR);
      $stmtu->bindValue(':customer_id',$cs_id, PDO::PARAM_INT);
      
      $stmtu->execute();   

      header('Location:cs_password_updated.php');
      exit;
    }else{
      $err_msg="パスワードが一致していません";
    }
    }catch (PDOException $e){
      exit($e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>会員情報変更</title>
  <link rel="stylesheet" href="style.css">
</head>
<body id="page-layout">
  <header>
    <div id="home-top">
      <h4>ヘッダーデザイン</h4>
    </div>
  </header>
    <div id="main-top">
      <h1>パスワード再設定</h1>
    </div>
    <p>新しいパスワードを入力してください</p>
    <span class="text-red"><?php if($err_msg!==null && $err_msg!==""){echo $err_msg;} ?></span>
    <form class="newform" action="cs_password.php" method="post">
        <div>
          <table>
            <tr>
              <td class="text-right">
                <label for="password" class="margin-right">新しいパスワード</label>
              </td>
              <td>
                <input class="box" type="password" name="password1" required>
              </td>
            </tr>
            <tr>
              <td class="text-right">
                <label for="password" class="margin-right">パスワード再入力</label>
              </td>
              <td>
                <input class="box" type="password" name="password2" required>
              </td>
            </tr>
            </td>
          </table>
          </div>
        </div>
        <input class="checkcontent" type="submit" value="更新" name="check">
    </form>
    <div >
    <form class="backtologin" action="index.php">
      <input type="submit" value="更新せずに戻る">
    </form>
    <footer>
      <p class="copyright">&copy; お店 All rights reserved.</p>
    </footer>
</body>
</body>
</html>