<?php
session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']=="okokok"){
  header('Location:sf_login.php');
  exit;
}

// DB設定要

$discount="";
$qupon_id = $_SESSION["qupon_id"];

// Change qupon_status from 5 to 2.(U-1)
if(isset($_POST['confirm'])){

  try{
    $pdo=new PDO($dsn, $user, $password);

    $sql_used= 'SELECT * FROM qupon_list WHERE customer_id LIKE :customer_id AND qupon_status=5';

    $sql_used=$pdo->prepare($sql_used);
    $sql_used->bindValue(':customer_id',$_SESSION['customer_id'],PDO::PARAM_INT);
    $sql_used->execute();

    $updates=$sql_used->fetchAll(PDO::FETCH_ASSOC);

    foreach($updates as $update){

      $sql_s2_update='
      UPDATE qupon_list
      SET  qupon_status = :qupon_status,
      qupon_used_date = :qupon_used_date
      WHERE qupon_no LIKE :qupon_no
      ';

      $stmtqs2 = $pdo->prepare($sql_s2_update);
  
      $stmtqs2->bindValue(':qupon_status',2,PDO::PARAM_INT);
      $stmtqs2->bindValue(':qupon_used_date',date('Y-m-d'),PDO::PARAM_STR);
      $stmtqs2->bindValue(':qupon_no',$update['qupon_no'],PDO::PARAM_INT);

      $stmtqs2->execute();
    }

    $pdo="";

  }catch(PDOException $e){    
    exit($e->getMessage());
  }

  $discount=$_POST['amount_before']*$_SESSION['discount_rate']/100;

   try{
    $pdo=new PDO($dsn, $user, $password);


    $sql_sales='
      INSERT INTO sales_list(customer_id, date_of_payment, used_qupon, discounted_amount, sales_without_qupon, sales_after_qupon) 
      VALUES(:customer_id,:date_of_payment,:used_qupon,:discounted_amount,:sales_without_qupon,:sales_after_qupon)
    ';

    $stmtsales = $pdo->prepare($sql_sales);

    $stmtsales->bindValue(':customer_id',$_SESSION['customer_id'],PDO::PARAM_INT);
    $stmtsales->bindValue(':date_of_payment',date('Y-m-d'),PDO::PARAM_STR);
    $stmtsales->bindValue(':used_qupon',$_SESSION['qupon_id'],PDO::PARAM_STR);
    $stmtsales->bindValue(':discounted_amount', $discount ,PDO::PARAM_INT);
    $stmtsales->bindValue(':sales_without_qupon',$_POST['amount_before'] ,PDO::PARAM_INT);
    $stmtsales->bindValue(':sales_after_qupon', $_POST['sales_after_qupon'],PDO::PARAM_INT);

    $stmtsales->execute();

    header('Location:payment_completion.php');

  }catch(PDOException $e){    
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
  <title>Payment confirmation</title>
  <link rel="stylesheet" href="style.css">
</head>
<header>
    <div>
      <h4>ヘッダーデザイン</h4>
    </div>
  </header>
  <main>
    <div class="main-title">
      <h1>Payment confirmation</h1>
    </div>
    <p>Please confirm the details below</p>
    <table class="table-font">
      <tr>
        <td>Customer ID:</td>
        <td><?php echo $_SESSION['customer_id']; ?></td>
      </tr>
      <tr>
        <td>Amount BEFORE qupon used:</td>
        <?php $amount_before=$_POST['amount_before']; ?>
        <td><?php echo $amount_before; ?></td>
      </tr>
      <tr>
        <td>Booked qupon:</td>
        <td><?php echo $_SESSION['qupon_name']; ?></td>
      </tr>
      <tr>
        <td>Discount rate:</td>
        <td><?php echo $_SESSION['discount_rate'].'%'; ?></td>
      </tr>
      <tr>
        <td>Discount:</td>
        <?php $discount=$_POST['amount_before']*$_SESSION['discount_rate']/100; ?>
        <td><?php  echo $discount; ?></td>
      </tr>
      <tr>
        <td>Amount AFTER qupon used:</td>
        <?php $sales_after_qupon=$_POST['amount_before']- $discount; ?>
        <td><?php echo $sales_after_qupon; ?></td>
      </tr>
    </table>
    <form action="payment_confirmation.php" method="post">
      <input type="hidden" name="amount_before" value="<?php echo $amount_before; ?>">
      <input type="hidden" name="discount" value="<?php echo $discount; ?>">
      <input type="hidden" name="sales_after_qupon" value="<?php echo $sales_after_qupon; ?>">
      <input class="registaration enletter-space" type="submit" value="confirm" name="confirm">
    </form>
    <form action="payment.php">
      <input class="enletter-space back" type="submit" value="Back to payment">
    </form>
    <footer id="footer">
      <p><small>&copy; お店 All rights reserved.</small></p>
    </footer>
  </main>
</body>