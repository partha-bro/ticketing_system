<?php
  $servername = "localhost";
  $username = "root";
  $password = "123@root";
  $dbname = "support";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $id = $_POST['id'];                               //ticket id fetch from URL
  $sql = "SELECT number,calllog,mobno,name FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` ON ost_ticket.ticket_id = ost_ticket__cdata.ticket_id INNER JOIN `ost_user` ON ost_ticket.user_id = ost_user.id WHERE ost_ticket__cdata.ticket_id=".$id." ";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
      	$varTicktno = $row["number"];               //ticket number
      	$varName = $row["calllog"];                 //agent name
      	$varNo = $row["mobno"];                     //agent mobile number
        $schoolName = $row["name"];                     //school name
      }
  } else {
      echo "0 results";
  }
  // Close connection
  $conn->close();
  $uid = $id."2561";                        //generate the encryption for id
  //SMS connection info
  //default details
  $varUserName = "t1dsdigital";                     //sms portal username
  $varPWD = "Dssch@2013";                           //sms portal pass
  $varSenderID = "DSDGTL";                          //sms sender id

  $message = "Dear ".$varName.", Your complaint ".$varTicktno.", has been resolved. please give feedback support.dsdigital.in/support/sms/index.php?id=".$uid." ";

  //message encode for url
  $varMSG = urlencode($message);

  //send sms processing
  $url="http://nimbusit.co.in/api/swsendSingle.asp";
  $data="username=".$varUserName."&password=".$varPWD."&sender=".$varSenderID."&sendto=".$varNo."&message=".$varMSG;
  postData($url,$data);

  function postdata($url,$data)
  	{
  		//The function uses CURL for posting data to
  		$objURL = curl_init($url); curl_setopt($objURL,
  		CURLOPT_RETURNTRANSFER,1);
  		curl_setopt($objURL,CURLOPT_POST,1);
  		curl_setopt($objURL, CURLOPT_POSTFIELDS,$data);
  		$retval = trim(curl_exec($objURL));
  		curl_close($objURL);
  		return $retval;
  	}
  	echo "<script> alert('SMS is sent successfully.'); </script> ";

  //echo "<script> alert('Ticket no=". $varTicktno . "," ." name=". $varName . "," ." Number=". $varNo ." msg=". $varMSG ."uid=".$uid."'); </script>";

	// go back to original page
	echo "<script> history.go(-1); </script>";
?>
