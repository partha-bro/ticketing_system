<?php
    $DBHOST='localhost';
    $DBNAME='support';
    $DBUSER='root';
    $DBPASS='123@root';
    $link = mysqli_connect($DBHOST, $DBUSER, $DBPASS, $DBNAME);
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>
