<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
include ("dolaczenia/kod_html.php");

?>
<html lang="pl">
    <head>
        <title>Rezerwacja</title>
        <link rel="stylesheet" href="css/glowny.css"/>
        <link rel="stylesheet" href="css/formy.css"/>
        <link rel="stylesheet" href="css/rezerwuj.css"/>
    </head>
    <body>
        <?php echo '<center>'; Wiadomosc(); echo '</center>'; ?>
        <div id="wrapper">
        <?php 
        Naglowek();
        echo '<center>';
        echo '<div id="uklad_sali">';
        Dane_seansu();
        Siedzenia();
        echo '</div>';
        echo '</center>';
        ?>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>