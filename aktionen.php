<?php
$v=0;
if ($v==1) { var_dump($_GET); }

include 'basics.php';

// start html page
print_start("Gebiet - Aktionen",1);

// connect DB 
$con= connect_db();


if ( isset($_GET['ch_action']) ) {

  // echo "Eintragung ";
  // zuerst checken wir ob der letzte Eintrag ein In-Datum hat
  
  $sqlString= "SELECT * FROM `aktionen` WHERE `gebiet`=".$_GET['ch_gebiet']." AND `aktiv`=1 ORDER BY `out` DESC LIMIT 0, 1";
  
  if ($v==1) { echo $sqlString."\n\n<br><br>"; }
  
  $result= mysqli_query($con, $sqlString);

  $row= mysqli_fetch_array($result);

  // wenn es ein out-Eintrag ist erzeugen wir einen neuen Datensatz
  if ( $_GET['ch_action'] == "out"  AND $_GET['ch_name'] != "n/a" AND $_GET['ch_date'] != ""  ) {

    if ($v==1) { echo "out ";}
    if ($v==1) { echo "\n\n<br><br>";}
    if ($v==1) { var_dump($row); }
    if ($v==1) { echo "<br><br>in: ".$row['in']."<br><br>"; }

    if ( $row['in'] != "0000-00-00" ) {
      
	  if ($v==1) { echo "in not 0000-00-00<br><br>"; }

	  if ( !isset($_GET['ch_elektronisch']) or $_GET['ch_elektronisch'] == "" ) {
		$_GET['ch_elektronisch']=0;
	  }
	  if ( !isset($_GET['ch_brieflich']) or $_GET['ch_brieflich'] == "" ) {
		$_GET['ch_brieflich']=0;
	  }
	  if ( isset($_GET['ch_gruppe']) or $_GET['ch_gruppe'] == "" ) {
		$_GET['ch_gruppe']=0;
	  }
      
      $sqlString= "INSERT INTO `aktionen` ( `index`, `time`, `gebiet`, `out`, `in`, `name`, `bemerkung`, `aktiv`, `elektronisch`, `brieflich`, `gruppe`) 
                   VALUES ( NULL, CURRENT_TIMESTAMP, ".$_GET['ch_gebiet'].", '".$_GET['ch_date']."', '', '".$_GET['ch_name']."', '".$_GET['ch_bemerkung']."', '1', '".$_GET['ch_elektronisch']."', '".$_GET['ch_brieflich']."', '".$_GET['ch_gruppe']."')";
      
      mysqli_query($con,$sqlString);
      
	  if ($v==1) { echo $sqlString."\n\n<br><br>";}
      if ($v==1) { echo "erledigt!\n<br>";}
      
    }
    // Falls nicht, lehnen wir ab
    else {
      if ($v==1) { echo "nicht m&ouml;glich!\n<br>";}  
    }
  }

  // wenn es ein in-Eintrag ist aktualisieren wir den passenden eintrag
  // TODO:  und daß das out-datum einen tag zurückliegt
  if ( $_GET['ch_action'] == "in" ) {

    if ($v==1) { echo "in ";
    			echo "\n\n<br><br>";
    			var_dump($row);
    			echo "\n\n<br><br>";
               }

    if ( $row['in'] == "0000-00-00" ) {

      $sqlString= "UPDATE `aktionen` SET `in`='".$_GET['ch_date']."', `bemerkung`='".$row['bemerkung']." - ".$_GET['ch_bemerkung']."' WHERE `index`=".$row['index']." ";
      
      mysqli_query($con,$sqlString);
      
	   if ($v==1) { echo $sqlString."\n\n<br><br>";}
       if ($v==1) { echo "erledigt!\n<br>";}
      
    }
    // Falls nicht, lehnen wir ab
    else {
      if ($v==1) { echo "nicht m&ouml;glich!\n<br>";}
    }
  }
}

// Formular 1 holt Gebiet

echo "<table width=90%>\n";
echo "  <tr><td bgcolor=#888888>\n<form action=\"aktionen.php\" method=\"get\">\n";
echo "  <table width=100%>";
echo "  <tr><td align=center valign=top>\n";
echo "      <input type=\"hidden\" name=\"action\" value=\"choose\"><br>";
echo "      <input type=\"text\" style=\" width:360px; height:100px; font-size: 60px;\" name=\"gebiet\" size=\"5\" maxlength=\"5\" value=\"";
if ( isset($_GET['gebiet'])) {
	echo $_GET['gebiet'];
}
echo "\">\n";
echo "  </td></tr>";
echo "  <tr><td  align=center >";
echo "    <input type=\"button\" style=\" width:120px; height:100px; font-size: 50px;\" value=1 onclick=\"this.form.gebiet.value=this.form.gebiet.value.substring(this.form.gebiet.value.length-4)+'1'\">".
         "<input type=\"button\" style=\" width:120px; height:100px; font-size: 50px;\" value=2 onclick=\"this.form.gebiet.value=this.form.gebiet.value.substring(this.form.gebiet.value.length-4)+'2'\">".
         "<input type=\"button\" style=\" width:120px; height:100px; font-size: 50px;\" value=3 onclick=\"this.form.gebiet.value=this.form.gebiet.value.substring(this.form.gebiet.value.length-4)+'3'\"><br>\n";
