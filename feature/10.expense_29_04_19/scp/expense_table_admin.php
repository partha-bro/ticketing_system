<?php
	$name = $thisstaff->getFirstName();	//agent name store
?>
<div class='data-table' id='show_table_data'><br/> 
	<form method='post' action='expense_csv.php'>
		<strong>Manager: <?php echo $name; ?></strong>
 		<input type='submit' value='Export CSV' name='Export' style="float:right; margin-bottom: 10px;">
			<table border='1px' class='scroll'>
			    <tr>
			     <th>ID</th>
			     <th>Ticket_no</th>
			     <th>School_name</th>
			     <th>Account_code</th>
			     <th>Agent_name</th>
			     <th>TA</th>
			     <th>DA</th>
			     <th>Hotel</th>
			     <th>Misc</th>
			     <th>Date</th>
			    </tr>
    		<?php 
    			$head_arr[] = array("ID","Ticket_no","School_name","Account_code","Agent_name","TA","DA","Hotel","Misc","Date");
     			$query = "SELECT * FROM ost_expense ORDER BY id asc";
     			$result = mysqli_query($link,$query);
     			$user_arr = array();
     			while($row = mysqli_fetch_array($result)){
				      $id = $row['id'];
				      $tktno = $row['tkt_no'];
				      $school_name = $row['school_name'];
				      $account = $row['account'];
				      $agent = $row['agent_name'];
				      $ta = $row['ta'];
				      $da = $row['da'];
				      $hotel = $row['hotel'];
				      $misc = $row['misc'];
				      $date = $row['date'];
				      $user_arr[] = array($id,$tktno,$school_name,$account,$agent,$ta,$da,$hotel,$misc,$date);
   			?>
		      <tr>
		       <td><?php echo $id; ?></td>
		       <td><?php echo $tktno; ?></td>
		       <td><?php echo $school_name; ?></td>
		       <td><?php echo $account; ?></td>
		       <td><?php echo $agent; ?></td>
		       <td><?php echo $ta; ?></td>
		       <td><?php echo $da; ?></td>
		       <td><?php echo $hotel; ?></td>
		       <td><?php echo $misc; ?></td>
		       <td><?php echo $date; ?></td>
		      </tr>
   			<?php
			    }
			    $user_arr = array_merge($head_arr, $user_arr);
   			?>
   		</table>
   	<?php 
   		//colected data that export in csv format
    	$serialize_user_arr = serialize($user_arr);
   	?>
  <textarea name='export_data' style='display: none;'><?php echo $serialize_user_arr; ?></textarea>
 </form>
</div>

