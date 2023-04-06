<?php
  // DB設定要
  
  if(isset($_POST['submit'])){
    try{
      $pdo=new PDO($dsn, $user, $password);
  
      $sql='
      INSERT INTO staff_list(staff_name,login_id,staff_email,staff_password)
      VALUES(:staff_name,:login_id,:staff_email,:staff_password)
      ';

      $stmt=$pdo->prepare($sql);
  
      $stmt->bindValue(':staff_name',$_POST['staff_name'],PDO::PARAM_STR);
      $stmt->bindValue(':login_id',$_POST['login_id'],PDO::PARAM_STR);
      $stmt->bindValue(':staff_email',$_POST['staff_email'],PDO::PARAM_STR);
      $stmt->bindValue(':staff_password',$_POST['staff_password'],PDO::PARAM_STR);
     
    
      $stmt->execute();
      header("Location: staff_completion.php");

    }catch (PDOException $e){
      exit($e->getMessage());
  }
}
?>
<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmation</title>
  <link rel="stylesheet" href="style.css">
</head>

<body id="page-layout">
  <header>
    <div>
      <h4>Header designe</h4>
    </div>
  </header>
  <main>
    <div class="main-title">
      <h1>Confirmation</h1>
    </div>
    <p>Please check the content</p>
    <table class="table-font">
      <tr>
        <td>Name:</td>
        <td><?php echo $_POST['staff_name']; ?></td>
      </tr>
      <tr>
        <td>Login ID:</td>
        <td><?php echo $_POST['login_id']; ?></td>
      </tr>
      <tr>
        <td>E-mail:</td>
        <td><?php echo $_POST['staff_email']; ?></td>
      </tr>
    </table>
    <form action="staff_info_confirmation.php" method="post">
      <input type="hidden" name="staff_name" value="<?php echo $_POST['staff_name'] ?>">
      <input type="hidden" name="login_id" value="<?php echo $_POST['login_id'] ?>">
      <input type="hidden" name="staff_email" value="<?php echo $_POST['staff_email'] ?>">
      <input type="hidden" name="staff_password" value="<?php echo $_POST['staff_password'] ?>">
      <input class="registaration enletter-space" type="submit" value="Registration" name="submit">
    </form>
    <form action="staff_registration.php">
      <input class="enletter-space back" type="submit" value="Back to modify">
    </form>
    <footer id="footer">
      <p><small>&copy; お店 All rights reserved.</small></p>
    </footer>
  </main>
</body>