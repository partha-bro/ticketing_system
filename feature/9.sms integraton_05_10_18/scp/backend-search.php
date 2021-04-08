<?php

    require('connDB.php');              //database connection
    if(isset($_REQUEST['term'])){
        // Prepare a select statement
        $code = $_REQUEST['term'];
        $sql = "select * from ost_feedback where tktno like '%".$code."%' limit 0,10";
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
                        echo "<p>" . $row["tktno"] . "</p>";
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
