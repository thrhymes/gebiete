<?php
  
function print_start($title,$back) {

  echo "<!DOCTYPE html>\n".
       "<html lang=\"de\">\n".
       "<head>\n".
       // "  <meta charset=\"utf-8\">".
       "  <meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\">".
       "  <title>$title</title>".
       "  <link rel=\"stylesheet\" type=\"text/css\" href=\"formate.css\">".
       "</head>\n".
       "<body><div class=\"frame\">\n";
       
       if ( $back==1 ) {
          echo "<a href=\"index.php\"><p class=\"button\">Zur&uuml;ck</p></a>\n";
       }
}

function print_end() {

  echo "</div></body>\n</html>";

}

function connect_db() {

  // Create connection
  $con=mysqli_connect("e11635-mysql.services.easyname.eu","u1636db1","VersammlungWien23","u1636db1");

  // Check connection
  if (mysqli_connect_errno($con))  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }  

  return $con;  

}

function close_db($con) {

  mysqli_close($con);

}

?> 


