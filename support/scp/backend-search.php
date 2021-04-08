<?php

    require('connDB.php');              //database connection
    if(isset($_REQUEST['term'])){
        // Prepare a select statement
        $code = $_REQUEST['term'];
        $sql = "SELECT id,account,ost_feedback.name,tktno,rate,message,date FROM `ost_ticket` INNER JOIN `ost_feedback` ON ost_feedback.tktno = ost_ticket.number INNER JOIN `ost_user__cdata` ON ost_ticket.user_id = ost_user__cdata.user_id where account like '%".$code."%' limit 0,10";
      //  $sql = "SELECT * FROM ost_record WHERE account_code LIKE ".$code." limit 0,10";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            @mysqli_stmt_bind_param($stmt, "s", $param_term);
            // Set parameters
            $param_term = $_REQUEST['term'] . '%';
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                // Check number of rows in the result set
                if(mysqli_num_rows($result) > 0){
                    // Fetch result rows as an associative array
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                        echo "<p>" . $row["account"] . "</p>";
                    }
                } else{
                    echo "<p>No matches found</p>";
                }
            } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // close connection
    mysqli_close($link);
?>
