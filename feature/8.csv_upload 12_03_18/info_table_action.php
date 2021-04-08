<link rel="stylesheet" type="text/css" href="css/info_tab.css"/>
<fieldset class="action_table">
  <legend align="center">Upload status</legend>
  <div class=div_body>
    <?php
      require('connDB.php');            //database connection
      // upload file
      if(isset($_POST["submit"])){
      	$file_name = $_FILES["fileToUpload"]["name"];
      	$new_file_name = $file_name;
        if($new_file_name == "school_info.csv"){
        	$target_dir = "uploads/";                                                      //target folder for uploaded pdf
        	$target_file = $target_dir.$new_file_name;
        	$uploadOk = 1;                                                                 //this value for upload status
        	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        	// Check if pdf file is a actual pdf or not
        	if($imageFileType == "csv") {
        		if($_FILES["fileToUpload"]["size"]){
        			$uploadOk = 1;
        		}else{
        			$uploadOk = 2;
        		}
        	}else {
        		$uploadOk = 0;
        	}
        	// Check if $uploadOk is set to 0 by an error
        	if ($uploadOk == 0) {
        		echo "<span class='note_result'>Sorry, your file was not uploaded.</span>";
        	// if everything is ok, try to upload file
        	}else if ($uploadOk == 2) {
        		echo "<span class='note_result'>Your file size is not less than 3MB.</span>";
        	// if everything is ok, try to upload file
        	}else{
        		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        			$query = "select * from ost_record";
        			$sql = mysqli_query($link,$query);
        			if(mysqli_num_rows($sql) > 0){
        				mysqli_query( $link,"DELETE FROM ost_record" );
        				//echo "<script>alert('delete all data.');</script>";
        				$handle = fopen($target_file,"r");

        				// assuming that first row has collumns names
        				$query = "INSERT INTO ost_record(";
        				$cols = fgetcsv($handle,100000,';','"');
        				$query .= implode(", ",$cols).") VALUES";

        				$values = "";

        				// cycle through each row and build mysql insert query
        				while($data = fgetcsv($handle,100000,',')) {
        					$values .= " ( ";

        					foreach($data as $text) {
        						      $values .= "'".$text."', ";
        					}
        					$values = substr($values,0,-2);
        					$values .= "), ";
        				}
        					// remove last 2 chars
        				$values = substr($values,0,-2);
        				$query .= $values;
        				$sql = mysqli_query($link,$query);
                $date = date("F d Y",filemtime($target_file));                      //last upload date
                $query1 = "UPDATE `ost_record` SET `upload_date`='$date' WHERE 1 ";
                $sql1 = mysqli_query($link,$query1);
        				if($sql){
        					echo "<span class='note_result'>File has successfully uploaded.</span>";
        				}
        				else{
        					echo "<span class='note_result'>File has not successfully uploaded.</span>";
        				}
        				fclose($handle);
        			}else{
        				$handle = fopen($target_file,"r");

        				// assuming that first row has collumns names
        				$query = "INSERT INTO ost_record(";
        				$cols = fgetcsv($handle,100000,';','"');
        				$query .= implode(", ",$cols).") VALUES";

        				$values = "";

        					// cycle through each row and build mysql insert query
        				while($data = fgetcsv($handle,100000,',')) {
        					$values .= " ( ";

        					foreach($data as $text) {
        						$values .= "'".$text."', ";
        					}

        					$values = substr($values,0,-2);
        					$values .= "), ";
        				}
        				// remove last 2 chars
        				$values = substr($values,0,-2);
        				$query .= $values;
        				$sql = mysqli_query($link,$query);
        				if($sql){
        					echo "<span class='note_result'>File has successfully uploaded.</span>";
        				}
        				else{
        					echo "<span class='note_result'>File has not successfully uploaded.</span>";
        				}
        				fclose($handle);
        			}
        		} else {
        			echo "<span class='note_result'>Sorry, there was an error uploading your file.</span>";
        		}
        	}
        } else {
            echo "<span class='note_result'>Sorry, you have uploaded different file.</span>";
        }
      } else {
        echo "<span class='note_result'>Sorry, you are not uploading a file.</span>";
      }
    ?>
    <br/><br/>
    <button name="back_btn" id="back_btn" onclick="window.history.back();">Back</button>
  </div>
</fieldset>
