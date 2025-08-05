<?php
$v=1;

include 'basics.php';

// start html page
print_start("Gebiete",2);
?>

<h1 class="button" style="background-color: #DDDDFF;">Gebietsverwaltung</h1>

<a href="aktionen.php"                 ><p class="button" >Aktionen setzen</p></a>
<a href="einzusammeln.php?show=25" target=_new ><p class="button" >Gebiete zum Einsammeln</p></a>
<a href="auszugeben.php"   target=_new ><p class="button" >Gebiete zum Ausgeben</p></a>
<a href="admin.php"        target=_new ><p class="button" >Administratives</p></a>

<?php

// end HTML
print_end();
 
?>
