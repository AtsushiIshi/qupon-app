<?php
  // DB設定要

  $no_used_date="";
  $now = time();

    try{
      $pdo=new PDO($dsn, $user, $password);

      // 未使用分のクーポンステータスを判別
      $sql_usable= 'SELECT * FROM qupon_list WHERE qupon_used_date =""';

      $stmt_usable=$pdo->prepare($sql_usable);
      $stmt_usable->execute();

      $results=$stmt_usable->fetchAll(PDO::FETCH_ASSOC);

      foreach($results as $result){

        // 期限前のクーポンのqupon_statusを０(使用可能）から１(使用期間前)に変更(A-1)
        if($now < strtotime ($result['available_from']) && $result['qupon_status']===0){

            $sql_s1_update='
            UPDATE qupon_list
            SET  qupon_status = :qupon_status 
            WHERE qupon_id = :qupon_id
            ';
      
            $stmtqs1 = $pdo->prepare($sql_s1_update);
      
            $stmtqs1->bindValue(':qupon_status',1,PDO::PARAM_INT);
            $stmtqs1->bindValue(':qupon_id',$result['qupon_id'],PDO::PARAM_STR);

            $stmtqs1->execute();

            //期限切れのクーポンを期限切れに変更。qupon_statusを０(使用可能）から3(期限切れ)に変更。(A-3)
          }elseif($now > strtotime ($result['date_of_expiry'])){

            $sql_s3_update='
            UPDATE qupon_list
            SET  qupon_status = :qupon_status,
            qupon_used_date = :qupon_used_date
            WHERE qupon_id = :qupon_id
            ';
      
            $stmtqs3 = $pdo->prepare($sql_s3_update);
      
            $stmtqs3->bindValue(':qupon_status',3,PDO::PARAM_INT);
            $stmtqs3->bindValue(':qupon_used_date','expired',PDO::PARAM_STR);
            $stmtqs3->bindValue(':qupon_id',$result['qupon_id'],PDO::PARAM_STR);

            $stmtqs3->execute();

            // 期限前のクーポンを使用可能に変更。qupon_statusを１(使用期間前)から０(使用可能）に変更。(A-2)
          }elseif($now > strtotime ($result['available_from']) && $result['qupon_status']===1){

          $sql_s0_update='
            UPDATE qupon_list
            SET  qupon_status = :qupon_status 
            WHERE qupon_id = :qupon_id
            ';
      
            $stmtqs0 = $pdo->prepare($sql_s0_update);
      
            $stmtqs0->bindValue(':qupon_status',0,PDO::PARAM_INT);
            $stmtqs0->bindValue(':qupon_id',$result['qupon_id'],PDO::PARAM_STR);

            $stmtqs0->execute();
          }

          
        // notice_email=1(送信不可)かつnotice_date=""(未配信)にはnotice_dateを1111-11-11にする(A-4)
          $sql_update_notice='UPDATE notice_list as nl
          INNER JOIN customer_list as cl
          ON nl.receiver_id=cl.customer_id
          SET nl.notice_date="1111-11-11"
          WHERE cl.notice_email=1
          AND nl.notice_date=""
          ';

          $stmt_no_notice=$pdo->query($sql_update_notice);
          $stmt_no_notice->execute();

      }
    }catch (PDOException $e){      
        exit($e->getMessage());
    }







?>