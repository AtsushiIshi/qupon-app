<?php
// DB設定要

  $err_msg="";

  header('X-FRAME-OPTIONS:DENY');

if(isset($_POST['check_password'])){
  $birthday = $_POST['year']."-". $_POST['month']."-". $_POST['day'];

  try{
    $pdo=new PDO($dsn, $user, $password);

    $stmt=$pdo->prepare("SELECT * FROM customer_list WHERE customer_name =? and customer_birthday =?");    
    $stmt->execute(array($_POST['customer_name'], $birthday));
    $result=$stmt->fetch();

    if($result !== false){
      session_start();
      $_SESSION['cs_id']=$result['customer_id'];
      $_SESSION['flg']="okokokok";

      header('Location:cs_password.php');
      exit;
      }else{
        $err_msg="入力したお名前または選択した誕生日が誤りです";
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
        <div class="main-title">
              <h1>パスワード再設定</h1>
              <p>パスワード再設定するための本人確認が必要です<br>登録したお名前と登録した誕生日を入力してください</p>
        </div>
        <form class="newform" action="cs_fgt_p.php" method="post">
          <div>
            <label for="name" class="newlabel">登録したお名前 </label>
            <input id="name" class="textbox wd300" type="text" name="customer_name" min="0" max="30" required>
          </div>
            <div>
              <label class="newlabel">登録した誕生日</label>
                <div>
                  <select name="year" class="birth">
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
                  <select name="month" class="birth">
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
                  <select name="day" class="birth">
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
            <input class="registaration jpletter-space" type="submit" value="パスワード再設定" name="check_password">      
        </form>
        <span class="text-red"><?php if($err_msg!==null && $err_msg!==""){echo $err_msg;} ?></span>
        <form class="backtologin" action="index.php">
          <input type="submit" value="更新せずに戻る">
        </form>
      </main>
    <footer id="footer">
      <p><small>&copy; お店 All rights reserved.</small></p>
    </footer>
  </body>
</html>