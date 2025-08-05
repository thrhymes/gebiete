<?php
include 'basics.php';

// start HTML
print_start("Gebiet - Gebiete",1);
 
// connect DB
$con= connect_db();

// insert new data or change data as needed
if ( isset($_GET['ch_action']) ) {
	if ( $_GET['gebietsnr']>0 AND ( $_GET['wohnungen']<>"" OR $_GET['bemerkung']<>"" OR $_GET['aktiv']<>"") ) {
    
		if ( $_GET['action']=="new" ) {
    
			$sqlString = "INSERT INTO gebiet (gebiet, wohnungen, bemerkung) VALUES".
					"(".$_GET['gebietsnr'].
					", ".$_GET['wohnungen'].
					",'".$_GET['bemerkung']."')";
                            
			mysqli_query($con,$sqlString);
    
		}
		elseif ( $_GET['action']=="change" ) { 
    
			if ( $_GET['wohnungen']<>"" ) {
				$sqlString= "UPDATE gebiet SET wohnungen=".$_GET['wohnungen']." WHERE `gebiet`='".$_GET['gebietsnr']."'";
				mysqli_query($con,$sqlString);
			}

			if ( $_GET['bemerkung']<>"" ) {
				$sqlString= "UPDATE gebiet SET bemerkung='".$_GET['bemerkung']."' WHERE `gebiet`='".$_GET['gebietsnr']."'";
				mysqli_query($con,$sqlString);
			}

			if ( $_GET['aktiv']<>"" ) {
				$sqlString= "UPDATE gebiet SET aktiv='".$_GET['aktiv']."' WHERE `gebiet`='".$_GET['gebietsnr']."'";
				mysqli_query($con,$sqlString);
			}
    
		}
		else {
    
			echo "<br>keine aktion gewählt<br><br>";
    
		}
	}
}
  
// read table and show it
$result = mysqli_query($con,"SELECT * FROM gebiet ORDER BY Gebiet ASC");

// echo "<table><tr>\n<td valign=\"top\">\n";
echo "<div class=\"scroller\">";
echo "<table width=100% class=\"border\">\n  <tr><td>Gebiet</td><td>Wohnungen</td><td>Bemerkung</td></tr>\n";

$rows=0;
while ($row = mysqli_fetch_array($result)) {

/*    if ( $rows > 29 ) {
        echo "  </table>\n</td><td valign=\"top\">\n  <table border=0>\n".
             "  <tr><td>Gebiet</td><td>Wohnungen</td><td>Bemerkung</td><td>Aktiv</td></tr>\n";
        $rows=0;
    }
*/
  
    $color= "#ffffff";
	if ( isset($_GET['ch_action']) ) {
		if ( $_GET['gebietsnr']==$row['gebiet'] ) { 
      
			$color= "#88FF88";
		}
	}
    
    echo "  <tr><td bgcolor=".$color.">" . $row['gebiet'] . 
          "</td><td bgcolor=".$color.">" . $row['wohnungen'] . 
          "</td><td bgcolor=".$color.">" . $row['bemerkung'] .
          "</td><td bgcolor=".$color.">" . $row['aktiv'] . 
          "</td><td><a href=\"gebietsinfo.php?gebiet=".$row['gebiet']."\" target=_new>Info</a></td></tr>\n";
  
	if ( isset($row['Gebiet']) ) {
		$lastGebiet=$row['Gebiet'];
	}
    $rows++;

}

echo "  </table>\n";
echo "</div>";
// echo "</td></tr></table>\n\n";

  
// Formular
echo "<form action=\"gebiete.php\" method=\"get\">\n";
echo "<table border=0>\n".
     "<tr><td><table border=0>\n".
     "<tr><td>Gebiet   </td><td><input style=\"width:200px;\" type=\"text\" name=\"gebietsnr\"></td></tr>\n".
     "<tr><td>Wohnungen</td><td><input style=\"width:200px;\" type=\"text\" name=\"wohnungen\"></td></tr>\n".
     "<tr><td>Bemerkung</td><td><input style=\"width:200px;\" type=\"text\" name=\"bemerkung\"></td></tr>\n".
     "<tr><td>Aktiv</td><td><input style=\"width:200px;\" type=\"text\" name=\"aktiv\"></td></tr>\n</table>\n".
     "</td><td>Aktion<br>".
     "   <select name=\"action\" size=3>".
     "         <option value=\"new\"   >Neu</option>".
     "         <option value=\"change\">&Auml;ndern</option></select>".
     "</td><td>Senden<br><input type=\"submit\" value=\"Go!\"></td></tr>\n</table>";
echo "</form>\n\n";
  
mysqli_close($con);

print_end();;
?> 


