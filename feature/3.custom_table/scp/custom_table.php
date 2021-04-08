<?php
/*************************************************************************
    tickets.php

    Handles all tickets related actions.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('staff.inc.php');
require_once(STAFFINC_DIR.'header.inc.php');
require_once(INCLUDE_DIR.'class.json.php');

$DBHOST='localhost';
$DBNAME='support';
$DBUSER='root';
$DBPASS='123@root';
$link = mysqli_connect($DBHOST, $DBUSER, $DBPASS, $DBNAME);
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 
// Attempt select query execution
$dat = date("Y-m-d");
$sql = "SELECT * FROM ost_ticket";
$sql_open = "SELECT * FROM ost_ticket where ost_ticket.status_id = '1'";
$sql_create = "SELECT * FROM ost_ticket where date(created)='$dat'";
$sql_close = "SELECT * FROM ost_ticket where date(closed)='$dat'";
?>
<p>Click on the buttons inside the tabbed menu:</p>
<div class="tab" width="100%">
  <button class="tablinks" onclick="openCity(event, 'ticket')">Ticket</button>
  <button class="tablinks" onclick="openCity(event, 'category')">Category</button>
  <button class="tablinks" onclick="openCity(event, 'Cluster')">Cluster</button>
  <button class="tablinks" onclick="openCity(event, 'subject')">Complaints Type</button>
  <button class="tablinks" onclick="openCity(event, 'branch')">Branch</button>
</div>
<div id="ticket" class="tabcontent">
<?php

if($result_open = mysqli_query($link, $sql_open)){
    if(mysqli_num_rows($result_open) > 0){
	$open = mysqli_num_rows($result_open);
}
if($result_create = mysqli_query($link, $sql_create)){
    if(mysqli_num_rows($result_create) > 0){
	$create = mysqli_num_rows($result_create);
}
if($result_close = mysqli_query($link, $sql_close)){
    if(mysqli_num_rows($result_close) > 0){
	$close = mysqli_num_rows($result_close);
}
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table class='data-table'>";
            echo "<tr>";
                echo "<th width='50%'>Description</th>";
		echo "<th width='50%'>No of Tickets</th>";
            echo "</tr>";
	 if($row = mysqli_fetch_array($result)){
		$last_id = mysqli_num_rows($result);
		
            echo "<tr>";
		echo "<td>" . "All Tickets" . "</td>";
                echo "<td>" . "$last_id" . "</td>";
            echo "</tr>";
        	}
	echo "<tr>";
                echo "<td>" . "Open Tickets" . "</td>";                
                echo "<td>" . "$open" . "</td>";
            echo "</tr>";
        	}
	 echo "<tr>";
                echo "<td>" . "New Tickets added Today" . "</td>";
                echo "<td>" . "$create" . "</td>";
            echo "</tr>";
        	}
	echo "<tr>";
                echo "<td>" . "Tickets Closed by Today" . "</td>";
                echo "<td>" . "$close" . "</td>";
            echo "</tr>";
        	}
	
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
?>
</div>

<div id="category" class="tabcontent">
<?php
echo "<table class='data-table'>";
            echo "<tr>";
                echo "<th width='50%'>Category</th>";
		echo "<th width='50%'>Open Tickets</th>";
            echo "</tr>";
// Attempt select query execution
$n='A';
$no='1';
while($n <= "E"){
$sql = "SELECT * FROM ost_ticket inner join ost_user__cdata on ost_ticket.user_id = ost_user__cdata.user_id where category='$n' and status_id='1'";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
	 if($row = mysqli_fetch_array($result)){
		$count = mysqli_num_rows($result);
		echo "$last";
            echo "<tr>";
                echo "<td>" . "$row[category]" . "</td>";
                echo "<td>" . "$count" . "</td>";
            echo "</tr>";
        	}
	}
      $n++;
	$no++;
    } 
}
echo "<tr>";
                echo "<td>Total Tickets</td>";
		echo "<td>" . "$open" . "</td>";
            echo "</tr>";
echo "</table>";

?>
</div>
<div id="Cluster" class="tabcontent">
<?php
echo "<table class='data-table'>";
            echo "<tr>";
                
                echo "<th width='50%'>Cluster</th>";
		echo "<th width='50%'>Open Tickets</th>";
            echo "</tr>";
// Attempt select query execution
$n='2';
$no='1';
while($n <= "7"){
$sql = "SELECT * FROM ost_ticket inner join ost_user on ost_ticket.user_id=ost_user.id join ost_organization on ost_organization.id=ost_user.org_id where status_id='1' and org_id='$n'";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
	 if($row = mysqli_fetch_array($result)){
		$count = mysqli_num_rows($result);
            echo "<tr>";
                echo "<td>" . "$row[name]" . "</td>";
                echo "<td>" . "$count" . "</td>";
            echo "</tr>";	
        	}
	}
      $n++;
    } 
}
echo "<tr>"; 
                echo "<td>Total Tickets</td>";
		echo "<td>" . "$open" . "</td>";
            echo "</tr>";
echo "</table>";
?>
</div>
<div id="subject" class="tabcontent">
<?php
$link = mysqli_connect("localhost", "root", "123@root", "support");
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 
echo "<table class='data-table'>";
            echo "<tr>";
                echo "<th width='50%'>Subject</th>";
		echo "<th width='50%'>Open Tickets</th>";
            echo "</tr>";
// Attempt select query execution
$n='12';
while($n <= "29"){
$sql = "SELECT * FROM ost_ticket inner join ost_help_topic on ost_ticket.topic_id=ost_help_topic.topic_id where ost_ticket.status_id='1' and ost_ticket.topic_id='$n'";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
	 if($row = mysqli_fetch_array($result)){
		$count = mysqli_num_rows($result);
            echo "<tr>";
                echo "<td>" . "$row[topic]" . "</td>";
                echo "<td>" . "$count" . "</td>";
            echo "</tr>";
		
        	}
	}
      $n++;
    } 
}
echo "<tr>";   
                echo "<td>Total Tickets</td>";
		echo "<td>" . "$open" . "</td>";
            echo "</tr>";
echo "</table>";
?>
</div>
<div id="branch" class="tabcontent">
<?php
echo "<table class='data-table'>";
            echo "<tr>";
                echo "<th width='50%'>Branch</th>";
		echo "<th width='50%'>Open Tickets</th>";
            echo "</tr>";
// Attempt select query execution
$sql_row = "SELECT DISTINCT branch FROM ost_user__cdata";
if($result_row = mysqli_query($link, $sql_row)){
    if(mysqli_num_rows($result_row) > 0){
	 while($row_row = mysqli_fetch_array($result_row)){
		$data = $row_row[0];
$sql = "SELECT * FROM ost_ticket inner join ost_ticket__cdata on ost_ticket.ticket_id=ost_ticket__cdata.ticket_id where ost_ticket.status_id='1' and ost_ticket__cdata.branch_ticket ='$data'";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
	 if($row = mysqli_fetch_array($result)){
		$count = mysqli_num_rows($result);
            echo "<tr>";
                echo "<td>" . "$row[branch_ticket]" . "</td>";
                echo "<td>" . "$count" . "</td>";
            echo "</tr>";   	
		}
	}
    } 
}}}
echo "</table>";
// Close connection
mysqli_close($link);
?>
</div>
<?php
require_once(STAFFINC_DIR.'footer.inc.php');
