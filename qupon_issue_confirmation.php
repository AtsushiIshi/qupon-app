<?php
header('X-FRAME-OPTIONS:DENY');

session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']=="okokok"){
  header('Location:sf_login.php');
  exit;
}
$customer_id=$_POST['check'];


if(isset($_POST['confirm'])){

  // DB設定要
  
  try{
    $pdo=new PDO($dsn, $user, $password);

    $sql='INSERT INTO qupon_list (qupon_id, qupon_type, customer_id, qupon_name, discount_rate, qupon_url, qupon_issued_date, available_from, date_of_expiry, qupon_status)
          VALUES(:qupon_id, :qupon_type, :customer_id, :qupon_name, :discount_rate, :qupon_url, :qupon_issued_date, :available_from, :date_of_expiry, :qupon_status)
          ';

    $stmt=$pdo->prepare($sql);

    // 対象者にクーポン発行
    for($i=0; $i<count($customer_id) ; $i++){
      
      $stmt->bindvalue(':qupon_id',$i+67,PDO::PARAM_INT);
      $stmt->bindvalue(':qupon_type',1,PDO::PARAM_INT);
      $stmt->bindvalue(':customer_id',$customer_id[$i],PDO::PARAM_INT);
      $stmt->bindvalue(':qupon_name','月間VIP',PDO::PARAM_STR);
      $stmt->bindvalue(':discount_rate',$_SESSION['discount_rate'],PDO::PARAM_INT);
      $stmt->bindvalue(':qupon_url',"",PDO::PARAM_STR);
      $stmt->bindvalue(':qupon_issued_date',date('Y-m-d'),PDO::PARAM_STR);
      $stmt->bindvalue(':available_from',$_SESSION['available_from'],PDO::PARAM_STR);
      $stmt->bindvalue(':date_of_expiry',$_SESSION['date_of_expiry'],PDO::PARAM_STR);
      $stmt->bindvalue(':qupon_status',0,PDO::PARAM_INT);
      
      $stmt->execute();
    }


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
  <title>会員様ページ</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div id="home-top">
      <h4>ヘッダーデザイン</h4>
    </div>
  </header>

  <main>
    <h1>Qupon issue confirmation</h1>
    <a href="qupon_target_cs.php">Back to Target customer</a>

    <section>
    <form action="qupon_issue_confirmation.php" method="post">
      <table>
        <tr>
          <th>No</th>
          <th>Customer ID</th>
          <th>Discount rate</th>
          <th>Valid from</th>
          <th>Valid until</th>
        </tr>
        <?php
          $i=0;
          Foreach($_POST['check'] as $customer){
            echo '<tr>
                    <td>'.++$i.'</td>                    
                    <td>'.$customer.'</td>
                    <td>'.$_SESSION['discount_rate'].'%</td>
                    <td>'.$_SESSION['available_from'].'</td>
                    <td>'.$_SESSION['date_of_expiry'].'</td>
                  </tr>';
          }
        ?>
      </table>
      <input type="submit" name="confirm" value="issue qupon">
        </form>
    </section>
  </main>

  <footer id="footer">
    <p><small>&copy; お店 All rights reserved.</small></p>
  </footer>
</body>

</html>