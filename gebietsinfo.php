<?php
include 'basics.php';

// start HTML
print_start("Gebiet - Gebietsinfoblatt",1);
 
// connect DB
$con= connect_db();

// wir bekommen $_GET['gebiet'] um zu wissen von welchem gebiet das blatt erstellt wird

// header mit Gebeitsnummer und Wohneinheiten
  
$sql= "SELECT * FROM `gebiet` WHERE `gebiet`=".$_GET['gebiet'].";";
  
$result= mysqli_query( $con, $sql);
$row = mysqli_fetch_array($result);
  
  echo "<table width=100% border=0>\n".
       "<tr><td             ><h1>Gebiet: ".$_GET['gebiet']. "</h1></td>".
           "<td align=\"right\" ><h1>WE: ".$row['wohnungen'].   "</h1></td>".
       "</tr>\n</table>\n";
  
  echo "\nPersonen die nicht besucht werden m&ouml;chten<br>\n".
       "<table width=100% border=1>\n<tr><td>Datum</td><td>Name/<br>Adresse</td><td>Bemerkung</td></tr>\n";

  $sqlString= "SELECT * FROM niewieder WHERE `gebiet`='".$_GET['gebiet']."' AND aktiv='1' ";

$result = mysqli_query($con,$sqlString);
$rows=0;

while ($row = mysqli_fetch_array($result)) {

    echo "  <tr><td>" . $row['datum'] .
          "</td><td>" . $row['name'] .
          "     <br>" . $row['adresse'] .
          "</td><td>" . $row['bemerkung'] .
          "</td></tr>\n";
  
    $rows++;

}

echo "\n<tr><td><br><br></td><td></td><td></td></tr>\n<tr><td><br><br></td><td></td><td></td></tr>\n</table>\n";

  
mysqli_close($con);

print_end();;
?> 