<?php
  $uid = mysql_real_escape_string($_GET['id']);        //ticket id fetch from URL
  $id = substr($uid,0, -4);

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
  $sql = "SELECT number,name FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` ON ost_ticket.ticket_id = ost_ticket__cdata.ticket_id INNER JOIN `ost_user` ON ost_ticket.user_id = ost_user.id WHERE ost_ticket__cdata.ticket_id=".$id." ";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $tktno = $row["number"];               //ticket number
        $name = $row["name"];                 //school name
      }
  } else {
      echo "0 results";
  }
  // Close connection
  $conn->close();

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Feedback form</title>

<link href="css/bootstrap.min.css" rel="stylesheet" >
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script  src="js/main.js"></script>
<script  src="js/rebrandly.js"></script>
<!--Change the script of button-->
<script>
function showText(obj){
  if(document.getElementById('submit').disabled){
    document.getElementById('submit').disabled = false;
    document.getElementById('message').disabled = false;
  }
}
var rebrandlyClient = require("js/rebrandly.js");

var linkDef = {
    "title": "My first link",
    "slashtag": "test"+ Math.floor(Math.random()*999999),
    //for the sake of example, slashtag should always be different
    "destination": "http://192.168.18.172/support/sms/index.php?id=22312512"
  };

function onError(err){
    console.log(JSON.stringify(err))
}

rebrandlyClient.getAccount(function(account) {
    rebrandlyClient.createNewLink(linkDef, function(link){
        console.log("Congratulations ", account.fullName, "! You just created your first link.")
        console.log("Link ID is: ", link.id)
        console.log("Short URL is: http://", link.shortUrl)
        console.log("Destination URL is: ", link.destination)
  }, onError);
}, onError)

</script>
<!------ Include the above in your HEAD tag ---------->

</head>
<body>

<div class="container">
    <div class="row  cont-bord">
    <h2 class="heading-size text-center mar-top">Feedback</h2>

      <div class="col-md-9 col-md-offset-0">
      <img src="images/ds-logo.png"/>
        <div class="">

          <form class="form-horizontal" action="save.php" method="post">
          <fieldset>

            <!-- School Name-->
            <div class="form-group mar-top10">
              <!--<label class="col-md-3 control-label" for="name">School Name</label>-->
              <div class="col-md-9">
          <?php  echo "<input type='text' class='name' name='nam' value='". $name ."' readonly>"; ?>
          <!--<input type='text' class='name' value='D.M PUBLIC SCHOOL' readonly>-->
              </div>
            </div>

            <!-- Ticket Number-->
            <div class="form-group">
              <!--<label class="col-md-3 control-label" for="email">Ticket Number</label>-->
              <div class="col-md-9">
                <?php  echo "#<input type='text' class='tkt' name='tktno' value='". $tktno ."' readonly>"; ?>
              </div>
            </div>

			<!-- Rating -->
            <div class="form-group">
             <!-- <label class="col-md-3 control-label" for="message">Rating</label>-->
              <div class="col-md-9" onclick='showText(this)'>
                <input id="input-21e" value="0" type="number" class="rating" min=0 max=5 step=0.5 data-size="xs" name="rate">
              </div>
            </div>

            <!-- Message body -->
            <div class="form-group">
              <label class="col-md-3 control-label" for="message">Additional feedback/Comments </label>
              <div class="col-md-9">
                <textarea class="form-control" id="message" name="comment" placeholder="Please enter your feedback here..." rows="5" disabled="disabled"></textarea>
              </div>
            </div>



            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-md"  id="submit" disabled="disabled">Submit</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
    </div>


</div>

</div>

</body>
</html>
