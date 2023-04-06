<?php
header('X-FRAME-OPTIONS:DENY');

// DB設定要
$err_msg="";
 

if(isset($_POST['check'])){
  $staff_email=$_POST['staff_email'];
  $staff_login_id=$_POST['login_id'];

  try{
    $pdo=new PDO($dsn, $user, $password);

    $sql_check ='SELECT * FROM staff_list WHERE staff_login_id =? AND staff_email=?';

    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check ->execute(array($staff_login_id,$staff_email));
    $result_check=$stmt_check->fetch();

      if($result_check['staff_login_id'] == false || $result_check['staff_email'] == false){

          $sql='
          INSERT INTO staff_list(staff_name, staff_login_id, staff_email, staff_password)
          VALUES(:staff_name, :staff_login_id, :staff_email, :staff_password)
          ';
        
          $stmt=$pdo->prepare($sql);
        
          $stmt->bindValue(':staff_name',$_POST['staff_name'],PDO::PARAM_STR);
          $stmt->bindValue(':staff_login_id',$staff_login_id,PDO::PARAM_STR);
          $stmt->bindValue(':staff_email',$staff_email,PDO::PARAM_STR);
          $stmt->bindValue(':staff_password',$_POST['staff_password'],PDO::PARAM_STR);
        
          $stmt->execute();
          header("Location:sf_info_completed.php");
            exit;
        }else{
          $err_msg="The Login ID or E-mail you keyed in is already registerd.";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>staff registration</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body id="page-layout">
    <header>
      <div>
        <h4>ヘッダーデザイン</h4>
      </div>
    </header>
      <div class="main-title">
        <h1>Staff Registration</h1>
      </div>
      <form class="newform" action="sf_info_regist.php" method="post">
          <div>
            <label class="newlabel">Name<span class="red">【Required】<span></label>
            <input class="textbox wd300" type="name" name="staff_name" min="0" max="30" required>
          </div>
          <div>
            <label class="newlabel">Login ID<span class="red">【Required】<span></label>
            <input class="textbox wd300" type="text" name="login_id" min="0" max="30" required>
          </div>
          <div>
            <label class="newlabel">E-mail <span class="red">【Required】</span></label>
            <input class="textbox wd300" type="email" name="staff_email" min="0" max="60" required>
          </div>
          </div>
          <div>
            <label class="newlabel">Password<span class="red">【Required】<span></label>
            <input class="textbox wd300" type="password" name="staff_password">
          </div>
          <input class="registaration enletter-space" type="submit" value="Confirmation" name="check">
      </form>
      <span class="text-red"><?php if($err_msg!==null && $err_msg!==""){echo $err_msg;} ?></span>
      <form action="sf_login.php">
        <input class="back" type="submit" value="Back to login page">
      </form>
      <footer id="footer">
        <p><small>&copy; お店 All rights reserved.</small></p>
      </footer>
  </body>
</html>