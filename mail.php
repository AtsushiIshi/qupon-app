<?php
  header('X-FRAME-OPTIONS:DENY');
  session_start();

  if(!isset($_SESSION['flg']) &&  $_SESSION['flg']!=="ok"){
    header('Location:index.php');
    exit;
  }

  // DB設定要

  try{
    $pdo=new PDO($dsn, $user, $password);


    // notice_dateがデータ無かつnotice_emailが０に該当するcustomer_emailを抽出
    $sql_findcs= '
                  SELECT distinct(customer_list.customer_email) 
                  FROM notice_list
                  join customer_list
                  WHERE notice_date="" and customer_list.notice_email=0
                  ';

    $stmt_findcs = $pdo->query($sql_findcs);
    $results=$stmt_findcs->fetchall(PDO::FETCH_ASSOC);

    mb_internal_encoding("UTF-8");
    mb_language("Japanese");

    foreach($results as $result){
      
      $to = implode($result);
      $title = 'テストメール';
      $content = 'test';
      $headers = 'info@qupon-app.site';

      // mb_send_mail($to, $title, $content, $headers);

      echo $to."にメールを送信しました".'<br>';
    }

      // notice_dateがデータ無かつnotice_emailが０のnotice_dateに今日の日付を入れる
      $sql_update_notice='
            UPDATE notice_list
            SET  notice_date = :notice_date
            WHERE notice_date=""';

      $stmt_update_notice=$pdo->prepare($sql_update_notice);
      $stmt_update_notice->bindValue(':notice_date',date('Y-m-d'),PDO::PARAM_STR);
      $stmt_update_notice->execute();

  }catch (PDOException $e){
      exit($e->getMessage());
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
  </head>
  <body>
    <?php

    ?>
  </body>
</html>