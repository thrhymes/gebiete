<?php
/*
bearbeiterstat.php

hier suchen wir Verk�ndiger und zeigen die fertig bearbeiteten gebiete der letzten 3 Jahre an

*/

include 'basics.php';

// start HTML
print_start("Gebiet - Gebietsbearbeiter Statistik",1);
 
// connect DB
$con= connect_db();

  
// Wir suchen die aktiven Bibellehrer
$sql= "  SELECT             * 
         FROM               bibellehrer 
         WHERE              aktiv=1 
		 ORDER BY 			nachname ASC 
      ";

$result= mysqli_query( $con, $sql );


  
echo "<div class=\"scroller\">";
echo "<table width=100%>\n  <tr><th>Name</th><th>derzeit</th><th>im letzten jahr</th></tr>\n";

$rows= 0;
while ( $row= mysqli_fetch_array($result) ) {

    
    echo "  <tr><td>" . $row['nachname'] . " " . $row['vorname'] . "</td>";
    echo "  <td class=\"border\">";  
  
    $sql1= " SELECT * FROM aktionen WHERE `name`='" .$row['index'] . "' and `in`=0000-00-00";
    $result1= mysqli_query( $con, $sql1 );
    $komma= "";
    while ( $row1= mysqli_fetch_array($result1) ) {
        echo $komma . $row1['gebiet'];
        $komma= ", ";
        // var_dump($row1);
    }
    echo "</td><td class=\"border\">";              
    $sql1= " SELECT * FROM aktionen WHERE `name`='" .$row['index'] . 
           "' and `in` >= date_sub( curdate(), interval 356 day ) ";
    $result1= mysqli_query( $con, $sql1 );
    $komma1= "";
    while ( $row1= mysqli_fetch_array($result1) ) {
        echo $komma1 . $row1['gebiet'];
        $komma1= ", ";
        // var_dump($row1);
    }
    echo "</td></tr>\n";
  
}

echo "  </table>\n";
echo "</div>\n";
  
mysqli_close($con);

print_end();;
?> 


