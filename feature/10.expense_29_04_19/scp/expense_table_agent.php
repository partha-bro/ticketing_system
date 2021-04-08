<?php
	 $name = $thisstaff->getFirstName();	//agent name store	
	echo "<div class='data-table' id='show_table_data'><br/>";
	echo "<strong style='float:left; margin-bottom: 10px;'>Agent: $name</strong>";	
    		echo "<table border='1px' class='scroll'>";
      			echo"<tr>
      				<th>ID</th>
      				<th>Ticket_number</th>
      				<th>Account_code</th>
      				<th>School_name</th>
      				<th>Subject</th>
					<th>Status</th>
					<th>Expense</th>
      			</tr>";
		      $query = "SELECT ost_ticket.number,ost_user.name,ost_ticket__cdata.subject,ost_user__cdata.account FROM ost_ticket INNER JOIN ost_user ON ost_user.id = ost_ticket.user_id INNER JOIN ost_ticket__cdata ON ost_ticket.ticket_id = ost_ticket__cdata.ticket_id INNER JOIN ost_user__cdata ON ost_ticket.user_id = ost_user__cdata.user_id AND ost_ticket.staff_id = '$staff_id' and ost_ticket.status_id = '3'";     	//display searched data

    				$sql = mysqli_query($link,$query);
    				$id = '1';
    			    	while($row=  mysqli_fetch_array($sql))
    			    	{
    			    		$Tkt_no = $row['number'];
            				echo "<tr>
            				<td>".$id++."</td>
                   			<td>".$row['number']."</td>
                   			<td>".$row['account']."</td>
            				<td>".$row['name']."</td>
            				<td>".$row['subject']."</td>";
            				$query_check = "select comment from ost_expense where tkt_no = '$Tkt_no'";
            				$sql_check = mysqli_query($link,$query_check);
					    	$row=  mysqli_fetch_array($sql_check);
					    	  		$status = $row['comment'];
					    	if(!empty($status)){
					    		if($status == "edit"){
					    			echo "<td ><b>Submitted</b></td>";
					    			echo "<td><a name='add_btn' id='add_btn' class='action-button' href='expense_table_agent_dataentry.php?id=".$Tkt_no."'>ADD +</a></td></tr>";
					    		}else{
					    			echo "<td ><b>Submitted</b></td>";
					    			echo "<td><a name='add_btn' id='add_btn' class='action-button' href='expense_table_agent_dataentry.php?id=".$Tkt_no."'>ADD +</a></td></tr>";
					    		}
					    		
					    	}else{
					    		echo "<td style='color:red;'><b>Empty</b></td>";
					    		echo "<td><a name='add_btn' id='add_btn' class='action-button' href='expense_table_agent_dataentry.php?id=".$Tkt_no."'>ADD +</a></td></tr>";
					    	}
                    		
							
            			}
    		echo"</table></div>";
?>

