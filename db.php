<?php
//server with default setting (user 'root' with no password)
$host = 'localhost';  // server 
$user = 'root';   
$pass = "";   
$database = 'airbus_rizeen';   //Database Name  

// establishing connection
  $conn = mysqli_connect($host,$user,$pass,$database);   

 // for displaying an error msg in case the connection is not established
  if (!$conn) {                                             
    die("Connection failed: " . mysqli_connect_error());     
  }

$query_update = "SELECT ID FROM airbus_update";
$result_update = mysqli_query($conn, $query_update);
    $query_update = "CREATE TABLE airbus_update(
    id int(12) NOT NULL AUTO_INCREMENT,
    UpdatedRowRevenue VARCHAR(255),
    PRIMARY KEY (id)
    )";
    $result_update = mysqli_query($conn, $query_update);    

$query_airbus = "SELECT ID FROM airbus_record";
$result_airbus = mysqli_query($conn, $query_airbus);
    $query_airbus = "CREATE TABLE airbus_record (
      record_id INT NOT NULL,
      ItinID VARCHAR(255) NOT NULL,
      MktID VARCHAR(255) NOT NULL,
      MktCoupons INTEGER NOT NULL,
      Quarter INTEGER NOT NULL,
      Origin VARCHAR(255) NOT NULL,
      OriginWac INTEGER NOT NULL,
      Dest VARCHAR(255) NOT NULL,
      DestWac INTEGER NOT NULL,
      Miles INTEGER NOT NULL,
      ContiguousUSA INTEGER NOT NULL,
      NumTicketsOrdered INTEGER NOT NULL,
      AirlineCompany VARCHAR(255) NOT NULL,
      PricePerTicket DECIMAL(10 , 2 ) NOT NULL,
      RowRevenue DECIMAL(10 , 2 ),
      PRIMARY KEY (record_id)
)";
    $result_airbus = mysqli_query($conn, $query_airbus);

$csv_airbus = 'select record_id from airbus_record where record_id=1';
$csv_query = mysqli_query($conn, $csv_airbus );
$rowcount_csv=mysqli_num_rows($csv_query);
if($rowcount_csv==0){
    $sql = "LOAD DATA INFILE '../../htdocs/airbus_rizeen/Cleaned_2018_Flights.csv' INTO TABLE airbus_record"
. " FIELDS TERMINATED BY ','"
. " LINES TERMINATED BY '\n'"
. " IGNORE 1 LINES";
  if (!($stmt = $conn->query($sql))) {
    echo "\nQuery execute failed: ERRNO: (" . $conn->errno . ") " . $conn->error;
  }
}

$UpdatedRowRevenue = 'select UpdatedRowRevenue from airbus_update where id=1';
$UpdatedRowRevenue_query = mysqli_query($conn, $UpdatedRowRevenue );
$rowcount_Updated=mysqli_num_rows($UpdatedRowRevenue_query);
if( $rowcount_Updated==0 ){
  $update_row_rev = 'update airbus_record set RowRevenue=NumTicketsOrdered*PricePerTicket';
  $update_row_rev_query = mysqli_query($conn, $update_row_rev );
  $insert = 'insert into airbus_update (UpdatedRowRevenue) VALUES ("YES")';
  $insert_query = mysqli_query($conn, $insert );
}