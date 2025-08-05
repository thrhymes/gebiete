<?php
$v=1;

include 'basics.php';

echo "<!DOCTYPE html>\n".
       "<html lang=\"de\">\n".
       "<head>\n".
       // "  <meta charset=\"utf-8\">".
       "  <meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\">".
       "  <title>Gebiet - Graph </title>".
       // "  <link rel=\"stylesheet\" type=\"text/css\" href=\"formate.css\">".
       "</head>\n".
       "<body><div >\n";

// connect DB 
$con= connect_db();

  $divider= 86400; // sekunden pro tag

  $sqlString= "SELECT   min(`out`) 'out'
               FROM     `aktionen`";

  $result= mysqli_query($con,$sqlString);

  $row= mysqli_fetch_array($result);

  // print_r($row);

  $firstDate= (strtotime(date('Y-m-d'))-(720*$divider)); // start 5 Weeks before first date
  $lastDate=  strtotime(date('Y-m-d'));  // go until today
  $difDate=   $lastDate-$firstDate;
  $scaleDate= floor( $difDate / $divider );
  echo "<h1>Grafischer Check</h1><p>grün ... frei</br>orange ... bearbeitet (mit maus drüberfahren)</p>";
  echo "<br>Erstes Datum.: (".date("Y-m-d", $firstDate)."), Heute.: (".date('Y-m-d')."), Sekunden-Differenz.: ".$difDate.", Tage.: ".$scaleDate."<br>";

  // wir füllen ein Array mit den Verkündigern
  $verk;
  $result = mysqli_query($con,"SELECT * FROM bibellehrer ORDER BY nachname ASC");
  while ( $row= mysqli_fetch_array($result) ) {
      $verk[$row['index']]=$row['nachname']." ".$row['vorname'];
  }

  // Wir holen uns die Gebietsnummern aufsteigend sortiert
  $sqlString= "SELECT `gebiet` FROM `aktionen` GROUP BY `gebiet` ORDER BY `gebiet` ASC";
  $result= mysqli_query($con,$sqlString);
  
  echo "<table border=0>\n";

  // wir gehen Gebietsweise durch die Liste
  while ( $row= mysqli_fetch_array($result) ) {

      echo "<tr><td>".$row['gebiet']."</td>";

      // Wir lesen zeilen sortiert nach dem ausgabedatum
      $res= mysqli_query ( $con, "SELECT * FROM `aktionen` where `gebiet`='".$row['gebiet']."' ORDER BY `out` ASC" );

      $first=1;
      $lastIn=0;
      $sumwidth=0;
      echo "<td>";

      // schleife
      while ( $r = mysqli_fetch_array($res) ) {

          // print_r($r);

          // für die erste Zeile, die wir verarbeiten
          if ( $first == 1 ) {

               // nehmen wir das erste Ausgabedatum und zeichnen den startbalken bis dorthin
               $width= ceil( ( strtotime($r['out']) - $firstDate ) / $divider / 2);
               print "<img style=\" width: ".$width."px; height:20px;\" src=\"pix_bright.gif\" />";
               // echo $r['out'].$r['in']."<br>";
               $sumwidth += $width;
          }
          
          // wenn wir schon einen kompletten eintrag verarbeitet haben, füllen wir den freiraum zum nächsten
          else {
               $width= ceil( ( strtotime($r['out']) - strtotime($lastIn) ) / $divider / 2 ) ;
               print "<img style=\" width: ".$width."px; height:20px\" src=\"pix_green.gif\" title=\"Frei; ".$width." Tage\"/>";
               // echo $r['out'].$r['in']."<br>";
               $sumwidth += $width;
          }

          // Wenn es noch nicht abgeschlossen ist, gehts bis heute - das ist die letzte zeile
          if ( $r['in'] == "0000-00-00" ) {

               $width= ceil( ( $lastDate - strtotime($r['out']) ) / $divider / 2 ) ;
               print "<img style=\" width: ".$width."px; height:20px\" src=\"pix_orange.gif\" title=\"".$verk[$r['name']]."; ".$width." Tage\"/>";
               // echo $r['out'].$r['in']."<br>";
               $sumwidth +=  $width;
          }
          // wenn es abgeschlossen ist, zeichnen wir die bearbeitung komplett
          else {
               $width= ceil( ( strtotime($r['in']) - strtotime($r['out']) ) / $divider / 2  ) ;
               print "<img style=\" width: ".$width."px; height:20px\" src=\"pix_orange.gif\" title=\"".$verk[$r['name']]."; ".$width." Tage\"/>";
               // echo $r['out'].$r['in']."<br>";
               $sumwidth += $width;
          }

          // wir merken uns das letzte rückgabedatum
          $lastIn=$r['in'];
          $lastOut=$r['out'];
          $first=0;
          // echo $lastIn;
      }
      if ( $lastIn != "0000-00-00" ) {

               $width= ceil( ( $lastDate - strtotime($lastIn) ) / $divider / 2  ) ;
               print "<img style=\" width: ".$width."px; height:20px\" src=\"pix_green.gif\" />";
               // echo $r['out'].$r['in']."<br>";
               $sumwidth +=  $width;
      }
      echo "</td>";
      // echo "<td>$sumwidth</td>";
      echo "</tr>\n";

  }
  echo "</table>\n";

// close DB
close_db($con);

// end HTML
print_end();
 
?>
