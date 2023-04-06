<?php
  header('X-FRAME-OPTIONS:DENY');
  session_start();

  if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="ok"){
    header('Location:index.php');
    exit;
  }

  // DB設定要

  $cs_id=$_SESSION['cs_id'];
  $no_used_date="";
  $now = time();

    try{
      $pdo=new PDO($dsn, $user, $password);

      // book qupon(B-1)
      if(isset($_POST['set'])){
        
          $sql_s5_update='
          UPDATE qupon_list
          SET  qupon_status = :qupon_status
          WHERE qupon_no LIKE :qupon_no AND  qupon_used_date=""
          ';
        
          $stmtqs5 = $pdo->prepare($sql_s5_update);
          
          $stmtqs5->bindValue(':qupon_no',$_POST['qupon_no'],PDO::PARAM_INT);
          $stmtqs5->bindValue(':qupon_status',5,PDO::PARAM_INT);
          $stmtqs5->execute();

         // booked qupon release(B-2)
        }elseif(isset($_POST['release'])){

        $sql_s0_update='
        UPDATE qupon_list
        SET  qupon_status = :qupon_status
        WHERE qupon_no LIKE :qupon_no
        ';
  
        $stmtqs0 = $pdo->prepare($sql_s0_update);
        
        $stmtqs0->bindValue(':qupon_no',$_POST['qupon_no'],PDO::PARAM_INT);
        $stmtqs0->bindValue(':qupon_status',0,PDO::PARAM_INT);
        $stmtqs0->execute();
      }

    // クーポン表示
      // booked qupon
      $sql_booked= 'SELECT * FROM qupon_list WHERE customer_id LIKE :customer_id AND qupon_status =5';

      $stmt_booked=$pdo->prepare($sql_booked);
      $stmt_booked->bindValue(':customer_id',$cs_id,PDO::PARAM_INT);
      $stmt_booked->execute();
      $result_booked=$stmt_booked->fetch(PDO::FETCH_ASSOC);

      if($result_booked !== false){
        $result_booked_url = $result_booked['qupon_url'];
        $disabled = "disabled";
      }else{
        $disabled = "";
      }

      // available qupon
      $sql_usable= 'SELECT * FROM qupon_list WHERE customer_id LIKE :customer_id AND qupon_status =0 ORDER BY date_of_expiry ASC';

      $stmt_usable=$pdo->prepare($sql_usable);
      $stmt_usable->bindValue(':customer_id',$cs_id,PDO::PARAM_INT);
      $stmt_usable->execute();
      $result_usables=$stmt_usable->fetchall(PDO::FETCH_ASSOC);


      // Before usable period.
      $sql_before= 'SELECT * FROM qupon_list WHERE customer_id LIKE :customer_id AND qupon_status =1';

      $stmt_before=$pdo->prepare($sql_before);
      $stmt_before->bindValue(':customer_id',$cs_id,PDO::PARAM_INT);
      $stmt_before->execute();
      $result_befores=$stmt_before->fetchall(PDO::FETCH_ASSOC);

      // used qupon
      $sql_usd= 'SELECT * FROM qupon_list WHERE customer_id LIKE :customer_id AND qupon_status =2 ORDER BY qupon_used_date DESC';

      $stmt_usd=$pdo->prepare($sql_usd);
      $stmt_usd->bindValue(':customer_id',$cs_id,PDO::PARAM_INT);
      $stmt_usd->execute();
      $result_usds=$stmt_usd->fetchall(PDO::FETCH_ASSOC);


    }catch (PDOException $e){
      
      exit($e->getMessage());
  }

