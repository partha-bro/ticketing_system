<?php

require('staff.inc.php');
require_once(STAFFINC_DIR.'header.inc.php');
require('connDB.php');                          //database connection
?>
<link rel="stylesheet" type="text/css" href="css/info_tab.css"/>
<script src="js/jquery-1.12.4.min.js"></script>
<script>
  $(document).ready(function(){
      $('.search-box input[type="text"]').on("keyup input", function(){
          /* Get input value on change */
          var inputVal = $(this).val();
          var resultDropdown = $(this).siblings(".result");
          if(inputVal.length){
              $.get("backend-search.php", {term: inputVal}).done(function(data){
                  // Display the returned data in browser
                  resultDropdown.html(data);
              });
          } else{
              resultDropdown.empty();
          }
      });
      // Set search input value on click of result item
      $(document).on("click", ".result p", function(){
          $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
          $(this).parent(".result").empty();
      });
  });
</script>
<div class="body_div">
		<h3>Feedback Information</h3>
    	<div class="info_div attached input">
          <form action='<?php echo $_SERVER['PHP_Self']; ?>'>
              <button name="show_data" class="action-button" id="show_data">Full Info</button>
              <div class="search-box">
                  <input type="text" autocomplete="off" placeholder="Search Field" name="search" id="search"/>
                  <div class="result"></div>
              </div>
              <button name="search_btn" class="attached button" id="search_btn" value="1">Go</button>
    			     <!--<input type="search" name="search" class="basic-search" size="30" id="search" placeholder="Search Field" />-->
          </form>
    			<button name="upload_btn" id="upload_btn" class="action-button" onclick="showUpload();">export CSV</button><br/>
    	</div>
    	<div class="data-table" id="show_table_data"><br/>
    		<table border="1px" class="scroll">
      			<tr>
      				<th>ID</th>
      				<th>School_name</th>
      				<th>Ticket_number</th>
              <th>Rateing</th>
      				<th>Message</th>
      				<th>Date</th>
      			</tr>
    		  <?php
          if(isset($_GET['search_btn'])){
              $search = $_GET['search'];
              $query = "select * from ost_feedback where tktno='".$search."'";     //display searched data
          } else if(isset($_GET['show_data'])){
              $query = "select * from ost_feedback";                                      //display all data present inside the table
          } else {
              $query = "select * from ost_feedback"; //where id < 12";                      //sample data show on the table
          }
    				$sql = mysqli_query($link,$query);
    			    	while($row=  mysqli_fetch_array($sql))
    			    	{
            			?>
            			<tr>
                    <td><?php echo $row['id']; ?></td>
            				<td><?php echo $row['name']; ?></td>
            				<td><?php echo $row['tktno']; ?></td>
            				<td><?php echo $row['rate']; ?></td>
                    <td><?php echo $row['message']; ?></td>
            				<td><?php echo $row['date']; ?></td>
            			</tr>
            		  <?php
            			     	}
            			?>
    		</table>
    	</div>
</div>
<?php
  require_once(STAFFINC_DIR.'footer.inc.php');
?>
