<?php
header('X-FRAME-OPTIONS:DENY');

session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']=="okokok"){
  header('Location:sf_login.php');
  exit;
}

// DB設定要

$_SESSION['discount_rate'] = $_POST['discount_rate'];
$_SESSION['available_from'] = $_POST['available_from'];
$_SESSION['date_of_expiry'] = $_POST['date_of_expiry'];

try{
  $pdo=new PDO($dsn, $user, $password);

  $sql_cs='SELECT customer_id, SUM(sales_after_qupon)
        FROM sales_list
        WHERE date_of_payment BETWEEN :available_from AND :date_of_expiry
        Group by customer_id
        ORDER BY SUM(sales_after_qupon) desc
        limit 5
        ';

  $stmt_cs=$pdo->prepare($sql_cs);
  $stmt_cs->bindValue(':available_from',"2023-03-01",PDO::PARAM_STR);
  $stmt_cs->bindValue(':date_of_expiry',"2023-03-31",PDO::PARAM_STR);
  $stmt_cs->execute();
  $results_cs=$stmt_cs->fetchall();

}catch(PDOException $e){
  exit($e->getMessage());
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
    <h1>Target customer</h1>
    <a href="mts_setting.php">Back to Qupon Management</a>

    <section>
      <table>
        <tr>
        <th><button id="checkAll">select all</button></th>
          <th>Customer ID</th>
          <th>Total payment</th>
        </tr>
        <form action="qupon_issue_confirmation.php" method="post">
        <?php
          Foreach($results_cs as $result_cs){
            echo '<tr>
                    <td><input type="checkbox" class="checks" name="check[]" value='.$result_cs['customer_id'].'></td>                    
                    <td>'.$result_cs['customer_id'].'</td>
                    <td>'.$result_cs['SUM(sales_after_qupon)'].'</td>
                  </tr>';
          }
        ?>
      </table>
      <input type="submit" name="confirm" value="confirm">
        </form>
    </section>
  </main>

  <footer id="footer">
    <p><small>&copy; お店 All rights reserved.</small></p>
  </footer>
  <script src="selection.js"></script>
</body>

</html>