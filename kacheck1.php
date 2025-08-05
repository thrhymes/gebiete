<?php
$v=1;

include 'basics.php';

// start html page
print_start("Gebiet - KA-Check",2);

// connect DB 
$con= connect_db();

  // zeige Liste  
  echo "  <tr><td bgcolor=#BBBBBB>\n";
  
  $sqlString= " SELECT   * 
                FROM      ( SELECT   * 
                            FROM     `aktionen` 
                            ORDER BY `OUT` DESC
                          ) a                
                WHERE    `in` != '0000-00-00'
                GROUP BY  `gebiet` 
                ORDER BY `in` desc";
  
  $sqlString= " SELECT * 
                FROM ( SELECT * 
                       FROM ( SELECT   `gebiet`, `in`, `out`, `name` 
                              FROM     `aktionen` 
                              ORDER BY `in` DESC
                            ) a               
                       WHERE `in` >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 365 DAY), '%Y-%m-%d')
                       GROUP BY  `gebiet` 
                       ORDER BY `in` DESC 
                     ) b 
                # WHERE `in` != '0000-00-00' 
              ";

$sqlString= " SELECT   `gebiet`, `in`, `out`, `name` 
              FROM     `aktionen` 
              WHERE    ((`in` >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 360 DAY), '%Y-%m-%d') 
                       OR `in` = '0000-00-00'))
              ORDER BY `gebiet` asc
                              
              ";

$sqlString= "SELECT a1.`gebiet`, a1.`out`, MAX(a1.`in`) AS `min`
FROM `aktionen` a1
WHERE a1.`gebiet` NOT IN (
    SELECT DISTINCT a2.`gebiet`
    FROM `aktionen` a2
    WHERE a2.`in` >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
)
Group BY a1.`gebiet`
ORDER BY a1.`gebiet`";

$sqlString = "SELECT a1.`gebiet`, a1.`out`, MAX(a1.`in`) AS `min`
FROM `aktionen` a1
WHERE a1.`gebiet` NOT IN (
    SELECT DISTINCT a2.`gebiet`
    FROM `aktionen` a2
    WHERE a2.`in` > DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    AND a2.`in` <= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
)
Group BY a1.`gebiet`
ORDER BY a1.`gebiet`";

  $result = mysqli_query($con,$sqlString);

  echo "<table width=90%>\n<caption>Gebiete die l&auml;nger als 12 Monate nicht bearbeitet wurden</caption>  <tr><th> # </th><th> Gebiet </th><th> Retour </th><th> Monate </th><th> im Umlauf </th></tr>\n";

  $rows=0;
  $counter=0;

  while ($row = mysqli_fetch_array($result)) {

    $color="#ffffff";
    
    $rowIn=$row['min'];
    $rowOut=$row['out'];
	
    
    $show=1;
    // wir zeigen aber nur aktive gebiete
    $sql= "SELECT * FROM `gebiet` WHERE `gebiet`=".$row['gebiet'].";"; 
    $res= mysqli_fetch_array( mysqli_query( $con, $sql ) );
    if ( $res['aktiv']==0 ) {
        $show=0;
    }

    // wir zeigen alles was �lter als 10 Monate ist
    if     ( ( strtotime(date("Y-m-d")) - strtotime($rowIn) ) > 15552000 AND ( strtotime(date("Y-m-d")) - strtotime($rowIn) ) < 30758400 and $show==1 ) {
$counter++;
        // > 12 monate --> Rot
        if     ( ( strtotime(date("Y-m-d")) - strtotime($rowIn) ) > 30758400 ) {
             $color= "#FFBBBB";
        } 
  

        echo "  <tr><td>".$counter."</td><td style=\"border-bottom: 1px solid black; background-color:".$color.";\">" . $row['gebiet'] . 
             "</td><td style=\"border-bottom: 1px solid black; background-color:".$color.";\">" . $row['min'] . 
             "</td><td style=\"border-bottom: 1px solid black; background-color:".$color.";\">" . floor( ( strtotime(date("Y-m-d")) - strtotime($rowIn) ) / (30*24*60*60) ) . 
             "</td><td style=\"border-bottom: 1px solid black; background-color:".$color.";\">";

        // ist das gebiet gerade ausgegeben? wer hat es?
        $sqlString= "SELECT * FROM `aktionen` as akt, `bibellehrer` as bib WHERE akt.`gebiet`='".$row['gebiet']."' AND akt.`in`='0000-00-00' AND akt.`name`=bib.`index`";
        $resultat= mysqli_fetch_array( mysqli_query($con, $sqlString));
        // print_r($resultat)."<br>";
        if ( $resultat['in']=="0000-00-00" ) { 
            echo $resultat['vorname']." ".$resultat['nachname']." ".$resultat['out'];
        }
        echo  "</td></tr>\n";

        }
  }
  echo "</table>\n";  
  echo "</td></tr>";
  echo "</table>\n";  


  echo "<form>";  

// close DB
close_db($con);

// end HTML
print_end();
 
?>
