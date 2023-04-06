<?php

header('X-FRAME-OPTIONS:DENY');

session_start();

if(!isset($_SESSION['flg']) &&  $_SESSION['flg']=="okokok"){
  header('Location:sf_login.php');
  exit;
}

// DB設定要
$err_msg="";
$customer_id="";

if(isset($_POST['cs_no_check'])){
$customer_id=$_POST['customer_id'];

  try{
    $pdo=new PDO($dsn, $user, $password);


    // 特定の顧客の予約クーポンを支払に反映（P-1)
    $stmt_qupon_check=$pdo->prepare("SELECT * FROM qupon_list WHERE customer_id =? and qupon_status=5");    
    $stmt_qupon_check->execute(array($customer_id));
    $result_qupon=$stmt_qupon_check->fetch();

    if($result_qupon !== false){
      $_SESSION['customer_id']=$result_qupon['customer_id'];
      $_SESSION['qupon_name']=$result_qupon['qupon_name'];
      $_SESSION['discount_rate']=$result_qupon['discount_rate'];
      $_SESSION['qupon_no']=$result_qupon['qupon_no'];
      $_SESSION['qupon_id']=$result_qupon['qupon_id'];
    }
    
  }catch (PDOException $e){
    exit($e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
  </head>

  <body>
    <header>
      <div id="home-top">
        <h4>ヘッダーデザイン</h4>
      </div>
    </header>

    <main>
      <div class="main-title">
        <h1>Payment</h1>
      </div>

      
        <table>
          <thead>
            <th>
              <td></td>
              <td></td>
            </th>
          </thead>

        
          <tbody>

            <th>
              <td>
                <label for="customer_id">Customer ID</label>
              </td>
            </th>
            <form action="payment.php"  method="post">
              <td>
                <input type="text" id="customer_id" name="customer_id" value="<?php if(isset($_POST['customer_id'])){echo $_POST['customer_id'];} ?>">
              </td>
              <td>
                <input type="submit" name="cs_no_check" value="SEARCH">
              </td>
            </form>

            <form action="payment_confirmation.php" method="post">  
              <tr>
                <th>
                  <td>
                    <label for="amount_before">Amount before qupon used</label>
                  </td>
                  <td id="amountbefore">
                    <input type="text" id="amount_before" name="amount_before" required>
                  </td>
                </th>
              </tr>

              <tr>
                <th>
                  <td>
                    <label for="booked_qupon">Booked qupon</label>
                  </td>
                  <td>
                    <?php if(isset($_POST['cs_no_check']) && $result_qupon !== false){echo $result_qupon['qupon_name'];}else{echo 'qupon is not selected';} ?>
                  </td>
                </th>
              </tr>

              <tr>
                <th>
                  <td>
                    <label for="discount_rate">Discount rate</label>
                  </td>
                  <td>
                    <input id="discount_rate" type="hidden" value="<?php if(isset($_POST['cs_no_check']) && $result_qupon !== false){echo $result_qupon['discount_rate'];}else{echo '0';} ?>">
                    <?php if(isset($_POST['cs_no_check']) && $result_qupon !== false){echo $result_qupon['discount_rate'].'%';}else{echo '0%';} ?>
                  </td>
                </th>
              </tr>

              <tr>
                <th>
                  <td>
                    <label for="discount">Discount</label>
                  </td>
                  <td id="discount">
                  </td>
                </th>
              </tr>

              <tr>
                <th>
                  <td>
                    <label for="amount_after">Amount after qupon used</label>
                  </td>
                  <td id="amount_after">
                  </td>
                </th>
              </tr>

              <tr>
                <th>
                  <td>
                    <label for="Received_amount">Received amount</label>
                  </td>
                  <td>
                    <input type="text" id="received_amount" name="received_amount" required>
                  </td>
                </th>
              </tr>

              <tr>
                <th>
                  <td>
                    <label for="change">Change</label>
                  </td>
                  <td id="change">
                  </td>
                </th>
              </tr>
            </tbody>
          </table> 
          <input type="submit" value="Paid">
        </form>
        <a href="sf_home.php">Back to home</a>
    </main>
    <script src="payment.js"></script>
  </body>
</html>

