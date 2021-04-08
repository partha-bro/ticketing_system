<?php

require('staff.inc.php');
require_once(STAFFINC_DIR.'header.inc.php');
require('connDB.php');                          //database connection
?>
<link rel="stylesheet" type="text/css" href="css/info_tab.css"/>
<script src="js/jquery-1.12.4.min.js"></script>
<script>
	function showUpload(){
		if(document.getElementById("upload_btn").innerHTML == 'Upload CSV'){
			document.getElementById("hide").style.display = 'block';
			document.getElementById("upload_btn").innerHTML='Hide'
		}else{
			document.getElementById("hide").style.display = 'none';
			document.getElementById("upload_btn").innerHTML='Upload CSV'
		}
	}
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
		<h3>School Information</h3>
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
    			<button name="upload_btn" id="upload_btn" class="action-button" onclick="showUpload();">Upload CSV</button><br/>
    	</div>
    	<div class="hide_div" style="display: none;" id="hide"><br/>
    		<fieldset>
    			<legend>Update DATA</legend>
          		<p style="color:red">
          					<?php
          						$query_date="select upload_date from ost_record order by upload_date asc limit 1";
          						$sql_date = mysqli_query($link,$query_date);
          						$obj = mysqli_fetch_array($sql_date);
          						echo "Last uploaded ticket_info file -> ".$obj[0];          //print last date of uploading file
          					?>
          		</p>
          		<div>
          			<form action="info_table_action.php" method="post" enctype="multipart/form-data">
          				<input type="file" name="fileToUpload" id="fileToUpload" accept=".csv"/>
                  <input type="button" class="action-button" id="select_btn" onclick="document.getElementById('fileToUpload').click()" value="Select a File" />
          				<button name="submit" class="action-button" id="submit">Upload</button>
          			</form>
          		</div>
    		</fieldset>
    	</div>
    	<div class="data-table" id="show_table_data"><br/>
    		<table border="1px" class="scroll">
      			<tr>
      				<th>S_no</th>
      				<th>Account_code</th>
      				<th>School_name</th>
      				<th>Address</th>
              <th>Model</th>
      				<th>Agreement_number</th>
      				<th>Agreement_date</th>
      				<th>Period</th>
      				<th>Agreement_expiry_date</th>
              <th>No_of_cr</th>
      				<th>Rate_per_cr</th>
              <th>Qtrly_billing</th>
      				<th>O_S</th>
      			</tr>
    		  <?php
          if(isset($_GET['search_btn'])){
              $search = $_GET['search'];
              $query = "select * from ost_record where account_code='".$search."'";     //display searched data
          } else if(isset($_GET['show_data'])){
              $query = "select * from ost_record";                                      //display all data present inside the table
          } else {
              $query = "select * from ost_record where s_no < 12";                      //sample data show on the table
          }
    				$sql = mysqli_query($link,$query);
    			    	while($row=  mysqli_fetch_array($sql))
    			    	{
            			?>
            			<tr>
                    <td><?php echo $row['s_no']; ?></td>
            				<td><?php echo $row['account_code']; ?></td>
            				<td><?php echo $row['school_name']; ?></td>
            				<td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['model']; ?></td>
            				<td><?php echo $row['agreement_number']; ?></td>
            				<td><?php echo $row['agreement_date']; ?></td>
            				<td><?php echo $row['period']; ?></td>
                    <td><?php echo $row['agreement_expiry_date']; ?></td>
            				<td><?php echo $row['no_of_cr']; ?></td>
            				<td><?php echo $row['rate_per_cr']; ?></td>
            				<td><?php echo $row['qtrly_billing']; ?></td>
                    <td><?php echo $row['o_s']; ?></td>
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
