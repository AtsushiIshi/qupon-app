<?php
session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']=="okokok"){
  header('Location:sf_login.php');
  exit;
}

// DB設定要

try{
  $pdo=new PDO($dsn, $user, $password);

  $sql='SELECT *
        FROM qupon_list
        WHERE qupon_type=1
        AND qupon_issued_date=(
         SELECT last_issued_date
         FROM qupon_setting
         WHERE qupon_type=1)
        ';

  $stmt=$pdo->query($sql);
  $results=$stmt->fetchall();

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
    <h1>Last monthly sales issue data</h1>
    <a href="mts_setting.php">Back to Monthly top sales setting</a>


    <section>
      <table>
        <tr>
          <th>Qupon ID</th>
          <th>Customer ID</th>
          <th>Discount Rate</th>
          <th>Valid from</th>
          <th>Valid until</th>
          <th>Issued date</th>
        </tr>
        <?php
          Foreach($results as $result){
            echo '<tr>
                    <td>'.$result['qupon_id'].'</td>
                    <td>'.$result['customer_id'].'</td>
                    <td>'.$result['discount_rate'].'%</td>
                    <td>'.$result['available_from'].'</td>
                    <td>'.$result['date_of_expiry'].'</td>
                    <td>'.$result['qupon_issued_date'].'</td>
                  </tr>';
          }

        ?>
      </table> 
    </section>
  </main>

  <footer id="footer">
    <p><small>&copy; お店 All rights reserved.</small></p>
  </footer>
</body>

</html>