?>
<!DOCTYPE html>
<html lang="jp">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認画面</title>
    <link rel="stylesheet" href="style.css">
  </head>

  <body id="page-layout">
    <header>
      <div>
        <h4>ヘッダーデザイン</h4>
      </div>
    </header>
    <main>
      <div class="main-title">
        <h1>クーポン使用・確認画面</h1>
      </div>
      <a class="backtologin" href="cs_home.php">会員画面に戻る</a>


      <!-- 使用予定クーポン表示 -->
      <div class="test">
      <p>使用予定クーポン</p>
      <?php 
        if($result_booked===false){
          echo "使用予定クーポンは設定されていません";
        } else {
        echo 
        ' <table>
            <tr>
              <td rowspan="5">
                <form action="cs_qupon.php" method="post">
                  <input type="submit" name="release" value="解除"> 
                  <input type="hidden" name="qupon_no" value='.$result_booked['qupon_no'].'>
                </form>
              </td>
            </tr>
            <tr>
              <td>'.$result_booked['qupon_name'].'</td>
            </tr>
            <tr>
              <td>'.$result_booked['available_from'].'～'.$result_booked['date_of_expiry'].'</td>
            </tr>
            <tr>
              <td>お支払い金額から'.$result_booked['discount_rate'].'%OFF</td>          
            </tr>
            <tr>
              <td><a href='.$result_booked_url.' target="_blank" rel="noopener noreferrer">クーポン詳細</a></td>
            </tr>  
          </table>
        ';
        }
      ?>
      </div>

      <!-- 使用可能クーポン表示 -->
      <div class="test">
      <p>使用可能クーポン</p>
      <?php
        if($result_usables === false){
          echo "使用可能クーポンはありません";
          }else{foreach ($result_usables as $result_usable){
            echo '       
                <table>
                  <tr>
                    <td rowspan="5">
                      <form action="cs_qupon.php" method="post">
                        <input type="submit" name="set" value="使用" '.$disabled.' > 
                        <input type="hidden" name="qupon_no" value='.$result_usable['qupon_no'].'>
                      </form>
                    </td>
                  </tr>        
                  <tr>
                    <td>'.$result_usable['qupon_name'].'</td>
                  </tr>
                  <tr>
                    <td>'.$result_usable['available_from'].'～'.$result_usable['date_of_expiry'].'</td>
                  </tr>
                  <tr>
                    <td>お支払い金額から'.$result_usable['discount_rate'].'%OFF</td>          
                  </tr>
                  <tr>
                    <td><a href='.$result_usable['qupon_url'].' target="_blank" rel="noopener noreferrer">クーポン詳細</a></td>
                  </tr>  
                </table>
                <br>
              ';
            }
          }
      ?>
      </div>
      <!-- 使用可能期間前クーポン表示 -->
      <p>使用可能期間前クーポン</p>
      <?php
          if($result_befores === false){
            echo "使用可能期間前クーポンはありません";
            }else{foreach ($result_befores as $result_before){
              echo '       
                  <table>
                    <tr>
                      <td>'.$result_before['qupon_name'].'</td>
                    </tr>
                    <tr>
                      <td>'.$result_before['available_from'].'～'.$result_before['date_of_expiry'].'</td>
                    </tr>
                    <tr>
                      <td>お支払い金額から'.$result_before['discount_rate'].'%OFF</td>          
                    </tr>
                    <tr>
                      <td><a href='.$result_before['qupon_url'].' target="_blank" rel="noopener noreferrer">クーポン詳細</a></td>
                    </tr>  
                  </table>
                  <br>
                ';
              }
            }  
      ?>

      <!-- 期限切れ・使用済みクーポン表示 -->
      <p>期限切れ・使用済みクーポン</p>
      <?php
          if($result_usds === false){
            echo "期限切れ・使用済みクーポンはありません";
            }else{foreach ($result_usds as $result_usd){
              echo '       
                    <table>
                      <tr>
                        <td>使用日　'.$result_usd['qupon_used_date'].'</td>
                      </tr>
                      <tr>
                        <td>'.$result_usd['qupon_name'].'</td>
                      </tr>
                      <tr>
                        <td><a href='.$result_usd['qupon_url'].' target="_blank" rel="noopener noreferrer">クーポン詳細</a></td>
                      </tr>  
                    </table>
                    <br>
                  ';
              }
            }
      ?>
    </main>
    <footer id="footer">
      <p><small>&copy; お店 All rights reserved.</small></p>
    </footer>
  </body>
</html>