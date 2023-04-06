<?php
header('X-FRAME-OPTIONS:DENY');
session_start();
$cs_id = $_SESSION['cs_id'];

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="ok"){
  header('Location:index.php');
  exit;
}

// DB設定要

$err_msg="";

if(isset($_POST['check'])){

try{
  $pdo=new PDO($dsn, $user, $password);

  $stmt=$pdo->prepare("SELECT * FROM customer_list WHERE customer_id =?");    
  $stmt->execute(array($cs_id));
  $result=$stmt->fetch();

  $stmtc=$pdo->prepare("SELECT * FROM customer_list WHERE customer_email =?");    
  $stmtc->execute(array($_POST['customer_email']));
  $resultc=$stmtc->fetch();
  
    if($resultc !== false && $resultc['customer_id'] !== $result['customer_id']){
      $err_msg="入力いただいたメールアドレスは既に会員登録されています";
      }else{
      $birthday = $_POST['year']."-". $_POST['month']."-". $_POST['day'];

      $sql_update='
            UPDATE customer_list
            SET customer_name = :customer_name, 
            customer_email = :customer_email, 
            customer_birthday = :customer_birthday,
            notice_email = :notice_email
            WHERE customer_id = :customer_id
          ';
      
      $stmtu = $pdo->prepare($sql_update);

      $stmtu->bindValue(':customer_name',$_POST['customer_name'],PDO::PARAM_STR);
      $stmtu->bindValue(':customer_email',$_POST['customer_email'],PDO::PARAM_STR);
      $stmtu->bindValue(':customer_birthday',$birthday, PDO::PARAM_STR);
      $stmtu->bindValue(':notice_email',$_POST['notice_email'],PDO::PARAM_INT);
      $stmtu->bindValue(':customer_id',$cs_id, PDO::PARAM_INT);
      
      $stmtu->execute();
      
      $_SESSION['cs_name']=$_POST['customer_name'];
      $_SESSION['cs_email']=$_POST['customer_email'];
      $_SESSION['cs_birthday']=$birthday;
      $_SESSION['notice_email']=$_POST['notice_email'];
      $_SESSION['newbirth_year']=$_POST['year'];
      $_SESSION['newbirth_month']=$_POST['month'];
      $_SESSION['newbirth_day']=$_POST['day'];
      

      header('Location:cs_info_update_complete.php');
      exit;
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
      <h1>会員情報更新</h1>
    </div>
    <p>必要な箇所を変更してください</p>
    <span class="text-red"><?php if($err_msg!==null && $err_msg!==""){echo $err_msg;} ?></span>
    <form class="newform" action="cs_info_update.php" method="post">
        <div>
          <label class="newlabel">お名前（ニックネーム可)<span class="text-red">【必須】<span></label>
          <input class="textbox" type="text" name="customer_name" min="0" max="30" value="<?php echo $_SESSION['cs_name']; ?>" required>
        </div>
        <div>
          <label class="newlabel">Eメール <span class="text-red">【必須】<span></label>
          <input class="textbox" type="email" name="customer_email" min="0" max="60" value="<?php if(isset($_POST['customer_email'])){echo $_POST['customer_email'];}else{echo $_SESSION['cs_email'];} ?>" required>
        </div>
        <div>
          <label class="newlabel">誕生日<span class="text-red">【必須】<span></label>
            <div>
              <select name="year" class="birth" required>
                <?php if(isset($_SESSION['newbirth_year'])){echo "<option value = '{$_SESSION['newbirth_year']}' selected>{$_SESSION['newbirth_year']}</option>";} ?>
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
              <?php if(isset($_SESSION['newbirth_month'])){echo "<option value = '{$_SESSION['newbirth_month']}' selected>{$_SESSION['newbirth_month']}</option>";} ?>
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
              <?php if(isset($_SESSION['newbirth_day'])){echo "<option value = '{$_SESSION['newbirth_day']}' selected>{$_SESSION['newbirth_day']}</option>";} ?>
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
        <div class="message">
          <label class="newlabel">お知らせをEメールに配信<span class="text-red">【必須】<span></label>
          <div class="noticemail">
            <div class="checknotice">
              <input type="radio" name="notice_email" value="0" <?php if($_SESSION['notice_email']=="0")echo 'checked'; ?> >配信可
            </div>
            <div>
              <input type="radio" name="notice_email" value="1" <?php if($_SESSION['notice_email']=="1")echo 'checked' ?> >配信不可
            </div>

          </div>
        </div>
        <input class="checkcontent" type="submit" value="更新" name="check">
    </form>
    <div >
    <form class="backtologin" action="cs_home.php">
      <input type="submit" value="会員画面に戻る">
    </form>
    <footer>
      <p class="copyright">&copy; お店 All rights reserved.</p>
    </footer>
</body>
</body>
</html>