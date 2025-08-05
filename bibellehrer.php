<?php
include 'basics.php';

// start HTML
print_start("Gebiet - Bibellehrer",1);
 
// connect DB
$con= connect_db();

// insert new data or change data as needed
if ( $_GET['action']<>"" ) {
    
  if ( $_GET['action']=="new" ) {
    
    $sqlString = "INSERT INTO `bibellehrer` ( `index`, `nachname`, `vorname`, `kontakt`, `aktiv` ) VALUES ".
                 "( NULL, '".$_GET['nachname']."', '".$_GET['vorname']."', '".$_GET['kontakt']."', 1 )";
                            
    mysqli_query($con,$sqlString);
    
  }
  elseif ( $_GET['action']=="change" ) { 
    
    $sqlString = "";
    if ($_GET['nachname']<>"") {$sqlString= "UPDATE `bibellehrer` SET `nachname`='".$_GET['nachname']."' WHERE `index`=".$_GET['index'].";";mysqli_query($con,$sqlString);};
    if ($_GET['vorname']<>"" ) {$sqlString= "UPDATE `bibellehrer` SET `vorname`='". $_GET['vorname']. "' WHERE `index`=".$_GET['index'].";";mysqli_query($con,$sqlString);};
    if ($_GET['kontakt']<>"" ) {$sqlString= "UPDATE `bibellehrer` SET `kontakt`='". $_GET['kontakt']. "' WHERE `index`=".$_GET['index'].";";mysqli_query($con,$sqlString);};                        
    
    
    
  }
  elseif ( $_GET['action']=="activate" ) { 
    
    $sqlString = "UPDATE `bibellehrer` SET `aktiv`='1' WHERE `index`='".$_GET['index']."';";
    
    mysqli_query($con,$sqlString);
    
  }
  elseif ( $_GET['action']=="deactivate" ) { 
    
    $sqlString = "UPDATE `bibellehrer` SET `aktiv`='0' WHERE `index`='".$_GET['index']."';";
    
    mysqli_query($con,$sqlString);
    
  }
  else {
    
    echo "<br>keine aktion gewählt<br><br>";
    
  }
}
  
// read table and show it
$result = mysqli_query($con,"SELECT * FROM bibellehrer ORDER BY nachname ASC");

// echo "<table><tr>\n<td valign=\"top\">\n";
echo "<div class=\"scroller\">";
echo "<table width=100%>\n  <tr><th>Index</th><th>Nachname</th><th>Vorname</th><th>Kontakt</th><th>Aktiv</th></tr>\n";

$rows=0;
while ($row = mysqli_fetch_array($result)) {

/*
    if ( $rows > 29 ) {
        echo "  </table>\n</td><td>\n  <table border=0>\n".
             "  <tr><td>Index</td><td>Nachname</td><td>Vorname</td><td>Kontakt</td><td>Aktiv</td></tr>\n";
        $rows=0;
    }
*/
  
    $color= "#ffffff";
    if ( isset($_GET['index']) and $_GET['index']==$row['index'] ) { 
      
      $color= "#88FF88";
    }
    
    echo "  <tr><td bgcolor=".$color."> " . $row['index'] . 
          "</td><td bgcolor=".$color." class=\"border\">" . $row['nachname'] . 
          "</td><td bgcolor=".$color." class=\"border\">" . $row['vorname'] . 
          "</td><td bgcolor=".$color." class=\"border\">" . $row['kontakt'] . 
          "</td><td bgcolor=".$color." class=\"border\">" . $row['aktiv'] . 
          "</td></tr>\n";
  
    if (  isset($row['Gebiet'] )) { 
		$lastGebiet=$row['Gebiet'];
	}
    $rows++;

}

echo "  </table>\n";
echo "</div>\n";
//echo "</td></tr></table>\n\n";

  
// Formular
echo "<form action=\"bibellehrer.php\" method=\"get\">\n";
echo "<table>\n<tr><td>\n".
     "<table>\n<tr>\n".
     "<td>ID      </td><td><input style=\"width:200px;\" type=\"text\" name=\"index\"></td></tr>".
     "<td>Nachname</td><td><input style=\"width:200px;\" type=\"text\" name=\"nachname\"></td></tr>".
     "<td>Vorname </td><td><input style=\"width:200px;\" type=\"text\" name=\"vorname\"></td></tr>".
     "<td>Kontakt </td><td><input style=\"width:200px;\" type=\"text\" name=\"kontakt\"></td></tr>".
     "</table><td>Aktion<br>".
           "<select name=\"action\" size=4>".
               "<option value=\"new\"        >Neu</option>".
               "<option value=\"activate\"   >Aktivieren</option>".
               "<option value=\"deactivate\" >Deaktivieren</option></select>".
     "</td><td>Senden<br><input type=\"submit\" value=\"Go!\"></td></tr>\n</table>";
echo "</form>\n\n";
  
mysqli_close($con);

print_end();;
?> 


