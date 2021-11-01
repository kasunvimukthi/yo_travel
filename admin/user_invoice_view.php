<?php 
    include ('includes/check_login.php');
    include ('includes/header.php');
    include ('includes/navbar.php');
    include ('includes/sidebar.php');
    require 'db_conn.php';
    ?>
    <div class="container-fluid">
      <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Invoice
            <select  id="user_select" name="user_select" class="ml-4">
		                    	<option selected="" value="all_user" >All User</option>
		                    	<?php 
		                    		
                                    $query = "SELECT * FROM users ORDER BY User_ID ASC"; 
                                    $result = $conn->query($query);
                                    
                                    if($result->num_rows > 0){ 
                                        while($row = $result->fetch_assoc()){  
                                            echo '<option value="'.$row['User_ID'].'">ID '.$row['User_ID'].'  '.$row['Name'].'</option>'; 
                                        } 
                                    }else{ 
                                        echo '<option value="">There are no any users</option>'; 
                                    }

		                    	 ?>
		                    </select></h6>
                            <input type="hidden" name="user_id" value="0" id="user_id">
          </div>
        <div class="card-body" id="user_invoice_data"  style="height: 70vh; overflow-y: scroll;">
       
        </div>
      </div>
    </div>
  <?php 
    include ('includes/script.php');
    include ('includes/footer.php');
    include ('includes/modal.php');
  
    ?>