echo "    <input type=\"button\" style=\" width:120px; height:100px; font-size: 50px;\" value=4 onclick=\"this.form.gebiet.value=this.form.gebiet.value.substring(this.form.gebiet.value.length-4)+'4'\">".
         "<input type=\"button\" style=\" width:120px; height:100px; font-size: 50px;\" value=5 onclick=\"this.form.gebiet.value=this.form.gebiet.value.substring(this.form.gebiet.value.length-4)+'5'\">".
         "<input type=\"button\" style=\" width:120px; height:100px; font-size: 50px;\" value=6 onclick=\"this.form.gebiet.value=this.form.gebiet.value.substring(this.form.gebiet.value.length-4)+'6'\"><br>\n";
echo "    <input type=\"button\" style=\" width:120px; height:100px; font-size: 50px;\" value=7 onclick=\"this.form.gebiet.value=this.form.gebiet.value.substring(this.form.gebiet.value.length-4)+'7'\">".
         "<input type=\"button\" style=\" width:120px; height:100px; font-size: 50px;\" value=8 onclick=\"this.form.gebiet.value=this.form.gebiet.value.substring(this.form.gebiet.value.length-4)+'8'\">".
         "<input type=\"button\" style=\" width:120px; height:100px; font-size: 50px;\" value=9 onclick=\"this.form.gebiet.value=this.form.gebiet.value.substring(this.form.gebiet.value.length-4)+'9'\"><br>\n";
echo "    <input type=\"button\" style=\" width:120px; height:100px; font-size: 50px;\" value=\"x\" onclick=\"this.form.gebiet.value=''\">".
         "<input type=\"button\" style=\" width:120px; height:100px; font-size: 50px;\" value=0 onclick=\"this.form.gebiet.value=this.form.gebiet.value.substring(this.form.gebiet.value.length-4)+'0'\">".
         "<input type=\"submit\" style=\" width:120px; height:100px; font-size: 50px;\" value=\" Go! \">\n";
echo "  </td></tr>\n</table>\n";

echo "</td></tr>\n";

