<?php
  // DB設定要
  
  $err_msg="";

  header('X-FRAME-OPTIONS:DENY');
  
if(isset($_POST['login'])){
  $customer_email=$_POST['customer_email'];
  $customer_password=$_POST['customer_password'];

  try{
    $pdo=new PDO($dsn, $user, $password);

    $stmt=$pdo->prepare("SELECT * FROM customer_list WHERE customer_email =? and customer_password=?");    
    $stmt->execute(array($customer_email,$customer_password));
    $result=$stmt->fetch();

    if($result !=false){

      session_start();
      $_SESSION['cs_email']=$customer_email;
      $_SESSION['cs_id']=$result['customer_id'];
      $_SESSION['cs_name']=$result['customer_name'];
      $_SESSION['cs_birthday']=$result['customer_birthday'];
      $_SESSION['notice_email']=$result['notice_email'];
      $_SESSION['flg']="ok";

      header('Location:cs_home.php');
      exit;
      }else{
        $err_msg="メールアドレスまたはパスワードが誤りです";
      }
   }catch (PDOException $e){
     exit($e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html lang="jp">


<body id="page-layout">
  <header>
      <h4>ヘッダーデザイン</h4>
  </header>
    <main>
        <div class="main-title">
          <h1>会員様ログイン</h1>
          <p class="message">ご来店どうもありがとうございます</p>
          <p>日頃お世話になっている会員様に<br>感謝としまして様々な特別割引を<br>ご提供させていただきます</p>
        </div>
         <!-- 新規登録  -->
        <form action="cs_info_regist.php">
          <input class="registaration jpletter-space" type="submit" value="新規会員登録">
        </form>

        <!-- ログイン -->
        <form action="index.php" method="post">
          <table class="table-font">
            <tr>
              <td class="text-right">
                <label for="email" class="margin-right">メールアドレス</label>
              </td>
              <td>
                <input id="email" class="box" type="email" name="customer_email" required>
              </td>
            </tr>
            <tr>
              <td class="text-right">
                <label for="password" class="margin-right">パスワード</label>
              </td>
              <td>
                <input id="password" class="box" type="password" name="customer_password" required>
              </td>
            </tr>
          </table>
          <input class="registaration jpletter-space" type="submit" value="ログイン" name="login">      
        </form>
        <span class="text-red"><?php if($err_msg!==null && $err_msg!==""){echo $err_msg;} ?></span>
        <div class="large-text">
          <p><a href="cs_fgt_e.php">メールアドレスをお忘れのお客様</a></p>
          <p><a href="cs_fgt_p.php">パスワードをお忘れのお客様</a></p>
        </div>
    </main>
  <footer id="footer">
    <p><small>&copy; お店 All rights reserved.</small></p>
  </footer>
</body>

</html>