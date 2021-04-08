<?php

require('staff.inc.php');
require_once(STAFFINC_DIR.'header.inc.php');
require('connDB.php');                          //database connection
?>

<link rel="stylesheet" type="text/css" href="css/expense.css"/>
<script src="js/jquery-1.12.4.min.js"></script>
<script>

</script>
<div class="body_div">
	<h3>Expense Information</h3>	
	
<?php
	//Details about agent
	$name = $thisstaff->getFirstName();	//agent name store
	$query = "SELECT role_id,staff_id FROM ost_staff WHERE firstname = '$name'";
	$sql = mysqli_query($link,$query);
	while($row=  mysqli_fetch_array($sql))
	{
		$role_id = $row['role_id'];
		$staff_id = $row['staff_id'];
	}
	//assign role model
	if($role_id == '3' || $role_id == '4'){
		$value = "<strong>Agent: ".$name." </strong>";
		//code for agent 
		require('expense_table_agent.php');
		
	  
	
	}else if($role_id == '5' || $role_id == '1'){
		//code for manager/admin
		require('expense_table_admin.php');
	}else{
		$value = "<strong>Sorry, Some technical issue is occour, Please contant to admin.</strong>";
	}

?>
</div>
<?php
  require_once(STAFFINC_DIR.'footer.inc.php');
?>