if ( isset($_GET['gebiet'])) {
	$sqlString= "SELECT   `gebiet` 
				 FROM     `gebiet`
				 WHERE    `gebiet`='".$_GET['gebiet']."'";

	if ($v==1) { echo $sqlString."\n\n<br><br>";}

	$result= mysqli_query($con,$sqlString);
	 if ($v==1) { print_r($result); }

	$row=mysqli_fetch_array($result);
	 if ($v==1) { print_r($row);	}
}
// zeigen den rest, wenn die gebietnummer gesetzt ist
if ( isset($_GET['gebiet']) AND $_GET['gebiet']==$row['gebiet'] ) {

  $sqlString= "SELECT   * 
               FROM     `aktionen`  
               WHERE    `gebiet`=".$_GET['gebiet']." 
               ORDER BY `out`,`in` ASC ";
               // LIMIT    0, 10";

  if ($v==1) { echo $sqlString."\n\n<br><br>";}

  $result= mysqli_query($con,$sqlString);

  $rowIn=" ";
  if ( $result ) {
		// zeige Liste  
		echo "  <tr><td bgcolor=#BBBBBB>\n";
		echo "  <b>Gebietsdaten</b>\n";
		echo "<table width=100% border=0>\n  <tr><td>Ausg.</td><td>Retour</td><td>Name</td><td>Elektr.</td><td>Brief</td><td>Gruppe</td></tr>\n";

		$rows=0;
		
		while ($row = mysqli_fetch_array($result)) {

			$rowIn=$row['in'];
			$rowOut=$row['out'];
			// echo "  <tr><td bgcolor=".$color.">" . $row['out'] . 
			//       "</td><td bgcolor=".$color.">" . $row['in'] . 
			//       "</td><td bgcolor=".$color.">";

			echo "<tr><td>" . $row['out'] . 
				"</td><td>" . $row['in'] . 
				"</td><td>";

			$sql= "SELECT * FROM `bibellehrer` WHERE `index`=".$row['name'].";"; 
			$res= mysqli_fetch_array( mysqli_query( $con, $sql ) );
    
			echo  $res['nachname']." ".$res['vorname']."</td><td>".$row['elektronisch']."</td><td>".$row['brieflich']."</td><td>".$row['gruppe']."</td></tr>\n";

		}
		echo "</table>\n";  
		echo "</td></tr>";
  }

  // wenn das Gebiet ausgegeben ist...
  if ( $rowIn == "0000-00-00" ) {
       // > 6 monate --> Rot
       if ( (  strtotime(date("Y-m-d")) - strtotime($rowOut) ) > 15552000 ) {
         echo "<tr><td bgcolor=#FFBBBB align=center>R&uuml;ckgabe!!!!</td></tr>";
       } 
       // > 4 monate --> Gelb
       elseif ( ( strtotime(date("Y-m-d")) - strtotime($rowOut) ) > 10368000 ) {
         echo "<tr><td bgcolor=#FFFFBB align=center>R&uuml;ckgabe!</td></tr>";
       }  
    }
    // wenn das Gebiet retourniert ist
    else {
       
       // > 5 monate --> Rot
       if ( ( strtotime(date("Y-m-d")) - strtotime($rowIn) ) > 12960000 ) {
         echo "<tr><td bgcolor=#FFBBBB align=center>Ausgeben!!!</td></tr>";
       }    
       // > 3 monate --> Gelb
       elseif ( ( strtotime(date("Y-m-d")) - strtotime($rowIn) ) > 7776000 ) {
         echo "<tr><td bgcolor=#BBFFBB align=center>Ausgeben!</td></tr>";
       }
  }

  // Was tun wir?
  echo "</td></tr><tr><td bgcolor=#AAAAAA>\n";
  echo "<form action=\"aktionen.php\" method=\"get\">\n";
  echo "<table width=100%><tr><td>\n";
  echo "  <table><tr><td>Datum</td><td><input type=\"date\" name=\"ch_date\" size=\"16\">".
    // "<input type=\"button\" value=\"Heute\" 
    //        onclick=\"var d=new Date();this.form.ch_date.value=d.getFullYear() + '-' + 
    //        d.getMonth() + '-' + d.getDate()\">".
       "</td></tr>\n";



  if ( $rowIn  == "0000-00-00" ) { 
    echo "  <tr><td>Anmerkung</td><td><input type=\"text\" name=\"ch_bemerkung\" size=\"16\"></td></tr>\n";
	echo "\n</table>";
    echo "  </td><td>";
    // echo "<select name=\"ch_action\"><option value=\"in\">Ret.</option></select>";
    echo "<input type=\"hidden\" name=\"ch_action\" value=\"in\">";
  }
  else { 
    // echo "  <tr><td>Name</td><td><input type=\"text\" name=\"ch_name\" size=\"16\">";
 
    echo "<tr><td>Name</td><td><select name=\"ch_name\" >\n<option>n/a</option>";

    $sqlString= "SELECT * FROM `bibellehrer` WHERE `aktiv`='1' ORDER BY `nachname` ASC";
    
    if ($v==1) { echo $sqlString."\n\n<br><br>";}
    
    $result = mysqli_query($con,$sqlString);  

    while( $row= mysqli_fetch_array($result) ) {
      
      echo "  <option value=\"".$row['index']."\">".$row['nachname']." ".$row['vorname']."</option>\n";
    }
    echo "</select></td></tr>\n";

    echo "  <tr><td>Anm.</td><td><input type=\"text\" name=\"ch_bemerkung\" size=\"16\"></td></tr>\n";
	echo "  <tr><td>Elektronisch<br><br><br></td><td><br><span style=\"top-margin:25px; margin:25px;\"><input type=\"checkbox\" name=\"ch_elektronisch\" value=\"1\" style=\"transform: scale(4);\"></span></td></tr>\n";
	echo "  <tr><td>Brieflich<br><br><br></td><td><br><span style=\"top-margin:25px; margin:25px;\"><input type=\"checkbox\" name=\"ch_brieflich\" value=\"1\" style=\"transform: scale(4);\"></span></td></tr>\n";
	echo "  <tr><td>Guppen-Gebiet<br><br><br></td><td><br><span style=\"top-margin:25px; margin:25px;\"><input type=\"checkbox\" name=\"ch_gruppe\" value=\"1\" style=\"transform: scale(4);\"></span></td></tr>\n";
	echo " </table>\n";
	
	
    echo "</td><td>";
    // echo "<select name=\"ch_action\"><option value=\"out\">Ausg.</option></select>";
    echo "<input type=\"hidden\" name=\"ch_action\" value=\"out\">";
    
  }

  echo "  <br><input type=\"hidden\" name=\"ch_gebiet\" value=\"".$_GET['gebiet']."\"><input style=\"width:90px; height:90px\" type=\"submit\" value=\"GO!\"></td>\n";
  echo "</tr></table>\n";
  echo "<form>";  

  echo "</td></tr>\n";

}

echo "</table>\n";
$geb_img= "";
if ( isset($_GET['gebiet']) ) { 
	$geb_img= sprintf( "%03s", $_GET['gebiet']);
}
echo "<img src=\"img/".$geb_img.".jpg\" width=1024px />";
echo "<img src=\"img/Info-".$geb_img.".jpg\" width=1024px />";



// close DB
close_db($con);

// end HTML
print_end();
 
?>
