<?php
header('X-FRAME-OPTIONS:DENY');

session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']=="okokok"){
  header('Location:sf_login.php');
  exit;
}

// DB設定要

try{
  $pdo=new PDO($dsn, $user, $password);

  $sql='SELECT *
        FROM qupon_setting
        WHERE qupon_type=1
        ';

  $stmt=$pdo->query($sql);
  $result=$stmt->fetch();


  $sql_last='SELECT *
        FROM qupon_list
        WHERE qupon_type=1
        AND qupon_issued_date=(
         SELECT last_issued_date
         FROM qupon_setting
         WHERE qupon_type=1)
        ';

  $stmt_last=$pdo->query($sql_last);
  $results_last=$stmt_last->fetchall();

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
    <h1>Monthly top sales qupon setting</h1>
    <a href="qupon_manage.php">Back to Qupon Management</a>

    <p>Please change the rate and validity for the new qupon accordingly</p>

    <section>
      <form action="qupon_target_cs.php" method="post">
        <table>
        <tr>
            <td>The target month</td>
            <td>
                <select name="year">
                  <option value="2023">2023</option>
                  <option value="2024">2024</option>
                  <option value="2025">2025</option>
                  <option value="2026">2026</option>
                  <option value="2027">2027</option>
                  <option value="2028">2028</option>
                  <option value="2029">2029</option>
                  <option value="2030">2030</option>
                </select>
                -
                <select name="month">
                  <option value="1">Jan</option>
                  <option value="2">Feb</option>
                  <option value="3">Mar</option>
                  <option value="4">Apr</option>
                  <option value="5">May</option>
                  <option value="6">Jun</option>
                  <option value="7">Jul</option>
                  <option value="8">Aug</option>
                  <option value="9">Sep</option>
                  <option value="10">Oct</option>
                  <option value="11">Nov</option>
                  <option value="12">Dec</option>
                </select>
            </td>
          </tr>
          <tr>
            <td>Discount Rate</td>
            <td>
                <input type="text" name="discount_rate" value="<?php echo $result['discount_rate']?>">%
            </td>
          </tr>
          <tr>
            <td>Valid from</td>
            <td>
                <input type="text" name="available_from" value="<?php echo $result['available_from']?>">
            </td>
          </tr>
          <tr>
            <td>Valid until</td>
            <td>
                <input type="text" name="date_of_expiry" value="<?php echo $result['date_of_expiry']?>">
            </td>
          </tr>
          <tr>
            <td>URL</td>
            <td></td>
          </tr>
        </table>
        <input type="submit" name="" value="select the target customer">      
      </form>
    </section>

    <section>
      <h3>Last issued Monthly sales top qupon</h3>
      <table>
        <tr>
          <td>Last issued date</td>
          <td><?php echo $result['last_issued_date'] ?></td>
          <td>
        </tr>
        <tr>
          <th>Qupon ID</th>
          <th>Customer ID</th>
          <th>Discount Rate</th>
          <th>Valid from</th>
        </tr>
        <?php
          Foreach($results_last as $result_last){
            echo '<tr>
                    <td>'.$result_last['qupon_id'].'</td>
                    <td>'.$result_last['customer_id'].'</td>
                    <td>'.$result_last['discount_rate'].'%</td>
                    <td>'.$result_last['available_from'].'</td>
                    <td>'.$result_last['date_of_expiry'].'</td>
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