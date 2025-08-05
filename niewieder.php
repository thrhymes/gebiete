<?php
include 'basics.php';

// start HTML
print_start("Gebiet - Gebiete",1);
 
// connect DB
$con= connect_db();

// insert new data or change data as needed
// if ( $_GET['gebiet']>0 AND $_GET['name']<>"" AND $_GET['adresse']<>"" ) ) {
    
  if ( $_GET['action']=="new" ) {

    // INSERT INTO `niewieder` (`index`, `gebiet`, `name`, `adresse`, `datum`, `bemerkung`, `aktiv`) VALUES (NULL, '1', 'test', 'test', '2013-01-01', 'böser WI', '1');
    $sqlString = "INSERT INTO niewieder (`index`, `gebiet`, `name`, `adresse`, `datum`, `bemerkung`, `aktiv`) VALUES".
                 "( NULL, '".$_GET['gebiet'].
                      "', '".$_GET['name'].
                      "', '".$_GET['adresse'].
                      "', '".$_GET['datum'].
                      "', '".$_GET['bemerkung']."', '1')";
                            
    mysqli_query($con,$sqlString);
    
  }
  elseif ( $_GET['action']=="change" ) { 

    $separator="";
    $sqlString = "UPDATE `niewieder` SET";
    if ($_GET['name']<>"")      {$sqlString.= $separator." `name`='".$_GET['name']."'"; $separator=","; };
    if ($_GET['datum']<>"")     {$sqlString.= $separator." `datum`='".$_GET['datum']."'"; $separator=","; };
    if ($_GET['adresse']<>"")   {$sqlString.= $separator." `adresse`='".$_GET['adresse']."'"; $separator=","; };
    if ($_GET['bemerkung']<>"") {$sqlString.= $separator." `bemerkung`='".$_GET['bemerkung']."'"; $separator=","; };
    $sqlString.= " WHERE `index`='".$_GET['index']."'";
    // echo "change: ".$sqlString;
    mysqli_query($con,$sqlString);
  }
  elseif ( $_GET['action']=="activate" ) { 
    
    $sqlString = "UPDATE `niewieder` SET `aktiv`='1' WHERE `index`='".$_GET['index']."';";
    
    mysqli_query($con,$sqlString);
    
  }
  elseif ( $_GET['action']=="deactivate" ) { 
    
    $sqlString = "UPDATE `niewieder` SET `aktiv`='0' WHERE `index`='".$_GET['index']."';";
    
    mysqli_query($con,$sqlString);
    
  }
// }
  
// read table and show it

// echo "<table><tr style=\"background-color:#bbbbbb;\">\n<td valign=\"top\">\n";
echo "<div class=\"scroller\">";
echo "<form action=\"niewieder.php\" method=\"get\">\n<input type=\"submit\" value=\"Filter\">\n".
     "  <select name=\"filter_gebiet\"><option>n/a</option>";

        $sqlString= "SELECT gebiet FROM niewieder GROUP BY gebiet ORDER BY gebiet ASC";

        $result= mysqli_query( $con, $sqlString );

        while ( $row = mysqli_fetch_array($result) ) {
           echo "<option";
           if ( $row['gebiet'] == $_GET['filter_gebiet'] ) { echo " selected"; };          
           echo ">".$row['gebiet']."</option>";
        }

echo "  </select>&nbsp;&nbsp;nur deaktivierte&nbsp;<input type=\"checkbox\" name=\"filter_active\"";
if ( $_GET['filter_active']=="on" ) { echo "checked=checked"; };
echo " /></form>\n".
     "  <table width=100% border=0>\n<tr><td>Id</td><td>Geb.</td><td>Datum</td><td>Name/<br>Adresse</td><td>Bemerkung</td></tr>\n";

$sqlString= "SELECT * FROM niewieder ";
$where=" WHERE ";
$separator="";
if ( $_GET['filter_gebiet']<>"" AND $_GET['filter_gebiet']!="n/a") {
    $sqlString.= $where."`gebiet`='".$_GET['filter_gebiet']."'";
    $separator=" AND ";
    $where="";
}
if ( $_GET['filter_active']=="on" ) { $sqlString.= $where.$separator."aktiv='0' "; }
else { $sqlString.= $where.$separator."aktiv='1' "; }
$sqlString.= " ORDER BY `gebiet`, `index` ASC";

// $sqlString.= " ORDER BY `index` DESC";
// echo $sqlString;

$result = mysqli_query($con,$sqlString);
$rows=0;
while ($row = mysqli_fetch_array($result)) {
/*
    if ( $rows > 29 ) {
        echo "  </table>\n</td><td valign=\"top\">\n  <table>\n".
             "  <tr><td>Eintrag</td><td>Gebiet</td><td>Datum</td><td>Name/<br>Adresse</td><td>Bemerkung</td><td>Aktiv</td></tr>\n";
        $rows=0;
    }
*/  
    $color= "#ffffff";
    if ( $_GET['index']==$row['index'] ) { 
      
      $color= "#88FF88";
    }
    
    echo "  <tr><td bgcolor=".$color.">" . $row['index'] . 
          "</td><td bgcolor=".$color.">" . $row['gebiet'] . 
          "</td><td bgcolor=".$color.">" . $row['datum'] . 
          "</td><td bgcolor=".$color.">" . $row['name'] .
          "<br>" . $row['adresse'] . 
          "</td><td bgcolor=".$color.">" . $row['bemerkung'] . 
          "</td></tr>\n";
  
    $lastGebiet=$row['Gebiet'];
    $rows++;

}

echo "  </table>\n";
echo "</div>\n";
// echo "</td></tr></table>"
echo "<table><tr><td style=\"background-color:#dddddd;\">\n\n";

  
// Formular
echo "<form action=\"niewieder.php\" method=\"get\">\n";
echo "<table><tr><td><table>\n".
     "<tr><td>Eintrag Nr. </td><td><input type=\"text\" name=\"index\" style=\"width:200px;\"></td></tr>\n".
     "<tr><td>Gebiet      </td><td><select name=\"gebiet\"><option>n/a</option>";

        $sqlString= "SELECT * FROM gebiet";

        $result= mysqli_query( $con, $sqlString );

        while ( $row = mysqli_fetch_array($result) ) {
           echo "<option>".$row['gebiet']."</option>";
        }

echo "</select>";
echo "</td></tr>\n".
     "<tr><td>Datum    </td><td><input type=\"date\" name=\"datum\"     style=\"width:200px;\" value=\"".date("Y-m-d")."\"></td></tr>\n".
     "<tr><td>Name     </td><td><input type=\"text\" name=\"name\"      style=\"width:200px;\" ></td></tr>\n".
     "<tr><td>Adresse  </td><td><input type=\"text\" name=\"adresse\"   style=\"width:200px;\" ></td></tr>\n".
     "<tr><td>Bemerkung</td><td><input type=\"text\" name=\"bemerkung\" style=\"width:200px;\" ></td></tr>\n</table>".
           "<td>Aktion<br>".
               "<select  name=\"action\" size=4>".
               "<option value=\"new\"        >Neu</option>".
               "<option value=\"change\"     >Ändern</option>".
               "<option value=\"activate\"   >Aktivieren</option>".
               "<option value=\"deactivate\" >Deaktivieren</option>".
               "</select>".
           "</td><td>Senden<br><input type=\"submit\" value=\"Go!\"></td>".
           "</tr>\n</table>";
echo "</form>\n\n";
  
mysqli_close($con);

print_end();;
?> 


