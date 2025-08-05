<?php
$v=1;

include 'basics.php';

// start html page
print_start("Gebiet - Einzusammeln",2);

// connect DB 
$con= connect_db();


  // zeige Liste  
  // echo "  <tr><td bgcolor=#BBBBBB>\n";


  $sqlString= "SELECT   * 
               FROM     `aktionen`
               WHERE    `in`='0000-00-00'
               ORDER BY `out` ASC";

  $result = mysqli_query($con,$sqlString);

  echo "<table width=90%>\n<caption>Ausgegebene Gebiete</caption><tr><th>Gebiet</th><th>Ausg.</th><th>Retour-Soll</th><th>Retour-Ist</th><th>Name</th></tr>\n";

  $rows=0;
  $count=0;
  while ($row = mysqli_fetch_array($result)) {

      $color="#ffffff";

      $rowIn=$row['in'];
      $rowOut=$row['out'];
      $show=0;
      $count++;

      // > 6 monate --> Rot
      if ( (  strtotime(date("Y-m-d")) - strtotime($rowOut) ) > 15552000 ) {
           $color= "#FFDDDD";
           $show=1;         
      } 
      // > 4 monate --> Gelb
      elseif ( ( strtotime(date("Y-m-d")) - strtotime($rowOut) ) > 10368000 ) {
           $color= "#FFFFDD";
           $show=1;
      } 
      elseif ( $count < 37 ) {
           $show=1;
      }
      // mehr zeigen wir nur auf wunsch
      else {
          if ( $_GET['show'] and $_GET['show']=="all" ) {
              $show=1;
          }
      }

      // wir zeigen aber nur aktive gebiete
      $sql= "SELECT * FROM `gebiet` WHERE `gebiet`=".$row['gebiet'].";"; 
      $res= mysqli_fetch_array( mysqli_query( $con, $sql ) );
      if ( $res['aktiv']==0 ) {
          $show=0;
      }

      if ( $show==1 ) {
          echo "  <tr><td style=\"border-bottom: 1px solid black; background-color:".$color.";\">" .
		"<a href=\"https://gebiete.x-s.at/aktionen.php?action=choose&gebiet=". $row['gebiet'] ."\">" . $row['gebiet'] . "</a>". 
                "</td><td style=\"border-bottom: 1px solid black; background-color:".$color.";\">" . $row['out'] . 
                "</td><td style=\"border-bottom: 1px solid black; background-color:".$color.";\">" . date("Y-m-d",strtotime($rowOut)+15552000) . 
                "</td><td style=\"border-bottom: 1px solid black; background-color:".$color.";\">" .
                "</td><td width=300px style=\"border-bottom: 1px solid black; background-color:".$color.";\">";

          $sql= "SELECT * FROM `bibellehrer` WHERE `index`=".$row['name'].";"; 
          $res= mysqli_fetch_array( mysqli_query( $con, $sql ) );
    
          echo  $res['nachname']." ".$res['vorname'].
                "</td></tr>\n";
      }
      
  }
  // echo "</table>\n";  
  // echo "</td></tr>";
  echo "</table>\n";
  echo "<form>";  

  if ( $_GET['show']!="all" ) {
      echo "<a href=\"einzusammeln.php?show=all\"> mehr</a>";
  }

// close DB
close_db($con);

// end HTML
print_end();
 
?>
