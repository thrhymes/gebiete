<?php
$v=1;

include 'basics.php';

// start html page
print_start("Gebiet - Auszugeben",2);

// connect DB 
$con= connect_db();


  // zeige Liste  
  echo "  <tr><td bgcolor=#BBBBBB>\n";
  echo "  \n";

//  $sqlString= "SELECT    *
  //             FROM      ( SELECT   * 
    //                       FROM      ( SELECT   * 
      //                                         FROM     `aktionen` 
        //                                       ORDER BY `OUT` DESC
          //                           ) a                         
            //               GROUP BY  `gebiet` 
              //           ) b
              //WHERE    `in` != '0000-00-00' 
              //ORDER BY `in` ASC";

  $sqlString= " SELECT * 
                FROM  ( SELECT * 
                        FROM (  SELECT DISTINCT(`gebiet`), `in`, `out` 
                                FROM `aktionen` 
                                ORDER BY `out` DESC 
                             ) a  
                        GROUP BY `gebiet` 
                        ORDER BY `in` ASC 
                      ) b 
              WHERE `in`!= '0000-00-00'
              ";

  
  $result = mysqli_query($con,$sqlString);

  echo "<table width=90%>\n<caption>Liegende Gebiete</caption>  <tr><th>Gebiet</th><th>Retour</th><th>Monate</th><th>Ausgegeben </th><th> Name </th></tr>\n";

  if ( isset($_GET['show']) ) {
  }
  else {
	  $_GET['show']="";
  }

  $rows=0;
  $count=0;

  while ($row = mysqli_fetch_array($result)) {

      $color="#ffffff";

      $rowIn=$row['in'];
      $rowOut=$row['out'];
      $count++;
      $show=0;

      // > 6 monate --> Rot
      if ( ( strtotime(date("Y-m-d")) - strtotime($rowIn) ) > 15552000 ) {
           $color= "#FFDDDD";
           $show=1;   
      }  
      // > 4 monate --> Gelb
      elseif ( ( strtotime(date("Y-m-d")) - strtotime($rowIn) ) > 10368000 ) {
           $color= "#FFFFDD";
           $show=1;
      }  
      // wir zeigen auf alle f lle 36 Zeilen , die passen auf ein a4
      elseif ( $count < 37 ) {
           $show=1;
      }
      // mehr zeigen wir nur auf wunsch
      else {
          if ( $_GET['show']=="all" ) {
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
          echo "  <tr><td style=\"border-bottom: 1px solid black; background-color:".$color.";\">".
		"<a href=\"https://gebiete.x-s.at/aktionen.php?action=choose&gebiet=". $row['gebiet'] ."\">" . $row['gebiet'] . "</a>".
                "</td><td style=\"border-bottom: 1px solid black; background-color:".$color.";\">" . $row['in'] . 
                "</td><td style=\"border-bottom: 1px solid black; background-color:".$color.";\">" . floor( ( strtotime(date("Y-m-d")) - strtotime($rowIn) ) / (30*24*60*60) ) . 
                "</td><td style=\"border-bottom: 1px solid black; background-color:".$color.";\">" .
                "</td><td width=200px style=\"border-bottom: 1px solid black; background-color:".$color.";\">" .
                "</td></tr>\n";
      }

  }
  echo "</table>\n";  
  echo "</td></tr>";
  echo "</table>\n";
  echo "<form>";  

  if ( $_GET['show']!="all" ) {
      echo "<a href=\"auszugeben.php?show=all\"> mehr</a>";
  }

// close DB
close_db($con);

// end HTML
print_end();
 
?>
