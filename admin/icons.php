<?php 
    include ('includes/check_login.php');
    include ('includes/header.php');
    include ('includes/navbar.php');
    include ('includes/sidebar.php');
    ?>
    <div class="container-fluid">
      <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Icons
            <button  name="Bot_Add" class="btn btn-primary"data-toggle="modal" id="Icon_Add">Add New</button></h6>
          </div>
        <div class="icons_body" id="icons_data" style="height: 70vh; overflow-y: scroll;">
          <i class="" style="font-size: 15px;"></i>
        </div>
      </div>
    </div>
  <?php 
    include ('includes/script.php');
    include ('includes/footer.php');
    include ('includes/modal.php');
    ?>
