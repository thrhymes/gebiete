<?php
include 'basics.php';

// start HTML
print_start("Gebiet - Gebiete",1);
 
// connect DB
$con= connect_db();

// insert new data or change data as needed

for ( $i=31; $i<=300; $i++) {
    $sqlString = "INSERT INTO gebiet (gebiet, wohnungen, bemerkung, aktiv, alt) VALUES (".$i.",0 ,'', 1, 0)";
                            
    mysqli_query($con,$sqlString);
}
  
  
mysqli_close($con);

print_end();;
?> 


