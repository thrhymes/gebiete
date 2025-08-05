<?php
$v=1;

include 'basics.php';

// start html page
print_start("Gebiet - Aktionen",1);

// connect DB 
$con= connect_db();

if ( isset($_GET['ch_action']) ) {
}
else {
	$_GET['ch_action']= "none";
}

// wenn wir eine änderung ausführen wollen
if ( $_GET['ch_action']=="change" ) {
  // echo "Eintragung ";

  // $sqlString= " SELECT * FROM `aktionen` WHERE `index`='".$_GET['ch_index']."'";
  // $result= mysqli_query($con,$sqlString);

  if ( $_GET['ch_date_out']<>"" ) {
      $sqlString= "UPDATE `aktionen` SET `out`='".$_GET['ch_date_out']."' WHERE `index`=".$_GET['ch_index']." ";
      mysqli_query($con,$sqlString);
  }

  if ( $_GET['ch_date_in']<>"" ) {
      $sqlString= "UPDATE `aktionen` SET `in`='".$_GET['ch_date_in']."' WHERE `index`=".$_GET['ch_index']." ";
      mysqli_query($con,$sqlString);
  }

  if ( $_GET['ch_name']<>"n/a" ) {
      $sqlString= "UPDATE `aktionen` SET `name`='".$_GET['ch_name']."' WHERE `index`=".$_GET['ch_index']." ";
      mysqli_query($con,$sqlString);
  }

  if ( $_GET['ch_elektronisch']<>"" ) {
      $sqlString= "UPDATE `aktionen` SET `elektronisch`='".$_GET['ch_elektronisch']."' WHERE `index`=".$_GET['ch_index']." ";
      mysqli_query($con,$sqlString);
  }
  
   if ( $_GET['ch_brieflich']<>"" ) {
      $sqlString= "UPDATE `aktionen` SET `brieflich`='".$_GET['ch_brieflich']."' WHERE `index`=".$_GET['ch_index']." ";
      mysqli_query($con,$sqlString);
  }

  if ( $_GET['ch_gruppe']<>"" ) {
      $sqlString= "UPDATE `aktionen` SET `gruppe`='".$_GET['ch_gruppe']."' WHERE `index`=".$_GET['ch_index']." ";
      mysqli_query($con,$sqlString);
  }
}

// Formular 1 holt Gebiet

echo "<table width=100%>\n";
echo "  <tr><td bgcolor=#888888>\n<form action=\"manipulate.php\" method=\"get\">\n";
echo "  <table width=100%>";
echo "  <tr><td align=center valign=top>\n";
echo "    <input type=\"hidden\" name=\"action\" value=\"choose\"><br>";
echo "    <input type=\"text\" style=\" width:360px; height:100px; font-size: 60px;\" name=\"gebiet\" size=\"3\" maxlength=\"5\" value=\"";
if ( isset($_GET['gebiet']) ) {
	echo $_GET['gebiet'];
}
echo "\">\n";
echo "	</td></tr>";
echo "  <tr><td align=center >";
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

if ( isset($_GET['gebiet']) ) {
	
} 
else { 
	$_GET['gebiet']=0; 
}

$sqlString= "SELECT   `gebiet` 
             FROM     `gebiet`
             WHERE    `gebiet`='".$_GET['gebiet']."'";

$result= mysqli_query($con,$sqlString);
// print_r($result);

$row=mysqli_fetch_array($result);
// print_r($row);

// zeigen den rest, wenn die gebietnummer gesetzt ist
if ( $_GET['gebiet'] > 0 AND $_GET['gebiet']==$row['gebiet'] ) {

  // zeige Liste  
  echo "  <tr><td bgcolor=#BBBBBB>\n";
  echo "  <b>Gebietsdaten</b>\n";

  $sqlString= "SELECT   * 
               FROM     `aktionen`  
               WHERE    `gebiet`=".$_GET['gebiet']." 
               ORDER BY `out`,`in` ASC 
               LIMIT    0, 10";

  $result= mysqli_query($con,$sqlString);

  echo "<form action=\"manipulate.php\" method=\"get\">\n";
  echo "<table width=100% border=0>\n  <tr><td>index</td><td>Ausg.</td><td>Retour</td><td>Name</td><td>Elektr.</td><td>Brief</td><td>Gruppe</td></tr>\n";

  $rows=0;

  while ($row = mysqli_fetch_array($result)) {

    $rowIn=$row['in'];
    $rowOut=$row['out'];
    echo "  <tr><td><input type=\"radio\" name=\"ch_index\" value=\"" . $row['index'] . "\">".
          "</td><td>" . $row['out'] . 
          "</td><td>" . $row['in'] . 
          "</td><td>";

    $sql= "SELECT * FROM `bibellehrer` WHERE `index`=".$row['name'].";"; 
    $res= mysqli_fetch_array( mysqli_query( $con, $sql ) );
    
    echo  $res['nachname']." ".$res['vorname']."</td>";
	echo "<td>".$row['elektronisch']."</td>";
	echo "<td>".$row['brieflich']."</td>";
	echo "<td>".$row['gruppe']."</td>";
	echo "</tr>\n";
	

  }
  echo "</table>\n";  
  echo "</td></tr>";

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


  echo "<table width=100%><tr><td>\n";
  echo "  <table><tr><td>Ausg.</td><td><input type=\"date\" name=\"ch_date_out\" size=\"16\"></td></tr>\n";
  echo "         <tr><td>R&uuml;ck.</td><td><input type=\"date\" name=\"ch_date_in\" size=\"16\"></td></tr>\n";

    echo "<tr><td>Name</td><td><select name=\"ch_name\" >\n<option>n/a</option>";

    $sqlString= "SELECT * FROM `bibellehrer` WHERE `aktiv`='1' ORDER BY `nachname` ASC";
    $result = mysqli_query($con,$sqlString);  

    while( $row= mysqli_fetch_array($result) ) {      
      echo "  <option value=\"".$row['index']."\">".$row['nachname']." ".$row['vorname']."</option>\n";
    }
    echo "</select></td></tr>\n";

    echo "  <tr><td>Anm.</td><td><input type=\"text\" name=\"ch_bemerkung\" size=\"16\"></td></tr>\n";
	echo "  <tr><td>Elektronisch</td><td><input type=\"text\" name=\"ch_elektronisch\" size=\"3\"></td>";
	echo "  <tr><td>Brief</td><td><input type=\"text\" name=\"ch_brieflich\" size=\"3\"></td>";
	echo "  <tr><td>Gruppe</td><td><input type=\"text\" name=\"ch_gruppe\" size=\"3\"></td>";
	echo "  </tr>\n";
    echo "</td><td></table></td><td>\n";


  echo "  <br><input type=\"hidden\" name=\"ch_gebiet\" value=\"".$_GET['gebiet']."\"><input type=\"hidden\" name=\"ch_action\" value=\"nothing\">".
       "      <input type=\"button\" style=\" width:90px; height:90px\" value='Do!' onclick=\"this.form.ch_action.value='change'\">".
       "      <input style=\"width:90px; height:90px\" type=\"submit\" value=\"GO!\"></td></tr>";
  echo "</form>";  


}

echo "</table>\n";

// close DB
close_db($con);

// end HTML
print_end();
 
?>
