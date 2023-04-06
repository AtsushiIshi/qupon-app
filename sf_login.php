<?php

header('X-FRAME-OPTIONS:DENY');

// DB設定要
$err_msg="";

if(isset($_POST['login'])){
$staff_login_id=$_POST['login_id'];
$staff_password=$_POST['staff_password'];

  try{
    $pdo=new PDO($dsn, $user, $password);

    $stmt=$pdo->prepare("SELECT * FROM staff_list WHERE staff_login_id =? and staff_password=?");    
    $stmt->execute(array($staff_login_id, $staff_password));
    $result=$stmt->fetch();

    if($result !== false){
      session_start();
      $_SESSION['staff_no']=$result['staff_no'];
      $_SESSION['staff_email']=$result['staff_email'];
      $_SESSION['staff_login_id']=$result['staff_login_id'];
      $_SESSION['staff_name']=$result['staff_name'];
      $_SESSION['flg']="okokok";
      
      header('Location:sf_home.php');

    }else{
      $err_msg="Login ID or password is wrong";
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
  <title>Staff login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css?ver=1.0.1">
</head>
<body id="page-layout">
  <header >
      <h4>Header design</h4>
  </header>
    <main>
        <div class="main-title">
          <h1>Staff Login</h1>
        </div>

         <!-- New registration  -->
        <form action="sf_info_regist.php">
          <input class="registaration enletter-space" type="submit" value="Registration">
        </form>

        <!-- Login -->
        <form action="sf_login.php" method="post">
          <table class="table-font">
            <tr>
              <td class="text-right">
                <label for="login_id" class="margin-right">Login ID</label>
              </td>
              <td>
                <input id="login_id" class="box large-text" type="text" name="login_id" required>
              </td>
            </tr>
            <tr>
              <td class="text-right">
                <label for="password" class="margin-right">Password</label>
              </td>
              <td>
                <input id="password" class="box large-text" type="password" name="staff_password" required>
              </td>
            </tr>
          </table>
          <input class="registaration enletter-space" type="submit" value="login" name="login">      
        </form>
        <span><?php if($err_msg!==null && $err_msg!==""){echo $err_msg;} ?></span>
        <div class="large-text">
          <p><a href="">Forgot your ID?</a></p>
          <p><a href="">Forgot your password?</a></p>
        </div>
    </main>
  <footer id="footer">
    <p><small>&copy; お店 All rights reserved.</small></p>
  </footer>
</body>

</html>