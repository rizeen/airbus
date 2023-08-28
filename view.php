<!-- Header -->
<?php  include 'header.php'?>
  <div class="container mt-5">
    <h2 class="text-center">Total Revenue:        
      <?php
        if (isset($_GET['AirlineCompany'])) {
          $AirlineCompany = $_GET['AirlineCompany']; 
          $query="SELECT SUM(if(AirlineCompany = '$AirlineCompany',RowRevenue,0)) AS TotalRevenue
          FROM airbus_record";                 
          $view_users= mysqli_query($conn,$query);            
          while($row = mysqli_fetch_assoc($view_users))
          {
            echo $row["TotalRevenue"];
          }
        }
      ?>
    </h2>
  </div>