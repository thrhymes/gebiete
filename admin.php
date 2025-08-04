<?php
$v=1;

include 'basics.php';

// start html page
print_start("Gebiete",1);
?>

<h1 class="button" style="background-color: #FFDDDD;">Bitte mit Vorsicht!!!</h1>

<a href="niewieder.php"                  ><p class="button" >nicht Besuchen</p></a>
<a href="bibellehrer.php"                ><p class="button" >Verk&uuml;ndiger verwalten</p></a>
<a href="gebiete.php"                    ><p class="button" >Gebiete verwalten</p></a>
<a href="kacheck.php" target=_new        ><p class="button" >Kreisaufseher Check</p></a>
<a href="graph.php" target=_new          ><p class="button" >Grafischer Check</p></a>
<a href="bearbeiterstat.php" target=_new ><p class="button" >Gebiete je Verk&uuml;ndiger</p></a>
<a href="manipulate.php"                 ><p class="button" >Aktionen Manipulieren</p></a>

<?php

// end HTML
print_end();
 
?>
