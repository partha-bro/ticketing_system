<?php
      //export.php
 if(isset($_POST["export"]))
 {
      $connect = mysqli_connect("localhost", "root", "123@root", "support");
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=feedback.csv');
      $output = fopen("php://output", "w");
      fputcsv($output, array('ID', 'Account code','School Name', 'Ticket Number', 'Rating', 'Message', 'Date'));
        $query = "SELECT id,account,ost_feedback.name,tktno,rate,message,date FROM `ost_ticket` INNER JOIN `ost_feedback` ON ost_feedback.tktno = ost_ticket.number INNER JOIN `ost_user__cdata` ON ost_ticket.user_id = ost_user__cdata.user_id ORDER BY date DESC";
      $result = mysqli_query($connect, $query);
      while($row = mysqli_fetch_assoc($result))
      {
           fputcsv($output, $row);
      }
      fclose($output);
 }
 ?>
