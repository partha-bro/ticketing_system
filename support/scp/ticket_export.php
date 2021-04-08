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
require_once(INCLUDE_DIR.'class.ticket.php');
require_once(INCLUDE_DIR.'class.dept.php');
require_once(INCLUDE_DIR.'class.filter.php');
require_once(INCLUDE_DIR.'class.canned.php');
require_once(INCLUDE_DIR.'class.json.php');
require_once(INCLUDE_DIR.'class.dynamic_forms.php');
require_once(INCLUDE_DIR.'class.export.php');       // For paper sizes
require('connDB.php');                          //database connection


$sql = "SELECT max(ticket_id) FROM ost_ticket";
$link = db_query($sql);
$row = mysqli_fetch_array($link);
    $last_id = $row[0];

$page='';
$ticket = $user = null; //clean start.
$redirect = false;
//LOCKDOWN...See if the id provided is actually valid and if the user has access.
if($_REQUEST['id'] || $_REQUEST['number']) {
    if($_REQUEST['id'] && !($ticket=Ticket::lookup($_REQUEST['id'])))
         $errors['err']=sprintf(__('%s: Unknown or invalid ID.'), __('ticket'));
    elseif($_REQUEST['number'] && !($ticket=Ticket::lookup(['number' => $_REQUEST['number']])))
         $errors['err']=sprintf(__('%s: Unknown or invalid number.'), __('ticket'));
    elseif(!$ticket->checkStaffPerm($thisstaff)) {
        $errors['err']=__('Access denied. Contact admin if you believe this is in error');
        $ticket=null; //Clear ticket obj.
    }
}

if ($_REQUEST['uid']) {
    $user = User::lookup($_REQUEST['uid']);
}
if($_GET['export']){
	$param['fdate'] =  $_REQUEST['fdate'];
	$param['ldate'] =  $_REQUEST['ldate'];
	$param['ticket_status'] =  $_REQUEST['ticket_status'];
	$days = (strtotime($param['ldate']) - strtotime($param['fdate'])) / (60 * 60 * 24);
	if($_REQUEST['a'] == 'export_custom') {
		if ($days <= "365"){
			$ts = strftime('%Y%m%d');
			if ($param['ticket_status'] == 'all'){
			if (!Export::exportTickets($param, "tickets-$ts.csv", 'csv' , $last_id))
				$errors['err'] = __('Unable to dump query results.')
					.' '.__('Internal error occurred');
			}
			elseif ($param['ticket_status'] == 'open'){
				if (!Export::exportOpenTickets($param, "tickets-$ts.csv", 'csv', $last_id))
				$errors['err'] = __('Unable to dump query results.')
					.' '.__('Internal error occurred');
			}
			else{
				if (!Export::exportCloseTickets($param, "tickets-$ts.csv", 'csv', $last_id))
				$errors['err'] = __('Unable to dump query results.')
					.' '.__('Internal error occurred');
		}
		}else{
			echo '<script type="text/javascript">alert("1 year is a maximum duration.Please select date in between 1 year.");</script>';
			}
	}
}


require_once(STAFFINC_DIR.'header.inc.php');?>
<head>
<style>
img{
    height: 22px;
	width:20px;
    vertical-align: middle;
}
</style>
</head>
<div>
<form action="" method="GET">
	<div>
		<b>From: </b><input type="text" id="fromdate" name="fdate" value="" required>
		<img src="./images/cal.png" alt="calendar image"/>

		<b>To: </b><input type="text" id="todate" name="ldate" value="" required>
		<img src="./images/cal.png" alt="calendar image"/>
	<input type="hidden" name="a" value="export_custom">
	<input type="radio" name="ticket_status" value="all" checked /> All
	<input type="radio" name="ticket_status" value="open" /> Open
	<input type="radio" name="ticket_status" value="closed" /> Closed
	<input type="submit" name="export" class="export-csv no-pjax" value="EXPORT"/>
	</div>
</form>
</div>
<?php
print $response_form->getMedia();
require_once(STAFFINC_DIR.'footer.inc.php');
