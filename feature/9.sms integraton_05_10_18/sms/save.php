<?php
    $name = mysql_real_escape_string($_POST['nam']);
    $tktno = mysql_real_escape_string($_POST['tktno']);
    $rate = mysql_real_escape_string($_POST['rate']);
    $comment = mysql_real_escape_string($_POST['comment']);

    //today date finder
    $date = date('Y-m-d');

    $servername = "localhost";
    $username = "root";
    $password = "123@root";
    $dbname = "support";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //apply condition for does not insert duplicate feedback of single ticket
    $sql = "select id from ost_feedback where tktno='".$tktno."'";    //fetch id from existing feedback data
    $result = $conn->query($sql);
    $id_data = null;
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $id_data = $row["id"];               //id of ticket number
        }
    }
    if ($id_data != null){

      //feedback update into ost_feedback database
      $update_sql = "UPDATE ost_feedback SET rate='$rate',message='$comment', date='$date' WHERE id='$id_data'";

      if ($conn->query($update_sql) === TRUE) {
        echo "<script> alert('Thank you for your feedback.'); </script>";
      } else {
          echo "<script> alert('Error, please try again!'); </script>";
      }
    }else {
      
      //feedback insert into ost_feedback database
      $insert_sql = "INSERT INTO ost_feedback (name, tktno, rate, message, date)
      VALUES ('$name', '$tktno', '$rate', '$comment' , '$date')";

      if ($conn->query($insert_sql) === TRUE) {
          echo "<script> alert('Thank you for your feedback.'); </script>";
      } else {
          echo "<script> alert('Error, please try again!'); </script>";
      }
    }


    /*echo "<script> alert('Ticket no=". $tktno . "," ." school name=". $name . ", Rate=". $rate.", Comment=".$comment."'); </script>";
    echo "<script> alert('Thank you for your feedback'); </script>";*/

    // go back to original page
    echo "<script> history.go(-1); </script>";
?>
