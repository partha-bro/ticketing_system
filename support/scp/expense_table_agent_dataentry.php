<?php
	require('staff.inc.php');
	require_once(STAFFINC_DIR.'header.inc.php');
	require('connDB.php');                          //database connection

	$tkt_no = $_GET['id'];

	$query_chk = "SELECT comment FROM ost_expense WHERE tkt_no = '$tkt_no'";     	

    	$sql_chk = mysqli_query($link,$query_chk);
    	while($row_chk=  mysqli_fetch_array($sql_chk))
    	  	{
    	   		$edit_status = "y";		
    	   	}

    if($edit_status == "y"){
    	$query_edit = "SELECT * FROM ost_expense WHERE tkt_no = '$tkt_no'";     	

    	$sql_edit = mysqli_query($link,$query_edit);
    	while($row_edit =  mysqli_fetch_array($sql_edit))
    	  	{
    	  		$id = $row_edit['id'];
    	  		$ta_edit = $row_edit['ta'];	
    	   		$da_edit = $row_edit['da'];
    	   		$hotel_edit = $row_edit['hotel'];
    	   		$misc_edit = $row_edit['misc'];	
    	   	}
    }
?>

<link rel="stylesheet" type="text/css" href="css/expense.css"/>
<script src="js/jquery-1.12.4.min.js"></script>
<script>
	function onSubmit() {
		// body...
		var id = document.getElementById('tkt_id').value;
		var edit = document.getElementById('edit').innerHTML;
		var tktno = document.getElementById('tktno').value;
		var exp_1 = document.getElementById('exp_1').value;
		var exp_2 = document.getElementById('exp_2').value;
		var exp_3 = document.getElementById('exp_3').value;
		var exp_4 = document.getElementById('exp_4').value;
		if(exp_1 != "" && exp_2 != "" && exp_3 != "" && exp_4 != ""){
			if(exp_1 >= '0' && exp_2 >= '0' && exp_3 >= '0' && exp_4 >= '0'){
				if(edit == "Update"){
					//alert("update");
					window.location.href = 'expense_submit.php?exp_1='+ exp_1 +'&exp_2='+ exp_2 +'&exp_3='+ exp_3 +'&exp_4='+ exp_4 +'&tkt='+ tktno +'&edit='+ edit +'&id=' + id;
				}else{
					//alert("submit");
					window.location.href = 'expense_submit.php?exp_1='+ exp_1 +'&exp_2='+ exp_2 +'&exp_3='+ exp_3 +'&exp_4='+ exp_4 +'&tkt='+ tktno +'&edit='+ edit +'&id=' + id;
				}
				
			}else{
				alert("Please remove negative sign in fields.");
			}
			
		}else{
			alert("Please enter all details.");
		}
		
	}
	
</script>
<div class="body_div">
	<h3>Expense Information</h3>	
	
	<?php
		if($edit_status == "y"){
			echo "<div class'exp_data' id='exp_data' style='display:block'>";
	?>
		<form method="post">
				<p>Ticket No: <?php echo $_GET['id']; ?></p>
				<input type="hidden" id="tktno" value="<?php echo $_GET['id']; ?>">
				<input type="hidden" id="tkt_id" value="<?php echo $id; ?>">
				TA: <input type="number" name="exp_1" min="0" id="exp_1" value="<?php echo $ta_edit; ?>" required style="margin-left: 5%" /><br />
				DA: <input type="number" name="exp_2" min="0" id="exp_2" value="<?php echo $da_edit; ?>" required style="margin-left: 4.7%"/><br />
				HOTEL: <input type="number" name="exp_3" min="0" id="exp_3" value="<?php echo $hotel_edit; ?>" required style="margin-left: 2.3%"/><br />
				MISC.: <input type="number" name="exp_4" min="0" id="exp_4" value="<?php echo $misc_edit; ?>" required style="margin-left: 3%"/><br />
				<a name="cancel" class='action-button' href="expense_table.php">Cancel</a>
				<a name="submit" class='action-button' id="edit" onclick="onSubmit()">Update</a>
				
			</form>
			<p style="color: red;">Note: if you don't want to input any value, then please put "0" instead of blank.</p>
		</div>
	<?php
		}else{
			echo "<div class='exp_data' id='exp_data' style='display:block'>";
	?>
			<form method="post">
				<p>Ticket No: <?php echo $_GET['id']; ?></p>
				<input type="hidden" id="tktno" value="<?php echo $_GET['id']; ?>">
				<input type="hidden" id="tkt_id" value="<?php echo $id; ?>">
				TA: <input type="number" name="exp_1" min="0" id="exp_1" value="" required style="margin-left: 5%" /><br />
				DA: <input type="number" name="exp_2" min="0" id="exp_2" value="" required style="margin-left: 4.7%"/><br />
				HOTEL: <input type="number" name="exp_3" min="0" id="exp_3" value="" required style="margin-left: 2.3%"/><br />
				MISC.: <input type="number" name="exp_4" min="0" id="exp_4" value="" required style="margin-left: 3%"/><br />
				<a name="cancel" class='action-button' href="expense_table.php">Cancel</a>
				<a name="submit" class='action-button' id="edit" onclick="onSubmit()">Submit</a>
				
			</form>
			<p style="color: red;">Note: if you don't want to input any value, then please put "0" instead of blank.</p>
		</div>
	<?php
		} 	
	?>
			
</div>
<?php
  require_once(STAFFINC_DIR.'footer.inc.php');
?>