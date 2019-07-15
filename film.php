<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
include ("dolaczenia/kod_html.php");
OcenionoFilm();
?>
<html lang="pl">
    <head>
        <title><?php Tytul(); ?></title>
        <link rel="stylesheet" href="css/glowny.css"/>
        <link rel="stylesheet" href="css/film.css"/>
        <link rel="stylesheet" href="css/formy.css"/>
    </head>
    <body>
        <?php echo '<center>'; Wiadomosc(); echo '</center>'; ?>
        <div id="wrapper">
        <?php
        Naglowek();
        ?> 
        <?php 
        SzczegolyFilmu();
        OcenyFilmu();
        Rezerwacje();     
        ?>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>