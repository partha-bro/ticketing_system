
<?php
	require('staff.inc.php');
	require_once(STAFFINC_DIR.'header.inc.php');
	require('connDB.php');                          //database connection

	$id = $_GET['id'];
	$edit = $_GET['edit'];
	$date = date("d-m-y");
	$ta = $_GET['exp_1'];
	$da = $_GET['exp_2'];
	$hotel = $_GET['exp_3'];
	$misc = $_GET['exp_4'];
	$agent_name = $thisstaff->getFirstName();		//agent name store
	$tktno = $_GET['tkt'];
	//find school name and account code in old data
	$query = "SELECT ost_user.name,ost_user__cdata.account FROM ost_ticket INNER JOIN ost_user ON ost_user.id = ost_ticket.user_id INNER JOIN ost_user__cdata ON ost_ticket.user_id = ost_user__cdata.user_id WHERE ost_ticket.number = '$tktno'";     	

    	$sql = mysqli_query($link,$query);
    	while($row=  mysqli_fetch_array($sql))
    	  	{
    	   		$school_name = $row['name'];		
    	   		$account_code = $row['account'];
    	   	}

	/*echo "exp_1:".$ta."<br/>";
	echo "exp_2:".$da."<br/>";
	echo "exp_3:".$hotel."<br/>";
	echo "exp_4:".$misc."<br/>";
	echo "exp_4:".$agent_name."<br/>";
	echo "exp_4:".$tktno."<br/>";
	echo "exp_4:".$school_name."<br/>";
	echo "exp_4:".$account_code."<br/>";
	echo "exp_4:".$date."<br/>";*/

	//insert expense data into table

	if($edit == "Update"){
		$query_ins = "UPDATE ost_expense SET ta = '$ta', da = '$da', hotel = '$hotel', misc = '$misc', date = '$date', comment = 'edit' WHERE id = '$id'";
	}else{
		$query_ins = "INSERT INTO ost_expense (tkt_no, account, school_name, agent_name, ta, da, hotel, misc, date, comment)
	VALUES ('$tktno', '$account_code', '$school_name', '$agent_name', '$ta', '$da', '$hotel', '$misc', '$date', 'new')";
	}
	

	if ($link->query($query_ins) === TRUE) {
	    echo "<strong>Expense has saved Successfully</strong>";
	} else {
	    echo "Error: " . $sql_ins . "-->" . $link->error;
	}

	$link->close();

	echo "<a name='back' class='action-button' href='expense_table.php'>Back</a>";

  require_once(STAFFINC_DIR.'footer.inc.php');
?>