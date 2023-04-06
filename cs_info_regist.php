<?php
header('X-FRAME-OPTIONS:DENY');

// DB設定要

$err_msg="";

if(isset($_POST['check'])){
$customer_email=$_POST['customer_email'];

try{
  $pdo=new PDO($dsn, $user, $password);

  $stmt=$pdo->prepare("SELECT * FROM customer_list WHERE customer_email =?");    
  $stmt->execute(array($customer_email));
  $result=$stmt->fetch();

  if($result['customer_email'] !== $customer_email){
    session_start();
    $_SESSION['newcs_email']=$customer_email;
    $_SESSION['newcs_name']=$_POST['customer_name'];
    $_SESSION['newbirth_year']=$_POST['year'];
    $_SESSION['newbirth_month']=$_POST['month'];
    $_SESSION['newbirth_day']=$_POST['day'];
    $_SESSION['newcs_password']=$_POST['customer_password'];
    $_SESSION['newnotice_email']=$_POST['notice_email'];
    $_SESSION['flg']="okok";

    header('Location:cs_info_regist_confirm.php');
    exit;
    }else{
      $err_msg="入力いただいたメールアドレスは既に会員登録されています";
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
  <title>新規会員登録</title>
  <link rel="stylesheet" type="text/css" href="style.css?ver=1.0.1">
</head>
<body id="page-layout">
  <header>
    <div>
      <h4>ヘッダーデザイン</h4>
    </div>
  </header>
    <div class="main-title">
      <h1>新規会員登録</h1>
    </div>
    <form class="newform" action="cs_info_regist.php" method="post">
        <div>
          <label for="name" class="newlabel">お名前（ニックネーム可) <span class="text-red">【必須】<span></label>
          <input id="name" class="textbox wd300" type="text" name="customer_name" min="0" max="30" value="<?php if(isset($_POST['customer_name'])){echo $_POST['customer_name'];} ?>" required>
        </div>
        <div>
          <label for="email" class="newlabel">Eメール <span class="text-red">【必須】</span></label>
          <input id="email" class="textbox wd300" type="email" name="customer_email" min="0" max="60" value="<?php if(isset($_POST['customer_email'])){echo $_POST['customer_email'];} ?>" required>
        </div>
        <div>
          <label class="newlabel">誕生日<span class="text-red">【必須】</span></label>
            <div>
            <select name="year" class="birth" required>
              <?php if(isset($_POST['year'])){echo "<option value = '{$_POST['year']}' selected>{$_POST['year']}</option>";} ?>
                <option value=""></option>
                <option value="1940">1940</option>
                <option value="1941">1941</option>
                <option value="1942">1942</option>
                <option value="1943">1943</option>
                <option value="1944">1944</option>
                <option value="1945">1945</option>
                <option value="1946">1946</option>
                <option value="1947">1947</option>
                <option value="1948">1948</option>
                <option value="1949">1949</option>
                <option value="1950">1950</option>
                <option value="1951">1951</option>
                <option value="1952">1952</option>
                <option value="1953">1953</option>
                <option value="1954">1954</option>
                <option value="1955">1955</option>
                <option value="1956">1956</option>
                <option value="1957">1957</option>
                <option value="1958">1958</option>
                <option value="1959">1959</option>
                <option value="1960">1960</option>
                <option value="1961">1961</option>
                <option value="1962">1962</option>
                <option value="1963">1963</option>
                <option value="1964">1964</option>
                <option value="1965">1965</option>
                <option value="1966">1966</option>
                <option value="1967">1967</option>
                <option value="1968">1968</option>
                <option value="1969">1969</option>
                <option value="1970">1970</option>
                <option value="1971">1971</option>
                <option value="1972">1972</option>
                <option value="1973">1973</option>
                <option value="1974">1974</option>
                <option value="1975">1975</option>
                <option value="1976">1976</option>
                <option value="1977">1977</option>
                <option value="1978">1978</option>
                <option value="1979">1979</option>
                <option value="1980">1980</option>
                <option value="1981">1981</option>
                <option value="1982">1982</option>
                <option value="1983">1983</option>
                <option value="1984">1984</option>
                <option value="1985">1985</option>
                <option value="1986">1986</option>
                <option value="1987">1987</option>
                <option value="1988">1988</option>
                <option value="1989">1989</option>
                <option value="1990">1990</option>
                <option value="1991">1991</option>
                <option value="1992">1992</option>
                <option value="1993">1993</option>
                <option value="1994">1994</option>
                <option value="1995">1995</option>
                <option value="1996">1996</option>
                <option value="1997">1997</option>
                <option value="1998">1998</option>
                <option value="1999">1999</option>
                <option value="2000">2000</option>
                <option value="2001">2001</option>
                <option value="2002">2002</option>
                <option value="2003">2003</option>
              </select> 年
              <select name="month" class="birth" required>
                <?php if(isset($_POST['month'])){echo "<option value = '{$_POST['month']}' selected>{$_POST['month']}</option>";} ?>
                <option value=""></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select> 月
              <select name="day" class="birth" required>
                <?php if(isset($_POST['day'])){echo "<option value = '{$_POST['day']}' selected>{$_POST['day']}</option>";} ?>
                <option value=""></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
              </select> 日
            </div>
        </div>
        <div>
          <label for="password" class="newlabel">パスワード<span class="text-red">【必須】<span></label>
          <input id="password" class="textbox wd300" type="password" name="customer_password" required value="<?php if(isset($_POST['customer_password'])){echo $_POST['customer_password'];} ?>">
        </div>
        <div class="message">
          <label class="newlabel">お知らせをEメールに配信<span class="text-red">【必須】<span></label>
              <input type="radio" id="can" name="notice_email" checked value="0" <?php if(isset($_POST['notice_email']) && ($_POST['notice_email']==="0")){echo 'checked';} ?>><label for="can">配信可</label>
              <input type="radio" id="cannot" name="notice_email" value="1" <?php if(isset($_POST['notice_email']) && ($_POST['notice_email']==="1")){echo 'checked';} ?>><label for="cannot">配信不可</label>
        </div>
        <input class="registaration jpletter-space newform" type="submit" value="登録内容確認" name="check">
    </form>
    <div>
    <span class="text-red"><?php if($err_msg!==null && $err_msg!==""){echo $err_msg;} ?></span>
    </div>
    <form action="index.php">
      <input class="jpletter-space back" type="submit" value="ログイン画面に戻る">
    </form>
    <footer id="footer">
      <p><small>&copy; お店 All rights reserved.</small></p>
    </footer>
</body>
</html>